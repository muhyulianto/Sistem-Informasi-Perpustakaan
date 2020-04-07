export const searchMixin = {
  data() {
    return {
      search_query: "",
      has_notFound: "",
      data_buku: {},
      data_pagination: [],
      data_entries: "10",
      has_data_buku: false
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
            search_query: this.search_query
          }
        })
        .then(response => {
          this.data_buku = response.data.data_buku;
          this.has_data_buku = true;
          this.data_pagination = this.getPagesArray(
            this.data_buku.total,
            this.data_buku.current_page,
            this.data_buku.per_page
          );
          this.$store.commit("TOGGLE_LOADING", false);
        })
    },

    getPagesArray(numberOfItems, currentPage, itemsPerPage) {
      const groupSize = 3;
      const numberOfPages = Math.ceil(numberOfItems / itemsPerPage);
      const pageList = [...Array(numberOfPages).keys()];

      return pageList.reduce((final, index) => {
        const pageNumber = index + 1;
        const isOneOfFirstPages =
          currentPage <= groupSize + 1 && pageNumber <= groupSize + 2;
        const isOneOfLastPages =
          currentPage >= numberOfPages - groupSize &&
          pageNumber >= numberOfPages - groupSize - 1;
        const isFirstPage = pageNumber === 1;
        const isLastPage = pageNumber === numberOfPages;
        const isCurrentPage = pageNumber === currentPage;
        const isCurrentEdgeBefore = pageNumber + 1 === currentPage;
        const isCurrentEdgeAfter = pageNumber - 1 === currentPage;

        const addPage = () =>
          !final.find(_ => _ === pageNumber) ? final.push(pageNumber) : null;
        const addEllipsis = () =>
          !final.find(_ => _ === "...")
            ? final.push("...")
            : Number.isInteger(final[final.length - 1])
            ? final.push("...")
            : null;

        if (
          isOneOfFirstPages ||
          isOneOfLastPages ||
          isFirstPage ||
          isLastPage ||
          isCurrentPage ||
          isCurrentEdgeBefore ||
          isCurrentEdgeAfter
        ) {
          addPage();
        } else {
          addEllipsis();
        }

        return final;
      }, []);
    }
  }
};
