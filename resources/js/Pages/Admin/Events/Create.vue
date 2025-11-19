<template>
    <Head title="Tambah Kegiatan Baru" />

    <div class="container-fluid px-4 py-4">
        <div class="row justify-content-center">
            <div class="col-md-10">

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="fs-3 fw-bold mb-0">Tambah Kegiatan</h2>
                    <Link href="/admin/events" class="btn btn-outline-secondary">
                        <i class="fa fa-arrow-left me-1"></i> Kembali
                    </Link>
                </div>

                <div class="card border-0 shadow">
                    <div class="card-body p-4">
                        <form @submit.prevent="submit">

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Nama Kegiatan</label>
                                    <input type="text" class="form-control" v-model="form.title" @input="createSlug" :class="{ 'is-invalid': form.errors.title }" placeholder="Masukkan nama kegiatan">
                                    <div v-if="form.errors.title" class="invalid-feedback">{{ form.errors.title }}</div>
                                </div>
                                    <div class="col-md-6">
                                    <label class="form-label fw-bold">Tanggal Mulai</label>
                                    <input type="date" class="form-control" v-model="form.date" :class="{ 'is-invalid': form.errors.date }">
                                    <div v-if="form.errors.date" class="invalid-feedback">{{ form.errors.date }}</div>
                                </div>

                            </div>


                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <button type="reset" class="btn btn-light me-md-2">Reset</button>
                                <button type="submit" class="btn btn-primary" :disabled="form.processing">
                                    <i class="fa fa-save me-1"></i>
                                    {{ form.processing ? 'Menyimpan...' : 'Simpan Kegiatan' }}
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
import { useForm } from '@inertiajs/inertia-vue3';

const form = useForm({
    title: '',
    date: '',
});


const submit = () => {
    form.post('/admin/events');
};
</script>

<script>
import LayoutAdmin from '../../../Layouts/Admin.vue';
export default { layout: LayoutAdmin }
</script>
