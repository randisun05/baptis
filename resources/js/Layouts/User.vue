<script setup>
    // Import komponen yang diperlukan
    import Navbar from "../Components/User/Navbar.vue";
    import SidebarUser from "../Components/User/Sidebar.vue"; 
</script>

<template>
    <div class="d-flex" style="min-height: 100vh; overflow-x: hidden; background-color: #f8f9fa;">

        <SidebarUser />

        <div class="d-flex flex-column flex-grow-1" style="min-width: 0;">

            <Navbar v-if="showNavbar" /> 

            <main class="flex-grow-1 p-3">
                <slot />
            </main>

           <footer class="bg-dark text-white py-5">
            <div class="container">
                <div class="row g-4">
                    <div class="col-lg-6">
                        <h5 class="fw-bold text-warning mb-3">Paroki Santa Melania</h5>
                        <p class="small opacity-75">
                            Jl. Melania No.1-3, Cihaur Geulis, Kec. Cibeunying Kaler, Kota Bandung, Jawa Barat 40122<br>
                            Telp: (022) 20463790<br>
                            Email: sekretariat@stmelania.org<br>
                            <a href="https://wa.me/6281321272634" target="_blank" class="text-white opacity-75 text-decoration-none">
                                <i class="fab fa-whatsapp me-1"></i> WhatsApp: +62 813-2127-2634
                            </a>
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
                    © 2025 Paroki Santa Melania - Sistem Informasi Katekumen & Baptis Bayi.
                </div>
            </div>
        </footer>
            </div>

    </div>
</template>

<script>
// Kunci Perubahan: Definisikan prop showNavbar di Layout agar dapat diterima dari Page (Dashboard.vue)
export default {
    props: {
        showNavbar: {
            type: Boolean,
            default: true // Default true agar tidak tersembunyi di halaman lain
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
/* Garis horizontal penghubung step */
.process-line {
    position: absolute;
    top: 25px; 
    left: 15%;
    right: 15%;
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
</style>