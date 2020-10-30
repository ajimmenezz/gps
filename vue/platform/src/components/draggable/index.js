import draggable from './draggable'
import draggableHeader from './draggable.header'
import draggableContent from './draggable.content'
import draggableContentFixed from './draggable.content.fixed'
import draggableBottom from './draggable.bottom'

export default {
  install (Vue) {
    Vue.component('draggable', draggable)
        Vue.component('draggableHeader', draggableHeader)
        Vue.component('draggableContent', draggableContent)
        Vue.component('draggableContentFixed', draggableContentFixed)
        Vue.component('draggableBottom', draggableBottom)
    }

}

export { draggable, draggableContent, draggableContentFixed, draggableHeader, draggableBottom }
