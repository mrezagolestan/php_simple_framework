<?php

namespace App\Repositories;


class ReservationRepository extends Repository
{
    protected string $table = "reservations";

    public function reserveList($from, $to)
    {
        return $this->db->getAll("SELECT * FROM reservations WHERE `date` >= '$from' OR `date` <= $to");
    }

    public function reserveExist(int $hourId, string $date)
    {
        return $this->db
            ->getSingle("SELECT id, user_id FROM reservations WHERE hour_id = $hourId AND date = '$date'");
    }

    public function reserve(int $hourId, string $date, int $userId): int
    {
        return $this->db
            ->insert("INSERT INTO reservations (hour_id,date,user_id) VALUES (:hourId,:date,:userId)", [
                ':hourId' => $hourId,
                ':date' => $date,
                ':userId' => $userId,
            ]);
    }

    public function cancelReserve(int $hourId, string $date): int
    {
        return $this->db
            ->execute("DELETE FROM reservations WHERE hour_id = :hourId AND date = :date", [
                ':hourId' => $hourId,
                ':date' => $date,
            ]);
    }

}