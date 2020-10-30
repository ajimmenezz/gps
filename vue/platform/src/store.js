import Vue from 'vue'
import Vuex from 'vuex'

import websocket from '@/store/websocket'
import devices from '@/store/devices'
import test from '@/store/test'
import mapModule from '@/store/mapmodule'
import { isMobile, isTablet, isMobileOnly, isBrowser } from 'mobile-device-detect'

Vue.use(Vuex)

export default new Vuex.Store({
  state: {
    appVersion: JSON.parse(unescape(process.env.PACKAGE_JSON || '%7B%7D')).version,
    apiUrl: process.env.VUE_APP_API_URL,
    imgLogo: null,
    paramNameUser: null,
    isFirstTimeLogin: null,
    loading: true,
    islogged: false,
    loginTimeFirst: null,
    userType: null,
    clientType: null,
    showDasboard: false,
    typeUserMenu: null,
    showMenu: false,
    widthMenu: null,
    topMenu: null,
    seccionMenu: null,
    toogleSubmenuStatus: 0,
    submenuActive: null,
    itemSubmenuActive: null,
    permissions: null,
    permissionsAdmin: null,
    loader: false,
    modal: {
      isVisible: false,
      component: null,
      datosDymanic: {}
    },
    modaloader: {
      isVisible: false,
      component: null,
      datosDymanic: {}
    },
    menu: {
      widthMenu: null,
      topMenu: null,
      leftMenu: null
    },
    draggableContentForm: {
      top: 0,
      left: 0,
      index: 0
    },
    typeDevice: {
      mobile: isMobile,
      tablet: isTablet,
      mobileOrTable: isMobileOnly,
      web: isBrowser,
      isHorizontal: false
    },
    pruebas: true,
    Getlogo: localStorage.getItem('imgLogo')
  },
  mutations: {
    SuccessLogin (state, payload) {
      state.loading = false
      state.islogged = true
      state.isFirstTimeLogin = payload.session.isFirstTimeLogin
      state.userType = payload.session.userType
      state.clientType = payload.session.clientType
    },
    showMenu (state, show) {
      state.showMenu = show
    },
    menuOptions (state, permissions) {
      state.permissions = permissions
    },
    FailLogin (state, payload) {
      state.loading = false
      state.islogged = false
    },
    loginFirstTime (state, dat) {
      state.loginTimeFirst = dat
    },
    ADD_COMPONENT_DINAMIC (state, dat) {
      state.modal.component = dat.component
      state.modal.datosDymanic = dat.datos
      // state.modal.deviceImei = dat.device
      // state.modal.stateParoMotor = dat.stateMotor
    },
    ADD_COMPONENT_DINAMIC_STATE (state, dat) {
      state.modal.isVisible = dat
    },
    CLEAR_MODAL_DINAMIC (state) {
      state.modal.isVisible = false
      state.modal.component = null
      state.modal.datosDymanic = {}
    },
    ADD_COMPONENT_DINAMIC_modaloader (state, dat) {
      state.modaloader.component = dat.component
      state.modaloader.datosDymanic = dat.datos
      // state.modaloader.deviceImei = dat.device
      // state.modaloader.stateParoMotor = dat.stateMotor
    },
    ADD_COMPONENT_DINAMIC_STATE_modaloader (state, dat) {
      state.modaloader.isVisible = dat
    },
    CLEAR_MODAL_DINAMIC_modaloader (state) {
      state.modaloader.isVisible = false
      state.modaloader.component = null
      state.modaloader.datosDymanic = {}
    },
    logOut_session (state) {
      sessionStorage.clear()
    },
    CLEAR_STORE (state) {
      state.isFirstTimeLogin = null
      state.loading = true
      state.islogged = false
      state.loginTimeFirst = null
      state.showMenu = false
      state.permissions = null
    }
  },
  actions: {
    async SuccessLogin (context, data) {
      context.commit('SuccessLogin', data)
      // await context.dispatch('devices/LOAD_DEVICES', data.devices)
    },
    async showMenu (context, show) {
      context.commit('showMenu', show)
    },
    async FailLogin (context, data) {
      context.commit('FailLogin', data)
    },
    async loginFirstTime (context, data) {
      context.commit('loginFirstTime', data)
    },
    async LOAD_LIST_DEVICES (context) {
      await context.dispatch('devices/LOAD_DEVICES', null)
    },
    async LogOut (context) {
      await context.commit('CLEAR_STORE')
      await context.commit('CLEAR_MODAL_DINAMIC')
      await context.dispatch('devices/CLEAR_STORE')

      await context.commit('logOut_session')
    }
  },
  getters: {
    appVersion (state) {
      return state.appVersion
    },
    isLogged (state) {
      return state.islogged
    },
    getloginFirstTime (state) {
      return state.loginTimeFirst
    },
    isMenuVisible (state) {
      return state.showMenu
    },
    Modal (state) {
      return state.modal.component
    },
    isVisibleModal (state) {
      return state.modal.isVisible
    },
    permission: (state) => (id) => {
      var index = state.permissions.findIndex(x => x.id == id)

      if (index == -1) {
        return false
      } else {
        return true
      }
    },
    permissionAdmin: (state) => (id) => {
      var index = state.permissionsAdmin.findIndex(x => x.id == id)

      if (index == -1) {
        return false
      } else {
        return true
      }
    }

  },
  modules: {
    devices: devices,
    test: test,
    ws: websocket,
    mapModule: mapModule
  }
})
