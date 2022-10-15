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

    public function createInvitation(int $id, array $invitation)
    {
        $nom_prenoms = htmlspecialchars($invitation['nom_prenoms']);
        $place = htmlspecialchars($invitation['place']);
        $id_evenement = $id;
        $sql = "INSERT INTO invitations(nom_prenoms, place, id_evenement) VALUES (:nom_prenoms, :place, :id_evenement)";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue('nom_prenoms', $nom_prenoms);
        $stmt->bindValue('place', $place);
        $stmt->bindValue('id_evenement', $id_evenement);
        $green = $this->checkNom($nom_prenoms);
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

    public function insertLink(int $id, string $lien)
    {
        $sql = "UPDATE evenements SET lien_code = $lien WHERE id = $id";
        $stmt = $this->connection->prepare($sql);
        return $this->exeStatement($stmt, ['success' => true]);
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