<template>
  <div class="row">
    <div class="col-lg-6">
      <div class="card shadow-sm">
        <div class="card-header d-flex align-items-center">
          <router-link
            :to="{ name: 'buku' }"
            class="btn btn-primary btn-sm mr-2"
          >
            <i class="fa fa-arrow-left" aria-hidden="true"></i>
          </router-link>
          <div class="card-title font-weight-bold m-0">
            PINJAM BUKU
          </div>
        </div>
        <div class="card-body">
          <div class="form-group">
            <label for="user">
              Nama siswa
            </label>
            <select class="form-control" id="user" v-model="idUser">
              <option value="" selected disabled> </option>
              <option v-for="user in users" :key="user.id" :value="user.id">
                {{ user.name }}
              </option>
            </select>
          </div>
          <div class="form-group">
            <label for="lamaPeminjaman">
              Lama peminjaman
            </label>
            <input
              type="number"
              class="form-control"
              id="lamaPeminjaman"
              min="0"
              max="7"
              v-model="lamaPeminjaman"
            />
          </div>
          <button v-on:click="pinjamBuku()" class="btn btn-primary">
            Pinjam
          </button>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import moment from "moment";
export default {
  data() {
    return {
      users: [],
      idUser: "",
      lamaPeminjaman: ""
    };
  },

  mounted() {
    this.getBuku();
  },

  methods: {
    getBuku() {
      axios.get("api/users").then(response => {
        this.users = response.data.users.data;
      });
    },

    pinjamBuku() {
      axios
        .post("api/peminjaman", {
          id_user: this.idUser,
          id_buku: this.$route.params.id,
          tanggal_pinjam: moment().format("YYYY-MM-DD hh:mm:ss"),
          tanggal_kembali: moment()
            .add(this.lamaPeminjaman, "days")
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
            text: response.data.success
          });
          this.$router.push({ name: "buku" });
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
