<template>
  <div class="row">
    <div class="col">
      <div class="card shadow-sm">
        <div class="card-header d-flex flex-wrap align-items-end">
          <div class="card-title font-weight-bold text-uppercase mb-0 py-1">
            Data peminjaman
          </div>
          <button class="btn btn-secondary btn-sm ml-auto" @click="reset()">
            Reset pencarian
          </button>
          <form
            v-on:submit.prevent="
              fetchPeminjaman({ search_query: search_query })
            "
            class="input-group w-25 ml-2"
          >
            <input
              type="search"
              class="form-control form-control-sm"
              v-model="search_query"
              required
            />
            <span class="input-group-btn">
              <button class="btn btn-primary btn-sm" type="submit">
                <span class="fa fa-search" aria-hidden="true"></span> search!
              </button>
            </span>
          </form>
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
                <th v-if="$auth.check(1)">Status</th>
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
                <td v-if="$auth.check(1)">
                  {{
                    pinjam.tanggal_kembali <
                    moment().format("YYYY-MM-DD HH:MM:SS")
                      ? "Terlambat"
                      : "Dipinjam"
                  }}
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
          <div
            class="modal-info"
            v-for="(data, h) in data_peminjaman.data"
            :key="h"
          >
            <modalInfo
              :key="'info_buku' + h"
              v-bind:isPeminjaman="true"
              :parentData="data.buku"
            />
          </div>
          <modalUser
            v-for="(info_user, j) in data_peminjaman.data"
            :key="'info_user' + j"
            :parentData="info_user"
          />
          <div class="row justify-content-between">
            <div class="col-lg-3">
              <div class="d-flex align-items-center ml-auto">
                <div>Display</div>
                <select
                  v-model="data_entries"
                  class="form-control form-control-sm mx-2"
                  id="entry-show"
                  @change="fetchPeminjaman({})"
                >
                  <option value="10">10</option>
                  <option value="15">15</option>
                  <option value="20">20</option>
                </select>
                <div>Entries</div>
              </div>
            </div>
            <div class="col-lg-4 d-flex justify-content-end">
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
                      fetchPeminjaman({
                        page: data_peminjaman.current_page - 1
                      })
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
                      halaman == '...' ? '' : fetchPeminjaman({ page: halaman })
                    "
                    >{{ halaman }}</a
                  >
                </li>
                <li class="page-item">
                  <a
                    class="page-link"
                    href="#"
                    @click.prevent="
                      fetchPeminjaman({
                        page: data_peminjaman.current_page + 1
                      })
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
    </div>
  </div>
</template>
<script>
import { peminjamanMixin } from "../mixins/peminjamanMixin.js";
import { paginationMixin } from "../mixins/paginationMixin.js";
import modalInfo from "./modal/modal-info.vue";
import modalUser from "./modal/modal-user.vue";

export default {
  mixins: [peminjamanMixin, paginationMixin],

  components: {
    modalInfo,
    modalUser
  },

  mounted() {
    this.fetchPeminjaman({});
  },

  computed: {
    telat: () => {
      return "berhasil";
    }
  },

  methods: {
    returnBuku(id) {
      axios
        .post("api/kembalikanBuku", {
          id: id
        })
        .then(response => {
          this.fetchPeminjaman({});
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
    }
  }
};
</script>
