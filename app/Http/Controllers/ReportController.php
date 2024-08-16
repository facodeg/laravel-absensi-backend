<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Company;
use App\Models\User;
use App\Models\Izin; // Pastikan untuk mengimpor model Izin
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf; // Untuk ekspor PDF
use Maatwebsite\Excel\Facades\Excel; // Untuk ekspor Excel
use App\Exports\ReportExport; // Pastikan Anda membuat export ini

class ReportController extends Controller
{
    public function monthlyReport(Request $request)
    {
        $month = $request->input('month', now()->month); // Default to current month
        $year = $request->input('year', now()->year); // Default to current year

        $startDate = Carbon::create($year, $month, 1)->startOfMonth();
        $endDate = $startDate->copy()->endOfMonth();

        $attendances = Attendance::with('user')
            ->whereBetween('date', [$startDate, $endDate])
            ->get();

        $company = Company::first();
        $users = User::all(); // Dapatkan semua pengguna

        $report = [];

        foreach ($users as $user) {
            $userAttendances = $attendances->where('user_id', $user->id);

            // Menghitung total kehadiran
            $total = $userAttendances->count();
            $late = $userAttendances->where('time_in', '>', $company->time_in)->count();
            $early_leave = $userAttendances->where('time_out', '<', $company->time_out)->count();
            $on_time = $total - $late - $early_leave;

            // Menghitung hari wajib hadir (Senin hingga Sabtu)
            $mandatoryDays = $this->countMandatoryDays($startDate, $endDate);

            // Menghitung jumlah izin
            $userIzin = Izin::where('user_id', $user->id)
                ->whereBetween('date_izin', [$startDate, $endDate])
                ->count();

            // Menghitung hari tidak hadir
            $presentDays = $total + $userIzin;
            $absent = $mandatoryDays - $presentDays;

            $report[$user->id] = [
                'user_name' => $user->name,
                'total' => $total,
                'late' => $late,
                'early_leave' => $early_leave,
                'on_time' => $on_time,
                'absent' => $absent,
                'mandatory_days' => $mandatoryDays,
                'izin' => $userIzin, // Tambahkan jumlah izin ke laporan
            ];
        }

        return view('pages.monthly_report', compact('report'));
    }

    private function countMandatoryDays($startDate, $endDate)
    {
        $currentDate = $startDate;
        $mandatoryDays = 0;

        while ($currentDate <= $endDate) {
            $dayOfWeek = $currentDate->dayOfWeek;

            // Menghitung hari dari Senin (1) hingga Sabtu (6)
            if ($dayOfWeek >= Carbon::MONDAY && $dayOfWeek <= Carbon::SATURDAY) {
                $mandatoryDays++;
            }

            $currentDate->addDay();
        }

        return $mandatoryDays;
    }

    // Fungsi untuk eksport PDF
    public function exportPdf(Request $request)
    {
        $report = $this->generateReportData($request);

        $pdf = PDF::loadView('pages.report_pdf', compact('report'));
        return $pdf->download('laporan_presensi_bulanan.pdf');
    }

   
    private function generateReportData($request)
    {
        $month = $request->input('month', now()->month);
        $year = $request->input('year', now()->year);

        $startDate = Carbon::create($year, $month, 1)->startOfMonth();
        $endDate = $startDate->copy()->endOfMonth();

        $attendances = Attendance::with('user')
            ->whereBetween('date', [$startDate, $endDate])
            ->get();

        $company = Company::first();
        $users = User::all();

        $report = [];

        foreach ($users as $user) {
            $userAttendances = $attendances->where('user_id', $user->id);

            $total = $userAttendances->count();
            $late = $userAttendances->where('time_in', '>', $company->time_in)->count();
            $early_leave = $userAttendances->where('time_out', '<', $company->time_out)->count();
            $on_time = $total - $late - $early_leave;

            $mandatoryDays = $this->countMandatoryDays($startDate, $endDate);
            $userIzin = Izin::where('user_id', $user->id)
                ->whereBetween('date_izin', [$startDate, $endDate])
                ->count();

            $presentDays = $total + $userIzin;
            $absent = $mandatoryDays - $presentDays;

            $report[$user->id] = [
                'user_name' => $user->name,
                'total' => $total,
                'late' => $late,
                'early_leave' => $early_leave,
                'on_time' => $on_time,
                'absent' => $absent,
                'mandatory_days' => $mandatoryDays,
                'izin' => $userIzin,
            ];
        }

        return $report;
    }
}
