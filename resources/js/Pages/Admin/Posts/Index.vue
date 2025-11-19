<template>
  <Head title="Data Posts" />

  <div class="container-fluid px-4 py-4">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
      <div>
        <h2 class="fs-3 fw-bold text-navy mb-0">Daftar Postingan</h2>
        <p class="text-muted small mb-0">Kelola artikel dan berita paroki.</p>
      </div>
      <Link href="/admin/posts/create" class="btn btn-navy shadow-sm">
        <i class="bi bi-plus-lg me-1"></i> Tambah Post Baru
      </Link>
    </div>

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
                <th class="px-4 py-3" style="width: 25%;">Judul Kegiatan</th>
                <th class="px-4 py-3">Deskripsi Singkat</th>
                <th class="px-4 py-3 text-center" style="width: 15%;">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(post, index) in posts.data" :key="post.id">
                <td class="px-4 fw-bold text-secondary">{{ index + 1 }}</td>
                
                <td class="px-4 text-center">
                    <div v-if="post.image">
                        <img :src="`/storage/${post.image}`" alt="Thumbnail" class="img-thumbnail rounded shadow-sm" style="width: 80px; height: 50px; object-fit: cover;">
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
                  <div class="btn-group" role="group">
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
                <td colspan="5" class="text-center py-5">
                    <div class="d-flex flex-column align-items-center text-muted">
                        <i class="bi bi-inbox display-4 mb-3 opacity-50"></i>
                        <p class="mb-0">Belum ada data postingan.</p>
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
// Import SweetAlert2
import Swal from 'sweetalert2';

// Menerima props dari Controller
defineProps({
  posts: Object,
})

// Fungsi Hapus dengan SweetAlert
const destroy = (id) => {
    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: "Data yang dihapus tidak dapat dikembalikan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',      // Merah untuk hapus
        cancelButtonColor: '#003366',    // Navy Blue untuk batal (sesuai tema)
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            // Jika user klik "Ya", jalankan delete inertia
            Inertia.delete(`/admin/posts/${id}`, {
                onSuccess: () => {
                    // Opsional: Tampilkan notifikasi sukses kedua dari SweetAlert
                    Swal.fire(
                        'Terhapus!',
                        'Data berhasil dihapus.',
                        'success'
                    )
                }
            });
        }
    })
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
</style>