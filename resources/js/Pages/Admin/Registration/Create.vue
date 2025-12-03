<template>
    <Head title="Registrasi Peserta Baru" />

    <div class="container-fluid px-4 py-4">
        <div class="row justify-content-center">
            <div class="col-lg-10">

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h2 class="fs-3 fw-bold text-navy mb-0">Registrasi Peserta Baru</h2>
                        <p class="text-muted small mb-0">Isi formulir pendaftaran peserta baru.</p>
                    </div>
                    <Link href="/admin/registration" class="btn btn-outline-navy btn-sm shadow-sm">
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

                <form @submit.prevent="submit">
                    
                    <div class="card shadow-sm border-0 rounded-4 mb-4">
                        <div class="card-body p-4">
                            <h5 class="fw-bold text-navy mb-4 border-bottom pb-2">1. Informasi Data Diri Utama</h5>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="number" class="form-label fw-bold text-navy">Tahun/Nomor Registrasi</label>
                                    <input 
                                        type="text" 
                                        class="form-control input-tegas" 
                                        :class="{ 'is-invalid': form.errors.number }" 
                                        id="number" 
                                        v-model="form.number" 
                                        placeholder="Contoh: 2025/024"
                                    >
                                    <div v-if="form.errors.number" class="invalid-feedback">{{ form.errors.number }}</div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label fw-bold text-navy">Nama Lengkap Peserta</label>
                                    <input 
                                        type="text" 
                                        class="form-control input-tegas" 
                                        :class="{ 'is-invalid': form.errors.name }" 
                                        id="name" 
                                        v-model="form.name" 
                                        placeholder="Contoh: Budi Santoso"
                                    >
                                    <div v-if="form.errors.name" class="invalid-feedback">{{ form.errors.name }}</div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="gender" class="form-label fw-bold text-navy">Jenis Kelamin</label>
                                    <select 
                                        class="form-select input-tegas" 
                                        :class="{ 'is-invalid': form.errors.gender }" 
                                        id="gender" 
                                        v-model="form.gender"
                                    >
                                        <option value="" disabled>-- Pilih Jenis Kelamin --</option>
                                        <option value="Laki-laki">Laki-laki</option>
                                        <option value="Perempuan">Perempuan</option>
                                    </select>
                                    <div v-if="form.errors.gender" class="invalid-feedback">{{ form.errors.gender }}</div>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="kelompok" class="form-label fw-bold text-navy">Kelompok Katekese</label>
                                    <select 
                                        class="form-select input-tegas" 
                                        :class="{ 'is-invalid': form.errors.kelompok }" 
                                        id="kelompok" 
                                        v-model="form.kelompok"
                                    >
                                        <option value="" disabled>-- Pilih Kelompok Pelayanan --</option>
                                        <option value="Katekumen">Katekumen (Dewasa/Anak)</option>
                                        <option value="Sakramen Baptis Bayi">Sakramen Baptis Bayi</option>
                                    </select>
                                    <div v-if="form.errors.kelompok" class="invalid-feedback">{{ form.errors.kelompok }}</div>
                                    <div class="form-text text-muted small">Pilih jenis pelayanan yang akan diikuti peserta.</div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label fw-bold text-navy">Alamat Email</label>
                                    <input 
                                        type="email" 
                                        class="form-control input-tegas" 
                                        :class="{ 'is-invalid': form.errors.email }" 
                                        id="email" 
                                        v-model="form.email" 
                                        placeholder="nama@email.com"
                                    >
                                    <div v-if="form.errors.email" class="invalid-feedback">{{ form.errors.email }}</div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="contact" class="form-label fw-bold text-navy">No. Telepon / WhatsApp</label>
                                    <input 
                                        type="text" 
                                        class="form-control input-tegas" 
                                        :class="{ 'is-invalid': form.errors.contact }" 
                                        id="contact" 
                                        v-model="form.contact" 
                                        placeholder="08123xxxx"
                                    >
                                    <div v-if="form.errors.contact" class="invalid-feedback">{{ form.errors.contact }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div v-if="form.kelompok === 'Katekumen'" class="card shadow-sm border-0 rounded-4 mb-4 fade-in">
                        <div class="card-body p-4">
                            <h5 class="fw-bold text-navy mb-4 border-bottom pb-2">2. Data Tambahan Katekumen</h5>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="address" class="form-label fw-bold text-navy">Alamat Lengkap</label>
                                    <textarea 
                                        class="form-control input-tegas" 
                                        :class="{ 'is-invalid': form.errors.address }" 
                                        id="address" 
                                        v-model="form.address"
                                        placeholder="Alamat tempat tinggal saat ini"
                                    ></textarea>
                                    <div v-if="form.errors.address" class="invalid-feedback">{{ form.errors.address }}</div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="education" class="form-label fw-bold text-navy">Pendidikan Terakhir</label>
                                        <input 
                                            type="text" 
                                            class="form-control input-tegas" 
                                            :class="{ 'is-invalid': form.errors.education }" 
                                            id="education" 
                                            v-model="form.education"
                                            placeholder="Contoh: S1 Teknik"
                                        >
                                        <div v-if="form.errors.education" class="invalid-feedback">{{ form.errors.education }}</div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="namePenjamin" class="form-label fw-bold text-navy">Nama Penjamin</label>
                                        <input 
                                            type="text" 
                                            class="form-control input-tegas" 
                                            :class="{ 'is-invalid': form.errors.namePenjamin }" 
                                            id="namePenjamin" 
                                            v-model="form.namePenjamin"
                                            placeholder="Nama penjamin baptis/wali"
                                        >
                                        <div v-if="form.errors.namePenjamin" class="invalid-feedback">{{ form.errors.namePenjamin }}</div>
                                    </div>
                                </div>
                            </div>
                            
                            <h6 class="fw-bold text-navy mt-4 mb-3 border-bottom pb-1">2b. Riwayat Agama & Kegiatan</h6>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="religion" class="form-label fw-bold text-navy">Agama Awal Peserta</label>
                                    <input 
                                        type="text" 
                                        class="form-control input-tegas" 
                                        :class="{ 'is-invalid': form.errors.religion }" 
                                        v-model="form.religion" 
                                        id="religion" 
                                        placeholder="Contoh: Islam, Hindu, Buddha, Protestan"
                                    >
                                    <div v-if="form.errors.religion" class="invalid-feedback">{{ form.errors.religion }}</div>
                                </div>
                            </div>
                            
                            <div class="p-3 border rounded bg-white mt-3 fade-in">
                                <h6 class="fw-bold mb-3 text-secondary border-bottom pb-2">Detail Riwayat (Isi yang Relevan)</h6>
                                
                                <div class="row">
                                    <p class="text-muted small mb-3">Silakan isi bagian yang relevan dengan riwayat agama peserta saat ini (misalnya jika pernah dibaptis Kristen, isi detail Gereja Kristen).</p>
                                </div>
                                
                                <!-- Kelompok Detail Pelajaran Agama Katolik -->
                                <h6 class="fw-bold mt-3 mb-2 text-primary small">I. Riwayat Pelajaran Agama Katolik:</h6>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="location" class="form-label small fw-bold">Tempat Pelajaran (Opsional)</label>
                                        <input type="text" class="form-control input-tegas" v-model="form.location" id="location">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="schedule" class="form-label small fw-bold">Hari (Opsional)</label>
                                        <input type="text" class="form-control input-tegas" v-model="form.schedule" id="schedule">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="dateStart" class="form-label small fw-bold">Mulai ikut pelajaran Agama pada tanggal (Opsional)</label>
                                        <input type="date" class="form-control input-tegas" v-model="form.dateStart" id="dateStart">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="dateEnd" class="form-label small fw-bold">Sampai dengan tanggal (Opsional)</label>
                                        <input type="date" class="form-control input-tegas" v-model="form.dateEnd" id="dateEnd">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="participateBefore" class="form-label small fw-bold">Jika sebelumnya pernah mengikuti pelajaran agama di (Opsional)</label>
                                        <input type="text" class="form-control input-tegas" v-model="form.participateBefore" id="participateBefore">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="nameGuru" class="form-label small fw-bold">Guru yang mengajar (Opsional)</label>
                                        <input type="text" class="form-control input-tegas" v-model="form.nameGuru" id="nameGuru">
                                    </div>
                                </div>

                                <!-- Kelompok Detail Sakramen Baptis Kristen -->
                                <h6 class="fw-bold mt-4 mb-2 text-primary small border-top pt-2">II. Riwayat Baptis Kristen:</h6>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="nameGereja" class="form-label small fw-bold">Nama Gereja (Opsional)</label>
                                        <input type="text" class="form-control input-tegas" v-model="form.nameGereja" id="nameGereja">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="addressGereja" class="form-label small fw-bold">Alamat/Kota Gereja (Opsional)</label>
                                        <input type="text" class="form-control input-tegas" v-model="form.addressGereja" id="addressGereja">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="namePriest" class="form-label small fw-bold">Pendeta/Pastor yang Membaptis (Opsional)</label>
                                        <input type="text" class="form-control input-tegas" v-model="form.namePriest" id="namePriest">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="dateBaptis" class="form-label small fw-bold">Tanggal Baptis (Opsional)</label>
                                        <input type="date" class="form-control input-tegas" v-model="form.dateBaptis" id="dateBaptis">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="numberBaptis" class="form-label small fw-bold">Nomor Surat Baptis (Opsional)</label>
                                        <input type="text" class="form-control input-tegas" v-model="form.numberBaptis" id="numberBaptis">
                                    </div>
                                </div>

                            </div>
                            
                            <h6 class="fw-bold text-navy mt-4 mb-3 border-bottom pb-1">2c. Status Pernikahan</h6>
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="statusMarried" class="form-label fw-bold text-navy">Status Nikah</label>
                                    <select 
                                        class="form-select input-tegas" 
                                        :class="{ 'is-invalid': form.errors.statusMarried }" 
                                        id="statusMarried" 
                                        v-model="form.statusMarried"
                                    >
                                        <option value="" disabled>-- Pilih Status Nikah --</option>
                                        <option value="Belum Menikah">Belum Menikah</option>
                                        <option value="Menikah Katolik">Menikah Katolik</option>
                                        <option value="Menikah Kristen">Menikah Kristen</option>
                                        <option value="Menikah Sipil">Menikah Sipil</option>
                                        <option value="Menikah Lain">Menikah Lain (Adat, Hindu, Budha, dll.)</option>
                                        <option value="Pernah Menikah">Pernah Menikah (Janda/Duda)</option>
                                    </select>
                                    <div v-if="form.errors.statusMarried" class="invalid-feedback">{{ form.errors.statusMarried }}</div>
                                </div>
                            </div>
                            
                            <!-- Detail Pernikahan (Tampil jika sudah menikah) -->
                            <div v-if="form.statusMarried && form.statusMarried !== 'Belum Menikah' && form.statusMarried !== 'Pernah Menikah'" 
                                class="p-3 border rounded bg-white mt-3 fade-in">
                                <h6 class="fw-bold mb-3 text-secondary">Data Pasangan</h6>
                                <div class="row">
                                    <div :class="{'col-md-12': form.statusMarried === 'Menikah Sipil', 'col-md-6': form.statusMarried !== 'Menikah Sipil'}" class="mb-3">
                                        <label for="namePasangan" class="form-label small fw-bold">Nama Pasangan</label>
                                        <input type="text" class="form-control input-tegas" v-model="form.namePasangan" :class="{ 'is-invalid': form.errors.namePasangan }" id="namePasangan">
                                        <div v-if="form.errors.namePasangan" class="invalid-feedback">{{ form.errors.namePasangan }}</div>
                                    </div>
                                    <div class="col-md-6 mb-3" v-if="form.statusMarried !== 'Menikah Sipil'">
                                        <label for="religionPasangan" class="form-label small fw-bold">Agama Pasangan</label>
                                        <input 
                                            type="text" 
                                            class="form-control input-tegas" 
                                            v-model="form.religionPasangan" 
                                            :class="{ 'is-invalid': form.errors.religionPasangan }" 
                                            id="religionPasangan"
                                            :readonly="form.statusMarried === 'Menikah Katolik' || form.statusMarried === 'Menikah Kristen'" 
                                        >
                                        <div v-if="form.errors.religionPasangan" class="invalid-feedback">{{ form.errors.religionPasangan }}</div>
                                    </div>
                                </div>
                                
                                <!-- Detail Pernikahan Katolik -->
                                <div v-if="form.statusMarried === 'Menikah Katolik'" class="mt-3 fade-in">
                                    <h6 class="fw-bold mt-3 mb-3 text-secondary border-bottom pb-2">Detail Pernikahan Katolik</h6>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="placeMarried1" class="form-label small fw-bold">Secara Katolik di Gereja</label>
                                            <input type="text" class="form-control input-tegas" v-model="form.placeMarried1" id="placeMarried1" :class="{ 'is-invalid': form.errors.placeMarried1 }">
                                            <div v-if="form.errors.placeMarried1" class="invalid-feedback">{{ form.errors.placeMarried1 }}</div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="cityMarried1" class="form-label small fw-bold">Kota (Opsional)</label>
                                            <input type="text" class="form-control input-tegas" v-model="form.cityMarried1" id="cityMarried1">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="dateMarried1" class="form-label small fw-bold">Tanggal (Opsional)</label>
                                            <input type="date" class="form-control input-tegas" v-model="form.dateMarried1" id="dateMarried1">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="namePeneguh1" class="form-label small fw-bold">Peneguh Nikah (Opsional)</label>
                                            <input type="text" class="form-control input-tegas" v-model="form.namePeneguh1" id="namePeneguh1">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="numberMarried1" class="form-label small fw-bold">No. Surat Nikah (Opsional)</label>
                                            <input type="text" class="form-control input-tegas" v-model="form.numberMarried1" id="numberMarried1">
                                        </div>
                                    </div>
                                </div>

                                <!-- Detail Pernikahan Kristen -->
                                <div v-else-if="form.statusMarried === 'Menikah Kristen'" class="mt-3 fade-in">
                                    <h6 class="fw-bold mt-3 mb-3 text-secondary border-bottom pb-2">Detail Pernikahan Kristen</h6>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="placeMarried2" class="form-label small fw-bold">Secara Kristen di Gereja/Tempat Lain</label>
                                            <input type="text" class="form-control input-tegas" v-model="form.placeMarried2" id="placeMarried2" :class="{ 'is-invalid': form.errors.placeMarried2 }">
                                            <div v-if="form.errors.placeMarried2" class="invalid-feedback">{{ form.errors.placeMarried2 }}</div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="cityMarried2" class="form-label small fw-bold">Kota (Opsional)</label>
                                            <input type="text" class="form-control input-tegas" v-model="form.cityMarried2" id="cityMarried2">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="dateMarried2" class="form-label small fw-bold">Tanggal (Opsional)</label>
                                            <input type="date" class="form-control input-tegas" v-model="form.dateMarried2" id="dateMarried2">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="namePeneguh2" class="form-label small fw-bold">Pendeta/Peneguh Nikah (Opsional)</label>
                                            <input type="text" class="form-control input-tegas" v-model="form.namePeneguh2" id="namePeneguh2">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="numberMarried2" class="form-label small fw-bold">No. Surat Nikah (Opsional)</label>
                                            <input type="text" class="form-control input-tegas" v-model="form.numberMarried2" id="numberMarried2">
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Detail Pernikahan Sipil -->
                                <div v-else-if="form.statusMarried === 'Menikah Sipil'" class="mt-3 fade-in">
                                    <h6 class="fw-bold mt-3 mb-3 text-secondary border-bottom pb-2">Detail Pernikahan Sipil</h6>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="cityMarried3" class="form-label small fw-bold">Secara Sipil di Kota</label>
                                            <input type="text" class="form-control input-tegas" v-model="form.cityMarried3" id="cityMarried3" :class="{ 'is-invalid': form.errors.cityMarried3 }">
                                            <div v-if="form.errors.cityMarried3" class="invalid-feedback">{{ form.errors.cityMarried3 }}</div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="dateMarried3" class="form-label small fw-bold">Tanggal</label>
                                            <input type="date" class="form-control input-tegas" v-model="form.dateMarried3" id="dateMarried3" :class="{ 'is-invalid': form.errors.dateMarried3 }">
                                            <div v-if="form.errors.dateMarried3" class="invalid-feedback">{{ form.errors.dateMarried3 }}</div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="numberMarried3" class="form-label small fw-bold">No. Surat Nikah</label>
                                            <input type="text" class="form-control input-tegas" v-model="form.numberMarried3" id="numberMarried3" :class="{ 'is-invalid': form.errors.numberMarried3 }">
                                            <div v-if="form.errors.numberMarried3" class="invalid-feedback">{{ form.errors.numberMarried3 }}</div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Detail Pernikahan Lain -->
                                <div v-else-if="form.statusMarried === 'Menikah Lain'" class="mt-3 fade-in">
                                    <h6 class="fw-bold mt-3 mb-3 text-secondary border-bottom pb-2">Detail Pernikahan Lain (Adat, Hindu, Budha, dll.)</h6>
                                    <p class="small text-muted mb-3">Harap isi Agama Pasangan secara manual di atas.</p>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="placeMarried4" class="form-label small fw-bold">Tempat</label>
                                            <input type="text" class="form-control input-tegas" v-model="form.placeMarried4" id="placeMarried4" :class="{ 'is-invalid': form.errors.placeMarried4 }">
                                            <div v-if="form.errors.placeMarried4" class="invalid-feedback">{{ form.errors.placeMarried4 }}</div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="cityMarried4" class="form-label small fw-bold">Kota (Opsional)</label>
                                            <input type="text" class="form-control input-tegas" v-model="form.cityMarried4" id="cityMarried4">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="dateMarried4" class="form-label small fw-bold">Tanggal (Opsional)</label>
                                            <input type="date" class="form-control input-tegas" v-model="form.dateMarried4" id="dateMarried4">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="namePeneguh4" class="form-label small fw-bold">Peneguh Nikah (Opsional)</label>
                                            <input type="text" class="form-control input-tegas" v-model="form.namePeneguh4" id="namePeneguh4">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="numberMarried4" class="form-label small fw-bold">No. Surat Nikah (Opsional)</label>
                                            <input type="text" class="form-control input-tegas" v-model="form.numberMarried4" id="numberMarried4">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Detail Pernah Menikah -->
                            <div v-else-if="form.statusMarried === 'Pernah Menikah'" class="p-3 border rounded bg-white mt-3 fade-in">
                                <h6 class="fw-bold mt-3 mb-3 text-secondary border-bottom pb-2">Detail Pernah Menikah (Janda/Duda)</h6>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="nameMantan" class="form-label small fw-bold">Pernah Menikah Dengan</label>
                                        <input type="text" class="form-control input-tegas" v-model="form.nameMantan" id="nameMantan" :class="{ 'is-invalid': form.errors.nameMantan }">
                                        <div v-if="form.errors.nameMantan" class="invalid-feedback">{{ form.errors.nameMantan }}</div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="cityMantan" class="form-label small fw-bold">Kota Pernikahan (Opsional)</label>
                                        <input type="text" class="form-control input-tegas" v-model="form.cityMantan" id="cityMantan">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="statusMantan" class="form-label small fw-bold">Status Hubungan Berakhir</label>
                                        <select 
                                            class="form-select input-tegas" 
                                            v-model="form.statusMantan"
                                            id="statusMantan" 
                                            :class="{ 'is-invalid': form.errors.statusMantan }"
                                        >
                                            <option value="" disabled>-- Pilih Status --</option>
                                            <option value="Cerai">Cerai</option>
                                            <option value="Meninggal">Meninggal</option>
                                        </select>
                                        <div v-if="form.errors.statusMantan" class="invalid-feedback">{{ form.errors.statusMantan }}</div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="yearMantan" class="form-label small fw-bold">Tahun Berakhir</label>
                                        <input type="text" class="form-control input-tegas" v-model="form.yearMantan" id="yearMantan" placeholder="Contoh: 2020" :class="{ 'is-invalid': form.errors.yearMantan }">
                                        <div v-if="form.errors.yearMantan" class="invalid-feedback">{{ form.errors.yearMantan }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div v-else-if="form.kelompok === 'Sakramen Baptis Bayi'" class="card shadow-sm border-0 rounded-4 mb-4 fade-in">
                        <div class="card-body p-4">
                            <h5 class="fw-bold text-navy mb-4 border-bottom pb-2">2. Data Sakramen Baptis Bayi</h5>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="nameWali" class="form-label fw-bold text-navy">Nama Wali Baptis</label>
                                    <input 
                                        type="text" 
                                        class="form-control input-tegas" 
                                        :class="{ 'is-invalid': form.errors.nameWali }" 
                                        id="nameWali" 
                                        v-model="form.nameWali"
                                        placeholder="Nama salah satu orang tua/wali"
                                    >
                                    <div v-if="form.errors.nameWali" class="invalid-feedback">{{ form.errors.nameWali }}</div>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="status" class="form-label fw-bold text-navy">Status Wali Baptis</label>
                                    <select 
                                        class="form-select input-tegas" 
                                        :class="{ 'is-invalid': form.errors.status }" 
                                        id="status" 
                                        v-model="form.status"
                                    >
                                        <option value="" disabled>-- Pilih Status Wali Baptis --</option>
                                        <option value="Bapak Baptis">Bapak Baptis</option>
                                        <option value="Ibu Baptis">Ibu Baptis</option>
                                    </select>
                                    <div v-if="form.errors.status" class="invalid-feedback">{{ form.errors.status }}</div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="namePastoor" class="form-label fw-bold text-navy">Nama Pastoor</label>
                                    <input 
                                        type="text" 
                                        class="form-control input-tegas" 
                                        :class="{ 'is-invalid': form.errors.namePastoor }" 
                                        id="namePastoor" 
                                        v-model="form.namePastoor"
                                        placeholder="Nama pastoor yang bertugas"
                                    >
                                    <div v-if="form.errors.namePastoor" class="invalid-feedback">{{ form.errors.namePastoor }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div v-if="form.kelompok" class="card shadow-sm border-0 rounded-4 mb-4 fade-in">
                        <div class="card-body p-4">
                            <h5 class="fw-bold text-navy mb-4 border-bottom pb-2">3. Data Anggota Keluarga (Ayah, Ibu, dll.)</h5>
                            
                            <p v-if="form.family_members.length === 0" class="text-muted text-center small">
                                Belum ada anggota keluarga ditambahkan. Anggota keluarga wajib diisi.
                            </p>

                            <div v-for="(member, index) in form.family_members" :key="index" class="p-3 border rounded mb-3 bg-light">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="fw-bold text-dark">Anggota #{{ index + 1 }}</span>
                                    <button type="button" @click="removeFamilyMember(index)" class="btn btn-sm btn-danger">
                                        <i class="bi bi-x-lg"></i> Hapus
                                    </button>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label :for="`fam_name_${index}`" class="form-label small fw-bold">Nama</label>
                                        <input type="text" class="form-control input-tegas" v-model="member.name" :class="{ 'is-invalid': form.errors[`family_members.${index}.name`] }" :id="`fam_name_${index}`">
                                        <div v-if="form.errors[`family_members.${index}.name`]" class="invalid-feedback">{{ form.errors[`family_members.${index}.name`] }}</div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label :for="`fam_rel_${index}`" class="form-label small fw-bold">Hubungan</label>
                                        <input type="text" class="form-control input-tegas" v-model="member.relation" :class="{ 'is-invalid': form.errors[`family_members.${index}.relation`] }" :id="`fam_rel_${index}`">
                                        <div v-if="form.errors[`family_members.${index}.relation`]" class="invalid-feedback">{{ form.errors[`family_members.${index}.relation`] }}</div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label :for="`fam_relig_${index}`" class="form-label small fw-bold">Agama</label>
                                        <input type="text" class="form-control input-tegas" v-model="member.religion" :class="{ 'is-invalid': form.errors[`family_members.${index}.religion`] }" :id="`fam_relig_${index}`">
                                        <div v-if="form.errors[`family_members.${index}.religion`]" class="invalid-feedback">{{ form.errors[`family_members.${index}.religion`] }}</div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label :for="`fam_contact_${index}`" class="form-label small fw-bold">Kontak</label>
                                        <input type="text" class="form-control input-tegas" v-model="member.contact" :class="{ 'is-invalid': form.errors[`family_members.${index}.contact`] }" :id="`fam_contact_${index}`">
                                        <div v-if="form.errors[`family_members.${index}.contact`]" class="invalid-feedback">{{ form.errors[`family_members.${index}.contact`] }}</div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 mb-3">
                                        <label :for="`fam_addr_${index}`" class="form-label small fw-bold">Alamat</label>
                                        <textarea class="form-control input-tegas" v-model="member.address" :class="{ 'is-invalid': form.errors[`family_members.${index}.address`] }" :id="`fam_addr_${index}`"></textarea>
                                        <div v-if="form.errors[`family_members.${index}.address`]" class="invalid-feedback">{{ form.errors[`family_members.${index}.address`] }}</div>
                                    </div>
                                </div>

                            </div>

                            <button type="button" @click="addFamilyMember" class="btn btn-sm btn-outline-success mt-2">
                                <i class="bi bi-plus-circle me-1"></i> Tambah Anggota Keluarga
                            </button>
                            <div v-if="form.errors.family_members" class="text-danger small mt-2">{{ form.errors.family_members }}</div>
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                        <button type="button" @click="form.reset()" class="btn btn-link text-danger text-decoration-none px-0">
                            <i class="bi bi-arrow-counterclockwise me-1"></i> Reset Form
                        </button>

                        <div class="d-flex gap-2">
                            <Link href="/admin/registration" class="btn btn-light border">Batal</Link>
                            <button type="submit" class="btn btn-navy px-4 shadow-sm" :disabled="form.processing">
                            <span v-if="form.processing">
                                            <span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>
                                            Menyimpan...
                                        </span>
                                <span v-else>
                                    <i class="bi bi-save me-1"></i> Simpan Data
                                </span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script setup>
import { Head, Link, useForm } from '@inertiajs/inertia-vue3'
import { watch } from 'vue'
import Swal from 'sweetalert2'

// Daftar lengkap field yang dibutuhkan oleh semua Model
const form = useForm({
    // Basic Info (Registration & Member)
    number: '',
    name: '',
    gender: '',    
    email: '',
    contact: '',    
    kelompok: '', 
    
    // Data Katekumen (DataKatekumen)
    address: '',
    education: '',
    namePenjamin: '',

    // Data Riwayat (DataRiwayat)
    // historyType dihapus
    religion: '', // Agama awal (Kini input manual)
    location: '', // Tempat
    schedule: '', // Hari
    dateStart: '', // Mulai ikut pelajaran Agama pada tanggal
    dateEnd: '', // sampai dengan tanggal
    participateBefore: '', // Jika sebelumnya pernah mengikuti pelajaran agama di
    nameGuru: '', // Guru yang mengajar
    nameGereja: '', // Nama Gereja
    addressGereja: '', // di
    namePriest: '', // Dibaptis oleh
    dateBaptis: '', // Tanggal Baptis
    numberBaptis: '', // Nomor Surat Baptis
    
    // Data Menikah (DataMenikah)
    statusMarried: '',
    namePasangan: '', 
    religionPasangan: '',
    // Detail Katolik
    placeMarried1: '', cityMarried1: '', dateMarried1: '', namePeneguh1: '', numberMarried1: '', 
    // Detail Kristen
    placeMarried2: '', cityMarried2: '', dateMarried2: '', namePeneguh2: '', numberMarried2: '', 
    // Detail Sipil
    cityMarried3: '', dateMarried3: '', numberMarried3: '', 
    // Detail Lain
    placeMarried4: '', cityMarried4: '', dateMarried4: '', namePeneguh4: '', numberMarried4: '', 
    // Detail Pernah Menikah (Janda/Duda)
    nameMantan: '', cityMantan: '', statusMantan: '', yearMantan: '',

    // Data Baptis Bayi (DataBaptis)
    namePastoor: '',
    status: '',
    nameWali: '',

    // Data Keluarga (Dynamic Array - Wajib di kedua kelompok)
    family_members: [
        { name: '', relation: '', religion: '', address: '', contact: '' }
    ],
})

// === WATCHER LAMA UNTUK RIWAYAT AGAMA DIHAPUS

// === WATCHER UNTUK STATUS PERNIKAHAN (Tidak ada perubahan) ===
watch(() => form.statusMarried, (newStatus) => {
    // 1. Clear conditional fields on status change
    
    // Clear Catholic marriage details
    if (newStatus !== 'Menikah Katolik') {
        form.placeMarried1 = ''; form.cityMarried1 = ''; form.dateMarried1 = '';
        form.namePeneguh1 = ''; form.numberMarried1 = '';
    }
    
    // Clear Kristen marriage details
    if (newStatus !== 'Menikah Kristen') {
        form.placeMarried2 = ''; form.cityMarried2 = ''; form.dateMarried2 = '';
        form.namePeneguh2 = ''; form.numberMarried2 = '';
    }

    // Clear Civil marriage details
    if (newStatus !== 'Menikah Sipil') { 
        form.cityMarried3 = ''; form.dateMarried3 = ''; form.numberMarried3 = '';
    }

    // Clear Lain marriage details
    if (newStatus !== 'Menikah Lain') { 
        form.placeMarried4 = ''; form.cityMarried4 = ''; form.dateMarried4 = '';
        form.namePeneguh4 = ''; form.numberMarried4 = '';
    }
    
    // Clear Pernah Menikah details
    if (newStatus !== 'Pernah Menikah') {
        form.nameMantan = ''; 
        form.cityMantan = ''; 
        form.statusMantan = ''; 
        form.yearMantan = '';
    }

    // Clear spouse name/religion if status is irrelevant
    if (newStatus === 'Belum Menikah' || newStatus === 'Pernah Menikah' || newStatus === '') {
        form.religionPasangan = '';
        form.namePasangan = '';
    }

    // 2. Auto-fill religionPasangan and control readability
    if (newStatus === 'Menikah Katolik') {
        form.religionPasangan = 'Katolik';
    } else if (newStatus === 'Menikah Kristen') {
        form.religionPasangan = 'Kristen';
    } else if (newStatus === 'Menikah Sipil' || newStatus === 'Menikah Lain') { 
        form.religionPasangan = ''; 
    } else if (newStatus !== 'Belum Menikah' && newStatus !== 'Pernah Menikah') {
        form.religionPasangan = '';
    }
});


// Fungsi untuk menambahkan anggota keluarga baru
const addFamilyMember = () => {
    form.family_members.push({ name: '', relation: '', religion: '', address: '', contact: '' });
}

// Fungsi untuk menghapus anggota keluarga
const removeFamilyMember = (index) => {
    form.family_members.splice(index, 1);
    // Hapus error validation terkait item yang dihapus
    Object.keys(form.errors).forEach(key => {
        if (key.startsWith(`family_members.${index}`)) {
            delete form.errors[key];
        }
    });
}

const submit = () => {
    form.post('/admin/registration', {
        onSuccess: () => {
            Swal.fire({
                title: 'Berhasil!',
                text: 'Data peserta baru berhasil disimpan.',
                icon: 'success',
                confirmButtonColor: '#003366',
                confirmButtonText: 'OK'
            });
        },
        onError: () => {
             Swal.fire({
                title: 'Gagal Validasi!',
                text: 'Mohon periksa kembali isian formulir Anda.',
                icon: 'error',
                confirmButtonColor: '#003366',
                confirmButtonText: 'OK'
            });
        }
    });
}
</script>

<script>
import LayoutAdmin from '../../../Layouts/Admin.vue';
export default { 
    layout: LayoutAdmin 
};
</script>

<style scoped>
/* --- ANIMASI & UX --- */
.fade-in { animation: fadeIn 0.5s ease-in-out; }
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

/* --- Theme Variables & Styles --- */
:root {
    --navy-primary: #003366;
    --navy-hover: #002244;
}

.text-navy { color: #003366; }
.bg-navy { background-color: #003366; }

/* --- Input Style (Tegas & Rapi) --- */
.input-tegas {
    border: 1px solid #b0b8c4;
    border-radius: 8px;    
    padding: 0.7rem 1rem;  
    font-size: 0.95rem;
    background-color: #fcfcfc;
    transition: all 0.3s ease;
}

.input-tegas:hover {
    border-color: #859bb3;
    background-color: #ffffff;
}

.input-tegas:focus {
    border-color: #003366;  
    box-shadow: 0 0 0 4px rgba(0, 51, 102, 0.1); 
    background-color: #ffffff;
    outline: none;
}

select.input-tegas {
    cursor: pointer;
}

/* Button Custom Navy */
.btn-navy {
    background-color: #003366;
    color: white;
    border: none;
    border-radius: 8px;
    padding: 0.6rem 1.2rem;
    font-weight: 500;
    transition: all 0.2s ease;
}
.btn-navy:hover {
    background-color: #002244;
    color: #ffffff;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0, 51, 102, 0.25);
}

/* Button Outline Navy */
.btn-outline-navy {
    color: #003366;
    border-color: #003366;
    background-color: transparent;
    border-radius: 6px;
}
.btn-outline-navy:hover {
    color: white;
    background-color: #003366;
}

/* Utils */
.card { border-radius: 16px; }
.bg-danger-subtle { background-color: #f8d7da; }
.text-danger-emphasis { color: #842029; }
</style>