<template>
    <Head title="Data Events" />

    <div class="container-fluid px-4 py-4">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fs-3 fw-bold text-dark mb-0">Manajemen Kegiatan</h2>
            <Link href="/admin/events/create" class="btn btn-primary border-0 shadow">
                <i class="fa fa-plus-circle me-2"></i> Tambah Kegiatan
            </Link>
            
        </div>


        <div class="row mb-4">
            <div class="col-md-6">
                <form @submit.prevent="handleSearch">
                    <div class="input-group">
                        <input type="text" class="form-control border-0 shadow-sm" v-model="search" placeholder="Cari nama kegiatan...">
                        <button class="input-group-text border-0 shadow-sm bg-white">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card border-0 shadow">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-centered table-nowrap mb-0 rounded">
                        <thead class="thead-dark table-light">
                            <tr>
                                <th class="border-0 rounded-start" style="width:5%">No.</th>
                                <th class="border-0">Nama Kegiatan</th>
                                <th class="border-0">Jadwal (Mulai - Selesai)</th>
                                <th class="border-0">Status</th>
                                <th class="border-0 rounded-end text-center" style="width:15%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(event, index) in events.data" :key="event.id">
                                <td class="fw-bold text-center">{{ ++index + (events.current_page - 1) * events.per_page }}</td>
                                <td>
                                    <div class="fw-bold">{{ event.title }}</div>
                                </td>

                                <td>
                                    <div>{{ event.date }}</div>
                                    <div class="small text-muted">s/d {{ event.enddate }}</div>
                                </td>
                                <td>
                                    <button v-if="event.status === 'active'" @click="changeStatus(event.id)" class="badge bg-success border-0">Active</button>
                                    <button v-else @click="changeStatus(event.id)" class="badge bg-secondary border-0">Closed</button>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <Link :href="`/admin/events/${event.id}`" class="btn btn-sm btn-success text-white" title="Show">
                                            <i class="fa fa-eye"></i>
                                        </Link>
                                        <Link :href="`/admin/events/${event.id}/edit`" class="btn btn-sm btn-warning text-white" title="Edit">
                                            <i class="fa fa-pencil"></i>
                                        </Link>
                                        <button @click="destroy(event.id)" class="btn btn-sm btn-danger" title="Hapus">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr v-if="events.data.length === 0">
                                <td colspan="7" class="text-center py-4 text-muted">Data kegiatan belum tersedia.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <Pagination :links="events.links" align="end" class="mt-3" />
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import { Head, Link } from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia';
import Swal from 'sweetalert2';
import Pagination from '../../../Components/Pagination.vue'; // Sesuaikan path

// Props dari controller
const props = defineProps({
    events: Object,
});

// Search Logic
const search = ref('' || (new URL(document.location)).searchParams.get('q'));
const handleSearch = () => {
    Inertia.get('/admin/events', { q: search.value }, { preserveState: true });
};

// Delete Logic
const destroy = (id) => {
    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: "Data kegiatan akan dihapus permanen!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            Inertia.delete(`/admin/events/${id}`);
        }
    });
};

// Change Status Logic
const changeStatus = (id) => {
    Inertia.post(`/admin/events/${id}/change-status`, {}, {
        preserveScroll: true,
        onSuccess: () => Swal.fire('Berhasil', 'Status kegiatan diperbarui', 'success')
    });
};
</script>

<script>
import LayoutAdmin from '../../../Layouts/Admin.vue';
export default { layout: LayoutAdmin }
</script>
