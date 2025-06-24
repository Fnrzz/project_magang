@extends('layouts.layout')

@section('content')
    <div class="col d-flex flex-column gap-5">
        <div class="mb-3">
            <a href="" class="btn btn-outline-secondary">Total Penghargaan</a>
        </div>
        <div class="d-flex flex-column gap-2 border border-primary rounded-2 p-2">
            <h6 class="col-2 text-center p-3 border bg-primary text-white rounded-2">Adipura</h6>
            <div class="row row-cols-4 text-center align-items-center">
                <div class="col d-flex flex-column gap-3">
                    <form action="{{ route('assessment.upload.adipura') }}" method="POST" enctype="multipart/form-data"
                        id="uploadAdipuraForm">
                        @csrf
                        <input type="file" name="file_adipura" id="adipuraFileInput" accept=".xls,.xlsx"
                            style="display: none;">

                        <div class="d-grid">
                            <button type="button" id="uploadAdipuraBtn"
                                class="btn {{ session('file_uploaded_adipura') ? 'btn-success' : 'btn-outline-primary' }}"
                                {{ session('file_uploaded_adipura') ? 'disabled' : '' }}>
                                {{ session('file_uploaded_adipura') ? 'File is ready' : 'Upload File' }}
                            </button>
                        </div>
                    </form>

                    {{-- Hitung Adipura Button --}}
                    <button id="hitungAdipuraBtn" class="btn btn-outline-primary">Hitung Adipura</button>
                </div>
                <div class="col">
                    <h6 class="text-center mb-4">Nilai Orisinal (Skema Adipura)</h6>
                    <div id="nilaiOrisinal"
                        class="d-flex justify-content-center align-items-center p-2 border border-secondary rounded-2">
                        67
                    </div>
                </div>
                <div class="col d-flex flex-column">
                    <p class="btn btn-outline-primary">Re-Layout</p>
                    <p class="btn btn-outline-primary">Koreksi</p>
                    {{-- Hitung Adipura-NT Button --}}
                    <button id="hitungAdipuraNTBtn" class="btn btn-outline-primary">Hitung Adipura - NT</button>
                </div>
                <div class="col">
                    <h6 class="text-center mb-4">Nilai Koreksi (Skema NT)</h6>
                    <div id="nilaiKoreksi"
                        class="d-flex justify-content-center align-items-center p-2 border border-secondary bg-primary-subtle rounded-2">
                        69
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex flex-column gap-2 border border-primary rounded-2 p-2">
            <h6 class="col-2 text-center p-3 border bg-primary text-white rounded-2">Adiwiyata</h6>
            <div class="row row-cols-4 text-center align-items-center">
                <div class="col d-flex flex-column gap-3">
                    <a href="" class="btn btn-outline-primary">Upload File</a>
                    <a href="" class="btn btn-outline-primary">Hitung Adiwiyata</a>
                </div>
                <div class="col">
                    <h6 class="text-center mb-4">Nilai Orisinal (Skema Adiwiyata)</h6>
                    <div class="d-flex justify-content-center align-items-center p-2 border border-secondary rounded-2">
                        76
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex flex-column gap-2 border border-primary rounded-2 p-2">
            <h6 class="col-2 text-center p-3 border bg-primary text-white rounded-2">Proklim</h6>
            <div class="row row-cols-4 text-center align-items-center">
                <div class="col d-flex flex-column gap-3">
                    <a href="" class="btn btn-outline-primary">Upload File</a>
                    <a href="" class="btn btn-outline-primary">Hitung Proklim</a>
                </div>
                <div class="col">
                    <h6 class="text-center mb-4">Nilai Orisinal (Skema Proklim)</h6>
                    <div class="d-flex justify-content-center align-items-center p-2 border border-secondary rounded-2">
                        76
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex flex-column gap-2 border border-primary rounded-2 p-2">
            <h6 class="col-2 text-center p-3 border bg-primary text-white rounded-2">Kalpataru</h6>
            <div class="row row-cols-4 text-center align-items-center">
                <div class="col d-flex flex-column gap-3">
                    <a href="" class="btn btn-outline-primary">Upload File</a>
                    <a href="" class="btn btn-outline-primary">Hitung Kalpataru</a>
                </div>
                <div class="col">
                    <h6 class="text-center mb-4">Nilai Orisinal (Skema Kalpataru)</h6>
                    <div class="d-flex justify-content-center align-items-center p-2 border border-secondary rounded-2">
                        76
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex flex-column gap-2 border border-primary rounded-2 p-2">
            <h6 class="col-2 text-center p-3 border bg-primary text-white rounded-2">Proper</h6>
            <div class="row row-cols-4 text-center align-items-center">
                <div class="col d-flex flex-column gap-3">
                    <a href="" class="btn btn-outline-primary">Upload File</a>
                    <a href="" class="btn btn-outline-primary">Hitung Proper</a>
                </div>
                <div class="col">
                    <h6 class="text-center mb-4">Nilai Orisinal (Skema Proper)</h6>
                    <div class="d-flex justify-content-center align-items-center p-2 border border-secondary rounded-2">
                        76
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
            const hitungAdipuraBtn = document.getElementById('hitungAdipuraBtn');
            const hitungAdipuraNTBtn = document.getElementById('hitungAdipuraNTBtn');
            const nilaiOrisinal = document.getElementById('nilaiOrisinal');
            const nilaiKoreksi = document.getElementById('nilaiKoreksi');
            const uploadAdipuraForm = document.getElementById('uploadAdipuraForm');
            const uploadAdipuraBtn = document.getElementById('uploadAdipuraBtn');
            const adipuraFileInput = document.getElementById('adipuraFileInput');

            uploadAdipuraBtn.addEventListener('click', function() {
                adipuraFileInput.click();
            });

            adipuraFileInput.addEventListener('change', function(event) {
                const file = event.target.files[0];
                if (file) {
                    const allowedExtensions = ['xls', 'xlsx'];
                    const fileExtension = file.name.split('.').pop().toLowerCase();

                    if (!allowedExtensions.includes(fileExtension)) {
                        alert('File harus berformat Excel (.xls atau .xlsx)');
                        adipuraFileInput.value = '';
                        return;
                    }

                    const formData = new FormData(uploadAdipuraForm);

                    uploadAdipuraBtn.textContent = 'Uploading...';
                    uploadAdipuraBtn.disabled = true;

                    fetch(uploadAdipuraForm.action, {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                    .getAttribute('content')
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                uploadAdipuraBtn.textContent = 'File is ready';
                                uploadAdipuraBtn.classList.add('btn-success');
                                uploadAdipuraBtn.classList.remove('btn-outline-primary');
                                alert('File berhasil diupload!');
                            } else {
                                alert('File upload failed: ' + data.message);
                                uploadAdipuraBtn.textContent = 'Upload File';
                                uploadAdipuraBtn.disabled = false;
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Terjadi kesalahan saat mengupload file');
                            uploadAdipuraBtn.textContent = 'Upload File';
                            uploadAdipuraBtn.disabled = false;
                        })
                        .finally(() => {
                            adipuraFileInput.value = '';
                        });
                }
            });

            hitungAdipuraBtn.addEventListener('click', function() {
                fetch('{{ route('assessment.calculate.orisinal') }}')
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            nilaiOrisinal.textContent = data.nilai;
                        } else {
                            alert('Failed to calculate Adipura score: ' + data.message);
                        }
                    })
                    .catch(error => console.error('Error:', error));
            });

            hitungAdipuraNTBtn.addEventListener('click', function() {
                fetch('{{ route('assessment.calculate.koreksi') }}')
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            nilaiKoreksi.textContent = data.nilai;
                        } else {
                            alert('Failed to calculate Adipura - NT score: ' + data.message);
                        }
                    })
                    .catch(error => console.error('Error:', error));
            });
        });
    </script>
@endsection
