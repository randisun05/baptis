<template>
    <Head title="Referensi Kegiatan" />

    <div class="container-fluid px-4 py-4">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fs-3 fw-bold text-dark mb-0">Referensi Kegiatan</h2>
            <button @click="openCreateModal" class="btn btn-primary border-0 shadow">
                <i class="fa fa-plus-circle me-2"></i> Tambah Referensi
            </button>
        </div>

        <div class="row mb-4">
            <div class="col-md-6">
                <form @submit.prevent="handleSearch">
                    <div class="input-group">
                        <input type="text" class="form-control border-0 shadow-sm" v-model="search" placeholder="Cari nama referensi...">
                        <button class="input-group-text border-0 shadow-sm bg-white">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card border-0 shadow">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-centered table-nowrap mb-0 rounded">
                        <thead class="thead-dark table-light">
                            <tr>
                                <th class="border-0 rounded-start" style="width:5%">No.</th>
                                <th class="border-0">Nama Referensi</th>
                                <th class="border-0 rounded-end text-center" style="width:15%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(item, index) in refevents.data" :key="item.id">
                                <td class="fw-bold text-center">
                                    {{ ++index + (refevents.current_page - 1) * refevents.per_page }}
                                </td>
                                <td>
                                    <div class="fw-bold">{{ item.title }}</div>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <button @click="openEditModal(item)" class="btn btn-sm btn-warning text-white me-1" title="Edit">
                                            <i class="fa fa-pencil"></i>
                                        </button>
                                        <button @click="destroy(item.id)" class="btn btn-sm btn-danger" title="Hapus">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr v-if="refevents.data.length === 0">
                                <td colspan="3" class="text-center py-4 text-muted">Data referensi belum tersedia.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <Pagination :links="refevents.links" align="end" class="mt-3" />
            </div>
        </div>

        <div class="modal fade" id="refModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title fw-bold">{{ isEditMode ? 'Edit Referensi' : 'Tambah Referensi Baru' }}</h5>
                        <button type="button" class="btn-close" @click="closeModal" aria-label="Close"></button>
                    </div>
                    <form @submit.prevent="submit">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Nama Referensi Kegiatan</label>
                                <input type="text" class="form-control" v-model="form.title" placeholder="Contoh: Misa Natal, Baptis Bayi" :class="{ 'is-invalid': form.errors.title }">
                                <div v-if="form.errors.title" class="invalid-feedback">
                                    {{ form.errors.title }}
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="closeModal">Batal</button>
                            <button type="submit" class="btn btn-primary" :disabled="form.processing">
                                <i class="fa fa-save me-1"></i> {{ isEditMode ? 'Update' : 'Simpan' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { Head, useForm } from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia';
import Swal from 'sweetalert2';
import Pagination from '../../../Components/Pagination.vue';

// Props disesuaikan dengan nama variabel di controller ('refevents')
const props = defineProps({
    refevents: Object,
});

// State Variables
const search = ref('' || (new URL(document.location)).searchParams.get('q'));
const isEditMode = ref(false);
let modalInstance = null;

// Form Reactive (Hanya title, karena controller hanya validasi title)
const form = useForm({
    title: '',
});

onMounted(() => {
    modalInstance = new window.bootstrap.Modal(document.getElementById('refModal'));
});

// --- Functions ---

const handleSearch = () => {
    Inertia.get('/admin/events/ref', { q: search.value }, { preserveState: true });
};

const openCreateModal = () => {
    isEditMode.value = false;
    form.reset();
    form.clearErrors();
    modalInstance.show();
};

const openEditModal = (item) => {
    isEditMode.value = true;
    form.clearErrors();
    form.id = item.id;
    form.title = item.title;
    modalInstance.show();
};

const closeModal = () => {
    modalInstance.hide();
    form.reset();
};

const submit = () => {
    if (isEditMode.value) {
        // Update Logic
        // URL ini harus match dengan Route di web.php yang mengarah ke function Updateref
        form.put(`/admin/events-ref/${form.id}`, {
            onSuccess: () => {
                closeModal();
                Swal.fire('Berhasil', 'Data referensi berhasil diperbarui.', 'success');
            },
        });
    } else {
        // Create Logic
        // URL ini harus match dengan Route di web.php yang mengarah ke function Storeref
        form.post('/admin/events-ref', {
            onSuccess: () => {
                closeModal();
                Swal.fire('Berhasil', 'Data referensi berhasil ditambahkan.', 'success');
            },
        });
    }
};

const destroy = (id) => {
    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: "Data referensi ini akan dihapus permanen!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            // Delete Logic
            // URL ini harus match dengan Route di web.php yang mengarah ke function Deleteref
            Inertia.delete(`/admin/events-ref/${id}`, {
                onSuccess: () => Swal.fire('Terhapus!', 'Data telah dihapus.', 'success')
            });
        }
    });
};
</script>

<script>
import LayoutAdmin from '../../../Layouts/Admin.vue';
export default { layout: LayoutAdmin }
</script>
