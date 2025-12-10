<template>
    <Head>
        <title>{{ post.title }} - Paroki Santa Melania</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap"
            rel="stylesheet">
    </Head>

    <div class="landing-wrapper container-fluid px-4 py-4 fade-in">
        <section class="py-lg-5 bg-white">
            <div class="container py-md-4 px-0 px-md-3">
                <div class="row justify-content-center">
                    <div class="col-lg-10">

                        <div class="card shadow-sm border-0 rounded-4 mb-4">
                            <div class="card-body p-4 p-md-5">

                                <div class="d-flex align-items-start mb-4 border-bottom pb-3 header-mobile-stack">
                                    
                                    <div class="date-box bg-warning-subtle text-warning rounded p-2 text-center me-3 date-box-mobile">
                                        <span class="d-block fw-bold h5 mb-0 date-day-mobile">{{ formatDate(post.created_at, 'day') }}</span>
                                        <span class="d-block small fw-bold date-month-mobile">{{ formatDate(post.created_at, 'month') }}</span>
                                    </div>
                                    
                                    <div class="flex-grow-1">
                                        <h1 class="h3 fw-bold text-navy mb-1 post-title-mobile">{{ post.title }}</h1>
                                        <p class="mb-0 text-muted small post-date-mobile">
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
                                    <Link href="/user/posts/list" class="btn btn-outline-navy px-4 w-100-mobile">
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
/* --- Custom Colors & Variables (Sama dengan kode sebelumnya) --- */
:root {
    --navy-primary: #003366;
    --orange-accent: #ff9900;
}

.text-navy { color: #003366; }
.bg-navy { background-color: #003366; }
.btn-outline-navy { color: #003366; border-color: #003366; }
.btn-outline-navy:hover { background-color: #003366; color: white; }

.card { border-radius: 1rem; }

/* Warna standar Bootstrap yang digunakan */
.text-warning { color: #ffc107 !important; }
.text-primary { color: #003366 !important; }
.bg-primary-subtle { background-color: #cfe2ff !important; }
.bg-warning-subtle { background-color: #fff3cd !important; }

/* --- Animasi Fade-In --- */
.fade-in { animation: fadeIn 0.8s ease-in-out; }
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

/* --- Layout dan Komponen Khusus --- */
.landing-wrapper {
    font-family: 'Poppins', sans-serif;
}

/* Date Box Styling */
.date-box {
    min-width: 60px;
    height: 60px;
    border-radius: 8px;
    display: flex;
    flex-direction: column;
    justify-content: center;
}
.date-box .h5 {
    font-size: 1.5rem;
}

/* Post Content Styling (untuk konsistensi) */
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

/* Gaya untuk Gambar Postingan */
.post-image {
    width: 100%;
    max-height: 500px;
    object-fit: cover;
    border-radius: 0.5rem !important;
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
}

/* --- Penyesuaian Responsif untuk Perangkat Seluler (Mobile-Friendly) --- */

@media (max-width: 767.98px) {
    /* Container Utama & Padding */
    .landing-wrapper.container-fluid.px-4.py-4 {
        padding: 1rem !important;
    }

    /* Card & Padding */
    .card-body.p-4.p-md-5 {
        padding: 1.5rem !important; /* Kurangi padding card */
    }

    /* Header (Tanggal + Judul) */
    .d-flex.align-items-start.mb-4.border-bottom.pb-3.header-mobile-stack {
        /* Tidak perlu di-stack, hanya perkecil komponen */
        align-items: flex-start !important; 
    }

    /* Date Box mobile */
    .date-box-mobile {
        min-width: 50px !important;
        height: 50px;
        padding: 0.5rem !important;
    }

    .date-day-mobile {
        font-size: 1.2rem !important; /* Perkecil angka hari */
    }
    .date-month-mobile {
        font-size: 0.6rem !important; /* Perkecil tulisan bulan */
    }

    /* Judul dan Tanggal Teks */
    .post-title-mobile {
        font-size: 1.2rem !important; /* Perkecil h1/h3 */
    }
    .post-date-mobile {
        font-size: 0.75rem !important;
    }
    
    /* Post Image */
    .post-image {
        max-height: 300px; /* Batasi tinggi gambar di mobile */
    }

    /* Post Content (memastikan teks mudah dibaca) */
    .post-content {
        font-size: 0.9rem;
    }
    .post-content p {
        line-height: 1.6;
        margin-bottom: 0.8rem;
    }

    /* Tombol Kembali */
    .w-100-mobile {
        width: 100% !important; /* Tombol kembali penuh */
    }
}
</style>