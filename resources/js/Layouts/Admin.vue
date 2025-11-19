<template>
<div class="wrapper">



      <div class="d-flex" id="wrapper">

        <Sidebar />
        <div id="page-content-wrapper" class="w-100 bg-light">
        <Navbar />
        <slot />


        </div>
    </div>


</div>


</template>

<script>
    //import navbar
    import Navbar from "../Components/Navbar.vue";

    // //import sidebar
    import Sidebar from '../Components/Sidebar.vue';

    export default {

        //register components
        components: {
            Navbar,
            Sidebar
        },
    }

</script>

<style>
        /* ... Paste CSS Anda yang sangat panjang di sini ... */
        /* Untuk mempermudah, kode ini mengasumsikan CSS Bootstrap 5 sudah dimuat */

        /* Sedikit style tambahan agar sidebar full height */
        body {
            min-height: 100vh;
            overflow-x: hidden;
        }
        #wrapper {
            min-height: 100vh;
        }
        #sidebar-wrapper {
            min-width: 250px;
            max-width: 250px;
            min-height: 100vh;
        }
    </style>
