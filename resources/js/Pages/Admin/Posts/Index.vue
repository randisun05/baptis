<template>
  <Head title="Data Posts" />

  <div class="container-fluid px-4 py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
      <h2 class="fs-3 fw-bold text-dark">Daftar Post</h2>
      <Link href="/admin/posts/create" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i> Tambah Post
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
                <th>Judul</th>
                <th>Konten (Excerpt)</th>
                <th class="text-center">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(post, index) in posts.data" :key="post.id">
                <td>{{ index + 1 }}</td>
                <td class="fw-semibold">{{ post.title }}</td>
                <td class="text-muted">{{ post.body.substring(0, 50) }}...</td>
                <td class="text-center">
                  <Link :href="`/admin/posts/${post.id}/edit`" class="btn btn-sm btn-warning me-2">
                    <i class="bi bi-pencil-square"></i> Edit
                  </Link>
                  <button @click="destroy(post.id)" class="btn btn-sm btn-danger">
                    <i class="bi bi-trash"></i> Hapus
                  </button>
                </td>
              </tr>
              <tr v-if="posts.data.length === 0">
                <td colspan="4" class="text-center py-4 text-muted">Data belum tersedia.</td>
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

// Menerima props dari Controller
defineProps({
    posts: Object,

})

// Fungsi Hapus
const destroy = (id) => {
    if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
        Inertia.delete(`/admin/posts/${id}`)
    }
}
</script>

<script>
import LayoutAdmin from '../../../Layouts/Admin.vue';
export default { layout: LayoutAdmin };
</script>
