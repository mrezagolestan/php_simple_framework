<?php

namespace App\Controllers;

use App\Repositories\DayRepository;
use App\Repositories\HourRepository;
use App\Repositories\ReservationRepository;
use Core\Response\ResponseInterface;
use Core\Utils\Auth\Auth;

class ReservationController extends Controller
{

    public function __construct(
        private readonly HourRepository        $hourRepository,
        private readonly DayRepository         $dayRepository,
        private readonly ReservationRepository $reservationRepository,
        private readonly Auth                  $auth,
    )
    {

    }

    public function index(): ResponseInterface
    {
        $hours = $this->hourRepository->getAll();
        $days = $this->dayRepository->getAll();

        $from = $days[0]['date'];
        $to = $days[count($days) - 1]['date'];
        $reserves = $this->reservationRepository->reserveList($from, $to);

        $currentUser = $this->auth->getUserId();

        return view('reservations/index', compact('hours', 'days', 'reserves', 'currentUser'));
    }

    public function reserve(int $hourId, string $date): ResponseInterface
    {
        $exist = $this->reservationRepository->reserveExist($hourId, $date);

        if ($exist && $exist['user_id'] == $this->auth->getUserId()) {
            setFlashMessage('danger', 'this time booked by another & can\'t be reserved anymore');
        }

        if ($exist) {
            $this->cancelReserve($hourId, $date);
        } else {
            $userId = $this->auth->getUserId();
            $this->bookReserve($hourId, $date, $userId);
        }

        return redirect('/reservations');
    }

    private function bookReserve(int $hourId, string $date, int $userId): void
    {
        $action = $this->reservationRepository->reserve($hourId, $date, $userId);

        if ($action) {
            setFlashMessage('success', 'reserve booked.');
        } else {
            setFlashMessage('danger', 'reserve booking failed.');
        }
    }

    private function cancelReserve(int $hourId, string $date): void
    {
        $action = $this->reservationRepository->cancelReserve($hourId, $date);

        if ($action) {
            setFlashMessage('success', 'reserve booked.');
        } else {
            setFlashMessage('danger', 'reserve booking failed.');
        }
    }
}