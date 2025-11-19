<template>
   <!-- Responsive navbar-->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container px-5">
                <a class="navbar-brand" href="#!">Start Bootstrap</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item"><a class="nav-link active" aria-current="page" href="#!">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="#!">About</a></li>
                        <li class="nav-item"><a class="nav-link" href="#!">Contact</a></li>
                        <li class="nav-item"><a class="nav-link" href="#!">Services</a></li>
                    </ul>
                </div>
            </div>
        </nav>

</template>

<script>
import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';
//import Link
import { Link,  } from '@inertiajs/inertia-vue3';



export default {
    //register component
    components: {
        Link,
    },

    data() {
        return {
            dropdowns: {
                home: false,
                profile: false,
                program: false,
                publikasi: false,
                keanggotaan: false,
                kontak: false,
            },
            dropdownItems: {
                profile: ["Tentang Aspro", "Ketua Umum", "Struktur Organisasi", "Visi Misi", "Sejarah Terbentuknya Aspro", "Peraturan Organisasi"],
                program: ["Pelatihan", "Sertifikasi", "Kegiatan Aspro"],
                publikasi: ["Pengumuman", "Artikel", "Berita", "Media"],
                keanggotaan: ["Login", "Registrasi"],
            },
            isScrolled: false, // New property to track scroll state
        };
    },
    methods: {
        toggleDropdown(dropdown) {
            this.dropdowns[dropdown] = !this.dropdowns[dropdown];
        },

    },
    mounted() {
        const handleScroll = () => {
            this.isScrolled = window.scrollY > 0;
        };
        window.addEventListener('scroll', handleScroll);
        onUnmounted(() => {
            window.removeEventListener('scroll', handleScroll);
        });
    },




}
</script>


<style>
/* CSS for red background */
/* CSS for red background */


/* CSS for fixed header */
.fixedmenu {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    z-index: 1000;
    transition: background-color 0.3s ease-in-out; /* Smooth transition for background color */
}



</style>
