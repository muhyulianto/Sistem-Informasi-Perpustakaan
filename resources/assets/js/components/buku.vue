<template>
  <div class="row">
    <div class="col">
      <div class="card shadow-sm">
        <div class="card-header d-flex flex-wrap align-items-end">
          <div class="card-title font-weight-bold text-uppercase m-0">
            Data buku di perpustakaan
          </div>
          <button class="btn btn-secondary btn-sm ml-auto" @click="reset()">
            Reset pencarian
          </button>
          <form v-on:submit.prevent="search()" class="input-group w-25 ml-2">
            <div class="input-group">
              <input
                type="search"
                class="form-control form-control-sm"
                v-model="search_query"
                required
              />
              <span class="input-group-append">
                <button class="btn btn-primary btn-sm" type="submit">
                  <span class="fa fa-search" aria-hidden="true"></span> cari
                </button>
              </span>
            </div>
          </form>
          <router-link
            :to="{ name: 'tambahBuku' }"
            class="btn btn-primary btn-sm ml-2"
            v-if="$auth.check(2)"
          >
            Tambah buku
          </router-link>
        </div>
        <div class="card-body">
          <table class="table table-no-border-top">
            <thead>
              <tr>
                <th style="width: 50px">No</th>
                <th>
                  <a
                    class="text-dark"
                    href=""
                    @click.prevent="sort({ orderBy: 'judul_buku' })"
                  >
                    <i
                      v-if="orderDirection == 'DESC'"
                      class="fa fa-sort-desc"
                      aria-hidden="true"
                    ></i>
                    <i
                      v-else-if="orderDirection == 'ASC'"
                      class="fa fa-sort-asc"
                      aria-hidden="true"
                    ></i>
                    <i
                      v-else
                      class="fa fa-sort text-muted"
                      aria-hidden="true"
                    ></i>
                    Nama buku
                  </a>
                </th>
                <th class="text-right">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(buku, i) in data_buku.data" v-bind:key="i">
                <td>{{ data_buku.from + i }}</td>
                <td>{{ buku.judul_buku }}</td>
                <td class="text-right">
                  <router-link
                    class="btn btn-primary btn-sm"
                    :to="{ name: 'detailBuku', params: { id: buku.id } }"
                  >
                    Detail
                  </router-link>
                  <router-link
                    v-if="$auth.check(2)"
                    class="btn btn-success btn-sm"
                    :to="{ name: 'pinjamBuku', params: { id: buku.id } }"
                  >
                    Pinjam
                  </router-link>
                  <button
                    class="btn btn-danger btn-sm"
                    v-if="$auth.check(2)"
                    @click="hapus(buku.id)"
                  >
                    Hapus
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
          <div class="row justify-content-between">
            <div class="col-md-3">
              <div class="d-flex align-items-center ml-auto">
                <div>Display</div>
                <select
                  v-model="data_entries"
                  class="form-control form-control-sm mx-2"
                  id="entry-show"
                  @change="search()"
                >
                  <option value="10">10</option>
                  <option value="15">15</option>
                  <option value="20">20</option>
                </select>
                <div>Entries</div>
              </div>
            </div>
            <div class="col-md-4 d-flex justify-content-end">
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
                    @click.prevent="
                      data_buku.current_page == halaman
                        ? ''
                        : halaman == '...'
                        ? ''
                        : search(halaman)
                    "
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
      </div>
    </div>
  </div>
</template>

<script>
import { searchMixin } from "../mixins/searchMixin.js";
import { paginationMixin } from "../mixins/paginationMixin.js";

export default {
  mixins: [searchMixin, paginationMixin],

  mounted() {
    this.search();
  },

  methods: {
    reset() {
      this.search_query = "";
      this.search();
    },

    hapus(id) {
      this.$swal({
        title: "Apa anda yakin?",
        text: "Anda tidak akan dapat mengembalikan file ini",
        type: "warning",
        showCancelButton: true,
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

    sort({ orderBy }) {
      this.orderBy = orderBy;
      this.orderDirection = this.orderDirection == "DESC" ? "ASC" : "DESC";
      this.search();
    }
  }
};
</script>
