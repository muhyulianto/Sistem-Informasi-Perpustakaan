export const searchMixin = {
  data() {
    return {
      search_query: null,
      has_notFound: "",
      data_buku: {},
      data_entries: "10",
      has_data_buku: false,
      orderBy: null,
      orderDirection: null
    };
  },

  methods: {
    search(page) {
      this.$store.commit("TOGGLE_LOADING", true);
      axios
        .get("api/data", {
          params: {
            page: page,
            entries: this.data_entries,
            search_query: this.search_query,
            orderBy: this.orderBy,
            orderDirection: this.orderDirection
          },
        })
        .then((response) => {
          this.data_buku = response.data.data_buku;
          this.has_data_buku = true;
          this.data_pagination = this.getPagesArray(
            this.data_buku.total,
            this.data_buku.current_page,
            this.data_buku.per_page
          );
          this.$store.commit("TOGGLE_LOADING", false);
        });
    },
  },
};
