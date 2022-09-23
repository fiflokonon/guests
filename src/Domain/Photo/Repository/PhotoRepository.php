<?php

namespace App\Domain\Photo\Repository;

use App\Domain\Core\Repository\Repository;
use PDO;

final class PhotoRepository extends Repository
{
    public function __construct(PDO $connection)
    {
        parent::__construct($connection);
    }

    public function getAllPhotos(): bool|array
    {
        return $this->getAll('photos');
    }

    /**
     * @param int $id
     * @return array|mixed
     */
    public function getPhoto(int $id)
    {
        return $this->getOne('photos', $id);
    }
    public function photo(int $id, string $lien): array
    {
        $lien = htmlspecialchars($lien);
        $id_utilisateur = htmlspecialchars($id);
        $sql = "INSERT INTO photos(id_utilisateur, lien_photo) VALUES (:id_utilisateur, :lien_photo)";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue('id_utilisateur', $id_utilisateur);
        $stmt->bindValue('lien_photo', './uploads/'.$lien.'/');
        try {
            if ($stmt->execute())
                $lastId = $this->connection->lastInsertId();
                $req = "UPDATE photos SET statut = false WHERE id != $lastId AND id_utilisateur = $id_utilisateur";
                if (!$this->connection->prepare($req)->execute())
                    return ["success" => false, "message" => "An error occurs insert-time"];
            else {
                return ["success" => true, "message" => "photo added successfully"];
            }
        }
        catch (\Exception $exception)
        {
            return ["message" => $exception->getMessage()];
        }
    }

    /**
     * @param int $id
     * @param $lien_photo
     * @return false|mixed|string
     */
    public function editPhoto(int $id, $lien_photo): mixed
    {
        $lien_photo = htmlspecialchars($lien_photo);
        $sql = "UPDATE photos SET lien_photo = '$lien_photo' WHERE id = $id";
        $stmt = $this->connection->prepare($sql);
        return $this->exeStatement($stmt, ["success" => true]);
    }
    /**
     * @param int $id
     * @return false|mixed|string
     */
    public function supprimerPhoto(int $id)
    {
        return $this->deleteOne('photos', $id);
    }

    /**
     * @param int $id
     * @return array|false
     */
    public function getForUser(int $id)
    {
        $sql = "SELECT * FROM photos WHERE id_utilisateur=$id";
        try
        {
            return $this->connection->query($sql)->fetchAll();
        }
        catch (\Exception $exception)
        {
            return ['message' => $exception->getMessage()];
        }
    }

    /**
     * @param int $id
     * @return array|false
     */
    public function getActive(int $id)
    {
        $sql = "SELECT * FROM photos WHERE statut = true AND id_utilisateur = $id LIMIT 1";
        try {
            return $this->connection->query($sql)->fetchAll();
        }
        catch (\Exception $exception)
        {
            return ["message" => $exception->getMessage()];
        }
    }
}