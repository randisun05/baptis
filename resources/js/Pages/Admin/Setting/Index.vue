<template>
    <Head title="Administrator | Manajemen Pengguna" />

    <div class="container-fluid px-4 py-4">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fs-3 fw-bold text-navy mb-0">Data Pengguna</h2>
                <p class="text-muted small mb-0">Kelola akun pengguna.</p>
            </div>
            <Link href="/admin/setting/create" class="btn btn-navy shadow-sm">
                <i class="bi bi-person-plus-fill me-1"></i> Tambah Pengguna
            </Link>
        </div>
        
        <div class="row mb-4 align-items-center">
            <div class="col-md-6 col-12 mb-2">
                <form @submit.prevent="handleSearch">
                    <div class="input-group shadow-sm rounded-pill overflow-hidden bg-white">
                        <input type="text" class="form-control border-0 bg-white" v-model="search"
                            placeholder="Cari nama pengguna atau email dan tekan Enter...">
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
                                <th class="px-4 py-3" style="width:30%">Nama</th>
                                <th class="px-4 py-3" style="width:35%">Email</th>
                                <th class="px-4 py-3" style="width:15%">Role</th>
                                <th class="px-4 py-3 text-center" style="width:15%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(user, index) in users.data" :key="index">
                                <td class="px-4 fw-bold text-secondary">
                                    {{ (users.current_page - 1) * users.per_page + index + 1 }}
                                </td>
                                <td class="px-4 fw-bold text-navy">{{ user.name}}</td>
                                <td class="px-4 text-muted">{{ user.email }}</td>
                                <td class="px-4">
                                    <span class="badge" :class="getRoleBadgeClass(user.role)">
                                        {{ formatRole(user.role) }}
                                    </span>
                                </td>
                                <td class="px-4 text-center">
                                    <div class="btn-group" role="group">
                                        <Link :href="`/admin/setting/${user.id}/edit`" class="btn btn-sm btn-light text-warning border hover-warning" title="Edit">
                                            <i class="bi bi-pencil-square"></i> 
                                        </Link>
                                        <button @click="destroy(user.id)" class="btn btn-sm btn-light text-danger border hover-danger ms-1" title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr v-if="users.data.length === 0">
                                <td colspan="5" class="text-center py-5">
                                    <div class="d-flex flex-column align-items-center text-muted">
                                        <i class="bi bi-inbox display-4 mb-3 opacity-50"></i>
                                        <p class="mb-0">Data pengguna tidak ditemukan.</p>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="px-4 py-3 border-top" v-if="users.links">
                    <Pagination :links="users.links" align="end" />
                </div>
            </div>

            <div class="card-footer bg-white py-3 border-top border-light" v-if="users.data.length > 0">
                <div class="small text-muted px-2">
                    Menampilkan {{ users.data.length }} data 
                    <span v-if="users.total">dari total {{ users.total }}</span>
                </div>
            </div>
        </div>

    </div>
</template>

<script setup>
import { ref } from 'vue';
import { Head, Link } from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia';
import Pagination from '../../../Components/Pagination.vue';
import Swal from 'sweetalert2';

// Props yang diterima dari controller
const props = defineProps({
    users: Object, // Data pengguna yang dipaginasi
    errors: Object, // Error validation (jika diperlukan)
});

// Definisikan variabel pencarian dan isi dari URL jika ada
const search = ref('' || (new URL(document.location)).searchParams.get('q'));

// Method untuk pencarian
const handleSearch = () => {
    Inertia.get('/admin/setting', {
        q: search.value,
    }, {
        preserveState: true,
        replace: true
    });
};

// Fungsi helper untuk badge role
const getRoleBadgeClass = (role) => {
    switch (role) {
        case 'admin':
            return 'bg-primary-subtle text-primary border border-primary-subtle rounded-pill fw-normal px-3 py-2';
        case 'staff':
            return 'bg-info-subtle text-info border border-info-subtle rounded-pill fw-normal px-3 py-2';
        default:
            return 'bg-secondary-subtle text-secondary border border-secondary-subtle rounded-pill fw-normal px-3 py-2';
    }
};

// Fungsi helper untuk format role (huruf pertama kapital)
const formatRole = (role) => {
    if (!role) return '';
    return role.charAt(0).toUpperCase() + role.slice(1);
};


// define method destroy
const destroy = (id) => {
    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: "Anda tidak akan dapat mengembalikan data pengguna ini!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33', // Merah untuk Hapus
        cancelButtonColor: '#003366', // Navy Blue untuk Batal
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    })
    .then((result) => {
        if (result.isConfirmed) {
            Inertia.delete(`/admin/setting/${id}`, {
                onSuccess: () => {
                     Swal.fire({
                        title: 'Terhapus!',
                        text: 'Pengguna berhasil dihapus.',
                        icon: 'success',
                        confirmButtonColor: '#003366'
                    });
                }
            });
        }
    });
};

</script>

<script>
// Import layout di script biasa
import LayoutAdmin from '../../../Layouts/Admin.vue';
export default { layout: LayoutAdmin }
</script>

<style scoped>
/* --- Theme Variables --- */
:root {
    --navy-primary: #003366;
    --navy-hover: #002244;
}

.text-navy { color: #003366; }
.text-warning { color: #ffc107 !important; }

/* --- Button Styles --- */
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

/* --- Table Styles --- */
.table-custom thead { background-color: #003366; color: white; }
.table-custom thead th { background-color: #003366; color: white; font-weight: 500; border-bottom: none; letter-spacing: 0.5px; font-size: 0.9rem; text-transform: uppercase; }
.table-custom tbody tr { transition: background-color 0.2s; }

/* Efek hover pada tombol aksi */
.hover-warning:hover { 
    background-color: #fff8e1; 
    border-color: #ffecb3; 
    color: #e3a008 !important; /* Warna kuning yang lebih gelap */
}
.hover-danger:hover { 
    background-color: #ffeef0; 
    border-color: #ffccd3; 
    color: #dc3545 !important; 
}

/* Customizing input group look */
.input-group.shadow-sm .form-control, 
.input-group.shadow-sm .input-group-text {
    border: none !important;
}

/* --- Card & Utils --- */
.card { border-radius: 12px; }
.bg-primary-subtle { background-color: #cfe2ff !important; }
.text-primary { color: #0a58ca !important; }
.bg-info-subtle { background-color: #cff4fc !important; }
.text-info { color: #0d6efd !important; } /* Menggunakan primary blue sebagai ganti karena info-text default terlalu terang */
.bg-secondary-subtle { background-color: #e2e3e5 !important; }
.text-secondary { color: #6c757d !important; }
</style>