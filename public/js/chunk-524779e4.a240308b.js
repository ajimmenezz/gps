(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-524779e4"],{4472:function(e,t,s){"use strict";s.r(t);var i=function(){var e=this,t=e.$createElement,s=e._self._c||t;return s("div",{staticClass:" row "},[e._m(0),s("div",{staticClass:" col-12 float-left"},[s("data-table",{ref:"table",attrs:{showEditButton:e.onEditVisible,showWatchButton:e.onVisible,showDeleteButton:e.ondeleteVisible,showActiveButton:!1,showIndex:!0},on:{OnWatch:e.OnWatch,OnEdit:e.OnEdit,OnDelete:e.OnDelete}})],1)])},n=[function(){var e=this,t=e.$createElement,s=e._self._c||t;return s("div",{staticClass:"col-12"},[s("h5",{staticClass:"float-left",staticStyle:{"font-size":"20px","padding-bottom":"10px"}},[s("b",[e._v("Sims")])])])}],r=(s("ac6a"),s("96cf"),s("3b8d")),a=s("08e6"),o=s("e2a2"),c=s("ed73"),u=s("d3e3"),l=s("a9b0"),m={name:"tablaSims",mixins:[a["a"]],data:function(){return{listSims:null,ondeleteVisible:!1,onEditVisible:!1,onVisible:!1}},components:{cModalDelete:c["a"],dataTable:l["a"]},created:function(){this.$store.state.StoreCliente=this.$store.state.modal.datosDymanic.idCliente,0==this.getClientID&&(this.ondeleteVisible=!0,this.onEditVisible=!0),0!=this.getClientID&&(this.onVisible=!0),this.getSims()},mounted:function(){this.$store.state.seccionMenu="adminSims",$("#containerPrincipal").css({"margin-left":this.$store.state.widthMenu}),$("#containerPrincipal").css({"margin-top":this.$store.state.topMenu}),this.suscribeToDeviceEvents()},beforeDestroy:function(){this.unsuscribreToDeviceEvents()},methods:{getListSims:function(){var e=Object(r["a"])(regeneratorRuntime.mark((function e(){var t,s;return regeneratorRuntime.wrap((function(e){while(1)switch(e.prev=e.next){case 0:if(0!=this.$store.state.StoreCliente){e.next=7;break}return e.next=3,this.getRequest("sims/store");case 3:t=e.sent,!0===t.success&&(this.listSims=t.data.sims),e.next=12;break;case 7:return s={clientID:this.$store.state.StoreCliente},e.next=10,this.getRequest("sims/store",s);case 10:t=e.sent,!0===t.success&&(this.listSims=t.data.sims);case 12:case"end":return e.stop()}}),e,this)})));function t(){return e.apply(this,arguments)}return t}(),getSims:function(){var e=Object(r["a"])(regeneratorRuntime.mark((function e(){var t,s;return regeneratorRuntime.wrap((function(e){while(1)switch(e.prev=e.next){case 0:if(0!=this.$store.state.StoreCliente){e.next=7;break}return e.next=3,this.getRequest("sims/store");case 3:t=e.sent,!0===t.success&&(this.listSims=t.data.sims),e.next=12;break;case 7:return s={clientID:this.$store.state.StoreCliente},e.next=10,this.getRequest("sims/store",s);case 10:t=e.sent,!0===t.success&&(this.listSims=t.data.sims);case 12:return e.next=14,this.changeHeaderTable();case 14:case"end":return e.stop()}}),e,this)})));function t(){return e.apply(this,arguments)}return t}(),changeHeaderTable:function(){this.headers=[{title:"Teléfono",key:"phone",default:""},{title:"Compañia teléfonica",key:"carrierName",default:"-",priority:1},{title:"Fecha de creación",key:"creationTime",default:"-",priority:5}],this.listSims.forEach((function(e){e.creationTime&&(e.creationTime=moment(1e3*e.creationTime).format("DD-MM-YYYY"))})),console.debug(this.listSims,"DATOS_list"),this.rows=this.listSims,console.debug("DATOS_ROWS",this.rows),this.$refs.table.Render(this.headers,this.rows),this.Refresh()},Refresh:function(){console.debug("data_REFRESH"),this.$refs.table.Refresh()},OnWatch:function(e,t){console.debug("WATCH: ".concat(e.imei," ").concat(e.alias)),this.modalEdit(e)},OnEdit:function(e,t){console.debug("onEdit: ".concat(e.imei," ").concat(e.alias)),this.modalEdit(e,2,t)},OnDelete:function(e,t){console.debug("DELETE: ".concat(e.phone," ").concat(e.id," ")),console.debug("DELETE row",t,e),this.eliminar(e,t)},modalFormSims:function(){var e=Object(r["a"])(regeneratorRuntime.mark((function e(){var t;return regeneratorRuntime.wrap((function(e){while(1)switch(e.prev=e.next){case 0:return this.$store.state.loader=!0,this.$store.commit("CLEAR_MODAL_DINAMIC"),t={component:FormSims,datos:{seccion:"sims",accion:"nueva"}},console.debug(t),e.next=6,this.$store.commit("ADD_COMPONENT_DINAMIC",t);case 6:return e.next=8,this.$store.commit("ADD_COMPONENT_DINAMIC_STATE",!0);case 8:case"end":return e.stop()}}),e,this)})));function t(){return e.apply(this,arguments)}return t}(),modalEdit:function(){var e=Object(r["a"])(regeneratorRuntime.mark((function e(t){var s,i,n,r=arguments;return regeneratorRuntime.wrap((function(e){while(1)switch(e.prev=e.next){case 0:return s=r.length>1&&void 0!==r[1]?r[1]:1,i=r.length>2&&void 0!==r[2]?r[2]:null,console.debug("MODALEDIT",t,s,i),this.$store.state.loader=!0,this.$store.commit("CLEAR_MODAL_DINAMIC"),e.next=7,this.$store.commit("ADD_COMPONENT_DINAMIC_STATE",!1);case 7:return n={component:o["a"],datos:{seccion:"sims",accion:"editar",id:t.id,item:t}},2==s&&(n.datos.sender=i),console.debug("MODAL_OPEN_EDIT",n),e.next=12,this.$store.commit("ADD_COMPONENT_DINAMIC",n);case 12:return e.next=14,this.$store.commit("ADD_COMPONENT_DINAMIC_STATE",!0);case 14:case"end":return e.stop()}}),e,this)})));function t(t){return e.apply(this,arguments)}return t}(),editarSims:function(){var e=Object(r["a"])(regeneratorRuntime.mark((function e(t){var s,i,n;return regeneratorRuntime.wrap((function(e){while(1)switch(e.prev=e.next){case 0:return console.debug("DATOS",t.datos),e.next=3,this.putRequest("sims/"+t.item.id,t.datos);case 3:if(s=e.sent,!0!==s.success){e.next=27;break}if(this.$store.state.loader=!1,0!=this.$store.state.StoreCliente){e.next=13;break}return e.next=9,this.getRequest("sims/store");case 9:s=e.sent,!0===s.success&&(this.listSims=s.data.sims),e.next=18;break;case 13:return i={clientID:this.$store.state.StoreCliente},e.next=16,this.getRequest("sims/store",i);case 16:s=e.sent,!0===s.success&&(this.listSims=s.data.sims);case 18:return this.listSims.filter((function(e,s){console.debug("ITEM",e,s),t.item.id==e.id&&(t.item=e)})),e.next=21,this.$refs.table.RemoveRow(t.sender);case 21:return console.debug("DATOS_FIn",t,n),e.next=24,this.$refs.table.AddRow(t.item);case 24:notify("Excelente!","Se ha editado la sims ","top","right","success",10,50),e.next=29;break;case 27:this.$store.state.loader=!1,notify("Error!","No se ha editado la sims ","top","right","danger",10,50);case 29:case"end":return e.stop()}}),e,this)})));function t(t){return e.apply(this,arguments)}return t}(),eliminar:function(){var e=Object(r["a"])(regeneratorRuntime.mark((function e(t,s){var i;return regeneratorRuntime.wrap((function(e){while(1)switch(e.prev=e.next){case 0:return this.$store.commit("CLEAR_MODAL_DINAMIC"),i={component:c["a"],datos:{ID:t.id,name:t.phone,tipo:"sims",item:t,sender:s}},e.next=4,this.$store.commit("ADD_COMPONENT_DINAMIC",i);case 4:return e.next=6,this.$store.commit("ADD_COMPONENT_DINAMIC_STATE",!0);case 6:case"end":return e.stop()}}),e,this)})));function t(t,s){return e.apply(this,arguments)}return t}(),eliminarSims:function(){var e=Object(r["a"])(regeneratorRuntime.mark((function e(t){var s,i;return regeneratorRuntime.wrap((function(e){while(1)switch(e.prev=e.next){case 0:return s=t.id,e.next=3,this.deleteRequest("sims/store/"+s);case 3:i=e.sent,!0===i.success?(this.$refs.table.RemoveRow(t.sender),this.getListSims(),this.$store.state.loader=!1,notify("Excelente!","Se ha eliminado la sims ","top","right","success",10,50)):(this.$store.state.loader=!1,notify("Error!","No se ha eliminado la sims ","top","right","danger",10,50));case 5:case"end":return e.stop()}}),e,this)})));function t(t){return e.apply(this,arguments)}return t}(),suscribeToDeviceEvents:function(){var e=this;u["a"].$on("editar_sims",(function(t){console.debug("EDITAR_SIMS",t),e.editarSims(t)})),u["a"].$on("eliminar_sims",(function(t){console.debug("ELIMINAR_SIMS",t),e.eliminarSims(t)}))},unsuscribreToDeviceEvents:function(){u["a"].$off("editar_sims"),u["a"].$off("eliminar_sims")}},computed:{getClientID:function(){return this.$store.state.StoreCliente}}},h=m,d=(s("ccb0"),s("2877")),f=Object(d["a"])(h,i,n,!1,null,null,null);t["default"]=f.exports},a41b:function(e,t,s){},ccb0:function(e,t,s){"use strict";var i=s("a41b"),n=s.n(i);n.a}}]);
//# sourceMappingURL=chunk-524779e4.a240308b.js.map