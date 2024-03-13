<?php

namespace features;

use Core\Testing\RefreshDatabase;
use Core\Utils\Auth\AuthInterface;
use PHPUnit\Framework\TestCase;
use Core\Testing\Testing;

final class ReservationTest extends TestCase
{
    use Testing, RefreshDatabase;

    public function test_reservation_unauthenticated(): void
    {
        $response = $this->get('/reservations');

        $this->assertSame(302, $response->getStatus());
        $this->assertStringContainsString(config()->auth->login, $response->getBody());
    }

    public function test_reservation_authenticated(): void
    {
        $this->actAs(1);

        $response = $this->get('/reservations');

        $this->assertSame(200, $response->getStatus());
    }

    public function test_reservation_home_proper_load(): void
    {
        $this->actAs(1);

        $response = $this->get('/reservations');

        $this->assertStringContainsString('Reservation', $response->getBody());
    }
}