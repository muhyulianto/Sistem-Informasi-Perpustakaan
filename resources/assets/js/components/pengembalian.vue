<template>
  <div class="row">
    <div class="col">
      <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between">
          <h5 class="card-title mb-0 py-1">Data pengembalian</h5>
          <a href="api/pengembalian/download">Download data pengembalian</a>
        </div>
        <div class="card-body">
          <form
            v-on:submit.prevent="
              fetchPeminjaman({
                search_query: search_query,
                pengembalian: true
              })
            "
            class="input-group"
          >
            <input type="search" class="form-control" v-model="search_query" required />
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
                  >{{ kembali.user.name }}</a>
                </td>
                <td>
                  <a
                    href
                    data-toggle="modal"
                    :data-target="'#info__buku' + kembali.id_buku"
                  >{{ kembali.buku.judul_buku }}</a>
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
          <modalUser
            v-for="(info_user, j) in data_peminjaman.data"
            :key="'info_user' + j"
            :parentData="info_user"
          />
          <div class="modal-info" v-for="(data, h) in data_peminjaman.data" :key="h">
            <modalInfo :key="'info_buku' + h" v-bind:isPeminjaman="true" :parentData="data.buku" />
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
      axios.get("api/pengembalian/download", {});
    }
  }
};
</script>
