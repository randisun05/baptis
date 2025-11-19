<template>
  <Head title="Edit Post" />

  <div class="container-fluid px-4 py-4">
    <div class="row justify-content-center">
      <div class="col-md-8">

        <div class="d-flex justify-content-between align-items-center mb-3">
           <h2 class="fs-3 fw-bold">Edit Post</h2>
           <Link href="/posts" class="btn btn-outline-secondary btn-sm">Kembali</Link>
        </div>

        <div class="card shadow-sm border-0">
          <div class="card-body p-4">
            <form @submit.prevent="submit">

              <div class="mb-3">
                <label for="title" class="form-label fw-semibold">Judul Post</label>
                <input
                    type="text"
                    class="form-control"
                    :class="{ 'is-invalid': form.errors.title }"
                    id="title"
                    v-model="form.title"
                >
                <div v-if="form.errors.title" class="invalid-feedback">
                    {{ form.errors.title }}
                </div>
              </div>

              <div class="mb-4">
                <label for="body" class="form-label fw-semibold">Konten</label>
                <textarea
                    class="form-control"
                    :class="{ 'is-invalid': form.errors.body }"
                    id="body"
                    v-model="form.body"
                    rows="6"
                ></textarea>
                <div v-if="form.errors.body" class="invalid-feedback">
                    {{ form.errors.body }}
                </div>
              </div>

              <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary" :disabled="form.processing">
                    <i class="bi bi-check-circle me-1"></i>
                    {{ form.processing ? 'Mengupdate...' : 'Update Data' }}
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

// Mengambil props post yang dikirim dari controller
const props = defineProps({
    post: Object
})

// Inisialisasi form dengan data yang ada
const form = useForm({
    title: props.post.title,
    body: props.post.body
})

const submit = () => {
    form.put(`/admin/posts/${props.post.id}`)
}
</script>

<script>
import LayoutAdmin from '../../../Layouts/Admin.vue';
export default { layout: LayoutAdmin }
</script>
