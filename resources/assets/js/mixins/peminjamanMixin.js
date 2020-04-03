export const peminjamanMixin = {
  methods: {
    fethUser() {
      return axios
        .get("api/auth/user", {
          params: {}
        })
        .then(response => {
          if (response.data.data.role == 2) {
            return null;
          }
          return response.data.data.id;
        });
    },

    async fetchPeminjaman(data) {
      const { search_query, page, pengembalian } = data;
      this.$store.commit("TOGGLE_LOADING", true);
      let tunggu = await this.fethUser();
      axios
        .get("api/peminjaman", {
          // run something here
          params: {
            id: tunggu,
            page: page,
            pengembalian: pengembalian,
            search_query: search_query
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
