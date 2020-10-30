<template>
<div class="container">
    <div class="row" style="margin-top:50px;">
        <div class="col-3" style="min-height:500px;"><loader-small v-if="showLoader" :message="message"/>Lorem ipsum dolor sit amet consectetur adipisicing elit. Facere, sapiente cupiditate? Excepturi deserunt repellat molestiae voluptatum maiores et aliquid numquam explicabo cupiditate saepe, quod reprehenderit repellendus. Dicta corrupti inventore veniam?</div>
        <div class="col-3">Lorem ipsum dolor sit amet consectetur adipisicing elit. Aperiam dolores modi accusamus molestiae voluptatem quo, a debitis ab labore sint doloribus libero hic repellendus minus, aspernatur maxime doloremque ipsam rem?</div>
        <div class="col-3">Lorem ipsum dolor sit amet consectetur adipisicing elit. Quae nostrum tempore error, neque, expedita non ut labore explicabo facere excepturi, assumenda cum. Magni molestias officia maxime voluptatum optio quod reiciendis!</div>
        <div class="col-3">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Recusandae veniam vero voluptates tempora iure quos nihil eum soluta rem delectus nisi sunt expedita molestias perferendis aspernatur saepe facilis, numquam officiis.</div>
        <div class="col-12" >
            <button @click="showLoader = !showLoader">SHOW LOADER</button>
            <input type="text" v-model="message" />
        </div>
    </div>
</div>
</template>

<script>
import loaderSmall from '@/components/loader/loader.small.vue'
export default {
  components: { loaderSmall },
  data () {
    return {
      showLoader: false,
      message: ''
    }
  },
  mounted () {
    console.debug('Show Component Loader')
  }
}
</script>

<style>

</style>
