<template>

    <Head>
        <title>Profile Anggota</title>
    </Head>
    <form @submit.prevent="submit" class="getin_form border-form padding" id="data">
        <section id="profile" class="container mt-4">
            <div class="container-fluid px-5">
                <div class="row d-flex justify-content-center">
                    <!-- First group of columns -->
                    <div class="col-sm-12 card shadow">
                        <div class="row">
                            <h3 class="text-center mt-4 text-black">
                                Update Profile Anggota
                            </h3>
                        </div>



                        <div class="container py-4">
                            <div class="row">
                                <div class="col-lg-2 col-md-2">
                                    <div class="text-center">
                                        
                                    </div>
                                </div>

                                <div class="col-lg-1">

                                </div>

                                <div class="col-lg-9">
                                   

                                    <div class="row mt-2">
                                        <div class="col-lg-3 ms-5 py-2">
                                            <span> Nama </span>
                                        </div>

                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" v-model="form.name" />
                                            <div v-if="errors.name" class="rounded alert-danger mt-1">
                                                {{ errors.name }}
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- Data Pribadei-->
                    <div class="col-sm-12 card shadow mt-4">
                        <div class="py-4">
                            <span> Data Ortu </span>
                        </div>

                        <div class="row ms-2 mb-3">
                            
                        </div>

                       
                    </div>

                    <div class="col-sm-12 card shadow mt-4">
                        <div class="py-4">
                            <span> Data Riwayat </span>
                        </div>

                        <div class="row ms-2 mb-3">
                            
                        </div>
                    </div>

                    

                    <div class="row d-flex justify-content-center py-5">
                        <button type="submit" class="button btnprimary" style="width: 300px;">Simpan</button>
                        <a href="/admin/members" class="button btnsecondary" style="width: 300px;">Batal</a>
                    </div>
                </div>
            </div>
        </section>
    </form>
</template>

<script>
//import layout
import LayoutAdmin from '../../../Layouts/Admin.vue';

//import Head from Inertia
import { Head, Link } from "@inertiajs/inertia-vue3";

//import reactive
import { reactive } from "vue";

//import sweet alert2
import Swal from "sweetalert2";

//import inertia adapter
import { Inertia } from "@inertiajs/inertia";

export default {

   

    // computed property to filter instansis based on search input
    computed: {
        filteredInstansis() {
            return this.instansis.filter(instansi =>
                instansi.title.toLowerCase().includes(this.searchInstansi.toLowerCase())
            );
        },
    },


    methods: {
        // // method to toggle dropdown visibility
        toggleSearch() {
            this.showDropdown = !this.showDropdown;
            if (this.showDropdown) {
                // Menambahkan event listener ke elemen body
                document.body.addEventListener('click', this.closeDropdownOutside);
            } else {
                // Menghapus event listener dari elemen body
                document.body.removeEventListener('click', this.closeDropdownOutside);
            }
        },

        // // method to close dropdown when clicked outside
        closeDropdownOutside(event) {
            if (!this.$refs.dropdownWrapper.contains(event.target)) {
                this.showDropdown = false;
                document.body.removeEventListener('click', this.closeDropdownOutside);
            }
        },

        // // method to select an instansi from dropdown
        selectInstansi(instansi) {
            this.form.agency = instansi.title;
            this.searchInstansi = ''; // reset search input after selection
            this.showDropdown = false; // hide dropdown after selection
        },

        openFileInput() {
            this.$refs.fileInput.click();
        },
        updateImage(event) {
            this.form.image = event.target.files[0];
        },
    },

    //layout
    layout: LayoutAdmin,

    //register component
    components: {
        Head,
        Link,
    },

    //props
    props: {
        errors: Object,
        session: Object,
        data: Object,
        instansis: Array,
        provinces: Array,
        cities: Array,
    },

    //define composition API
    setup(props) {


        //define form state
        const form = reactive({
            nip: props.data.main.nip,
            name: props.data.main.name,
            email: props.data.main.email,
            contact: props.data.main.contact,
            fname: props.data.main.fname,
            lname: props.data.main.lname,
            leveledu: props.data.main.leveledu,
            lastedu: props.data.main.lastedu,
            place: props.data.main.place,
            dob: props.data.main.dob,
            docid: props.data.main.docid,
            nodocid: props.data.main.nodocid,
            gender: props.data.main.gender,
            religion: props.data.main.religion,
            agency: props.data.agency,
            image: props.data.main.image,

            level: props.data.level,
            type: props.data.type,
            status: props.data.status,
            agency: props.data.agency,
            unit: props.data.unit,
            subunit: props.data.subunit,
            location: props.data.location,
            position: props.data.position,
            tmtpos: props.data.tmtpos,
            golru: props.data.golru,
            tmtgolru: props.data.tmtgolru,
            wyear: props.data.wyear,
            wmonth: props.data.wmonth,
        });

        //submit method
        const submit = () => {
            //send data to server
            Inertia.put(`/admin/members/${props.data.id}`,
                {
                    //data
                    nip: form.nip,
                    // name: form.name,
                    // fname: form.fname,
                    // lname: form.lname,
                    // leveledu: form.leveledu,
                    // lastedu: form.lastedu,
                    // place: form.place,
                    // dob: form.dob,
                    // docid: form.docid,
                    // nodocid: form.nodocid,
                    // email: form.email,
                    // contact: form.contact,
                    // gender: form.gender,
                    // religion: form.religion,

                    // level: form.level,
                    // type: form.type,
                    // status: form.status,
                    // agency: form.agency,
                    // unit: form.unit,
                    // subunit: form.subunit,
                    // location: form.location,
                    // position: form.position,
                    // tmtpos: form.tmtpos,
                    // golru: form.golru,
                    // tmtgolru: form.tmtgolru,
                    // wyear: form.wyear,
                    // wmonth: form.wmonth,

                },
                {
                    onSuccess: () => {
                        //show success alert
                        Swal.fire({
                            title: "Success!",
                            text: "Data Anggota Berhasil Diupdate.",
                            icon: "success",
                            showConfirmButton: false,
                            timer: 2000,
                        });
                    },
                }
            );
        };


        //send data to server


        // Method to get the URL of the document
        const getImageUrl = (imageName) => {
            return imageName ? `/storage/${imageName}` : "/assets/images/team-grey-1.jpg";
        }

        const updateImage = (event) => {
            // Buat objek FormData
            const formData = new FormData();
            // Tambahkan file gambar yang dipilih ke FormData
            formData.append('image', event.target.files[0]);
            // Kirim permintaan dengan Inertia
            Inertia.post(`/user/profile/image`, formData);
        };


        //return form state and submit method
        return {
            form,
            submit,
            getImageUrl,
            updateImage,

        };
    },
};
</script>
<style>
.dropdown-select {
    max-height: 200px;
    /* Tentukan tinggi maksimal dropdown */
    overflow-y: auto;
    /* Aktifkan pengguliran vertikal jika item melebihi tinggi maksimal */
}
</style>
