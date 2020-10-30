import Vue from 'vue'

export default {
  namespaced: true,
  state: {
    modal: {
      isVisible: false,
      component: null
    }
  },
  mutations: {
    ADD_COMPONENT_DINAMIC (state, dat) {
      state.modal.component = dat
    },
    ADD_COMPONENT_DINAMIC_STATE (state, dat) {
      state.modal.isVisible = dat
    }
  },
  actions: {

  },
  getters: {
    Modal (state) {
      return state.modal.component
    },
    isVisibleModal (state) {
      return state.modal.isVisible
    }
  }
}

/*
EVENTS
DEVICE_ADDED
DEVICE_POSITION_CHANGED
DEVICE_CONNECTION_CHANGED

*/
