(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-2d216450"],{c26a:function(t,e,a){"use strict";a.r(e);var n=function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"row"},[a("div",{staticClass:"col-12"},[a("data-table",{ref:"table",attrs:{showEditButton:!0,showWatchButton:!1,showDeleteButton:!0,showIndex:!1},on:{OnWatch:t.OnWatch,OnEdit:t.OnEdit,OnDelete:t.OnDelete}})],1),a("div",{staticClass:"col-12",staticStyle:{"margin-top":"40px"},attrs:{id:"alertasAD"}}),a("div",{staticClass:"col-12 ",staticStyle:{"margin-top":"15px"}},[a("button",{staticClass:"btn  btn-primary shadow-2 mb-4 float-right",attrs:{id:"agregarContac",type:"button"},on:{click:function(e){return t.modalContactCreate()}}},[t._v("Agregar contacto")])])])},o=[],c=(a("7f7f"),a("96cf"),a("3b8d")),i=a("08e6"),s=a("511d"),r=a("d3e3"),l=a("5e83"),u=a("e3a0"),d=a("a9b0"),h=a("862e"),f={components:{dataTable:d["a"]},mixins:[i["a"],s["a"]],created:function(){this.changeHeaderTable()},mounted:function(){this.catPeople(),console.debug("dt/ Fill Demo"),this.$refs.table.Render(this.headers,this.rows),this.suscribeToDeviceEvents()},destroyed:function(){this.unsuscribreToDeviceEvents()},data:function(){return{headers:[],rows:[],rowVisibility:!0,id:1,contactos:[],contactosFine:[],catTipoContact:[]}},methods:{catPeople:function(){var t=Object(c["a"])(regeneratorRuntime.mark((function t(){var e,a;return regeneratorRuntime.wrap((function(t){while(1)switch(t.prev=t.next){case 0:return t.next=2,this.getRequest("catalogs/people");case 2:e=t.sent,a=e.data.peopleTypes,this.catTipoContact=a;case 5:case"end":return t.stop()}}),t,this)})));function e(){return t.apply(this,arguments)}return e}(),suscribeToDeviceEvents:function(){var t=this;r["a"].$on("GET_list_contactos",(function(e){t.getInfoMiPerfil(),$("#legales-tab").removeClass("active"),$("#contactos-tab").addClass("active")})),r["a"].$on("agregar_contactos",(function(e){t.agregarContacto(e),t.id++,$("#legales-tab").removeClass("active"),$("#contactos-tab").addClass("active")})),r["a"].$on("edit_contactos",(function(e){t.editarContacto(e),$("#legales-tab").removeClass("active"),$("#contactos-tab").addClass("active")})),r["a"].$on("Delete_contactos",(function(e){t.eliminarcontac(e)})),r["a"].$on("refresh_dataTable",(function(e){console.debug("EVEN_REFRESH"),t.Refresh()}))},unsuscribreToDeviceEvents:function(){r["a"].$off("GET_list_contactos"),r["a"].$off("agregar_contactos"),r["a"].$off("Delete_contactos"),r["a"].$off("edit_contactos"),r["a"].$off("refresh_dataTable")},changeHeaderTable:function(){this.headers=[{title:"Contacto",key:"name",default:""},{title:"Tipo",key:"tipo",default:""},{title:"Teléfono",key:"phone",default:"-"},{title:"Celular",key:"cel",default:"-"},{title:"Correo",key:"email",default:""}],this.rows=[],console.debug("DATOS_ROWS",this.rows),this.$refs.table.Render(this.headers,this.rows),this.Refresh()},modalContactCreate:function(){var t=Object(c["a"])(regeneratorRuntime.mark((function t(){var e;return regeneratorRuntime.wrap((function(t){while(1)switch(t.prev=t.next){case 0:return this.$store.commit("CLEAR_MODAL_DINAMIC"),this.$store.state.loader=!0,e={component:l["a"],datos:{seccion:"contacto",id:this.id}},t.next=5,this.$store.commit("ADD_COMPONENT_DINAMIC",e);case 5:return t.next=7,this.$store.commit("ADD_COMPONENT_DINAMIC_STATE",!0);case 7:case"end":return t.stop()}}),t,this)})));function e(){return t.apply(this,arguments)}return e}(),agregarContacto:function(t){console.debug("DA ",t," ta");var e=t;this.$refs.table.AddRow(e),this.contactos.push(t),r["a"].$emit("get_listContact",this.contactos)},Refresh:function(){console.debug("data_REFRESH"),this.$refs.table.Refresh()},OnWatch:function(t,e){alert("WATCH: ".concat(t.name," ").concat(t.age," ").concat(t.country))},OnEdit:function(t,e){this.modalEditContact(t,e)},OnDelete:function(t,e){console.debug("DELETE: ".concat(t.name," ").concat(t.id," ").concat(t.tipo)),console.debug("DELETE row",e,t),this.modalEliminarcontac(t.id,e)},eliminarcontac:function(t){var e;console.debug("DATA_DELETE",t);var a=0;this.contactos.filter((function(n,o){if(console.debug("ITEM",n),n.id==t.id)return e=o,a=n,!0})),console.debug(this.contactos,"TIPO",a,t.id),this.contactos.splice(e,1),this.$refs.table.RemoveRow(t.sender),r["a"].$emit("get_listContact",this.contactos)},editarContacto:function(t){console.debug("DATA_EDIT",t),this.eliminarcontac(t.data);var e=0;this.catTipoContact.filter((function(a,n){if(a.id===t.data.tipo)return n,e=a,!0})),t.data.tipo=e.name,console.debug("NUEVO_EDIT",t),this.agregarContacto(t.data)},modalEditContact:function(){var t=Object(c["a"])(regeneratorRuntime.mark((function t(e,a){var n,o,c;return regeneratorRuntime.wrap((function(t){while(1)switch(t.prev=t.next){case 0:return console.debug("CLICK_EDIT",e),this.$store.commit("CLEAR_MODAL_DINAMIC"),this.$store.state.loader=!0,n=0,this.contactos.filter((function(t,a){if(t.id==e.id)return a,n=t,!0})),o=0,this.catTipoContact.filter((function(t,e){if(t.name===n.tipo)return e,o=t,!0})),console.debug(n,"MODAL_CONTAT",this.catTipoContact),console.debug("TIPO_MODAL_EDIT",o),n.tipoId=o.id,c={component:h["a"],datos:{seccion:"contacto",data:e,sender:a,dataContact:n}},t.next=13,this.$store.commit("ADD_COMPONENT_DINAMIC",c);case 13:return t.next=15,this.$store.commit("ADD_COMPONENT_DINAMIC_STATE",!0);case 15:case"end":return t.stop()}}),t,this)})));function e(e,a){return t.apply(this,arguments)}return e}(),modalEliminarcontac:function(){var t=Object(c["a"])(regeneratorRuntime.mark((function t(e,a){var n;return regeneratorRuntime.wrap((function(t){while(1)switch(t.prev=t.next){case 0:return this.$store.commit("CLEAR_MODAL_DINAMIC"),this.$store.state.loader=!0,n={component:u["a"],datos:{seccion:"contacto",id:e,sender:a}},t.next=5,this.$store.commit("ADD_COMPONENT_DINAMIC",n);case 5:return t.next=7,this.$store.commit("ADD_COMPONENT_DINAMIC_STATE",!0);case 7:case"end":return t.stop()}}),t,this)})));function e(e,a){return t.apply(this,arguments)}return e}()}},m=f,p=a("2877"),C=Object(p["a"])(m,n,o,!1,null,null,null);e["default"]=C.exports}}]);
//# sourceMappingURL=chunk-2d216450.d5bda2aa.js.map