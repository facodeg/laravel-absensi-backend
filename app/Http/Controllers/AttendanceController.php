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
        return view('pages.presensi.index', compact('attendance'));
    }

    //create
    public function create()
    {
        return view('pages.presensi.create');
    }

    //store
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'time_in' => 'required',
            'time_out' => 'required',
            'date' => 'required',
            'latlon_in' => 'required',
            'latlon_out' => 'required',
        ]);

        $attendance = new Attendance();
        $attendance->user_id = $request->user_id;
        $attendance->time_in = $request->time_in;
        $attendance->time_out = $request->time_out;
        $attendance->date = $request->date;
        $attendance->latlon_in = $request->latlon_in;
        $attendance->latlon_out = $request->latlon_out;
        $attendance->save();

        return redirect()->route('presensi.index')->with('success', 'Attendance created successfully');
    }

    //edit
    public function edit($id)
    {
        $attendance = Attendance::find($id);
        return view('pages.presensi.edit', compact('attendance'));
    }
}
