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
        $qr = QrCode::create($data);
        $qr->setForegroundColor(new Color(25, 23, 61))
            ->setBackgroundColor(new Color(255, 255, 255));
        $writer = new PngWriter();
        $file = $writer->write($qr);
        $file->saveToFile(__DIR__.'/../../../../public/invitations/code-'.$id.'.png');
        return ["message" => true];
    }

    public function createInvitation(int $id, array $invitation)
    {
        $invit = $this->repository->createInvitation($id, $invitation);
        if (isset($invit['id']) && !empty($invit['id']))
        {
            $e_data = $this->repository->aesEncrypt($invit['id']);
            if (isset($e_data) && !empty($e_data))
            {
                try {
                    $this->generateCode($e_data, $invit['id']);
                }
                catch (\Exception $exception)
                {
                    return ['success' => false, 'message' => $exception->getMessage()];
                }
            }
        }
    }
}