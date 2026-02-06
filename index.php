<?php
session_start();
require_once 'get_services.php';

// Get services from database
$services = getAllServices();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Almahyra Sukses Group - Biro Jasa Management and Tax Advisory Service</title>
    <link rel="stylesheet" href="homepage-style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* Updated Auth Button Styles in Navbar */
        .auth-buttons {
            display: flex;
            gap: 10px;
            align-items: center;
        }
        
        .auth-btn {
            padding: 8px 20px;
            border: none;
            border-radius: 25px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
        }
        
        .auth-btn.login {
            background: transparent;
            color: #1e3a8a;
            border: 2px solid #1e3a8a;
        }
        
        .auth-btn.register {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: 2px solid transparent;
        }
        
        .auth-btn.dashboard {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
            border: 2px solid transparent;
        }
        
        .auth-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }
        
        .auth-btn.login:hover {
            background: #1e3a8a;
            color: white;
        }
        
        .auth-btn.register:hover {
            background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
        }
        
        .auth-btn.dashboard:hover {
            background: linear-gradient(135deg, #20c997 0%, #28a745 100%);
        }
        
        /* User info display */
        .user-info {
            background: rgba(30, 58, 138, 0.1);
            padding: 8px 15px;
            border-radius: 20px;
            color: #1e3a8a;
            font-weight: 600;
            font-size: 14px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        
        /* Update navbar to accommodate auth buttons */
        .navbar-menu {
            display: flex;
            align-items: center;
            gap: 20px;
        }
        
        /* Dynamic service item styles */
        .dynamic-service-item {
            background: white;
            border-radius: 15px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            cursor: pointer;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        
        .dynamic-service-item:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
        }
        
        .service-icon {
            font-size: 3rem;
            color: #667eea;
            margin-bottom: 15px;
        }
        
        .service-title {
            font-size: 1.2rem;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 10px;
        }
        
        .service-description {
            color: #666;
            font-size: 0.9rem;
            line-height: 1.5;
            margin-bottom: 15px;
            flex-grow: 1;
        }
        
        .service-price {
            color: #28a745;
            font-weight: 700;
            font-size: 1.1rem;
        }
        
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .navbar-menu {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .auth-buttons {
                width: 100%;
                justify-content: center;
                margin-top: 15px;
                padding: 10px 0;
                border-top: 1px solid #e5e7eb;
            }
            
            .auth-btn {
                padding: 8px 16px;
                font-size: 0.9rem;
            }
            
            .user-info {
                font-size: 0.8rem;
                padding: 6px 12px;
            }
        }
    </style>
</head>
<body>

<!-- HEADER SECTION -->
<header>
    <!-- KONTAK INFORMASI -->
    <div class="header">
        <a href="mailto:info@almahyrasuksesgroup.com"><i class="fas fa-envelope"></i> info@almahyrasuksesgroup.com</a>
        <span class="divider">|</span>
        <a href="https://wa.me/6281333803960" target="_blank"><i class="fas fa-phone"></i> 081333803960</a>
        <span class="divider">|</span>
        <a><i class="fas fa-clock"></i> Mon - Fri : 08.30 - 17.30</a>
    </div>
    
<!-- NAVIGASI MENU -->
<div class="navbar">
    <div class="navbar-logo">
        <img src="images/logo_ASG.png" alt="Company Logo">
        <span class="company-name">ALMAHYRA SUKSES GROUP</span>
    </div>
    <nav class="navbar-menu">
       <!-- Hamburger Icon for Mobile -->
       <div class="hamburger" onclick="toggleMenu()">☰</div>
        <ul class="menu">
            <li><a href="#beranda">Beranda</a></li>
            <li><a href="#layanan">Layanan</a></li>
            <li><a href="#footer">Tentang</a></li>
            <li><a href="#footer">Kontak</a></li>
        </ul>
        
        <!-- Login/Register Buttons in Navbar -->
        <div class="auth-buttons">
            <?php if (isset($_SESSION['user_id'])): ?>
                <span class="user-info">
                    <i class="fas fa-user"></i> 
                    <?php echo htmlspecialchars($_SESSION['nama_lengkap']); ?>
                </span>
                <?php if ($_SESSION['role'] == 'admin'): ?>
                    <a href="admin/dashboard.php" class="auth-btn dashboard">
                        <i class="fas fa-tachometer-alt"></i>
                        Dashboard
                    </a>
                <?php else: ?>
                    <a href="pelanggan/dashboard.php" class="auth-btn dashboard">
                        <i class="fas fa-user-circle"></i>
                        Dashboard
                    </a>
                <?php endif; ?>
                <a href="logout.php" class="auth-btn login">
                    <i class="fas fa-sign-out-alt"></i>
                    Logout
                </a>
            <?php else: ?>
                <a href="login.php" class="auth-btn login">
                    <i class="fas fa-sign-in-alt"></i>
                    Login
                </a>
                <a href="register.php" class="auth-btn register">
                    <i class="fas fa-user-plus"></i>
                    Register
                </a>
            <?php endif; ?>
        </div>
    </nav>
</div>

    <!-- BAGIAN BANNER -->
    <section class="banner">
        <div class="overlay">
            <h1>ALMAHYRA SUKSES GROUP</h1>
            <p>Biro Jasa Account and Management Tax Advisory Service</p>
            <a href="https://wa.me/6281333803960" target="_blank" class="button">Hubungi Sekarang</a>
        </div>
    </section>
</header>

<!-- SECTION ABOUT -->
<section class="about-section" id="beranda">
    <div class="about-left">
        <h2>Kami ada<br>di sini<br>untuk membantu</h2>
    </div>
    <div class="about-right">
        <p>Ratusan pembaruan dan aturan-aturan baru setiap tahun keluar di Indonesia. Dengan enam jenis dasar hukum dan ratusan regulasi di dalamnya, Indonesia telah menjadi salah satu negara yang paling tidak ramah bagi wajib pajak. Dengan pergeseran kondisi ekonomi setiap hari, anda masih perlu mengantisipasi tiga hal yang tidak menyenangkan berikut ini:</p>
        <ul>
            <li>Waktu yang dihabiskan untuk administrasi pajak yang kompleks</li>
            <li>Penalti-penalti pajak</li>
            <li>Terus mengikuti regulasi-regulasi baru setiap hari</li>
        </ul>
    </div>
</section>

<!-- SECTION CONTAINER -->
<div class="container">
    <div class="title">Kami bisa membantu anda <span>hanya</span> dengan 5 langkah sederhana!</div>
    <div class="steps">
        <div class="step">
            <div class="step-number">01.</div>
            <div class="step-description">Hubungi Kami</div>
        </div>
        <div class="step">
            <div class="step-number">02.</div>
            <div class="step-description">Kami menunjuk konsultan pajak pribadi untuk anda</div>
        </div>
        <div class="step">
            <div class="step-number">03.</div>
            <div class="step-description">Kami mempersiapkan Surat Pemberitahuan (SPT) anda</div>
        </div>
        <div class="step">
            <div class="step-number">04.</div>
            <div class="step-description">Meriview dan membayar pajak anda</div>
        </div>
        <div class="step">
            <div class="step-number">05.</div>
            <div class="step-description">Kami membantu melaporkan SPT anda</div>
        </div>
    </div>
</div>

<div class="container-background">
    <div class="container">
        <div class="services-title"><span>Layanan Kami</span></div>
    </div>
</div>

<!-- LAYANAN SECTION - DYNAMIC FROM DATABASE -->
<section id="layanan" class="layanan-section">
    <div class="layanan-grid">
        <?php if (!empty($services)): ?>
            <?php 
            $service_icons = [
                'fas fa-file-invoice-dollar',
                'fas fa-handshake',
                'fas fa-shield-alt',
                'fas fa-calculator',
                'fas fa-chart-line',
                'fas fa-users',
                'fas fa-book',
                'fas fa-clipboard-list',
                'fas fa-graduation-cap'
            ];
            ?>
            <?php foreach ($services as $index => $service): ?>
                <div class="layanan-item dynamic-service-item" onclick="showServicePopup('<?php echo htmlspecialchars($service['nama_layanan']); ?>', '<?php echo htmlspecialchars($service['deskripsi']); ?>', '<?php echo number_format($service['harga'], 0, ',', '.'); ?>', '<?php echo htmlspecialchars($service['syarat_dokumen']); ?>')">
                    <div>
                        <div class="service-icon">
                            <i class="<?php echo $service_icons[$index % count($service_icons)]; ?>"></i>
                        </div>
                        <div class="service-title"><?php echo htmlspecialchars($service['nama_layanan']); ?></div>
                        <div class="service-description"><?php echo htmlspecialchars(substr($service['deskripsi'], 0, 100)) . (strlen($service['deskripsi']) > 100 ? '...' : ''); ?></div>
                    </div>
                    <div class="service-price">Rp <?php echo number_format($service['harga'], 0, ',', '.'); ?></div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <!-- Fallback to static services if database is empty -->
            <div class="layanan-item" id="JasaAdministrasiPajak" onclick="showPopup('Jasa Administrasi pajak', 'Membantu perusahaan dalam pengajuan terkait pemenuhan administrasi perpajakan.')">
                <img src="images/service1.jpg" alt="Jasa Administrasi pajak">
                <p>Jasa Administrasi pajak</p>
            </div>
            <div class="layanan-item" id="JasaKonsultasiPajak" onclick="showPopup('Jasa Konsultasi Pajak', 'Memberikan konsultasi rutin dan khusus terkait permasalahan perpajakan.')">
                <img src="images/service2.png" alt="Jasa Konsultasi Pajak">
                <p>Jasa Konsultasi Pajak</p>
            </div>
            <div class="layanan-item" id="JasaKepatuhanPerpajakan" onclick="showPopup('Jasa Kepatuhan Perpajakan', 'Membantu perusahaan atau individu dalam pemenuhan kewajiban pajak, termasuk menghitung, menyetorkan, dan melaporkan pajak.')">
                <img src="images/service3.png" alt="Jasa Kepatuhan Perpajakan">
                <p>Jasa Kepatuhan Perpajakan</p>
            </div>
            <div class="layanan-item" id="Penyusunan SPT Tahunan" onclick="showPopup('Penyusunan SPT Tahunan', 'Membantu penyusunan SPT Tahunan PPh Badan atau Pribadi sesuai laporan keuangan.')">
                <img src="images/service4.jpg" alt="Penyusunan SPT Tahunan">
                <p>Penyusunan SPT Tahunan</p>
            </div>
            <div class="layanan-item" id="JasaPerencanaanPerpajakan" onclick="showPopup('Jasa Perencanaan Perpajakan', 'Menyusun rencana perpajakan untuk efisiensi pajak perusahaan atau perseorangan.')">
                <img src="images/service5.jpg" alt="Jasa Perencanaan Perpajakan">
                <p>Jasa Perencanaan Perpajakan</p>
            </div>
            <div class="layanan-item" id="JasaPendampinganPerpajakan" onclick="showPopup('Jasa Pendampingan Perpajakan ', 'Mendampingi dalam proses pemeriksaan, keberatan, restitusi, dan banding perpajakan.')">
                <img src="images/service6.png" alt="Jasa Pendampingan Perpajakan">
                <p>Jasa Pendampingan Perpajakan</p>
            </div>
            <div class="layanan-item" id="JasaPembukuan" onclick="showPopup('Jasa Pembukuan', 'Menyusun pembukuan dan laporan keuangan untuk pengambilan keputusan terkait pajak.')">
                <img src="images/service7.png" alt="Jasa Pembukuan">
                <p>Jasa Pembukuan</p>
            </div>
            <div class="layanan-item" id="JasaKompilasi" onclick="showPopup('Jasa Kompilasi', 'Menyusun laporan keuangan berkala sesuai ketentuan perpajakan.')">
                <img src="images/service8.png" alt="Jasa Kompilasi">
                <p>Jasa Kompilasi</p>
            </div>
            <div class="layanan-item" id="JasaPelatihanPerpajakan" onclick="showPopup('Jasa Pelatihan Perpajakan', 'Pelatihan perpajakan untuk meningkatkan pengetahuan karyawan sesuai kebutuhan industri.')">
                <img src="images/service9.png" alt="Jasa Pelatihan Perpajakan">
                <p>Jasa Pelatihan Perpajakan</p>
            </div>
        <?php endif; ?>
    </div>
</section>

<!--SECTION VISI MISI -->
<section class="visi-misi-section">
    <div class="visi-misi-container">
        <div class="text-container">
            <h2>Visi dan Misi</h2>
            <div class="visi">
                <h3>Visi</h3>
                <p>Menjadi konsultan pajak terkemuka yang diakui atas keandalan dan inovasi dalam membantu klien mengelola kewajiban perpajakan.</p>
            </div>
            <div class="misi">
                <h3>Misi</h3>
                <div class="misi-item">
                    <p>→ <strong>Layanan Berkualitas:</strong> Konsultasi pajak akurat dan transparan.</p>
                </div>
                <div class="misi-item">
                    <p>→ <strong>Pendekatan Personal:</strong> Hubungan jangka panjang.</p>
                </div>
                <div class="misi-item">
                    <p>→ <strong>Inovasi:</strong> Mengadopsi metode dan teknologi baru.</p>
                </div>
                <div class="misi-item">
                    <p>→ <strong>Integritas:</strong> Menjunjung tinggi standar etika.</p>
                </div>
            </div>                    
        </div>
    </div>
</section>

<!-- FOOTER SECTION -->
<footer id="footer">
    <div class="footer-container">
        <!-- LOGO AND CONTACT INFO -->
        <div class="footer-section">
            <img src="images/logo_ASG.png" alt="ALMAHYRA SUKSES GROUP Logo">
            <h2>ALMAHYRA SUKSES GROUP</h2>
            <p>Biro Jasa Management and Tax Advisory Service</p>
            <p><a href="https://maps.app.goo.gl/UekwudcLGPhQn1iw8" target="_blank">Alamat</a></p>
            <p><a href="mailto:info@almahyrasuksesgroup.com">Email</a></p>
            <p><a href="https://instagram.com/almahyra_sukses_group" target="_blank">Instagram</a></p>
            <p><a href="https://wa.me/6281333803960" target="_blank">Whatsapp</a></p>
        </div>

        <!-- TENTANG KAMI SECTION -->
        <div class="footer-section">
            <h3>TENTANG KAMI</h3>
            <p>Almahyra Sukses Group dikelola oleh Praktisi yang memiliki izin sebagai Konsultan Pajak serta izin sebagai Kuasa Hukum dan berusaha memberikan pelayanan terbaik.</p>
        </div>

        <!-- MENU LAYANAN SECTION -->
        <div class="footer-section">
            <h3>LAYANAN</h3>
            <?php if (!empty($services)): ?>
                <?php foreach (array_slice($services, 0, 9) as $service): ?>
                    <p><a href="#layanan"><?php echo htmlspecialchars($service['nama_layanan']); ?></a></p>
                <?php endforeach; ?>
            <?php else: ?>
                <p><a href="#JasaAdministrasiPajak">Jasa Administrasi Pajak</a></p>
                <p><a href="#JasaKonsultasiPajak">Jasa Konsultasi Pajak</a></p>
                <p><a href="#JasaKepatuhanPerpajakan">Jasa Kepatuhan Perpajakan</a></p>
                <p><a href="#PenyusunanSPTTahunan">Penyusunan SPT Tahunan</a></p>
                <p><a href="#JasaPerencanaanPerpajakan">Jasa Perencanaan Perpajakan</a></p>
                <p><a href="#JasaPendampinganPerpajakan">Jasa Pendampingan Perpajakan</a></p>
                <p><a href="#JasaPembukuan">Jasa Pembukuan</a></p>
                <p><a href="#JasaKompilasi">Jasa Kompilasi</a></p>
                <p><a href="#JasaPelatihanPerpajakan">Jasa Pelatihan Perpajakan</a></p>
            <?php endif; ?>
        </div>

        <!-- MENU SECTION -->
        <div class="footer-section">
            <h3>MENU</h3>
            <p><a href="#beranda">Beranda</a></p>
            <p><a href="#layanan">Layanan</a></p>
            <p><a href="#tentangKami">Tentang Kami</a></p>
            <p><a href="#kontakKami">Kontak Kami</a></p>
        </div>
    </div>

    <!-- COPY RIGHT -->
    <div class="footer-bottom">
        <p>&copy; 2024 ALMAHYRA SUKSES GROUP | All Rights Reserved</p>
    </div>
</footer>

<!-- POPUP -->
<div id="popup" class="popup" onclick="hidePopup()">
    <div class="popup-content" onclick="event.stopPropagation()">
        <span class="close" onclick="hidePopup()">&times;</span>
        <h2 id="popup-title">Title</h2>
        <p id="popup-info">Informasi tambahan di sini</p>
        <div id="popup-price" style="font-weight: bold; color: #28a745; margin: 10px 0;"></div>
        <div id="popup-requirements" style="margin-top: 15px;">
            <h4>Syarat Dokumen:</h4>
            <p id="popup-req-list"></p>
        </div>
        <?php if (isset($_SESSION['user_id'])): ?>
            <div style="margin-top: 20px;">
                <a href="pelanggan/permohonan.php" class="btn" style="background: #667eea; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">
                    <i class="fas fa-paper-plane"></i> Ajukan Permohonan
                </a>
            </div>
        <?php else: ?>
            <div style="margin-top: 20px;">
                <p style="color: #666; font-style: italic;">Silakan login terlebih dahulu untuk mengajukan permohonan layanan.</p>
                <a href="login.php" class="btn" style="background: #667eea; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; margin-right: 10px;">
                    <i class="fas fa-sign-in-alt"></i> Login
                </a>
                <a href="register.php" class="btn" style="background: #28a745; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">
                    <i class="fas fa-user-plus"></i> Register
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- SCRIPT JS -->
<script src="homepage-script.js"></script>

<script>
// Enhanced popup function for dynamic services
function showServicePopup(title, description, price, requirements) {
    document.getElementById('popup-title').textContent = title;
    document.getElementById('popup-info').textContent = description;
    document.getElementById('popup-price').textContent = 'Harga: Rp ' + price;
    document.getElementById('popup-req-list').textContent = requirements;
    document.getElementById('popup').style.display = 'flex';
}

// Original popup function for backward compatibility
function showPopup(title, info) {
    document.getElementById('popup-title').textContent = title;
    document.getElementById('popup-info').textContent = info;
    document.getElementById('popup-price').textContent = '';
    document.getElementById('popup-req-list').textContent = '';
    document.getElementById('popup').style.display = 'flex';
}

function hidePopup() {
    document.getElementById('popup').style.display = 'none';
}

// Close popup when clicking outside
window.onclick = function(event) {
    const popup = document.getElementById('popup');
    if (event.target == popup) {
        hidePopup();
    }
}
</script>

</body>
</html>