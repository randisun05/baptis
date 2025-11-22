<template>
    <nav class="navbar navbar-expand-lg fixed-top" :class="{ 'scrolled': isScrolled }">
        <div class="container">
        <a href="/" class="navbar-brand d-flex align-items-center">
        <i class="fas fa-church me-2 fa-lg text-warning"></i>
         <div class="d-flex flex-column lh-sm">
        <span class="fw-bold text-white">Paroki Santa Melania</span>
        <span class="fs-7 text-white-50" style="font-size: 0.75rem;">Sistem Informasi Katekumen dan Baptis Bayi</span>
                    </div>
    </a>
            
            <div class="d-flex gap-2">
                <!-- Asumsi Link dan route/path-nya valid -->
                <Link href="/user/login" class="btn btn-outline-light btn-sm px-4">Masuk</Link>
            </div>
        </div>
    </nav>
</template>

<script setup>
import { Link } from '@inertiajs/inertia-vue3';
import { ref, onMounted, onUnmounted } from 'vue';

// Logika untuk Navbar berubah warna saat discroll
const isScrolled = ref(false);

const handleScroll = () => {
    // 50px adalah batas scroll sebelum navbar berubah warna
    isScrolled.value = window.scrollY > 50;
};

onMounted(() => {
    window.addEventListener('scroll', handleScroll);
});

onUnmounted(() => {
    window.removeEventListener('scroll', handleScroll);
});
</script>

<style scoped>
/* --- Custom Colors & Variables (Diperlukan di sini untuk styling navbar) --- */
:root {
    --navy-primary: #003366;
    --orange-accent: #ff9900;
}
.text-warning { color: #ff9900 !important; }
/* --- Navbar Styles (Penting untuk diletakkan di sini) --- */
.navbar {
    transition: all 0.3s ease-in-out;
    padding: 1rem 0;
    background: transparent; /* Transparan di awal */
}
.navbar.scrolled {
    background: var(--navy-primary); /* Navy saat discroll */
    padding: 0.5rem 0;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}
/* Memindahkan style yang relevan ke komponen ini */
.btn-outline-light:hover {
    background-color: white;
    color: var(--navy-primary);
}
</style>