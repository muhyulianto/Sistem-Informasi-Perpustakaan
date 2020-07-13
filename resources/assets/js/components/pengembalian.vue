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
              fetchPeminjaman({
                pengembalian: true
              })
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
          <a class="ml-3" href="#" v-on:click.prevent="downloadPengembalian">
            <span class="fa fa-download"></span> Download data
          </a>
        </div>
        <div class="card-body">
          <table class="table table-no-border-top text-gray-900">
            <thead>
              <tr>
                <th>No</th>
                <th v-if="$auth.check(2)">
                  <a
                    class="text-dark"
                    href=""
                    @click.prevent="
                      sort({ orderBy: 'name', pengembalian: true })
                    "
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
                    @click.prevent="
                      sort({ orderBy: 'judul_buku', pengembalian: true })
                    "
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
                    @click.prevent="
                      sort({ orderBy: 'tanggal_pinjam', pengembalian: true })
                    "
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
                    @click.prevent="
                      sort({ orderBy: 'tanggal_kembali', pengembalian: true })
                    "
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
                <th>
                  <a
                    class="text-dark"
                    href=""
                    @click.prevent="
                      sort({
                        orderBy: 'dikembalikan_tanggal',
                        pengembalian: true
                      })
                    "
                  >
                    <i
                      v-if="
                        orderDirection == 'DESC' &&
                          orderBy == 'dikembalikan_tanggal'
                      "
                      class="fa fa-sort-desc"
                      aria-hidden="true"
                    ></i>
                    <i
                      v-else-if="
                        orderDirection == 'ASC' &&
                          orderBy == 'dikembalikan_tanggal'
                      "
                      class="fa fa-sort-asc"
                      aria-hidden="true"
                    ></i>
                    <i
                      v-else
                      class="fa fa-sort text-muted"
                      aria-hidden="true"
                    ></i>
                    Dikembalikan
                  </a>
                </th>
                <th>
                  <a
                    class="text-dark"
                    href=""
                    @click.prevent="
                      sort({ orderBy: 'telat', pengembalian: true })
                    "
                  >
                    <i
                      v-if="orderDirection == 'DESC' && orderBy == 'telat'"
                      class="fa fa-sort-desc"
                      aria-hidden="true"
                    ></i>
                    <i
                      v-else-if="orderDirection == 'ASC' && orderBy == 'telat'"
                      class="fa fa-sort-asc"
                      aria-hidden="true"
                    ></i>
                    <i
                      v-else
                      class="fa fa-sort text-muted"
                      aria-hidden="true"
                    ></i>
                    Terlambat
                  </a>
                </th>
                <th>Denda</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(kembali, i) in data_peminjaman.data" v-bind:key="i">
                <td>{{ data_peminjaman.from + i }}</td>
                <td v-if="$auth.user().role == 2">
                  <router-link
                    :to="{ name: 'userShow', params: { id: kembali.user.id } }"
                  >
                    {{ kembali.user.name }}
                  </router-link>
                </td>
                <td>
                  <router-link
                    :to="{
                      name: 'detailBuku',
                      params: { id: kembali.buku.id }
                    }"
                  >
                    {{ kembali.buku.judul_buku }}
                  </router-link>
                </td>
                <td>{{ kembali.tanggal_pinjam | moment("DD MMMM YYYY") }}</td>
                <td>
                  {{ kembali.tanggal_kembali | moment("DD MMMM YYYY") }}
                </td>
                <td>
                  {{ kembali.dikembalikan_tanggal | moment("DD MMMM YYYY") }}
                </td>
                <td>
                  {{
                    kembali.telat == 0 ? "tepat waktu" : kembali.telat + " Hari"
                  }}
                </td>
                <td>Rp.{{ kembali.denda }},-</td>
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
                  @change="fetchPeminjaman({ pengembalian: true })"
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
                        page: data_peminjaman.current_page - 1,
                        pengembalian: true
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
                        : fetchPeminjaman({ page: halaman, pengembalian: true })
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
                        page: data_peminjaman.current_page + 1,
                        pengembalian: true
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
  mixins: [paginationMixin, peminjamanMixin],

  mounted() {
    this.fetchPeminjaman({ search_query: "", pengembalian: true });
  },

  methods: {
    downloadPengembalian() {
      axios.post("api/pengembalian/download", {});
    }
  }
};
</script>
