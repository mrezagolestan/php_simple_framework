<?php

namespace units;

use Carbon\Carbon;
use Core\Testing\RefreshDatabase;
use PHPUnit\Framework\TestCase;
use App\Repositories\ReservationRepository;

final class ReservationRepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_repository_test(): void
    {
        $reservationRepository = app()->resolve(ReservationRepository::class);
        $day5 = Carbon::now()->addDays(5)->format("Y-m-d");

        $firstReservation = $reservationRepository->getAll()[0];

        $this->assertSame(['id' => 1, 'hour_id' => 3, 'date'=> $day5, 'user_id' => 1], $firstReservation);
    }


}