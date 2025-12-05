<template>
    <Head>
        <title>Warta - Paroki Santa Melania</title>
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
                        <span class="fs-7 text-white-50" style="font-size: 0.7rem;">Sistem Informasi Katekumen & Baptis Bayi</span>
                    </div>
                </Link>

                <div class="d-flex gap-2 align-items-center ms-auto">
                    <Link href="/user/login" class="btn btn-outline-light btn-sm px-3">Masuk</Link>
                </div>
            </div>
        </nav>

        <section class="sub-hero d-flex align-items-center">
            <div class="overlay"></div>
            <div class="container position-relative text-center text-white z-1 py-5">
                <h1 class="display-5 fw-bold mb-2">Warta Paroki</h1>
                <p class="lead mb-0 text-white-50 mx-auto small-text" style="max-width: 600px; font-size: 1rem;">
                    Informasi dan pengumuman terbaru untuk umat Paroki Santa Melania.
                </p>
            </div>
        </section>

        <div class="container pt-4">
            <Link href="/" class="btn btn-outline-secondary border-0 shadow-sm mb-4 btn-sm">
                <i class="fas fa-arrow-left me-1"></i> Kembali ke Beranda
            </Link>
        </div>

        <section class="pb-5 bg-light" id="warta">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card shadow-sm border-0">
                            <div class="card-body p-0">
                                <div class="list-group list-group-flush">

                                    <div class="list-group-item p-4 d-flex flex-column list-item-mobile"
                                        v-for="(post, index) in posts.data" :key="index">

                                        <div class="d-flex align-items-center justify-content-between header-row">
                                            <div class="d-flex align-items-center">

                                                <div class="date-box bg-primary-subtle text-primary rounded p-2 text-center me-3 date-box-md">
                                                    <span class="d-block fw-bold h5 mb-0">{{ formatDate(post.created_at, 'day') }}</span>
                                                    <span class="d-block small fw-bold">{{ formatDate(post.created_at, 'month') }}</span>
                                                </div>

                                                <div>
                                                    <h5 class="fw-bold mb-1 text-navy post-title">{{ post.title }}</h5>
                                                    <p class="mb-0 text-muted small small-info">
                                                        <i class="far fa-calendar-alt me-1"></i>
                                                        Diterbitkan: {{ formatDate(post.created_at, 'full') }}
                                                    </p>
                                                </div>
                                            </div>

                                            <Link :href="`/warta/${post.slug}`"
                                                class="btn btn-sm btn-outline-primary shadow ms-4 flex-shrink-0 view-btn" type="button">
                                                <i class="fas fa-eye me-1"></i> Lihat Post
                                            </Link>
                                        </div>

                                        <div class="w-100 mt-3 pt-3 border-top excerpt-row">
                                            <p class="small text-muted mb-0 small-text">
                                                {{ post.excerpt || 'Klik Lihat Post untuk membaca selengkapnya.' }}
                                            </p>
                                        </div>
                                    </div>

                                    <div v-if="posts.data && posts.data.length === 0" class="list-group-item text-center text-muted p-4">
                                        Belum ada warta paroki terbaru yang diterbitkan.
                                    </div>

                                </div>
                            </div>

                            <div class="card-footer bg-white border-top p-3">
                                <Pagination :links="posts.links" align="end" />
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
import Pagination from '../../../../Components/Pagination.vue'; 

export default {
    components: {
        Head,
        Link,
        Pagination
    },

    props: {
        title: String,
        posts: Object, // Menggunakan Object untuk pagination data
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
            // Mengubah menjadi navy setelah scroll 50px
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
/* --- Custom Colors & Variables (Copy dari index.vue) --- */
:root {
    --navy-primary: #003366;
    --orange-accent: #ff9900;
}

.text-navy { color: #003366; }
.bg-navy { background-color: #003366; }
.text-warning { color: #ff9900 !important; }

/* Menggunakan kembali warna primary yang konsisten */
.text-primary { color: #003366 !important; } 

.btn-primary {
    background-color: #003366;
    border-color: #003366;
}
.btn-primary:hover {
    background-color: #002244;
    border-color: #002244;
}
.small-brand-title { font-size: 0.85rem; } /* Konsistensi ukuran brand title */

/* --- Typography --- */
.landing-wrapper {
    font-family: 'Poppins', sans-serif;
}

/* --- Navbar (Copy dari index.vue) --- */
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
.navbar-brand .fa-church { font-size: 1.5rem; }
.navbar-brand { padding-top: 0; padding-bottom: 0; }
.lh-sm { line-height: 1.25; } 

.btn-outline-light:hover {
    background-color: white;
    color: var(--navy-primary);
}
.navbar:not(.scrolled) .btn-primary {
    background-color: var(--navy-primary); 
    border-color: var(--navy-primary);
}

/* --- SUB HERO SECTION (Menyesuaikan dengan style Hero) --- */
.sub-hero {
    height: 30vh; /* Sedikit lebih tinggi dari sub-hero awal */
    min-height: 250px;
    background: url('/gambar/hero5.jpg') no-repeat center center/cover;
    position: relative;
    margin-top: 0; 
}
.sub-hero .overlay {
    position: absolute;
    top: 0; left: 0; right: 0; bottom: 0;
    background: linear-gradient(to bottom, rgba(0,51,102,0.8), rgba(0,0,0,0.6));
}
.sub-hero .container {
    padding-top: 5rem !important; /* Memberi ruang di atas */
}

/* --- Daftar Warta Spesifik --- */
.date-box-md {
    min-width: 70px !important; /* Ukuran yang sedikit lebih besar dari mobile di landing page */
}
.date-box-md .h5 {
    font-size: 1.25rem;
}


/* Tambahan Warna Subtle (Copy dari index.vue) */
.bg-primary-subtle { background-color: #cfe2ff !important; }
.text-primary { color: #0a58ca !important; }
.bg-success-subtle { background-color: #d1e7dd !important; }
.text-success { color: #198754 !important; }
.bg-warning-subtle { background-color: #fff3cd !important; }
.text-warning { color: #ffc107 !important; } 


/* --- STYLE UNTUK HOVER WHATSAPP DI FOOTER --- */
footer a.text-white:hover {
    opacity: 1 !important; 
    color: var(--orange-accent) !important;
}

/* =======================================
   RESPONSIVE/MOBILE ADJUSTMENTS (<= 768px)
   ======================================= */
@media (max-width: 768px) {
    /* --- Navbar --- */
    .navbar { padding: 0.75rem 0; }
    .navbar-brand .fa-church { font-size: 1.25rem; }
    .small-brand-title { font-size: 0.85rem; }
    .navbar-brand span:nth-child(2) { font-size: 0.65rem !important; } /* sub title */

    /* --- Sub Hero --- */
    .sub-hero { min-height: 200px; height: 25vh; }
    .sub-hero .container { padding-top: 3rem !important; }
    .sub-hero .display-5 { font-size: 1.75rem; }
    .sub-hero .small-text { font-size: 0.875rem !important; }

    /* --- List Warta --- */
    .list-group-item { padding: 1rem !important; } 
    
    .header-row {
        flex-direction: column; /* Ubah menjadi tumpukan vertikal */
        align-items: flex-start !important;
        width: 100%;
    }
    /* Kotak Tanggal menyesuaikan */
    .date-box-md {
        min-width: 50px !important;
        padding: 0.5rem !important;
        margin-right: 0.75rem !important;
    }
    .date-box-md .h5 { font-size: 1rem !important; }
    .date-box-md .small { font-size: 0.65rem !important; }

    /* Judul Post */
    .post-title { font-size: 1rem !important; }
    .small-info { font-size: 0.75rem !important; } /* Tanggal terbit */

    /* Tombol Lihat Post */
    .view-btn {
        width: 100%; /* Lebar penuh */
        margin-left: 0 !important;
        margin-top: 1rem; 
        order: 3; /* Memindahkan tombol ke bawah */
    }
    
    /* Ringkasan Post */
    .excerpt-row {
        margin-top: 1rem !important;
        padding-top: 1rem !important;
    }
    .excerpt-row p { font-size: 0.8rem !important; } 

    /* --- Footer --- */
    .footer-contact, .footer-hours {
        font-size: 0.8rem; /* Font footer lebih kecil */
    }
}
</style>