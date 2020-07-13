<template>
  <div class="row">
    <div class="col-lg-6">
      <div class="card mb-4 shadow-sm">
        <div class="card-header border-0 d-flex align-items-center">
          <a
            href=""
            class="btn btn-primary btn-sm mr-2"
            @click.prevent="$router.go(-1)"
          >
            <i class="fa fa-arrow-left" aria-hidden="true"></i>
          </a>
          <div class="card-title font-weight-bold m-0">
            Informasi siswa
          </div>
        </div>
        <div class="card-body">
          <table class="table table-borderless">
            <tr>
              <td>Nama siswa</td>
              <td class="text-right font-weight-bold">
                {{ userData.name }}
              </td>
            </tr>
            <tr>
              <td>E-mail</td>
              <td class="text-right font-weight-bold">
                {{ userData.email }}
              </td>
            </tr>
            <tr>
              <td>Kelas</td>
              <td class="text-right font-weight-bold">
                {{ userData.kelas == null ? "-" : userData.kelas }}
              </td>
            </tr>
          </table>
        </div>
      </div>
    </div>
    <div class="col-lg-6">
      <div class="card mb-4 shadow-sm">
        <div class="card-header border-0">
          <div class="card-title font-weight-bold m-0">
            Daftar buku yang terakhir dipinjam
          </div>
        </div>
        <div class="card-body">
          <table class="table">
            <thead>
              <tr>
                <th class="border-top-0">Judul buku</th>
                <th class="border-top-0 text-right">Tanggal pinjam</th>
              </tr>
            </thead>
            <tbody>
              <tr
                v-for="(peminjaman, i) in data_peminjaman.data"
                :key="i"
                v-if="i < 5"
              >
                <td>{{ peminjaman.buku.judul_buku }}</td>
                <td class="text-right">
                  {{ peminjaman.tanggal_pinjam | moment("DD MMMM YYYY") }}
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <div class="col-lg-12">
      <div class="card shadow-sm mb-4">
        <div class="card-body">
          <canvas id="canvas"></canvas>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import { Bar } from "vue-chartjs";
import { peminjamanMixin } from "./../mixins/peminjamanMixin.js";
import { paginationMixin } from "./../mixins/paginationMixin.js";
export default {
  mixins: [peminjamanMixin, paginationMixin],

  data() {
    return {
      id: this.$route.params.id,
      userData: {},
      tanggal: [],
      jumlah: []
    };
  },

  mounted() {
    this.fetchPeminjaman({ pengembalian: true, id_user: this.id });
    this.getUser();
    this.renderChart();
  },

  methods: {
    getUser() {
      axios
        .post("api/user", {
          id: this.id
        })
        .then(response => {
          this.userData = response.data.user;
        });
    },

    async renderChart() {
      this.$store.commit("TOGGLE_LOADING", true);
      const tunggu = await this.chartData();
      this.$store.commit("TOGGLE_LOADING", false);
      new Chart(document.getElementById("canvas").getContext("2d"), {
        type: "line",
        data: {
          labels: this.tanggal,
          datasets: [
            {
              label: "Jumlah peminjaman",
              data: this.jumlah,
              fill: false,
              borderColor: "#5BC0DE"
            }
          ]
        },
        options: {
          title: {
            display: true,
            fontSize: 22,
            text: "Grafik peminjaman user selama 1 minggu terakhir"
          }
        }
      });
    },

    chartData() {
      return axios.post("api/user/" + this.id).then(response => {
        this.tanggal = response.data.chartdata;
        this.jumlah = response.data.jumlahdata;
      });
    }
  }
};
</script>
