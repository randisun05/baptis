<template>
    <Head title="Unenroll Peserta" />

    <div class="container-fluid px-3 px-md-4 py-3 py-md-4 mb-5 mb-md-0">
        <div class="row justify-content-center">
            <div class="col-md-12">

                <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
                    <div>
                        <h2 class="fs-4 fs-md-3 fw-bold mb-0 text-danger">Hapus Peserta Event</h2>
                        <p class="text-muted mb-0 small-md">Event: <span class="fw-bold text-navy">{{ event.title }}</span></p>
                    </div>
                    <Link :href="`/admin/events/${event.id}`" class="btn btn-outline-secondary border-0 shadow-sm w-100 w-md-auto text-start text-md-center">
                        <i class="fa fa-arrow-left me-2"></i> Kembali
                    </Link>
                </div>

                <div class="card border-0 shadow rounded-4">
                    <div class="card-body p-3 p-md-4">

                        <div class="row mb-3 align-items-end g-3">
                            <div class="col-12 col-md-6">
                                <label class="form-label fw-bold d-none d-md-block">Cari Peserta Terdaftar</label>
                                <div class="input-group">
                                    <span class="input-group-text border-0 bg-light ps-3"><i class="fa fa-search text-muted"></i></span>
                                    <input type="text" class="form-control border-0 bg-light py-2" v-model="search" placeholder="Cari nama peserta untuk dihapus...">
                                </div>
                            </div>
                            
                            <div class="col-md-6 text-md-end d-none d-md-block">
                                <div class="d-flex justify-content-end align-items-center gap-3">
                                    <span class="text-muted small" v-if="form.member_ids.length > 0">
                                        {{ form.member_ids.length }} peserta dipilih
                                    </span>
                                    <button @click="submit" :disabled="form.processing || form.member_ids.length === 0" class="btn btn-danger px-4 shadow-sm">
                                        <i class="fa fa-trash me-1"></i>
                                        {{ form.processing ? 'Menghapus...' : 'Hapus Peserta' }}
                                    </button>
                                </div>
                            </div>

                            <div class="col-12 d-md-none d-flex justify-content-between align-items-center mt-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" :checked="isAllSelected" @change="toggleSelectAll" id="selectAllMobile">
                                    <label class="form-check-label small text-muted" for="selectAllMobile">
                                        Pilih Semua Tampil
                                    </label>
                                </div>
                                <span class="badge bg-danger-subtle text-danger rounded-pill" v-if="form.member_ids.length > 0">
                                    {{ form.member_ids.length }} Dipilih
                                </span>
                            </div>
                        </div>

                        <div v-if="filteredMembers.length === 0" class="alert alert-light text-center border bg-light text-muted">
                            <i class="bi bi-info-circle me-2"></i>
                            <span v-if="members.length === 0">Belum ada peserta yang terdaftar di event ini.</span>
                            <span v-else>Peserta dengan kata kunci "<strong>{{ search }}</strong>" tidak ditemukan.</span>
                        </div>

                        <div v-else class="table-responsive d-none d-md-block">
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
                                    <tr v-for="member in filteredMembers" :key="member.id" :class="{'table-danger-custom': form.member_ids.includes(member.id)}">
                                        <td class="text-center">
                                            <input type="checkbox" class="form-check-input"
                                                :value="member.id"
                                                v-model="form.member_ids">
                                        </td>
                                        <td class="fw-bold text-navy">{{ member.name }}</td>
                                        <td>
                                            <span v-if="getGroupName(member.group)" :class="getGroupBadgeClass(member.group)">
                                                <i class="bi bi-people-fill me-1"></i> {{ getGroupName(member.group) }}
                                            </span>
                                            <span v-else class="text-muted small fst-italic">-</span>
                                        </td>
                                        <td>
                                            <div class="small">{{ member.email }}</div>
                                            <div class="small text-muted">{{ member.contact || '-' }}</div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="d-md-none mt-2">
                            <div v-for="member in filteredMembers" :key="member.id" 
                                class="card mb-3 border shadow-sm member-card"
                                :class="{'border-danger bg-danger-subtle-light': form.member_ids.includes(member.id)}"
                                @click="toggleMember(member.id)">
                                <div class="card-body p-3">
                                    <div class="d-flex align-items-start gap-3">
                                        <div class="pt-1">
                                            <input type="checkbox" class="form-check-input fs-5" :checked="form.member_ids.includes(member.id)" readonly>
                                        </div>
                                        
                                        <div class="flex-grow-1">
                                            <div class="d-flex justify-content-between align-items-start mb-1">
                                                <h6 class="fw-bold text-navy mb-0">{{ member.name }}</h6>
                                            </div>
                                            
                                            <div class="mb-2">
                                                <span v-if="getGroupName(member.group)" :class="getGroupBadgeClass(member.group)" class="badge-sm">
                                                    {{ getGroupName(member.group) }}
                                                </span>
                                            </div>

                                            <div class="text-muted small">
                                                <div v-if="member.email" class="mb-1"><i class="fa fa-envelope me-2 text-primary opacity-50"></i> {{ member.email }}</div>
                                                <div v-if="member.contact"><i class="fa fa-phone me-2 text-success opacity-50"></i> {{ member.contact }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="fixed-bottom p-3 bg-white border-top shadow d-md-none" v-if="form.member_ids.length > 0">
            <div class="d-grid">
                <button @click="submit" :disabled="form.processing" class="btn btn-danger btn-lg shadow">
                    <span v-if="form.processing">Processing...</span>
                    <span v-else>
                        Hapus {{ form.member_ids.length }} Peserta <i class="fa fa-trash ms-2"></i>
                    </span>
                </button>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import Swal from 'sweetalert2';
import LayoutAdmin from '../../../Layouts/Admin.vue';

const props = defineProps({
    members: Array, // Ini adalah member yang SUDAH terdaftar
    event: Object,
});

const search = ref('');
const form = useForm({
    member_ids: [],
});

// === Helper Functions (Sama seperti Enroll) ===
const getGroupName = (groupValue) => {
    if (groupValue === true || groupValue === 'Katekumen' || groupValue === 1) return 'Katekumen';
    if (groupValue === false || groupValue === 'Sakramen Baptis Bayi' || groupValue === 0) return 'Sakramen Baptis Bayi';
    return null;
};

const getGroupBadgeClass = (groupValue) => {
    if (groupValue === true || groupValue === 'Katekumen' || groupValue === 1) {
        return 'badge bg-info-subtle text-info-emphasis border border-info-subtle fw-normal px-2 px-md-3 py-1 py-md-2';
    } else if (groupValue === false || groupValue === 'Sakramen Baptis Bayi' || groupValue === 0) {
        return 'badge bg-primary-subtle text-primary-emphasis border border-primary-subtle fw-normal px-2 px-md-3 py-1 py-md-2';
    }
    return 'badge bg-light text-muted border border-secondary-subtle fw-normal px-2 px-md-3 py-1 py-md-2';
};

// === Logic ===
const filteredMembers = computed(() => {
    if (!search.value) return props.members;
    const searchText = search.value.toLowerCase();
    return props.members.filter(member => {
        return member.name.toLowerCase().includes(searchText) ||
               (member.email && member.email.toLowerCase().includes(searchText)) ||
               (member.contact && member.contact.toLowerCase().includes(searchText));
    });
});

const isAllSelected = computed(() => {
    if (filteredMembers.value.length === 0) return false;
    return filteredMembers.value.every(member => form.member_ids.includes(member.id));
});

const toggleSelectAll = () => {
    if (isAllSelected.value) {
        const displayedIds = filteredMembers.value.map(m => m.id);
        form.member_ids = form.member_ids.filter(id => !displayedIds.includes(id));
    } else {
        const displayedIds = filteredMembers.value.map(m => m.id);
        form.member_ids = [...new Set([...form.member_ids, ...displayedIds])];
    }
};

const toggleMember = (id) => {
    if (form.member_ids.includes(id)) {
        form.member_ids = form.member_ids.filter(memberId => memberId !== id);
    } else {
        form.member_ids.push(id);
    }
};

// === SUBMIT LOGIC (BERBEDA DENGAN ENROLL) ===
const submit = () => {
    if (form.member_ids.length === 0) {
        Swal.fire('Peringatan', 'Pilih setidaknya satu peserta untuk dihapus.', 'warning');
        return;
    }

    Swal.fire({
        title: 'Hapus Peserta?',
        text: `Apakah Anda yakin ingin menghapus ${form.member_ids.length} peserta ini dari event?`,
        icon: 'warning', // Icon warning karena destruktif
        showCancelButton: true,
        confirmButtonColor: '#d33', // Warna merah
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            // Post ke route unenroll
            form.post(`/admin/events/${props.event.id}/unenroll`, {
                onSuccess: () => {
                    Swal.fire('Berhasil', 'Peserta berhasil dihapus dari event.', 'success');
                    form.reset();
                    // Jika ingin auto uncheck / reset search:
                    form.member_ids = []; 
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
.text-navy { color: #003366; }
.text-primary { color: #003366 !important; }

/* Custom styles for Danger/Unenroll context */
.bg-danger-subtle-light { background-color: #fff5f5 !important; } 
.table-danger-custom { background-color: #fff5f5; }

/* Badge Colors Helpers */
.bg-success-subtle { background-color: #d1e7dd !important; }
.text-success-emphasis { color: #0f5132 !important; }
.bg-info-subtle { background-color: #cff4fc !important; }
.text-info-emphasis { color: #055160 !important; }
.bg-primary-subtle { background-color: #cfe2ff !important; }
.text-primary-emphasis { color: #0a58ca !important; }
.bg-danger-subtle { background-color: #f8d7da !important; }
.text-danger { color: #dc3545 !important; }

/* Table Style */
.table-centered th, .table-centered td { vertical-align: middle; }

/* Mobile Card Style */
.member-card { transition: all 0.2s; cursor: pointer; }
.member-card:active { transform: scale(0.98); }

/* Responsiveness Helpers */
@media (min-width: 768px) {
    .w-md-auto { width: auto !important; }
    .small-md { font-size: 1rem; }
}
@media (max-width: 767px) {
    .small-md { font-size: 0.9rem; }
    .badge-sm { font-size: 0.75rem; }
}
</style>