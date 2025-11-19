<template>
  <Head title="Tambah Post Baru" />

  <div class="container-fluid px-4 py-4">
    <div class="row justify-content-center">
      <div class="col-md-8">

        <div class="d-flex justify-content-between align-items-center mb-3">
           <h2 class="fs-3 fw-bold">Tambah Post</h2>
           <Link href="/posts" class="btn btn-outline-secondary btn-sm">Kembali</Link>
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
                    placeholder="Masukkan judul..."
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
                    placeholder="Tulis konten di sini..."
                ></textarea>
                <div v-if="form.errors.body" class="invalid-feedback">
                    {{ form.errors.body }}
                </div>
              </div>

              <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary" :disabled="form.processing">
                    <i class="bi bi-save me-1"></i>
                    {{ form.processing ? 'Menyimpan...' : 'Simpan Data' }}
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

const form = useForm({
    title: '',
    body: ''
})

const submit = () => {
    form.post('/admin/posts')
}
</script>

<script>
import LayoutAdmin from '../../../Layouts/Admin.vue';
export default { layout: LayoutAdmin }
</script>
