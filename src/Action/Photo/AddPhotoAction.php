<?php

namespace App\Action\Photo;

use App\Domain\Photo\Service\AddPhotoService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UploadedFileInterface;

final class AddPhotoAction
{
    /**
     * @var AddPhotoService
     */
    private AddPhotoService $service;

    /**
     * @param AddPhotoService $service
     */
    public function __construct(AddPhotoService $service)
    {
        $this->service = $service;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface
    {
        $directory = __DIR__ . '/../../../public/uploads';
        $files = [];
        // TODO: Implement __invoke() method.
        //Get File
        $uploadFiles = $request->getUploadedFiles();
        if (!empty($uploadFiles))
        {
            $uploadFile = $uploadFiles['file'];
            if ($uploadFile->getError() === UPLOAD_ERR_OK)
            {
                try {
                    $filename = $this->moveUploadedFile($directory, $uploadFile);
                } catch (\Exception $e) {
                    $response->getBody()->write(json_encode(["message" => $e->getMessage()]));
                    return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
                }
                $files = [
                    'filename' => "".$filename,
                    'original' => "".$uploadFile->getClientFileName(),
                    'type' => pathinfo($uploadFile->getClientFilename(), PATHINFO_EXTENSION)
                ];
                $this->service->createPhoto($args['id'], $files['filename']);
            }
        }
        $response->getBody()->write(json_encode($files));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);

    }

    /**
     * @param string $directory
     * @param UploadedFileInterface $uploadedFile
     * @return string
     * @throws \Exception
     */
    public function moveUploadedFile(string $directory, UploadedFileInterface $uploadedFile): string
    {
        $extension = pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION);
        $basename = bin2hex(random_bytes(8));
        $filename = sprintf('%s.%0.8s', $basename, $extension);
        $uploadedFile->moveTo($directory . DIRECTORY_SEPARATOR . $filename);
        return $filename;
    }

}