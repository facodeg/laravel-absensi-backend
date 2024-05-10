<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    //checkin
    public function checkin(Request $request)
    {
        //validate lat and log
        $request->validate([
            'latitude' => 'required',
            'longitude' => 'required',
        ]);

        //save new attendance
        $attendance = new Attendance();
        $attendance->user_id = auth()->user()->id;
        $attendance->time_in = date('H:i:s');
        $attendance->date = date('Y-m-d');
        $attendance->latlon_in = $request->latitude . ',' . $request->longitude;
        $attendance->save();

        return response()->json(
            [
                'message' => 'Checkin successfully',
                'attendance' => $attendance,
            ],
            200,
        );
    }

    //checkout
    public function checkout(Request $request)
    {
        //validate lat and log
        $request->validate([
            'latitude' => 'required',
            'longitude' => 'required',
        ]);

        //get last attendance
        $attendance = Attendance::where('user_id', auth()->user()->id)
            ->where('date', date('Y-m-d'))
            ->first();

        //save new attendance
        $attendance->time_out = date('H:i:s');
        $attendance->latlon_out = $request->latitude . ',' . $request->longitude;
        $attendance->save();

        return response()->json(
            [
                'message' => 'Checkout successfully',
                'attendance' => $attendance,
            ],
            200,
        );
    }

    //check is checkedin
    public function isCheckedin(Request $request)
    {
        //get last attendance
        $attendance = Attendance::where('user_id', $request->user()->id)
            ->where('date', date('Y-m-d'))
            ->first();

        return response()->json(
            [
                'checkedin' => $attendance ? true : false,
            ],
            200,
        );
    }
}
