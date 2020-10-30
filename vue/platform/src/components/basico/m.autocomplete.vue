<template>
    <div class="form-group text-left" style="margin-bottom:10px;">
      <label>{{title}}</label>
      <input class="form-control" type="text"
        ref="input"
        v-model="query"
        @keydown.up="up"
        @keydown.down="down"
        @keydown.enter="close()"
        placeholder="Seleccione"
        @click="show(true), autoClearSelection()"
        @blur="close()"
        >
      <div class="popover options" ref="optionsList" v-show="visible">
        <ul @mouseleave="close()">
          <li v-for="(match, index) in matches"
            :key="index"
            @click="itemClicked(index)"
            v-text="match[filterby]"></li>
        </ul>
      </div>
    </div>
</template>

<script>
// inpiration https://github.com/AfikDeri/VueJS-Autocomplete/blob/master/src/components/Autocomplete.vue
export default {
  name: 'MAutocomplete',
  props: {
    data: {
      type: Array,
      required: true
    },
    filterby: {
      type: String,
      required: true
    },
    title: {
      default: 'Seleccione',
      type: String
    },
    resetOnClick: {
      type: Boolean,
      default: false
    }
  },
  data () {
    return {
      itemHeight: 39,
      selectedItem: null,
      selectedIndex: -1,
      query: '',
      visible: false
    }
  },
  methods: {
    autoClearSelection () {
      if (this.resetOnClick) { this.clearSelection() }
    },
    clearSelection () {
      this.selectedIndex = -1
      this.query = ''
      this.selectedItem = null

      //   console.debug('selectionChanged', this.selectedItem)
      this.$emit('selectionChanged', this.selectedItem)
    },
    close () {
      setTimeout(() => {
        if (this.visible) {
          console.debug('close and searchItem')
          this.searchItem()
        }
      }, 250)
    },
    show (show) {
      setTimeout(() => {
        this.visible = show
      }, 50)
    },
    itemClicked (index) {
      console.debug(`ItemClick`, index)
      //   this.selectedIndex = index
      this.selectedItem = this.matches[index]
      this.query = this.selectedItem[this.filterby]
      this.show(false)

      //   console.debug('selectionChanged', this.selectedItem)
      this.$emit('selectionChanged', this.selectedItem)
    },
    searchItem () {
      try {
        console.debug('searchItem')
        if (this.matches.length == 1) {
          this.selectedItem = this.matches[0]
          this.query = this.selectedItem[this.filterby]
        } else {
          this.selectedItem = null
          this.query = ''
        }
      } catch (err) {
        this.selectedItem = null
        this.query = ''
      }

      this.show(false)
      this.$refs.input.blur()
      //   console.debug('selectionChanged', this.selectedItem)
      this.$emit('selectionChanged', this.selectedItem)
    },
    up () {
      if (this.selectedIndex == 0) {
        return
      }
      this.selectedIndex -= 1
      this.scrollToItem()
    },
    down () {
      if (this.selectedIndex >= this.matches.length - 1) {
        return
      }
      this.selectedIndex += 1
      this.scrollToItem()
    },
    scrollToItem () {
      this.$refs.optionsList.scrollTop = this.selectedIndex * this.itemHeight
    }
  },
  computed: {
    matches () {
      try {
        if (this.query === '') {
          return this.data
        }

        return this.data.filter((item) => item[this.filterby].toLowerCase().includes(this.query.toLowerCase()))
      } catch (err) {
        return this.data
      }
    }
  },
  watch: {
    data () {
      this.clearSelection()
    }
  }
}
</script>

<style scoped>
.popover{
    /* margin-top: 5px; */
    border-radius: 0px;
    border: 1px solid lightgray;
}
.options {
    width: 90%;
    max-height: 150px;
    overflow-y: scroll;
    margin-top: 70px;
    margin-left: 15px;
}
.options ul {
    list-style-type: none;
    text-align: left;
    padding-left: 0;
}
.options ul li {
    border-bottom: 1px solid lightgray;
    padding: 10px;
    cursor: pointer;
    background: white;
}
.options ul li:first-child {
    border-top: 2px solid #d6d6d6;
}
.options ul li:hover {
    background: #04a9f5;
    color: #fff;
}
</style>
