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
                        <span class="fw-bold text-white">Paroki Santa Melania</span>
                        <span class="fs-7 text-white-50" style="font-size: 0.75rem;">Sistem Informasi Katekumen dan Baptis Bayi</span>
                    </div>
                </Link>

                <div class="d-flex gap-2 align-items-center ms-auto">
                    <Link href="/user/login" class="btn btn-outline-light btn-sm px-4">Masuk</Link>
                </div>
            </div>
        </nav>

        <section class="sub-hero d-flex align-items-center">
            <div class="overlay"></div>
            <div class="container position-relative text-center text-white z-1">
                <p class="lead mb-2 text-white-50 mx-auto" style="max-width: 600px;">
                    Warta Paroki
                </p>
                <h2 class="display-5 fw-bold mb-3">{{ post.title }}</h2>
            </div>
        </section>

        <section class="py-5 bg-white">
            <div class="container py-4">
                <div class="row justify-content-center">
                    <div class="col-lg-10">

                        <div class="card shadow-lg border-0 mb-4">
                            <div class="card-body p-5">

                                <div class="d-flex align-items-center mb-4 border-bottom pb-3">
                                    <div class="date-box bg-warning-subtle text-warning rounded p-2 text-center me-3"
                                        style="min-width: 60px;">
                                        <span class="d-block fw-bold h5 mb-0">{{ formatDate(post.created_at, 'day') }}</span>
                                        <span class="d-block small fw-bold">{{ formatDate(post.created_at, 'month') }}</span>
                                    </div>
                                    <div>
                                        <h1 class="h3 fw-bold text-navy mb-0">{{ post.title }}</h1>
                                        <p class="mb-0 text-muted small">
                                            <i class="far fa-calendar-alt me-1"></i>
                                            Diterbitkan: {{ formatDate(post.created_at, 'full') }}
                                        </p>
                                    </div>
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

                        <div class="text-center mt-5">
                            <h4 class="text-navy fw-bold">Bagikan Warta Ini</h4>
                            <div class="d-flex justify-content-center gap-3 mt-3">
                                <a href="#" class="btn btn-primary rounded-circle"><i class="fab fa-facebook-f"></i></a>
                                <a href="#" class="btn btn-success rounded-circle"><i class="fab fa-whatsapp"></i></a>
                                <a href="#" class="btn btn-info rounded-circle"><i class="fab fa-twitter"></i></a>
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
                        <p class="small opacity-75">
                            Jl. Melania No.1-3, Cihaur Geulis, Kec. Cibeunying Kaler, Kota Bandung, Jawa Barat 40122<br>
                            Telp: (022) 20463790<br>
                            Email: sekretariat@stmelania.org
                        </p>
                    </div>
                    <div class="col-lg-6">
                        <h5 class="fw-bold text-warning mb-3">Jam Sekretariat</h5>
                        <ul class="list-unstyled small opacity-75">
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
    // Nama komponen untuk halaman show
    name: 'ShowPost',

    components: {
        Head,
        Link
    },

    // Menerima satu objek 'post' sebagai prop
    props: {
        post: Object,
    },

    setup() {
        // --- Fungsi Pembantu untuk Format Tanggal (diambil dari kode sebelumnya) ---
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
            isScrolled,
            formatDate,
        }
    }
}
</script>

<style scoped>
/* Tambahkan atau salin semua CSS dari halaman index sebelumnya di sini */
/* Pastikan semua variabel dan kelas kustom (seperti .text-navy, .bg-navy, .sub-hero, .date-box) disalin */
/* Saya hanya menyertakan CSS esensial yang TIDAK ada di file sebelumnya */

.text-navy { color: #003366; }
.bg-navy { background-color: #003366; }
.text-warning { color: #ffc107 !important; }
.text-primary { color: #003366 !important; }
.bg-primary-subtle { background-color: #cfe2ff !important; }
.bg-warning-subtle { background-color: #fff3cd !important; } /* Digunakan di date-box */
.date-box {
    width: 70px;
    height: 70px;
    border-radius: 8px; /* Sedikit lebih kotak dari icon-box */
}

/* --- Hero Section (disalin dari file index) --- */
.sub-hero {
    height: 30vh; /* Sedikit ditinggikan untuk halaman sub */
    min-height: 300px;
    background: url('/gambar/hero5.jpg') no-repeat center center/cover;
    position: relative;
    /* Margin-top agar di bawah navbar saat navbar tidak discroll */
    padding-top: 70px;
}
.sub-hero .overlay {
    position: absolute;
    top: 0; left: 0; right: 0; bottom: 0;
    background: linear-gradient(to bottom, rgba(0,51,102,0.8), rgba(0,0,0,0.6));
}

/* Penyesuaian Navbar (disalin dari file index) */
.navbar { transition: all 0.3s ease-in-out; padding: 1rem 0; background: transparent; }
.navbar.scrolled { background: #003366; padding: 0.5rem 0; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
/* ... (pastikan semua CSS dari file sebelumnya disalin ke sini) ... */

/* Gaya untuk Konten Post (Jika post.body berisi markup) */
.post-content h1, .post-content h2, .post-content h3 {
    color: var(--navy-primary);
    margin-top: 1.5rem;
    margin-bottom: 0.8rem;
    font-weight: 700;
}
.post-content p {
    line-height: 1.8;
    margin-bottom: 1rem;
    color: #343a40;
}
</style>
