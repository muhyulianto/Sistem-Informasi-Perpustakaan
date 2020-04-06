<template>
  <div class="modal__data">
    <!-- Modal -->
    <div :id="'pinjam' + parentData.id" class="modal" role="dialog">
      <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <div class="modal-title">Pilih durasi peminjaman</div>
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
            <div class="row">
              <div class="col-lg-4">
                <button
                  @click="pinjam($auth.user().id, parentData.id, 1)"
                  class="btn btn-success btn-sm btn-block"
                >
                  1 Hari
                </button>
              </div>
              <div class="col-lg-4">
                <button
                  @click="pinjam($auth.user().id, parentData.id, 3)"
                  class="btn btn-success btn-sm btn-block"
                >
                  3 Hari
                </button>
              </div>
              <div class="col-lg-4">
                <button
                  @click="pinjam($auth.user().id, parentData.id, 7)"
                  class="btn btn-success btn-sm btn-block"
                >
                  7 Hari
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import moment from "moment";
export default {
  props: {
    parentData: Object
  },

  data() {
    return {};
  },

  mounted() {},

  methods: {
    pinjam(id_user, id_buku, durasi) {
      axios
        .post("api/peminjaman", {
          id_user: id_user,
          id_buku: id_buku,
          tanggal_pinjam: moment().format("YYYY-MM-DD hh:mm:ss"),
          tanggal_kembali: moment()
            .add(durasi, "days")
            .format("YYYY-MM-DD hh:mm:ss")
        })
        .then(response => {
          // run something here
          this.$swal({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 3000,
            type: "success",
            title: "Berhasil!",
            text: "Data telah ditambahkan"
          });
          this.$emit("reload", "");
          $(".modal").modal("hide");
        })
        .catch(error => {
          this.$swal({
            position: "center",
            showConfirmButton: false,
            timer: 3000,
            type: "error",
            title: "Oops!",
            text: error.response.data.errors
          });
        });
    }
  }
};
</script>
