<template>
  <div class="row">
    <div v-if="loading" class="loading">
      <label class="align-self-center">
        <div class="sk-chase">
          <div class="sk-chase-dot"></div>
          <div class="sk-chase-dot"></div>
          <div class="sk-chase-dot"></div>
          <div class="sk-chase-dot"></div>
          <div class="sk-chase-dot"></div>
          <div class="sk-chase-dot"></div>
        </div>
      </label>
    </div>
    <div v-if="!loading" class="col fadeMe">
      <div class="card shadow-sm">
        <div class="card-header">
          <h5 class="card-title my-2">Data peminjaman</h5>
        </div>
        <div class="card-body">
          <table class="table table-no-border-top">
            <thead>
              <tr>
                <th>No</th>
                <th v-if="$auth.user().role == 2">Nama user</th>
                <th>Judul buku</th>
                <th>Tanggal pinjam</th>
                <th>Tanggal kembali</th>
                <th v-if="$auth.user().role == 2">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(pinjam, i) in data_peminjaman.data" v-bind:key="i">
                <td class="align-middle">{{ data_peminjaman.from + i }}</td>
                <td class="align-middle" v-if="$auth.user().role == 2">
                  <a
                    href
                    data-toggle="modal"
                    :data-target="'#info__user' + pinjam.id_user"
                    >{{ pinjam.user.name }}</a
                  >
                </td>
                <td class="align-middle">
                  <a
                    href
                    data-toggle="modal"
                    :data-target="'#info__buku' + pinjam.id_buku"
                    >{{ pinjam.buku.judul_buku }}</a
                  >
                </td>
                <td class="align-middle">
                  {{ pinjam.tanggal_pinjam | moment("DD MMMM YYYY") }}
                </td>
                <td class="align-middle">
                  {{ pinjam.tanggal_kembali | moment("DD MMMM YYYY") }}
                </td>
                <td v-if="$auth.user().role == 2">
                  <button
                    @click.prevent="returnBuku(pinjam.id)"
                    class="btn btn-primary btn-sm"
                  >
                    Kembali
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
          <div class="modal-info" v-for="(data, h) in data_peminjaman.data">
            <dataModal__info
              :key="'info_buku' + h"
              v-bind:isPeminjaman="true"
              :parentData="data.buku"
            />
          </div>
          <peminjamanModal__user
            v-for="(info_user, j) in data_peminjaman.data"
            :key="'info_user' + j"
            :parentData="info_user"
          />
          <ul class="pagination" v-if="data_peminjaman.last_page > 1">
            <li
              :class="
                data_peminjaman.current_page - 1 < 1
                  ? 'page-item disabled'
                  : 'page-item'
              "
            >
              <a
                class="page-link"
                href="#"
                @click.prevent="
                  fetchPeminjaman(data_peminjaman.current_page - 1)
                "
              >
                <span class="fa fa-angle-double-left"></span>
              </a>
            </li>
            <li
              v-for="(halaman, i) in data_pagination"
              v-bind:key="i"
              :class="
                data_peminjaman.current_page == halaman
                  ? 'page-item active'
                  : 'page-item'
              "
            >
              <a
                class="page-link"
                href="#"
                @click.prevent="
                  halaman == '...' ? '' : fetchPeminjaman(halaman)
                "
                >{{ halaman }}</a
              >
            </li>
            <li class="page-item">
              <a
                class="page-link"
                href="#"
                @click.prevent="
                  fetchPeminjaman(data_peminjaman.current_page + 1)
                "
              >
                <span class="fa fa-angle-double-right"></span>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import { searchMixin } from "../mixins/searchMixin.js";
import dataModal__info from "./modal-info.vue";
import peminjamanModal__user from "./peminjaman__modal--user.vue";

export default {
  mixins: [searchMixin],

  components: {
    dataModal__info,
    peminjamanModal__user
  },

  data() {
    return {
      data_peminjaman: {},
      loading: false
    };
  },

  mounted() {
    this.fetchPeminjaman();
  },

  methods: {
    fethUser() {
      return axios
        .get("api/auth/user", {
          params: {}
        })
        .then(response => {
          if (response.data.data.role == 2) {
            return null;
          }
          return response.data.data.id;
        });
    },

    async fetchPeminjaman(page) {
      this.loading = true;
      let tunggu = await this.fethUser();
      axios
        .get("api/peminjaman", {
          // run something here
          params: {
            id: tunggu,
            page: page
          }
        })
        .then(response => {
          this.data_peminjaman = response.data.data_peminjaman;
          this.data_pagination = this.getPagesArray(
            this.data_peminjaman.total,
            this.data_peminjaman.current_page,
            this.data_peminjaman.per_page
          );
          this.loading = false;
        });
    },

    returnBuku(id) {
      axios
        .post("api/pengembalian", {
          id: id
        })
        .then(response => {
          this.fetchPeminjaman();
          this.$swal({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 3000,
            type: "success",
            title: "Berhasil!",
            text: "Buku telah dikembalikan"
          });
        });
    },

    noDuplicateArray(array, item) {
      const result = array.reduce((unique, o) => {
        if (!unique.some(obj => obj[item] === o[item])) {
          unique.push(o);
        }
        return unique;
      }, []);
      return result;
    }
  }
};
</script>
