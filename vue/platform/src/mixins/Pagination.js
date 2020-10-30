export const Pagination = {
  data () {
    return {
      pagination: {
        currentPage: 1,
        rowsPerPage: 100,
        counter: 0,
        pages: 0
      }

    }
  },
  methods: {
    paginationStart () {
      this.pagination.pages = this.paginationCount({})
      this.pagination.pages = Math.ceil((this.pagination.pages / this.pagination.rowsPerPage))

      this.paginationVirtualService({
        pageNo: this.pagination.currentPage,
        pageSize: this.pagination.rowsPerPage
      })
    },
    paginationPage (pageNo) {
      this.paginationVirtualService({
        pageNo: pageNo,
        pageSize: this.pagination.rowsPerPage
      })
    },
    paginationFirst () {
      this.pagination.currentPage = 1
      this.paginationVirtualService({
        pageNo: this.pagination.currentPage,
        pageSize: this.pagination.rowsPerPage
      })
    },
    paginationLast () {
      this.pagination.currentPage = this.pagination.counter
      this.paginationVirtualService({
        pageNo: this.pagination.currentPage,
        pageSize: this.pagination.rowsPerPage
      })
    },
    paginationPrev () {
      if (this.pagination.currentPage > 1) {
        this.pagination.currentPage -= 1
        this.paginationVirtualService({
          pageNo: this.pagination.currentPage,
          pageSize: this.pagination.rowsPerPage
        })
      }
    },
    paginationNext () {
      console.debug(`${this.pagination.currentPage} < ${this.pagination.counter}`)

      if (this.pagination.currentPage < this.pagination.counter) {
        this.pagination.currentPage += 1
        this.paginationVirtualService({
          pageNo: this.pagination.currentPage,
          pageSize: this.pagination.rowsPerPage
        })
      }
    },
    paginationCount (condition) {
      return this.reports.length
    },

    paginationQuery (condition, startRow, endRow) {
      var result = []
      condition = {}
      var count = this.paginationCount(condition)

      console.debug(`GET REPORTS FROM ${startRow} AT ${endRow}`, condition)
      result = this.reports.slice(startRow, endRow)
      return result
    },
    paginationVirtualService (params) {
      var result = []
      var condition = {}
      var pageNo = params.pageNo
      var pageSize = params.pageSize
      var pageCount = Math.ceil(this.paginationCount(condition) / pageSize)

      if (pageNo == 0) pageNo = 1
      if (pageNo < 0) pageNo = pageCount
      else if (pageNo > pageCount) pageNo = pageCount
      var startRow = (pageNo - 1) * pageSize + 1
      var endRow = startRow + pageSize - 1
      var data = this.paginationQuery(condition, startRow, endRow)

      // set result
      this.reportsTable = data
      this.pagination.currentPage = pageNo
      this.pagination.counter = pageCount
    }
  }
}
