<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Upload Format Penilaian Adipura</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/upload.css') }}">
</head>
<body>
    <div class="main-container">
        <div class="header">
            <h1><i class="fas fa-cloud-upload-alt"></i> Upload Format Penilaian Adipura</h1>
        </div>
        
        <div class="upload-container">
            <div class="nav-buttons">
                <a href="{{ route('assessment.index') }}" class="back-btn">
                    <i class="fas fa-arrow-left"></i>
                    Kembali ke Penilaian Adipura
                </a>
            </div>

            <h2 class="form-title">
                <i class="fas fa-file-upload"></i>
                Upload Format Penilaian
            </h2>

            <div class="instructions">
                <div class="instructions-title">
                    <i class="fas fa-info-circle"></i>
                    Petunjuk Upload
                </div>
                <ul class="instructions-list">
                    <li>
                        <i class="fas fa-check" style="color: #48bb78;"></i>
                        Format file yang didukung: CSV (.csv), Excel (.xlsx, .xls)
                    </li>
                    <li>
                        <i class="fas fa-check" style="color: #48bb78;"></i>
                        Maksimal ukuran file: 10MB
                    </li>
                    <li>
                        <i class="fas fa-check" style="color: #48bb78;"></i>
                        File harus berisi kolom: subkomponen, Bobot Sub Komponen, Bobot Sub Komponen Koreksi
                    </li>
                    <li>
                        <i class="fas fa-check" style="color: #48bb78;"></i>
                        Data akan disimpan sebagai format penilaian Adipura
                    </li>
                </ul>
            </div>

            @if ($errors->any())
                <div class="error-container show">
                    <div class="error-title">
                        <i class="fas fa-exclamation-triangle"></i>
                        Terjadi Kesalahan
                    </div>
                    <ul class="error-list">
                        @foreach ($errors->all() as $err)
                            <li>
                                <i class="fas fa-times-circle"></i>
                                {{ $err }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(session('success'))
                <div class="success-message">
                    <i class="fas fa-check-circle"></i>
                    {{ session('success') }}
                </div>
            @endif

            <form id="uploadForm" action="{{ route('csv.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="upload-area" id="uploadArea">
                    <div class="upload-icon">
                        <i class="fas fa-cloud-upload-alt"></i>
                    </div>
                    <div class="upload-text">Drag & Drop file CSV atau Excel di sini</div>
                    <div class="upload-subtext">atau klik untuk memilih file (.csv, .xlsx, .xls)</div>
                    <button type="button" class="browse-btn">
                        <i class="fas fa-folder-open"></i>
                        Pilih File
                    </button>
                    <input type="file" name="file" class="file-input" id="fileInput" accept=".csv,.xlsx,.xls" required>
                </div>

                <div class="selected-file" id="selectedFile">
                    <div class="file-icon">
                        <i class="fas fa-file" id="fileIconDisplay"></i>
                    </div>
                    <div class="file-info">
                        <div class="file-name" id="fileName"></div>
                        <div class="file-size" id="fileSize"></div>
                    </div>
                    <button type="button" class="remove-file" id="removeFile">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <div class="progress-bar" id="progressBar">
                    <div class="progress-fill" id="progressFill"></div>
                </div>

                <button type="submit" class="submit-btn" id="submitBtn" disabled>
                    <i class="fas fa-upload"></i>
                    Upload File
                </button>
            </form>
        </div>
    </div>

    <script src="{{ asset('js/upload.js') }}"></script>
</body>
</html>
