<template>
<div class="row">
  <div class="col-6 col-lg-3">
    <m-select
    ref="productTypeSelect"
    :data="productType.catalog"
    filterby="type"
    title="Seleccione tipo de producto"
    @selectionChanged="onProductTypeSelected"></m-select>
  </div>
  <div class="w-100"></div>
  <div class="col-6 col-lg-3" >
    <m-select
    :data="factory.catalog"
    filterby="name"
    title="Seleccione Marca"
    @selectionChanged="onFactorySelected"></m-select>
  </div>
  <div class="col-6 col-lg-3" v-if="model.visible">
     <m-select
    :data="model.catalog"
    filterby="name"
    title="Seleccione Modelo"
    @selectionChanged="onModelSelected"></m-select>
  </div>
  <div class="col-6 col-lg-3">
     <m-autocomplete
     :data="product.store"
     filterby="id"
     title="Seleccione producto"
     @selectionChanged="onProductSelected"/>
  </div>
  <div class="col-6  col-lg-3 align-self-end text-left">
    <button class="btn" v-bind:class="[addProductBtnClass]" @click="addProduct()">Agregar</button>
  </div>
</div>
</template>

<script>
import { API } from '@/mixins/API'
import mAutocomplete from '@/components/basico/m.autocomplete.vue'
import mSelect from '@/components/basico/m.select.vue'
export default {
  name: 'ProductSelector',
  mixins: [
    API
  ],
  components: {
    mAutocomplete,
    mSelect
  },
  data () {
    return {
      productType: {
        catalog: [],
        selected: ''
      },
      factory: {
        catalog: [],
        selected: ''
      },
      model: {
        catalog: [],
        selected: '',
        visible: true
      },
      product: {
        store: [],
        selected: ''
      }
    }
  },
  mounted () {
    this.getProductTypes()
  },
  methods: {
    clearProducts () {
      this.product.store = []
      this.product.selected = ''
    },
    clearModel () {
      this.model.catalog = []
      this.model.selected = ''

      if (this.productType.selected.id == 2) {
        this.model.visible = false
      } else {
        this.model.visible = true
      }

      this.clearProducts()
    },
    clearFactory () {
      this.factory.catalog = []
      this.factory.selected = ''
      this.clearModel()
    },
    async getProductTypes () {
      this.$store.state.loader = true
      var request = await this.getRequest('catalogs/products/types')
      this.productType.catalog = request.data.types
      this.$store.state.loader = false
    },
    async getFactories (productTypeID) {
      this.$store.state.loader = true
      var params = {
        productType: productTypeID
      }
      var request = await this.getRequest('catalogs/products/factories', params)
      this.factory.catalog = request.data.factories
      this.$store.state.loader = false
    },
    async getModels (factoryID) {
      this.$store.state.loader = true
      var params = {
        productType: this.productType.selected.id
      }
      var request = await this.getRequest(`catalogs/products/factories/${factoryID}/models`, params)
      this.model.catalog = request.data.models
      this.$store.state.loader = false
    },
    async getProducts () {
      this.$store.state.loader = true
      var params = {
        productType: this.productType.selected.id,
        factory: this.factory.selected.id,
        onTransfers: false,
        limit: 0
      }

      if (this.productType.selected.id !== 2) {
        params.model = this.model.selected.id
      }

      var request = await this.getRequest(`store`, params)
      this.product.store = request.data.products

      this.$store.state.loader = false
    },
    onProductTypeSelected (productType) {
      this.productType.selected = productType
      this.clearFactory()
      this.getFactories(productType.id)
    },
    onFactorySelected (factory) {
      this.clearModel()
      this.factory.selected = factory

      if (this.productType.selected.id == 2) {
        this.getProducts()
      } else {
        this.getModels(factory.id)
      }
    },
    onModelSelected (model) {
      this.clearProducts()

      this.model.selected = model
      this.getProducts()
    },
    onProductSelected (product) {
      this.product.selected = product
    },
    addProduct () {
      if (this.product.selected) {
        console.debug('OnProductSelected', this.product.selected)
        this.$emit('OnProductSelected', this.product.selected)

        this.$refs.productTypeSelect.selectedItem = ''
        this.clearFactory()
      }
    }

  },
  computed: {
    addProductBtnClass () {
      if (this.product.selected) {
        return 'btn-primary'
      } else {
        return 'btn-secondary'
      }
    }
  }
}
</script>

<style>
</style>
