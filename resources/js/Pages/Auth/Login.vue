<template>
  <Head>
    <title>Login Administrator</title>
  </Head>

  <section class="bg-light py-5">
    <div class="container px-5 my-5 px-5">
      <div class="text-center mb-5">
        <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3">
          <i class="bi bi-envelope"></i>
        </div>
        <h2 class="fw-bolder">Login</h2>
        <p class="lead mb-0">Administrator</p>
      </div>
      <div class="row gx-5 justify-content-center">
        <div class="col-lg-6">

          <!-- <div v-if="$page.props.flash.message" class="alert alert-success alert-dismissible fade show" role="alert">
             {{ $page.props.flash.message }}
          </div>
          <div v-if="$page.props.flash.error" class="alert alert-danger alert-dismissible fade show" role="alert">
             {{ $page.props.flash.error }}
          </div> -->

          <form @submit.prevent="submit">

            <div class="form-floating mb-3">
              <input
                class="form-control"
                :class="{ 'is-invalid': form.errors.email }"
                id="email"
                type="email"
                v-model="form.email"
                placeholder="name@example.com"
              />
              <label for="email">Email</label>
              <div v-if="form.errors.email" class="invalid-feedback">
                {{ form.errors.email }}
              </div>
            </div>

            <div class="form-floating mb-3">
              <input
                class="form-control"
                :class="{ 'is-invalid': form.errors.password }"
                id="password"
                type="password"
                v-model="form.password"
                placeholder="Password"
              />
              <label for="password">Password</label>
              <div v-if="form.errors.password" class="invalid-feedback">
                {{ form.errors.password }}
              </div>
            </div>

            <div class="d-grid">
              <button
                class="btn btn-primary btn-lg"
                :class="{ 'disabled': form.processing }"
                :disabled="form.processing"
                id="submitButton"
                type="submit">
                {{ form.processing ? 'Loading...' : 'Login' }}
              </button>
            </div>
          </form>
          </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { Head, useForm } from '@inertiajs/inertia-vue3'

// Menggunakan useForm dari Inertia untuk handling form otomatis
const form = useForm({
  email: '',
  password: '',
})

const submit = () => {
  form.post('/login', {
    onFinish: () => form.reset('password'), // Reset password field setelah submit selesai
    // onError otomatis di-handle oleh Inertia dan masuk ke form.errors
  })
}
</script>

<script>
import LayoutAuth from '../../Layouts/Website.vue'
export default {
    layout: LayoutAuth
}
</script>
