<script setup>
    // Import Navbar dari path yang Anda tentukan
    import Navbar from "../Components/User/Navbar.vue";
    
    // Import komponen SidebarUser yang sudah kita buat
    // Catatan: Asumsikan SidebarUser berada di path yang sama dengan Navbar atau disesuaikan
    import SidebarUser from "../Components/User/Sidebar.vue"; 
</script>

<template>
    <div class="d-flex" style="min-height: 100vh; overflow-x: hidden; background-color: #f8f9fa;">

        <SidebarUser />

        <div class="d-flex flex-column flex-grow-1" style="min-width: 0;">

            <Navbar />

            <main class="flex-grow-1 p-3">
                <slot />
            </main>

            <footer class="bg-white text-center py-3 border-top text-muted small mt-auto">
                &copy; 2025 Paroki Santa Melania
            </footer>

        </div>

    </div>
</template>

<style>
    /* Styling Dasar, memastikan latar belakang halaman konsisten */
    body {
        background-color: #f8f9fa;
        margin: 0; /* Pastikan margin body 0 agar sidebar menempel di tepi */
    }
</style>