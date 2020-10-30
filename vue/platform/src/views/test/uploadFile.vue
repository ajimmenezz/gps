<template>
<div>
   <input :id="id+'--inputfile'" @change="onSelectedFiles" ref="file" type="file" name="files" style="display: none">
   <button @click="upload()">upload</button>

</div>
</template>

<script>
import { API } from '@/mixins/API'
export default {
  mixins: [API],
  data () {
    return {
      id: 'input',
      files: []
    }
  },
  methods: {
    upload () {
      this.$refs.file.click()
    },
    async onSelectedFiles (sender) {
      var files = sender.target.files
      var filesArr = Array.prototype.slice.call(files)
      for (var i = 0; i < filesArr.length; i++) {
        this.files.push({
          file: filesArr[i],
          name: 'img_' + i
        })
      }

      await this.uploadFile()
    },
    async uploadFile () {
      var formData = new FormData()
      for (var i = 0; i < this.files.length; i++) {
        console.debug('File to add', this.files[i])
        if (this.files[i].file != null) {
          formData.append('files[]', this.files[i].file)
          formData.append('filenames[]', this.files[i].name)
        } else {
          console.debug('Null file')
        }
      }

      console.debug('post', formData)
      var result = await this.postRequest(`/test/uploadFile`, formData)

      if (result.success) {
        alert('Success')
        console.debug('success', result)
      } else {
        alert('fail')
        console.error('fail', result)
      }
    }
  }
}
</script>

<style>

</style>
