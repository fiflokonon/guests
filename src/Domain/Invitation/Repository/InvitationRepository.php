<?php

namespace App\Domain\Invitation\Repository;

use \App\Domain\Core\Repository\Repository;
use PDO;
use Slim\Exception\HttpException;

final class InvitationRepository extends Repository
{
    public function __construct(PDO $connection)
    {
        parent::__construct($connection);
    }

    /**
     * @return array|false
     */
    public function invitations(): bool|array
    {
        return $this->getAll('invitations');
    }

    /**
     * @param int $id
     * @return array|mixed
     */
    public function invitation(int $id)
    {
        return $this->getOne('invitations', $id);
    }

    public function createInvitation(int $id, array $invitation, $lien)
    {
        $nomPrenoms = htmlspecialchars($invitation['nom_prenoms']);
        $nombre = htmlspecialchars($invitation['nombre']);
        $id_evenement = $id;
        $lien_code = htmlspecialchars($lien);
        $sql = "INSERT INTO invitations(nomPrenoms, nombre, id_evenement, lien_code) VALUES (:nomPrenoms, :nombre, :id_evenement, :lien_code)";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue('nomPrenoms', $nomPrenoms);
        $stmt->bindValue('nombre', $nombre);
        $stmt->bindValue('id_evenement', $id_evenement);
        $stmt->bindValue('lien_code', $lien_code);
        $green = $this->checkNom($nomPrenoms);
        if ($green)
        {
            try
            {
                if($stmt->execute())
                {
                    return $this->connection->lastInsertId();
                }
                else
                {
                    return ['message' => "An error occurs"];
                }
            }
            catch (HttpException $exception)
            {
                $errorMessage = sprintf('%s %s', $statusCode, $response->getReasonPhrase());
                return ["message" => $errorMessage];
            }
        }
        else
        {
            return ['message' => "That invitation had already existed", "Astuce" => "Change nom et prenoms Please"];
        }
    }

    /**
     * @param int $id
     * @return false|mixed|string
     */
    public function supprimerInvitation(int $id)
    {
        return $this->deleteOne('invitations', $id);
    }

    /**
     * @param string $nom
     * @return bool
     */
    public function checkNom(string $nom)
    {
        $sql = "SELECT * from invitations WHERE nomPrenoms = '$nom'";
        $result = $this->connection->query($sql)->fetchAll();
        if ($result)
            return false;
        else
            return true;
    }
}