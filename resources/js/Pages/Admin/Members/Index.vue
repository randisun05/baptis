<template>
    <Head>
        <title>Administrator | Data Peserta</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    </Head>

    <div class="container-fluid px-3 px-md-4 py-4">

        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">
            <div class="mb-3 mb-md-0">
                <h2 class="fs-3 fw-bold text-navy mb-0"> Data Peserta</h2>
                <p class="text-muted small mb-0">Kelola pendaftaran akun peserta.</p>
            </div>
            <div>
                <a v-if="$page.props.auth.user.role !== 'ketua_wakil_subseksi'" 
                   href="/admin/members/export" 
                   class="btn btn-success shadow-sm w-100 w-md-auto" 
                   target="_blank">
                    <i class="bi bi-file-earmark-spreadsheet-fill me-1"></i> Download Data Excel
                </a>
            </div>
        </div>

        <div v-if="$page.props.session?.success || $page.props.session?.error || $page.props.session?.status"
             class="alert alert-dismissible fade show shadow-sm border-0 mb-4"
             :class="{
                 'alert-success bg-success-subtle text-success-emphasis': $page.props.session?.success || $page.props.session?.status,
                 'alert-danger bg-danger-subtle text-danger-emphasis': $page.props.session?.error
             }" role="alert">
            <i class="bi me-2" :class="$page.props.session?.error ? 'bi-exclamation-triangle-fill' : 'bi-check-circle-fill'"></i>
            {{ $page.props.session?.success || $page.props.session?.error || $page.props.session?.status }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>

        <div class="row mb-4">
            <div class="col-12 col-md-6">
                <form @submit.prevent="handleSearch">
                    <div class="input-group shadow-sm rounded-pill overflow-hidden bg-white">
                        <input type="text" class="form-control border-0 bg-white" v-model="search"
                            placeholder="Cari peserta...">
                        <span class="input-group-text bg-white border-0">
                            <i class="bi bi-search text-muted"></i>
                        </span>
                    </div>
                </form>
            </div>
        </div>

        <div class="card shadow-sm border-0 rounded-4 overflow-hidden bg-transparent bg-md-white">
            
            <div class="card-body p-0 d-none d-md-block bg-white">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 table-custom">
                        <thead>
                            <tr>
                                <th class="px-4 py-3" style="width: 5%;">No</th>
                                <th class="px-4 py-3">Nama Peserta</th>
                                <th class="px-4 py-3" style="width: 15%;">Email</th>
                                <th class="px-4 py-3" style="width: 20%;">Kelompok</th>
                                <th class="px-4 py-3" style="width: 15%;">Status</th>
                                <th class="px-4 py-3 text-center" style="width: 15%;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(data, index) in datas.data" :key="data.id">
                                <td class="px-4 fw-bold text-secondary text-center">
                                    {{ (datas.current_page - 1) * datas.per_page + index + 1 }}
                                </td>
                                <td class="px-4 fw-bold text-navy">{{ data.name }}</td>
                                <td class="px-4">
                                    <div class="d-flex align-items-center text-muted">
                                        <i class="bi bi-envelope me-2 text-secondary"></i>
                                        <span class="text-truncate" style="max-width: 200px;" :title="data.email">{{ data.email }}</span>
                                    </div>
                                </td>
                                <td class="px-4">
                                    <span v-if="getGroupName(data.group)" :class="getGroupBadgeClass(data.group)">
                                        <i class="me-1" :class="getGroupIconClass(data.group)"></i> {{ getGroupName(data.group) }}
                                    </span>
                                    <span v-else class="text-muted small fst-italic">-</span>
                                </td>
                                <td class="px-4 text-center">
                                    <span :class="getStatusBadgeClass(data.status)">{{ formatStatus(data.status) }}</span>
                                </td>
                                <td class="px-4 text-center">
                                    <div class="btn-group" role="group">
                                        <Link :href="`/admin/members/${data.id}`" class="btn btn-sm btn-light text-info border hover-primary" title="Detail">
                                            <i class="bi bi-eye-fill"></i>
                                        </Link>
                                        <button v-if="$page.props.auth.user.role !== 'ketua_wakil_subseksi'" 
                                                @click.prevent="destroy(data.id)" 
                                                class="btn btn-sm btn-light text-danger border hover-danger ms-1" 
                                                title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="d-md-none">
                <div v-for="(data, index) in datas.data" :key="'mobile-' + data.id" class="card bg-white border-0 shadow-sm rounded-3 mb-3">
                    <div class="card-body p-3">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div>
                                <h6 class="fw-bold text-navy mb-1">{{ data.name }}</h6>
                                <div class="small text-muted">
                                    <i class="bi bi-envelope me-1"></i> {{ data.email }}
                                </div>
                            </div>
                            <span :class="getStatusBadgeClass(data.status)" class="badge-sm">
                                {{ formatStatus(data.status) }}
                            </span>
                        </div>

                        <hr class="my-2 border-light">

                        <div class="mb-3">
                            <span class="text-muted small d-block mb-1">Kelompok:</span>
                            <span v-if="getGroupName(data.group)" :class="getGroupBadgeClass(data.group)" class="w-100 d-block text-center py-2">
                                <i class="me-1" :class="getGroupIconClass(data.group)"></i> {{ getGroupName(data.group) }}
                            </span>
                            <span v-else class="text-muted small fst-italic">- Tidak ditentukan -</span>
                        </div>

                        <div class="d-flex gap-2">
                            <Link :href="`/admin/members/${data.id}`" class="btn btn-outline-primary btn-sm flex-fill">
                                <i class="bi bi-eye-fill me-1"></i> Detail
                            </Link>
                            <button v-if="$page.props.auth.user.role !== 'ketua_wakil_subseksi'" 
                                    @click.prevent="destroy(data.id)" 
                                    class="btn btn-outline-danger btn-sm flex-fill">
                                <i class="bi bi-trash me-1"></i> Hapus
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div v-if="!datas.data || datas.data.length === 0" class="card-body bg-white text-center py-5">
                <i class="bi bi-inbox display-4 mb-3 opacity-50"></i>
                <p class="mb-0">Data peserta tidak ditemukan.</p>
            </div>

            <div class="card-footer bg-white py-3 border-top border-light d-flex flex-column flex-md-row justify-content-between align-items-center">
                <div class="small text-muted mb-2 mb-md-0">
                    Data: {{ datas.from || 0 }} - {{ datas.to || 0 }} dari {{ datas.total }}
                </div>
                <div class="w-100 w-md-auto overflow-auto">
                    <Pagination :links="datas.links" align="end" />
                </div>
            </div>
        </div>
    </div>
</template>

<script>
// Bagian Script TIDAK PERLU DIUBAH (sama persis dengan sebelumnya)
import LayoutAdmin from '../../../Layouts/Admin.vue';
import Pagination from '../../../Components/Pagination.vue';
import { Head, Link } from '@inertiajs/inertia-vue3';
import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import Swal from 'sweetalert2';

export default {
    layout: LayoutAdmin,
    components: { Head, Link, Pagination },
    props: { errors: Object, datas: Object },
    setup(props) {
        const search = ref('' || (new URL(document.location)).searchParams.get('q'));
        const handleSearch = () => {
            Inertia.get('/admin/members', { q: search.value }, { preserveState: true, replace: true });
        }
        const destroy = (id) => {
            Swal.fire({
                title: 'Hapus Data?',
                text: "Anda yakin ingin menghapus data peserta ini secara permanen?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#003366',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    Inertia.delete(`/admin/members/${id}`, {
                        onSuccess: () => { Swal.fire({ title: 'Terhapus!', text: 'Data peserta berhasil dihapus.', icon: 'success', confirmButtonColor: '#003366' }); },
                        onError: (errors) => { Swal.fire('Gagal!', errors.message || 'Gagal menghapus data.', 'error'); }
                    });
                }
            });
        }
        const getGroupName = (groupValue) => {
             if (groupValue === true || groupValue === 'Katekumen' || groupValue === 1) return 'Katekumen';
             else if (groupValue === false || groupValue === 'Sakramen Baptis Bayi' || groupValue === 0) return 'Sakramen Baptis Bayi';
             return null;
        };
        const getGroupBadgeClass = (groupValue) => {
             if (groupValue === true || groupValue === 'Katekumen' || groupValue === 1) return 'badge bg-info-subtle text-info-emphasis border border-info-subtle fw-normal px-3 py-2';
             else if (groupValue === false || groupValue === 'Sakramen Baptis Bayi' || groupValue === 0) return 'badge bg-success-subtle text-success-emphasis border border-success-subtle fw-normal px-3 py-2';
             return 'badge bg-light text-muted border border-secondary-subtle fw-normal px-3 py-2';
        };
        const getGroupIconClass = (groupValue) => {
             if (groupValue === true || groupValue === 'Katekumen' || groupValue === 1) return 'fas fa-user-friends';
             else if (groupValue === false || groupValue === 'Sakramen Baptis Bayi' || groupValue === 0) return 'fas fa-baby';
             return '';
        };
        const getStatusBadgeClass = (status) => {
            switch (status) {
                case 'verified': case 'confirmed': return 'badge bg-success-subtle text-success-emphasis border border-success-subtle fw-normal px-3 py-2';
                case 'confirm': return 'badge bg-warning-subtle text-warning-emphasis border border-warning-subtle fw-normal px-3 py-2';
                case 'pending': return 'badge bg-secondary-subtle text-secondary-emphasis border border-secondary-subtle fw-normal px-3 py-2';
                default: return 'badge bg-light text-muted border border-secondary-subtle fw-normal px-3 py-2';
            }
        };
        const formatStatus = (status) => {
            switch (status) {
                case 'verified': case 'confirmed': return 'Terverifikasi';
                case 'confirm': return 'Menunggu Verifikasi';
                case 'pending': return 'Tertunda';
                default: return status;
            }
        };

        return { search, handleSearch, destroy, getStatusBadgeClass, formatStatus, getGroupName, getGroupBadgeClass, getGroupIconClass }
    }
}
</script>

<style scoped>
/* Menambahkan CSS untuk Mobile View agar background transparan di luar card */
@media (max-width: 767.98px) {
    .bg-md-white { background-color: transparent !important; box-shadow: none !important; }
    .badge-sm { font-size: 0.75rem; padding: 0.35em 0.65em; }
}
@media (min-width: 768px) {
    .bg-md-white { background-color: #fff !important; }
}

/* Style Lama tetap dipertahankan */
:root { --navy-primary: #003366; --navy-hover: #002244; }
.text-navy { color: #003366 !important; }
.btn-navy { background-color: #003366; color: white; border: none; padding: 0.5rem 1rem; border-radius: 6px; transition: all 0.2s ease; }
.btn-navy:hover { background-color: #002244; color: #ffffff; transform: translateY(-1px); box-shadow: 0 4px 6px rgba(0, 51, 102, 0.2); }
.table-custom thead { background-color: #003366; color: white; }
.table-custom thead th { background-color: #003366; color: white; font-weight: 500; border-bottom: none; letter-spacing: 0.5px; font-size: 0.9rem; }
.table-custom tbody tr { transition: background-color 0.2s; }
.hover-primary:hover { background-color: #e6f0ff; border-color: #b3d7ff; color: #0056b3 !important; }
.hover-danger:hover { background-color: #ffeef0; border-color: #ffccd3; color: #dc3545 !important; }
.text-info { color: #0dcaf0 !important; }
.card { border-radius: 12px; }
.bg-success-subtle { background-color: #d1e7dd; }
.text-success-emphasis { color: #0f5132; }
.bg-danger-subtle { background-color: #f8d7da; }
.text-danger-emphasis { color: #842029; }
.bg-warning-subtle { background-color: #fff3cd; }
.text-warning-emphasis { color: #664d03; }
.bg-secondary-subtle { background-color: #e2e3e5; }
.text-secondary-emphasis { color: #41464b; }
.bg-info-subtle { background-color: #cff4fc; }
.text-info-emphasis { color: #055160; }
.bg-primary-subtle { background-color: #cfe2ff; }
.text-primary-emphasis { color: #0a58ca; }
</style>