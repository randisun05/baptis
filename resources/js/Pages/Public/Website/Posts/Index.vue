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
                        <span class="fw-bold text-white">Paroki Santa Melania</span>
                        <span class="fs-7 text-white-50" style="font-size: 0.75rem;">Sistem Informasi Katekumen dan Baptis
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
                <div class="container position-relative text-center text-white z-1">
                    <p class="lead mb-4 text-white-50 mx-auto" style="max-width: 600px;">

                    </p>
                    <h2 class="display-4 fw-bold mb-3"> {{ title }}</h2>
                </div>
            </section>

           <section class="py-5 bg-light" id="warta">
    <div class="container py-4">
        <div class="row">
            <div class="col-lg-12">
                <h2 class="fw-bold text-navy mb-4">Daftar Warta Paroki</h2>
                <div class="card shadow-sm border-0">
                    <div class="card-body p-0">
                        <div class="list-group list-group-flush">

                            <div class="list-group-item p-4 d-flex flex-column"
                                v-for="(post, index) in posts.data" :key="index">

                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <div class="d-flex align-items-center">

                                        <div class="date-box bg-primary-subtle text-primary rounded p-2 text-center me-3"
                                            style="min-width: 60px;">
                                            <span class="d-block fw-bold h5 mb-0">{{ formatDate(post.created_at, 'day') }}</span>
                                            <span class="d-block small fw-bold">{{ formatDate(post.created_at, 'month') }}</span>
                                        </div>

                                        <div>
                                            <h5 class="fw-bold mb-1 text-navy">{{ post.title }}</h5>
                                            <p class="mb-0 text-muted small">
                                                <i class="far fa-calendar-alt me-1"></i>
                                                Diterbitkan: {{ formatDate(post.created_at, 'full') }}
                                            </p>
                                        </div>
                                    </div>

                                    <Link :href="`/warta/${post.slug}`"
                                        class="btn btn-sm btn-outline-primary shadow ms-4 flex-shrink-0" type="button">
                                        <i class="fas fa-eye me-1"></i> Lihat Post
                                    </Link>
                                </div>

                                <div class="w-100 mt-2 ps-3">
                                    <p class="small text-muted mb-0 border-start border-3 ps-3">
                                        {{ post.excerpt }}
                                    </p>
                                </div>
                            </div>
                            <div v-if="posts.data && posts.data.length === 0" class="list-group-item text-center text-muted p-4">
                                Belum ada warta paroki terbaru yang diterbitkan.
                            </div>

                        </div>
                    </div>

                      <Pagination :links="posts.links" align="end" />

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
    import Pagination from '../../../../Components/Pagination.vue'; // Sesuaikan path

    export default {
        components: {
            Head,
            Link,
            Pagination
        },

        props: {
            title: String,
            posts: Array,
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
    </style>
