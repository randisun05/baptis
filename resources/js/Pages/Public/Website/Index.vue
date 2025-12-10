<template>
    <Head>
        <title>Warta - Paroki Santa Melania</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    </Head>

    <div class="landing-wrapper">

        <nav class="navbar navbar-expand-lg fixed-top" :class="{ 'scrolled': isScrolled }">
            <div class="container">

                <Link href="/" class="navbar-brand d-flex align-items-center">
                    <i class="fas fa-church me-2 fa-lg text-warning"></i>
                    <div class="d-flex flex-column lh-sm">
                        <span class="fw-bold text-white small-brand-title">Paroki Santa Melania</span>
                        <span class="fs-7 text-white-50" style="font-size: 0.7rem;">Sistem Informasi Katekumen & Baptis Bayi</span>
                    </div>
                </Link>

                <div class="d-flex gap-2 align-items-center ms-auto">
                    <Link href="/user/login" class="btn btn-outline-light btn-sm px-3">Masuk</Link>
                </div>
            </div>
        </nav>

        <section class="hero d-flex align-items-center">
            <div class="overlay"></div>
            <div class="container position-relative text-center text-white z-1 py-5">
                <span class="badge bg-warning text-dark mb-3 px-3 py-2 rounded-pill">Selamat Datang</span>
                <h1 class="display-5 fw-bold mb-3">Pelayanan Sakramen <br> Kini Lebih Mudah</h1>
                <p class="lead mb-4 text-white-50 mx-auto small-text" style="max-width: 600px;">
                    Sistem Informasi Katekumen dan Sakramen Baptis bayi untuk Anda atau buah hati Anda untuk Sakramen Baptis dan Kelas Katekumen secara online. Terintegrasi, transparan, dan efisien.
                </p>
                <div class="d-flex justify-content-center flex-wrap gap-3">
                    <Link href="/user/login" class="btn btn-primary btn-md px-4 shadow-lg">
                        <i class="fas fa-sign-in-alt me-2"></i> Login
                    </Link>
                    <a href="#jadwal" class="btn btn-outline-light btn-md px-4">
                        Lihat Jadwal
                    </a>
                </div>
            </div>
        </section>

        <section class="py-5 bg-light" id="layanan">
            <div class="container py-4">
                <div class="text-center mb-5">
                    <h6 class="text-primary fw-bold text-uppercase ls-1">Layanan Kami</h6>
                    <h2 class="fw-bold text-navy">Pendaftaran Katekese</h2>
                    <div class="divider mx-auto"></div>
                </div>

                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="card h-100 border-0 shadow-sm hover-up">
                            <div class="card-body text-center p-4">
                                <div class="icon-box bg-primary-subtle text-primary mb-3 mx-auto">
                                    <i class="fas fa-baby fa-2x"></i>
                                </div>
                                <h4 class="card-title fw-bold text-navy">Sakramen Baptis Bayi</h4>
                                <p class="card-text text-muted">Pendaftaran khusus untuk orang tua yang ingin membaptiskan putera-puterinya (usia di bawah 7 tahun).</p>
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
                                <p class="card-text text-muted"> Pastikan data Anda terdaftar di sekretariat. Jika belum terdaftar harap datang ke sekretariat gereja.</p>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-5 bg-white" style="overflow-x: hidden;">
            <div class="container py-4">
                <div class="text-center mb-5">
                    <h6 class="text-primary fw-bold text-uppercase">Prosedur</h6>
                    <h2 class="fw-bold text-navy">Alur Pendaftaran Online</h2>
                    <p class="text-muted">Ikuti 4 langkah mudah ini</p>
                </div>

                <div class="row text-center position-relative process-row">
                    <div class="process-line d-none d-md-block"></div>

                    <div class="col-md-3 col-6 mb-4 position-relative">
                        <div class="step-icon bg-navy text-white mx-auto mb-3">1</div>
                        <h5 class="fw-bold">Pendaftaran</h5>
                        <p class="small text-muted">Daftarkan diri Anda dengan datang ke Sekretariat.</p>
                    </div>
                    <div class="col-md-3 col-6 mb-4 position-relative">
                        <div class="step-icon bg-navy text-white mx-auto mb-3">2</div>
                        <h5 class="fw-bold">Penyerahan Dokumen</h5>
                        <p class="small text-muted">Isi dokumen yang diberikan oleh sekretariat dan serahkan untuk pendataan.</p>
                    </div>
                    <div class="col-md-3 col-6 mb-4 position-relative">
                        <div class="step-icon bg-navy text-white mx-auto mb-3">3</div>
                        <h5 class="fw-bold">Verifikasi Akun</h5>
                        <p class="small text-muted">Verifikasi data pada akun Anda dengan melakukan login pada akun yang telah diberikan oleh sekretariat via email berupa username dan password.</p>
                    </div>
                    <div class="col-md-3 col-6 mb-4 position-relative">
                        <div class="step-icon bg-success text-white mx-auto mb-3"><i class="fas fa-check"></i></div>
                        <h5 class="fw-bold">Berhasil</h5>
                        <p class="small text-muted">Anda memiliki akses untuk masuk ke sistem untuk keperluan kegiatan katekumen atau sakramen baptis bayi.</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-5 bg-light" id="jadwal">
            <div class="container py-4">
                <div class="row align-items-center">

                    <div class="col-lg-5 mb-4">
                        <h2 class="fw-bold text-navy mb-3">Jadwal Sakramen & Katekumen</h2>
                        <p class="text-muted mb-4">Berikut adalah jadwal pembaptisan dan pembukaan kelas katekumen periode mendatang.</p>
                        
                    </div>

                    <div class="col-lg-7">
                        <div class="card shadow-sm border-0">
                            <div class="card-body p-0">
                                <div class="list-group list-group-flush">

                                    <div class="list-group-item p-3 d-flex align-items-center justify-content-between"
                                        v-for="event in events"
                                        :key="event.id">

                                        <div class="d-flex align-items-center">

                                            <div class="date-box bg-primary-subtle text-primary rounded p-2 text-center me-3 date-box-sm">
                                                <span class="d-block fw-bold h6 mb-0">{{ formatDate(event.date, 'day') }}</span>
                                                <span class="d-block small fw-bold">{{ formatDate(event.date, 'month') }}</span>
                                            </div>

                                            <div>
                                                <h6 class="fw-bold mb-1 text-navy event-title-sm">{{ event.title }}</h6>
                                                <p class="mb-0 text-muted small-info">
                                                    <i class="fas fa-map-marker-alt me-1"></i> {{ event.place }}
                                                    <span v-if="event.ref_event" class="ms-2 badge bg-info-subtle text-info-emphasis event-badge-sm">
                                                        {{ event.ref_event.title }}
                                                    </span>
                                                </p>
                                            </div>
                                        </div>

                                        <div class="d-flex flex-column align-items-end gap-2 ms-2">
                                            <span class="badge rounded-pill px-3 py-1 event-status-sm"
                                                :class="event.status === 'active' ? 'bg-success' : 'bg-secondary'">
                                                {{ event.status === 'active' ? 'Aktif' : 'Ditutup' }}
                                            </span>
                                        </div>
                                    </div>

                                    <div v-if="events.length === 0" class="list-group-item text-center text-muted p-4">
                                        Tidak ada jadwal yang tersedia saat ini.
                                    </div>

                                    <div class="card-footer p-3 text-center">
                                        <Link href="/kegiatan" class="btn btn-sm btn-outline-navy"><strong>Lihat Semua Kegiatan</strong></Link>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <section class="py-5 bg-light" id="warta">
            <div class="container py-4">
                <div class="row align-items-center">

                    <div class="col-lg-5 mb-4">
                        <h2 class="fw-bold text-navy mb-3">Warta Paroki Terbaru</h2>
                        <p class="text-muted mb-4">Informasi dan pengumuman yang baru diterbitkan untuk umat.</p>


                        <div class="card bg-navy text-white p-4 border-0 rounded-3">
                            <h4><i class="fas fa-bullhorn me-2"></i> Keterangan</h4>
                            <p class="mb-0 small opacity-75">Klik tombol "Lihat Post" di samping untuk membaca warta selengkapnya.</p>
                        </div>
                    </div>

                    <div class="col-lg-7">
                        <div class="card shadow-sm border-0">
                            <div class="card-body p-0">
                                <div class="list-group list-group-flush">

                                    <div class="list-group-item p-3 d-flex align-items-center justify-content-between"
                                        v-for="post in posts"
                                        :key="post.id">

                                        <div class="d-flex align-items-center">
                                            <div class="date-box bg-primary-subtle text-primary rounded p-2 text-center me-3 date-box-sm">
                                                <span class="d-block fw-bold h6 mb-0">{{ formatDate(post.created_at, 'day') }}</span>
                                                <span class="d-block small fw-bold">{{ formatDate(post.created_at, 'month') }}</span>
                                            </div>

                                            <div>
                                                <h6 class="fw-bold mb-1 text-navy event-title-sm">{{ post.title }}</h6>
                                                <p class="mb-0 text-muted small-info">
                                                    <i class="far fa-calendar-alt me-1"></i>
                                                    Diterbitkan: {{ formatDate(post.created_at, 'full') }}
                                                </p>
                                            </div>
                                        </div>

                                        <Link :href="`/warta/${post.slug}`" class="btn btn-sm btn-outline-primary border-0 shadow ms-2" type="button">
                                            <i class="fas fa-eye me-1"></i> Lihat Post
                                        </Link>
                                    </div>

                                    <div v-if="posts.length === 0" class="list-group-item text-center text-muted p-4">
                                        Belum ada warta paroki terbaru yang diterbitkan.
                                    </div>

                                    <div class="card-footer p-3 text-center">
                                        <Link href="/warta" class="btn btn-sm btn-outline-navy"><strong>Lihat Semua Warta</strong></Link>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-5 bg-white" id="lokasi">
            <div class="container py-4">
                <div class="text-center mb-5">
                    <h6 class="text-primary fw-bold text-uppercase">Lokasi</h6>
                    <h2 class="fw-bold text-navy">Gereja Santa Melania</h2>
                    <div class="divider mx-auto"></div>
                </div>
                <div class="card border-0 shadow-lg">
                    <div class="card-body p-0">
                        <div class="map-responsive">
                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3959.327942890694!2d107.6212273!3d-6.9003616!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68e7b306147b35%3A0x44c48d0d2a9d2f59!2sGereja%20Katolik%20Santa%20Melania%2C%20Cihaur%20Geulis!5e0!3m2!1sid!2sid!4v1727260000000!5m2!1sid!2sid"
                                width="100%"
                                height="350" style="border:0;"
                                allowfullscreen=""
                                loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade">
                            </iframe>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <section class="py-5 bg-navy text-white" id="dokumen">
            <div class="container text-center">
                <h3 class="fw-bold mb-4 text-white">Butuh Formulir Fisik?</h3>
                <p class="mb-5 opacity-75 small-text">Anda dapat mengunduh formulir pendaftaran manual di bawah ini jika diperlukan.</p>
                <div class="d-flex justify-content-center flex-wrap gap-3">
                    <a href="/assets/document/formulirSakramenBaptisBayi.pdf" download class="btn btn-outline-light btn-sm px-3 py-2">
                        <i class="fas fa-file-pdf me-2"></i> Form Baptis Bayi
                    </a>
                    <a href="/assets/document/formKatekumen.pdf" download class="btn btn-outline-light btn-sm px-3 py-2">
                        <i class="fas fa-file-pdf me-2"></i> Form Katekumen
                    </a>
                    <a href="/assets/document/formDataUmat.pdf" download class="btn btn-outline-light btn-sm px-3 py-2">
                        <i class="fas fa-file-pdf me-2"></i> Form Data Umat
                    </a>
                </div>
            </div>
        </section>

        <footer class="bg-dark text-white py-5">
            <div class="container">
                <div class="row g-4">
                    <div class="col-lg-6">
                        <h5 class="fw-bold text-warning mb-3">Paroki Santa Melania</h5>
                        <p class="small opacity-75 footer-contact">
                            Jl. Melania No.1-3, Cihaur Geulis, Kec. Cibeunying Kaler, Kota Bandung, Jawa Barat 40122<br>
                            Telp: (022) 20463790<br>
                            <a href="mailto:parokimelaniabdg@gmail.com" class="text-white opacity-75 text-decoration-none">
                            Email: parokimelaniabdg@gmail.com
                            </a>
                            <br>
                            <a href="https://wa.me/6281321272634" target="_blank" class="text-white opacity-75 text-decoration-none">
                                <i class="fab fa-whatsapp me-1"></i> WhatsApp: +62 813-2127-2634
                            </a>
                        </p>
                    </div>
                    <div class="col-lg-6">
                        <h5 class="fw-bold text-warning mb-3">Jam Sekretariat</h5>
                        <ul class="list-unstyled small opacity-75 footer-hours">
                            <li class="d-flex justify-content-between mb-2"><span>Senin:</span> <span>08.00 – 16.00</span></li>
                            <li class="d-flex justify-content-between mb-2"><span>Selasa:</span> <span>08.00 – 16.00</span></li>
                            <li class="d-flex justify-content-between mb-2"><span>Rabu:</span> <span>08.00 – 16.00</span></li>
                            <li class="d-flex justify-content-between mb-2"><span>Kamis & Libur Nasional:</span> <span>LIBUR</span></li>
                            <li class="d-flex justify-content-between mb-2"><span>Jumat:</span> <span>08.00 – 16.00</span></li>
                            <li class="d-flex justify-content-between mb-2"><span>Jumat Pertama & Sabtu:</span> <span>08.00-14.00 & 16.00-18.00</span></li>
                            <li class="d-flex justify-content-between"><span>Minggu:</span> <span>07.00 – 12.00</span></li>
                        </ul>
                    </div>
                </div>
                <div class="border-top border-secondary mt-5 pt-4 text-center small opacity-50">
                    © 2025 Paroki Santa Melania - Sistem Informasi Katekumen & Baptis Bayi.
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

    props: {
        title: String,
        posts: Array,
        events: Array // Events sekarang diasumsikan memiliki relasi ref_event dan status
    },

    setup() {

        // --- Fungsi Pembantu untuk Format Tanggal ---
        const formatDate = (dateString, formatType) => {
            if (!dateString) return '';
            const date = new Date(dateString);

            if (formatType === 'day') {
                return date.getDate().toString().padStart(2, '0');
            }
            if (formatType === 'month') {
                return date.toLocaleDateString('id-ID', { month: 'short' }).toUpperCase();
            }
            if (formatType === 'full') {
                return date.toLocaleDateString('id-ID', {
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                });
            }
            return dateString;
        };

        // --- Logika untuk Navbar berubah warna saat discroll ---
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
            isScrolled,
            formatDate,
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
.text-primary { color: #003366 !important; } 

.btn-primary {
    background-color: #003366;
    border-color: #003366;
}
.btn-primary:hover {
    background-color: #002244;
    border-color: #002244;
}

/* --- Typography --- */
.landing-wrapper {
    font-family: 'Poppins', sans-serif;
}

/* --- Navbar --- */
.navbar {
    transition: all 0.3s ease-in-out;
    padding: 1rem 0;
    background: transparent; 
}
.navbar.scrolled {
    background: var(--navy-primary); 
    padding: 0.5rem 0;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

/* Penyesuaian Navbar Brand */
.navbar-brand .fa-church {
    font-size: 1.5rem;
}
.navbar-brand {
    padding-top: 0;
    padding-bottom: 0;
}
.lh-sm { line-height: 1.25; } 

/* --- Hero Section --- */
.hero {
    height: 100vh; 
    min-height: 600px;
    background: url('/gambar/hero5.jpg') no-repeat center center/cover; 
    position: relative;
    margin-top: -76px; 
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

/* Garis horizontal penghubung step (MODIFIKASI FULL WIDTH) */
.process-line {
    position: absolute;
    top: 25px; 
    
    /* Membuat garis selebar viewport (layar browser) */
    width: 100vw;
    
    /* Memposisikan di tengah-tengah relatif parent */
    left: 50%;
    transform: translateX(-50%);
    
    height: 2px;
    background-color: #e9ecef;
    z-index: 1;
}

/* --- Utilities --- */
.ls-1 { letter-spacing: 1px; }

/* Tambahan Warna Subtle untuk Section Layanan */
.bg-primary-subtle { background-color: #cfe2ff !important; }
.text-primary { color: #0a58ca !important; }
.bg-success-subtle { background-color: #d1e7dd !important; }
.text-success { color: #198754 !important; }
.bg-warning-subtle { background-color: #fff3cd !important; }
.text-warning { color: #ffc107 !important; } 
.bg-secondary-subtle { background-color: #e2e3e5 !important; }
.text-secondary { color: #6c757d !important; }
.bg-info-subtle { background-color: #cff4fc !important; }
.text-info-emphasis { color: #055160 !important; }


/* Menghapus background button kontak saat tidak discroll, karena sudah pakai btn-outline-light */
.btn-outline-light:hover {
    background-color: white;
    color: var(--navy-primary);
}
.navbar:not(.scrolled) .btn-primary {
    background-color: var(--navy-primary); 
    border-color: var(--navy-primary);
}

/* --- STYLE UNTUK HOVER WHATSAPP DI FOOTER --- */
footer a.text-white:hover {
    /* Meningkatkan opasitas dari 75% menjadi 100% */
    opacity: 1 !important; 
    /* Mengubah warna menjadi warna aksen orange-accent saat di-hover */
    color: var(--orange-accent) !important;
}

/* =======================================
   RESPONSIVE/MOBILE ADJUSTMENTS (<= 768px)
   ======================================= */
@media (max-width: 768px) {
    
    /* --- Navbar --- */
    .navbar {
        padding: 0.75rem 0; /* Padding lebih kecil */
    }
    .navbar-brand .fa-church {
        font-size: 1.25rem;
    }
    .small-brand-title {
        font-size: 0.85rem; /* Judul lebih kecil */
    }

    /* --- Hero Section --- */
    .hero {
        height: 60vh; /* Tinggi hero dikurangi di mobile */
        min-height: 400px;
        margin-top: -55px; /* Sesuaikan dengan tinggi navbar yang baru */
    }
    .hero .container {
        padding-top: 8rem !important;
        padding-bottom: 2rem !important;
    }
    .display-5 {
        font-size: 1.75rem; /* H1 lebih kecil */
    }
    .small-text {
        font-size: 0.875rem; /* Paragraf lebih kecil */
    }

    /* --- Process Flow --- */
    .process-line {
        display: none !important; /* Sembunyikan garis horizontal */
    }
    /* Pastikan step-icon tetap di tengah kolom 6 */
    .col-6 .step-icon {
        margin-left: auto !important;
        margin-right: auto !important;
    }

    /* --- Jadwal & Warta Card List --- */
    .list-group-item {
        padding: 0.75rem !important; /* Padding lebih kecil */
    }
    .date-box-sm {
        min-width: 50px !important; /* Kotak tanggal lebih kecil */
    }
    .date-box-sm .h6 {
        font-size: 1rem !important;
    }
    .event-title-sm {
        font-size: 0.9rem; /* Judul kegiatan lebih kecil */
    }
    .small-info {
        font-size: 0.75rem !important; /* Info lebih kecil */
    }
    .event-badge-sm {
        font-size: 0.6rem; /* Badge lebih kecil */
    }
    .event-status-sm {
        font-size: 0.7rem; /* Status badge lebih kecil */
    }

    /* --- Lokasi (Map) --- */
    .map-responsive iframe {
        height: 300px; /* Tinggi peta dikurangi di mobile */
    }
    
    /* --- Footer --- */
    .footer-contact, .footer-hours {
        font-size: 0.8rem; /* Font footer lebih kecil */
    }
}
</style>