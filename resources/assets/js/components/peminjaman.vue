<template>
  <div class="row">
    <div class="col">
      <div class="card">
        <div class="card-header">
          <h5 class="card-title mb-0 py-1">Data peminjaman</h5>
        </div>
        <div class="card-body">
          <form
            v-on:submit.prevent="
              fetchPeminjaman({ search_query: search_query })
            "
            class="input-group"
          >
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
                  fetchPeminjaman({ page: data_peminjaman.current_page - 1 })
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
                  fetchPeminjaman({ page: data_peminjaman.current_page + 1 })
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
import { peminjamanMixin } from "../mixins/peminjamanMixin.js";
import modalInfo from "./modal-info.vue";
import modalUser from "./modal-user.vue";

export default {
  mixins: [searchMixin, peminjamanMixin],

  components: {
    modalInfo,
    modalUser
  },

  data() {
    return {
      data_peminjaman: {},
      search_query: ""
    };
  },

  mounted() {
    this.fetchPeminjaman({});
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
