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
            v-on:submit.prevent="fetchPeminjaman({})"
            class="input-group w-25 ml-2"
          >
            <div class="input-group">
              <input
                type="search"
                class="form-control form-control-sm"
                v-model="search_query"
                required
              />
              <span class="input-group-append">
                <button class="btn btn-primary btn-sm" type="submit">
                  <span class="fa fa-search" aria-hidden="true"></span> search!
                </button>
              </span>
            </div>
          </form>
        </div>
        <div class="card-body">
          <table class="table table-no-border-top">
            <thead>
              <tr>
                <th>No</th>
                <th v-if="$auth.check(2)">
                  <a
                    class="text-dark"
                    href=""
                    @click.prevent="sort({ orderBy: 'name' })"
                  >
                    <i
                      v-if="orderDirection == 'DESC' && orderBy == 'name'"
                      class="fa fa-sort-desc"
                      aria-hidden="true"
                    ></i>
                    <i
                      v-else-if="orderDirection == 'ASC' && orderBy == 'name'"
                      class="fa fa-sort-asc"
                      aria-hidden="true"
                    ></i>
                    <i
                      v-else
                      class="fa fa-sort text-muted"
                      aria-hidden="true"
                    ></i>
                    Nama user
                  </a>
                </th>
                <th>
                  <a
                    class="text-dark"
                    href=""
                    @click.prevent="sort({ orderBy: 'judul_buku' })"
                  >
                    <i
                      v-if="orderDirection == 'DESC' && orderBy == 'judul_buku'"
                      class="fa fa-sort-desc"
                      aria-hidden="true"
                    ></i>
                    <i
                      v-else-if="
                        orderDirection == 'ASC' && orderBy == 'judul_buku'
                      "
                      class="fa fa-sort-asc"
                      aria-hidden="true"
                    ></i>
                    <i
                      v-else
                      class="fa fa-sort text-muted"
                      aria-hidden="true"
                    ></i>
                    Judul buku
                  </a>
                </th>
                <th>
                  <a
                    class="text-dark"
                    href=""
                    @click.prevent="sort({ orderBy: 'tanggal_pinjam' })"
                  >
                    <i
                      v-if="
                        orderDirection == 'DESC' && orderBy == 'tanggal_pinjam'
                      "
                      class="fa fa-sort-desc"
                      aria-hidden="true"
                    ></i>
                    <i
                      v-else-if="
                        orderDirection == 'ASC' && orderBy == 'tanggal_pinjam'
                      "
                      class="fa fa-sort-asc"
                      aria-hidden="true"
                    ></i>
                    <i
                      v-else
                      class="fa fa-sort text-muted"
                      aria-hidden="true"
                    ></i>
                    Tanggal pinjam
                  </a>
                </th>
                <th>
                  <a
                    class="text-dark"
                    href=""
                    @click.prevent="sort({ orderBy: 'tanggal_kembali' })"
                  >
                    <i
                      v-if="
                        orderDirection == 'DESC' && orderBy == 'tanggal_kembali'
                      "
                      class="fa fa-sort-desc"
                      aria-hidden="true"
                    ></i>
                    <i
                      v-else-if="
                        orderDirection == 'ASC' && orderBy == 'tanggal_kembali'
                      "
                      class="fa fa-sort-asc"
                      aria-hidden="true"
                    ></i>
                    <i
                      v-else
                      class="fa fa-sort text-muted"
                      aria-hidden="true"
                    ></i>
                    Tanggal kembali
                  </a>
                </th>
                <th v-if="$auth.check(1)">Status</th>
                <th v-if="$auth.check(2)">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(pinjam, i) in data_peminjaman.data" v-bind:key="i">
                <td class="align-middle">{{ data_peminjaman.from + i }}</td>
                <td class="align-middle" v-if="$auth.user().role == 2">
                  <router-link
                    :to="{ name: 'userShow', params: { id: pinjam.user.id } }"
                  >
                    {{ pinjam.user.name }}
                  </router-link>
                </td>
                <td class="align-middle">
                  <router-link
                    :to="{ name: 'detailBuku', params: { id: pinjam.buku.id } }"
                  >
                    {{ pinjam.buku.judul_buku }}
                  </router-link>
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
                      ? "Terlambat "
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
                      halaman == '...'
                        ? ''
                        : fetchPeminjaman({
                            page: halaman
                          })
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

export default {
  mixins: [peminjamanMixin, paginationMixin],

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
