(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-19f8fff0"],{"09b1":function(t,e,a){},"19bc":function(t,e,a){"use strict";a.r(e);var s=function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"card-body"},[this.$store.state.typeDevice.tablet||this.$store.state.typeDevice.mobile?t._e():a("div",{attrs:{id:"legales"}},[a("div",{staticClass:"row"},[a("div",{staticClass:"col-12 col-md-4"},[a("div",{staticClass:"form-group "},[a("label",{attrs:{for:"selectStatusLegal"}},[t._v("Estado legal")]),a("select",{directives:[{name:"model",rawName:"v-model",value:t.statusLegal,expression:"statusLegal"}],staticClass:"form-control classdisabled ",attrs:{id:"selectStatusLegal",required:""},on:{change:[function(e){var a=Array.prototype.filter.call(e.target.options,(function(t){return t.selected})).map((function(t){var e="_value"in t?t._value:t.value;return e}));t.statusLegal=e.target.multiple?a:a[0]},function(e){return t.changeStatusLegal()}]}},[a("option",{attrs:{value:""}},[t._v("Selecciona")]),t._l(t.catLegalStatus,(function(e){return a("option",{key:e.id,domProps:{value:e.id}},[t._v(t._s(e.name))])}))],2)])]),a("div",{staticClass:"col-12 col-md-4"},[a("config-input",{attrs:{id:"nombreLegal",label:t.labelLegal,typeinput:"text",placeholder:t.labelLegal,required:"true",valor:t.nameLegal,toLowerUperCase:"uppercase"},model:{value:t.nameLegal,callback:function(e){t.nameLegal="string"===typeof e?e.trim():e},expression:"nameLegal"}})],1),a("div",{staticClass:"col-12 col-md-4",staticStyle:{display:"none"},attrs:{id:"divRFC"}},[a("config-input",{attrs:{id:"rfc",label:t.labelRFC,typeinput:"text",placeholder:t.labelRFC,required:"true",valor:t.rfc,toLowerUperCase:"uppercase"},model:{value:t.rfc,callback:function(e){t.rfc="string"===typeof e?e.trim():e},expression:"rfc"}})],1),a("div",{staticClass:"col-12 col-md-4"},[a("config-input",{attrs:{id:"pais",label:"País",typeinput:"text",placeholder:"País",required:"true",valor:t.pais,toLowerUperCase:"uppercase"},model:{value:t.pais,callback:function(e){t.pais="string"===typeof e?e.trim():e},expression:"pais"}})],1),a("div",{staticClass:"col-12 col-md-4"},[a("config-input",{attrs:{id:"region",label:"Región/Estado",typeinput:"text",placeholder:"Región/Estado",required:"true",valor:t.region,toLowerUperCase:"uppercase"},model:{value:t.region,callback:function(e){t.region="string"===typeof e?e.trim():e},expression:"region"}})],1),a("div",{staticClass:"col-12 col-md-4"},[a("config-input",{attrs:{id:"cp",label:"Código postal",typeinput:"text",placeholder:"Código postal",required:"true",valor:t.codep,toLowerUperCase:"uppercase"},model:{value:t.codep,callback:function(e){t.codep="string"===typeof e?e.trim():e},expression:"codep"}})],1),a("div",{staticClass:"col-12 col-md-4"},[a("div",{staticClass:"form-group "},[a("label",{attrs:{for:"zonaH"}},[t._v("Zona horaria")]),a("select",{directives:[{name:"model",rawName:"v-model",value:t.zonaH,expression:"zonaH"}],staticClass:"form-control classdisabled",attrs:{id:"zonaH",valor:t.zonaH,required:""},on:{change:function(e){var a=Array.prototype.filter.call(e.target.options,(function(t){return t.selected})).map((function(t){var e="_value"in t?t._value:t.value;return e}));t.zonaH=e.target.multiple?a:a[0]}}},[a("option",{attrs:{value:""}},[t._v("Selecciona")]),t._l(t.listZonaHoraria,(function(e){return a("option",{key:e.id,domProps:{value:e.id}},[t._v(t._s(e.name))])}))],2)])]),a("div",{staticClass:"col-12 col-md-4"},[a("config-input",{attrs:{id:"addres",label:"Dirección",typeinput:"text",placeholder:"Dirección",required:"true",valor:t.addres,toLowerUperCase:"uppercase"},model:{value:t.addres,callback:function(e){t.addres="string"===typeof e?e.trim():e},expression:"addres"}})],1),a("div",{staticClass:"col-12 col-md-4"},[a("config-input",{attrs:{id:"notes",label:"Notas",typeinput:"text",placeholder:"Notas",required:"false",valor:t.notas},model:{value:t.notas,callback:function(e){t.notas="string"===typeof e?e.trim():e},expression:"notas"}})],1),a("div",{staticClass:"col-12 ",attrs:{id:"alertasAD"}}),a("div",{staticClass:"col-12  float-right"},[t.Getdisabled?t._e():a("button",{staticClass:"btn btn-primary",attrs:{id:"editSubmit",type:"submit"},on:{click:function(e){return t.editarCampos(!0)}}},[t._v("Editar datos")]),t.Getdisabled?a("button",{staticClass:"btn btn-outline-primary ",attrs:{type:"button"},on:{click:function(e){return t.editarCampos(!1)}}},[t._v("Cancelar actualizacion")]):t._e(),t.Getdisabled?a("button",{staticClass:"btn btn-primary ",attrs:{id:"registerSubmit",type:"submit"},on:{click:function(e){return t.SendFormLegales()}}},[t._v("Guardar cambios")]):t._e()])])]),this.$store.state.typeDevice.tablet||this.$store.state.typeDevice.mobile?a("div",{attrs:{id:"legalesM"}},[a("div",{staticClass:"row"},[a("div",{staticClass:"col-12 col-md-6"},[a("div",{staticClass:"form-group "},[a("label",{attrs:{for:"selectStatusLegal"}},[t._v("Estado legal")]),a("select",{directives:[{name:"model",rawName:"v-model",value:t.statusLegal,expression:"statusLegal"}],staticClass:"form-control classdisabled ",attrs:{id:"selectStatusLegal",required:""},on:{change:[function(e){var a=Array.prototype.filter.call(e.target.options,(function(t){return t.selected})).map((function(t){var e="_value"in t?t._value:t.value;return e}));t.statusLegal=e.target.multiple?a:a[0]},function(e){return t.changeStatusLegal()}]}},[a("option",{attrs:{value:""}},[t._v("Selecciona")]),t._l(t.catLegalStatus,(function(e){return a("option",{key:e.id,domProps:{value:e.id}},[t._v(t._s(e.name))])}))],2)])]),a("div",{staticClass:"col-12 col-md-6"},[a("config-input",{attrs:{id:"nombreLegal",label:t.labelLegal,typeinput:"text",placeholder:t.labelLegal,required:"true",valor:t.nameLegal,toLowerUperCase:"uppercase"},model:{value:t.nameLegal,callback:function(e){t.nameLegal="string"===typeof e?e.trim():e},expression:"nameLegal"}})],1),a("div",{staticClass:"col-12 col-md-6",staticStyle:{display:"none"},attrs:{id:"divRFC"}},[a("config-input",{attrs:{id:"rfc",label:t.labelRFC,typeinput:"text",placeholder:t.labelRFC,required:"true",valor:t.rfc,toLowerUperCase:"uppercase"},model:{value:t.rfc,callback:function(e){t.rfc="string"===typeof e?e.trim():e},expression:"rfc"}})],1),a("div",{staticClass:"col-12 col-md-6"},[a("config-input",{attrs:{id:"pais",label:"País",typeinput:"text",placeholder:"País",required:"true",valor:t.pais,toLowerUperCase:"uppercase"},model:{value:t.pais,callback:function(e){t.pais="string"===typeof e?e.trim():e},expression:"pais"}})],1),a("div",{staticClass:"col-12 col-md-6"},[a("config-input",{attrs:{id:"region",label:"Región/Estado",typeinput:"text",placeholder:"Región/Estado",required:"true",valor:t.region,toLowerUperCase:"uppercase"},model:{value:t.region,callback:function(e){t.region="string"===typeof e?e.trim():e},expression:"region"}})],1),a("div",{staticClass:"col-12 col-md-6"},[a("config-input",{attrs:{id:"cp",label:"Código postal",typeinput:"text",placeholder:"Código postal",required:"true",valor:t.codep,toLowerUperCase:"uppercase"},model:{value:t.codep,callback:function(e){t.codep="string"===typeof e?e.trim():e},expression:"codep"}})],1),a("div",{staticClass:"col-12 col-md-6"},[a("div",{staticClass:"form-group "},[a("label",{attrs:{for:"zonaH"}},[t._v("Zona horaria")]),a("select",{directives:[{name:"model",rawName:"v-model",value:t.zonaH,expression:"zonaH"}],staticClass:"form-control classdisabled",attrs:{id:"zonaH",valor:t.zonaH,required:""},on:{change:function(e){var a=Array.prototype.filter.call(e.target.options,(function(t){return t.selected})).map((function(t){var e="_value"in t?t._value:t.value;return e}));t.zonaH=e.target.multiple?a:a[0]}}},[a("option",{attrs:{value:""}},[t._v("Selecciona")]),t._l(t.listZonaHoraria,(function(e){return a("option",{key:e.id,domProps:{value:e.id}},[t._v(t._s(e.name))])}))],2)])]),a("div",{staticClass:"col-12 col-md-6"},[a("config-input",{attrs:{id:"addres",label:"Dirección",typeinput:"text",placeholder:"Dirección",required:"true",valor:t.addres,toLowerUperCase:"uppercase"},model:{value:t.addres,callback:function(e){t.addres="string"===typeof e?e.trim():e},expression:"addres"}})],1),a("div",{staticClass:"col-12 col-md-6"},[a("config-input",{attrs:{id:"notes",label:"Notas",typeinput:"text",placeholder:"Notas",required:"false",valor:t.notas},model:{value:t.notas,callback:function(e){t.notas="string"===typeof e?e.trim():e},expression:"notas"}})],1),this.$store.state.typeDevice.mobile&&1==t.optionTab?a("div",{staticClass:"col-12 float-right"},[t.Getdisabled?t._e():a("button",{staticClass:" btn-block btn btn-primary",staticStyle:{right:"0px",bottom:"0px","margin-top":"25px"},attrs:{id:"editSubmit",type:"submit"},on:{click:function(e){return t.editarCampos(!0)}}},[t._v("Editar datos")]),t.Getdisabled?a("button",{staticClass:" btn-block btn btn-outline-primary ",attrs:{type:"button"},on:{click:function(e){return t.editarCampos(!1)}}},[t._v("Cancelar actualizacion")]):t._e(),t.Getdisabled?a("button",{staticClass:" btn-block btn btn-primary ",attrs:{id:"registerSubmit",type:"submit"},on:{click:function(e){return t.SendFormLegales()}}},[t._v("Guardar cambios")]):t._e()]):t._e(),this.$store.state.typeDevice.mobile||1!=t.optionTab?t._e():a("div",{staticClass:"col-12 col-md-6 float-right"},[t.Getdisabled?t._e():a("button",{staticClass:"btn btn-primary",attrs:{id:"editSubmit",type:"submit"},on:{click:function(e){return t.editarCampos(!0)}}},[t._v("Editar datos")]),t.Getdisabled?a("button",{staticClass:"btn btn-outline-primary ",attrs:{type:"button"},on:{click:function(e){return t.editarCampos(!1)}}},[t._v("Cancelar actualizacion")]):t._e(),t.Getdisabled?a("button",{staticClass:"btn btn-primary ",attrs:{id:"registerSubmit",type:"submit"},on:{click:function(e){return t.SendFormLegales()}}},[t._v("Guardar cambios")]):t._e()]),a("div",{staticClass:"col-12 ",attrs:{id:"alertasAD"}})])]):t._e()])},i=[],r=(a("ac6a"),a("7f7f"),a("96cf"),a("3b8d")),o=a("08e6"),n=a("511d"),l=a("d3e3"),c={name:"datosLegales",mixins:[o["a"],n["a"]],components:{},data:function(){return{cuenta:null,email:null,statusLegal:"",labelLegal:null,labelRFC:null,nameLegal:null,rfc:null,pais:null,region:null,codep:null,notas:"",contactos:[],contactosFine:[],addres:null,catLegalStatus:[],catTipoContact:[],id:0,seccion:this.$route.params.id,title:null,zonaH:14,listZonaHoraria:[],visabled:!0,accionT:this.$store.state.modal.datosDymanic.accion,active:null,setDisabled:!0,idCliente:null,resultado:!1,idInp:"input",files:[],Getlogo:localStorage.getItem("imgLogo"),optionTab:1}},created:function(){var t=Object(r["a"])(regeneratorRuntime.mark((function t(){return regeneratorRuntime.wrap((function(t){while(1)switch(t.prev=t.next){case 0:return console.debug("CREATED_INICIO"),t.next=3,this.getInfoMiPerfil();case 3:console.debug("CREATED_FIN"),this.catStatusLegal(),this.catPeople(),this.zonaHoraria();case 7:case"end":return t.stop()}}),t,this)})));function e(){return t.apply(this,arguments)}return e}(),mounted:function(){var t=Object(r["a"])(regeneratorRuntime.mark((function t(){return regeneratorRuntime.wrap((function(t){while(1)switch(t.prev=t.next){case 0:return this.editarCampos(!1),$("#containerPrincipal").css({"margin-left":this.$store.state.widthMenu}),$("#containerPrincipal").css({"margin-top":this.$store.state.topMenu}),this.changeStatusLegal(),t.next=6,l["a"].$emit("NAVBAR_MenuSimple",this.$store.state.seccionMenu);case 6:return this.$store.state.submenuActive="config",this.$store.state.itemSubmenuActive="itemPerfil",t.next=10,l["a"].$emit("NAVBAR_MenuOpciones","config","itemPerfil");case 10:this.title=" Mi cuenta",this.suscribeToDeviceEvents(),this.$store.state.loader=!1;case 13:case"end":return t.stop()}}),t,this)})));function e(){return t.apply(this,arguments)}return e}(),destroyed:function(){this.unsuscribreToDeviceEvents()},methods:{catPeople:function(){var t=Object(r["a"])(regeneratorRuntime.mark((function t(){var e,a;return regeneratorRuntime.wrap((function(t){while(1)switch(t.prev=t.next){case 0:return t.next=2,this.getRequest("catalogs/people");case 2:e=t.sent,a=e.data.peopleTypes,this.catTipoContact=a;case 5:case"end":return t.stop()}}),t,this)})));function e(){return t.apply(this,arguments)}return e}(),editarCampos:function(t){console.debug("editarCampos",t),this.setDisabled=t,1==t&&($("#selectStatusLegal").removeAttr("disabled"),$("#nombreLegal").removeAttr("disabled"),$("#rfc").removeAttr("disabled"),$("#pais").removeAttr("disabled"),$("#region").removeAttr("disabled"),$("#cp").removeAttr("disabled"),$("#addres").removeAttr("disabled"),$("#notes").removeAttr("disabled")),0==t&&($("#selectStatusLegal").attr("disabled","disabled"),$("#nombreLegal").attr("disabled","disabled"),$("#rfc").attr("disabled","disabled"),$("#pais").attr("disabled","disabled"),$("#region").attr("disabled","disabled"),$("#cp").attr("disabled","disabled"),$("#zonaH").attr("disabled","disabled"),$("#addres").attr("disabled","disabled"),$("#notes").attr("disabled","disabled"))},suscribeToDeviceEvents:function(){var t=this;l["a"].$on("GET_list_contactos",(function(e){t.getInfoMiPerfil(),$("#legales-tab").removeClass("active"),$("#contactos-tab").addClass("active")}))},unsuscribreToDeviceEvents:function(){l["a"].$off("GET_list_contactos")},getInfoMiPerfil:function(){var t=Object(r["a"])(regeneratorRuntime.mark((function t(){var e,a,s,i=this;return regeneratorRuntime.wrap((function(t){while(1)switch(t.prev=t.next){case 0:return console.debug("GET_INFO_TABLE_INICIO"),this.$store.state.loader=!0,this.contactosFine=[],this.contactos=[],t.next=6,this.getRequest("configuration/account");case 6:return e=t.sent,console.debug("GET_INFO_PERFIL",e),a=e.data.customer,this.active=a.active,this.cuenta=a.account,this.statusLegal=a.legal.statusID,this.nameLegal=a.legal.name,this.rfc=a.legal.taxID,this.pais=a.legal.country,this.region=a.legal.region,this.codep=a.legal.zipCode,this.notas=a.legal.notes,this.addres=a.legal.address,this.idCliente=a.id,s=a.contacts,console.debug("CONTACTOS",s),s.forEach((function(t){console.debug("PHONE_CELL",t.phone,t.cel),""!=t.phone&&null!=t.phone||(console.debug("VACIO_PHONE"),t.phone=null),t.cel==""-t.cel==null&&(console.debug("VACIO_CEL"),t.cel=null),i.contactos.push({id:t.id,idC:t.id,name:t.name,phone:t.phone,cel:t.cel,email:t.email,tipo:t.contactType,notes:t.notes}),i.contactosFine.push({id:t.id,idC:t.id,type:t.contactTypeID,name:t.name,phone:t.phone,cel:t.cel,email:t.email,notes:t.notes})})),this.$store.state.loader=!1,console.debug("GET_INFO_TABLE_FIN"),this.resultado=!0,t.next=28,l["a"].$emit("legales_getCuenta",this.cuenta);case 28:case"end":return t.stop()}}),t,this)})));function e(){return t.apply(this,arguments)}return e}(),catStatusLegal:function(){var t=Object(r["a"])(regeneratorRuntime.mark((function t(){var e,a;return regeneratorRuntime.wrap((function(t){while(1)switch(t.prev=t.next){case 0:return t.next=2,this.getRequest("catalogs/legalstatus");case 2:e=t.sent,a=e.data.legalStatus,this.catLegalStatus=a;case 5:case"end":return t.stop()}}),t,this)})));function e(){return t.apply(this,arguments)}return e}(),zonaHoraria:function(){var t=Object(r["a"])(regeneratorRuntime.mark((function t(){var e;return regeneratorRuntime.wrap((function(t){while(1)switch(t.prev=t.next){case 0:return t.next=2,this.getRequest("catalogs/timezones");case 2:e=t.sent,!0===e.success&&(this.listZonaHoraria=e.data.timezones);case 4:case"end":return t.stop()}}),t,this)})));function e(){return t.apply(this,arguments)}return e}(),changeStatusLegal:function(){$("#divRFC").css({display:"block"}),this.labelLegal="Nombre legal / razon social",this.labelRFC="RFC / ID legal"},SendFormLegales:function(){var t=Object(r["a"])(regeneratorRuntime.mark((function t(){var e,a,s;return regeneratorRuntime.wrap((function(t){while(1)switch(t.prev=t.next){case 0:if(this.$store.state.loader=!0,0,"",console.debug("MI PERFIL"),""==this.statusLegal||null==this.statusLegal||null==this.nameLegal||""==this.nameLegal||null==this.pais||""==this.pais||null==this.region||""==this.region||null==this.codep||""==this.codep||null==this.addres||""==this.addres||null==this.rfc||""==this.rfc){t.next=16;break}return console.debug("MIS ENTRA"),e={},a={legal:{statusID:this.statusLegal,taxID:this.rfc.toUpperCase(this.rfc),name:this.nameLegal.toUpperCase(this.nameLegal),country:this.pais.toUpperCase(this.pais),region:this.region.toUpperCase(this.region),zipCode:this.codep.toUpperCase(this.codep),notes:this.notas,address:this.addres.toUpperCase(this.addres)}},e.customer=a,console.debug(a,"DATOS",e),t.next=12,this.putRequest("configuration/account",e);case 12:s=t.sent,!0===s.success?(this.$store.state.loader=!1,$("#alertasAD").html("<div class='alert alert-success alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Excelente! </strong>Se han actualizado tus datos<button type='button' class='close' data-dismiss='alert' aria-label='Close' style='padding-top: 0px;'><span aria-hidden='true'>&times;</span></button></div>"),setTimeout((function(){$("#alertasAD").html("")}),3e3)):(this.$store.state.loader=!1,$("#alertasAD").html("<div class='alert alert-danger alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Error! </strong>No se han actulizado tus datos<button type='button' class='close' data-dismiss='alert' aria-label='Close' style='padding-top: 0px;'><span aria-hidden='true'>&times;</span></button></div>"),setTimeout((function(){$("#alertasAD").html("")}),5e3)),t.next=18;break;case 16:$("#alertasAD").html("<div class='alert alert-danger alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Error! </strong>Por favor, ingresa todos los campos<button type='button' class='close' data-dismiss='alert' aria-label='Close' style='padding-top: 0px;'><span aria-hidden='true'>&times;</span></button></div>"),setTimeout((function(){$("#alertasAD").html("")}),5e3);case 18:this.$store.state.loader=!1;case 19:case"end":return t.stop()}}),t,this)})));function e(){return t.apply(this,arguments)}return e}()},computed:{Getdisabled:function(){return this.setDisabled},getShowTable:function(){return this.resultado},getContactos:function(){return this.contactos},isEmptyContacts:function(){return $.isEmptyObject(this.contactos)},logoGet:function(){return this.Getlogo}}},u=c,d=(a("9908"),a("2877")),p=Object(d["a"])(u,s,i,!1,null,"2f6d819a",null);e["default"]=p.exports},9908:function(t,e,a){"use strict";var s=a("09b1"),i=a.n(s);i.a}}]);
//# sourceMappingURL=chunk-19f8fff0.23244313.js.map