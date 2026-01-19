<?php
session_start();
require 'db.php'; // Pastikan file db.php tersedia
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>KOARA Apparel - Future Sportswear Laboratory</title>

  <!-- Favicon -->
  <link href="logo.png" rel="icon" type="image/png">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700;900&family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
  
  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

  <style>
    :root {
      --primary: #00f2ff; /* Cyan Neon */
      --secondary: #0048ff; /* Deep Blue */
      --dark-bg: #050505;
      --glass-bg: rgba(255, 255, 255, 0.03);
      --glass-border: rgba(255, 255, 255, 0.08);
      --glass-blur: blur(20px);
    }

    body {
      background-color: var(--dark-bg);
      color: #e0e0e0;
      font-family: 'Poppins', sans-serif;
      overflow-x: hidden;
      scroll-behavior: smooth;
    }

    /* Mouse Glow Effect */
    #mouse-glow {
      position: fixed;
      width: 400px;
      height: 400px;
      background: radial-gradient(circle, rgba(0, 242, 255, 0.07) 0%, transparent 70%);
      border-radius: 50%;
      pointer-events: none;
      z-index: 9999;
      transform: translate(-50%, -50%);
      transition: width 0.3s, height 0.3s;
    }

    /* Scrollbar */
    ::-webkit-scrollbar { width: 8px; }
    ::-webkit-scrollbar-track { background: #000; }
    ::-webkit-scrollbar-thumb { background: linear-gradient(to bottom, var(--secondary), var(--primary)); border-radius: 4px; }

    /* Typography */
    h1, h2, h3, h4, h5, .brand-font {
      font-family: 'Orbitron', sans-serif;
      text-transform: uppercase;
      letter-spacing: 2px;
    }

    /* Reveal Animation Logic */
    .reveal {
      position: relative;
      transform: translateY(50px);
      opacity: 0;
      transition: all 0.8s ease-out;
    }
    .reveal.active {
      transform: translateY(0);
      opacity: 1;
    }

    /* Background Slideshow */
    .slideshow-bg {
      position: fixed; top: 0; left: 0; width: 100%; height: 100vh; z-index: -2;
    }
    .slide-item {
      position: absolute; width: 100%; height: 100%; background-size: cover; background-position: center;
      opacity: 0; transform: scale(1.1); animation: slideAnim 18s infinite;
    }
    .overlay-dark {
      position: fixed; top: 0; left: 0; width: 100%; height: 100%;
      background: radial-gradient(circle at center, transparent 0%, #000 90%), 
                  linear-gradient(to bottom, rgba(0,0,0,0.4), #050505);
      z-index: -1;
    }
    .slide-item:nth-child(1) { background-image: url('DSC09123.jpg'); animation-delay: 0s; }
    .slide-item:nth-child(2) { background-image: url('SWP03277.JPG'); animation-delay: 6s; }
    .slide-item:nth-child(3) { background-image: url('SWP03280.JPG'); animation-delay: 12s; }

    @keyframes slideAnim {
      0% { opacity: 0; transform: scale(1.1); }
      10% { opacity: 0.6; transform: scale(1); }
      33% { opacity: 0.6; transform: scale(1); }
      43% { opacity: 0; transform: scale(1.15); }
      100% { opacity: 0; }
    }

    /* Navbar */
    .navbar {
      background: transparent;
      padding: 20px 0;
      transition: 0.5s;
    }
    .navbar.scrolled {
      background: rgba(5, 5, 5, 0.9);
      backdrop-filter: blur(15px);
      padding: 12px 0;
      border-bottom: 1px solid var(--glass-border);
    }
    .navbar-brand { font-weight: 800; color: #fff !important; }
    .nav-link {
      color: #bbb !important; font-family: 'Orbitron'; font-size: 0.8rem; margin: 0 10px;
    }
    .nav-link:hover, .nav-link.active { color: var(--primary) !important; text-shadow: 0 0 10px var(--primary); }

    .btn-login-nav {
      background: transparent; border: 1px solid var(--primary); color: var(--primary);
      padding: 8px 20px; font-family: 'Orbitron'; font-size: 0.75rem; transition: 0.3s;
    }
    .btn-login-nav:hover { background: var(--primary); color: #000; box-shadow: 0 0 20px var(--primary); }

    /* Hero */
    .hero-section {
      min-height: 100vh; display: flex; align-items: center; justify-content: center;
      text-align: center; padding-top: 80px;
    }
    .hero-title { font-size: clamp(2.5rem, 8vw, 4.5rem); font-weight: 900; margin-bottom: 20px; }
    .hero-title span {
      background: linear-gradient(90deg, #fff, var(--primary), var(--secondary));
      -webkit-background-clip: text; -webkit-text-fill-color: transparent;
    }
    .hero-text { color: #aaa; max-width: 700px; margin: 0 auto 40px; font-size: 1.1rem; line-height: 1.8; }

    .btn-glow {
      display: inline-block; background: var(--primary); color: #000; padding: 18px 45px;
      font-weight: 800; font-family: 'Orbitron'; text-decoration: none;
      clip-path: polygon(10% 0, 100% 0, 100% 70%, 90% 100%, 0% 100%, 0% 30%);
      transition: 0.4s;
    }
    .btn-glow:hover { transform: translateY(-5px); box-shadow: 0 0 30px var(--primary); color: #000; }

    /* Stats Section */
    .stat-box { text-align: center; padding: 20px; }
    .stat-number { font-size: 3rem; font-weight: 900; color: var(--primary); display: block; font-family: 'Orbitron'; }
    .stat-label { font-size: 0.75rem; text-transform: uppercase; letter-spacing: 2px; color: #888; }

    /* Services & Features */
    section { padding: 100px 0; }
    .section-title { text-align: center; margin-bottom: 60px; font-size: 2.5rem; }
    .section-title span { color: var(--primary); }

    .service-box {
      background: var(--glass-bg); border: 1px solid var(--glass-border);
      padding: 40px; border-radius: 15px; height: 100%; transition: 0.4s;
      backdrop-filter: var(--glass-blur); text-align: center;
    }
    .service-box:hover { 
      border-color: var(--primary); transform: translateY(-10px); 
      box-shadow: 0 10px 30px rgba(0, 242, 255, 0.1);
    }
    .service-icon { font-size: 3rem; margin-bottom: 20px; color: var(--primary); }

    .feature-icon-circle {
      width: 80px; height: 80px; background: rgba(0, 242, 255, 0.1);
      border: 1px solid var(--primary); border-radius: 50%; margin: 0 auto 20px;
      display: flex; align-items: center; justify-content: center; font-size: 2rem; color: var(--primary);
    }

    /* Product Card */
    .product-card {
      background: #0a0a0a; border: 1px solid #1a1a1a; transition: 0.3s; height: 100%;
    }
    .product-card:hover { border-color: var(--primary); }
    .product-img-wrapper { overflow: hidden; height: 350px; }
    .product-img { width: 100%; height: 100%; object-fit: cover; transition: 0.5s; }
    .product-card:hover .product-img { transform: scale(1.05); }
    .btn-product {
      width: 100%; border: 1px solid #333; background: transparent; color: #fff;
      padding: 10px; font-family: 'Orbitron'; font-size: 0.8rem; transition: 0.3s; text-decoration: none; display: block;
    }
    .btn-product:hover { background: #fff; color: #000; }

    /* Slider (Real Results) */
    .slider-section { background: #000; padding: 80px 0; border-top: 1px solid #111; border-bottom: 1px solid #111; }
    .slider-track {
      display: flex; gap: 20px; animation: scrollRight 30s linear infinite; width: max-content;
    }
    .slide { width: 280px; height: 380px; flex-shrink: 0; }
    .slide img { 
        width: 100%; height: 100%; object-fit: cover; border-radius: 8px; 
        filter: grayscale(1); transition: 0.4s; border: 1px solid #222;
    }
    .slide img:hover { filter: grayscale(0); border-color: var(--primary); }
    @keyframes scrollRight { 0% { transform: translateX(0); } 100% { transform: translateX(-50%); } }

    /* FAQ Accordion */
    .accordion-item { background: var(--glass-bg) !important; border: 1px solid var(--glass-border) !important; margin-bottom: 10px; border-radius: 10px !important; overflow: hidden; }
    .accordion-button { background: transparent !important; color: #fff !important; font-family: 'Orbitron'; font-size: 0.9rem; border: none !important; }
    .accordion-button:not(.collapsed) { color: var(--primary) !important; box-shadow: none; }
    .accordion-body { color: #aaa; background: rgba(255,255,255,0.02); }

    /* Floating WA */
    .floating-wa {
      position: fixed; bottom: 30px; right: 30px; width: 60px; height: 60px;
      background: #25d366; color: white; border-radius: 50%; display: flex;
      align-items: center; justify-content: center; font-size: 30px;
      box-shadow: 0 0 20px rgba(37, 211, 102, 0.4); z-index: 999; transition: 0.3s; text-decoration: none;
    }
    .floating-wa:hover { transform: scale(1.1); color: white; box-shadow: 0 0 30px rgba(37, 211, 102, 0.6); }

    /* Contact & Footer */
    iframe { width: 100%; height: 350px; filter: grayscale(1) invert(0.9); border: 1px solid #222; }
    footer { padding: 50px 0; border-top: 1px solid #111; text-align: center; background: #020202; }

    @media (max-width: 768px) {
      .hero-title { font-size: 2.5rem; }
      .section-title { font-size: 1.8rem; }
      section { padding: 60px 0; }
      .floating-wa { bottom: 20px; right: 20px; width: 50px; height: 50px; font-size: 24px; }
    }
  </style>
</head>
<body>

  <!-- MOUSE GLOW -->
  <div id="mouse-glow"></div>

  <!-- BACKGROUND SLIDESHOW -->
  <div class="slideshow-bg">
    <div class="slide-item"></div>
    <div class="slide-item"></div>
    <div class="slide-item"></div>
  </div>
  <div class="overlay-dark"></div>

  <!-- NAVBAR -->
  <nav class="navbar navbar-expand-lg fixed-top" id="mainNav">
    <div class="container">
      <a class="navbar-brand" href="#">
        <img src="logo.png" alt="Logo" height="30" class="me-2"> KOARA
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" style="filter: invert(1);">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav align-items-center">
          <li class="nav-item"><a class="nav-link active" href="#home">Home</a></li>
          <li class="nav-item"><a class="nav-link" href="#layanan">Services</a></li>
          <li class="nav-item"><a class="nav-link" href="#produk">Collection</a></li>
          <li class="nav-item"><a class="nav-link" href="#kontak">Contact</a></li>
          <li class="nav-item ms-lg-3 mt-3 mt-lg-0">
            <?php if(isset($_SESSION['user_id'])): ?>
                <a href="dashboard.php" class="btn btn-login-nav">DASHBOARD</a>
            <?php else: ?>
                <a href="login.php" class="btn btn-login-nav">LOGIN / JOIN</a>
            <?php endif; ?>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- HERO SECTION -->
  <section class="hero-section" id="home">
    <div class="container reveal">
      <h1 class="hero-title">JERSEY MASA DEPAN<br><span>DI TANGANMU</span></h1>
      <p class="hero-text">
        Paduan teknologi printing mutakhir dengan material premium kelas dunia. 
        Wujudkan identitas timmu bersama KOARA Apparel.
      </p>
      <div class="d-flex justify-content-center gap-3 flex-wrap">
        <a href="login.php" class="btn-glow">MULAI PROYEK DESAIN</a>
      </div>
    </div>
  </section>

  <!-- STATS COUNTER -->
  <section class="py-5" style="background: rgba(0,0,0,0.4); border-top: 1px solid var(--glass-border);">
    <div class="container">
        <div class="row g-4">
            <div class="col-6 col-md-3 reveal">
                <div class="stat-box">
                    <span class="stat-number">1.2K+</span>
                    <span class="stat-label">Teams Trusted</span>
                </div>
            </div>
            <div class="col-6 col-md-3 reveal">
                <div class="stat-box">
                    <span class="stat-number">45K+</span>
                    <span class="stat-label">Jersey Produced</span>
                </div>
            </div>
            <div class="col-6 col-md-3 reveal">
                <div class="stat-box">
                    <span class="stat-number">99%</span>
                    <span class="stat-label">Satisfaction Rate</span>
                </div>
            </div>
            <div class="col-6 col-md-3 reveal">
                <div class="stat-box">
                    <span class="stat-number">24H</span>
                    <span class="stat-label">Pro Design Support</span>
                </div>
            </div>
        </div>
    </div>
  </section>

  <!-- LAYANAN SECTION -->
  <section id="layanan">
    <div class="container">
      <h2 class="section-title reveal">ORDER <span>GATEWAY</span></h2>
      <div class="row g-4">
        <div class="col-md-4 reveal">
          <a href="https://wa.me/6287839493882" target="_blank" class="text-decoration-none">
            <div class="service-box">
              <i class="fab fa-whatsapp service-icon"></i>
              <h4>WhatsApp Support</h4>
              <p class="text-muted small">Diskusi langsung dengan spesialis produksi kami untuk hasil terbaik.</p>
            </div>
          </a>
        </div>
        <div class="col-md-4 reveal">
          <a href="https://shopee.co.id/koara_sportwear" target="_blank" class="text-decoration-none">
            <div class="service-box">
              <i class="fas fa-shopping-cart service-icon"></i>
              <h4>Shopee Store</h4>
              <p class="text-muted small">Kemudahan transaksi dan keamanan belanja melalui marketplace official.</p>
            </div>
          </a>
        </div>
        <div class="col-md-4 reveal">
          <a href="https://www.instagram.com/koarasportwear" target="_blank" class="text-decoration-none">
            <div class="service-box">
              <i class="fab fa-instagram service-icon"></i>
              <h4>Instagram</h4>
              <p class="text-muted small">Update portofolio terbaru dan inspirasi desain setiap hari.</p>
            </div>
          </a>
        </div>
      </div>
    </div>
  </section>

  <!-- CORE TECHNOLOGY (USP) -->
  <section id="tech" style="background: rgba(0,0,0,0.3);">
    <div class="container text-center">
        <h2 class="section-title reveal">CORE <span>TECHNOLOGY</span></h2>
        <div class="row g-4 justify-content-center">
            <div class="col-md-3 col-sm-6 reveal">
                <div class="feature-icon-circle"><i class="fas fa-wind"></i></div>
                <h6 class="mb-2">Aero-Breathe</h6>
                <p class="small text-muted">Sirkulasi udara maksimal menjaga tubuh tetap dingin saat intensitas tinggi.</p>
            </div>
            <div class="col-md-3 col-sm-6 reveal">
                <div class="feature-icon-circle"><i class="fas fa-shield-virus"></i></div>
                <h6 class="mb-2">Anti-Bacterial</h6>
                <p class="small text-muted">Serat kain khusus yang mencegah pertumbuhan bakteri penyebab bau.</p>
            </div>
            <div class="col-md-3 col-sm-6 reveal">
                <div class="feature-icon-circle"><i class="fas fa-tint-slash"></i></div>
                <h6 class="mb-2">Hydro-Dry</h6>
                <p class="small text-muted">Teknologi cepat serap keringat yang menguap dalam hitungan detik.</p>
            </div>
            <div class="col-md-3 col-sm-6 reveal">
                <div class="feature-icon-circle"><i class="fas fa-palette"></i></div>
                <h6 class="mb-2">Deep-Ink Neo</h6>
                <p class="small text-muted">Warna printing lebih tajam, solid, dan tidak akan pernah luntur.</p>
            </div>
        </div>
    </div>
  </section>

  <!-- PRODUK SECTION -->
  <section id="produk" style="background: rgba(10,10,10,0.5);">
    <div class="container">
      <h2 class="section-title reveal">LATEST <span>DROPS</span></h2>
      <div class="row g-4">
        <?php
        $query = "SELECT * FROM products ORDER BY id DESC LIMIT 3";
        $result = mysqli_query($conn, $query);
        if($result && mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
        ?>
            <div class="col-md-4 reveal">
              <div class="product-card">
                <div class="product-img-wrapper">
                   <img src="uploads/<?= $row['image'] ?>" class="product-img" alt="<?= $row['name'] ?>">
                </div>
                <div class="p-4 text-center">
                  <h6 class="mb-1"><?= $row['name'] ?></h6>
                  <p class="text-primary small mb-3">Rp <?= number_format($row['price']) ?></p>
                  <a href="product_detail.php?id=<?= $row['id'] ?>" class="btn-product">DETAIL PRODUK</a>
                </div>
              </div>
            </div>
        <?php 
            }
        } else {
            echo "<p class='text-center text-muted'>Belum ada produk terbaru.</p>";
        }
        ?>
      </div>
    </div>
  </section>

  <!-- REAL RESULTS (Infinite Scroll) -->
  <section class="slider-section">
    <div class="container-fluid overflow-hidden">
        <h2 class="section-title reveal">REAL <span>PROJECTS</span></h2>
        <div class="slider-track">
            <!-- Set 1 -->
            <div class="slide"><img src="DSC07455.jpg"></div>
            <div class="slide"><img src="DSC07390.jpg"></div>
            <div class="slide"><img src="DSC07424.jpg"></div>
            <div class="slide"><img src="DSC07433.jpg"></div>
            <div class="slide"><img src="DSC07402.jpg"></div>
            <!-- Set 2 (Duplikasi untuk efek loop) -->
            <div class="slide"><img src="DSC07455.jpg"></div>
            <div class="slide"><img src="DSC07390.jpg"></div>
            <div class="slide"><img src="DSC07424.jpg"></div>
            <div class="slide"><img src="DSC07433.jpg"></div>
            <div class="slide"><img src="DSC07402.jpg"></div>
        </div>
    </div>
  </section>

  <!-- FAQ SECTION -->
  <section id="faq">
    <div class="container">
      <h2 class="section-title reveal">F.A.<span>Q</span></h2>
      <div class="row justify-content-center">
        <div class="col-md-8 reveal">
          <div class="accordion" id="faqAccordion">
            <div class="accordion-item">
              <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                  Berapa minimal order jersey custom?
                </button>
              </h2>
              <div id="faq1" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                  Minimal pemesanan untuk jersey custom adalah 12 pcs. Untuk pemesanan di atas 50 pcs, Anda akan mendapatkan harga spesial vendor.
                </div>
              </div>
            </div>
            <div class="accordion-item">
              <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                  Berapa lama proses pengerjaannya?
                </button>
              </h2>
              <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                  Waktu produksi standar adalah 10-14 hari kerja setelah desain disetujui. Kami juga menyediakan layanan kilat 7 hari kerja.
                </div>
              </div>
            </div>
            <div class="accordion-item">
              <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                  Apakah bisa dibantu buatkan desain?
                </button>
              </h2>
              <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                  Tentu! Tim desainer profesional kami siap membantu mewujudkan konsep Anda secara gratis untuk setiap pemesanan minimal order.
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- KONTAK SECTION -->
  <section id="kontak">
    <div class="container reveal">
      <div class="row align-items-center g-5">
        <div class="col-md-5">
            <h2 class="mb-4">LET'S <span>CONNECT</span></h2>
            <div class="mb-4">
                <p class="mb-2 text-primary font-monospace">LOKASI WORKSHOP</p>
                <p class="text-muted">Kupatan, Gang Blimbing II, RT.04/RW.09, Kedungsari, Kec. Magelang Utara, Kota Magelang, Jawa Tengah 56114</p>
            </div>
            <div class="mb-4">
                <p class="mb-2 text-primary font-monospace">HUBUNGI KAMI</p>
                <p class="text-muted">Email: koarasportwear@gmail.com <br>Phone: +62 878 3949 3882</p>
            </div>
            <div class="mt-4">
                <a href="#" class="text-white me-3 fs-4"><i class="fab fa-facebook"></i></a>
                <a href="#" class="text-white me-3 fs-4"><i class="fab fa-tiktok"></i></a>
                <a href="#" class="text-white fs-4"><i class="fab fa-youtube"></i></a>
            </div>
        </div>
        <div class="col-md-7">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3442.5989334144074!2d110.22385685436174!3d-7.443090576742143!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7a85eed6ad3a4d%3A0x972c5a14053a5648!2sKOARA%20SPORTWEAR!5e0!3m2!1sid!2sid!4v1768286720486!5m2!1sid!2sid" allowfullscreen loading="lazy"></iframe>
        </div>
      </div>
    </div>
  </section>

  <!-- FLOATING WHATSAPP -->
  <a href="https://wa.me/6287839493882" class="floating-wa" target="_blank">
    <i class="fab fa-whatsapp"></i>
  </a>

  <!-- FOOTER -->
  <footer>
    <div class="container">
      <img src="logo.png" height="40" class="mb-3 opacity-50">
      <p class="small text-muted mb-2">&copy; 2025 KOARA APPAREL. FUTURE SPORTWEAR LABORATORY.</p>
      <div class="small text-muted">Made with <i class="fas fa-heart text-danger"></i> for Athletes.</div>
    </div>
  </footer>

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
      // Mouse Glow tracking
      const glow = document.getElementById('mouse-glow');
      window.addEventListener('mousemove', (e) => {
          glow.style.left = e.clientX + 'px';
          glow.style.top = e.clientY + 'px';
      });

      // Navbar scroll effect
      window.addEventListener('scroll', function() {
          const nav = document.getElementById('mainNav');
          if (window.scrollY > 50) {
              nav.classList.add('scrolled');
          } else {
              nav.classList.remove('scrolled');
          }
      });

      // Reveal animation on scroll
      function reveal() {
          var reveals = document.querySelectorAll('.reveal');
          for (var i = 0; i < reveals.length; i++) {
              var windowHeight = window.innerHeight;
              var elementTop = reveals[i].getBoundingClientRect().top;
              var elementVisible = 100;
              if (elementTop < windowHeight - elementVisible) {
                  reveals[i].classList.add('active');
              }
          }
      }
      window.addEventListener('scroll', reveal);
      reveal(); // Run once on load
  </script>
</body>
</html>