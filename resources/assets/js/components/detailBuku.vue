<template>
  <div class="row">
    <div class="col">
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
            Informasi lengkap buku
          </div>
        </div>
        <div class="card-body">
          <div class="row align-items-center justify-content-center">
            <div class="col-lg-6 text-center">
              <img
                style="height: 300px"
                class="img-fluid"
                :src="'./../uploads/' + buku.namaGambar"
                alt="anda belum mengunggah gambar buku"
              />
            </div>
            <div class="col-lg-6">
              <div class="table-responsive">
                <table class="table table-borderless table-sm m-0">
                  <tbody>
                    <tr>
                      <td
                        class="align-middle text-muted border-0"
                        style="width: 30%"
                      >
                        Judul buku
                      </td>
                      <td class="border-0">
                        <input
                          type="text"
                          id="inputJudulBuku"
                          :class="
                            isEditing
                              ? 'form-control '
                              : 'form-control-plaintext text-right'
                          "
                          :value="buku.judul_buku"
                          ref="judul_buku"
                        />
                      </td>
                    </tr>
                    <tr>
                      <td class="align-middle text-muted">Pengarang</td>
                      <td class="w-75">
                        <input
                          type="text"
                          id="input_pengarang"
                          :class="
                            isEditing
                              ? 'form-control'
                              : 'form-control-plaintext text-right'
                          "
                          :value="buku.pengarang"
                          ref="pengarang"
                        />
                      </td>
                    </tr>
                    <tr>
                      <td class="align-middle text-muted">Tahun terbit</td>
                      <td class="w-75">
                        <input
                          type="text"
                          id="input_tahunTerbit"
                          :class="
                            isEditing
                              ? 'form-control'
                              : 'form-control-plaintext text-right'
                          "
                          :value="buku.tahun_terbit"
                          ref="tahun_terbit"
                        />
                      </td>
                    </tr>
                    <tr>
                      <td class="align-middle text-muted">Penerbit</td>
                      <td class="w-75">
                        <input
                          type="text"
                          id="input_penerbit"
                          :class="
                            isEditing
                              ? 'form-control'
                              : 'form-control-plaintext text-right'
                          "
                          :value="buku.penerbit"
                          ref="penerbit"
                        />
                      </td>
                    </tr>
                    <tr>
                      <td class="align-middle text-muted">Jenis buku</td>
                      <td class="w-75">
                        <input
                          type="text"
                          id="input_jenisBuku"
                          :class="
                            isEditing
                              ? 'form-control'
                              : 'form-control-plaintext text-right'
                          "
                          :value="buku.jenis_buku"
                          ref="jenis_buku"
                        />
                      </td>
                    </tr>
                    <tr>
                      <td class="align-middle text-muted">Lokasi rak</td>
                      <td class="w-75">
                        <input
                          type="text"
                          id="input_lokasiRak"
                          :class="
                            isEditing
                              ? 'form-control'
                              : 'form-control-plaintext text-right'
                          "
                          :value="buku.lokasi_rak"
                          ref="lokasi_rak"
                        />
                      </td>
                    </tr>
                    <tr :class="isEditing ? 'd-show' : 'd-none'">
                      <td class="align-middle text-muted">Gambar</td>
                      <td>
                        <div class="custom-file">
                          <input
                            type="file"
                            class="custom-file-input"
                            id="inputGroupFile01"
                            aria-describedby="inputGroupFileAddon01"
                            @change="uploadGambar($event)"
                          />
                          <label
                            class="custom-file-label overflow-hidden"
                            for="inputGroupFile01"
                            >{{ namaGambar }}</label
                          >
                        </div>
                        <div class="input-group"></div>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        <div class="card-footer float-right">
          <button
            :class="
              isEditing == true ? 'd-none' : 'btn btn-primary btn-sm px-4'
            "
            @click="edit"
          >
            Ubah
          </button>
          <button
            :class="
              isEditing == false ? 'd-none' : 'btn btn-primary btn-sm px-4'
            "
            @click="update(buku.id)"
          >
            Simpan
          </button>
          <button
            :class="
              isEditing == false ? 'd-none' : 'btn btn-secondary btn-sm px-4 '
            "
            @click="isEditing = false"
          >
            Batal
          </button>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {
      id: this.$route.params.id,
      buku: {},
      isEditing: false,
      readonly: true,
      gambarBuku: {},
      namaGambar: "Pilih gambar"
    };
  },

  mounted() {
    this.getBuku();
  },

  methods: {
    getBuku() {
      this.$store.commit("TOGGLE_LOADING", true);
      axios
        .get("api/data/" + this.id)
        .then(response => {
          this.buku = response.data;
        })
        .then(() => {
          this.$store.commit("TOGGLE_LOADING", false);
        });
    },

    uploadGambar(event) {
      this.gambarBuku = event.target.files[0];
      this.namaGambar = this.gambarBuku.name;
    },

    edit() {
      this.isEditing = true;
      this.readonly = false;
    },

    update(id) {
      let formData = new FormData();
      formData.append("_method", "put");
      formData.append("judul_buku", this.$refs.judul_buku.value);
      formData.append("pengarang", this.$refs.pengarang.value);
      formData.append("tahun_terbit", this.$refs.tahun_terbit.value);
      formData.append("penerbit", this.$refs.penerbit.value);
      formData.append("jenis_buku", this.$refs.jenis_buku.value);
      formData.append("lokasi_rak", this.$refs.lokasi_rak.value);
      formData.append("image", this.gambarBuku);
      axios
        .post("/api/data/" + id, formData, {
          headers: {
            "Content-Type": "multipart/form-data"
          }
        })
        .then(response => {
          this.isEditing = false;
          this.readonly = true;
          this.$emit("reload", "");
          this.$swal({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 3000,
            type: "success",
            title: "Berhasil!",
            text: "Data telah diupdate!"
          });
        })
        .then(() => {
          this.getBuku();
        });
    }
  }
};
</script>
