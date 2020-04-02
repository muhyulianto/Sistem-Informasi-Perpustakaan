<template>
  <div class="row">
    <div class="col">
      <div class="card">
        <div class="card-header">
          <button
            class="btn btn-primary btn-sm pull-right"
            data-toggle="modal"
            data-target="#tambah_data"
            v-if="$auth.user().role == 2"
          >
            Tambah data
          </button>
          <h5 class="card-title mb-0 py-1">Data buku di perpustakaan</h5>
        </div>
        <div class="card-body">
          <form v-on:submit.prevent="search(0, url)" class="input-group">
            <input
              type="search"
              class="form-control"
              v-model="search_query"
              required
            />
            <span class="input-group-btn">
              <button class="btn btn-primary" type="submit">
                <span class="fa fa-search" aria-hidden="true"></span> search!
              </button>
            </span>
          </form>
        </div>
      </div>
      <div class="card">
        <div class="card-body">
          <table class="table table-no-border-top">
            <thead>
              <tr>
                <th>No</th>
                <th class="w-75">Nama buku</th>
                <th class="w-25">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(buku, i) in data_buku.data" v-bind:key="i">
                <td>{{ data_buku.from + i }}</td>
                <td class="w-75">{{ buku.judul_buku }}</td>
                <td class="w-25">
                  <button
                    class="btn btn-primary btn-sm px-3"
                    data-toggle="modal"
                    :data-target="'#info__buku' + buku.id"
                  >
                    Info
                  </button>
                  <button
                    class="btn btn-danger btn-sm"
                    v-if="$auth.user().role == 2"
                    @click="hapus(buku.id)"
                  >
                    Hapus
                  </button>
                  <button
                    class="btn btn-success btn-sm"
                    v-if="$auth.user().role == 1"
                    @click="pinjam($auth.user().id, buku.id)"
                  >
                    Pinjam
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
          <!-- Modal start -->
          <ul class="pagination" v-if="data_buku.last_page > 1">
            <li
              :class="
                data_buku.current_page - 1 < 1
                  ? 'page-item disabled'
                  : 'page-item'
              "
            >
              <a
                class="page-link"
                href="#"
                @click.prevent="search(data_buku.current_page - 1)"
              >
                <span class="fa fa-angle-double-left"></span>
              </a>
            </li>
            <li
              v-for="(halaman, i) in data_pagination"
              v-bind:key="i"
              :class="
                data_buku.current_page == halaman
                  ? 'page-item active'
                  : 'page-item'
              "
            >
              <a
                class="page-link"
                href="#"
                @click.prevent="halaman == '...' ? '' : search(halaman)"
                >{{ halaman }}</a
              >
            </li>
            <li
              :class="
                data_buku.current_page + 1 > data_buku.last_page
                  ? 'page-item disabled'
                  : 'page-item'
              "
            >
              <a
                class="page-link"
                href="#"
                @click.prevent="search(data_buku.current_page + 1)"
              >
                <span class="fa fa-angle-double-right"></span>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </div>
    <buku_ModalAdd v-on:reload="search" />
    <modalInfo
      v-on:reload="search"
      v-for="(buku, i) in data_buku.data"
      :key="'info' + i"
      :parentData="buku"
    />
    <!-- Modal end -->
  </div>
</template>

<script>
import { searchMixin } from "../mixins/searchMixin.js";
import modalInfo from "./modal-info.vue";
import buku_ModalAdd from "./modal-add.vue";

import moment from "moment";

export default {
  mixins: [searchMixin],

  data() {
    return {
      url: "api/data"
    };
  },

  components: {
    modalInfo,
    buku_ModalAdd
  },

  mounted() {
    this.search();
  },

  methods: {
    hapus(id) {
      this.$swal({
        title: "Apa anda yakin?",
        text: "Anda tidak akan dapat mengembalikan file ini",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Ya, hapus file ini!",
        cancelButtonText: "Batalkan"
      }).then(result => {
        if (result.value) {
          axios
            .delete("/api/data/" + id, {
              // Do something here
            })
            .then(response => {
              this.search();
              this.$swal({
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 3000,
                type: "success",
                title: "Berhasil!",
                text: "Data telah dihapus!"
              });
            });
        }
      });
    },

    pinjam(id_user, id_buku) {
      axios
        .post("api/peminjaman", {
          id_user: id_user,
          id_buku: id_buku,
          tanggal_pinjam: moment().format("YYYY-MM-DD hh:mm:ss"),
          tanggal_kembali: moment()
            .add(3, "days")
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
</script>
