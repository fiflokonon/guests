<?php

namespace App\Domain\Core\Repository;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Psr\Http\Message\ResponseFactoryInterface;
use PDO;
use Slim\Exception\HttpException;


    /*************************************************
     * ICI - LA CLASSE PARENT DE REPOSITORY***********
     *************************************************/

class Repository
{
    /**
     * @var PDO
     */
    protected PDO $connection;

    /**
     * @param PDO $connection
     */
     protected string $secret_key = 'GUESTS';
     private ResponseFactoryInterface $responseFactory;
     protected ResponseFactoryInterface $factory;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    public function createOne(string $table, $object)
    {
        $keys = array_keys($object);
        foreach ($keys as  $item) {
            $creation[$item] = $object[$item];
        }
    }
    /**
     * @param string $table
     * @return array|false
     */
    public function getAll(string $table)
    {
        $sql = "SELECT * FROM $table";
        try {
            return $this->connection->query($sql)->fetchAll();
        }
        catch (\Exception $exception)
        {
            return ['message' => $exception->getMessage()];
        }
    }

    /**
     * @param string $table
     * @param int $id
     * @return array|mixed
     */
    public function getOne(string $table, int $id)
    {
        $sql = "SELECT * FROM $table WHERE id = $id LIMIT 1";
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
     * @param string $table
     * @param int $id
     * @return false|mixed|string
     */
    public function deleteOne(string $table, int $id): mixed
    {
        $sql = "DELETE FROM $table WHERE id = $id";
        $stmt = $this->connection->prepare($sql);
        return $this->exeStatement($stmt, ['success' => true]);
    }
    /**
     * @param $stmt
     * @param $response
     * @return false|mixed|string
     */
    public function exeStatement($stmt, $response)
    {
        try {
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

    /**
     * @param array $data
     * @return string
     */
    public function generateToken(array $data): string
    {
        $issuer_claim = "payplus.africa"; // this can be the servername
        $issuedat_claim = time(); // issued at
        $notbefore_claim = $issuedat_claim + 5; //not before in seconds
        $expire_claim = $issuedat_claim + 3600; // expire time in seconds
        $token = array(
            "iss" => $issuer_claim,
            "iat" => $issuedat_claim,
            "nbf" => $notbefore_claim,
            "exp" => $expire_claim,
            "data" => $data
        );
        try
        {
            return JWT::encode($token, $this->secret_key, 'HS256');
        }
        catch (\Exception $exception)
        {
            return $exception->getMessage();
        }
    }

    /**
     * @param string $token
     * @return \Psr\Http\Message\ResponseInterface|\stdClass
     */
    public function decodeToken(string $token)
    {
        try {
            return JWT::decode($token, new Key($this->secret_key, 'HS256'));
        }catch (HttpException $exception)
        {
            $statusCode = $exception->getCode();
            $response = $this->responseFactory->createResponse();
            $errorMessage = sprintf('%s %s', $statusCode, $response->getReasonPhrase());
            $response->getBody()->write($errorMessage);
            return $response;
        }
    }

    public function aesEncrypt(int $data):string
    {
//Define cipher
        $cipher = "aes-256-cbc";
//Generate a 256-bit encryption key
        $encryption_key = openssl_random_pseudo_bytes(32);
// Generate an initialization vector
        $iv_size = openssl_cipher_iv_length($cipher);
        $iv = openssl_random_pseudo_bytes($iv_size);
//Data to encrypt
        return openssl_encrypt($data, $cipher, $encryption_key, 0, $iv);
    }

    public function aesDecrypt(string $encrypted)
    {
        $cipher = "aes-256-cbc";
        $encryption_key = openssl_random_pseudo_bytes(32);
        $iv_size = openssl_cipher_iv_length($cipher);
        $iv = openssl_random_pseudo_bytes($iv_size);
        return openssl_decrypt($encrypted, $cipher, $encryption_key, 0, $iv);
    }

}