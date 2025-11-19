<template>
    <Head>
        <title>Beranda - Paroki Santa Melania</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    </Head>

    <div class="landing-wrapper">
        
        <nav class="navbar navbar-expand-lg fixed-top" :class="{ 'scrolled': isScrolled }">
            <div class="container">
                <a class="navbar-brand d-flex align-items-center" href="#">
                    <i class="fas fa-church me-2 fa-lg text-warning"></i>
                    <div class="d-flex flex-col">
                        <span class="fw-bold text-white">Paroki Santa Melania</span>
                        <span class="fs-7 text-white-50" style="font-size: 0.75rem;"></span>
                    </div>
                </a>
                
                <div class="d-flex gap-2">
                    <Link href="/login" class="btn btn-outline-light btn-sm px-4">Masuk</Link>
                </div>
            </div>
        </nav>

        <section class="hero d-flex align-items-center">
            <div class="overlay"></div>
            <div class="container position-relative text-center text-white z-1">
                <span class="badge bg-warning text-dark mb-3 px-3 py-2 rounded-pill">Selamat Datang Umat Allah</span>
                <h1 class="display-4 fw-bold mb-3">Pelayanan Sakramen <br> Kini Lebih Mudah</h1>
                <p class="lead mb-4 text-white-50 mx-auto" style="max-width: 600px;">
                   Sistem Informasi Katekumen dan Sakramen Bapstis bayi untuk Anda atau buah hati Anda untuk Sakramen Baptis dan Kelas Katekumen secara online. Terintegrasi, transparan, dan efisien.
                </p>
                <div class="d-flex justify-content-center gap-3">
                    <Link href="/user/login" class="btn btn-primary btn-lg px-5 shadow-lg">
                        <i class="fas fa-sign-in-alt me-2"></i> Login
                    </Link>
                    <a href="#jadwal" class="btn btn-outline-light btn-lg px-5">
                        Lihat Jadwal
                    </a>
                </div>
            </div>
        </section>

        <section class="py-5 bg-light" id="layanan">
            <div class="container py-4">
                <div class="text-center mb-5">
                    <h6 class="text-primary fw-bold text-uppercase ls-1">Layanan Kami</h6>
                    <h2 class="fw-bold text-navy">Pendaftaran Sakramen</h2>
                    <div class="divider mx-auto"></div>
                </div>

                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="card h-100 border-0 shadow-sm hover-up">
                            <div class="card-body text-center p-4">
                                <div class="icon-box bg-primary-subtle text-primary mb-3 mx-auto">
                                    <i class="fas fa-baby fa-2x"></i>
                                </div>
                                <h4 class="card-title fw-bold text-navy">Baptis Bayi</h4>
                                <p class="card-text text-muted">Pendaftaran khusus untuk orang tua yang ingin membaptiskan putera-puterinya (usia di bawah 7 tahun).</p>
                                <Link href="/login" class="btn btn-outline-primary w-100 mt-3">Daftar Sekarang</Link>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card h-100 border-0 shadow-sm hover-up">
                            <div class="card-body text-center p-4">
                                <div class="icon-box bg-success-subtle text-success mb-3 mx-auto">
                                    <i class="fas fa-user-graduate fa-2x"></i>
                                </div>
                                <h4 class="card-title fw-bold text-navy">Katekumen</h4>
                                <p class="card-text text-muted">Pendaftaran kelas persiapan penerimaan Gereja Katolik untuk Dewasa dan Anak/Remaja.</p>
                                <Link href="/login" class="btn btn-outline-success w-100 mt-3">Gabung Kelas</Link>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card h-100 border-0 shadow-sm hover-up">
                            <div class="card-body text-center p-4">
                                <div class="icon-box bg-warning-subtle text-warning mb-3 mx-auto">
                                    <i class="fas fa-users fa-2x"></i>
                                </div>
                                <h4 class="card-title fw-bold text-navy">Data Umat</h4>
                                <p class="card-text text-muted">Pembaruan data umat atau mutasi paroki. Pastikan data Anda terdaftar di sekretariat.</p>
                                <a href="#dokumen" class="btn btn-outline-warning w-100 mt-3">Unduh Formulir</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-5 bg-white">
            <div class="container py-4">
                <div class="text-center mb-5">
                    <h6 class="text-primary fw-bold text-uppercase">Prosedur</h6>
                    <h2 class="fw-bold text-navy">Alur Pendaftaran Online</h2>
                    <p class="text-muted">Ikuti 4 langkah mudah ini</p>
                </div>

                <div class="row text-center position-relative process-row">
                    <div class="process-line d-none d-md-block"></div>

                    <div class="col-md-3 mb-4 position-relative">
                        <div class="step-icon bg-navy text-white mx-auto mb-3">1</div>
                        <h5 class="fw-bold">Buat Akun</h5>
                        <p class="small text-muted">Registrasi akun menggunakan email aktif Anda.</p>
                    </div>
                    <div class="col-md-3 mb-4 position-relative">
                        <div class="step-icon bg-navy text-white mx-auto mb-3">2</div>
                        <h5 class="fw-bold">Pilih Layanan</h5>
                        <p class="small text-muted">Pilih menu Baptis Bayi atau Katekumen di Dashboard.</p>
                    </div>
                    <div class="col-md-3 mb-4 position-relative">
                        <div class="step-icon bg-navy text-white mx-auto mb-3">3</div>
                        <h5 class="fw-bold">Upload Berkas</h5>
                        <p class="small text-muted">Unggah scan Akta Lahir, KK, dan Surat Nikah (PDF/JPG).</p>
                    </div>
                    <div class="col-md-3 mb-4 position-relative">
                        <div class="step-icon bg-success text-white mx-auto mb-3"><i class="fas fa-check"></i></div>
                        <h5 class="fw-bold">Verifikasi</h5>
                        <p class="small text-muted">Sekretariat akan memverifikasi data dan memberi jadwal.</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-5 bg-light" id="jadwal">
            <div class="container py-4">
                <div class="row align-items-center">
                    <div class="col-lg-5 mb-4">
                        <h2 class="fw-bold text-navy mb-3">Agenda Terdekat</h2>
                        <p class="text-muted mb-4">Berikut adalah jadwal pembaptisan dan pembukaan kelas katekumen periode mendatang.</p>
                        <div class="card bg-navy text-white p-4 border-0 rounded-3">
                            <h4><i class="fas fa-info-circle me-2"></i> Informasi Penting</h4>
                            <p class="mb-0 small opacity-75">Pendaftaran ditutup H-3 sebelum tanggal pelaksanaan. Harap melengkapi berkas tepat waktu.</p>
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="card shadow-sm border-0">
                            <div class="card-body p-0">
                                <div class="list-group list-group-flush">
                                    <div class="list-group-item p-4 d-flex align-items-center justify-content-between">
                                        <div class="d-flex align-items-center">
                                            <div class="date-box bg-primary-subtle text-primary rounded p-2 text-center me-3" style="min-width: 60px;">
                                                <span class="d-block fw-bold h5 mb-0">24</span>
                                                <span class="d-block small fw-bold">NOV</span>
                                            </div>
                                            <div>
                                                <h5 class="fw-bold mb-1 text-navy">Sakramen Baptis Bayi</h5>
                                                <p class="mb-0 text-muted small"><i class="far fa-clock me-1"></i> 10:00 WIB - Gereja Utama</p>
                                            </div>
                                        </div>
                                        <span class="badge bg-success rounded-pill px-3">Buka</span>
                                    </div>
                                    
                                    <div class="list-group-item p-4 d-flex align-items-center justify-content-between">
                                        <div class="d-flex align-items-center">
                                            <div class="date-box bg-warning-subtle text-warning rounded p-2 text-center me-3" style="min-width: 60px;">
                                                <span class="d-block fw-bold h5 mb-0">01</span>
                                                <span class="d-block small fw-bold">DES</span>
                                            </div>
                                            <div>
                                                <h5 class="fw-bold mb-1 text-navy">Pembukaan Kelas Katekumen</h5>
                                                <p class="mb-0 text-muted small"><i class="far fa-clock me-1"></i> 16:00 WIB - Aula Paroki</p>
                                            </div>
                                        </div>
                                        <span class="badge bg-success rounded-pill px-3">Buka</span>
                                    </div>

                                     <div class="list-group-item p-4 d-flex align-items-center justify-content-between bg-light">
                                        <div class="d-flex align-items-center">
                                            <div class="date-box bg-secondary-subtle text-secondary rounded p-2 text-center me-3" style="min-width: 60px;">
                                                <span class="d-block fw-bold h5 mb-0">15</span>
                                                <span class="d-block small fw-bold">DES</span>
                                            </div>
                                            <div>
                                                <h5 class="fw-bold mb-1 text-muted">Rekoleksi Orang Tua Baptis</h5>
                                                <p class="mb-0 text-muted small"><i class="far fa-clock me-1"></i> 09:00 WIB - Ruang Petrus</p>
                                            </div>
                                        </div>
                                        <span class="badge bg-secondary rounded-pill px-3">Penuh</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-5 bg-navy text-white" id="dokumen">
            <div class="container text-center">
                <h3 class="fw-bold mb-4 text-white">Butuh Formulir Fisik?</h3>
                <p class="mb-5 opacity-75">Anda dapat mengunduh formulir pendaftaran manual di bawah ini jika diperlukan.</p>
                <div class="d-flex justify-content-center flex-wrap gap-3">
                    <a href="/dokumen/formulirSakramenBaptisBayi.pdf" download class="btn btn-outline-light px-4 py-2">
                        <i class="fas fa-file-pdf me-2"></i> Form Baptis Bayi
                    </a>
                    <a href="/dokumen/formKatekumen.pdf" download class="btn btn-outline-light px-4 py-2">
                        <i class="fas fa-file-pdf me-2"></i> Form Katekumen
                    </a>
                    <a href="/dokumen/formDataUmat.pdf" download class="btn btn-outline-light px-4 py-2">
                        <i class="fas fa-file-pdf me-2"></i> Form Data Umat
                    </a>
                </div>
            </div>
        </section>

        <footer class="bg-dark text-white py-5">
            <div class="container">
                <div class="row g-4">
                    <div class="col-lg-4">
                        <h5 class="fw-bold text-warning mb-3">Paroki Santa Melania</h5>
                        <p class="small opacity-75">
                            Jl. Melania No. 1, Bandung, Jawa Barat<br>
                            Telp: (022) 1234-5678<br>
                            Email: sekretariat@stmelania.org
                        </p>
                    </div>
                    <div class="col-lg-4">
                        <h5 class="fw-bold text-warning mb-3">Tautan Cepat</h5>
                        <ul class="list-unstyled small opacity-75">
                            <li class="mb-2"><Link href="/login" class="text-white text-decoration-none">Login Peserta</Link></li>
                            <li class="mb-2"><Link href="/register" class="text-white text-decoration-none">Daftar Baru</Link></li>
                            <li class="mb-2"><a href="#jadwal" class="text-white text-decoration-none">Jadwal Misa</a></li>
                        </ul>
                    </div>
                    <div class="col-lg-4">
                        <h5 class="fw-bold text-warning mb-3">Jam Sekretariat</h5>
                        <ul class="list-unstyled small opacity-75">
                            <li class="d-flex justify-content-between mb-2"><span>Senin - Jumat:</span> <span>08.00 - 16.00</span></li>
                            <li class="d-flex justify-content-between mb-2"><span>Sabtu:</span> <span>08.00 - 12.00</span></li>
                            <li class="d-flex justify-content-between"><span>Minggu & Libur:</span> <span>Tutup</span></li>
                        </ul>
                    </div>
                </div>
                <div class="border-top border-secondary mt-5 pt-4 text-center small opacity-50">
                    &copy; 2025 Paroki Santa Melania - Sistem Informasi Katekumen & Baptis Bayi. All Rights Reserved.
                </div>
            </div>
        </footer>

    </div>
</template>

<script>
import { Head, Link } from '@inertiajs/inertia-vue3';
import { ref, onMounted, onUnmounted } from 'vue';

export default {
    components: {
        Head,
        Link
    },
    setup() {
        // Logika untuk Navbar berubah warna saat discroll
        const isScrolled = ref(false);

        const handleScroll = () => {
            if (window.scrollY > 50) {
                isScrolled.value = true;
            } else {
                isScrolled.value = false;
            }
        };

        onMounted(() => {
            window.addEventListener('scroll', handleScroll);
        });

        onUnmounted(() => {
            window.removeEventListener('scroll', handleScroll);
        });

        return {
            isScrolled
        }
    }
}
</script>

<style scoped>
/* --- Custom Colors & Variables --- */
:root {
    --navy-primary: #003366;
    --orange-accent: #ff9900;
}
.text-navy { color: #003366; }
.bg-navy { background-color: #003366; }
.text-warning { color: #ff9900 !important; }
.btn-primary {
    background-color: #003366;
    border-color: #003366;
}
.btn-primary:hover {
    background-color: #002244;
}

/* --- Typography --- */
.landing-wrapper {
    font-family: 'Poppins', sans-serif;
}

/* --- Navbar --- */
.navbar {
    transition: all 0.3s ease-in-out;
    padding: 1rem 0;
    background: transparent; /* Transparan di awal */
}
.navbar.scrolled {
    background: #003366; /* Navy saat discroll */
    padding: 0.5rem 0;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

/* --- Hero Section --- */
.hero {
    height: 100vh; /* Full Screen */
    min-height: 600px;
    background: url('/gambar/hero5.jpg') no-repeat center center/cover; /* Pastikan path gambar benar */
    position: relative;
    margin-top: -76px; /* Menarik ke atas agar di belakang navbar */
}
.hero .overlay {
    position: absolute;
    top: 0; left: 0; right: 0; bottom: 0;
    background: linear-gradient(to bottom, rgba(0,51,102,0.8), rgba(0,0,0,0.6));
}

/* --- Cards & Hover Effects --- */
.hover-up {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.hover-up:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
}
.icon-box {
    width: 70px;
    height: 70px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}
.divider {
    width: 60px;
    height: 3px;
    background-color: #ff9900;
    margin-top: 1rem;
}

/* --- Process Flow --- */
.step-icon {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    font-size: 1.2rem;
    z-index: 2;
    position: relative;
}
/* Garis horizontal penghubung step */
.process-line {
    position: absolute;
    top: 25px; /* Setengah dari tinggi step-icon */
    left: 15%;
    right: 15%;
    height: 2px;
    background-color: #e9ecef;
    z-index: 1;
}

/* --- Utilities --- */
.ls-1 { letter-spacing: 1px; }
</style>