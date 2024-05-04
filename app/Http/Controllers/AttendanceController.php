<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    //index
    public function index()
    {
        $attendance = Attendance::with('user')->orderBy('user_id')->get();
        return view('pages.presensi.index');
    }
}
