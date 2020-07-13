<template>
  <div class="row">
    <div class="col">
      <div class="card shadow-sm">
        <div class="card-header d-flex flex-wrap align-items-end">
          <div class="card-title font-weight-bold text-uppercase m-0">
            Data user perpustakaan
          </div>
          <button class="btn btn-secondary btn-sm ml-auto" @click="reset()">
            Reset pencarian
          </button>
          <form v-on:submit.prevent="fetchUser()" class="input-group w-25 ml-2">
            <input
              type="search"
              class="form-control form-control-sm"
              v-model="search_query"
              required
            />
            <span class="input-group-btn">
              <button class="btn btn-primary btn-sm" type="submit">
                <span class="fa fa-search" aria-hidden="true"></span> cari
              </button>
            </span>
          </form>
        </div>
        <div class="card-body">
          <table class="table">
            <thead>
              <tr>
                <th class="border-top-0" style="width: 5%">No</th>
                <th class="border-top-0">Nama user</th>
                <th class="border-top-0">Email</th>
                <th class="border-top-0">Kelas</th>
                <th class="border-top-0" style="width: 10%">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(user, i) in users.data" :key="i">
                <td>
                  {{ users.from + i }}
                </td>
                <td>
                  {{ user.name }}
                </td>
                <td>
                  {{ user.email }}
                </td>
                <td>
                  {{ user.kelas }}
                </td>
                <td>
                  <router-link
                    :to="{ name: 'userShow', params: { id: user.id } }"
                    class="btn btn-sm btn-primary"
                    >Detail</router-link
                  >
                </td>
              </tr>
            </tbody>
          </table>
          <div class="row justify-content-between align-items-center">
            <div class="col-lg-3">
              <div class="d-flex align-items-center ml-auto">
                <div>Display</div>
                <select
                  v-model="entries"
                  class="form-control form-control-sm mx-2"
                  id="entry-show"
                  @change="fetchUser()"
                >
                  <option value="5">5</option>
                  <option value="10">10</option>
                  <option value="20">20</option>
                </select>
                <div>Entries</div>
              </div>
            </div>
            <div class="col-lg-4">
              <div class="d-flex justify-content-end align-items-center">
                <ul class="pagination m-0" v-if="users.last_page > 1">
                  <li
                    :class="
                      users.current_page - 1 < 1
                        ? 'page-item disabled'
                        : 'page-item'
                    "
                  >
                    <a
                      class="page-link"
                      href="#"
                      @click.prevent="fetchUser(users.current_page - 1)"
                    >
                      <span class="fa fa-angle-double-left"></span>
                    </a>
                  </li>
                  <li
                    v-for="(halaman, i) in data_pagination"
                    v-bind:key="i"
                    :class="
                      users.current_page == halaman
                        ? 'page-item active'
                        : 'page-item'
                    "
                  >
                    <a
                      class="page-link"
                      href="#"
                      @click.prevent="
                        users.current_page == halaman
                          ? ''
                          : halaman == '...'
                          ? ''
                          : fetchUser(halaman)
                      "
                      >{{ halaman }}</a
                    >
                  </li>
                  <li
                    :class="
                      users.current_page + 1 > users.last_page
                        ? 'page-item disabled'
                        : 'page-item'
                    "
                  >
                    <a
                      class="page-link"
                      href="#"
                      @click.prevent="fetchUser(users.current_page + 1)"
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
  </div>
</template>

<script>
import { paginationMixin } from "../mixins/paginationMixin.js";

export default {
  mixins: [paginationMixin],

  data() {
    return {
      users: {},
      search_query: "",
      entries: 10
    };
  },

  mounted() {
    this.fetchUser();
  },

  methods: {
    fetchUser(page) {
      this.$store.commit("TOGGLE_LOADING", true);
      axios
        .get("/api/users", {
          params: {
            page: page,
            search_query: this.search_query,
            entries: this.entries
          }
        })
        .then(response => {
          this.users = response.data.users;
          this.data_pagination = this.getPagesArray(
            this.users.total,
            this.users.current_page,
            this.users.per_page
          );
          this.$store.commit("TOGGLE_LOADING", false);
        });
    }
  }
};
</script>
