<?php

namespace App\Domain\User\Repository;

use App\Domain\Core\Middleware\Error;
use App\Domain\Core\Repository\Repository;
use Nyholm\Psr7\Response;
use PDO;
use Firebase\JWT\JWT;
use Slim\Exception\HttpException;

/************************************************************
 * ICI - LA CLASSE QUI COMMUNIQUE AVEC LA TABLE UTILISATEURS*
 ************************************************************/
final class UserRepository extends Repository
{
    private Error $error;
    /**
     * @param PDO $connection
     */
    public function __construct(PDO $connection)
    {
        parent::__construct($connection);
    }

    /**
     * @return bool|array
     */
    public function getUsers()
    {
        return $this->getAll('utilisateurs');
    }
    /**
     * @param array $user
     * @return string[]
     */
    public function inscription(array $user)
    {
        $prenoms = htmlspecialchars($user['prenoms']);
        $nom = htmlspecialchars($user['nom']);
        $email = htmlspecialchars($user['email']);
        $tel = htmlspecialchars($user['tel']);
        $mot_de_passe = password_hash( htmlspecialchars($user['mot_de_passe']), PASSWORD_DEFAULT );
        $sexe = htmlspecialchars($user['sexe']);
        $sql = "SELECT * FROM utilisateurs WHERE email = '$email' OR tel = '$tel'";
        $get = $this->connection->query($sql)->fetchAll();
        if (empty($get))
        {
            if (!empty($prenoms) && !empty($nom) && !empty($email) && !empty($tel) && !empty($sexe) && !empty($mot_de_passe))
            {
                $sql = "INSERT INTO utilisateurs(prenoms, nom, email, tel, sexe, mot_de_passe) VALUES (:prenoms, :nom, :email, :tel, :sexe, :mot_de_passe)";
                $stmt = $this->connection->prepare($sql);
                $stmt->bindValue('prenoms', $prenoms);
                $stmt->bindValue('nom', $nom);
                $stmt->bindValue('email', $email);
                $stmt->bindValue('tel', $tel);
                $stmt->bindValue('sexe', $sexe);
                $stmt->bindValue('mot_de_passe', $mot_de_passe);
                /****************************************
                 **** EXECUTE REGISTER REQUEST **********
                 ****************************************/
                try
                {
                    if($stmt->execute())
                    {
                        $id = $this->connection->lastInsertId();
                        $sql = "SELECT * FROM utilisateurs where id=$id LIMIT 1 ";
                        return [
                            'success' => true,
                            'response' => $this->connection->query($sql)->fetchAll()
                        ];
                    }
                    else
                    {
                        return [
                            "success" => false,
                            'message' => "An error occurs"
                        ];
                    }
                }
                catch (HttpException $exception)
                {
                    $statusCode = $exception->getCode();
                    $errorMessage = sprintf('%s %s', $statusCode, $response->getReasonPhrase());
                    return [
                        "success" => false,
                        "message" => $errorMessage];
                }
            }
            else
            {
                return [
                    "success" => false,
                    "message" => "Something is empty"
                ];
            }
        }
        else
        {
            return [
                "success" => false,
                "message" => "Contact ou Email déjà associé à un compte"
            ];
        }

    }

    /**
     * @param array $user
     * @return array|string[]
     */
    public function connexion(array $user): array
    {
        if (isset($user['mot_de_passe']) && isset($user['email']) && !empty($user['mot_de_passe']) && !empty($user['email']))
        {
            $email = htmlspecialchars($user['email']);
            $sql = "SELECT * FROM utilisateurs WHERE email='$email'";
            $utilisateur = $this->connection->query($sql)->fetchAll();

            if($this->checkUserExist($utilisateur))
            {
                if ($this->checkPassword($utilisateur[0], $user))
                {
                   $token = $this->generateToken($utilisateur[0]);
                }
                else
                {
                    return [
                        'success' => false,
                        'message' => "Email ou mot de passe incorrect"
                    ];
                }
            }
            else
            {
                return ["success" => false,
                    'message' => "Utilisateur inexistant"];
            }
            return [
                'success' => true,
                'user' => $utilisateur[0],
                'token' => $token];
        }
        else
        {
            return [
                "success" => false,
                "message" => "Email ou mot de passe non fourni"
            ];
        }
    }

    public function user(int $id)
    {
        return $this->getOne('utilisateurs', $id);
    }
    /**
     * @param int $id
     * @param $user
     * @return false|mixed|string|void
     */
    public function editUtilisateur(int $id, $user)
    {
        $utilisateur = $this->user($id);
        if ($this->checkUserExist($utilisateur))
        {
            $prenoms = htmlspecialchars($user['prenoms']);
            $nom = htmlspecialchars($user['nom']);
            $email = htmlspecialchars($user['email']);
            $tel = htmlspecialchars($user['tel']);
            $mot_de_passe = password_hash(htmlspecialchars($user['mot_de_passe']),PASSWORD_DEFAULT);
            $sql = "UPDATE utilisateurs SET prenoms='$prenoms', nom='$nom', email='$email', tel='$tel', mot_de_passe='$mot_de_passe' WHERE id=$id";
            $stmt = $this->connection->prepare($sql);
            return $this->exeStatement($stmt, ['success' => true]);
        }
        else
        {
            return [
              "success" => false,
              "message" => "Utilisateur Inexistant"
            ];
        }
    }

    /**
     * @param int $id
     * @return false|mixed|string|void
     */
    public function changerStatutUtilisateur(int $id)
    {
        $utilisateur = $this->user($id);
        if ($this->checkUserExist($utilisateur))
        {
            $sql = "UPDATE utilisateurs SET statut=false WHERE id=$id";
            $stmt = $this->connection->prepare($sql);
            return $this->exeStatement($stmt, ['success' => true]);
        }
    }

    /**
     * @param int $id
     * @return false|mixed|string
     */
    public function supprimerUtilisateur(int $id)
    {
       return $this->deleteOne('utilisateurs', $id);
    }

    public function getMe(string $token)
    {
        $decoded = $this->decodeToken($token);
        if ($decoded)
        {
            $id = $decoded->data->id;
            return $this->user($id);
        }
        else{
            $response = new Response();
            return $this->error->setErrors($response, 401, 'Unauthorized');
        }
    }

    /**
     * @param array $user
     * @return bool
     */
    public function checkUserExist(array $user): bool
    {
        if (!empty($user))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    /**
     * @param array $user
     * @param array $userLog
     * @return bool
     */
    public function checkPassword(array $user, array $userLog): bool
    {
        if (password_verify($userLog['mot_de_passe'], $user['mot_de_passe']))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
}