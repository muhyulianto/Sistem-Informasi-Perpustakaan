export const peminjamanMixin = {
  data() {
    return {
      data_peminjaman: {},
      data_entries: 10,
      search_query: null,
      orderBy: null,
      orderDirection: null
    };
  },

  methods: {
    checkRole() {
      if (this.$auth.user().role == 2) {
        return null;
      }
      return this.$auth.user().role;
    },

    async fetchPeminjaman(data) {
      const { page, pengembalian, id_user } = data;
      this.$store.commit("TOGGLE_LOADING", true);
      let tunggu = await this.checkRole();
      axios
        .get("api/peminjaman", {
          // run something here
          params: {
            id: tunggu,
            page: page,
            entries: this.data_entries,
            pengembalian: pengembalian,
            search_query: this.search_query,
            id_user: id_user,
            orderBy: this.orderBy,
            orderDirection: this.orderDirection
          }
        })
        .then(response => {
          this.data_peminjaman = response.data.data_peminjaman;
          this.data_pagination = this.getPagesArray(
            this.data_peminjaman.total,
            this.data_peminjaman.current_page,
            this.data_peminjaman.per_page
          );
          this.$store.commit("TOGGLE_LOADING", false);
        });
    },

    reset() {
      this.search_query = "";
      this.fetchPeminjaman({});
    },

    sort({ orderBy, pengembalian }) {
      this.orderBy = orderBy;
      this.orderDirection = this.orderDirection == "DESC" ? "ASC" : "DESC";
      this.fetchPeminjaman({
        page: this.data_peminjaman.current_page,
        pengembalian: pengembalian
      });
    }
  }
};
