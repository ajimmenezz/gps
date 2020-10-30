<template>
    <div :id="name">
        <slot/>
    </div>
</template>

<script>
/**
* @vuese
 * @group components/draggable
 * componente draggable-header
 */
export default {
  name: 'draggable-header',
  data: function () {
    return {
      parentID: this.$parent.parentID,
      name: this.$parent.parentID + '-header'
    }
  }
}
</script>

<style>

</style>
