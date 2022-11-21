<?php

namespace App\Domain\Presence;

use PDO;

final class PresenceRepository extends \App\Domain\Core\Repository\Repository
{
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
    public function presences(): bool|array
    {
        return $this->getAll('presences');
    }

    /**
     * @param int $id
     * @return array|mixed
     */
    public function presence(int $id)
    {
        return $this->getOne('presences', $id);
    }

    public function delPresence(int $id)
    {
        return $this->deleteOne('presences', $id);
    }
}