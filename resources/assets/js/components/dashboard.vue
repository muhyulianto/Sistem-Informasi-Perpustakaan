<template>
  <div class="row">
    <template v-if="$auth.check(['roles', 2])">
      <div class="col-md-3">
        <div class="card bg-info text-white shadow-sm mb-4">
          <div class="card-header bg-info">Jumlah buku yang di pinjam hari ini</div>
          <div class="card-body">
            <h5>{{ buku != "" ? buku + " Buku" : "-" }}</h5>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card bg-success text-white shadow-sm mb-4">
          <div class="card-header bg-success">Jumlah user yang meminjam buku hari ini</div>
          <div class="card-body">
            <h5>{{ pinjam != "" ? pinjam + " User" : "-" }}</h5>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card bg-warning text-white shadow-sm mb-4">
          <div class="card-header bg-warning">Buku yang paling sering di pinjam</div>
          <div class="card-body">
            <h5 class="text-truncate">{{ bukuPalingDiPinjam != "" ? bukuPalingDiPinjam : "-" }}</h5>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card bg-danger text-white shadow-sm mb-4">
          <div class="card-header bg-danger">User yang paling sering meminjam buku</div>
          <div class="card-body">
            <h5 class="text-truncate">{{ userPalingMeminjam != "" ? userPalingMeminjam : "-" }}</h5>
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
    </template>
    <template v-if="$auth.check(['roles', 1])">
      <div class="col-lg-12 mb-3">
        <div class="card bg-primary text-white">
          <div
            class="card-body text-center font-weight-bold"
          >SELAMAT DATANG DI SISTEM INFORMASI PERPUSTAKAAN SDN 100 KONOHAGAKURE</div>
        </div>
      </div>
      <div class="col-lg-3">
        <div class="card">
          <div class="card-header">Jumlah buku yang telah anda pinjam</div>
          <div class="card-body">100 Buku</div>
        </div>
      </div>
    </template>
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
      jumlah: [0],
      loading: false
    };
  },

  mounted() {
    this.pinjamHariIni();
    this.renderChart();
  },

  methods: {
    pinjamHariIni() {
      axios.post("/api/dashboard/pinjam").then(response => {
        this.pinjam = response.data.userMeminjamBukuHariIni;
        this.buku = response.data.bukuDiPinjamHariIni;
        this.bukuPalingDiPinjam =
          response.data.bukuPalingBanyakPinjam[0].buku.judul_buku;
        this.userPalingMeminjam =
          response.data.userPalingBanyakMeminjam[0].user.name;
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
        response.data.chartdata.forEach(element =>
          this.tanggal.push(element.date)
        );
        response.data.chartdata.forEach(element =>
          this.jumlah.push(element.jumlah)
        );
      });
    }
  }
};
</script>
