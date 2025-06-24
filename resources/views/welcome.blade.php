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
                <h6 class="text-center mb-4">Nilai Nirawasita Tantra</h6>
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
        google.charts.load('current', { 'packages': ['line'] });
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {

            var data = new google.visualization.DataTable();
            data.addColumn('string', 'Tahun');
            data.addColumn('number', 'Nilai Total Penghargaan');

            data.addRows([
                ['2025', 17.6],
                ['2026', 54.7],
                ['2027', 60.8],
                ['2028', 90.3],
                ['2029', 38.9],
                ['2030', 67.8],
            ]);

            var options = {
                chart: {
                    title: 'Nilai Total Penghargaan Per Tahun',
                },
                width: 850,
                height: 500,
                vAxis: {
                    viewWindow: {
                        min: 10,
                        max: 100
                    },
                    gridlines: {
                        color: '#CCCCCC',
                        count: 11
                    }
                },
                series: {
                    0: { color: '#4285F4' }
                }
            };

            var chartContainer = document.getElementById('chart');
            var chart = new google.charts.Line(chartContainer);

            // DENGAN SANGAT HATI-HATI: Manipulasi SVG setelah grafik digambar.
            // Ini sangat rapuh dan mungkin tidak stabil.
            google.visualization.events.addListener(chart, 'ready', function () {
                var svg = chartContainer.querySelector('svg');
                if (!svg) {
                    console.error("SVG element not found in chart container.");
                    return;
                }

                // Cari grup elemen yang berisi area plot. Ini bisa sangat bervariasi
                // tergantung pada versi Google Charts dan struktur SVG internalnya.
                // Anda mungkin perlu memeriksa elemen SVG di browser Anda (Inspect Element)
                // untuk menemukan selector yang benar.
                // Contoh umum: 'g' dengan kelas atau atribut tertentu.
                // Untuk contoh ini, saya akan mencoba menemukan area plot berdasarkan strukturnya,
                // namun ini bisa gagal.
                var chartArea = svg.querySelector('g:has(rect[fill="none"])'); // Mencoba menemukan grup area plot

                if (!chartArea) {
                    console.warn("Could not find the chart plotting area (g element). Background colors won't be applied.");
                    return;
                }

                // Mendapatkan dimensi area plot (perkiraan, perlu kalibrasi)
                // Ini adalah tebakan terbaik tanpa mengetahui struktur SVG yang tepat.
                // Anda perlu mendapatkan koordinat X, Y, lebar, tinggi dari area plot yang sebenarnya.
                // Ini adalah bagian paling sulit dan rapuh.
                var chartAreaBBox = chartArea.getBBox(); // Dapatkan bounding box dari elemen chartArea

                var chartHeight = options.height; // Tinggi total chart
                var viewWindowMin = options.vAxis.viewWindow.min;
                var viewWindowMax = options.vAxis.viewWindow.max;
                var yAxisRange = viewWindowMax - viewWindowMin;

                // Perkiraan koordinat Y untuk rentang 10-60 dan 60-100
                // Ini SANGAT bergantung pada skala sumbu Y internal Google Charts,
                // yang tidak langsung terekspos. Ini adalah perkiraan dan perlu di-tweak.

                // Misalnya, jika 0-100 adalah 400px tinggi dalam plot area
                // maka 1 unit = 4px
                // Yaitu, (60-10) / (100-10) = 50/90 dari tinggi plot.
                // (100-60) / (100-10) = 40/90 dari tinggi plot.

                // Perkiraan tinggi efektif area plot Y yang sebenarnya
                // Anda perlu mengidentifikasi elemen <rect> yang merupakan latar belakang area plot
                // untuk mendapatkan dimensi yang akurat.
                var plotBackgroundRect = chartArea.querySelector('rect[fill="none"]'); // Mencari persegi latar belakang kosong
                if (!plotBackgroundRect) {
                    console.warn("Could not find the plot background rect. Cannot accurately determine plot dimensions.");
                    return; // Tidak bisa melanjutkan tanpa dimensi yang akurat
                }
                var plotY = parseFloat(plotBackgroundRect.getAttribute('y'));
                var plotHeight = parseFloat(plotBackgroundRect.getAttribute('height'));
                var plotWidth = parseFloat(plotBackgroundRect.getAttribute('width'));
                var plotX = parseFloat(plotBackgroundRect.getAttribute('x'));


                // Hitung proporsi tinggi untuk setiap rentang
                var yellowRangeStartValue = 10;
                var yellowRangeEndValue = 60;
                var greenRangeStartValue = 60;
                var greenRangeEndValue = 100;

                // Proporsi dari total rentang sumbu Y (10-100)
                var totalViewRange = viewWindowMax - viewWindowMin;

                var yellowHeightRatio = (yellowRangeEndValue - yellowRangeStartValue) / totalViewRange;
                var greenHeightRatio = (greenRangeEndValue - greenRangeStartValue) / totalViewRange;

                // Hitung posisi Y di dalam area plot (ingat Y meningkat ke bawah di SVG)
                // Posisi Y 100 (maks) akan di 'y' plotBackgroundRect
                // Posisi Y 10 (min) akan di 'y' + 'height' plotBackgroundRect

                // Y untuk nilai tertentu = plotY + plotHeight * ((viewWindowMax - value) / totalViewRange)

                var yellowYStart = plotY + plotHeight * ((viewWindowMax - yellowRangeEndValue) / totalViewRange);
                var yellowHeight = plotHeight * yellowHeightRatio;

                var greenYStart = plotY + plotHeight * ((viewWindowMax - greenRangeEndValue) / totalViewRange);
                var greenHeight = plotHeight * greenHeightRatio;

                // Buat elemen rect SVG baru
                var yellowRect = document.createElementNS('http://www.w3.org/2000/svg', 'rect');
                yellowRect.setAttribute('x', plotX); // X sama dengan area plot
                yellowRect.setAttribute('y', yellowYStart);
                yellowRect.setAttribute('width', plotWidth); // Lebar sama dengan area plot
                yellowRect.setAttribute('height', yellowHeight);
                yellowRect.setAttribute('fill', 'rgba(255, 255, 0, 0.2)'); // Kuning transparan
                yellowRect.setAttribute('pointer-events', 'none'); // Pastikan tidak mengganggu interaksi mouse

                var greenRect = document.createElementNS('http://www.w3.org/2000/svg', 'rect');
                greenRect.setAttribute('x', plotX);
                greenRect.setAttribute('y', greenYStart);
                greenRect.setAttribute('width', plotWidth);
                greenRect.setAttribute('height', greenHeight);
                greenRect.setAttribute('fill', 'rgba(0, 128, 0, 0.1)'); // Hijau transparan
                greenRect.setAttribute('pointer-events', 'none');

                // Tambahkan rectangle ini ke elemen SVG chartArea.
                // PENTING: Order (urutan) penambahan menentukan lapisan.
                // Anda ingin ini di bawah garis data, jadi tambahkan ke awal chartArea.
                chartArea.prepend(greenRect);
                chartArea.prepend(yellowRect);

                console.log("Background colors attempted to be applied.");
            });

            chart.draw(data, google.charts.Line.convertOptions(options));
        }
    </script>
@endsection