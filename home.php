
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko Cahaya Elektronik - Solusi Elektronik Terpercaya</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', 'Segoe UI', Arial, sans-serif;
        }

        :root {
            --primary: #2c3e50;
            --secondary: #3498db;
            --accent: #e74c3c;
            --gold: #f1c40f;
            --light: #f8f9fa;
            --dark: #2c3e50;
            --gray: #7f8c8d;
        }

        body {
            background-color: #ffffff;
            color: #333;
            line-height: 1.6;
        }

        /* Header & Navigation */
        header {
            background: linear-gradient(135deg, var(--primary) 0%, #1a2530 100%);
            color: white;
            padding: 1rem 0;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .nav-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .logo-icon {
            font-size: 2rem;
            color: var(--gold);
        }

        .logo-text h1 {
            font-size: 1.5rem;
            font-weight: 700;
        }

        .logo-text span {
            color: var(--gold);
        }

        .logo-text p {
            font-size: 0.8rem;
            opacity: 0.8;
        }

        nav ul {
            display: flex;
            list-style: none;
            gap: 2rem;
        }

        nav a {
            color: white;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s;
            padding: 5px 0;
            position: relative;
        }

        nav a:hover {
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

        nav a:hover::after {
            width: 100%;
        }

        .cta-button {
            background: var(--secondary);
            color: white;
            padding: 10px 25px;
            border-radius: 30px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .cta-button:hover {
            background: #2980b9;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(52, 152, 219, 0.3);
        }

        /* Hero Section */
        .hero {
            background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), url('https://images.unsplash.com/photo-1550009158-9ebf69173e03?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80');
            background-size: cover;
            background-position: center;
            color: white;
            padding: 180px 0 120px;
            text-align: center;
            margin-top: 80px;
        }

        .hero h2 {
            font-size: 3.5rem;
            margin-bottom: 1rem;
            text-shadow: 2px 2px 10px rgba(0,0,0,0.5);
        }

        .hero p {
            font-size: 1.2rem;
            max-width: 700px;
            margin: 0 auto 2rem;
            opacity: 0.9;
        }

        .highlight {
            color: var(--gold);
            font-weight: 700;
        }

        /* Features Section */
        .features {
            padding: 80px 0;
            background: var(--light);
        }

        .section-title {
            text-align: center;
            margin-bottom: 50px;
        }

        .section-title h2 {
            font-size: 2.5rem;
            color: var(--primary);
            margin-bottom: 10px;
        }

        .section-title p {
            color: var(--gray);
            max-width: 600px;
            margin: 0 auto;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            margin-top: 40px;
        }

        .feature-card {
            background: white;
            padding: 40px 30px;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.1);
        }

        .feature-icon {
            font-size: 3rem;
            color: var(--secondary);
            margin-bottom: 20px;
        }

        .feature-card h3 {
            color: var(--primary);
            margin-bottom: 15px;
            font-size: 1.5rem;
        }

        /* Products Preview */
        .products {
            padding: 80px 0;
        }

        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
            margin-top: 40px;
        }

        .product-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
            transition: transform 0.3s;
        }

        .product-card:hover {
            transform: translateY(-10px);
        }

        .product-img {
            height: 200px;
            background: linear-gradient(45deg, #3498db, #2ecc71);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 3rem;
        }

        .product-info {
            padding: 20px;
        }

        .product-category {
            color: var(--secondary);
            font-size: 0.9rem;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .product-name {
            color: var(--primary);
            font-size: 1.2rem;
            margin-bottom: 10px;
        }

        .product-price {
            color: var(--accent);
            font-size: 1.3rem;
            font-weight: 700;
            margin-bottom: 15px;
        }

        /* Testimonials */
        .testimonials {
            padding: 80px 0;
            background: var(--light);
        }

        .testimonial-card {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            margin: 20px;
            position: relative;
        }

        .testimonial-card::before {
            content: '"';
            font-size: 5rem;
            color: var(--secondary);
            opacity: 0.2;
            position: absolute;
            top: -10px;
            left: 20px;
        }

        .testimonial-text {
            font-style: italic;
            margin-bottom: 20px;
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
        }

        /* CTA Section */
        .cta-section {
            padding: 100px 0;
            background: linear-gradient(135deg, var(--primary) 0%, #1a2530 100%);
            color: white;
            text-align: center;
        }

        .cta-section h2 {
            font-size: 2.5rem;
            margin-bottom: 20px;
        }

        .cta-section p {
            max-width: 600px;
            margin: 0 auto 40px;
            opacity: 0.9;
        }

        /* Footer */
        footer {
            background: #1a2530;
            color: white;
            padding: 60px 0 30px;
        }

        .footer-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 40px;
            margin-bottom: 40px;
        }

        .footer-column h3 {
            color: var(--gold);
            margin-bottom: 20px;
            font-size: 1.2rem;
        }

        .footer-column ul {
            list-style: none;
        }

        .footer-column ul li {
            margin-bottom: 10px;
        }

        .footer-column a {
            color: #ddd;
            text-decoration: none;
            transition: color 0.3s;
        }

        .footer-column a:hover {
            color: var(--gold);
        }

        .contact-info {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 10px;
        }

        .social-links {
            display: flex;
            gap: 15px;
            margin-top: 20px;
        }

        .social-links a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
            transition: all 0.3s;
        }

        .social-links a:hover {
            background: var(--secondary);
            transform: translateY(-3px);
        }

        .copyright {
            text-align: center;
            padding-top: 30px;
            border-top: 1px solid rgba(255,255,255,0.1);
            color: #aaa;
            font-size: 0.9rem;
        }

        /* Mobile Menu */
        .mobile-menu-btn {
            display: none;
            background: none;
            border: none;
            color: white;
            font-size: 1.5rem;
            cursor: pointer;
        }

        @media (max-width: 768px) {
            .mobile-menu-btn {
                display: block;
            }

            nav ul {
                position: fixed;
                top: 80px;
                left: -100%;
                width: 100%;
                height: calc(100vh - 80px);
                background: var(--primary);
                flex-direction: column;
                align-items: center;
                justify-content: flex-start;
                padding-top: 40px;
                transition: left 0.3s;
            }

            nav ul.active {
                left: 0;
            }

            .hero h2 {
                font-size: 2.5rem;
            }

            .hero p {
                font-size: 1rem;
                padding: 0 20px;
            }
        }
    </style>
</head>
<body>
    <!-- Header & Navigation -->
    <header>
        <div class="container">
            <div class="nav-container">
                <div class="logo">
                    <div class="logo-icon">
                        <i class="fas fa-bolt"></i>
                    </div>
                    <div class="logo-text">
                        <h1><span>CAHAYA</span> ELEKTRONIK</h1>
                        <p>Solusi Elektronik Terpercaya</p>
                    </div>
                </div>

                <button class="mobile-menu-btn" id="mobileMenuBtn">
                    <i class="fas fa-bars"></i>
                </button>

                <nav>
                    <ul id="navMenu">
                        <li><a href="#" class="active">Beranda</a></li>
                        <li><a href="#">Produk</a></li>
                        <li><a href="#">Kategori</a></li>
                        <li><a href="#">Tentang Kami</a></li>
                        <li><a href="#">Kontak</a></li>
                        <li><a href="#" class="cta-button"><i class="fas fa-sign-in-alt"></i> Login</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <h2>Selamat Datang di <span class="highlight">Toko Cahaya Elektronik</span></h2>
            <p>Tempat terbaik untuk semua kebutuhan elektronik Anda. Dari gadget terkini hingga peralatan rumah tangga premium, kami menyediakan produk berkualitas dengan harga terbaik.</p>
            <a href="#" class="cta-button"><i class="fas fa-shopping-cart"></i> Belanja Sekarang</a>
            <a href="#" class="cta-button" style="background: transparent; border: 2px solid white;"><i class="fas fa-info-circle"></i> Pelajari Lebih Lanjut</a>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features">
        <div class="container">
            <div class="section-title">
                <h2>Mengapa Memilih Kami?</h2>
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

    <!-- Products Preview -->
    <section class="products">
        <div class="container">
            <div class="section-title">
                <h2>Produk Unggulan Kami</h2>
                <p>Temukan koleksi elektronik terbaru dan terpopuler</p>
            </div>
            <div class="products-grid">
                <div class="product-card">
                    <div class="product-img">
                        <i class="fas fa-laptop"></i>
                    </div>
                    <div class="product-info">
                        <div class="product-category">LAPTOP & KOMPUTER</div>
                        <h3 class="product-name">MacBook Air M2</h3>
                        <div class="product-price">Rp 18.500.000</div>
                        <a href="#" class="cta-button" style="padding: 8px 20px; font-size: 0.9rem;">Detail</a>
                    </div>
                </div>
                <div class="product-card">
                    <div class="product-img">
                        <i class="fas fa-mobile-alt"></i>
                    </div>
                    <div class="product-info">
                        <div class="product-category">SMARTPHONE</div>
                        <h3 class="product-name">iPhone 15 Pro Max</h3>
                        <div class="product-price">Rp 24.999.000</div>
                        <a href="#" class="cta-button" style="padding: 8px 20px; font-size: 0.9rem;">Detail</a>
                    </div>
                </div>
                <div class="product-card">
                    <div class="product-img">
                        <i class="fas fa-tv"></i>
                    </div>
                    <div class="product-info">
                        <div class="product-category">TELEVISI</div>
                        <h3 class="product-name">Samsung QLED 4K 55"</h3>
                        <div class="product-price">Rp 12.750.000</div>
                        <a href="#" class="cta-button" style="padding: 8px 20px; font-size: 0.9rem;">Detail</a>
                    </div>
                </div>
                <div class="product-card">
                    <div class="product-img">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="product-info">
                        <div class="product-category">AKSESORIS</div>
                        <h3 class="product-name">Smart Watch Pro</h3>
                        <div class="product-price">Rp 3.500.000</div>
                        <a href="#" class="cta-button" style="padding: 8px 20px; font-size: 0.9rem;">Detail</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section class="testimonials">
        <div class="container">
            <div class="section-title">
                <h2>Apa Kata Pelanggan Kami</h2>
                <p>Testimoni dari pelanggan yang puas dengan layanan kami</p>
            </div>
            <div class="features-grid">
                <div class="testimonial-card">
                    <div class="testimonial-text">
                        "Pelayanan sangat memuaskan! Barang sampai dengan cepat dan kondisi bagus. Garansi resmi membuat belanja di sini sangat terpercaya."
                    </div>
                    <div class="testimonial-author">
                        <div class="author-avatar">AS</div>
                        <div>
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
                        <div>
                            <h4>Sari Dewi</h4>
                            <p>Business Owner</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container">
            <h2>Siap Memulai Pengalaman Belanja Elektronik Terbaik?</h2>
            <p>Bergabunglah dengan ribuan pelanggan yang telah mempercayai kebutuhan elektronik mereka pada kami. Kualitas terjamin, harga terbaik.</p>
            <a href="#" class="cta-button"><i class="fas fa-user-plus"></i> Daftar Sekarang</a>
            <a href="#" class="cta-button" style="background: transparent; border: 2px solid white; margin-left: 15px;"><i class="fas fa-phone-alt"></i> Hubungi Kami</a>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="footer-content">
                <div class="footer-column">
                    <h3>Toko Cahaya Elektronik</h3>
                    <p>Solusi lengkap untuk semua kebutuhan elektronik Anda. Berpengalaman sejak 2010 melayani pelanggan dengan produk berkualitas dan layanan terbaik.</p>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-whatsapp"></i></a>
                    </div>
                </div>
                <div class="footer-column">
                    <h3>Menu Cepat</h3>
                    <ul>
                        <li><a href="#">Beranda</a></li>
                        <li><a href="#">Produk Elektronik</a></li>
                        <li><a href="#">Promo & Diskon</a></li>
                        <li><a href="#">Tentang Kami</a></li>
                        <li><a href="#">Syarat & Ketentuan</a></li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h3>Kontak Kami</h3>
                    <div class="contact-info">
                        <i class="fas fa-map-marker-alt"></i>
                        <span>Jl. Elektronik No. 123, Jakarta Pusat</span>
                    </div>
                    <div class="contact-info">
                        <i class="fas fa-phone"></i>
                        <span>(021) 1234-5678</span>
                    </div>
                    <div class="contact-info">
                        <i class="fas fa-envelope"></i>
                        <span>info@cahayaelektronik.com</span>
                    </div>
                    <div class="contact-info">
                        <i class="fas fa-clock"></i>
                        <span>Buka: Senin-Minggu, 08:00-21:00 WIB</span>
                    </div>
                </div>
            </div>
            <div class="copyright">
                <p>&copy; 2026 Toko Cahaya Elektronik. Hak Cipta Dilindungi.</p>
                <p>Developed with <i class="fas fa-heart" style="color: #e74c3c;"></i> for better shopping experience</p>
            </div>
        </div>
    </footer>

    <script>
        // Mobile Menu Toggle
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        const navMenu = document.getElementById('navMenu');
        
        mobileMenuBtn.addEventListener('click', () => {
            navMenu.classList.toggle('active');
            mobileMenuBtn.innerHTML = navMenu.classList.contains('active') 
                ? '<i class="fas fa-times"></i>' 
                : '<i class="fas fa-bars"></i>';
        });
        
        // Close mobile menu when clicking outside
        document.addEventListener('click', (e) => {
            if (!navMenu.contains(e.target) && !mobileMenuBtn.contains(e.target)) {
                navMenu.classList.remove('active');
                mobileMenuBtn.innerHTML = '<i class="fas fa-bars"></i>';
            }
        });
        
        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const targetId = this.getAttribute('href');
                if(targetId === '#') return;
                
                const targetElement = document.querySelector(targetId);
                if(targetElement) {
                    window.scrollTo({
                        top: targetElement.offsetTop - 80,
                        behavior: 'smooth'
                    });
                    
                    // Close mobile menu if open
                    navMenu.classList.remove('active');
                    mobileMenuBtn.innerHTML = '<i class="fas fa-bars"></i>';
                }
            });
        });
        
        // Add scroll effect to header
        window.addEventListener('scroll', () => {
            const header = document.querySelector('header');
            if(window.scrollY > 100) {
                header.style.background = 'rgba(44, 62, 80, 0.95)';
                header.style.backdropFilter = 'blur(10px)';
            } else {
                header.style.background = 'linear-gradient(135deg, var(--primary) 0%, #1a2530 100%)';
                header.style.backdropFilter = 'none';
            }
        });
    </script>
</body>
</html>