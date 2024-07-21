@extends('layouts.app')

@section('title', 'Dashboard')

@section('main')
    <div class="page-wrapper">
        <div class="page-content">
            <div class="card">
                <div class="card-body">
                    <h5 class="mb-3">Dashboard</h5>

                    <div id="izinChart"></div>

                    <table class="table table-striped table-bordered" id="example2">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Date</th>
                                <th>Time In</th>
                                <th>Time Out</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($attendances as $attendance)
                                <tr>
                                    <td>{{ $attendance->user->name }}</td>
                                    <td>{{ $attendance->user->email }}</td>
                                    <td>{{ $attendance->date }}</td>
                                    <td>{{ $attendance->time_in }}</td>
                                    <td>{{ $attendance->time_out }}</td>
                                    <td>
                                        @php
                                            $status = 'Tepat Waktu';
                                            if ($attendance->time_in > $company->time_in) {
                                                $status = 'Terlambat';
                                            } elseif ($attendance->time_out < $company->time_out) {
                                                $status = 'Pulang Cepat';
                                            }
                                        @endphp
                                        <div class="badge rounded-pill bg-{{ $status == 'Tepat Waktu' ? 'success' : ($status == 'Terlambat' ? 'warning' : 'info') }} text-dark w-100">{{ $status }}</div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="row row-cols-1 row-cols-md-2 row-cols-xl-2">
                <div class="col">
                    <div class="card radius-10">
                        <div class="card-body">
                            <div id="lateEarlyChart"></div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card radius-10">
                        <div class="card-body">
                            <div id="attendanceChart"></div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <script src="{{ asset('assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/js/dataTables.bootstrap5.min.js') }}"></script>


    <script>
        $(document).ready(function() {
            var table = $('#example2').DataTable({
                lengthChange: true,
                order: [[2, 'desc']], // Order by Date descending
                columnDefs: [
                    { targets: [3, 4], type: 'num' }, // Ensure numeric sorting on these columns
                ],
                buttons: ['copy', 'excel', 'pdf', 'print']
            });

            table.buttons().container()
                .appendTo('#example2_wrapper .col-md-6:eq(0)');
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Data for izin chart
            var izinChartData = @json($izinChartData);

            Highcharts.chart('izinChart', {
                chart: {
                    type: 'pie',
                    height: 350
                },
                title: {
                    text: 'Distribusi Izin'
                },
                tooltip: {
                    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                },
                accessibility: {
                    point: {
                        valueSuffix: '%'
                    }
                },
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                            enabled: true,
                            format: '<b>{point.name}</b>: {point.percentage:.1f} %'
                        }
                    }
                },
                series: [{
                    name: 'Jumlah Izin',
                    colorByPoint: true,
                    data: Object.keys(izinChartData).map(function(key) {
                        return {
                            name: key,
                            y: izinChartData[key]
                        };
                    })
                }]
            });

            // Data for attendance (late and early leave)
            var attendanceData = @json($attendances);

            var lateData = attendanceData.filter(function(item) {
                return item.time_in > '{{ $company->time_in }}';
            }).length;

            var earlyLeaveData = attendanceData.filter(function(item) {
                return item.time_out < '{{ $company->time_out }}';
            }).length;

            var attendanceOptions = {
                series: [{
                    name: 'Jumlah',
                    data: [lateData, earlyLeaveData]
                }],
                chart: {
                    type: 'bar',
                    height: 350
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '55%',
                        endingShape: 'rounded'
                    },
                },
                dataLabels: {
                    enabled: false
                },
                xaxis: {
                    categories: ['Terlambat', 'Pulang Cepat'],
                }
            };

            var attendanceChart = new ApexCharts(document.querySelector("#attendanceChart"), attendanceOptions);
            attendanceChart.render();

            // Highcharts Pie Chart for Late and Early Leave
            Highcharts.chart('lateEarlyChart', {
                chart: {
                    type: 'pie',
                    height: 350
                },
                title: {
                    text: 'Distribusi Terlambat dan Pulang Cepat'
                },
                tooltip: {
                    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                },
                accessibility: {
                    point: {
                        valueSuffix: '%'
                    }
                },
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                            enabled: true,
                            format: '<b>{point.name}</b>: {point.percentage:.1f} %'
                        }
                    }
                },
                series: [{
                    name: 'Jumlah',
                    colorByPoint: true,
                    data: [{
                        name: 'Terlambat',
                        y: lateData
                    }, {
                        name: 'Pulang Cepat',
                        y: earlyLeaveData
                    }]
                }]
            });
        });
    </script>
@endpush
