<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Penilaian Adipura</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/assessment.css') }}">
</head>
<body>
    <div class="main-container">
        <div class="header">
            <h1><i class="fas fa-chart-line"></i> Penilaian Adipura</h1>
        </div>
        
        <div class="content-wrapper">
            <div class="form-container">
                <div class="form-header">
                    <h2 class="form-title">
                        <i class="fas fa-edit"></i>
                        Input Data
                    </h2>
                    <a href="{{ route('csv.upload') }}" class="upload-btn">
                        <i class="fas fa-upload"></i>
                        Upload File Format
                    </a>
                </div>
                
                <form id="assessmentForm">
                    @csrf
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="input1">
                                <i class="fas fa-star"></i> Nilai 1
                            </label>
                            <input type="number" id="input1" name="input1" min="1" max="100" placeholder="1-100" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="input2">
                                <i class="fas fa-star"></i> Nilai 2
                            </label>
                            <input type="number" id="input2" name="input2" min="1" max="100" placeholder="1-100" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="input3">
                                <i class="fas fa-star"></i> Nilai 3
                            </label>
                            <input type="number" id="input3" name="input3" min="1" max="100" placeholder="1-100" required>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="subkomponen">
                            <i class="fas fa-list"></i> Pilih Subkomponen
                        </label>
                        <select id="subkomponen" name="subkomponen" required>
                            <option value="">-- Pilih Subkomponen --</option>
                            @foreach($subkomponenData as $item)
                                <option value="{{ $item['subkomponen'] }}">{{ $item['subkomponen'] }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>
                            <i class="fas fa-check-circle"></i> Status Koreksi
                        </label>
                        <div class="radio-group">
                            <div class="radio-item" data-radio="belum_koreksi">
                                <input type="radio" id="belum_koreksi" name="koreksi" value="belum_koreksi" required>
                                <label for="belum_koreksi">
                                    <i class="fas fa-clock"></i> Belum Dikoreksi
                                </label>
                            </div>
                            <div class="radio-item" data-radio="koreksi">
                                <input type="radio" id="sudah_koreksi" name="koreksi" value="koreksi" required>
                                <label for="sudah_koreksi">
                                    <i class="fas fa-check"></i> Sudah Dikoreksi
                                </label>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div id="resultContainer" class="result-container">
                <h3 class="result-header">
                    <i class="fas fa-chart-bar"></i>
                    Hasil Perhitungan
                </h3>
                <div id="resultContent" class="result-content">
                    <div class="loading">
                        <div class="spinner"></div>
                        <p>Sedang menghitung...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/assessment.js') }}"></script>
</body>
</html>