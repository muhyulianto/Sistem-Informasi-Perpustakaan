<template>
  <div class="col-md-8 offset-md-2">
    <div class="card mt-5 shadow-sm">
      <div class="card-header">
        <div class="card-title">
          <h3><i class="fa fa-book" aria-hidden="true"></i> Perpustakaan</h3>
        </div>
      </div>
      <div class="card-body">
        <form @submit.prevent="search" class="input-group">
          <input
            type="search"
            class="form-control"
            v-model="search_query"
            required
          />
          <span class="input-group-btn">
            <button class="btn btn-primary" type="submit">
              <span class="fa fa-search" aria-hidden="true"></span> Search!
            </button>
          </span>
        </form>
      </div>
    </div>
    <div class="card my-5 shadow-sm" v-if="has_data_buku == true">
      <div class="card-body">
        <table class="table table-no-border-top">
          <thead>
            <tr>
              <th>No</th>
              <th class="col-lg-10">Nama buku</th>
              <th>Info</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(buku, i) in data_buku.data" v-bind:key="i">
              <td>{{ data_buku.from + i }}</td>
              <td>{{ buku.judul_buku }}</td>
              <td>
                <button
                  class="btn btn-primary btn-sm px-4"
                  data-toggle="modal"
                  :data-target="'#info__buku' + buku.id"
                >
                  Info
                </button>
              </td>
            </tr>
          </tbody>
        </table>
        <dataModal__info
          v-for="(buku, i) in data_buku.data"
          :key="'info' + i"
          :parentData="buku"
        />
        <ul class="pagination" v-if="data_buku.last_page > 1">
          <li class="page-item">
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
          <li class="page-item">
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
    <div class="alert alert-danger" v-if="has_notFound == true">
      <a
        href="#"
        class="close"
        data-dismiss="alert"
        aria-label="close"
        @click="has_notFound = false"
        >&times;</a
      >
      {{ notFound.kosong }}
    </div>
  </div>
</template>

<script>
import { searchMixin } from "../mixins/searchMixin.js";
import dataModal__info from "./modal-info.vue";

export default {
  mixins: [searchMixin],

  components: {
    dataModal__info
  }
};
</script>
