<template>
  <table :id="tableID" :if="showTable"
    class="display table table-striped table-bordered dt-responsive nowrap" style="width:100%">
        <thead></thead>
        <tbody></tbody>
  </table>
</template>

<script>
export default {
  name: 'table',
  props: {
    paging: {
      type: Boolean,
      required: false,
      default: true
    },
    ordering: {
      type: Boolean,
      required: false,
      default: true
    },
    info: {
      type: Boolean,
      required: false,
      default: true
    },
    showDeleteButton: {
      type: Boolean,
      required: false,
      default: true
    },
    showEditButton: {
      type: Boolean,
      required: false,
      default: true
    },
    showWatchButton: {
      type: Boolean,
      required: false,
      default: true
    },
    showIndex: {
      type: Boolean,
      required: false,
      default: true
    },
    scrollY: {
      type: String,
      required: false,
      default: null
    },
    scrollX: {
      type: Boolean,
      required: false,
      default: false
    },
    responsive: {
      type: Boolean,
      required: false,
      default: true
    }
  },
  created () {
    this.tableID = 'dt-' + (Date.now()).toString(16)
    this.wrapperTableID = this.tableID + '--wrapper'
    console.debug('dt/ ID', this.tableID)
  },
  mounted () {
  },
  data () {
    return {
      showTable: false,
      tableID: null,
      wrapperTableID: null,
      table: null,
      headers: []
    }
  },
  methods: {
    Render (headers, rows = [], columDefs = []) {
      // console.debug('dt/ Render', headers, rows)
      this.headers = headers
      this.AddIndexColumn()
      this.AddActionsColumn()
      var columns = this.GetColums()

      console.debug('ColumDefs', columDefs)
      this.showTable = true
      this.table = $(`#${this.tableID}`).DataTable({
        paging: this.paging,
        ordering: this.ordering,
        info: this.info,
        scrollY: this.scrollY,
        scrollX: this.scrollX,
        language: {
          sLengthMenu: 'Mostrar _MENU_ registros',
          emptyTable: 'No se encontraron datos',
          info: 'Mostrando del _START_ al _END_ de _TOTAL_ resultados',
          infoEmpty: 'Mostrando 0 al 0 de 0 resultados',
          loadingRecords: 'Obteniendo datos...',
          processing: 'Procesando datos...',
          search: 'Buscar:',
          zeroRecords: 'No se encontraron datos',
          paginate: {
            first: 'Primero',
            last: 'Último',
            next: 'Siguiente',
            previous: 'Anterior'
          }
        },
        responsive: true,
        rowGroup: {
          dataSrc: 'group'
        },
        columns: columns,
        data: rows
        // createdRow: function (row, data, index) {
        //   var tableApi = this.api()
        //   var columns = tableApi.settings().init().columns
        //   var tds = $(row).find('td')
        //   tds.each(function (index) {
        //     var $td = $(this)
        //     var columnIndex = tableApi.column(this).index()
        //     var hasWidth = columns[columnIndex].width
        //     if (hasWidth) {
        //       $td.css({
        //         'width': hasWidth,
        //         'max-width': hasWidth,
        //         // 'min-width': hasWidth, // will enforce fixed width, skip if not required
        //         'word-wrap': 'break-word',
        //         'word-break': 'break-all'
        //       })
        //     }
        //   })
        // }
      })

      this.RegisterTableEvents()
      this.RegisterIndexEvent()
      this.RegisterActionEvents()

      this.Refresh()
    },
    RegisterTableEvents () {
      this.table.on('responsive-resize', function (e, datatable, columns) {
        // Table to stack (resize event)
        this.Refresh()
      }.bind(this))

      this.table.on('responsive-display', function (e, datatable, row, showHide, update) {
        this.ResponsiveRecalc()
      }.bind(this))
    },
    RegisterActionEvents () {
      var _this = this // Global this (vue)

      $(`#${this.tableID}`).on('click', '.watchAction', function (e) {
        var row = $(this).parent().parent().parent()
        var data = _this.table.row(row).data()

        // console.debug(`#${_this.tableID} OnWatch`, data)
        _this.$emit('OnWatch', data, row)
      })

      $(`#${this.tableID}`).on('click', '.editAction', function (e) {
        var row = $(this).parent().parent().parent()
        var data = _this.table.row(row).data()

        // console.debug(`#${_this.tableID} OnEdit`, data)
        _this.$emit('OnEdit', data, row)
      })

      $(`#${this.tableID}`).on('click', '.deleteAction', function (e) {
        var row = $(this).parent().parent().parent()
        var data = _this.table.row(row).data()

        // console.debug(`#${_this.tableID} OnDelete`, data)
        _this.$emit('OnDelete', data, row)
      })
    },
    RegisterIndexEvent () {
      if (this.showIndex) {
        this.table.on('order.dt search.dt', function () {
          this.table.column(0, { search: 'applied', order: 'applied' }).nodes().each(function (cell, i) {
            cell.innerHTML = i + 1
          })
        }.bind(this)).draw()
      }
    },
    AddIndexColumn () {
      if (this.showIndex) {
        this.headers.unshift({
          title: '',
          key: null,
          orderable: false,
          searchable: false,
          width: 30,
          class: `${this.tableID}--index`,
          priority: -1
        })
      }
    },
    AddActionsColumn () {
      if (this.showEditButton || this.showDeleteButton || this.showWatchButton) {
        let actionBtn = ''

        if (this.showWatchButton) {
          actionBtn += `<span>
            <i class="cursor icon-small icon universalicon-visible watchAction" style="margin-left:5px;"></i>
          </span>`
        }

        if (this.showEditButton) {
          actionBtn += `<span>
            <i class="cursor icon-small icon universalicon-pencil editAction" style="margin-left:5px;"></i>
          </span>`
        }

        if (this.showDeleteButton) {
          actionBtn += `<span>
            <i class="cursor icon-small icon universalicon-trash-2 deleteAction" style="margin-left:5px;"></i>
          </span>`
        }

        this.headers.push({
          title: 'Acciones',
          key: null,
          default: actionBtn,
          orderable: false,
          searchable: false,
          width: 160,
          priority: -2
        })
      }
    },
    GetColums () {
      var result = this.headers.map(function (x) {
        var item = {}
        item.title = x.title
        item.data = (x.key) ? x.key : null
        item.defaultContent = (x.default) ? x.default : ''
        item.className = (x.class) ? x.class : null
        item.orderable = x.hasOwnProperty('orderable') ? x.orderable : true
        item.searchable = x.hasOwnProperty(x.searchable) ? x.searchable : true
        item.width = x.hasOwnProperty('width') ? x.width : null
        item.responsivePriority = x.hasOwnProperty('priority') ? x.priority : null

        console.debug('dt/ Colum', item)
        return item
      })
      return result
    },
    AddRow (row) {
      this.table.row.add(row).draw()
    },
    RemoveRow (row) {
      this.table
        .row(row)
        .remove()
        .draw()

      console.debug(this.row)
    },
    async AddRows (rows) {
      rows.forEach(row => {
        this.table.row.add(row).draw()
      })
    },
    SetRows (rows) {
      this.Clear()
      this.table.rows.add(rows).draw()
      this.Refresh()
    },
    ShowRow (index, visible) {
      this.table.columns(index).visible(visible)
      this.Refresh()
    },
    Refresh () {
      this.table.columns.adjust().draw()
    },
    Draw () {
      this.table.draw()
    },
    Clear () {
      this.table.clear().draw()
    },
    ResponsiveRecalc () {
      this.table.columns.adjust().responsive.recalc()
    }
  }
}
</script>

<style>

</style>
