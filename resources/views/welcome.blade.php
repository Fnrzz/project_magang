@extends('layouts.layout')

@section('content')
    <div class="row">
        <div class="col-3 d-flex flex-column gap-2">
            <a href="" class="btn btn-outline-secondary">Klasifikasi Daerah</a>
            <a href="" class="btn btn-outline-secondary">IKLH</a>
            <a href="" class="btn btn-outline-secondary">SLHD</a>
            <a href="" class="btn btn-outline-secondary">Total Penghargaan</a>
        </div>
        <div class="col-9">
            <div class="mb-5">
                <h6 class="text-center mb-4">Nilai Wirawisata Tantra</h6>
                <div class="row align-items-center justify-content-center gap-2">
                    <div
                        class="col-2 d-flex justify-content-center align-items-center p-2 border border-secondary rounded-2">
                        79
                    </div>
                    <div class="col-2 d-flex justify-content-center align-items-center p-2 bg-success text-white rounded-2">
                        Sangat Baik
                    </div>
                </div>
            </div>
            <div class="row row-cols-3 mb-5">
                <div class="col">
                    <h6 class="text-center mb-4">Nilai IKHL</h6>
                    <div class="d-flex justify-content-center align-items-center p-2 border border-secondary rounded-2">
                        65
                    </div>
                </div>
                <div class="col">
                    <h6 class="text-center mb-4">Nilai SLHD</h6>
                    <div class="d-flex justify-content-center align-items-center p-2 border border-secondary rounded-2">
                        76
                    </div>
                </div>
                <div class="col">
                    <h6 class="text-center mb-4">Nilai Total Penghargaan</h6>
                    <div class="d-flex justify-content-center align-items-center p-2 border border-secondary rounded-2">
                        83
                    </div>
                </div>
            </div>
            <div id="bar-chart" style="width: 100%; height: 400px;"></div>
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        google.charts.load('current', {
            packages: ['corechart']
        });
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ['Tahun', 'Nilai Penghargaan', {
                    role: 'style'
                }],
                ['2020', 65, '#1E88E5'],
                ['2021', 70, '#1E88E5'],
                ['2022', 76, '#1E88E5'],
                ['2023', 80, '#1E88E5'],
                ['2024', 83, '#1E88E5']
            ]);

            var options = {
                title: 'Nilai Total Penghargaan per Tahun',
                chartArea: {
                    width: '70%',
                    height: '70%'
                },
                hAxis: {
                    title: 'Tahun'
                },
                vAxis: {
                    title: 'Nilai',
                    minValue: 0,
                    maxValue: 100
                }
            };

            var chart = new google.visualization.ColumnChart(document.getElementById('bar-chart'));
            chart.draw(data, options);
        }
    </script>
@endsection
