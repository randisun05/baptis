<script setup>
    // Import components
    import Navbar from "../Components/Navbar.vue";
    import Sidebar from "../Components/Sidebar.vue";
</script>

<template>
    <div class="d-flex" style="min-height: 100vh; overflow-x: hidden; background-color: #f8f9fa;">
        
        <Sidebar />

        <div class="d-flex flex-column flex-grow-1" style="min-width: 0;">
            
            <Navbar />

            <main class="flex-grow-1">
                <slot />
            </main>

            <footer class="bg-white text-center py-3 border-top text-muted small mt-auto">
                &copy; 2025 Paroki Santa Melania - Sistem Admin
            </footer>
            
        </div>

    </div>
</template>

<style>
    /* Tidak perlu CSS tambahan yang rumit. 
       Sidebar.vue sudah mengatur lebarnya sendiri (280px).
       Bootstrap classes (d-flex, flex-grow-1) menangani sisanya.
    */
    body {
        background-color: #f8f9fa;
    }
</style>