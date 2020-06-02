<template>
  <div class="modal__data">
    <!-- Modal -->
    <div id="tambah_data" class="modal" role="dialog">
      <div class="modal-dialog modal-dialog-centered">
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header border-0">
            <div class="modal-title font-weight-bolder">Tambah data buku</div>
            <button
              type="button"
              class="close"
              data-dismiss="modal"
              aria-label="Close"
            >
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form
              class="form"
              id="form_tambah_data_buku"
              action="#"
              @submit.prevent="tambahData__buku"
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
                  <button
                    type="submit"
                    class="btn btn-primary btn-sm btn-block"
                  >
                    Tambah
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import { searchMixin } from "../../mixins/searchMixin.js";
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

    tambahData__buku() {
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
          $("#form_tambah_data_buku").trigger("reset");
          this.$emit("reload", "");
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
