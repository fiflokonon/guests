<?php

namespace App\Domain\Invitation\Service;

use App\Domain\Invitation\Repository\InvitationRepository;
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

final class CreateInvitationService
{
    /**
     * @var InvitationRepository
     */
    private InvitationRepository $repository;

    /**
     * @param InvitationRepository $repository
     */
    public function __construct(InvitationRepository $repository)
    {
        $this->repository = $repository;
    }

    public function generateCode(string $data, int $id)
    {
        /**
         * Réf: https://code-boxx.com/generate-qr-code-php/
         */
        $qr = QrCode::create($data);
        $qr->setForegroundColor(new Color(255, 255, 255))
            ->setBackgroundColor(new Color(25, 23, 61));
        $writer = new PngWriter();
        $file = $writer->write($qr);
        try {
            $file->saveToFile(__DIR__.'/../../../../public/invitations/code-'.$id.'.png');
            $this->repository->insertLink($id, './invitations/code-'.$id.'.png');
            return $this->repository->invitation($id);
        }catch (\Exception $exception)
        {
            return ["message" => $exception->getMessage()];
        }
    }

    public function createInvitation(int $id, array $invitation)
    {
        $invit = $this->repository->createInvitation($id, $invitation);
        $code = $this->repository->aesEncrypt($invit);
        if (isset($code) && !empty($code))
        {
            return $this->generateCode($code, $invit);
        }
    }
}