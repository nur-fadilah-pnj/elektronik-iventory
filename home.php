<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CAHAYA ELEKTRONIK - Solusi Elektronik Terpercaya</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        :root {
            --primary: #2c3e50;
            --secondary: #3498db;
            --accent: #e74c3c;
            --gold: #f1c40f;
            --light: #f8f9fa;
            --dark: #2c3e50;
        }

        body {
            background-color: #ffffff;
            color: #333;
            line-height: 1.6;
        }

        /* Header */
        header {
            background: linear-gradient(135deg, var(--primary) 0%, #1a2530 100%);
            color: white;
            padding: 20px 0;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo h1 {
            font-size: 1.8rem;
            margin-bottom: 5px;
        }

        .logo span {
            color: var(--gold);
        }

        .logo p {
            font-size: 0.9rem;
            opacity: 0.9;
        }

        /* Navigation */
        nav ul {
            display: flex;
            list-style: none;
            gap: 30px;
        }

        nav a {
            color: white;
            text-decoration: none;
            font-weight: 500;
            padding: 8px 0;
            position: relative;
            transition: color 0.3s;
        }

        nav a:hover {
            color: var(--gold);
        }

        nav a.active {
            color: var(--gold);
        }

        nav a::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--gold);
            transition: width 0.3s;
        }

        nav a:hover::after,
        nav a.active::after {
            width: 100%;
        }

        .login-btn {
            background: var(--secondary);
            color: white;
            border: none;
            padding: 10px 25px;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 600;
            transition: background 0.3s;
        }

        .login-btn:hover {
            background: #2980b9;
        }

        /* Sections */
        section {
            padding: 80px 0;
        }

        .section-title {
            text-align: center;
            margin-bottom: 50px;
        }

        .section-title h1 {
            font-size: 2.5rem;
            color: var(--primary);
            margin-bottom: 15px;
        }

        .section-title p {
            color: #666;
            max-width: 700px;
            margin: 0 auto;
        }

        /* Hero Section */
        #beranda {
            background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), url('https://images.unsplash.com/photo-1550009158-9ebf69173e03?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80');
            background-size: cover;
            background-position: center;
            color: white;
            padding: 150px 0;
            text-align: center;
        }

        .hero-content h1 {
            font-size: 3rem;
            margin-bottom: 20px;
        }

        .hero-content p {
            font-size: 1.2rem;
            max-width: 800px;
            margin: 0 auto 30px;
            opacity: 0.9;
        }

        /* Features Section */
        #tentang {
            background: var(--light);
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
        }

        .feature-card {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            text-align: center;
        }

        .feature-card h3 {
            color: var(--primary);
            margin: 20px 0 15px;
            font-size: 1.5rem;
        }

        .feature-card p {
            color: #666;
        }

        .feature-icon {
            font-size: 2.5rem;
            color: var(--secondary);
        }

        /* Testimonials */
        .testimonials-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
        }

        .testimonial-card {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            position: relative;
        }

        .testimonial-card::before {
            content: '"';
            font-size: 4rem;
            color: var(--secondary);
            opacity: 0.2;
            position: absolute;
            top: 10px;
            left: 20px;
        }

        .testimonial-text {
            font-style: italic;
            margin-bottom: 20px;
            color: #555;
        }

        .testimonial-author {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .author-avatar {
            width: 50px;
            height: 50px;
            background: var(--secondary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 1.2rem;
        }

        .author-info h4 {
            color: var(--primary);
            margin-bottom: 5px;
        }

        .author-info p {
            color: #777;
            font-size: 0.9rem;
        }

        /* Contact Section */
        #kontak {
            background: var(--primary);
            color: white;
        }

        #kontak .section-title h1,
        #kontak .section-title p {
            color: white;
        }

        .contact-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 40px;
            max-width: 900px;
            margin: 0 auto;
        }

        .contact-item {
            display: flex;
            align-items: flex-start;
            gap: 15px;
            margin-bottom: 20px;
        }

        .contact-icon {
            font-size: 1.5rem;
            color: var(--gold);
            margin-top: 5px;
        }

        /* Footer */
        footer {
            background: #1a2530;
            color: white;
            padding: 40px 0;
            text-align: center;
        }

        .footer-content {
            max-width: 600px;
            margin: 0 auto;
        }

        .footer-content p {
            margin-bottom: 10px;
            opacity: 0.9;
        }

        .heart {
            color: var(--accent);
            animation: heartbeat 1.5s infinite;
        }

        @keyframes heartbeat {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.1); }
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            .header-content {
                flex-direction: column;
                gap: 20px;
            }
            
            nav ul {
                flex-direction: column;
                text-align: center;
                gap: 15px;
            }
            
            .hero-content h1 {
                font-size: 2.2rem;
            }
            
            section {
                padding: 60px 0;
            }
            
            .section-title h1 {
                font-size: 2rem;
            }
        }

        /* Smooth scroll behavior */
        html {
            scroll-behavior: smooth;
        }
    </style>
</head>
<body>
    <!-- Header & Navigation -->
    <header>
        <div class="container">
            <div class="header-content">
                <div class="logo">
                    <h1><span>CAHAYA</span> ELEKTRONIK</h1>
                    <p>Solusi Elektronik Terpercaya</p>
                </div>
                
                <nav>
                    <ul>
                        <li><a href="#beranda" class="active">Beranda</a></li>
                        <li><a href="#tentang">Tentang Kami</a></li>
                        <li><a href="#kontak">Kontak</a></li>
                        <li><button class="login-btn" onclick="window.location.href='login.php'">Login</button></li>
                    </ul>
                </nav>
            </div>
        </div>
    </header>

    <!-- Hero Section (Beranda) -->
    <section id="beranda">
        <div class="container">
            <div class="hero-content">
                <h1>Selamat Datang di Toko Cahaya Elektronik</h1>
                <p>Tempat terbaik untuk semua kebutuhan elektronik Anda. Dari gadget terkini hingga peralatan rumah tangga premium, kami menyediakan produk berkualitas dengan harga terbaik.</p>
                <button class="login-btn" onclick="window.location.href='login.php'" style="font-size: 1.1rem; padding: 12px 30px;">
                    <i class="fas fa-sign-in-alt"></i> Login ke Dashboard
                </button>
            </div>
        </div>
    </section>

    <!-- Tentang Kami Section -->
    <section id="tentang">
        <div class="container">
            <div class="section-title">
                <h1>Mengapa Memilih Kami?</h1>
                <p>Kami berkomitmen memberikan pengalaman belanja elektronik terbaik untuk Anda</p>
            </div>
            
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h3>Garansi Resmi</h3>
                    <p>Semua produk dilengkapi dengan garansi resmi dari distributor untuk memberikan kepastian bagi pelanggan.</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-shipping-fast"></i>
                    </div>
                    <h3>Gratis Ongkir</h3>
                    <p>Gratis pengiriman untuk pembelian di atas Rp 1.000.000 ke seluruh Indonesia dengan layanan cepat.</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-headset"></i>
                    </div>
                    <h3>Support 24/7</h3>
                    <p>Tim customer service kami siap membantu Anda kapan saja melalui berbagai channel komunikasi.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section>
        <div class="container">
            <div class="section-title">
                <h1>Apa Kata Pelanggan Kami</h1>
                <p>Testimoni dari pelanggan yang puas dengan layanan kami</p>
            </div>
            
            <div class="testimonials-grid">
                <div class="testimonial-card">
                    <div class="testimonial-text">
                        "Pelayanan sangat memuaskan! Barang sampai dengan cepat dan kondisi bagus. Garansi resmi membuat belanja di sini sangat terpercaya."
                    </div>
                    <div class="testimonial-author">
                        <div class="author-avatar">AS</div>
                        <div class="author-info">
                            <h4>Ahmad Syafii</h4>
                            <p>Pelanggan sejak 2022</p>
                        </div>
                    </div>
                </div>
                
                <div class="testimonial-card">
                    <div class="testimonial-text">
                        "Harga kompetitif dan produk original. Saya sudah beberapa kali belanja di sini untuk kebutuhan elektronik kantor, selalu puas dengan layanannya."
                    </div>
                    <div class="testimonial-author">
                        <div class="author-avatar">SD</div>
                        <div class="author-info">
                            <h4>Sari Dewi</h4>
                            <p>Business Owner</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Kontak Section -->
    <section id="kontak">
        <div class="container">
            <div class="section-title">
                <h1>Kontak Kami</h1>
                <p>Hubungi kami untuk informasi lebih lanjut</p>
            </div>
            
            <div class="contact-content">
                <div>
                    <div class="contact-item">
                        <div class="contact-icon"><i class="fas fa-map-marker-alt"></i></div>
                        <div>
                            <h3>Alamat</h3>
                            <p>Jl. Elektronik No. 123, Jakarta Pusat</p>
                        </div>
                    </div>
                    
                    <div class="contact-item">
                        <div class="contact-icon"><i class="fas fa-phone"></i></div>
                        <div>
                            <h3>Telepon</h3>
                            <p>(021) 1234-5678</p>
                        </div>
                    </div>
                </div>
                
                <div>
                    <div class="contact-item">
                        <div class="contact-icon"><i class="fas fa-envelope"></i></div>
                        <div>
                            <h3>Email</h3>
                            <p>info@cahayaelektronik.com</p>
                        </div>
                    </div>
                    
                    <div class="contact-item">
                        <div class="contact-icon"><i class="fas fa-clock"></i></div>
                        <div>
                            <h3>Jam Operasional</h3>
                            <p>Senin-Minggu, 08:00-21:00 WIB</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="footer-content">
                <p>&copy; 2026 Toko Cahaya Elektronik. Hak Cipta Dilindungi.</p>
                <p>Developed with <span class="heart">❤️</span> for better shopping experience</p>
            </div>
        </div>
    </footer>

    <script>
        // Smooth scroll dengan offset untuk header tetap
        document.querySelectorAll('nav a').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                
                const targetId = this.getAttribute('href');
                if(targetId === '#') return;
                
                const targetElement = document.querySelector(targetId);
                if(targetElement) {
                    // Hitung offset untuk header yang tetap
                    const headerHeight = document.querySelector('header').offsetHeight;
                    const targetPosition = targetElement.offsetTop - headerHeight;
                    
                    window.scrollTo({
                        top: targetPosition,
                        behavior: 'smooth'
                    });
                    
                    // Update active nav item
                    document.querySelectorAll('nav a').forEach(link => {
                        link.classList.remove('active');
                    });
                    this.classList.add('active');
                }
            });
        });
        
        // Update active nav item saat scroll
        window.addEventListener('scroll', () => {
            const sections = document.querySelectorAll('section[id]');
            const scrollPosition = window.scrollY + 100;
            
            sections.forEach(section => {
                const sectionTop = section.offsetTop;
                const sectionHeight = section.clientHeight;
                const sectionId = section.getAttribute('id');
                
                if(scrollPosition >= sectionTop && scrollPosition < sectionTop + sectionHeight) {
                    document.querySelectorAll('nav a').forEach(link => {
                        link.classList.remove('active');
                        if(link.getAttribute('href') === `#${sectionId}`) {
                            link.classList.add('active');
                        }
                    });
                }
            });
        });
        
        // Highlight active section on page load
        window.addEventListener('load', () => {
            const currentHash = window.location.hash;
            if(currentHash) {
                const targetLink = document.querySelector(`nav a[href="${currentHash}"]`);
                if(targetLink) {
                    document.querySelectorAll('nav a').forEach(link => {
                        link.classList.remove('active');
                    });
                    targetLink.classList.add('active');
                }
            }
        });
    </script>
</body>
</html>