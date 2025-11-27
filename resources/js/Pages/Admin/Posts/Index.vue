<template>
    <Head title="Data Posts" />

    <div class="container-fluid px-4 py-4">
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fs-3 fw-bold text-navy mb-0">Data Warta</h2>
                <p class="text-muted small mb-0">Kelola warta paroki.</p>
            </div>
            <Link href="/admin/posts/create" class="btn btn-navy shadow-sm">
                <i class="bi bi-plus-lg me-1"></i> Tambah Warta Baru
            </Link>
        </div>

        <!-- SEARCH INPUT BLOCK (Ditambahkan) -->
        <div class="row mb-4 align-items-center">
            <div class="col-md-6 col-12 mb-2">
                <form @submit.prevent="handleSearch">
                    <div class="input-group shadow-sm rounded-pill overflow-hidden bg-white">
                        <input type="text" class="form-control border-0 bg-white" v-model="search"
                            placeholder="Cari judul warta dan tekan Enter...">
                        <span class="input-group-text bg-white border-0">
                            <i class="bi bi-search text-muted"></i>
                        </span>
                    </div>
                </form>
            </div>
        </div>
        <!-- END SEARCH INPUT BLOCK -->


        <div v-if="$page.props.session?.success || $page.props.session?.error || $page.props.session?.status"
            class="alert alert-dismissible fade show shadow-sm border-0 mb-4"
            :class="{
                'alert-success bg-success-subtle text-success-emphasis': $page.props.session?.success || $page.props.session?.status,
                'alert-danger bg-danger-subtle text-danger-emphasis': $page.props.session?.error
            }"
            role="alert">
            
            <i class="bi me-2" :class="$page.props.session?.error ? 'bi-exclamation-triangle-fill' : 'bi-check-circle-fill'"></i>
            {{ $page.props.session?.success || $page.props.session?.error || $page.props.session?.status }}
            
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>

        <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 table-custom">
                        <thead>
                            <tr>
                                <th class="px-4 py-3" style="width: 5%;">No</th>
                                <th class="px-4 py-3 text-center" style="width: 15%;">Gambar</th> 
                                <th class="px-4 py-3" style="width: 20%;">Judul Warta</th> <!-- Disesuaikan -->
                                <th class="px-4 py-3">Deskripsi Singkat</th>
                                <th class="px-4 py-3 text-center" style="width: 10%;">Status</th> 
                                <th class="px-4 py-3 text-center" style="width: 15%;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(post, index) in posts.data" :key="post.id">
                                <td class="px-4 fw-bold text-secondary">{{ posts.from + index }}</td>
                                
                                <td class="px-4 text-center">
                                    <div v-if="post.image">
                                        <img :src="post.image.startsWith('http') ? post.image : `/storage/${post.image}`" 
                                            alt="Thumbnail" class="img-thumbnail rounded shadow-sm" 
                                            style="width: 80px; height: 50px; object-fit: cover;">
                                    </div>
                                    <div v-else>
                                        <span class="badge bg-light text-secondary border">No Image</span>
                                    </div>
                                </td>

                                <td class="px-4">
                                    <span class="fw-semibold text-navy d-block">{{ post.title }}</span>
                                </td>
                                <td class="px-4 text-muted small">
                                    {{ post.body.length > 60 ? post.body.substring(0, 60) + '...' : post.body }}
                                </td>

                                <td class="px-4 text-center">
                                    <span class="badge" :class="{
                                        'bg-success': post.status === 'active' || post.status === 'approved',
                                        'bg-danger': post.status === 'deactive' || post.status === 'rejected',
                                        'bg-warning text-dark': post.status === 'pending'
                                    }">
                                        {{ post.status.charAt(0).toUpperCase() + post.status.slice(1) }}
                                    </span>
                                </td>
                                
                                <td class="px-4 text-center">
                                    <div class="btn-group" role="group">
                                        
                                        <button v-if="post.status !== 'active'" @click="activate(post.id)" 
                                                class="btn btn-sm btn-light text-success border hover-primary me-1" title="Aktifkan">
                                            <i class="bi bi-check-circle"></i>
                                        </button>
                                        <button v-else @click="deactivate(post.id)" 
                                                class="btn btn-sm btn-light text-warning border hover-danger me-1" title="Nonaktifkan">
                                            <i class="bi bi-x-circle"></i>
                                        </button>

                                        <Link :href="`/admin/posts/${post.id}/edit`" class="btn btn-sm btn-light text-primary border hover-primary" title="Edit">
                                            <i class="bi bi-pencil-square"></i>
                                        </Link>
                                        <button @click="destroy(post.id)" class="btn btn-sm btn-light text-danger border hover-danger ms-1" title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            
                            <tr v-if="posts.data.length === 0">
                                <td colspan="6" class="text-center py-5">
                                    <div class="d-flex flex-column align-items-center text-muted">
                                        <i class="bi bi-inbox display-4 mb-3 opacity-50"></i>
                                        <p class="mb-0">Belum ada data warta.</p>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                <div class="px-4 py-3 border-top" v-if="posts.data.length > 0">
                    <Pagination :links="posts.links" align="end" />
                </div>
            </div>
            
            <div class="card-footer bg-white py-3 border-top border-light" v-if="posts.data.length > 0">
                <div class="small text-muted px-2">
                    Menampilkan {{ posts.data.length }} data dari total {{ posts.total }}
                </div>
            </div>
        </div>

    </div>
</template>

<script setup>
import { Head, Link } from '@inertiajs/inertia-vue3'
import { Inertia } from '@inertiajs/inertia'
import Pagination from '../../../Components/Pagination.vue';
import Swal from 'sweetalert2';
import { ref } from 'vue'; // Mengimpor ref

// Menerima props dari Controller
const props = defineProps({
    posts: Object,
})

// Logic Pencarian
const search = ref('' || (new URL(document.location)).searchParams.get('q'));
const handleSearch = () => {
    Inertia.get('/admin/posts', { 
        q: search.value 
    }, { 
        preserveState: true,
        replace: true
    });
};
// End Logic Pencarian


// Fungsi Hapus dengan SweetAlert
const destroy = (id) => {
    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: "Data yang dihapus tidak dapat dikembalikan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33', 
        cancelButtonColor: '#003366', 
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            // Jika user klik "Ya", jalankan delete inertia
            Inertia.delete(`/admin/posts/${id}`, {
                onSuccess: () => {
                    Swal.fire(
                        'Terhapus!',
                        'Data berhasil dihapus.',
                        'success'
                    )
                },
                onError: () => {
                    Swal.fire(
                        'Gagal!',
                        'Terjadi kesalahan saat menghapus data.',
                        'error'
                    )
                }
            });
        }
    })
}

// Fungsi Aktivasi Postingan
const activate = (id) => {
    Inertia.put(`/admin/posts/${id}/activate`, {}, {
        preserveScroll: true,
        onSuccess: () => {
             // Opsional: notifikasi sukses bisa ditangani via flash message dari controller
        }
    });
}

// Fungsi Deaktivasi Postingan
const deactivate = (id) => {
    Inertia.put(`/admin/posts/${id}/deactivate`, {}, {
        preserveScroll: true,
        onSuccess: () => {
            // Opsional
        }
    });
}
</script>

<script>
import LayoutAdmin from '../../../Layouts/Admin.vue';
export default { layout: LayoutAdmin };
</script>

<style scoped>
/* --- Theme Variables --- */
:root {
    --navy-primary: #003366;
    --navy-hover: #002244;
}

.text-navy { color: #003366; }

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
.hover-primary:hover { background-color: #e6f0ff; border-color: #b3d7ff; color: #0056b3 !important; }
.hover-danger:hover { background-color: #ffeef0; border-color: #ffccd3; color: #dc3545 !important; }

/* --- Card & Utils --- */
.card { border-radius: 12px; }
.bg-success-subtle { background-color: #d1e7dd; }
.text-success-emphasis { color: #0f5132; }
.bg-danger-subtle { background-color: #f8d7da; }
.text-danger-emphasis { color: #842029; }

/* Menyesuaikan penomoran paginasi di tabel */
.table-custom tbody tr td:first-child { 
    font-size: 0.85rem; 
}

/* Input group styling from event index for consistency */
.input-group.shadow-sm .form-control, 
.input-group.shadow-sm .input-group-text {
    border: none !important;
}
</style>