@extends('layouts.layout')

@section('content')
    <div class="row">
        <div class="col-3 d-flex flex-column gap-2">
            <a href="" class="btn btn-outline-secondary">Klasifikasi Daerah</a>
            <a href="" class="btn btn-outline-secondary">IKLH</a>
            <a href="" class="btn btn-outline-secondary">SLHD</a>
            <a href="{{ route('assessment.index') }}" class="btn btn-outline-secondary">Total Penghargaan</a>
        </div>
        <div class="col-9">
            <div class="mb-5">
                <h6 class="text-center mb-4">Nilai Nirwasita Tantra</h6>
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
            <div id="chart" style="width: 100%; height: 400px;"></div>
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        google.charts.load('current', {
            'packages': ['corechart']
        });
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {

            var data = new google.visualization.DataTable();
            data.addColumn('string', 'Tahun');
            data.addColumn('number', 'Nilai Total Penghargaan');

            data.addRows([
                ['2025', 70],
                ['2026', 54],
                ['2027', 60],
                ['2028', 90],
            ]);


            var options = {
                title: 'Nilai Total Penghargaan Per Tahun',
                width: 850,
                height: 500,
                chartArea: {
                    left: 60,
                    top: 50,
                    width: '85%',
                    height: '75%'
                },
                vAxis: {
                    viewWindow: {
                        min: 10,
                        max: 100
                    },
                    gridlines: {
                        color: '#CCCCCC',
                        count: 10
                    }
                },
                colors: ['#4285F4'],
                legend: {
                    position: 'top',
                    alignment: 'end'
                }
            };

            var chartContainer = document.getElementById('chart');

            var chart = new google.visualization.LineChart(chartContainer);

            chart.draw(data, options);
        }
    </script>
@endsection
