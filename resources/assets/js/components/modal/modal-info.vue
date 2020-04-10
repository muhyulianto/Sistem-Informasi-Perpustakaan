<template>
  <div class="modal__data">
    <!-- Modal -->
    <div :id="'info__buku' + parentData.id" class="modal" role="dialog">
      <div class="modal-dialog modal-dialog-centered modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <div class="modal-title">
              Informasi lengkap buku
            </div>
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
            <div class="row justify-content-between">
              <div class="col-md-4">
                <img
                  class="w-100 h-100 object-cover"
                  :src="'./uploads/' + parentData.namaGambar"
                  alt=""
                />
                <div :class="isEditing ? 'input-group mt-n5 p-1' : 'd-none'">
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
                </div>
              </div>
              <div class="col-md-8">
                <table class="table table-borderless table-sm w-auto m-0">
                  <tbody>
                    <tr>
                      <th class="align-middle">Judul buku</th>
                      <td>
                        <input
                          type="text"
                          :id="'info__judulBuku-' + parentData.id"
                          :class="
                            isEditing
                              ? 'form-control '
                              : 'form-control-plaintext'
                          "
                          :readonly="readonly"
                          :value="parentData.judul_buku"
                          ref="judul_buku"
                        />
                      </td>
                    </tr>
                    <tr>
                      <th class="align-middle">Pengarang</th>
                      <td class="w-75">
                        <input
                          type="text"
                          id="input_pengarang"
                          :class="
                            isEditing
                              ? 'form-control'
                              : 'form-control-plaintext'
                          "
                          :readonly="readonly"
                          :value="parentData.pengarang"
                          ref="pengarang"
                        />
                      </td>
                    </tr>
                    <tr>
                      <th class="align-middle">Tahun terbit</th>
                      <td class="w-75">
                        <input
                          type="text"
                          id="input_tahunTerbit"
                          :class="
                            isEditing
                              ? 'form-control'
                              : 'form-control-plaintext'
                          "
                          :readonly="readonly"
                          :value="parentData.tahun_terbit"
                          ref="tahun_terbit"
                        />
                      </td>
                    </tr>
                    <tr>
                      <th class="align-middle">Penerbit</th>
                      <td class="w-75">
                        <input
                          type="text"
                          id="input_penerbit"
                          :class="
                            isEditing
                              ? 'form-control'
                              : 'form-control-plaintext'
                          "
                          :readonly="readonly"
                          :value="parentData.penerbit"
                          ref="penerbit"
                        />
                      </td>
                    </tr>
                    <tr>
                      <th class="align-middle">Jenis buku</th>
                      <td class="w-75">
                        <input
                          type="text"
                          id="input_jenisBuku"
                          :class="
                            isEditing
                              ? 'form-control'
                              : 'form-control-plaintext'
                          "
                          :readonly="readonly"
                          :value="parentData.jenis_buku"
                          ref="jenis_buku"
                        />
                      </td>
                    </tr>
                    <tr>
                      <th class="align-middle">Lokasi rak</th>
                      <td class="w-75">
                        <input
                          type="text"
                          id="input_lokasiRak"
                          :class="
                            isEditing
                              ? 'form-control'
                              : 'form-control-plaintext'
                          "
                          :readonly="readonly"
                          :value="parentData.lokasi_rak"
                          ref="lokasi_rak"
                        />
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <div
            class="modal-footer"
            v-if="$auth.user().role == 2 && $attrs.isPeminjaman != true"
          >
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
              @click="update(parentData.id)"
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
  </div>
</template>
<script>
export default {
  props: {
    parentData: Object
  },

  mounted() {},

  data() {
    return {
      isEditing: false,
      readonly: true,
      gambarBuku: {},
      namaGambar: "Pilih gambar"
    };
  },

  methods: {
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
        });
    }
  }
};
</script>
