document.addEventListener('DOMContentLoaded', function() {
    const uploadArea = document.getElementById('uploadArea');
    const fileInput = document.getElementById('fileInput');
    const selectedFile = document.getElementById('selectedFile');
    const fileName = document.getElementById('fileName');
    const fileSize = document.getElementById('fileSize');
    const removeFile = document.getElementById('removeFile');
    const submitBtn = document.getElementById('submitBtn');
    const uploadForm = document.getElementById('uploadForm');
    const progressBar = document.getElementById('progressBar');    const progressFill = document.getElementById('progressFill');

    // Penanganan untuk membuka file input ketika tombol diklik
    const browseBtn = document.querySelector('.browse-btn');
    if (browseBtn) {
        browseBtn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            fileInput.click();
        });
    }

    // Penanganan untuk membuka file input ketika ikon atau teks di area upload diklik (selain tombol)
    const uploadIcon = document.querySelector('.upload-icon');
    const uploadText = document.querySelector('.upload-text');
    const uploadSubtext = document.querySelector('.upload-subtext');
    
    [uploadIcon, uploadText, uploadSubtext].forEach(element => {
        if (element) {
            element.addEventListener('click', function() {
                fileInput.click();
            });
            element.style.cursor = 'pointer';
        }
    });
    
    // Penanganan drag and drop
    uploadArea.addEventListener('dragover', function(e) {
        e.preventDefault();
        uploadArea.classList.add('dragover');
    });
    
    uploadArea.addEventListener('dragleave', function(e) {
        e.preventDefault();
        uploadArea.classList.remove('dragover');
    });
    
    uploadArea.addEventListener('drop', function(e) {
        e.preventDefault();
        uploadArea.classList.remove('dragover');
        
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            const file = files[0];
            handleFileSelect(file);
        }
    });
    
    // Event listener untuk memilih file melalui input
    fileInput.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            handleFileSelect(file);
        }
    });
    
    // Event listener untuk menghapus file yang dipilih
    removeFile.addEventListener('click', function() {
        fileInput.value = '';
        selectedFile.classList.remove('show');
        uploadArea.style.display = 'block';
        submitBtn.disabled = true;
    });
    
    // Event listener untuk mengirim form
    uploadForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        if (!fileInput.files[0]) {
            alert('Silakan pilih file terlebih dahulu');
            return;
        }
        
        // Menampilkan progress bar
        progressBar.classList.add('show');
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Uploading...';
        
        // Simulasi upload dengan progress bar
        let progress = 0;
        const interval = setInterval(() => {
            progress += 10;
            progressFill.style.width = progress + '%';
            
            if (progress >= 100) {
                clearInterval(interval);
                // Submit the form
                this.submit();
            }
        }, 100);
    });
    
    function handleFileSelect(file) {
        // Validate file type
        const allowedTypes = ['text/csv', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];
        const fileExtension = file.name.split('.').pop().toLowerCase();
        const allowedExtensions = ['csv', 'xls', 'xlsx'];
        
        if (!allowedTypes.includes(file.type) && !allowedExtensions.includes(fileExtension)) {
            alert('Tipe file tidak didukung. Silakan pilih file CSV, XLS, atau XLSX.');
            return;
        }
        
        // Menangani file input
        const dataTransfer = new DataTransfer();
        dataTransfer.items.add(file);
        fileInput.files = dataTransfer.files;
        
        // Menampilkan informasi file yang dipilih
        fileName.textContent = file.name;
        fileSize.textContent = formatFileSize(file.size);
        
        // Menset ikon file berdasarkan ekstensi
        const fileIcon = document.querySelector('.file-icon i');
        if (fileExtension === 'csv') {
            fileIcon.className = 'fas fa-file-csv';
        } else {
            fileIcon.className = 'fas fa-file-excel';
        }
        
        selectedFile.classList.add('show');
        uploadArea.style.display = 'none';
        submitBtn.disabled = false;
    }
    
    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }
});
