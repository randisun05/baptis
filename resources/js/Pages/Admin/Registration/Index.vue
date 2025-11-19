<template>
  <Head title="Data Peserta" />

  <div class="container-fluid px-4 py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
      <div>
        <h2 class="fs-3 fw-bold text-dark mb-0">Data Peserta</h2>
        <p class="text-muted mb-0">Kelola pendaftaran peserta baru.</p>
      </div>
      <Link href="/admin/registration/create" class="btn btn-primary">
        <i class="bi bi-person-plus-fill me-1"></i> Tambah Peserta
      </Link>
    </div>


    <div v-if="$page.props.session?.success || $page.props.session?.error || $page.props.session?.status"
     class="alert alert-dismissible fade show"
     :class="{
        'alert-success': $page.props.session?.success || $page.props.session?.status,
        'alert-danger': $page.props.session?.error
     }"
     role="alert">

     {{ $page.props.session?.success || $page.props.session?.error || $page.props.session?.status }}

        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>

    <div class="card shadow-sm border-0">
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-hover align-middle">
            <thead class="table-light">
              <tr>
                <th>No</th>
                <th>Nama Lengkap</th>
                <th>Kontak</th>
                <th>Terdaftar Pada</th>
                <th class="text-center">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(register, index) in registers.data" :key="register.id">
                <td>{{ index + 1 }}</td>
                <td>
                    <div class="fw-bold">{{ register.name }}</div>
                    <div class="small text-muted">ID: {{ register.id }}</div>
                </td>
                <td>
                    <div><i class="bi bi-envelope me-1 text-muted"></i> {{ register.email }}</div>
                    <div class="small text-muted"><i class="bi bi-telephone me-1"></i> {{ register.contact }}</div>
                </td>
                <td>{{ new Date(register.created_at).toLocaleDateString('id-ID') }}</td>
                <td class="text-center">
                  <Link :href="`/admin/registration/${register.id}/edit`" class="btn btn-sm btn-outline-warning me-2" title="Edit">
                    <i class="bi bi-pencil-square"></i>
                  </Link>
                  <button @click="destroy(register.id)" class="btn btn-sm btn-outline-danger" title="Hapus">
                    <i class="bi bi-trash"></i>
                  </button>
                </td>
              </tr>
              <tr v-if="registers.data.length === 0">
                <td colspan="6" class="text-center py-5 text-muted">
                    <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                    Belum ada data peserta.
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        </div>
    </div>
  </div>
</template>

<script setup>
import { Head, Link } from '@inertiajs/inertia-vue3'
import { Inertia } from '@inertiajs/inertia'
defineProps({
    registers: Object
})

const destroy = (id) => {
    if (confirm('Yakin ingin menghapus data peserta ini?')) {
        Inertia.delete(`/admin/registration/${id}`)
    }
}
</script>

<script>
import LayoutAdmin from '../../../Layouts/Admin.vue';
export default { layout: LayoutAdmin }
</script>
