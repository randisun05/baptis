<template>
    <Head>
        <title>{{ post.title }} - Paroki Santa Melania</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap"
            rel="stylesheet">
    </Head>

    <div class="landing-wrapper">

        <nav class="navbar navbar-expand-lg fixed-top" :class="{ 'scrolled': isScrolled }">
            <div class="container">

                <Link href="/" class="navbar-brand d-flex align-items-center">
                    <i class="fas fa-church me-2 fa-lg text-warning"></i>
                    <div class="d-flex flex-column lh-sm">
                        <span class="fw-bold text-white small-brand-title">Paroki Santa Melania</span>
                        <span class="fs-7 text-white-50 small-subtitle" style="font-size: 0.75rem;">Sistem Informasi Katekumen dan Baptis Bayi</span>
                    </div>
                </Link>

                <div class="d-flex gap-2 align-items-center ms-auto">
                    <Link href="/user/login" class="btn btn-outline-light btn-sm px-4">Masuk</Link>
                </div>
            </div>
        </nav>

        <section class="sub-hero d-flex align-items-center">
            <div class="overlay"></div>
            <div class="container position-relative text-center text-white z-1 py-5">
                <p class="lead mb-2 text-white-50 mx-auto warta-lead-text" style="max-width: 600px;">
                    Warta Paroki
                </p>
                <h2 class="display-5 fw-bold mb-3 hero-title">{{ post.title }}</h2>
            </div>
        </section>

        <section class="py-5 bg-light">
            <div class="container py-4">
                <div class="row justify-content-center">
                    <div class="col-lg-10">

                        <div class="card shadow-lg border-0 mb-4">
                            <div class="card-body p-4 p-md-5"> <div class="d-flex align-items-center mb-4 border-bottom pb-3 header-info">
                                    <div class="date-box bg-warning-subtle text-warning rounded p-2 text-center me-3 date-box-sm">
                                        <span class="d-block fw-bold h5 mb-0">{{ formatDate(post.created_at, 'day') }}</span>
                                        <span class="d-block small fw-bold">{{ formatDate(post.created_at, 'month') }}</span>
                                    </div>
                                    <div>
                                        <h1 class="h4 fw-bold text-navy mb-0 post-title-main">{{ post.title }}</h1>
                                        <p class="mb-0 text-muted small post-meta-info">
                                            <i class="far fa-calendar-alt me-1"></i>
                                            Diterbitkan: {{ formatDate(post.created_at, 'full') }}
                                        </p>
                                    </div>
                                </div>
                                
                                <div v-if="post.image" class="mb-4 post-image-wrapper">
                                    <img :src="`/storage/${post.image}`" :alt="post.title" class="img-fluid rounded-lg post-image">
                                </div>
                                <div class="post-content">
                                    <div v-html="post.body"></div> 
                                </div>

                                <div class="mt-5 pt-3 border-top text-center">
                                    <Link href="/warta" class="btn btn-outline-navy px-4">
                                        <i class="fas fa-arrow-left me-2"></i> Kembali ke Daftar Warta
                                    </Link>
                                </div>

                            </div>
                        </div>
                    </div>
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
                    &copy; 2025 Paroki Santa Melania - Sistem Informasi Katekumen & Baptis Bayi.
                </div>
            </div>
        </footer>

    </div>
</template>

<script>
import { Head, Link } from '@inertiajs/inertia-vue3';
import { ref, onMounted, onUnmounted } from 'vue';

export default {
    name: 'ShowPost',

    components: {
        Head,
        Link
    },

    props: {
        post: Object,
    },

    setup() {
        // --- Fungsi Pembantu untuk Format Tanggal ---
        const formatDate = (dateString, formatType) => {
            if (!dateString) return '';
            const date = new Date(dateString);

            // Menggunakan 'id-ID' untuk format bahasa Indonesia (nama bulan)
            const fullOptions = { year: 'numeric', month: 'long', day: 'numeric' };

            if (formatType === 'day') {
                return date.getDate().toString().padStart(2, '0');
            }
            if (formatType === 'month') {
                // Menggunakan 'short' untuk bulan, dan diubah ke uppercase di template
                return date.toLocaleDateString('id-ID', { month: 'short' }).toUpperCase();
            }
            if (formatType === 'full') {
                return date.toLocaleDateString('id-ID', fullOptions);
            }
            return dateString;
        };

        // --- Logika untuk Navbar berubah warna saat discroll ---
        const isScrolled = ref(false);

        const handleScroll = () => {
            isScrolled.value = window.scrollY > 50;
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
/* Variabel Warna Kustom */
.text-navy { color: #003366; }
.bg-navy { background-color: #003366; }
.btn-outline-navy { color: #003366; border-color: #003366; }
.btn-outline-navy:hover { background-color: #003366; color: white; }

/* Warna standar Bootstrap yang digunakan */
.text-warning { color: #ffc107 !important; }
.text-primary { color: #003366 !important; }
.bg-primary-subtle { background-color: #cfe2ff !important; }
.bg-warning-subtle { background-color: #fff3cd !important; } 

/* --- Layout dan Komponen Khusus --- */
.landing-wrapper {
    font-family: 'Poppins', sans-serif;
}
.date-box {
    width: 70px;
    height: 70px;
    display: flex; /* Tambahkan ini untuk centring konten */
    flex-direction: column;
    justify-content: center;
    align-items: center;
    border-radius: 8px;
    flex-shrink: 0; /* Pastikan tidak mengecil saat judul panjang */
}
.small-brand-title { font-size: 0.85rem; }
.small-subtitle { font-size: 0.7rem !important; }

/* --- Hero Section --- */
.sub-hero {
    height: 30vh;
    min-height: 250px; /* Disesuaikan agar lebih mobile friendly */
    background: url('/gambar/hero5.jpg') no-repeat center center/cover;
    position: relative;
    padding-top: 70px; 
}
.sub-hero .overlay {
    position: absolute;
    top: 0; left: 0; right: 0; bottom: 0;
    background: linear-gradient(to bottom, rgba(0,51,102,0.8), rgba(0,0,0,0.6));
}

/* --- Navbar Styling --- */
.navbar { 
    transition: all 0.3s ease-in-out; 
    padding: 1rem 0; 
    background: transparent; 
}
.navbar.scrolled { 
    background: #003366; 
    padding: 0.5rem 0; 
    box-shadow: 0 2px 10px rgba(0,0,0,0.1); 
}

/* --- Post Content Styling --- */
.post-content h1, .post-content h2, .post-content h3 {
    color: #003366; 
    margin-top: 1.5rem;
    margin-bottom: 0.8rem;
    font-weight: 700;
}
.post-content p {
    line-height: 1.8;
    margin-bottom: 1rem;
    color: #343a40;
}
.post-image {
    width: 100%;
    max-height: 500px;
    object-fit: cover;
    border-radius: 0.5rem !important;
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
}

/* --- Footer Link Hover --- */
footer a.text-white:hover {
    opacity: 1 !important; 
    color: #ff9900 !important; /* Orange Accent */
}

/* =======================================
    RESPONSIVE/MOBILE ADJUSTMENTS (<= 768px)
    ======================================= */
@media (max-width: 768px) {
    
    /* --- Navbar --- */
    .navbar-brand .fa-church { font-size: 1.25rem; }
    .small-brand-title { font-size: 0.8rem !important; }
    .small-subtitle { font-size: 0.6rem !important; }

    /* --- Sub Hero --- */
    .sub-hero { min-height: 200px; height: 25vh; }
    .sub-hero .py-5 { padding-top: 3rem !important; padding-bottom: 3rem !important; }
    .hero-title { font-size: 1.75rem !important; }
    .warta-lead-text { font-size: 0.875rem !important; }

    /* --- Post Card Content --- */
    .card-body {
        padding: 1.5rem !important; /* Kurangi padding kartu di HP */
    }

    /* Info Header (Date Box & Title) */
    .header-info {
        align-items: flex-start !important;
    }
    .date-box-sm {
        min-width: 55px !important;
        height: 55px !important;
        padding: 0.5rem !important;
    }
    .date-box-sm .h5 {
        font-size: 1rem !important;
    }
    .date-box-sm .small {
        font-size: 0.65rem !important;
    }
    .post-title-main { 
        font-size: 1.1rem !important; /* Judul postingan lebih kecil */
    }
    .post-meta-info {
        font-size: 0.75rem !important;
    }

    /* Post Content */
    .post-content p {
        line-height: 1.6;
        font-size: 0.9rem;
    }

    /* Footer */
    .footer-contact, .footer-hours {
        font-size: 0.8rem;
    }
}
</style>