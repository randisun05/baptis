<template>
    <Head title="Manajemen Kegiatan" />

    <div class="container-fluid px-4 py-4">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fs-3 fw-bold text-navy mb-0">Manajemen Kegiatan</h2>
                <p class="text-muted small mb-0">Kelola dan atur jadwal kegiatan.</p>
            </div>
            <Link href="/admin/events/create" class="btn btn-navy shadow-sm">
                <i class="bi bi-calendar-plus-fill me-1"></i> Tambah Kegiatan
            </Link>
        </div>

        <div class="row mb-4 align-items-center">
            <div class="col-md-6 col-12 mb-2">
                <form @submit.prevent="handleSearch">
                    <div class="input-group shadow-sm rounded-pill overflow-hidden bg-white">
                        <input type="text" class="form-control border-0 bg-white" v-model="search"
                            placeholder="Cari nama kegiatan dan tekan Enter...">
                        <span class="input-group-text bg-white border-0">
                            <i class="bi bi-search text-muted"></i>
                        </span>
                    </div>
                </form>
            </div>
        </div>

        <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 table-custom">
                        <thead>
                            <tr>
                                <th class="px-4 py-3" style="width:5%">No.</th>
                                <th class="px-4 py-3" style="width:35%">Nama Kegiatan</th>
                                <th class="px-4 py-3" style="width:30%">Jadwal</th>
                                <th class="px-4 py-3" style="width:15%">Status</th>
                                <th class="px-4 py-3 text-center" style="width:15%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(event, index) in events.data" :key="event.id">
                                <td class="px-4 fw-bold text-secondary">
                                    {{ (events.current_page - 1) * events.per_page + index + 1 }}
                                </td>
                                <td class="px-4">
                                    <div class="fw-bold text-navy">{{ event.title }}</div>
                                </td>

                                <td class="px-4 small text-muted">
                                    <i class="bi bi-calendar-date me-1"></i>
                                    {{ formatTanggal(event.date) }} 
                                </td>
                                
                                <td class="px-4">
                                    <button @click="changeStatus(event.id, event.status)" 
                                        :class="getBadgeStatusClass(event.status)" 
                                        class="badge border-0 fw-normal px-3 py-2 cursor-pointer"
                                        :title="event.status === 'active' ? 'Klik untuk Menutup' : 'Klik untuk Mengaktifkan'">
                                        {{ formatStatus(event.status) }}
                                    </button>
                                </td>
                                
                                <td class="px-4 text-center">
                                    <div class="btn-group" role="group">
                                        <Link :href="`/admin/events/${event.id}`" class="btn btn-sm btn-light text-primary border hover-primary" title="Lihat Detail">
                                            <i class="bi bi-eye"></i>
                                        </Link>
                                        <Link :href="`/admin/events/${event.id}/edit`" class="btn btn-sm btn-light text-warning border hover-warning ms-1" title="Edit">
                                            <i class="bi bi-pencil-square"></i>
                                        </Link>
                                        <button @click="destroy(event.id)" class="btn btn-sm btn-light text-danger border hover-danger ms-1" title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr v-if="events.data.length === 0">
                                <td colspan="5" class="text-center py-5">
                                    <div class="d-flex flex-column align-items-center text-muted">
                                        <i class="bi bi-inbox display-4 mb-3 opacity-50"></i>
                                        <p class="mb-0">Data kegiatan belum tersedia.</p>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                <div class="px-4 py-3 border-top" v-if="events.links">
                    <Pagination :links="events.links" align="end" />
                </div>
            </div>

            <div class="card-footer bg-white py-3 border-top border-light" v-if="events.data.length > 0">
                <div class="small text-muted px-2">
                    Menampilkan {{ events.data.length }} data 
                    <span v-if="events.total">dari total {{ events.total }}</span>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import { Head, Link } from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia';
import Swal from 'sweetalert2';
import Pagination from '../../../Components/Pagination.vue'; 

const props = defineProps({
    events: Object,
});

const formatTanggal = (dateString) => {
    if (!dateString) return '-';
    const options = { day: 'numeric', month: 'long', year: 'numeric' };
    return new Intl.DateTimeFormat('id-ID', options).format(new Date(dateString));
};

const getBadgeStatusClass = (status) => {
    return status === 'active' 
        ? 'bg-success-subtle text-success-emphasis border border-success-subtle rounded-pill' 
        : 'bg-secondary-subtle text-secondary border border-secondary-subtle rounded-pill';
};

const formatStatus = (status) => {
    if (!status) return '';
    const formatted = status === 'closed' ? 'Ditutup' : 'Aktif'; // Tampilkan dalam bahasa Indonesia
    return formatted.charAt(0).toUpperCase() + formatted.slice(1);
};


const search = ref('' || (new URL(document.location)).searchParams.get('q'));
const handleSearch = () => {
    Inertia.get('/admin/events', { q: search.value }, { preserveState: true });
};

const destroy = (id) => {
    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: "Data kegiatan akan dihapus permanen!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33', 
        cancelButtonColor: '#003366', 
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            Inertia.delete(`/admin/events/${id}`, {
                onSuccess: () => Swal.fire({
                    title: 'Terhapus!',
                    text: 'Kegiatan berhasil dihapus.',
                    icon: 'success',
                    confirmButtonColor: '#003366'
                })
            });
        }
    });
};

const changeStatus = (id, currentStatus) => {
    let url = '';
    let action = '';
    let actionText = '';

    if (currentStatus === 'active') {
        url = `/admin/events/${id}/close`; 
        action = 'menutup';
        actionText = 'Ditutup';
    } else {
        url = `/admin/events/${id}/activate`; 
        action = 'mengaktifkan';
        actionText = 'Diaktifkan';
    }
    
    Swal.fire({
        title: `Konfirmasi ${action}`,
        text: `Anda yakin ingin ${action} kegiatan ini?`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#003366',
        cancelButtonColor: '#d33',
        confirmButtonText: `Ya, ${action}!`,
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            Inertia.post(url, {}, {
                preserveScroll: true,
                onSuccess: () => Swal.fire({
                    title: 'Berhasil',
                    text: `Status kegiatan berhasil ${actionText}.`,
                    icon: 'success',
                    confirmButtonColor: '#003366'
                })
            });
        }
    });
};
</script>

<script>
import LayoutAdmin from '../../../Layouts/Admin.vue';
export default { layout: LayoutAdmin }
</script>

<style scoped>
.cursor-pointer { cursor: pointer; } 
/* ... (Style lainnya) ... */
.text-navy { color: #003366; }
.text-warning { color: #ffc107 !important; }

.btn-navy {
    background-color: #003366;
    color: white;
    border: none;
    padding: 0.5rem 1rem;
    border-radius: 6px;
    transition: all 0.2s ease;
}

.btn-navy:hover {
    background-color: #002244;
    color: #ffffff;
    transform: translateY(-1px);
    box-shadow: 0 4px 6px rgba(0, 51, 102, 0.2);
}

.table-custom thead { background-color: #003366; color: white; }
.table-custom thead th { background-color: #003366; color: white; font-weight: 500; border-bottom: none; letter-spacing: 0.5px; font-size: 0.9rem; text-transform: uppercase; }

.hover-primary:hover { background-color: #e6f0ff; border-color: #b3d7ff; color: #0056b3 !important; }
.hover-warning:hover { 
    background-color: #fff8e1; 
    border-color: #ffecb3; 
    color: #e3a008 !important; 
}
.hover-danger:hover { 
    background-color: #ffeef0; 
    border-color: #ffccd3; 
    color: #dc3545 !important; 
}

.input-group.shadow-sm .form-control, 
.input-group.shadow-sm .input-group-text {
    border: none !important;
}

.bg-success-subtle { background-color: #d1e7dd !important; }
.text-success-emphasis { color: #0f5132 !important; }
.bg-secondary-subtle { background-color: #e2e3e5 !important; }
.text-secondary { color: #6c757d !important; }
.card { border-radius: 12px; }
</style>