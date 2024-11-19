export default {
  handleFilterChange(filters) {
    const filterArray = [];

    for (const key in filters) {
      const filter = filters[key];

      if (filter && filter.value !== null) {
        filterArray.push([key, filter.operator, filter.value]);
      }
    }

    return filterArray;
  },
  cleanParams(params){
    params.filters.length = 0;
    params.itemsPerPage = 8;
    params.currentPage = 1;

    return params;
  }
};
