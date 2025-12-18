// Fungsi validasi form dengan feedback yang lebih baik
function validateForm(form) {
    var inputs = form.querySelectorAll('input[required], select[required], textarea[required]');
    var isValid = true;
    
    inputs.forEach(function(input) {
        // Reset pesan error sebelumnya
        input.classList.remove('is-invalid');
        
        // Hapus pesan error yang sudah ada
        var existingError = input.parentElement.querySelector('.invalid-feedback');
        if (existingError) {
            existingError.remove();
        }
        
        // Validasi field kosong
        if (!input.value.trim()) {
            input.classList.add('is-invalid');
            
            // Tambahkan pesan error jika belum ada
            var errorDiv = document.createElement('div');
            errorDiv.className = 'invalid-feedback';
            errorDiv.textContent = 'Field ini wajib diisi!';
            
            // Tentukan penempatan pesan error
            if (input.type === 'checkbox' || input.type === 'radio') {
                input.parentElement.parentElement.appendChild(errorDiv);
            } else {
                input.parentElement.appendChild(errorDiv);
            }
            
            isValid = false;
        }
        
        // Validasi khusus untuk email
        if (input.type === 'email' && input.value.trim()) {
            var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(input.value.trim())) {
                input.classList.add('is-invalid');
                
                var emailError = document.createElement('div');
                emailError.className = 'invalid-feedback';
                emailError.textContent = 'Format email tidak valid!';
                input.parentElement.appendChild(emailError);
                
                isValid = false;
            }
        }
        
        // Validasi untuk number (min/max)
        if (input.type === 'number' && input.value.trim()) {
            var value = parseFloat(input.value);
            
            if (input.hasAttribute('min')) {
                var min = parseFloat(input.getAttribute('min'));
                if (value < min) {
                    input.classList.add('is-invalid');
                    
                    var minError = document.createElement('div');
                    minError.className = 'invalid-feedback';
                    minError.textContent = 'Nilai minimum adalah ' + min;
                    input.parentElement.appendChild(minError);
                    
                    isValid = false;
                }
            }
            
            if (input.hasAttribute('max')) {
                var max = parseFloat(input.getAttribute('max'));
                if (value > max) {
                    input.classList.add('is-invalid');
                    
                    var maxError = document.createElement('div');
                    maxError.className = 'invalid-feedback';
                    maxError.textContent = 'Nilai maksimum adalah ' + max;
                    input.parentElement.appendChild(maxError);
                    
                    isValid = false;
                }
            }
        }
    });
    
    return isValid;
}

// Format angka menjadi Rupiah
function formatRupiah(angka, withSymbol = true) {
    if (!angka) return withSymbol ? 'Rp 0' : '0';
    
    var number = parseFloat(angka);
    if (isNaN(number)) return withSymbol ? 'Rp 0' : '0';
    
    var formatted = number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    return withSymbol ? 'Rp ' + formatted : formatted;
}

// Format tanggal dari YYYY-MM-DD menjadi DD/MM/YYYY
function formatDate(dateString, separator = '/') {
    if (!dateString) return '';
    
    try {
        var date = new Date(dateString);
        if (isNaN(date.getTime())) {
            // Jika format bukan ISO, coba split manual
            var parts = dateString.split('-');
            if (parts.length === 3) {
                return parts[2] + separator + parts[1] + separator + parts[0];
            }
            return dateString;
        }
        
        var day = date.getDate().toString().padStart(2, '0');
        var month = (date.getMonth() + 1).toString().padStart(2, '0');
        var year = date.getFullYear();
        
        return day + separator + month + separator + year;
    } catch (e) {
        console.error('Error formatting date:', e);
        return dateString;
    }
}

// Format tanggal dengan bulan nama (01 Januari 2023)
function formatDateLong(dateString) {
    if (!dateString) return '';
    
    var monthNames = [
        'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
    ];
    
    try {
        var date = new Date(dateString);
        if (isNaN(date.getTime())) return dateString;
        
        var day = date.getDate().toString().padStart(2, '0');
        var month = monthNames[date.getMonth()];
        var year = date.getFullYear();
        
        return day + ' ' + month + ' ' + year;
    } catch (e) {
        return dateString;
    }
}

// Konfirmasi sebelum menghapus dengan SweetAlert2
function confirmDelete(message, callback) {
    Swal.fire({
        title: 'Konfirmasi Hapus',
        text: message || 'Apakah Anda yakin ingin menghapus data ini?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed && typeof callback === 'function') {
            callback();
        }
    });
}

// Konfirmasi sederhana dengan alert browser
function confirmDeleteSimple(message) {
    return confirm(message || 'Apakah Anda yakin ingin menghapus data ini?');
}

// Show success message
function showSuccess(message) {
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: message || 'Operasi berhasil dilakukan',
        confirmButtonColor: '#28a745',
        timer: 2000
    });
}

// Show error message
function showError(message) {
    Swal.fire({
        icon: 'error',
        title: 'Terjadi Kesalahan!',
        text: message || 'Terjadi kesalahan. Silakan coba lagi.',
        confirmButtonColor: '#d33'
    });
}

// Auto-hide alert setelah 5 detik
document.addEventListener('DOMContentLoaded', function() {
    // Auto-hide Bootstrap alerts
    var alerts = document.querySelectorAll('.alert:not(.alert-permanent)');
    alerts.forEach(function(alert) {
        setTimeout(function() {
            var bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }, 5000);
    });
    
    // Validasi form secara real-time
    var forms = document.querySelectorAll('form[novalidate]');
    forms.forEach(function(form) {
        var inputs = form.querySelectorAll('input, select, textarea');
        
        inputs.forEach(function(input) {
            // Validasi on blur
            input.addEventListener('blur', function() {
                validateField(this);
            });
            
            // Validasi on input (untuk menghapus error saat user mulai mengetik)
            input.addEventListener('input', function() {
                if (this.classList.contains('is-invalid')) {
                    this.classList.remove('is-invalid');
                    
                    // Hapus pesan error
                    var errorDiv = this.parentElement.querySelector('.invalid-feedback');
                    if (errorDiv) {
                        errorDiv.remove();
                    }
                }
            });
        });
    });
    
    // Fungsi validasi per field
    function validateField(field) {
        if (field.hasAttribute('required') && !field.value.trim()) {
            field.classList.add('is-invalid');
            
            // Tambahkan pesan error jika belum ada
            if (!field.parentElement.querySelector('.invalid-feedback')) {
                var errorDiv = document.createElement('div');
                errorDiv.className = 'invalid-feedback';
                errorDiv.textContent = field.getAttribute('data-error') || 'Field ini wajib diisi!';
                field.parentElement.appendChild(errorDiv);
            }
            return false;
        }
        
        // Validasi email
        if (field.type === 'email' && field.value.trim()) {
            var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(field.value.trim())) {
                field.classList.add('is-invalid');
                
                if (!field.parentElement.querySelector('.invalid-feedback')) {
                    var emailError = document.createElement('div');
                    emailError.className = 'invalid-feedback';
                    emailError.textContent = 'Format email tidak valid!';
                    field.parentElement.appendChild(emailError);
                }
                return false;
            }
        }
        
        // Jika valid, hapus error
        field.classList.remove('is-invalid');
        var errorDiv = field.parentElement.querySelector('.invalid-feedback');
        if (errorDiv) {
            errorDiv.remove();
        }
        
        return true;
    }
    
    // Format input uang otomatis
    var moneyInputs = document.querySelectorAll('input[data-type="money"]');
    moneyInputs.forEach(function(input) {
        input.addEventListener('input', function() {
            var value = this.value.replace(/[^\d]/g, '');
            if (value) {
                this.value = formatRupiah(value, false);
            }
        });
        
        input.addEventListener('blur', function() {
            var value = this.value.replace(/[^\d]/g, '');
            if (value) {
                this.value = formatRupiah(value, true);
            }
        });
        
        input.addEventListener('focus', function() {
            this.value = this.value.replace(/[^\d]/g, '');
        });
    });
});

// Debounce function untuk performa
function debounce(func, wait) {
    var timeout;
    return function executedFunction() {
        var context = this;
        var args = arguments;
        
        var later = function() {
            timeout = null;
            func.apply(context, args);
        };
        
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// Copy text to clipboard
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        showSuccess('Teks berhasil disalin ke clipboard!');
    }).catch(function(err) {
        showError('Gagal menyalin teks: ' + err);
    });
}

// Disable form saat submit untuk mencegah double submit
document.addEventListener('submit', function(e) {
    var form = e.target;
    var submitButton = form.querySelector('button[type="submit"]');
    
    if (submitButton && !form.classList.contains('no-disable')) {
        submitButton.disabled = true;
        submitButton.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Memproses...';
        
        // Re-enable setelah 5 detik (jika terjadi error)
        setTimeout(function() {
            submitButton.disabled = false;
            submitButton.innerHTML = 'Simpan';
        }, 5000);
    }
});