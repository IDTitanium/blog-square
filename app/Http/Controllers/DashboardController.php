<?php

namespace App\Http\Controllers;

use App\Repositories\DashboardRepository;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    private $dashRepository;
    public function __construct(DashboardRepository $dashboardRepository)
    {
        $this->dashRepository = $dashboardRepository;
    }

    /**
     * Get the dashboard view
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index() {
        $data = $this->dashRepository->prepareData();

        return view('dashboard', $data);
    }
}
