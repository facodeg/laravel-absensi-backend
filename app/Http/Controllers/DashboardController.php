<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Izin;
use App\Models\Company;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Fetch all attendances with their related user data
        $attendances = Attendance::with('user')->get();

        // Fetch all izin data
        $izinData = Izin::with('user')->get();

        // Fetch company time in and out
        $company = Company::first();

        // Process chart data for izin
        $izinChartData = $izinData->groupBy('reason')->map(function ($row) {
            return $row->count();
        });

        return view('pages.dashboard', compact('attendances', 'izinChartData', 'company'));
    }
}
