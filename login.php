<?php
// Mulai session hanya jika belum dimulai
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Jika sudah login, redirect ke dashboard
if (isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

// Koneksi database
require_once 'config/koneksi.php';

// Proses login
$error = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = escape($_POST['username']);
    $password = $_POST['password'];
    
    $query = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($koneksi, $query);
    
    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
        
        // Verifikasi password
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id_user'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['nama_lengkap'] = $user['nama_lengkap'];
            $_SESSION['level'] = $user['level'];
            
            header('Location: index.php');
            exit();
        } else {
            $error = 'Password salah!';
        }
    } else {
        $error = 'Username tidak ditemukan!';
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Stok Barang Elektronik Sei Batang Hari</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    
    <!-- Custom CSS -->
    <style>
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3a0ca3;
            --accent-color: #4cc9f0;
            --success-color: #06d6a0;
            --warning-color: #ffd166;
            --danger-color: #ef476f;
            --light-color: #f8f9fa;
            --dark-color: #212529;
        }
        
        body {
            background: linear-gradient(135deg, 
                rgba(67, 97, 238, 0.9) 0%, 
                rgba(58, 12, 163, 0.9) 50%, 
                rgba(76, 201, 240, 0.8) 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            overflow-x: hidden;
        }
        
        /* Background Animation */
        .bg-animation {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            opacity: 0.3;
        }
        
        .bg-circle {
            position: absolute;
            border-radius: 50%;
            background: radial-gradient(circle, var(--accent-color) 0%, transparent 70%);
            animation: float 20s infinite linear;
        }
        
        @keyframes float {
            0% { transform: translateY(0) rotate(0deg); }
            100% { transform: translateY(-1000px) rotate(720deg); }
        }
        
        /* Glassmorphism Card */
        .glass-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 25px 45px rgba(0, 0, 0, 0.1),
                        0 0 100px rgba(67, 97, 238, 0.1);
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
        
        .glass-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 35px 60px rgba(0, 0, 0, 0.15),
                        0 0 150px rgba(67, 97, 238, 0.2);
        }
        
        /* Header dengan gradient */
        .login-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            padding: 2.5rem;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        
        .login-header::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 50%);
            animation: rotate 20s linear infinite;
        }
        
        @keyframes rotate {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        /* Logo dan Branding */
        .brand-logo {
            position: relative;
            z-index: 2;
        }
        
        .logo-icon {
            font-size: 4rem;
            background: linear-gradient(135deg, #fff 0%, rgba(255,255,255,0.8) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 1rem;
            filter: drop-shadow(0 4px 6px rgba(0,0,0,0.1));
        }
        
        /* Form Styles */
        .form-floating {
            position: relative;
            margin-bottom: 1.5rem;
        }
        
        .form-floating label {
            color: #6c757d;
            font-weight: 500;
        }
        
        .form-control {
            border: 2px solid #e9ecef;
            border-radius: 12px;
            padding: 1rem 1.2rem;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.9);
        }
        
        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 4px rgba(67, 97, 238, 0.15);
            background: white;
        }
        
        .form-control:focus + label {
            color: var(--primary-color);
        }
        
        /* Input Icons */
        .input-group-text {
            background: transparent;
            border: 2px solid #e9ecef;
            border-right: none;
            border-radius: 12px 0 0 12px;
            color: var(--primary-color);
        }
        
        /* Button Styles */
        .btn-login {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            border: none;
            border-radius: 12px;
            padding: 1rem 2rem;
            font-size: 1.1rem;
            font-weight: 600;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(67, 97, 238, 0.3);
            color: white;
        }
        
        .btn-login:active {
            transform: translateY(0);
        }
        
        .btn-login::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: 0.5s;
        }
        
        .btn-login:hover::before {
            left: 100%;
        }
        
        /* Error Alert */
        .alert-danger {
            background: linear-gradient(135deg, #ff6b6b 0%, #ef476f 100%);
            color: white;
            border: none;
            border-radius: 12px;
            padding: 1rem 1.5rem;
            animation: shake 0.5s ease-in-out;
        }
        
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }
        
        /* Credential Info */
        .credential-box {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 12px;
            padding: 1.5rem;
            margin-top: 2rem;
            border: 2px dashed #dee2e6;
        }
        
        .credential-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.5rem 0;
            border-bottom: 1px solid rgba(0,0,0,0.05);
        }
        
        .credential-item:last-child {
            border-bottom: none;
        }
        
        /* Footer */
        .login-footer {
            text-align: center;
            padding: 1.5rem;
            color: #6c757d;
            font-size: 0.9rem;
            border-top: 1px solid rgba(0,0,0,0.05);
            background: rgba(255,255,255,0.5);
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .glass-card {
                margin: 1rem;
            }
            
            .login-header {
                padding: 2rem 1.5rem;
            }
            
            .logo-icon {
                font-size: 3rem;
            }
        }
        
        /* Custom Checkbox */
        .form-check-input:checked {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        /* Password Toggle */
        .password-toggle {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #6c757d;
            cursor: pointer;
            z-index: 10;
        }
    </style>
</head>
<body>
    <!-- Background Animation -->
    <div class="bg-animation">
        <?php for($i = 0; $i < 20; $i++): ?>
            <div class="bg-circle" style="
                width: <?php echo rand(100, 300); ?>px;
                height: <?php echo rand(100, 300); ?>px;
                top: <?php echo rand(-50, 100); ?>%;
                left: <?php echo rand(0, 100); ?>%;
                animation-delay: <?php echo $i * 0.5; ?>s;
                animation-duration: <?php echo rand(15, 25); ?>s;
                opacity: <?php echo rand(2, 8) / 10; ?>;
            "></div>
        <?php endfor; ?>
    </div>
    
    <!-- Login Container -->
    <div class="container">
        <div class="row justify-content-center align-items-center min-vh-100">
            <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                <div class="glass-card animate__animated animate__fadeInUp">
                    <!-- Header -->
                    <div class="login-header">
                        <div class="brand-logo">
                            <div class="logo-icon">
                                <i class="fas fa-microchip"></i>
                            </div>
                            <h1 class="h2 mb-2 fw-bold">SISTEM STOK ELEKTRONIK</h1>
                            <p class="mb-0 opacity-75">
                                <i class="fas fa-map-marker-alt me-1"></i>
                                Sei Batang Hari
                            </p>
                        </div>
                    </div>
                    
                    <!-- Body -->
                    <div class="p-4 p-md-5">
                        <?php if ($error): ?>
                            <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center" role="alert">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                <div class="flex-grow-1"><?php echo $error; ?></div>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>
                        
                        <h3 class="text-center mb-4 fw-bold text-dark">Masuk ke Sistem</h3>
                        
                        <form method="POST" action="" id="loginForm">
                            <!-- Username Input -->
                            <div class="form-floating mb-4">
                                <input type="text" 
                                       class="form-control" 
                                       id="username" 
                                       name="username" 
                                       placeholder="Username"
                                       required
                                       autofocus>
                                <label for="username">
                                    <i class="fas fa-user me-2"></i>Username
                                </label>
                                <div class="form-text">
                                    Masukkan username Anda
                                </div>
                            </div>
                            
                            <!-- Password Input -->
                            <div class="form-floating mb-4 position-relative">
                                <input type="password" 
                                       class="form-control" 
                                       id="password" 
                                       name="password" 
                                       placeholder="Password"
                                       required>
                                <label for="password">
                                    <i class="fas fa-lock me-2"></i>Password
                                </label>
                                <button type="button" 
                                        class="password-toggle" 
                                        onclick="togglePassword()">
                                    <i class="fas fa-eye" id="toggleIcon"></i>
                                </button>
                                <div class="form-text">
                                    Masukkan password Anda
                                </div>
                            </div>
                            
                            <!-- Remember Me & Forgot Password -->
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="rememberMe">
                                    <label class="form-check-label" for="rememberMe">
                                        Ingat saya
                                    </label>
                                </div>
                                <a href="#" class="text-decoration-none text-primary fw-medium">
                                    <i class="fas fa-key me-1"></i>Lupa password?
                                </a>
                            </div>
                            
                            <!-- Submit Button -->
                            <div class="d-grid mb-4">
                                <button type="submit" class="btn btn-login">
                                    <i class="fas fa-sign-in-alt me-2"></i>
                                    MASUK KE SISTEM
                                </button>
                            </div>
                            
                            <!-- Divider -->
                            <div class="position-relative text-center mb-4">
                                <hr>
                                <span class="position-absolute top-50 start-50 translate-middle bg-white px-3 text-muted">
                                   
                                </span>
                            </div>
                            
                            
                    
                    <!-- Footer -->
                    <div class="login-footer">
                        <div class="row align-items-center">
                            <div class="col-12">
                                <p class="mb-2">
                                    <i class="fas fa-copyright me-1"></i>
                                    <?php echo date('Y'); ?> Sistem Stok Elektronik
                                </p>
                                <small class="text-muted">
                                    <i class="fas fa-shield-alt me-1"></i>
                                    Sistem aman dan terenkripsi
                                </small>
                                <div class="mt-2">
                                    <small>
                                        <i class="fas fa-server me-1"></i>
                                        PHP <?php echo phpversion(); ?> | 
                                        <i class="fas fa-database me-1"></i>
                                        MySQL
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- WOW.js for animations -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js"></script>
    
    <script>
    // Initialize WOW.js
    new WOW().init();
    
    // Password toggle functionality
    function togglePassword() {
        const passwordInput = document.getElementById('password');
        const toggleIcon = document.getElementById('toggleIcon');
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            toggleIcon.classList.remove('fa-eye');
            toggleIcon.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            toggleIcon.classList.remove('fa-eye-slash');
            toggleIcon.classList.add('fa-eye');
        }
    }
    
    // Form validation
    document.getElementById('loginForm').addEventListener('submit', function(e) {
        const username = document.getElementById('username').value.trim();
        const password = document.getElementById('password').value.trim();
        
        if (!username || !password) {
            e.preventDefault();
            // Add shake animation to empty fields
            if (!username) {
                document.getElementById('username').classList.add('is-invalid');
                document.getElementById('username').focus();
            }
            if (!password) {
                document.getElementById('password').classList.add('is-invalid');
            }
            
            // Remove invalid class after animation
            setTimeout(() => {
                document.getElementById('username').classList.remove('is-invalid');
                document.getElementById('password').classList.remove('is-invalid');
            }, 1000);
            
            return false;
        }
        
        // Add loading state to button
        const submitBtn = document.querySelector('.btn-login');
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Memproses...';
        submitBtn.disabled = true;
        
        return true;
    });
    
    // Auto-focus username on page load
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('username').focus();
        
        // Add floating label animation
        const inputs = document.querySelectorAll('.form-control');
        inputs.forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.classList.add('focused');
            });
            
            input.addEventListener('blur', function() {
                if (!this.value) {
                    this.parentElement.classList.remove('focused');
                }
            });
            
            // Check on load
            if (input.value) {
                input.parentElement.classList.add('focused');
            }
        });
    });
    
    // Background circles interaction
    document.addEventListener('mousemove', function(e) {
        const circles = document.querySelectorAll('.bg-circle');
        const mouseX = e.clientX / window.innerWidth;
        const mouseY = e.clientY / window.innerHeight;
        
        circles.forEach((circle, index) => {
            const speed = (index + 1) * 0.5;
            const x = (mouseX * speed * 100) - 50;
            const y = (mouseY * speed * 100) - 50;
            
            circle.style.transform = `translate(${x}px, ${y}px) rotate(${index * 5}deg)`;
        });
    });
    </script>
</body>
</html>