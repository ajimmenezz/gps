<template>
  <div class="container-fluid" style="margin-top:15px; margin-bottom:5px;">
    <!--Header-->
    <div class="row">
      <div class="col-8 text-left">
        <h5>Dispositivos</h5>
      </div>
      <div class="col-4 text-right">
        <i
          class="icon icon-small universalicon-help cursor test"
          data-toggle="tooltip"
          data-placement="bottom"
          data-delay='{"show":500, "hide":1000}'
          data-html="true"
          data-template='<div class="tooltip fluid" role="tooltip"><div class="arrow"></div><div class="tooltip-inner"></div></div>'
          title='<div class="alert-info text-left" style="padding:5px 10px;">
            El semaforo indica el tiempo del ultimo reporte de la unidad:
            <br />
            <span class="badge badge-pill badge-success">&nbsp;</span> Menos 12 horas
            <br />
            <span class="badge badge-pill badge-warning">&nbsp;</span> Menos 24 horas
            <br />
            <span class="badge badge-pill badge-danger">&nbsp;</span> Mas de 24 horas
          </div>'
        >&nbsp;</i>
      </div>
    </div>

    <!--Search Panel-->
    <div class="row" style="margin-top: 5px;">
      <div class="col-10">
        <div class="form-group" style="margin-bottom:0.5rem">
          <input
            type="text"
            class="form-control classdisabled toupperCase"
            style="padding:6px 12px"
            placeholder="Buscar por unidad o flotilla"
            @input="FilterDeviceList()"
            v-model="deviceList.searchTerm"
          />
        </div>
      </div>
      <div class="col-2 col-fluid text-left">
        <i
          class="icon-md universalicon-target-fixed cursor-pointer"
          @click="LocateAllDevices()"
          data-toggle="tooltip"
          data-placement="bottom"
          data-delay="500"
          title="Localizar todas las unidades"
        >&nbsp;</i>
      </div>
      <transition name="fade">
      <div class="col-12" v-show="helper.showResetDeviceListButton">
         <span class="badge badge-pill badge-info cursor-pointer"
         @click="ResetDeviceListFilter()">
          Mostrar todas las unidades
        </span>
      </div>
      </transition>
      <div class="col-12">
        <hr />
      </div>
    </div>

    <!--Device list-->
    <div class="row" style="overflow-y:auto; max-height:200px;">
      <div class="col-12">
        <div class="row" v-for="fleet in deviceList.filteredList" :key="fleet.id">
          <div
            class="col-9 text-left custom-control custom-checkbox"
            style="margin-left:10px; word-break: break-all;"
          >
            <input
              :id="`fleetCheckbox-${fleet.id}`"
              type="checkbox"
              class="custom-control-input cursor-pointer"
              :checked="fleet.selected"
              @input="OnFleetSelectionChanged(fleet.id, $event.target.checked)"
            />
            <label class="custom-control-label cursor-pointer" :for="`fleetCheckbox-${fleet.id}`"></label>
            <span
              class="cursor-pointer"
              @click="ToggleCollapseFleet(fleet.id)"
            >
              <small style="margin-left:10px;">{{fleet.name}}</small>
              <i
                :id="`fleet-${fleet.id}-collapse-icon`"
                class="icon-small universalicon-arrow-collapse"
                style="position: absolute; bottom: -2px; margin-left: 6px;"
              >&nbsp;</i>
            </span>
          </div>
          <div class="col-2">
            <i
              class="icon icon-small universalicon-target-fixed cursor-pointer"
              @click="LocateFleet(fleet.id)"
              data-toggle="tooltip"
              data-placement="bottom"
              data-delay="500"
              title="Localizar unidades de la flotilla"
              v-show="fleet.selected"
            ></i>
          </div>

          <div :id="`fleet-${fleet.id}`" class="col-12 collapse show">
            <ul class="list-group list-group-flush" v-if="fleet.devices.length > 0">
              <li class="list-group-item" v-for="device in fleet.devices" :key="device.imei">
                <div class="row">
                  <div class="col-1 col-fluid">
                    <div class="custom-control custom-checkbox" style="display:inline-block">
                      <input
                        :id="`deviceCheckbox-${device.id}`"
                        type="checkbox"
                        data-type="device"
                        class="custom-control-input cursor-pointer"
                        :checked="device.selected"
                        @input="OnDeviceSelectionChanged(device.id, $event.target.checked, fleet.id)"
                      />
                      <label
                        class="custom-control-label cursor-pointer"
                        :for="`deviceCheckbox-${device.id}`"
                      ></label>
                    </div>
                  </div>
                  <div class="col-8 text-left col-fluid">
                    <div style="display:inline-block; margin-left:5px; margin-right:15px;">
                      <span
                        class="dot"
                        style="position: absolute; top: 6px;"
                        :class="[ device.locationStatus == 1 ? 'bg-success' : '', device.locationStatus == 2 ? 'bg-warning' : '', device.locationStatus == 3 ? 'bg-danger' : '' ]"
                      >&nbsp;</span>
                    </div>
                    {{device.alias}}
                  </div>

                  <div class="col-3 col-fluid text-right">
                    <i
                      class="icon icon-small universalicon-target-fixed cursor-pointer"
                      @click="LocateDevices([device.imei])"
                      data-toggle="tooltip"
                      data-placement="bottom"
                      data-delay="500"
                      title="Localizar unidad"
                    >&nbsp;</i>
                    <i
                      v-if="deviceList.actionButtons.setEngine"
                      class="icon icon-small universalicon-shutdown cursor-pointer"
                      @click="SetEngine(device.id)"
                      data-toggle="tooltip"
                      data-placement="bottom"
                      data-delay="500"
                      title="Realizar paro o encendido de motor"
                    >&nbsp;</i>

                    <!--NOTE: If add more than 2 icons you'll need put into a context-menu -->
                  </div>
                </div>
              </li>
            </ul>
            <div class="float-center" v-else>
              <small>Sin Dispositivos</small>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!--footer-->
    <div class="row">
      <div class="col-12">
        <hr />
      </div>
      <div class="col-4">
        <span
          class="badge badge-pill"
          :class="[this.deviceList.totalSelected === 1 ? 'badge-info':'badge-secondary',
        this.deviceList.totalSelected === 1 ? 'cursor-pointer':'cursor-not-allowed']"
          @click="ShowDeviceRoutePanel()"
        >
          <i class="icon universalicon-polyline"></i> Recorrido
        </span>
      </div>
      <div class="col-8 text-right">
        <div v-show="this.deviceList.totalSelected > 0">
          <span class="badge badge-pill badge-info">{{this.deviceList.totalSelected}}</span> Seleccionados
        </div>
        <div v-show="this.deviceList.totalSelected < 1">
          <span
            class="badge badge-pill badge-success cursor-pointer"
            @click="FilterDeviceListByReportState(true)"
            data-toggle="tooltip"
            data-placement="top"
            data-delay="500"
            title="Unidades ubicadas"
          >{{this.$store.getters['devices/TOTAL_LOCATE']}}</span>

          <span
            class="badge badge-pill badge-danger cursor-pointer"
            @click="FilterDeviceListByReportState(false)"
            style="margin-left:15px;"
            data-toggle="tooltip"
            data-placement="top"
            data-delay="500"
            title="Unidades sin ubicar"
          >{{this.$store.getters['devices/TOTAL_DISLOCATE']}}</span>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import EventBus from '@/EventBus'
export default {
  name: 'DevicePanel',
  data () {
    return {
      map: null,
      helper: {
        showResetDeviceListButton: false
      },
      deviceList: {
        searchTerm: null,
        list: [],
        filteredList: [],
        totalSelected: 0,
        filterByReportStatus: null,
        actionButtons: {
          setEngine: this.$store.getters.permission(4)
        }
      }
    }
  },
  inject: [
    'getMap',
    'showDeviceInfo',
    'closeDeviceInfo',
    'loadDynamicComponent',
    'onDevicesSelected'
  ],
  mounted () {
    /** TODO:
     * Hacer boton de paro motor condicional (mostrar para algunos users)
     * Centrar mapa en seleccion
     *  */
    this.InitializeDeviceList()
    this.DeviceReportStateControl()
    this.RegisterTooltip()
    this.UpdateTotalDevicesSelected()
    this.SuscribeDeviceEvents()
  },
  beforeDestroy () {
    this.UnsuscribeDeviceEvents()
  },
  methods: {
    SuscribeDeviceEvents () {
      this.map = this.getMap()
      console.debug('SuscribeToMapEvents', this.map)

      EventBus.$on('MapModule_OpenInfowindowsDevices', (id) => {
        this.ClearDeviceSelection()
        var device = this.deviceList.list
          .flatMap((fleet) => fleet.devices)
          .find((device) => device.imei === id)
        this.OnDeviceSelectionChanged(device.id, true, device.fleetID)
      })

      EventBus.$on('MapModule_CloseInfowindowsDevices', (id) => {
        var device = this.deviceList.list
          .flatMap((fleet) => fleet.devices)
          .find((device) => device.imei === id)
        this.OnDeviceSelectionChanged(device.id, false, device.fleetID)
      })

      EventBus.$on('Ws_LOCATE_SELECT', (payload) => {
        console.debug('DeviceListPanel', 'WSLocateSelect', payload)
      })
      EventBus.$on('deviceList_locationsStatusDevices', (id) => {
        console.debug('DeviceListPanel', 'DeviceListLocationStatusDevices', id)
      })
      EventBus.$on('openInfowindowsDevicesROUTER', (id) => {
        console.debug('DeviceListPanel', 'openInfoWindowsDevicesROUTER', id)
      })

      EventBus.$on('EventGetbuscador', (data) => {
        console.debug('DeviceListPanel', 'EventGetBuscador', data)
        this.deviceList.searchTerm = data
        this.FilterDeviceList()
      })
    },
    UnsuscribeDeviceEvents () {
      EventBus.$off('MapModule_CloseInfowindowsDevices')
      EventBus.$off('MapModule_OpenInfowindowsDevices')
      EventBus.$off('Ws_LOCATE_SELECT')
      EventBus.$off('deviceList_locationsStatusDevices')
      EventBus.$off('openInfowindowsDevicesROUTER')
    },
    RegisterTooltip () {
      jQuery(document).ready(function () {
        jQuery('[data-toggle="tooltip"]').tooltip()
      })
    },
    LocateAllDevices () {
      var imei = []
      Object.values(this.$store.state.devices.devices).forEach((device) => {
        imei.push(device.imei)
      })

      this.LocateDevices(imei)
    },
    LocateFleet (fleetID) {
      var imei = []
      Object.values(this.$store.state.devices.devices).filter((device) => {
        if (device.fleetID === fleetID) {
          imei.push(device.imei)
        }
      })

      this.LocateDevices(imei)
    },
    LocateDevices (arrImei) {
      console.debug('LocateDevices', arrImei)
      if (this.$store.state.ws.connected) {
        arrImei.forEach((imei) => {
          var payload = {
            imei: imei
          }
          this.$store.dispatch('ws/LOCATE', payload)
        })

        var message = `<b>Localizar unidades</b><br>
        El comando se ha enviado a las unidades`

        if (arrImei.length === 1) {
          message = `<b>Localizar unidad</b><br>
        El comando se ha enviado a la unidad`
        }

        notify(
          '',
          message,
          'top',
          'right',
          'dark',
          340,
          this.$store.state.menu.topMenu
        )
      } else {
        notify(
          '<b>Servidor fuera de linea</b><br>',
          'No podemos realizar la peticion en este momento, porfavor intente mas tarde',
          'top',
          'right',
          'danger',
          340,
          this.$store.state.menu.topMenu
        )
      }
    },
    async SetEngine (deviceID) {
      this.$store.commit('CLEAR_MODAL_DINAMIC')
      var device = this.deviceList.list
        .flatMap((fleet) => fleet.devices)
        .find((device) => device.id === deviceID)

      var datos = {
        component: () => import('@/views/Modals/modalParoMotor'),
        datos: {
          deviceImei: device.imei,
          stateParoMotor: false,
          topMenu: 0,
          leftMenu: 0
        }
      }

      await this.$store.commit('ADD_COMPONENT_DINAMIC', datos)
      await this.$store.commit('ADD_COMPONENT_DINAMIC_STATE', true)
    },
    InitializeDeviceList () {
      this.$store.state.devices.fleets.forEach((item) => {
        var devices = Object.values(this.$store.state.devices.devices).filter(
          (device) => device.fleetID === item.id
        )

        var fleet = {
          id: item.id,
          name: item.name,
          devices: devices,
          collapsed: false,
          selected: false
        }

        console.debug('Fleet', fleet.name, fleet.devices)
        this.deviceList.filteredList.push(fleet)
        this.deviceList.list.push(fleet)

        var allDeviceSelected = this.HasFleetAllDevicesSelected(fleet.id)
        fleet.selected = allDeviceSelected
      })
    },
    DeviceReportStateControl () {
      this.UpdateDeviceLocationStatus() // Update FirstTime

      var interval = 60000 // Each Minute
      setInterval(this.UpdateDeviceLocationStatus, interval)
    },
    UpdateDeviceLocationStatus () {
      Object.values(this.$store.state.devices.devices).forEach((device) => {
        var maxGreenState = 43200 // up 12 Hrs
        var maxYellowState = 86400 // up 24 Hrs
        var timestampNow = Math.floor(Date.now() / 1000)

        var diffTime = timestampNow - device.report.timestamp
        if (diffTime <= maxGreenState) {
          device.locationStatus = 1
        } else if (diffTime <= maxYellowState) {
          device.locationStatus = 2
        } else {
          device.locationStatus = 3
        }
      })
    },
    ClearDeviceSelection () {
      this.deviceList.list.forEach((fleet) => {
        fleet.selected = false
        fleet.devices.forEach((device) => {
          device.selected = false
        })
      })
    },
    OnFleetSelectionChanged (fleetID, state) {
      var fleet = this.deviceList.filteredList.find((fleet) => {
        return fleet.id === fleetID
      })
      fleet.selected = state
      console.debug('FleetSelectionChanged', fleet, fleetID, state)

      fleet.devices.forEach((device) => {
        device.selected = state
        // TODO: Agregar un pequeño sleep para permitir la reactividad
        console.debug('Seleccionando', device.id, state)
      })
      this.UpdateTotalDevicesSelected()

      if (fleet.selected) {
        // TODO: centrar mapa a dispositivos and close allInfoWindows
      }
    },
    OnDeviceSelectionChanged (deviceID, state, fleetID = null) {
      var device
      var fleet

      if (fleetID != null) {
        fleet = this.deviceList.list.find((fleet) => fleet.id === fleetID)
        device = fleet.devices.find((device) => device.id === deviceID)
      } else {
        device = this.deviceList.list
          .flatMap((fleet) => fleet.devices)
          .find((device) => device.id === deviceID)
        fleet = this.deviceList.list.find(
          (fleet) => fleet.id === device.fleetID
        )
      }

      device.selected = state

      var allDeviceSelected = this.HasFleetAllDevicesSelected(device.fleetID)
      fleet.selected = allDeviceSelected

      this.UpdateTotalDevicesSelected()
    },
    HasFleetAllDevicesSelected (fleetID) {
      var fleet = this.deviceList.list.find((fleet) => fleet.id === fleetID)

      if (fleet.devices.length > 0) {
        return fleet.devices.every(
          (device) => device.selected === true
        )
      } else {
        return false
      }
    },
    ResetDeviceListFilter () {
      this.deviceList.searchTerm = ''
      this.deviceList.filteredList = this.deviceList.list
      this.helper.showResetDeviceListButton = false
    },
    FilterDeviceList () {
      if (this.deviceList.searchTerm.trim() === '') {
        this.ResetDeviceListFilter()
      } else {
        var list = []
        this.deviceList.list.forEach((fleet) => {
          if (
            fleet.name
              .toLowerCase()
              .includes(this.deviceList.searchTerm.toLowerCase())
          ) {
            list.push(fleet)
          } else {
            var auxFleet = Object.assign({}, fleet)
            auxFleet.devices = fleet.devices.filter((device) =>
              device.alias
                .toLowerCase()
                .includes(this.deviceList.searchTerm.toLowerCase())
            )

            if (auxFleet.devices.length > 0) {
              list.push(auxFleet)
            }
          }
        })

        this.helper.showResetDeviceListButton = true
        this.deviceList.filteredList = list
        this.RegisterTooltip()
      }
    },
    FilterDeviceListByReportState (located) {
      this.ResetDeviceListFilter()

      var list = []
      this.deviceList.list.forEach((fleet) => {
        var auxFleet = Object.assign({}, fleet)
        auxFleet.devices = fleet.devices.filter((device) => {
          if (located) {
            return (
              this.$store.state.devices.devices[device.imei].locationStatus < 3
            )
          } else {
            return (
              this.$store.state.devices.devices[device.imei].locationStatus ===
              3
            )
          }
        })

        if (auxFleet.devices.length > 0) {
          list.push(auxFleet)
        }
      })

      this.helper.showResetDeviceListButton = true
      this.deviceList.filteredList = list
      this.RegisterTooltip()
    },
    UpdateTotalDevicesSelected () {
      var devices = []
      this.deviceList.totalSelected = 0
      this.deviceList.list.forEach((fleet) => {
        fleet.devices.forEach((device) => {
          if (device.selected) {
            this.deviceList.totalSelected++
            devices.push({ deviceImei: device.imei })
          }
        })
      })

      if (this.deviceList.totalSelected === 1) {
        var device = this.deviceList.list
          .flatMap((fleet) => fleet.devices)
          .find((device) => device.selected === true)
        this.showDeviceInfo(device.imei)
      } else if (this.deviceList.totalSelected > 1) {
        this.closeDeviceInfo()
        this.onDevicesSelected(devices)
      } else {
        this.closeDeviceInfo()
        this.onDevicesSelected([])
      }
    },
    ShowDeviceRoutePanel () {
      if (this.deviceList.totalSelected === 1) {
        var device = this.deviceList.list
          .flatMap((fleet) => fleet.devices)
          .find((device) => device.selected === true)

        console.debug('ShowDeviceRoute of', device)
        var DeviceRouteComponent = () =>
          import('@/views/MapModule/MapFloatMenu/panelDevices/deviceRoute')
        var properties = {
          deviceID: device.imei,
          buscador: this.deviceList.searchTerm
        }

        this.loadDynamicComponent(
          'deviceRoute',
          DeviceRouteComponent,
          properties
        )
      }
    },
    ToggleCollapseFleet (fleetID) {
      var divFleetID = '#fleet-' + fleetID
      var divCollapseIconID = '#fleet-' + fleetID + '-collapse-icon'
      var isCollapsed = $(divFleetID).hasClass('show')

      if (isCollapsed) {
        $(divFleetID).collapse('hide')
        $(divCollapseIconID).removeClass('universalicon-arrow-collapse')
        $(divCollapseIconID).addClass('universalicon-arrow-expand')
      } else {
        $(divFleetID).collapse('show')
        $(divCollapseIconID).addClass('universalicon-arrow-collapse')
        $(divCollapseIconID).removeClass('universalicon-arrow-expand')
      }
    }
  } // End of Methods
}
</script>

<style>
</style>
