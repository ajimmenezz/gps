<template>
<div class="alert-warning">
    <div>COMPONENTE B</div>
    <component-c></component-c>
</div>
</template>

<script>
import componentC from '@/views/test/MapModule/c.component'
export default {
  components: {
    componentC
  }
}
</script>

<style>

</style>
