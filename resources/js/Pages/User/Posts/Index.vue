<template>
    <Head>
        <title>Warta - Paroki Santa Melania</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap"
            rel="stylesheet">
    </Head>

    <div class="landing-wrapper container-fluid px-4 py-4 fade-in">
        
        <div class="container pt-4 pt-md-0 px-0 px-md-3">
            <Link href="/user/dashboard" class="btn btn-outline-secondary border-0 shadow-sm mb-4 w-100-mobile">
                <i class="fas fa-arrow-left me-1"></i> Kembali ke Dashboard
            </Link>
        </div>
        
        <section class="py-lg-5" id="warta">
            <div class="container py-4 px-0 px-md-3">
                <div class="row justify-content-center">
                    <div class="col-lg-10">
                        <h2 class="fw-bold text-navy mb-4 mobile-fs-large">Daftar Warta Paroki</h2>
                        <div class="card shadow-sm border-0 rounded-4">
                            <div class="card-body p-0">
                                <div class="list-group list-group-flush">

                                    <div class="list-group-item p-4 d-flex flex-column list-item-mobile"
                                        v-for="(post, index) in posts.data" :key="index">

                                        <div class="d-flex align-items-center justify-content-between mb-3 mb-md-0">
                                            
                                            <div class="d-flex align-items-start align-items-md-center w-100">

                                                <div class="date-box bg-primary-subtle text-primary rounded p-2 text-center me-3 date-box-mobile">
                                                    <span class="d-block fw-bold h5 mb-0 date-day-mobile">{{ formatDate(post.created_at, 'day') }}</span>
                                                    <span class="d-block small fw-bold date-month-mobile">{{ formatDate(post.created_at, 'month') }}</span>
                                                </div>

                                                <div class="flex-grow-1">
                                                    <h5 class="fw-bold mb-1 text-navy post-title-mobile">{{ post.title }}</h5>
                                                    <p class="mb-0 text-muted small post-date-mobile">
                                                        <i class="far fa-calendar-alt me-1"></i>
                                                        Diterbitkan: {{ formatDate(post.created_at, 'full') }}
                                                    </p>
                                                </div>
                                            </div>

                                            <Link :href="`/user/posts/list/${post.slug}`"
                                                class="btn btn-sm btn-outline-primary shadow ms-4 flex-shrink-0 btn-action-mobile" type="button">
                                                <i class="fas fa-eye me-1"></i> Lihat Post
                                            </Link>
                                        </div>

                                        <div class="w-100 mt-3 pt-3 border-top preview-mobile">
                                            <p class="small text-muted mb-0 post-excerpt-mobile">
                                                {{ post.excerpt || 'Klik Lihat Post untuk membaca selengkapnya.' }}
                                            </p>
                                        </div>
                                    </div>
                                    
                                    <div v-if="posts.data && posts.data.length === 0" class="list-group-item text-center text-muted p-4">
                                        Belum ada warta paroki terbaru yang diterbitkan.
                                    </div>

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
    layout: LayoutWebsite, 
    
    components: {
        Head,
        Link,
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
    },
    
    methods: {
        route(name) {
            return window.route(name);
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

.bg-primary-subtle {
    background-color: #cfe2ff !important;
}

.text-primary {
    color: #0a58ca !important;
}

.card {
    border-radius: 1rem; 
}

/* Animasi Fade-In */
.fade-in { animation: fadeIn 0.8s ease-in-out; }
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

/* Tombol Primary */
.btn-primary {
    background-color: #003366;
    border-color: #003366;
}

.btn-primary:hover {
    background-color: #002244;
    border-color: #002244;
}

/* LIST GROUP ITEMS SPECIFIC STYLING */

/* Date Box Styling */
.date-box {
    min-width: 60px;
    height: 60px; /* Tambahkan tinggi agar kotak */
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.date-box .h5 {
    font-size: 1.5rem;
}

/* --- Penyesuaian Responsif untuk Perangkat Seluler (Mobile-Friendly) --- */

@media (max-width: 767.98px) {
    /* Container Utama */
    .landing-wrapper.container-fluid.px-4.py-4 {
        padding: 1rem !important; /* Kurangi padding utama */
    }

    /* Tombol Kembali */
    .w-100-mobile {
        width: 100% !important;
    }
    
    /* Heading Section */
    .mobile-fs-large {
        font-size: 1.5rem !important; /* Perkecil ukuran judul */
    }

    /* List Item Content (Mengubah flex direction pada layar kecil) */
    .list-group-item.list-item-mobile {
        padding: 1rem !important;
    }

    /* Header Judul + Tanggal + Tombol */
    .list-group-item > .d-flex.align-items-center.justify-content-between {
        flex-direction: column;
        align-items: flex-start !important;
        width: 100%;
    }

    /* Bagian Tanggal dan Judul */
    .d-flex.align-items-start.align-items-md-center.w-100 {
        align-items: flex-start !important;
        margin-bottom: 0.75rem;
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
        font-size: 1rem !important;
    }
    .post-date-mobile {
        font-size: 0.75rem !important;
    }

    /* Tombol Aksi */
    .btn-action-mobile {
        width: 100%; /* Lebar penuh */
        margin-left: 0 !important;
        margin-top: 0.5rem;
        padding: 0.5rem;
        font-size: 0.85rem;
        order: 3; /* Pindahkan ke baris paling bawah */
    }

    /* Excerpt (Deskripsi Singkat) */
    .preview-mobile {
        padding-top: 0.75rem !important;
        margin-top: 0.75rem !important;
    }
    .post-excerpt-mobile {
        font-size: 0.8rem;
    }
}
</style>