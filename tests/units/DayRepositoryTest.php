<?php

namespace units;

use Carbon\Carbon;
use Core\Testing\RefreshDatabase;
use PHPUnit\Framework\TestCase;
use App\Repositories\DayRepository;

final class DayRepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_repository_test(): void
    {
        $dayRepository = app()->resolve(DayRepository::class);
        $today = Carbon::now();

        $firstDay = $dayRepository->getAll()[0];

        $this->assertSame(['date' => $today->format("Y-m-d"), 'day' => $today->dayOfWeek], $firstDay);
    }


}