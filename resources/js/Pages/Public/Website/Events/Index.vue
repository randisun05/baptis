<template>
    <Head>
        <title>Kegiatan - Paroki Santa Melania</title>
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
                        <span class="fs-7 text-white-50 small-brand-subtitle">Sistem Informasi Katekumen dan Baptis
                            Bayi</span>
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
                <h1 class="display-5 fw-bold mb-2">Daftar Kegiatan</h1>
                <p class="lead mb-0 text-white-50 mx-auto small-text" style="max-width: 600px; font-size: 1rem;">
                    Informasi dan jadwal kegiatan katekumen dan sakramen baptis bayi yang tersedia.
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

                                    <div class="list-group-item p-4 d-flex align-items-center justify-content-between event-list-item"
                                        v-for="(event, index) in events.data" :key="index">

                                        <div class="d-flex align-items-start event-main-info">

                                            <div class="date-box bg-primary-subtle text-primary rounded p-2 text-center me-3 date-box-md">
                                                <span class="d-block fw-bold h5 mb-0">{{ formatDate(event.date, 'day') }}</span>
                                                <span class="d-block small fw-bold">{{ formatDate(event.date, 'month') }}</span>
                                            </div>

                                            <div class="event-details">
                                                <h5 class="fw-bold mb-1 text-navy event-title">{{ event.title }}</h5>
                                                <p class="mb-0 text-muted small small-info">
                                                    <i class="far fa-calendar-alt me-1"></i>
                                                    Tanggal: {{ formatDate(event.date, 'full') }}
                                                </p>
                                                <p class="mb-0 text-muted small small-info">
                                                    <i class="fas fa-map-marker-alt me-1"></i>
                                                    Lokasi: {{ event.place }}
                                                </p>
                                            </div>
                                        </div>

                                        <div class="d-flex flex-column align-items-end gap-2 event-badges">
                                            <span v-if="event.ref_event" class="badge rounded-pill px-3 py-2 bg-info-subtle text-info-emphasis event-ref-badge">
                                                {{ event.ref_event.title }}
                                            </span>
                                            
                                            <span class="badge rounded-pill px-3 py-2 event-status-badge"
                                                :class="event.status === 'active' ? 'bg-success' : 'bg-secondary'">
                                                {{ event.status === 'active' ? 'Aktif' : 'Ditutup' }}
                                            </span>
                                        </div>


                                    </div>
                                    <div v-if="events.data && events.data.length === 0" class="list-group-item text-center text-muted p-4">
                                        Belum ada kegiatan paroki terbaru.
                                    </div>

                                </div>
                            </div>

                            <div class="card-footer bg-white border-top p-3">
                                <Pagination :links="events.links" align="end" />
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
                            <a href="mailto:sekretariat@stmelania.org" class="text-white opacity-75 text-decoration-none">
                                Email: sekretariat@stmelania.org
                            </a>
                        </p>
                    </div>
                    <div class="col-lg-6">
                        <h5 class="fw-bold text-warning mb-3">Jam Sekretariat</h5>
                        <ul class="list-unstyled small opacity-75 footer-hours">
                            <li class="d-flex justify-content-between mb-2"><span>Senin:</span> <span>08.00 –
                                    16.00</span></li>
                            <li class="d-flex justify-content-between mb-2"><span>Selasa:</span> <span>08.00 –
                                    16.00</span></li>
                            <li class="d-flex justify-content-between mb-2"><span>Rabu:</span> <span>08.00 –
                                    16.00</span></li>
                            <li class="d-flex justify-content-between mb-2"><span>Kamis & Libur Nasional:</span>
                                <span>LIBUR</span></li>
                            <li class="d-flex justify-content-between mb-2"><span>Jumat:</span> <span>08.00 –
                                    16.00</span></li>
                            <li class="d-flex justify-content-between mb-2"><span>Jumat Pertama & Sabtu:</span>
                                <span>08.00-14.00 & 16.00-18.00</span></li>
                            <li class="d-flex justify-content-between"><span>Minggu:</span> <span>07.00 – 12.00</span>
                            </li>
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
        events: Object, // Menampung pagination data
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
                return date.toLocaleDateString('id-ID', { month: 'short' }).toUpperCase();
            }
            if (formatType === 'full') {
                return date.toLocaleDateString('id-ID', fullOptions);
            }
            return dateString;
        };

        // Logika untuk Navbar berubah warna saat discroll
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
/* --- Custom Colors & Variables --- */
:root {
    --navy-primary: #003366;
    --orange-accent: #ff9900;
}

.text-navy {
    color: #003366;
}

.bg-navy {
    background-color: #003366;
}

.text-warning {
    color: #ff9900 !important;
}

.text-primary {
    color: #003366 !important;
}

/* Menambahkan primary color */

.btn-primary {
    background-color: #003366;
    border-color: #003366;
}

.btn-primary:hover {
    background-color: #002244;
    border-color: #002244;
}
.btn-outline-primary {
    color: #003366;
    border-color: #003366;
}
.btn-outline-primary:hover {
    background-color: #003366;
    color: white;
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
    /* Transparan di awal */
}

.navbar.scrolled {
    background: var(--navy-primary);
    /* Navy saat discroll */
    padding: 0.5rem 0;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

/* Penyesuaian Navbar Brand */
.navbar-brand .fa-church {
    font-size: 1.5rem;
}

.navbar-brand {
    padding-top: 0;
    padding-bottom: 0;
}

.lh-sm {
    line-height: 1.25;
}

/* Bootstrap class */

/* Navbar Links Styling (TIDAK DIGUNAKAN, tapi kelas style tetap ada) */
.nav-link {
    color: rgba(255, 255, 255, 0.8) !important;
    font-weight: 500;
    transition: color 0.2s ease;
}

.nav-link:hover,
.nav-link:focus {
    color: white !important;
}

/* --- Hero Section --- */
.hero {
    height: 100vh;
    /* Full Screen */
    min-height: 600px;
    background: url('/gambar/hero5.jpg') no-repeat center center/cover;
    /* Pastikan path gambar benar */
    position: relative;
    margin-top: -76px;
    /* Menarik ke atas agar di belakang navbar (adjust if necessary) */
}

.sub-hero {
    height: 20vh;
    /* Full Screen */
    min-height: 300px;
    background: url('/gambar/hero5.jpg') no-repeat center center/cover;
    /* Pastikan path gambar benar */
    position: relative;
}

.sub-hero .overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(to bottom, rgba(0, 51, 102, 0.8), rgba(0, 0, 0, 0.6));
}

.hero .overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(to bottom, rgba(0, 51, 102, 0.8), rgba(0, 0, 0, 0.6));
}

/* --- Cards & Hover Effects --- */
.hover-up {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.hover-up:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
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
    top: 25px;
    /* Setengah dari tinggi step-icon */
    left: 15%;
    right: 15%;
    height: 2px;
    background-color: #e9ecef;
    z-index: 1;
}

/* --- Utilities --- */
.ls-1 {
    letter-spacing: 1px;
}

/* Tambahan Warna Subtle untuk Section Layanan */
.bg-primary-subtle {
    background-color: #cfe2ff !important;
}

.text-primary {
    color: #0a58ca !important;
}

.bg-success-subtle {
    background-color: #d1e7dd !important;
}

.text-success {
    color: #198754 !important;
}

.bg-warning-subtle {
    background-color: #fff3cd !important;
}

.text-warning {
    color: #ffc107 !important;
}

/* Mengubah ini agar lebih cerah */
.bg-secondary-subtle {
    background-color: #e2e3e5 !important;
}

.text-secondary {
    color: #6c757d !important;
}

.bg-info-subtle { background-color: #cff4fc !important; }
.text-info-emphasis { color: #055160 !important; }

/* Menghapus background button kontak saat tidak discroll, karena sudah pakai btn-outline-light */
.btn-outline-light:hover {
    background-color: white;
    color: var(--navy-primary);
}

.navbar:not(.scrolled) .btn-primary {
    background-color: var(--navy-primary);
    /* Pastikan tombol Masuk tetap navy */
    border-color: var(--navy-primary);
}

/* =======================================
    RESPONSIVE/MOBILE ADJUSTMENTS (<= 768px)
    ======================================= */
@media (max-width: 768px) {
    /* --- Navbar --- */
    .navbar { padding: 0.75rem 0; }
    .navbar-brand .fa-church { font-size: 1.25rem; }
    .small-brand-title { font-size: 0.85rem; }
    .small-brand-subtitle { font-size: 0.65rem !important; } 

    /* --- Sub Hero --- */
    .sub-hero { min-height: 200px; height: 25vh; }
    .sub-hero .container { padding-top: 3rem !important; }
    .sub-hero .display-5 { font-size: 1.75rem; }
    .sub-hero .small-text { font-size: 0.875rem !important; }

    /* --- List Kegiatan --- */
    .event-list-item { 
        padding: 1rem !important; 
        flex-direction: column; /* Mengubah layout utama menjadi vertikal */
        align-items: flex-start !important;
        gap: 0.75rem; /* Memberi jarak antara info utama dan badges */
    } 

    .event-main-info {
        width: 100%;
        display: flex;
        align-items: flex-start !important;
        order: 1; /* Paling atas */
    }

    /* Kotak Tanggal menyesuaikan */
    .date-box-md {
        min-width: 50px !important;
        padding: 0.5rem !important;
        margin-right: 0.75rem !important;
    }
    .date-box-md .h5 { font-size: 1rem !important; }
    .date-box-md .small { font-size: 0.65rem !important; }

    /* Judul Kegiatan */
    .event-details {
        flex-grow: 1;
        width: 100%; /* Agar detail bisa mengisi ruang jika tanggal kecil */
    }
    .event-title { font-size: 1rem !important; }
    .small-info { font-size: 0.75rem !important; } 

    /* Badge Status (dipindahkan ke bawah info utama) */
    .event-badges {
        width: 100%;
        align-items: flex-start !important; /* Pindah ke kiri */
        flex-direction: row; /* Ubah badges menjadi horizontal */
        border-top: 1px solid #eee;
        padding-top: 0.75rem;
        margin-top: 0.75rem;
        order: 2; /* Setelah info utama */
    }
    .event-ref-badge, .event-status-badge {
        font-size: 0.75rem !important;
    }
    
    /* --- Footer --- */
    .footer-contact, .footer-hours {
        font-size: 0.8rem; /* Font footer lebih kecil */
    }
}
</style>