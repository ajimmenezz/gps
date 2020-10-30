<template>
    <div :id="name" class="draggable--bottom">
        <slot/>
    </div>
</template>

<script>
/**
* @vuese
 * @group components/draggable
 * componente draggable-bottom
 */
export default {
  name: 'draggable-bottom',
  data: function () {
    return {
      parentID: this.$parent.parentID,
      name: this.$parent.parentID + '-bottom'
    }
  }

}
</script>

<style>

</style>
