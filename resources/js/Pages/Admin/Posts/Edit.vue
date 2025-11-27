<template>
  <Head title="Edit Post" />

  <div class="container-fluid px-4 py-4">
    <div class="row justify-content-center">
      <div class="col-md-8">

        <div class="d-flex justify-content-between align-items-center mb-4">
           <div>
             <h2 class="fs-3 fw-bold text-navy mb-0">Edit Warta</h2>
             <p class="text-muted small mb-0">Perbarui informasi warta.</p>
           </div>
           <Link href="/admin/posts" class="btn btn-outline-navy btn-sm shadow-sm">
             <i class="bi bi-arrow-left me-1"></i> Kembali
           </Link>
        </div>

        <div v-if="$page.props.session?.error"
             class="alert alert-danger bg-danger-subtle text-danger-emphasis alert-dismissible fade show shadow-sm border-0 mb-4"
             role="alert">
             <i class="bi bi-exclamation-triangle-fill me-2"></i>
             {{ $page.props.session?.error }}
             <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>

        <div class="card shadow-sm border-0 rounded-4">
          <div class="card-body p-4">
            <form @submit.prevent="submit">

              <div class="mb-4">
                <label for="title" class="form-label fw-bold text-navy">Judul Warta</label>
                <input
                    type="text"
                    class="form-control form-control-lg"
                    :class="{ 'is-invalid': form.errors.title }"
                    id="title"
                    v-model="form.title"
                    placeholder="Masukkan judul warta..."
                >
                <div v-if="form.errors.title" class="invalid-feedback">
                    {{ form.errors.title }}
                </div>
              </div>

              <div class="mb-4">
                <label for="image" class="form-label fw-bold text-navy">Gambar Utama</label>
                
                <div v-if="post.image" class="mb-2 p-2 border rounded bg-light d-inline-block">
                    <div class="small text-muted mb-1">Gambar Saat Ini:</div>
                    <img :src="`/storage/${post.image}`" class="img-thumbnail" style="max-height: 150px; width: auto;" alt="Current Image">
                </div>

                <input 
                    type="file" 
                    class="form-control" 
                    :class="{ 'is-invalid': form.errors.image }"
                    id="image"
                    @input="form.image = $event.target.files[0]" 
                    accept="image/*"
                >
                <div class="form-text text-muted small">Biarkan kosong jika tidak ingin mengganti gambar.</div>
                <div v-if="form.errors.image" class="invalid-feedback">
                    {{ form.errors.image }}
                </div>
                
                <div v-if="form.progress" class="progress mt-2" style="height: 5px;">
                  <div class="progress-bar bg-navy" role="progressbar" :style="{ width: form.progress.percentage + '%' }"></div>
                </div>
              </div>

              <div class="mb-4">
                <label for="body" class="form-label fw-bold text-navy">Konten</label>
                <textarea
                    class="form-control"
                    :class="{ 'is-invalid': form.errors.body }"
                    id="body"
                    v-model="form.body"
                    rows="8"
                    placeholder="Tulis konten warta lengkap di sini..."
                ></textarea>
                <div v-if="form.errors.body" class="invalid-feedback">
                    {{ form.errors.body }}
                </div>
              </div>

              <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <button type="submit" class="btn btn-navy px-4 py-2" :disabled="form.processing">
                    <span v-if="form.processing">
                        <span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>
                        Menyimpan...
                    </span>
                    <span v-else>
                        <i class="bi bi-save me-1"></i> Update Data
                    </span>
                </button>
              </div>

            </form>
          </div>
        </div>

      </div>
    </div>
  </div>
</template>

<script setup>
import { Head, Link, useForm } from '@inertiajs/inertia-vue3'
import { Inertia } from '@inertiajs/inertia'
// 1. Import SweetAlert2
import Swal from 'sweetalert2'

// Mengambil props post yang dikirim dari controller
const props = defineProps({
    post: Object
})

// Inisialisasi form
const form = useForm({
    _method: 'PUT', 
    title: props.post.title,
    body: props.post.body,
    image: null, 
})

const submit = () => {
    form.post(`/admin/posts/${props.post.id}`, {
        // 2. Tambahkan Alert di onSuccess
        onSuccess: () => {
            Swal.fire({
                title: 'Berhasil!',
                text: 'Data post berhasil diperbarui.',
                icon: 'success',
                confirmButtonColor: '#003366', // Warna Navy
                confirmButtonText: 'OK'
            });
            
            form.image = null;
        }
    })
}
</script>

<script>
import LayoutAdmin from '../../../Layouts/Admin.vue';
export default { layout: LayoutAdmin }
</script>

<style scoped>
/* --- Theme Variables & Styles --- */
:root {
    --navy-primary: #003366;
    --navy-hover: #002244;
}

.text-navy { color: #003366; }
.bg-navy { background-color: #003366; }

/* Button Custom Navy */
.btn-navy {
    background-color: #003366;
    color: white;
    border: none;
    border-radius: 6px;
    transition: all 0.2s ease;
}
.btn-navy:hover {
    background-color: #002244;
    color: #ffffff;
    transform: translateY(-1px);
    box-shadow: 0 4px 6px rgba(0, 51, 102, 0.2);
}

/* Button Outline Navy */
.btn-outline-navy {
    color: #003366;
    border-color: #003366;
    background-color: transparent;
}
.btn-outline-navy:hover {
    color: white;
    background-color: #003366;
}

/* Utils */
.card { border-radius: 12px; }
.bg-danger-subtle { background-color: #f8d7da; }
.text-danger-emphasis { color: #842029; }
</style>