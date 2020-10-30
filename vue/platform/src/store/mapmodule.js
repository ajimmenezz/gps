import Vue from 'vue'

export default {
  namespaced: true,
  state: {
    streetview: {
      show: false,
      device: null
    },
    map: {
      cluster: true
    }
  },
  mutations: {
    SHOW_STREET_VIEW (state, device) {
      Vue.set(state.streetview, 'show', true)
      Vue.set(state.streetview, 'device', device)
    },
    CLOSE_STREET_VIEW (state) {
      Vue.set(state.streetview, 'show', false)
      Vue.set(state.streetview, 'device', null)
    },
    MAP_CLUSTER (state, value) {
      Vue.set(state.map, 'cluster', value)
    }
  },
  actions: {
  },
  getters: {
    MAP_CLUSTER (state) {
      return state.map.cluster
    }
  }
}
