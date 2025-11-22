<template>
  <Head title="Data Peserta" />

  <div class="container-fluid px-4 py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
      <div>
        <h2 class="fs-3 fw-bold text-navy mb-0">Data Pendaftaran</h2>
        <p class="text-muted small mb-0">Kelola pendaftaran peserta baru.</p>
      </div>
      <Link href="/admin/registration/create" class="btn btn-navy shadow-sm">
        <i class="bi bi-person-plus-fill me-1"></i> Tambah Peserta
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
                 <th class="px-4 py-3" style="width: 20%;">Tahun/Nomor</th>
                <th class="px-4 py-3" style="width: 20%;">Nama Lengkap</th>
                <th class="px-4 py-3" style="width: 10%;">Jenis Kelamin</th>
                <th class="px-4 py-3" style="width: 15%;">Email</th>
                <th class="px-4 py-3" style="width: 10%;">No. Telepon</th>
                <th class="px-4 py-3" style="width: 15%;">Kelompok Katekese</th>
                <th class="px-4 py-3" style="width: 15%;">Terdaftar Pada</th>
                <th class="px-4 py-3 text-center" style="width: 10%;">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(register, index) in registers.data" :key="register.id">
                <td class="px-4 fw-bold text-secondary">
                    {{ (registers.current_page ? (registers.current_page - 1) * registers.per_page + index + 1 : index + 1) }}
                </td>
                 <td class="px-4">
                    <div class="fw-bold text-navy">{{ register.number }}</div>
                </td>
                <td class="px-4">
                    <div class="fw-bold text-navy">{{ register.name }}</div>
                </td>
                
                <td class="px-4">
                    <span v-if="register.gender === 'L' || register.gender === 'Laki-laki'" 
                          class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill px-3">
                        <i class="bi bi-gender-male me-1"></i> Pria
                    </span>
                    <span v-else-if="register.gender === 'P' || register.gender === 'Perempuan'" 
                          class="badge bg-danger-subtle text-danger border border-danger-subtle rounded-pill px-3">
                        <i class="bi bi-gender-female me-1"></i> Wanita
                    </span>
                    <span v-else class="text-muted small">
                        -
                    </span>
                </td>

                <td class="px-4">
                    <div class="d-flex align-items-center text-muted">
                        <i class="bi bi-envelope me-2 text-secondary"></i> 
                        <span class="text-truncate" style="max-width: 150px;" :title="register.email">{{ register.email }}</span>
                    </div>
                </td>

                <td class="px-4">
                    <div class="d-flex align-items-center text-muted">
                        <i class="bi bi-telephone me-2 text-secondary"></i> 
                        <span>{{ register.contact }}</span>
                    </div>
                </td>
                
                <td class="px-4">
                    <span v-if="register.kelompok" class="badge bg-light text-navy border border-secondary-subtle fw-normal px-3 py-2">
                        <i class="bi bi-people-fill me-1"></i> {{ register.kelompok }}
                    </span>
                    <span v-else class="text-muted small fst-italic">
                        - Tidak ditentukan -
                    </span>
                </td>

                <td class="px-4 text-muted small">
                    <i class="bi bi-calendar3 me-1"></i>
                    {{ new Date(register.created_at).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' }) }}
                </td>
                
                <td class="px-4 text-center">
                  <div class="btn-group" role="group">
                      <Link :href="`/admin/registration/${register.id}/edit`" class="btn btn-sm btn-light text-primary border hover-primary" title="Edit">
                        <i class="bi bi-pencil-square"></i>
                      </Link>
                      <button @click="destroy(register.id)" class="btn btn-sm btn-light text-danger border hover-danger ms-1" title="Hapus">
                        <i class="bi bi-trash"></i>
                      </button>
                  </div>
                </td>
              </tr>
              
              <tr v-if="registers.data.length === 0">
                <td colspan="8" class="text-center py-5">
                    <div class="d-flex flex-column align-items-center text-muted">
                        <i class="bi bi-inbox display-4 mb-3 opacity-50"></i>
                        <p class="mb-0">Belum ada data peserta.</p>
                    </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        
        <div class="px-4 py-3 border-top" v-if="registers.links">
            <Pagination :links="registers.links" align="end" />
        </div>
      </div>
      
      <div class="card-footer bg-white py-3 border-top border-light" v-if="registers.data.length > 0">
          <div class="small text-muted px-2">
             Menampilkan {{ registers.data.length }} data 
             <span v-if="registers.total">dari total {{ registers.total }}</span>
          </div>
      </div>
    </div>

  </div>
</template>

<script setup>
import { Head, Link } from '@inertiajs/inertia-vue3'
import { Inertia } from '@inertiajs/inertia'
import Pagination from '../../../Components/Pagination.vue';
// 1. Import SweetAlert2
import Swal from 'sweetalert2';

defineProps({
    registers: Object
})

// 2. Fungsi Destroy dengan SweetAlert
const destroy = (id) => {
    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: "Data peserta yang dihapus tidak dapat dikembalikan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',      // Merah untuk Hapus
        cancelButtonColor: '#003366',    // Navy Blue untuk Batal
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            Inertia.delete(`/admin/registration/${id}`, {
                onSuccess: () => {
                    Swal.fire({
                        title: 'Terhapus!',
                        text: 'Data peserta berhasil dihapus.',
                        icon: 'success',
                        confirmButtonColor: '#003366'
                    });
                }
            });
        }
    });
}
</script>

<script>
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
.bg-primary-subtle { background-color: #cfe2ff; }
.text-primary { color: #0a58ca !important; }
</style>