<template>
  <div class="row">
    <div class="col-lg-12 mb-4">
      <div class="card bg-primary text-white shadow-sm">
        <div class="card-body text-center font-weight-bold">
          SELAMAT DATANG DI SISTEM INFORMASI PERPUSTAKAAN SDN 100 KONOHAGAKURE
        </div>
      </div>
    </div>
    <div class="col-lg-3">
      <div class="card mb-4 shadow-sm">
        <div class="card-header text-muted">
          Jumlah buku yang telah anda pinjam
        </div>
        <div class="card-body font-weight-bold">
          {{ jumlah_pinjam + " Buku" }}
        </div>
      </div>
    </div>
    <div class="col-lg-3">
      <div class="card mb-4 shadow-sm">
        <div class="card-header text-muted">
          Jumlah buku yang anda pinjam hari ini
        </div>
        <div class="card-body font-weight-bold">
          {{ jumlah_pinjam_hari_ini + " Buku" }}
        </div>
      </div>
    </div>
    <div class="col-lg-3">
      <div class="card mb-4 shadow-sm">
        <div class="card-header text-muted">Buku yang sering anda pinjam</div>
        <div class="card-body font-weight-bold">{{ sering_dipinjam }}</div>
      </div>
    </div>
    <div class="col-lg-3">
      <div class="card mb-4 shadow-sm">
        <div class="card-header text-muted">
          Buku yang terkahir anda pinjam
        </div>
        <div class="card-body font-weight-bold">{{ terakhir_dipinjam }}</div>
      </div>
    </div>
    <div class="col-lg-6">
      <div class="card">
        <div class="card-header border-0">
          <div class="card-title font-weight-bold m-0">
            Daftar buku terbaru
          </div>
        </div>
        <div class="card-body">
          <table class="table">
            <thead>
              <tr>
                <th class="border-top-0" style="width: 10%">No</th>
                <th class="border-top-0">Nama buku</th>
              </tr>
            </thead>
            <tbody v-for="(buku, i) in daftar_buku_baru" :key="i">
              <tr>
                <td>
                  {{ i + 1 }}
                </td>
                <td>
                  {{ buku.judul_buku }}
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <div class="col-lg-6">
      <div class="card shadow-sm">
        <div class="card-body"></div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {
      jumlah_pinjam: "",
      jumlah_pinjam_hari_ini: "",
      sering_dipinjam: "",
      terakhir_dipinjam: "",
      daftar_buku_baru: ""
    };
  },

  mounted() {
    this.pinjamBukuUser();
  },

  methods: {
    pinjamBukuUser() {
      this.$store.commit("TOGGLE_LOADING", true);
      axios
        .post("api/dashboard/pinjam_user", {
          id_user: this.$auth.user().id
        })
        .then(response => {
          this.jumlah_pinjam = response.data.jumlah_pinjam_all;
          this.jumlah_pinjam_hari_ini = response.data.jumlah_pinjam_hari_ini;
          this.sering_dipinjam =
            response.data.buku_sering_dipinjam.buku.judul_buku;
          this.terakhir_dipinjam =
            response.data.buku_terakhir_dipinjam.buku.judul_buku;
          this.daftar_buku_baru = response.data.daftar_buku_baru;
          this.$store.commit("TOGGLE_LOADING", false);
        });
    }
  }
};
</script>
