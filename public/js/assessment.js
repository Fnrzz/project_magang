document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('assessmentForm');
    const resultContainer = document.getElementById('resultContainer');
    const resultContent = document.getElementById('resultContent');
    
    // Style untuk radio items
    const radioItems = document.querySelectorAll('.radio-item');
    radioItems.forEach(item => {
        item.addEventListener('click', function() {
            const radio = this.querySelector('input[type="radio"]');
            radio.checked = true;
            
            // Hapus class selected dari semua radio items
            radioItems.forEach(r => r.classList.remove('selected'));
            // Tambahkan class selected pada item yang dipilih
            this.classList.add('selected');
            
            // Hitung real-time setelah memilih radio
            calculateRealTime();
        });
    });
    
    // Event listener untuk form inputs agar menghitung real-time
    const inputs = form.querySelectorAll('input, select');
    inputs.forEach(input => {
        input.addEventListener('input', calculateRealTime);
        input.addEventListener('change', calculateRealTime);
    });
    
    function calculateRealTime() {
        const input1 = parseFloat(document.getElementById('input1').value) || 0;
        const input2 = parseFloat(document.getElementById('input2').value) || 0;
        const input3 = parseFloat(document.getElementById('input3').value) || 0;
        const subkomponen = document.getElementById('subkomponen').value;
        const koreksi = document.querySelector('input[name="koreksi"]:checked')?.value;
        
        // Cek apakah semua field terisi
        if (input1 && input2 && input3 && subkomponen && koreksi) {
            // Tampilkan loading state
            resultContainer.classList.add('show');
            resultContent.innerHTML = `
                <div class="loading">
                    <div class="spinner"></div>
                    <p>Sedang menghitung...</p>
                </div>
            `;
            
            // Kirim request ke server untuk perhitungan real-time
            const formData = new FormData();
            formData.append('input1', input1);
            formData.append('input2', input2);
            formData.append('input3', input3);
            formData.append('subkomponen', subkomponen);
            formData.append('koreksi', koreksi);
            
            fetch('/assessment', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    displayResult(data.data);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                resultContent.innerHTML = `
                    <div style="text-align: center; color: #e53e3e;">
                        <i class="fas fa-exclamation-triangle"></i>
                        <p>Terjadi kesalahan saat menghitung</p>
                    </div>
                `;
            });
        } else {
            resultContainer.classList.remove('show');
        }
    }
    
    function displayResult(data) {
        const koreksiText = data.koreksi === 'koreksi' 
            ? 'Sudah Dikoreksi' 
            : 'Belum Dikoreksi';
        
        const koreksiIcon = data.koreksi === 'koreksi' 
            ? '<i class="fas fa-check-circle" style="color: #48bb78;"></i>' 
            : '<i class="fas fa-clock" style="color: #ed8936;"></i>';
        
        resultContent.innerHTML = `
            <div class="result-item">
                <span class="result-label">
                    <i class="fas fa-star" style="color: #ffd700;"></i> Nilai 1
                </span>
                <span class="result-value">${data.input1}</span>
            </div>
            <div class="result-item">
                <span class="result-label">
                    <i class="fas fa-star" style="color: #ffd700;"></i> Nilai 2
                </span>
                <span class="result-value">${data.input2}</span>
            </div>
            <div class="result-item">
                <span class="result-label">
                    <i class="fas fa-star" style="color: #ffd700;"></i> Nilai 3
                </span>
                <span class="result-value">${data.input3}</span>
            </div>
            <div class="result-item">
                <span class="result-label">
                    <i class="fas fa-calculator" style="color: #667eea;"></i> Rata-rata
                </span>
                <span class="result-value">${data.average}</span>
            </div>
            <div class="result-item">
                <span class="result-label">
                    <i class="fas fa-list" style="color: #4299e1;"></i> Subkomponen
                </span>
                <span class="result-value">${data.subkomponen}</span>
            </div>
            <div class="result-item">
                <span class="result-label">
                    ${koreksiIcon} Status Koreksi
                </span>
                <span class="result-value">${koreksiText}</span>
            </div>
            <div class="result-item">
                <span class="result-label">
                    <i class="fas fa-percentage" style="color: #38b2ac;"></i> Persentase
                </span>
                <span class="result-value">${data.percentage}%</span>
            </div>
            <div class="result-item final-score">
                <span class="result-label">
                    <i class="fas fa-trophy"></i> Nilai Akhir
                </span>
                <span class="result-value">${data.finalScore}</span>
            </div>
        `;
    }
});
