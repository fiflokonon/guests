<?php

namespace App\Domain\Event\Repository;

use Http\Message\ResponseFactory;
use PDO;
use Psr\Http\Message\ResponseFactoryInterface;
use Slim\Exception\HttpException;

final class EventRepository
{
    /**
     * @var PDO
     */
    private PDO $connection;

    /**
     * @param PDO $connection
     */

    private ResponseFactoryInterface $factory;
    public function __construct(PDO $connection, ResponseFactoryInterface $factory)
    {
        $this->connection = $connection;
        $this->factory = $factory;
    }

    /**
     * @param int $id
     * @param array $event
     * @return false|mixed|string
     */
    public function creerEvenement(int $id, array $event)
    {
        $titre = htmlspecialchars($event['titre']);
        $slogan = htmlspecialchars($event['slogan']);
        $description = htmlspecialchars($event['description']);
        $lieu = htmlspecialchars($event['lieu']);
        $date_de_debut = htmlspecialchars($event['date_de_debut']);
        $date_de_fin = htmlspecialchars($event['date_de_fin']);
        $id_utilisateur = $id;
        if(strtotime($date_de_debut) >= (time()-(60*60*24)) && strtotime($date_de_fin) >= (time()-(60*60*24)))
        {
            if (strtotime($date_de_fin) >= strtotime($date_de_debut))
            {
                $sql = "INSERT INTO evenements(titre, slogan, description, lieu, date_de_debut, date_de_fin, id_utilisateur) VALUES (:titre, :slogan, :description, :lieu, :date_de_debut, :date_de_fin, :id_utilisateur)";
                $stmt = $this->connection->prepare($sql);
                $stmt->bindValue('titre', $titre);
                $stmt->bindValue('slogan', $slogan);
                $stmt->bindValue('description', $description);
                $stmt->bindValue('lieu', $lieu);
                $stmt->bindValue('date_de_debut', $date_de_debut);
                $stmt->bindValue('date_de_fin', $date_de_fin);
                $stmt->bindValue('id_utilisateur', $id_utilisateur);
                $green = $this->checkSlogan($slogan);
                if ($green)
                {
                    try
                    {
                        if($stmt->execute())
                        {
                            $id = $this->connection->lastInsertId();
                            $sql = "SELECT * FROM evenements where id = $id LIMIT 1";
                            return $this->connection->query($sql)->fetchAll();
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
                    return ['message' => "That slogan had already existed", "Astuce" => "Change slogan Please"];
                }
            }
            else
            {
                return ["message" => "Erreur de concordance des dates"];
            }
        }
        else
        {
            return ['message' => "La date est obsolete"];
        }

    }

    /**
     * @return array|false
     */
    public function listEvenements()
    {
        $sql = "SELECT * FROM evenements";
        try
        {
            $evenements = $this->connection->query($sql)->fetchAll();
        }
        catch (\Exception $exception)
        {
            return ['message' => $exception->getMessage()];
        }
        return $evenements;
    }

    /**
     * @param int $id
     * @return array|mixed
     */
    public function event(int $id)
    {
        $sql = "SELECT * FROM evenements where id = $id LIMIT 1";
        try
        {
            $evenement = $this->connection->query($sql)->fetchAll();
        }
        catch (\Exception $exception)
        {
            return ['message' => $exception->getMessage()];
        }
        return $evenement;
    }

    public function getEventsForUser(int $id)
    {
        $sql = "SELECT * FROM evenements WHERE id_utilisateur=$id";
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
     * @param array $event
     * @return false|mixed|string
     */
    public function editEvenement(int $id, array $event)
    {
        $titre = htmlspecialchars($event['titre']);
        $slogan = htmlspecialchars($event['slogan']);
        $description = htmlspecialchars($event['description']);
        $lieu = htmlspecialchars($event['lieu']);
        $date_de_debut = htmlspecialchars($event['date_de_debut']);
        $date_de_fin = htmlspecialchars($event['date_de_fin']);
        $sql = "UPDATE evenements SET titre='$titre', slogan='$slogan', description='$description', lieu='$lieu', date_de_debut='$date_de_debut', date_de_fin='$date_de_fin' WHERE id = $id";
        $stmt = $this->connection->prepare($sql);
        return $this->exeStatement($stmt, ['success' => true]);
    }

    public function pastEvents()
    {
        $sql = "SELECT * FROM evenements WHERE date_de_debut < CAST(NOW() as date)";
        try {
           return $this->connection->query($sql)->fetchAll();
        }catch (\Exception $exception)
        {
            return ['message' => $exception->getMessage()];
        }
    }

    public function userPastEvents(int $id)
    {
        $sql = "SELECT * FROM evenements WHERE date_de_fin < CAST(NOW() as date) AND id_utilisateur = $id";
        try {
            return $this->connection->query($sql)->fetchAll();
        }catch (\Exception $exception)
        {
            return ['message' => $exception->getMessage()];
        }
    }

    public function comingEvents()
    {
        $sql = "SELECT * FROM evenements WHERE date_de_debut > CAST(NOW() as date)";
        try {
            return $this->connection->query($sql)->fetchAll();
        }catch (\Exception $exception)
        {
            return ['message' => $exception->getMessage()];
        }
    }

    public function userComingEvents(int $id)
    {
        $sql = "SELECT * FROM evenements WHERE date_de_debut > CAST(NOW() as date) AND id_utilisateur = $id";
        try {
            return $this->connection->query($sql)->fetchAll();
        }catch (\Exception $exception)
        {
            return ['message' => $exception->getMessage()];
        }
    }

    public function todayEvents()
    {
        $sql = "SELECT * FROM evenements WHERE date_de_debut = CAST(NOW() as date) OR date_de_fin = CAST(NOW() as date)";
        try {
            return $this->connection->query($sql)->fetchAll();
        }catch (\Exception $exception)
        {
            return ['message' => $exception->getMessage()];
        }
    }

    public function userTodayEvents(int $id)
    {
        $sql = "SELECT * FROM evenements WHERE date_de_debut = CAST(NOW() as date) AND id_utilisateur = $id";
        try {
            return $this->connection->query($sql)->fetchAll();
        }catch (\Exception $exception)
        {
            return ['message' => $exception->getMessage()];
        }
    }
    /**
     * @param int $id
     * @return false|mixed|string
     */
    public function supprimerEvenement(int $id): mixed
    {
        $sql = "DELETE FROM evenements WHERE id = $id";
        $stmt = $this->connection->prepare($sql);
        return $this->exeStatement($stmt, ['success' => true]);
    }

    /**
     * @param string $slogan
     * @return bool
     */
    public function checkSlogan(string $slogan): bool
    {
        $sql = "SELECT * from evenements WHERE slogan = '$slogan'";
        $result = $this->connection->query($sql)->fetchAll();
        if ($result)
            return false;
        else
            return true;
    }
    /**
     * @param $stmt
     * @param $response
     * @return false|mixed|string
     */
    public function exeStatement($stmt, $response)
    {
        try{
            if ($stmt->execute()) {
                return $response;
            } else {
                return json_encode(['message' => "An error occurs"]);
            }
        } catch (HttpException $exception) {
            $statusCode = $exception->getCode();
            $errorMessage = sprintf('%s %s', $statusCode, $response->getReasonPhrase());
            return ["success" => false, "message" => $errorMessage];
        }

    }
}