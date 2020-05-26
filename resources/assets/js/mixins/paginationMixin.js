export const paginationMixin = {
  data() {
    return {
      data_pagination: [],
    };
  },

  methods: {
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
          !final.find((_) => _ === pageNumber) ? final.push(pageNumber) : null;
        const addEllipsis = () =>
          !final.find((_) => _ === "...")
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
    },
  },
};
