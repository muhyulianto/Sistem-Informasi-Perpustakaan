<template>
  <div class="row">
    <div class="col-md-3">
      <div class="card bg-info text-white shadow-sm mb-4">
        <div class="card-header bg-info">
          Jumlah buku yang di pinjam hari ini
        </div>
        <div class="card-body">
          <h5 class="font-weight-bold">
            {{ buku != "" ? buku + " Buku" : "-" }}
          </h5>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card bg-success text-white shadow-sm mb-4">
        <div class="card-header bg-success">
          Jumlah user yang meminjam buku hari ini
        </div>
        <div class="card-body">
          <h5 class="font-weight-bold">
            {{ pinjam != "" ? pinjam + " User" : "-" }}
          </h5>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card bg-warning text-white shadow-sm mb-4">
        <div class="card-header bg-warning">
          Buku yang paling sering di pinjam
        </div>
        <div class="card-body">
          <h5 class="text-truncate font-weight-bold">
            {{ bukuPalingDiPinjam != "" ? bukuPalingDiPinjam : "-" }}
          </h5>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card bg-danger text-white shadow-sm mb-4">
        <div class="card-header bg-danger">
          User yang paling sering meminjam buku
        </div>
        <div class="card-body">
          <h5 class="text-truncate font-weight-bold">
            {{ userPalingMeminjam != "" ? userPalingMeminjam : "-" }}
          </h5>
        </div>
      </div>
    </div>
    <div class="col">
      <div class="card shadow-sm">
        <div class="card-body">
          <canvas id="canvas"></canvas>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import { Bar } from "vue-chartjs";

export default {
  extends: Bar,

  data() {
    return {
      pinjam: "",
      buku: "",
      bukuPalingDiPinjam: "",
      userPalingMeminjam: "",
      tanggal: [0],
      jumlah: [0]
    };
  },

  mounted() {
    this.pinjamBuku();
    this.renderChart();
  },

  methods: {
    pinjamBuku() {
      axios.post("/api/dashboard/pinjam").then(response => {
        this.pinjam = response.data.userMeminjamBukuHariIni;
        this.buku = response.data.bukuDiPinjamHariIni;
        this.bukuPalingDiPinjam =
          response.data.bukuPalingBanyakPinjam.buku.judul_buku;
        this.userPalingMeminjam =
          response.data.userPalingBanyakMeminjam.user.name;
        this.daftar_buku_baru = response.data.daftar_buku_baru;
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
            text: "Grafik data peminjaman selama satu minggu"
          }
        }
      });
    },

    chartData() {
      return axios.post("api/dashboard/chartData").then(response => {
        this.tanggal = response.data.tanggal;
        this.jumlah = response.data.jumlah;
      });
    }
  }
};
</script>
