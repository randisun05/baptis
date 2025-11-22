<template>
    <Head title="Enroll Peserta" />

    <div class="container-fluid px-4 py-4">
        <div class="row justify-content-center">
            <div class="col-md-12">

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h2 class="fs-3 fw-bold mb-0 text-dark">Enroll Peserta Baru</h2>
                        <p class="text-muted mb-0">Event: <span class="fw-bold text-primary">{{ event.title }}</span></p>
                    </div>
                    <Link :href="`/admin/events/${event.id}`" class="btn btn-outline-secondary border-0 shadow-sm">
                        <i class="fa fa-arrow-left me-1"></i> Kembali
                    </Link>
                </div>

                <div class="card border-0 shadow">
                    <div class="card-body p-4">

                        <div class="row mb-4 align-items-end">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Cari Member</label>
                                <div class="input-group">
                                    <span class="input-group-text border-0 bg-light"><i class="fa fa-search"></i></span>
                                    <input type="text" class="form-control border-0 bg-light" v-model="search" placeholder="Ketik nama atau instansi...">
                                </div>
                            </div>
                            <div class="col-md-6 text-md-end mt-3 mt-md-0">
                                <div class="d-flex justify-content-end align-items-center gap-3">
                                    <span class="text-muted small" v-if="form.member_ids.length > 0">
                                        {{ form.member_ids.length }} peserta dipilih
                                    </span>
                                    <button @click="submit" :disabled="form.processing || form.member_ids.length === 0" class="btn btn-primary px-4 shadow-sm">
                                        <i class="fa fa-user-plus me-1"></i>
                                        {{ form.processing ? 'Menyimpan...' : 'Enroll Sekarang' }}
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div v-if="filteredMembers.length === 0" class="alert alert-info text-center">
                            <span v-if="members.length === 0">Semua member sudah terdaftar di event ini.</span>
                            <span v-else>Member dengan kata kunci "<strong>{{ search }}</strong>" tidak ditemukan.</span>
                        </div>

                        <div v-else class="table-responsive">
                            <table class="table table-hover table-centered align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="text-center" style="width: 50px;">
                                            <input type="checkbox" class="form-check-input"
                                                :checked="isAllSelected"
                                                @change="toggleSelectAll">
                                        </th>
                                        <th>Nama Lengkap</th>
                                        <th>Kelompok Katekese</th>
                                        <th>Email</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="member in filteredMembers" :key="member.id" :class="{'table-primary': form.member_ids.includes(member.id)}">
                                        <td class="text-center">
                                            <input type="checkbox" class="form-check-input"
                                                :value="member.id"
                                                v-model="form.member_ids">
                                        </td>
                                        <td class="fw-bold">{{ member.name }}</td>
                                        
                                        <td>
                                            <span v-if="getGroupName(member.group)" 
                                                :class="getGroupBadgeClass(member.group)">
                                                <i class="bi bi-people-fill me-1"></i> {{ getGroupName(member.group) }}
                                            </span>
                                            <span v-else class="text-muted small fst-italic">
                                                - Tidak ditentukan -
                                            </span>
                                        </td>
                                        <td>
                                            <div class="small">{{ member.email }}</div>
                                            <div class="small text-muted">{{ member.contact || '-' }}</div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import Swal from 'sweetalert2';
import LayoutAdmin from '../../../Layouts/Admin.vue'; // Sesuaikan path layout

// Props dari controller
const props = defineProps({
    members: Array, // List member yang belum enroll
    event: Object,  // Data event saat ini
});

// State Search (Client Side)
const search = ref('');

// Form Inertia
const form = useForm({
    member_ids: [], // Array untuk menampung ID yang diceklis
});

// === HELPER FUNCTIONS (DISALIN DARI KODE DATA PESERTA) ===

const getGroupName = (groupValue) => {
    // Asumsi: nilai 'groupValue' bisa berupa boolean (dari Casting Laravel) atau string 'Katekumen'/'Sakramen Baptis Bayi'
    if (groupValue === true || groupValue === 'Katekumen' || groupValue === 1) {
        return 'Katekumen';
    } else if (groupValue === false || groupValue === 'Sakramen Baptis Bayi' || groupValue === 0) {
        return 'Sakramen Baptis Bayi';
    }
    return null; // Mengembalikan null jika tidak cocok
};

const getGroupBadgeClass = (groupValue) => {
    if (groupValue === true || groupValue === 'Katekumen' || groupValue === 1) {
        // Katekumen: Warna Info/Cyan
        return 'badge bg-info-subtle text-info-emphasis border border-info-subtle fw-normal px-3 py-2';
    } else if (groupValue === false || groupValue === 'Sakramen Baptis Bayi' || groupValue === 0) {
        // Sakramen Baptis Bayi: Warna Primary/Biru
        return 'badge bg-primary-subtle text-primary-emphasis border border-primary-subtle fw-normal px-3 py-2';
    }
    return 'badge bg-light text-muted border border-secondary-subtle fw-normal px-3 py-2';
};

// === END HELPER FUNCTIONS ===


// Computed: Filter member berdasarkan search
const filteredMembers = computed(() => {
    if (!search.value) return props.members;
    return props.members.filter(member => {
        const searchText = search.value.toLowerCase();
        return member.name.toLowerCase().includes(searchText) ||
               (member.email && member.email.toLowerCase().includes(searchText)) ||
               (member.contact && member.contact.toLowerCase().includes(searchText));
    });
});

// Computed: Cek apakah semua data yang TAMPIL sudah terpilih
const isAllSelected = computed(() => {
    if (filteredMembers.value.length === 0) return false;
    // Cek apakah setiap member yang tampil ada di array form.member_ids
    return filteredMembers.value.every(member => form.member_ids.includes(member.id));
});

// Function: Toggle Select All
const toggleSelectAll = () => {
    if (isAllSelected.value) {
        // Jika sudah terpilih semua, batalkan pilihan (hanya untuk yang tampil/terfilter)
        const displayedIds = filteredMembers.value.map(m => m.id);
        form.member_ids = form.member_ids.filter(id => !displayedIds.includes(id));
    } else {
        // Jika belum, tambahkan semua yang tampil ke array, lalu buat unique pakai Set
        const displayedIds = filteredMembers.value.map(m => m.id);
        form.member_ids = [...new Set([...form.member_ids, ...displayedIds])];
    }
};

// Function: Submit
const submit = () => {
    if (form.member_ids.length === 0) {
        Swal.fire('Peringatan', 'Pilih setidaknya satu peserta.', 'warning');
        return;
    }

    Swal.fire({
        title: 'Konfirmasi Enroll',
        text: `Apakah Anda yakin ingin mendaftarkan ${form.member_ids.length} peserta ini?`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Ya, Simpan',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            // Pastikan URL route sesuai dengan route web.php Anda
            form.post(`/admin/events/${props.event.id}/enroll`, {
                onSuccess: () => {
                    Swal.fire('Berhasil', 'Peserta berhasil didaftarkan.', 'success');
                    form.reset();
                }
            });
        }
    });
};
</script>

<script>
export default { layout: LayoutAdmin }
</script>

<style scoped>
/* --- DISALIN DARI KODE DATA PESERTA UNTUK BADGE STYLE --- */
/* Adopsi Warna Subtlety dan Tambahan Warna Baru */
.bg-success-subtle { background-color: #d1e7dd; }
.text-success-emphasis { color: #0f5132; }
.bg-danger-subtle { background-color: #f8d7da; }
.text-danger-emphasis { color: #842029; }
.bg-warning-subtle { background-color: #fff3cd; }
.text-warning-emphasis { color: #664d03; }
.bg-secondary-subtle { background-color: #e2e3e5; }
.text-secondary-emphasis { color: #41464b; }
.bg-info-subtle { background-color: #cff4fc; } /* Custom Info Subtle */
.text-info-emphasis { color: #055160; } /* Custom Info Emphasis */
.bg-primary-subtle { background-color: #cfe2ff; }
.text-primary-emphasis { color: #0a58ca; }
/* -------------------------------------------------------- */

/* Gaya lainnya */
.card { border-radius: 12px; }
.table-centered th, .table-centered td {
    vertical-align: middle;
}
.table-primary {
    --bs-table-bg: #e0f7fa; /* Warna latar belakang untuk baris yang dipilih */
}
</style>