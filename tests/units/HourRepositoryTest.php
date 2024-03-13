<?php

use Core\Testing\RefreshDatabase;
use PHPUnit\Framework\TestCase;
use App\Repositories\HourRepository;
final class HourRepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_repository_test(): void
    {
        $hourRepository = app()->resolve(HourRepository::class);

        $firstHour = $hourRepository->getAll()[0];

        $this->assertSame(['id' => 1, 'title' => '9:00'], $firstHour);
    }




}