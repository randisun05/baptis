<template>
  <Head>
    <title>Login Administrator</title>
  </Head>

  <section class="bg-light d-flex align-items-center min-vh-100 py-5">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-5 col-md-7">

          <div class="card shadow-lg border-0 rounded-4">
            <div class="card-body p-5">
              
              <div class="text-center mb-5">
                <div class="bg-navy text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3 shadow-sm" style="width: 70px; height: 70px;">
                  <i class="bi bi-person-badge fs-1"></i>
                </div>
                <h2 class="fw-bold text-navy">Portal Pengurus</h2>
                <p class="text-muted small">Paroki Santa Melania</p>
              </div>

              <div v-if="$page.props.flash?.message || $page.props.flash?.error || form.errors.email" 
                  class="alert alert-danger bg-danger-subtle text-danger-emphasis border-0 rounded-3 mb-4 fade show" 
                  role="alert">
                <div class="d-flex align-items-center">
                    <i class="bi bi-exclamation-circle-fill me-2"></i>
                    <div>
                      {{ $page.props.flash?.message || $page.props.flash?.error || form.errors.email }}
                    </div>
                </div>
              </div>

              <form @submit.prevent="submit">

                <div class="form-floating mb-3">
                  <input
                    class="form-control input-cantik"
                    :class="{ 'is-invalid': form.errors.email }"
                    id="email"
                    type="email"
                    v-model="form.email"
                    placeholder="name@example.com"
                  />
                  <label for="email" class="text-muted">Alamat Email</label>
                </div>

                <div class="form-floating mb-4 position-relative">
                  <input
                    class="form-control input-cantik"
                    :class="{ 'is-invalid': form.errors.password }"
                    id="password"
                    :type="passwordFieldType"
                    v-model="form.password"
                    placeholder="Password"
                  />
                  <label for="password" class="text-muted">Password</label>
                  
                  <button 
                    type="button" 
                    @click="togglePasswordVisibility" 
                    class="btn btn-sm text-muted position-absolute end-0 top-50 translate-middle-y me-3 p-0"
                    style="z-index: 1000;"
                    aria-label="Toggle Password Visibility"
                  >
                      <i :class="['bi', isPasswordVisible ? 'bi-eye-slash-fill' : 'bi-eye-fill']"></i>
                  </button>

                  <div v-if="form.errors.password" class="invalid-feedback">
                    {{ form.errors.password }}
                  </div>
                </div>
                <div class="d-grid">
                  <button
                    class="btn btn-navy btn-lg py-3 fw-bold shadow-sm"
                    :class="{ 'disabled': form.processing }"
                    :disabled="form.processing"
                    type="submit">
                    
                    <span v-if="form.processing">
                      <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                      Memproses...
                    </span>
                    <span v-else>
                      Login <i class="bi bi-arrow-right ms-2"></i>
                    </span>

                  </button>
                </div>

                <div class="text-center mt-4">
                    <a href="/" class="text-decoration-none small text-muted hover-navy">
                        <i class="bi bi-arrow-left me-1"></i> Kembali ke Beranda Website
                    </a>
                </div>

              </form>
            </div>
          </div>
          
          <div class="text-center mt-4 text-muted small">
            &copy; 2025 Sistem Informasi Paroki Santa Melania
          </div>

        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { Head, useForm } from '@inertiajs/inertia-vue3'
import { ref, computed } from 'vue' // Import ref dan computed dari vue

const form = useForm({
  email: '',
  password: '',
})

const submit = () => {
  form.post('/login', {
    onFinish: () => form.reset('password'),
  })
}

// Logika Toggle Password
const isPasswordVisible = ref(false)

const passwordFieldType = computed(() => {
  return isPasswordVisible.value ? 'text' : 'password'
})

const togglePasswordVisibility = () => {
  isPasswordVisible.value = !isPasswordVisible.value
}
</script>

<script>
// Menggunakan Layout Website (agar style global termuat), 
// tapi kontennya kita override dengan section full-screen di atas.
import LayoutAuth from '../../Layouts/Website.vue'
export default {
    layout: LayoutAuth
}
</script>

<style scoped>
/* --- Theme Variables --- */
.text-navy { color: #003366 !important; }
.bg-navy { background-color: #003366 !important; }

/* --- Input Styles (Konsisten dengan form sebelumnya) --- */
.input-cantik {
    border: 1px solid #b0b8c4;
    border-radius: 8px;
    background-color: #fcfcfc;
    height: calc(3.5rem + 2px); /* Sesuaikan tinggi untuk floating label */
    transition: all 0.3s ease;
}

.input-cantik:focus {
    border-color: #003366;
    box-shadow: 0 0 0 4px rgba(0, 51, 102, 0.1);
    background-color: #ffffff;
}

/* Fix Floating Label agar pas dengan border custom */
.form-floating > label {
    padding-left: 1.2rem;
}
.form-floating > .form-control {
    padding-left: 1.2rem;
    /* Tambahkan padding kanan agar tidak tertutup tombol mata */
    padding-right: 3rem; 
}

/* Penyesuaian untuk tombol toggle agar tidak mengganggu label/input */
.form-floating > .form-control:not(:placeholder-shown) ~ button {
    /* Hanya untuk memastikan posisi relatif terhadap input terisi */
    right: 0; 
}

/* --- Button Styles --- */
.btn-navy {
    background-color: #003366;
    color: white;
    border: none;
    border-radius: 8px;
    transition: all 0.2s ease;
}

.btn-navy:hover {
    background-color: #002244;
    color: #ffffff;
    transform: translateY(-2px);
    box-shadow: 0 4px 10px rgba(0, 51, 102, 0.3) !important;
}

/* --- Utilities --- */
.hover-navy:hover {
    color: #003366 !important;
    text-decoration: underline !important;
}

/* Agar card terlihat pop-up */
.card {
    border-top: 5px solid #003366; /* Aksen garis biru di atas card */
}
</style>