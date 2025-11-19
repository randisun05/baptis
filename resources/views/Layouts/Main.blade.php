<!DOCTYPE html>
<html lang="en">
<head>
<!-- Required meta tags -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>Beranda - Aspro SDMA</title>
<link href="{{ asset('assets/images/logo.png') }}" rel="icon">
<link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet" />

</head>
<body>

@include('Layouts.Components.Header')
@include('Layouts.Components.Program')
@yield('content')

<script>

    //import Head from Inertia
    import {
        Head
    } from '@inertiajs/inertia-vue3';

    //import reactive
    import {
        reactive
    } from 'vue';

    //import inertia adapter
    import {
        Inertia
    } from '@inertiajs/inertia';

    export default {


        //register component
        components: {
            Head
        },

        //props
        props: {
            errors: Object,
            session: Object
        },


    }

</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="../../../assets/js/scripts.js"></script>
<script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>


</body>
</html>
