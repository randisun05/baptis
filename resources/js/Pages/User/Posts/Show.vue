<template>
    <Head>
        <title>{{ post.title }} - Paroki Santa Melania</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap"
            rel="stylesheet">
    </Head>

    <div class="landing-wrapper">
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
                                
                                <div v-if="post.image" class="mb-4 post-image-wrapper">
                                  <img :src="`/storage/${post.image}`" :alt="post.title" class="img-fluid rounded-lg post-image">
                                </div>
                                <div class="post-content">
                                    <div v-html="post.body"></div>
                                </div>

                                <div class="mt-5 pt-3 border-top text-center">
                                    <Link href="/user/posts/list" class="btn btn-outline-navy px-4">
                                        <i class="fas fa-arrow-left me-2"></i> Kembali ke Daftar Warta
                                    </Link>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
import { Head, Link } from '@inertiajs/inertia-vue3';
import { ref, onMounted, onUnmounted } from 'vue';
import LayoutWebsite from '../../../Layouts/User.vue'; // Pastikan path ini benar

export default {
      // 1. OPSI LAYOUT DARI INERTIA
    layout: LayoutWebsite, 
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
/* Variabel Warna Kustom */
.text-navy { color: #003366; }
.bg-navy { background-color: #003366; }
.btn-outline-navy { color: #003366; border-color: #003366; }
.btn-outline-navy:hover { background-color: #003366; color: white; }

/* Warna standar Bootstrap yang digunakan */
.text-warning { color: #ffc107 !important; }
.text-primary { color: #003366 !important; }
.bg-primary-subtle { background-color: #cfe2ff !important; }
.bg-warning-subtle { background-color: #fff3cd !important; } /* Digunakan di date-box */

/* --- Layout dan Komponen Khusus --- */
.landing-wrapper {
    font-family: 'Poppins', sans-serif;
}
.date-box {
    width: 70px;
    height: 70px;
    border-radius: 8px;
}
.fs-7 {
    font-size: 0.85rem !important;
}

/* --- Hero Section --- */
.sub-hero {
    height: 30vh;
    min-height: 300px;
    background: url('/gambar/hero5.jpg') no-repeat center center/cover;
    position: relative;
    padding-top: 70px; /* Offset dari navbar */
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
    color: #003366; /* Menggunakan .text-navy */
    margin-top: 1.5rem;
    margin-bottom: 0.8rem;
    font-weight: 700;
}
.post-content p {
    line-height: 1.8;
    margin-bottom: 1rem;
    color: #343a40;
}

/* --- Gaya untuk Gambar Postingan (Baru Ditambahkan) --- */
.post-image {
    width: 100%;
    max-height: 500px; /* Batasi tinggi maksimum */
    object-fit: cover;
    border-radius: 0.5rem !important;
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
}

/* --- Share Buttons --- */
.d-flex.justify-content-center.gap-3 a.btn {
    width: 45px;
    height: 45px;
    display: flex;
    align-items: center;
    justify-content: center;
}
</style>