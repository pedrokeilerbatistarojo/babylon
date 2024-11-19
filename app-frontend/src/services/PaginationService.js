export default {
  getPaginationData(pagination) {
    let next = null;
    let prev = null;

    if (
      pagination.lastPage > 1 &&
      pagination.currentPage < pagination.lastPage
    ) {
      next = pagination.currentPage + 1;
    }

    if (pagination.lastPage > 1 && pagination.currentPage > 1) {
      prev = pagination.currentPage - 1;
    }

    return {
      sortBy: null,
      descending: false,
      page: pagination.currentPage,
      rowsPerPage: pagination.itemsPerPage,
      rowsNumber: pagination.total,
      totalPages: pagination.lastPage,
      next: next,
      prev: prev,
    };
  },
  getNomenclatureItemsPerPage(){
    return 1000;
  }
};
