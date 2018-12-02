<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Contracts\Repository\OrderInterface;
use App\Contracts\Repository\UserInterface;

class DashboardController extends Controller
{
    /**
    *
    * @var \App\Repository\OrderRepository
    */
    protected $repository;

    public function __construct(OrderInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $totalRegisteredUser = app(UserInterface::class)->all();
        $totalOrder = $this->repository->all()->count();

        return view('admin.dashboard')
            ->with('totalRegisteredUser', $totalRegisteredUser)
            ->with('totalOrder', $totalOrder);
    }
}
