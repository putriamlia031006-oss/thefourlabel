<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>THE FOUR LABEL | Tentang Kami</title>

    <link rel="stylesheet" href="bootstrap-5.3.8-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="fontawesome/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css">

    <style>
        /* --- TEMA LAVENDER CUSTOM --- */
        :root {
            --lavender-primary: #967BB6; /* Lavender Tua */
            --lavender-light: #E6E6FA;   /* Lavender Muda */
            --lavender-dark: #6A5ACD;    /* Slate Blue/Lavender Gelap */
        }

        body {
            background-color: #F8F7FF !important; /* Background sangat muda keunguan */
        }

        .text-primary {
            color: var(--lavender-primary) !important;
        }

        .bg-primary {
            background-color: var(--lavender-primary) !important;
        }

        /* Border garis bawah judul */
        .title-full-line {
            display: inline-block;
            position: relative;
            padding-bottom: 10px;
            border-bottom: 3px solid var(--lavender-primary);
        }

        /* Border khusus untuk profile pic */
        .warna-lavender {
            border-color: var(--lavender-light) !important;
        }

        /* Progress Bar Lavender */
        .progress-bar {
            background-color: var(--lavender-primary) !important;
        }

        /* Overlay Parallax Nuansa Lavender */
        .overlay-mf {
            background-color: rgba(106, 90, 205, 0.7) !important; /* Lavender Gelap transparan */
        }

        /* Styling box shadow agar lebih lembut */
        .box-shadow-full {
            background-color: #fff;
            padding: 3rem;
            position: relative;
            margin-bottom: 3rem;
            box-shadow: 0 1px 1px 0 rgba(150, 123, 182, 0.1), 0 10px 20px 0 rgba(150, 123, 182, 0.15);
            border-radius: 15px;
        }

        /* Custom Bullet Swiper */
        .swiper-pagination-bullet-active {
            background: var(--lavender-light) !important;
        }

        .title-left::before {
            background-color: var(--lavender-primary) !important;
        }

        /* Hero Banner Gradient */
        .benner2 {
            background: linear-gradient(rgba(150, 123, 182, 0.8), rgba(106, 90, 205, 0.8)), url('image/benner2.jpeg');
            background-size: cover;
            background-position: center;
            height: 60vh;
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/typed.js@2.0.12"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            new Typed(".typed", {
                strings: [
                    "Cindi Setio Rhamadani",
                    "Khanza Afifah Karina Putri",
                    "Putri Amalia Ramadani",
                    "Putri Sofiatun Muzofar"
                ],
                typeSpeed: 80,
                backSpeed: 40,
                backDelay: 2000,
                loop: true
            });
        });
    </script>
</head>

<body>

<?php require "navbar.php"; ?>

<div class="container-fluid benner d-flex align-items-center justify-content-center">
    <div class="container text-white text-center hero-content">
        <h1 class="display-1 fw-bold mb-3 text-white">THE FOUR LABEL</h1>
        <p class="fs-3 fst-italic"><span class="typed"></span></p>
    </div>
</div>

<section id="about" class="py-5 about-mf">
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-lg-11">

                <div class="box-shadow-full mb-5">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <div class="title-box-2 mb-4 text-center">
                                <h5 class="title-full-line text-uppercase fw-bold">Tentang Konveksi THE FOUR LABEL</h5>
                            </div>
                        </div>
                        <div class="col-md-4 text-center mb-4 mb-md-0">
                            <div class="about-img">
                                <i class="fas fa-shopping-bag text-primary" style="font-size: 150px;"></i>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <p class="lead mb-3">
                                <strong>Konveksi THE FOUR LABEL</strong> adalah destinasi pilihan bagi Anda yang mencari koleksi fashion terkini dengan kualitas terbaik. Kami hadir dengan semangat Lavender yang menenangkan namun elegan untuk memberikan pengalaman berbelanja yang terpercaya.
                            </p>
                            <div class="row pt-2 text-center text-md-start">
                                <div class="col-sm-4">
                                    <h6 class="fw-bold"><i class="fas fa-star text-warning me-2"></i>Kualitas Premium</h6>
                                </div>
                                <div class="col-sm-4">
                                    <h6 class="fw-bold"><i class="fas fa-truck text-primary me-2"></i>Pengiriman Cepat</h6>
                                </div>
                                <div class="col-sm-4">
                                    <h6 class="fw-bold"><i class="fas fa-tags text-danger me-2"></i>Harga Kompetitif</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="box-shadow-full mb-5">
                    <div class="row align-items-start"> 
                        <div class="col-md-5 border-end pe-md-4">
                            <div class="about-img text-center">
                                <img src="image/cindi.jpeg" class="img-fluid rounded-4 shadow-sm border border-3 warna-lavender" alt="Cindi" style="width: 280px; height: 380px; object-fit: cover;">
                            </div>
                            <div class="skill-mf mt-4 px-3">
                                <p class="title-s mb-2 fw-bold">My Expertise</p>
                                <span>HTML</span> <span class="pull-right text-muted small">99%</span>
                                <div class="progress mb-2" style="height: 10px;"><div class="progress-bar" style="width: 99%"></div></div>
                                <span>CSS3</span> <span class="pull-right text-muted small">99%</span>
                                <div class="progress mb-2" style="height: 10px;"><div class="progress-bar" style="width: 99%"></div></div>
                                <span>PHP</span> <span class="pull-right text-muted small">99%</span>
                                <div class="progress" style="height: 10px;"><div class="progress-bar" style="width: 99%"></div></div>
                            </div>
                        </div>
                        <div class="col-md-7 ps-md-5 mt-3 mt-md-0 pt-md-2"> 
                            <div class="title-box-2 mb-4">
                                <h5 class="title-left text-uppercase fw-bold">About Me</h5>
                            </div>
                            <p class="lead mb-3">Saya memiliki ketertarikan yang besar terhadap dunia fashion, khususnya pada gaya kasual modern nuansa lavender yang mengutamakan kenyamanan tanpa mengesampingkan estetika.</p>
                            <p class="lead">Saya percaya bahwa outfit yang baik adalah outfit yang membuat pemakainya merasa percaya diri.</p>
                        </div>
                    </div>
                </div>

                <div class="box-shadow-full mb-5">
                    <div class="row align-items-start"> 
                        <div class="col-md-7 pe-md-5 order-2 order-md-1 mt-3 mt-md-0 pt-md-2">
                            <div class="title-box-2 mb-4">
                                <h5 class="title-left text-uppercase fw-bold">About Me</h5>
                            </div>
                            <p class="lead mb-3">Minat saya di dunia fashion berfokus pada fashion pria dengan konsep smart casual. Saya melihat fashion sebagai bagian dari identitas diri yang mampu merepresentasikan karakter.</p>
                            <p class="lead">Bagi saya, fashion bukan hanya tentang mengikuti tren, tetapi tentang memahami proporsi dan kenyamanan.</p>
                        </div>
                        <div class="col-md-5 border-start ps-md-4 order-1 order-md-2">
                            <div class="about-img text-center">
                                <img src="image/kanja.jpg" class="img-fluid rounded-4 shadow-sm border border-3 warna-lavender" alt="Mahesa" style="width: 280px; height: 380px; object-fit: cover;">
                            </div>
                            <div class="skill-mf mt-4 px-3 text-start">
                                <p class="title-s mb-2 fw-bold">My Expertise</p>
                                <span>HTML</span> <span class="pull-right text-muted small">99%</span>
                                <div class="progress mb-2" style="height: 10px;"><div class="progress-bar" style="width: 99%"></div></div>
                                <span>CSS3</span> <span class="pull-right text-muted small">99%</span>
                                <div class="progress mb-2" style="height: 10px;"><div class="progress-bar" style="width: 99%"></div></div>
                                <span>PHP</span> <span class="pull-right text-muted small">99%</span>
                                <div class="progress" style="height: 10px;"><div class="progress-bar" style="width: 99%"></div></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="box-shadow-full mb-5">
                    <div class="row align-items-start"> 
                        <div class="col-md-5 border-end pe-md-4">
                            <div class="about-img text-center">
                                <img src="image/putri.jpeg" class="img-fluid rounded-4 shadow-sm border border-3 warna-lavender" alt="Putri" style="width: 280px; height: 380px; object-fit: cover;">
                            </div>
                            <div class="skill-mf mt-4 px-3">
                                <p class="title-s mb-2 fw-bold">My Expertise</p>
                                <span>HTML</span> <span class="pull-right text-muted small">99%</span>
                                <div class="progress mb-2" style="height: 10px;"><div class="progress-bar" style="width: 99%"></div></div>
                                <span>CSS3</span> <span class="pull-right text-muted small">99%</span>
                                <div class="progress mb-2" style="height: 10px;"><div class="progress-bar" style="width: 99%"></div></div>
                                <span>PHP</span> <span class="pull-right text-muted small">99%</span>
                                <div class="progress" style="height: 10px;"><div class="progress-bar" style="width: 99%"></div></div>
                            </div>
                        </div>
                        <div class="col-md-7 ps-md-5 mt-3 mt-md-0 pt-md-2">
                            <div class="title-box-2 mb-4">
                                <h5 class="title-left text-uppercase fw-bold">About Me</h5>
                            </div>
                            <p class="lead mb-3">Saya memiliki ketertarikan mendalam pada dunia fashion wanita modern yang elegan. Nuansa warna lembut seperti lavender selalu menjadi inspirasi saya dalam berkarya.</p>
                            <p class="lead">Saya senang mengeksplorasi kombinasi warna yang mampu menciptakan kesan anggun bagi setiap wanita.</p>
                        </div>
                    </div>
                </div>

                <div class="box-shadow-full mb-5">
                    <div class="row align-items-start"> 
                        <div class="col-md-7 pe-md-5 order-2 order-md-1 mt-3 mt-md-0 pt-md-2">
                            <div class="title-box-2 mb-4">
                                <h5 class="title-left text-uppercase fw-bold">About Me</h5>
                            </div>
                            <p class="lead mb-3">Minat saya di dunia fashion berfokus pada fashion pria dengan konsep smart casual. Saya melihat fashion sebagai bagian dari identitas diri yang mampu merepresentasikan karakter.</p>
                            <p class="lead">Bagi saya, fashion bukan hanya tentang mengikuti tren, tetapi tentang memahami proporsi dan kenyamanan.</p>
                        </div>
                        <div class="col-md-5 border-start ps-md-4 order-1 order-md-2">
                            <div class="about-img text-center">
                                <img src="image/sofi.jpg" class="img-fluid rounded-4 shadow-sm border border-3 warna-lavender" alt="Mahesa" style="width: 280px; height: 380px; object-fit: cover;">
                            </div>
                            <div class="skill-mf mt-4 px-3 text-start">
                                <p class="title-s mb-2 fw-bold">My Expertise</p>
                                <span>HTML</span> <span class="pull-right text-muted small">99%</span>
                                <div class="progress mb-2" style="height: 10px;"><div class="progress-bar" style="width: 99%"></div></div>
                                <span>CSS3</span> <span class="pull-right text-muted small">99%</span>
                                <div class="progress mb-2" style="height: 10px;"><div class="progress-bar" style="width: 99%"></div></div>
                                <span>PHP</span> <span class="pull-right text-muted small">99%</span>
                                <div class="progress" style="height: 10px;"><div class="progress-bar" style="width: 99%"></div></div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

<div class="section-counter paralax-mf bg-image" style="background-image: url('image/lavender5.jpg')">
    <div class="overlay-mf"></div>
    <div class="container position-relative">
        <div class="row">
            <div class="col-sm-3 col-lg-3">
                <div class="counter-box pt-4 pt-md-0 text-center">
                    <div class="counter-ico mb-3"><span class="ico-circle border border-white"><i class="bi bi-check-circle text-white"></i></span></div>
                    <div class="counter-num"><p class="counter fw-bold text-white mb-0">450</p> <span class="counter-text text-uppercase text-white">Works Completed</span></div>
                </div>
            </div>
            <div class="col-sm-3 col-lg-3">
                <div class="counter-box pt-4 pt-md-0 text-center">
                    <div class="counter-ico mb-3"><span class="ico-circle border border-white"><i class="bi bi-journal-richtext text-white"></i></span></div>
                    <div class="counter-num"><p class="counter fw-bold text-white mb-0">25</p> <span class="counter-text text-uppercase text-white">Years Experience</span></div>
                </div>
            </div>
            <div class="col-sm-3 col-lg-3">
                <div class="counter-box pt-4 pt-md-0 text-center">
                    <div class="counter-ico mb-3"><span class="ico-circle border border-white"><i class="bi bi-people text-white"></i></span></div>
                    <div class="counter-num"><p class="counter fw-bold text-white mb-0">550</p> <span class="counter-text text-uppercase text-white">Total Clients</span></div>
                </div>
            </div>
            <div class="col-sm-3 col-lg-3">
                <div class="counter-box pt-4 pt-md-0 text-center">
                    <div class="counter-ico mb-3"><span class="ico-circle border border-white"><i class="bi bi-award text-white"></i></span></div>
                    <div class="counter-num"><p class="counter fw-bold text-white mb-0">48</p> <span class="counter-text text-uppercase text-white">Award Won</span></div>
                </div>
            </div>
        </div>
    </div>
</div>

<section class="paralax-mf bg-image py-5" style="background-image: url('image/lavender4.jpg');">
    <div class="overlay-mf"></div>
    <div class="container position-relative py-5">
        <div class="row">
            <div class="col-md-12">
                <div class="testimonials-slider swiper">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <div class="testimonial-box text-center">
                                <div class="author-test">
                                    <img src="image/putri.jpeg" alt="Putri" class="rounded-circle border border-4 warna-lavender shadow-lg mb-3" style="width: 150px; height: 150px; object-fit: cover;">
                                    <h5 class="author text-white text-uppercase fw-bold">Putri Amalia Ramadani</h5>
                                    <p class="text-light small">Fashion Enthusiast</p>
                                </div>
                                <div class="content-test px-lg-5">
                                    <p class="description lead text-white fst-italic">
                                        <i class="bi bi-quote fs-3 text-light"></i>
                                        "Putri memiliki ketertarikan pada fashion yang elegan and modern, mengusung kelembutan warna lavender dalam setiap gayanya."
                                        <i class="bi bi-quote fs-3 text-light"></i>
                                    </p>
                                </div>
                            </div>
                        </div>
                        </div>
                    <div class="swiper-pagination"></div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require "footer-aboutme.php"; ?>

<script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
<script src="bootstrap-5.3.8-dist/js/bootstrap.bundle.min.js"></script>
<script src="fontawesome/js/all.min.js"></script>

<script>
    // Counter Animation sederhana
    document.querySelectorAll('.counter').forEach(counter => {
        const updateCount = () => {
            const target = +counter.getAttribute('innerText') || parseInt(counter.innerText);
            const count = +counter.innerText;
            const speed = 200;
            const inc = target / speed;
            if (count < target) {
                counter.innerText = Math.ceil(count + inc);
                setTimeout(updateCount, 1);
            }
        };
        // updateCount(); // Aktifkan jika ingin animasi angka jalan
    });

    new Swiper('.testimonials-slider', {
        loop: true,
        autoplay: { delay: 4000, disableOnInteraction: false },
        pagination: { el: '.swiper-pagination', clickable: true },
        effect: 'fade',
        fadeEffect: { crossFade: true }
    });
</script>

</body>
</html>