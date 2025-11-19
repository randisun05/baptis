<template>
 <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom shadow-sm px-4 py-3">
                <div class="container-fluid p-0">
                    <button class="btn btn-outline-secondary d-lg-none" id="sidebarToggle">Menu</button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ms-auto mt-2 mt-lg-0">
                            <li class="nav-item active"><a class="nav-link" href="#">Home</a></li>
                            <li class="nav-item"><a class="nav-link" href="#">Notification <span class="badge bg-danger">4</span></a></li>
                        </ul>
                    </div>
                </div>
            </nav>


</template>

<script>

    //import Link
    import { Link } from '@inertiajs/inertia-vue3';

    export default {

        //register component
        components: {
            Link,
        }
    }

</script>

<style>

/* CSS for fixed header */
.fixedmenu {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    z-index: 1000;
    transition: background-color 0.3s ease-in-out; /* Smooth transition for background color */
}

.userbg {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    z-index: 1000;
    background: -webkit-linear-gradient(90deg, #423f9c, #862359);
    background: -webkit-gradient(linear, left top, right top, color-stop(#423f9c), color-stop(#862359));
    background: -webkit-linear-gradient(left, #423f9c, #862359);
    background: -o-linear-gradient(left, #423f9c, #862359);
    background: -webkit-gradient(linear, left top, right top, from(#423f9c), to(#862359));
    background: linear-gradient(90deg, #423f9c, #862359);
    z-index: 100000;
}

</style>
