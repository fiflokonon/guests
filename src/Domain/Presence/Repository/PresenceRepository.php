<?php

namespace App\Domain\Presence\Repository;

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
    public function presences()
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

    public function createPresence(int $id, int $place)
    {
        $infos = $this->invitationInfos($id);
        if ($infos['place_rest'] == 0)
        {
            return ['message' => "Il n'y a plus de places disponibles pour cette invitation"];
        }
        elseif ($infos['place_rest'] >= $place)
        {
            $sql = "INSERT INTO presences(id_invitation, place) VALUES(:id_invitation, :place)";
            $stmt = $this->connection->prepare($sql);
            $stmt->bindValue('id_invitation', $id);
            $stmt->bindValue('place', $place);
            if ($stmt->execute())
            {
                return $this->invitationInfos($id);
            }
        }
        else
        {
            return ['message' => "Il n'y a pas autant de places disponibles"];
        }

    }

    /**
     * @param int $id
     * @return array|false
     */
    public function invitationPresenceNumber(int $id)
    {
        $sql = "SELECT SUM(place) FROM presences  WHERE id_invitation = $id";
        return $this->connection->query($sql)->fetchAll();
    }

    /**
     * @param int $id
     * @return array
     */
    public function invitationInfos(int $id)
    {
        $place_occupe = intval($this->invitationPresenceNumber($id)[0]['sum']);
        $invitation = $this->getOne('invitations', $id);
        $place_dispo = intval($invitation[0]['place']);
        $place_rest = $place_dispo - $place_occupe;
        return [
            "nom_prenoms" => $invitation[0]['nom_prenoms'],
            "place_occupe" => $place_occupe,
            "place_dispo" => $place_dispo,
            "place_rest" => $place_rest
        ];
    }

    public function getPresencesEvent(int $id)
    {
        $tab_invitations = [];
        $list_invitations = [];
        $sql1 = "SELECT id FROM invitations WHERE id_evenement = $id";
        $invitations = $this->connection->query($sql1)->fetchAll();
        foreach ($invitations as $invit)
        {
            $tab_invitations[] = $invit['id'];
        }
        $sql2 = "SELECT * FROM presences WHERE id_invitation in ('".implode("','",$tab_invitations)."')";
        $presences = $this->connection->query($sql2)->fetchAll();
        foreach ($presences as $present)
        {
            $invitation_id = $present['id_invitation'];
            $sql3 = "SELECT DISTINCT nom_prenoms FROM invitations WHERE id = $invitation_id LIMIT 1";
            $places = $this->invitationInfos($invitation_id);
            $invitation = $this->connection->query($sql3)->fetchAll();
            $invitation[0]['place_occupe'] = $places['place_occupe'];
            $invitation[0]['place_dispo']  = $places['place_dispo'];
            $invitation[0]['place_rest'] = $places['place_rest'];
            $list_invitations[] = $invitation[0];
        }
        return array_unique($list_invitations, SORT_REGULAR);
    }

    /**
     * @param int $id
     * @return array|int[]
     */
    public function eventStats(int $id)
    {
        $total_present = 0;
        $total_dispo = 0;
        $total_absent = 0;
        $tab_presences = $this->getPresencesEvent($id);
        foreach ($tab_presences as $presence)
        {
            $total_present = $total_present + intval($presence['place_occupe']);
            $total_dispo  = $total_dispo + intval($presence['place_dispo']);
            $total_absent = $total_absent + intval($presence['place_rest']);
        }
        return [
            "nb_presents" => $total_present,
            "nb_absent" => $total_absent,
            "nb_invites" => $total_dispo
        ];
    }
}