<template>
  <div class="row">
    <div class="col-lg-6">
      <div class="card shadow-sm">
        <div class="card-header d-flex align-items-center">
          <a
            href=""
            class="btn btn-primary btn-sm mr-2"
            @click.prevent="$router.go(-1)"
          >
            <i class="fa fa-arrow-left" aria-hidden="true"></i>
          </a>
          <div class="card-title font-weight-bold m-0">
            Tambah data buku
          </div>
        </div>
        <div class="card-body">
          <form
            class="form"
            id="form_tambah_data_buku"
            action="#"
            @submit.prevent="tambahBuku()"
            enctype="multipart/form-data"
          >
            <div class="form-group d-flex">
              <label class="align-self-center m-0 w-25" for="judul_buku"
                >Judul buku
              </label>
              <div class="w-75">
                <input
                  type="text"
                  class="form-control"
                  id="judul_buku"
                  v-model="judul_buku"
                  autocomplete="off"
                  required
                />
              </div>
            </div>
            <div class="form-group d-flex">
              <label class="align-self-center m-0 w-25" for="pengarang"
                >Pengarang
              </label>
              <div class="w-75">
                <input
                  type="text"
                  class="form-control"
                  id="pengarang"
                  v-model="pengarang"
                  autocomplete="off"
                  required
                />
              </div>
            </div>
            <div class="form-group d-flex">
              <label class="align-self-center m-0 w-25" for="tahun_terbit"
                >Tahun terbit
              </label>
              <div class="w-75">
                <input
                  type="text"
                  class="form-control"
                  id="tahun_terbit"
                  v-model="tahun_terbit"
                  autocomplete="off"
                  required
                />
              </div>
            </div>
            <div class="form-group d-flex">
              <label class="align-self-center m-0 w-25" for="penerbit"
                >Penerbit
              </label>
              <div class="w-75">
                <input
                  type="text"
                  class="form-control"
                  id="penerbit"
                  v-model="penerbit"
                  autocomplete="off"
                  required
                />
              </div>
            </div>
            <div class="form-group d-flex">
              <label class="align-self-center m-0 w-25" for="jenis_buku"
                >Jenis buku
              </label>
              <div class="w-75">
                <input
                  type="text"
                  class="form-control"
                  id="jenis_buku"
                  v-model="jenis_buku"
                  autocomplete="off"
                  required
                />
              </div>
            </div>
            <div class="form-group d-flex">
              <label class="align-self-center m-0 w-25" for="code_buku"
                >Lokasi rak
              </label>
              <div class="w-75">
                <input
                  type="text"
                  class="form-control"
                  id="code_buku"
                  v-model="lokasi_rak"
                  autocomplete="off"
                  required
                />
              </div>
            </div>
            <div class="form-group d-flex">
              <label class="align-self-center m-0 w-25" for="uploadGambar"
                >Gambar
              </label>
              <div class="w-75 custom-file">
                <input
                  type="file"
                  id="uploadGambar"
                  @change="uploadGambar($event)"
                  class="form-control-file custom-file-input"
                />
                <label
                  class="custom-file-label overflow-hidden"
                  for="code_buku"
                  >{{ namaGambar }}</label
                >
              </div>
            </div>
            <div class="form-group d-flex">
              <div class="w-25"></div>
              <div class="w-25">
                <button type="submit" class="btn btn-primary btn-sm btn-block">
                  Tambah
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import { searchMixin } from "./../mixins/searchMixin.js";
export default {
  mixins: [searchMixin],
  data() {
    return {
      judul_buku: "",
      pengarang: "",
      tahun_terbit: "",
      penerbit: "",
      jenis_buku: "",
      lokasi_rak: "",
      gambarBuku: {},
      namaGambar: "Choose File"
    };
  },

  methods: {
    uploadGambar(event) {
      this.gambarBuku = event.target.files[0];
      this.namaGambar = this.gambarBuku.name;
    },

    tambahBuku() {
      let formData = new FormData();
      formData.append("judul_buku", this.judul_buku);
      formData.append("pengarang", this.pengarang);
      formData.append("tahun_terbit", this.tahun_terbit);
      formData.append("penerbit", this.penerbit);
      formData.append("jenis_buku", this.jenis_buku);
      formData.append("lokasi_rak", this.lokasi_rak);
      formData.append("image", this.gambarBuku);
      axios
        .post("api/data", formData, {
          headers: {
            "Content-Type": "multipart/form-data"
          }
        })
        .then(response => {
          this.$router.push({
            name: "buku"
          });
        })
        .then(response => {
          this.$swal({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 3000,
            type: "success",
            title: "Berhasil!",
            text: "Data telah ditambahkan"
          });
        });
    }
  }
};
</script>
