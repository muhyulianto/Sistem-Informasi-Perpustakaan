<template>
  <div class="row">
    <div class="col">
      <div class="card">
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
                search_query: search_query,
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
          <a href="#" v-on:click.prevent="downloadPengembalian">
            <span class="fa fa-download"></span> Download data
          </a>
        </div>
        <div class="card-body">
          <table class="table table-no-border-top text-gray-900">
            <thead>
              <tr>
                <th>No</th>
                <th v-if="$auth.user().role == 2">Nama user</th>
                <th>judul buku</th>
                <th>Tanggal pinjam</th>
                <th>Dikembalikan</th>
                <th>Denda</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(kembali, i) in data_peminjaman.data" v-bind:key="i">
                <td>{{ data_peminjaman.from + i }}</td>
                <td v-if="$auth.user().role == 2">
                  <a
                    href
                    data-toggle="modal"
                    :data-target="'#info__user' + kembali.id_user"
                    >{{ kembali.user.name }}</a
                  >
                </td>
                <td>
                  <a
                    href
                    data-toggle="modal"
                    :data-target="'#info__buku' + kembali.id_buku"
                    >{{ kembali.buku.judul_buku }}</a
                  >
                </td>
                <td>{{ kembali.tanggal_pinjam | moment("DD MMMM YYYY") }}</td>
                <td>
                  <!-- prettier-ignore -->
                  <a
                    href="#"
                    @click.prevent
                    type="button"
                    data-toggle="popover"
                    data-html="true"
                    data-placement="bottom"
                    data-title="
                      Keterangan
                    "
                    :data-content="
                    'Tanggal kembali: ' + moment(kembali.tanggal_kembali).format('DD MMMM YYYY')
                    + '<br/>' + 
                    'Terlambat: ' + kembali.telat + ' Hari'
                    "
                  >{{ kembali.dikembalikan_tanggal | moment("DD MMMM YYYY") }}</a>
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
          <modalUser
            v-for="(info_user, j) in data_peminjaman.data"
            :key="'info_user' + j"
            :parentData="info_user"
          />
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
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import { peminjamanMixin } from "../mixins/peminjamanMixin.js";
import { paginationMixin } from "../mixins/paginationMixin.js";
import modalUser from "./modal/modal-user.vue";
import modalInfo from "./modal/modal-info.vue";

export default {
  mixins: [paginationMixin, peminjamanMixin],

  components: {
    modalUser,
    modalInfo
  },

  mounted() {
    this.fetchPeminjaman({ search_query: "", pengembalian: true });
  },

  updated: function() {
    $(function() {
      $('[data-toggle="popover"]').popover();
    });

    $("body").on("click", function(e) {
      $("[data-toggle=popover]").each(function() {
        // hide any open popovers when the anywhere else in the body is clicked
        if (
          !$(this).is(e.target) &&
          $(this).has(e.target).length === 0 &&
          $(".popover").has(e.target).length === 0
        ) {
          $(this).popover("hide");
        }
      });
    });
  },

  methods: {
    downloadPengembalian() {
      axios.post("api/pengembalian/download", {});
    }
  }
};
</script>
