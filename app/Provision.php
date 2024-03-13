<?php
namespace App;
/* Consideration: migrations.sql runs before this script
 *
 * working with db, eg: $db->insert();
 *
*/

use Core\Utils\Database\DBInterface;
use Carbon\Carbon;

class Provision {
    public function __construct(
        private readonly DBInterface $db,
    )
    {

    }

    public function run(){
        $day = [];
        $today = Carbon::today();
        for ($i = 1; $i <= 7; $i++) {
            $day[] = $today->format('Y-m-d');
            $today->addDay();
        }

        $reservations = [
            [3, $day[5], 1],
            [1, $day[0], 2],
            [4, $day[4], 2],
            [10, $day[1], 1],
            [6, $day[3], 1],
            [4, $day[2], 1],
            [6, $day[6], 1],
            [8, $day[3], 1],
            [5, $day[2], 1],
            [3, $day[3], 1],
        ];

        foreach ($reservations as $reservation) {
            $this->db->insert('INSERT INTO reservations (hour_id, date, user_id) VALUES (:hourId, :date, :userId)', [
                ':hourId' => $reservation[0],
                ':date' => $reservation[1],
                ':userId' => $reservation[2],
            ]);
        }
    }
}