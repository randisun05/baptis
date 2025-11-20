<template>

    <Head>
        <title>Detail Event - Administrator</title>
    </Head>

    <div class="container-fluid px-4 py-4">
        <div class="row justify-content-center">
            <div class="col-md-12">

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="fs-3 fw-bold mb-0 text-dark">Detail Event</h2>
                    <Link href="/admin/events" class="btn btn-outline-secondary border-0 shadow-sm">
                        <i class="fa fa-arrow-left me-1"></i> Kembali
                    </Link>
                </div>

                <div class="card border-0 shadow mb-4">
                    <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                        <h4 class="fw-bold text-primary">{{ event.title }}</h4>
                    </div>
                    <div class="card-body p-4">
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-borderless table-sm">
                                    <tbody>
                                        <tr>
                                            <td class="fw-bold text-muted" style="width: 150px;">Tanggal Mulai</td>
                                            <td>: {{ event.date }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold text-muted">Selesai/Tutup</td>
                                            <td>: {{ event.enddate }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold text-muted">Tempat</td>
                                            <td>: {{ event.place }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-borderless table-sm">
                                    <tbody>
                                        <tr>
                                            <td class="fw-bold text-muted" style="width: 150px;">Kapasitas</td>
                                            <td>: <span class="badge bg-info">{{ event.participant }} Peserta</span></td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold text-muted">Link External</td>
                                            <td>:
                                                <a v-if="event.link" :href="event.link" target="_blank" class="text-decoration-none">
                                                    {{ event.link }} <i class="fa fa-external-link-alt small"></i>
                                                </a>
                                                <span v-else class="text-muted">-</span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="mt-3">
                            <h5 class="fw-bold mb-3">Deskripsi Kegiatan</h5>
                            <div class="p-3 bg-light rounded border" style="min-height: 100px;">
                                <div v-html="event.body" class="text-break detail-content"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow">
                    <div class="card-body p-4">
                        <h4 class="fw-bold mb-4">Data Peserta</h4>

                        <div class="row mb-3 align-items-end">
                            <div class="col-md-6 mb-2">
                                <form @submit.prevent="handleSearch">
                                    <div class="input-group">
                                        <input type="text" class="form-control border-0 shadow-sm" v-model="search" placeholder="Cari nama peserta...">
                                        <button class="input-group-text border-0 shadow-sm bg-white">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </div>
                                </form>
                            </div>
                           <div class="col-md-6 mb-2 text-md-end">
                            <Link :href="`/admin/events/${event.id}/enroll`" class="btn btn-success shadow-sm">
                                <i class="fa fa-check-circle me-1"></i> Enroll Peserta
                            </Link>
                        </div>
                        </div>

                        <ul class="nav nav-tabs mb-3">
                            <li class="nav-item">
                                <a class="nav-link active fw-bold" href="#">List Peserta</a>
                            </li>
                        </ul>

                        <div class="table-responsive">
                            <table class="table table-hover table-centered table-nowrap mb-0 rounded">
                                <thead class="thead-dark table-light">
                                    <tr>
                                        <th class="border-0 rounded-start text-center" style="width:5%">No.</th>
                                        <th class="border-0">Nama</th>
                                        <th class="border-0 rounded-end text-center">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(detail, index) in details.data" :key="index">
                                        <td class="fw-bold text-center">
                                            {{ ++index + (details.current_page - 1) * details.per_page }}
                                        </td>
                                        <td>{{ detail.member.name }}</td>
                                        <td class="text-center">
                                            <span class="badge bg-secondary">{{ detail.status }}</span>
                                        </td>
                                    </tr>
                                    <tr v-if="details.data.length === 0">
                                        <td colspan="5" class="text-center py-4 text-muted">Belum ada peserta yang terdaftar.</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <Pagination :links="details.links" align="end" class="mt-3" />

                    </div>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
//import layout
import LayoutAdmin from '../../../Layouts/Admin.vue';

//import component pagination
import Pagination from '../../../Components/Pagination.vue';

//import Heade and Link from Inertia
import { Head, Link } from '@inertiajs/inertia-vue3';

//import inertia adapter
import { Inertia } from '@inertiajs/inertia';

//import ref from vue
import { ref } from 'vue';

//import sweet alert2
import Swal from 'sweetalert2';

export default {
    layout: LayoutAdmin,

    components: {
        Head,
        Link,
        Pagination
    },

    props: {
        errors: Object,
        event: Object,
        details: Object
    },

    setup(props) {
        //define state search
        const search = ref('' || (new URL(document.location)).searchParams.get('q'));

        //define method search
        const handleSearch = () => {
            Inertia.get(`/admin/events/${props.event.id}`, {
                //send params "q" with value from state "search"
                q: search.value,
            }, {
                preserveState: true, // Supaya tidak refresh full page
                preserveScroll: true
            });
        }

        return {
            search,
            handleSearch
        }
    }
}
</script>

<style scoped>
/* Styling untuk Modal Custom */
.modal-backdrop-custom {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 1050;
    animation: fadeIn 0.2s;
}

.modal-content-custom {
    background: #fff;
    padding: 25px;
    border-radius: 8px;
    width: 90%;
    max-width: 450px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    animation: slideIn 0.3s;
}

/* Utility render HTML agar gambar tidak overflow */
.detail-content :deep(img) {
    max-width: 100%;
    height: auto;
    border-radius: 5px;
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

@keyframes slideIn {
    from { transform: translateY(-20px); opacity: 0; }
    to { transform: translateY(0); opacity: 1; }
}
</style>
