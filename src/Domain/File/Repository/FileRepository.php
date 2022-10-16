<?php

namespace App\Domain\File\Repository;
use App\Domain\Core\Repository\Repository;
use http\Exception;
use PDO;

final class FileRepository extends Repository
{
    public function __construct(PDO $connection)
    {
        parent::__construct($connection);
    }

    /**
     * @return array|false
     */
    public function files()
    {
        return $this->getAll('fichiers');
    }

    /**
     * @param int $id
     * @return array|mixed
     */
    public function file(int $id)
    {
        return $this->getOne('fichiers', $id);
    }

    /**
     * @param int $id
     * @param string $lien
     * @return array|false|void
     */
    public function createFile(int $id, string $lien)
    {
        $id_evenement = $id;
        $lien_fichier = htmlspecialchars($lien);
        $sql = "INSERT INTO fichiers(id_evenement, lien_fichier) VALUES (:id_evenement, :lien_fichier)";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue('id_evenement', $id_evenement);
        $stmt->bindValue('lien_fichier', $lien_fichier);
        try {
            if ($stmt->execute())
            {
                return $this->eventFiles($id);
            }
        }
        catch (\Exception $exception)
        {
            return ["message" => $exception->getMessage()];
        }
    }

    public function eventFiles(int $id)
    {
        $sql = "SELECT * FROM fichiers WHERE id_evenement = $id";
        return $this->connection->query($sql)->fetchAll();
    }
    /**
     * @param int $id
     * @return false|mixed|string
     */
    public function supprimerFile(int $id)
    {
        return $this->deleteOne('fichiers', $id);
    }
}