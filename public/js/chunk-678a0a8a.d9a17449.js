(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-678a0a8a"],{"2a01":function(t,e,a){},"2bff":function(t,e,a){"use strict";var n=a("2a01"),o=a.n(n);o.a},e850:function(t,e,a){"use strict";a.r(e);var n=function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"card-body"},[a("div",{attrs:{id:"contactos"}},[a("div",{staticClass:"row"},[a("div",{staticClass:"col-12"},[a("data-table",{ref:"table",attrs:{showEditButton:!0,showWatchButton:!1,showDeleteButton:!0,showIndex:!1},on:{OnWatch:t.OnWatch,OnEdit:t.OnEdit,OnDelete:t.OnDelete}})],1),t.isEmptyContacts?a("div",{staticClass:"col-12"},[t._v("Sin contactos")]):t._e(),a("div",{staticClass:"col-12",staticStyle:{"margin-top":"40px"},attrs:{id:"alertasAD"}}),a("div",{staticClass:"col-12 ",staticStyle:{"margin-top":"15px"}},[a("button",{staticClass:"btn btn-primary shadow-2 mb-4 float-right",attrs:{id:"agregarContac",type:"button"},on:{click:function(e){return t.modalContactCreate()}}},[t._v("Agregar contacto")])])])])])},o=[],s=(a("ac6a"),a("7f7f"),a("96cf"),a("3b8d")),i=a("08e6"),c=a("511d"),r=a("d3e3"),l=a("5e83"),u=a("e3a0"),d=a("a9b0"),h=a("862e"),f={name:"dataTableCuenta",mixins:[i["a"],c["a"]],components:{dataTable:d["a"]},data:function(){return{cuenta:null,email:null,statusLegal:"",labelLegal:null,labelRFC:null,nameLegal:null,rfc:null,pais:null,region:null,codep:null,notas:"",contactos:[],contactosFine:[],addres:null,catLegalStatus:[],catTipoContact:[],id:0,seccion:this.$route.params.id,title:null,zonaH:14,listZonaHoraria:[],visabled:!0,accionT:this.$store.state.modal.datosDymanic.accion,active:null,setDisabled:!0,idCliente:null,resultado:!1,idInp:"input",files:[],Getlogo:localStorage.getItem("imgLogo")}},created:function(){var t=Object(s["a"])(regeneratorRuntime.mark((function t(){return regeneratorRuntime.wrap((function(t){while(1)switch(t.prev=t.next){case 0:return console.debug("CREATED_INICIO"),t.next=3,this.getInfoCliente();case 3:console.debug("CREATED_FIN"),this.catPeople(),this.idCliente=this.$store.state.modal.datosDymanic.clientID;case 6:case"end":return t.stop()}}),t,this)})));function e(){return t.apply(this,arguments)}return e}(),mounted:function(){var t=Object(s["a"])(regeneratorRuntime.mark((function t(){return regeneratorRuntime.wrap((function(t){while(1)switch(t.prev=t.next){case 0:$("#containerPrincipal").css({"margin-left":this.$store.state.widthMenu}),$("#containerPrincipal").css({"margin-top":this.$store.state.topMenu}),this.suscribeToDeviceEvents(),this.$store.state.loader=!1;case 4:case"end":return t.stop()}}),t,this)})));function e(){return t.apply(this,arguments)}return e}(),destroyed:function(){this.unsuscribreToDeviceEvents()},methods:{catPeople:function(){var t=Object(s["a"])(regeneratorRuntime.mark((function t(){var e,a;return regeneratorRuntime.wrap((function(t){while(1)switch(t.prev=t.next){case 0:return t.next=2,this.getRequest("catalogs/people");case 2:e=t.sent,a=e.data.peopleTypes,this.catTipoContact=a;case 5:case"end":return t.stop()}}),t,this)})));function e(){return t.apply(this,arguments)}return e}(),suscribeToDeviceEvents:function(){var t=this;r["a"].$on("GET_list_contactos",(function(e){t.getInfoMiPerfil(),$("#legales-tab").removeClass("active"),$("#contactos-tab").addClass("active")})),r["a"].$on("agregar_contactos",(function(e){e.accion="agregar",t.agregarContacto(e),$("#legales-tab").removeClass("active"),$("#contactos-tab").addClass("active")})),r["a"].$on("edit_contactos",(function(e){t.editarContacto(e),$("#legales-tab").removeClass("active"),$("#contactos-tab").addClass("active")})),r["a"].$on("Delete_contactos",(function(e){e.accion="eliminar",t.eliminarcontac(e)})),r["a"].$on("refresh_dataTable",(function(e){console.debug("EVEN_REFRESH"),t.Refresh()}))},unsuscribreToDeviceEvents:function(){r["a"].$off("GET_list_contactos"),r["a"].$off("agregar_contactos"),r["a"].$off("Delete_contactos"),r["a"].$off("edit_contactos"),r["a"].$off("refresh_dataTable")},modalContactCreate:function(){var t=Object(s["a"])(regeneratorRuntime.mark((function t(){var e;return regeneratorRuntime.wrap((function(t){while(1)switch(t.prev=t.next){case 0:return this.$store.commit("CLEAR_MODAL_DINAMIC"),this.$store.state.loader=!0,e={component:l["a"],datos:{seccion:"contacto",id:this.idCliente}},t.next=5,this.$store.commit("ADD_COMPONENT_DINAMIC",e);case 5:return t.next=7,this.$store.commit("ADD_COMPONENT_DINAMIC_STATE",!0);case 7:case"end":return t.stop()}}),t,this)})));function e(){return t.apply(this,arguments)}return e}(),getInfoCliente:function(){var t=Object(s["a"])(regeneratorRuntime.mark((function t(){var e,a,n,o=this;return regeneratorRuntime.wrap((function(t){while(1)switch(t.prev=t.next){case 0:return t.next=2,this.getRequest("accounts/".concat(this.$store.state.modal.datosDymanic.clientID));case 2:return e=t.sent,console.debug("CLEINTE",e),a=e.data.customer,this.active=a.active,this.cuenta=a.account,this.statusLegal=a.legal.statusID,this.nameLegal=a.legal.name,this.rfc=a.legal.taxID,this.pais=a.legal.country,this.region=a.legal.region,this.codep=a.legal.zipCode,this.notas=a.legal.notes,this.addres=a.legal.address,n=a.contacts,console.debug("CONTACTOS",n),n.forEach((function(t){o.contactos.push({id:t.id,idC:t.id,name:t.name,phone:t.phone,cel:t.cel,email:t.email,tipo:t.contactType,notes:t.notes}),o.contactosFine.push({id:t.id,idC:t.id,type:t.contactTypeID,name:t.name,phone:t.phone,cel:t.cel,email:t.email,notes:t.notes}),o.id++})),t.next=20,this.changeHeaderTable();case 20:case"end":return t.stop()}}),t,this)})));function e(){return t.apply(this,arguments)}return e}(),changeHeaderTable:function(){this.headers=[{title:"Contacto",key:"name",default:""},{title:"Tipo",key:"tipo",default:""},{title:"Teléfono",key:"phone",default:"-"},{title:"Celular",key:"cel",default:"-"},{title:"Correo",key:"email",default:""}],this.rows=this.contactos,console.debug("DATOS_ROWS",this.rows),this.$refs.table.Render(this.headers,this.rows),this.Refresh()},agregarContacto:function(){var t=Object(s["a"])(regeneratorRuntime.mark((function t(e){var a,n,o,s;return regeneratorRuntime.wrap((function(t){while(1)switch(t.prev=t.next){case 0:if(console.debug("DA ",e," ta"),"editar"!=e.accion){t.next=7;break}this.$store.state.loader=!1,this.$refs.table.AddRow(e),this.contactos.push(e),t.next=17;break;case 7:return a=e,n={contactType:a.type,name:a.name,phone:a.phone,cel:a.cel,email:a.email,notes:a.notes},o={},o["contact"]=n,console.debug("DATOOS",o),t.next=14,this.postRequest("accounts/contacts/"+this.idCliente,o);case 14:s=t.sent,console.debug("DATOOS_REQUEST",s),!0===s.success?(this.$store.state.loader=!1,a.id=s.data.contactID,a.idC=s.data.contactID,this.$refs.table.AddRow(a),this.contactos.push(e),r["a"].$emit("get_listContact",this.contactos)):(this.$store.state.loader=!1,$("#alertasAD").html("<div class='alert alert-danger alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Error, </strong>No se ha agregado el contacto</div>"),setTimeout((function(){$("#alertasAD").html("")}),5e3));case 17:case"end":return t.stop()}}),t,this)})));function e(e){return t.apply(this,arguments)}return e}(),Refresh:function(){console.debug("data_REFRESH"),this.$refs.table.Refresh()},OnWatch:function(t,e){alert("WATCH: ".concat(t.name," ").concat(t.age," ").concat(t.country))},OnEdit:function(t,e){this.modalEditContact(t,e)},OnDelete:function(t,e){console.debug("DELETE: ".concat(t.name," ").concat(t.id," ").concat(t.tipo)),console.debug("DELETE row",e,t),this.modalEliminarcontac(t.id,e)},eliminarcontac:function(){var t=Object(s["a"])(regeneratorRuntime.mark((function t(e){var a,n,o;return regeneratorRuntime.wrap((function(t){while(1)switch(t.prev=t.next){case 0:if(console.debug("DATA_DELETE",e,e.i),"editar"!=e.accion){t.next=10;break}n=0,this.contactos.filter((function(t,o){if(console.debug("ITEM",t),t.id==e.id)return a=o,n=t,!0})),console.debug(this.contactos,"TIPO",n,e.id),this.contactos.splice(a,1),this.$refs.table.RemoveRow(e.sender),r["a"].$emit("get_listContact",this.contactos),t.next=14;break;case 10:return t.next=12,this.deleteRequest("accounts/contacts/"+e.id);case 12:o=t.sent,!0===o.success?(this.$store.state.loader=!1,n=0,this.contactos.filter((function(t,o){if(console.debug("ITEM",t),t.id==e.id)return a=o,n=t,!0})),console.debug(this.contactos,"TIPO",n,e.id),this.contactos.splice(a,1),this.$refs.table.RemoveRow(e.sender),r["a"].$emit("get_listContact",this.contactos)):(this.$store.state.loader=!1,$("#alertasAD").html("<div class='alert alert-danger alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Error, </strong>No se ha eliminado el contacto</div>"),setTimeout((function(){$("#alertasAD").html("")}),5e3));case 14:case"end":return t.stop()}}),t,this)})));function e(e){return t.apply(this,arguments)}return e}(),editarContacto:function(){var t=Object(s["a"])(regeneratorRuntime.mark((function t(e){var a,n,o,s,i;return regeneratorRuntime.wrap((function(t){while(1)switch(t.prev=t.next){case 0:return console.debug("DATA_EDIT",e),e.data.accion="editar",e.accion="editar",a=e.data,n={contactType:a.tipo,name:a.name,phone:a.phone,cel:a.cel,email:a.email,notes:a.notes},o={},o["contact"]=n,console.debug("DATOOS",o),t.next=10,this.putRequest("contact/"+a.id,o);case 10:s=t.sent,!0===s.success?(this.$store.state.loader=!1,this.eliminarcontac(e),i=0,this.catTipoContact.filter((function(t,a){if(t.id===e.data.tipo)return a,i=t,!0})),e.data.tipo=i.name,console.debug("NUEVO_EDIT",e),this.agregarContacto(e.data)):(this.$store.state.loader=!1,$("#alertasAD").html("<div class='alert alert-danger alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Error, </strong>No se ha agregado el contacto</div>"),setTimeout((function(){$("#alertasAD").html("")}),5e3));case 12:case"end":return t.stop()}}),t,this)})));function e(e){return t.apply(this,arguments)}return e}(),modalEditContact:function(){var t=Object(s["a"])(regeneratorRuntime.mark((function t(e,a){var n,o,s;return regeneratorRuntime.wrap((function(t){while(1)switch(t.prev=t.next){case 0:return console.debug("CLICK_EDIT",e),this.$store.commit("CLEAR_MODAL_DINAMIC"),this.$store.state.loader=!0,n=0,this.contactos.filter((function(t,a){if(t.id==e.id)return a,n=t,!0})),o=0,this.catTipoContact.filter((function(t,e){if(t.name===n.tipo)return e,o=t,!0})),console.debug(n,"MODAL_CONTAT",this.catTipoContact),console.debug("TIPO_MODAL_EDIT",o),n.tipoId=o.id,s={component:h["a"],datos:{seccion:"contacto",data:e,sender:a,dataContact:n}},t.next=13,this.$store.commit("ADD_COMPONENT_DINAMIC",s);case 13:return t.next=15,this.$store.commit("ADD_COMPONENT_DINAMIC_STATE",!0);case 15:case"end":return t.stop()}}),t,this)})));function e(e,a){return t.apply(this,arguments)}return e}(),modalEliminarcontac:function(){var t=Object(s["a"])(regeneratorRuntime.mark((function t(e,a){var n;return regeneratorRuntime.wrap((function(t){while(1)switch(t.prev=t.next){case 0:return this.$store.commit("CLEAR_MODAL_DINAMIC"),this.$store.state.loader=!0,n={component:u["a"],datos:{seccion:"contacto",id:e,sender:a}},t.next=5,this.$store.commit("ADD_COMPONENT_DINAMIC",n);case 5:return t.next=7,this.$store.commit("ADD_COMPONENT_DINAMIC_STATE",!0);case 7:case"end":return t.stop()}}),t,this)})));function e(e,a){return t.apply(this,arguments)}return e}()},computed:{Getdisabled:function(){return this.setDisabled},getShowTable:function(){return this.resultado},getContactos:function(){return this.contactos},isEmptyContacts:function(){return $.isEmptyObject(this.contactos)},logoGet:function(){return this.Getlogo}}},m=f,p=(a("2bff"),a("2877")),g=Object(p["a"])(m,n,o,!1,null,"5423789f",null);e["default"]=g.exports}}]);
//# sourceMappingURL=chunk-678a0a8a.d9a17449.js.map