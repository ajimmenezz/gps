(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-7ecb47d9"],{4797:function(t,e,a){"use strict";a.r(e);var s=function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"row"},[a("div",{staticClass:"col-12"},[a("h5",{staticClass:"float-left",staticStyle:{"font-size":"20px","padding-bottom":"10px"}},[a("b",[t._v(t._s(this.title))])])]),a("div",{staticClass:"col-12"},[a("div",{staticClass:"card"},[a("div",{staticClass:"card-header row"},[a("div",{staticClass:"col-6"},["editar"==this.$store.state.modal.datosDymanic.accion?a("h5",{staticClass:" float-left"},[t._v("Editar")]):t._e(),"consultar"==this.$store.state.modal.datosDymanic.accion?a("h5",{staticClass:" float-left"},[t._v("Consultar")]):t._e(),"consultar"!=this.$store.state.modal.datosDymanic.accion&&"editar"!=this.$store.state.modal.datosDymanic.accion&&0!=this.seccion?a("h5",{staticClass:" float-left"},[t._v("Nuevo")]):t._e(),0==this.seccion?a("h5",{staticClass:" float-left"},[t._v("Mis datos")]):t._e()])]),a("div",{staticClass:"card-body float-left"},[a("form",{on:{submit:function(t){t.preventDefault()}}},[a("div",{staticClass:"row"},[a("div",{staticClass:"col-12"},[0==this.seccion?a("p",{staticClass:"text-muted",staticStyle:{"text-align":"justify","font-size":"12px","margin-top":"7px"}},[t._v("\n         A continuación podrás consultar y modificar tus datos personales asi como de contacto")]):t._e(),"editar"==this.$store.state.modal.datosDymanic.accion?a("p",{staticClass:"text-muted",staticStyle:{"text-align":"justify","font-size":"12px","margin-top":"7px"}},[t._v("\n         A continuación podrás consultar y modificar los datos personales asi como de contacto de tus clientes")]):t._e(),"consultar"!=this.$store.state.modal.datosDymanic.accion&&"editar"!=this.$store.state.modal.datosDymanic.accion&&0!=this.seccion?a("p",{staticClass:"text-muted",staticStyle:{"text-align":"justify","font-size":"12px","margin-top":"7px"}},[t._v("\n         A continuación podrás registrar los datos personales asi como de contacto de tus clientes")]):t._e()]),a("div",{staticClass:"col-12 col-md-4"},["editar"==this.$store.state.modal.datosDymanic.accion||0==this.seccion?a("p",[t._v("Nombre de la cuenta:\n                          "),a("b",[t._v(t._s(t.cuenta))])]):a("config-input",{attrs:{id:"name",label:"Nombre de la cuenta",typeinput:"text",placeholder:"Nombre de la cuenta",required:"true",valor:t.cuenta,disabled:t.visabled,toLowerUperCase:"lowercase"},model:{value:t.cuenta,callback:function(e){t.cuenta="string"===typeof e?e.trim():e},expression:"cuenta"}})],1),"editar"==this.$store.state.modal.datosDymanic.accion?a("div",{staticClass:"col-6"},[a("p",[t._v("Estado de la cuenta:\n                          "),1==t.active?a("b",[t._v("Activa")]):t._e(),0==t.active?a("b",[t._v("Suspendida")]):t._e()])]):t._e(),"editar"!=this.$store.state.modal.datosDymanic.accion&&0!=this.seccion?a("div",{staticClass:"col-12 col-md-4"},[a("config-input",{attrs:{id:"email",label:"Correo electrónico",typeinput:"email",placeholder:"Correo electrónico",required:"true",valor:t.email,toLowerUperCase:"lowercase"},model:{value:t.email,callback:function(e){t.email="string"===typeof e?e.trim():e},expression:"email"}})],1):t._e(),t._m(0),a("div",{staticClass:"col-12 col-md-4"},[a("div",{staticClass:"form-group "},[a("label",{attrs:{for:"selectStatusLegal"}},[t._v("Estado legal")]),a("select",{directives:[{name:"model",rawName:"v-model",value:t.statusLegal,expression:"statusLegal"}],staticClass:"form-control classdisabled ",attrs:{id:"selectStatusLegal",required:""},on:{change:[function(e){var a=Array.prototype.filter.call(e.target.options,(function(t){return t.selected})).map((function(t){var e="_value"in t?t._value:t.value;return e}));t.statusLegal=e.target.multiple?a:a[0]},function(e){return t.changeStatusLegal()}]}},[a("option",{attrs:{value:""}},[t._v("Selecciona")]),t._l(t.catLegalStatus,(function(e){return a("option",{key:e.id,domProps:{value:e.id}},[t._v(t._s(e.name))])}))],2)])]),a("div",{staticClass:"col-12 col-md-4"},[a("config-input",{attrs:{id:"nombreLegal",label:t.labelLegal,typeinput:"text",placeholder:t.labelLegal,required:"true",valor:t.nameLegal,toLowerUperCase:"uppercase"},model:{value:t.nameLegal,callback:function(e){t.nameLegal="string"===typeof e?e.trim():e},expression:"nameLegal"}})],1),a("div",{staticClass:"col-12 col-md-4",staticStyle:{display:"none"},attrs:{id:"divRFC"}},[a("config-input",{attrs:{id:"rfc",label:t.labelRFC,typeinput:"text",placeholder:t.labelRFC,required:"true",valor:t.rfc,toLowerUperCase:"uppercase"},model:{value:t.rfc,callback:function(e){t.rfc="string"===typeof e?e.trim():e},expression:"rfc"}})],1),a("div",{staticClass:"col-12 col-md-4"},[a("config-input",{attrs:{id:"pais",label:"País",typeinput:"text",placeholder:"País",required:"true",valor:t.pais,toLowerUperCase:"uppercase"},model:{value:t.pais,callback:function(e){t.pais="string"===typeof e?e.trim():e},expression:"pais"}})],1),a("div",{staticClass:"col-12 col-md-4"},[a("config-input",{attrs:{id:"region",label:"Región/Estado",typeinput:"text",placeholder:"Región/Estado",required:"true",valor:t.region,toLowerUperCase:"uppercase"},model:{value:t.region,callback:function(e){t.region="string"===typeof e?e.trim():e},expression:"region"}})],1),a("div",{staticClass:"col-12 col-md-4"},[a("config-input",{attrs:{id:"cp",label:"Código postal",typeinput:"text",placeholder:"Código postal",required:"true",valor:t.codep,toLowerUperCase:"uppercase"},model:{value:t.codep,callback:function(e){t.codep="string"===typeof e?e.trim():e},expression:"codep"}})],1),"editar"!=this.$store.state.modal.datosDymanic.accion?a("div",{staticClass:"col-12 col-md-4"},[a("div",{staticClass:"form-group "},[a("label",{attrs:{for:"zonaH"}},[t._v("Zona horaria")]),a("select",{directives:[{name:"model",rawName:"v-model",value:t.zonaH,expression:"zonaH"}],staticClass:"form-control classdisabled",attrs:{id:"zonaH",valor:t.zonaH,required:""},on:{change:function(e){var a=Array.prototype.filter.call(e.target.options,(function(t){return t.selected})).map((function(t){var e="_value"in t?t._value:t.value;return e}));t.zonaH=e.target.multiple?a:a[0]}}},[a("option",{attrs:{value:""}},[t._v("Selecciona")]),t._l(t.listZonaHoraria,(function(e){return a("option",{key:e.id,domProps:{value:e.id}},[t._v(t._s(e.name))])}))],2)])]):t._e(),a("div",{staticClass:"col-12 col-md-4"},[a("config-input",{attrs:{id:"addres",label:"Dirección",typeinput:"text",placeholder:"Dirección",required:"true",valor:t.addres,toLowerUperCase:"uppercase"},model:{value:t.addres,callback:function(e){t.addres="string"===typeof e?e.trim():e},expression:"addres"}})],1),a("div",{staticClass:"col-12 col-md-4"},[a("config-input",{attrs:{id:"notes",label:"Notas",typeinput:"text",placeholder:"Notas",required:"false",valor:t.notas},model:{value:t.notas,callback:function(e){t.notas="string"===typeof e?e.trim():e},expression:"notas"}})],1),"consultar"!=this.$store.state.modal.datosDymanic.accion?a("div",{staticClass:"col-12",staticStyle:{"margin-top":"50px"}},[a("h5",{staticClass:"float-left"},[t._v("Contactos")]),a("hr",{staticStyle:{"margin-top":"2rem"}})]):t._e(),"consultar"!=this.$store.state.modal.datosDymanic.accion?a("div",{staticClass:"col-12"},[a("div",{staticClass:"row float-left"},[a("div",{staticClass:"col-12 col-md-3"},[a("div",{staticClass:"form-group"},[a("label",{attrs:{for:"exampleFormControlSelect2"}},[t._v("Tipo contacto")]),a("select",{directives:[{name:"model",rawName:"v-model",value:t.tipoContac,expression:"tipoContac"}],staticClass:"form-control",attrs:{id:"exampleFormControlSelect2"},on:{change:function(e){var a=Array.prototype.filter.call(e.target.options,(function(t){return t.selected})).map((function(t){var e="_value"in t?t._value:t.value;return e}));t.tipoContac=e.target.multiple?a:a[0]}}},[a("option",{attrs:{value:"null"}},[t._v("Ninguno")]),t._l(t.catTipoContact,(function(e){return a("option",{key:e.id,domProps:{value:e.id}},[t._v(t._s(e.name))])}))],2)])]),a("div",{staticClass:"col-12 col-md-3"},[a("config-input",{attrs:{id:"nameContac",label:"Nombre",typeinput:"text",placeholder:"Nombre",required:"false",valor:t.nameContac,toLowerUperCase:"uppercase"},model:{value:t.nameContac,callback:function(e){t.nameContac="string"===typeof e?e.trim():e},expression:"nameContac"}})],1),a("div",{staticClass:"col-12 col-md-3"},[a("config-input",{attrs:{id:"telefono",label:"Teléfono",typeinput:"number",placeholder:"Teléfono",required:"false",valor:t.telefono},model:{value:t.telefono,callback:function(e){t.telefono="string"===typeof e?e.trim():e},expression:"telefono"}})],1),a("div",{staticClass:"col-12 col-md-3"},[a("config-input",{attrs:{id:"celular",label:"Celular",typeinput:"number",placeholder:"Celular",required:"false",valor:t.celular},model:{value:t.celular,callback:function(e){t.celular="string"===typeof e?e.trim():e},expression:"celular"}})],1),a("div",{staticClass:"col-12 col-md-4"},[a("config-input",{attrs:{id:"emailContac",label:"Correo electrónico",typeinput:"email",placeholder:"Correo electrónico",required:"false",valor:t.emailContac,toLowerUperCase:"lowercase"},model:{value:t.emailContac,callback:function(e){t.emailContac="string"===typeof e?e.trim():e},expression:"emailContac"}})],1),a("div",{staticClass:"col-10 col-md-7"},[a("config-input",{attrs:{id:"notasContac",label:"Notas",typeinput:"text",placeholder:"Notas",required:"false",valor:t.notasContac},model:{value:t.notasContac,callback:function(e){t.notasContac="string"===typeof e?e.trim():e},expression:"notasContac"}})],1),a("div",{staticClass:"col-2 col-md-1",staticStyle:{"padding-left":"0px"}},[a("button",{staticClass:"btn btn-icon btn-primary",staticStyle:{height:"35px","padding-top":"8px","margin-top":"32px"},attrs:{id:"agregarContac",type:"button"},on:{click:function(e){return t.agregarContac()}}},[a("i",{staticClass:"feather icon-plus"})])])])]):t._e(),a("div",{staticClass:"col-12",staticStyle:{"margin-top":"20px"}},[a("div",{staticClass:"row float-left",staticStyle:{width:"100%"}},[a("div",{staticClass:"col-12"},[a("h5",{staticClass:"float-left"},[t._v("Lista de contactos")]),0==t.contactos.length?a("hr",{staticStyle:{"margin-top":"2rem"}}):t._e()]),t.contactos.length>0?a("div",{staticClass:"col-12",staticStyle:{"margin-top":"15px",overflow:"auto","max-height":"300px"}},[a("table",{staticClass:"table table-hover header_fijo"},[t._m(1),a("tbody",t._l(t.contactos,(function(e,s){return a("tr",{key:s},[a("td",[t._v(t._s(s+1))]),a("td",[t._v(t._s(e.name))]),a("td",[t._v(t._s(e.tipo))]),a("td",[t._v(t._s(e.phone))]),a("td",[t._v(t._s(e.cel))]),a("td",[t._v(t._s(e.email))]),a("td",{staticClass:"classdisabled",attrs:{id:"btnEliminar"}},[a("span",{staticClass:"btnEliminar",on:{click:function(a){return t.eliminarcontac(e.id)}}},[a("i",{staticClass:"cursor icon-small icon universalicon-trash-2 colorText-red"})])])])})),0)])]):t._e(),0==t.contactos.length?a("div",{staticClass:"col-12",staticStyle:{overflow:"auto","max-height":"130px"}},[t._v("Sin contactos")]):t._e()])]),a("div",{staticClass:"col-12",staticStyle:{"margin-top":"40px"},attrs:{id:"alertasAD"}}),a("div",{staticClass:"col-12 ",staticStyle:{"margin-top":"15px"}},[0!=this.seccion?a("button",{staticClass:"btn btn-secondary shadow-2 mb-4 float-left",on:{click:function(e){return t.cancel()}}},[t._v("CANCELAR")]):t._e(),"editar"!=this.$store.state.modal.datosDymanic.accion&&"consultar"!=this.$store.state.modal.datosDymanic.accion&&0!=this.seccion?a("button",{staticClass:"btn btn-primary shadow-2 mb-4 float-right",attrs:{type:"submit"},on:{click:function(e){return t.SendForm()}}},[t._v("REGISTRAR")]):t._e(),"editar"==this.$store.state.modal.datosDymanic.accion||0==this.seccion?a("button",{staticClass:"btn btn-primary shadow-2 mb-4 float-right",attrs:{type:"submit"},on:{click:function(e){return t.SendForm()}}},[t._v("EDITAR")]):t._e()])])])])])])])},i=[function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"col-12",staticStyle:{"margin-top":"30px"}},[a("h5",{staticClass:"float-left"},[t._v("Datos legales")]),a("hr",{staticStyle:{"margin-top":"2rem"}})])},function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("thead",[a("tr",[a("th",[t._v("#")]),a("th",[t._v("contacto")]),a("th",[t._v("Tipo")]),a("th",[t._v("telefono")]),a("th",[t._v("celular")]),a("th",[t._v("correo")]),a("th",[t._v("Acciones")])])])}],o=(a("7514"),a("ac6a"),a("7f7f"),a("96cf"),a("3b8d")),n=a("08e6"),l=a("511d"),r=a("d3e3"),c={name:"FormDistribuidorCliente",mixins:[n["a"],l["a"]],data:function(){return{cuenta:null,email:null,statusLegal:"",labelLegal:null,labelRFC:null,nameLegal:null,rfc:null,pais:null,region:null,codep:null,notas:"",contactos:[],contactosFine:[],tipoContac:null,nameContac:null,telefono:null,celular:null,addres:null,emailContac:null,notasContac:null,catLegalStatus:[],catTipoContact:[],id:0,seccion:this.$route.params.id,title:null,zonaH:14,listZonaHoraria:[],visabled:!0,accionT:this.$store.state.modal.datosDymanic.accion,active:null}},created:function(){var t=Object(o["a"])(regeneratorRuntime.mark((function t(){return regeneratorRuntime.wrap((function(t){while(1)switch(t.prev=t.next){case 0:this.$store.state.loader=!0,this.catStatusLegal(),this.catPeople(),this.zonaHoraria(),"editar"==this.$store.state.modal.datosDymanic.accion&&this.getInfoCliente(),0==this.seccion&&this.getInfoMiPerfil();case 6:case"end":return t.stop()}}),t,this)})));function e(){return t.apply(this,arguments)}return e}(),mounted:function(){var t=Object(o["a"])(regeneratorRuntime.mark((function t(){return regeneratorRuntime.wrap((function(t){while(1)switch(t.prev=t.next){case 0:return 1==this.seccion&&(this.$store.state.modal.datosDymanic.accion,this.title="Distribuidor",this.$store.state.seccionMenu="Distribuidores"),2==this.seccion&&(this.title="Cliente","editar"==this.$store.state.modal.datosDymanic.accion&&(this.title="Cliente"),"consultar"==this.$store.state.modal.datosDymanic.accion&&(this.title="Cliente"),this.$store.state.seccionMenu="Clientes"),$("#containerPrincipal").css({"margin-left":this.$store.state.widthMenu}),$("#containerPrincipal").css({"margin-top":this.$store.state.topMenu}),this.changeStatusLegal(),this.$store.state.loader=!1,t.next=8,r["a"].$emit("NAVBAR_MenuSimple",this.$store.state.seccionMenu);case 8:if(0!=this.seccion){t.next=14;break}return this.$store.state.submenuActive="config",this.$store.state.itemSubmenuActive="itemPerfil",t.next=13,r["a"].$emit("NAVBAR_MenuOpciones","config","itemPerfil");case 13:this.title=" Mi cuenta";case 14:case"end":return t.stop()}}),t,this)})));function e(){return t.apply(this,arguments)}return e}(),methods:{getInfoCliente:function(){var t=Object(o["a"])(regeneratorRuntime.mark((function t(){var e,a,s,i=this;return regeneratorRuntime.wrap((function(t){while(1)switch(t.prev=t.next){case 0:return t.next=2,this.getRequest("accounts/".concat(this.$store.state.modal.datosDymanic.clientID));case 2:e=t.sent,console.debug(e),a=e.data.customer,this.active=a.active,this.cuenta=a.account,this.statusLegal=a.legal.statusID,this.nameLegal=a.legal.name,this.rfc=a.legal.taxID,this.pais=a.legal.country,this.region=a.legal.region,this.codep=a.legal.zipCode,this.notas=a.legal.notes,this.addres=a.legal.address,s=a.contacts,console.debug("CONTACTOS",s),s.forEach((function(t){i.contactos.push({id:t.id,idC:t.id,name:t.name,phone:t.phone,cel:t.cel,email:t.email,tipo:t.contactType}),i.contactosFine.push({id:t.id,idC:t.id,type:t.contactTypeID,name:t.name,phone:t.phone,cel:t.cel,email:t.email,notes:t.notes}),i.id++}));case 18:case"end":return t.stop()}}),t,this)})));function e(){return t.apply(this,arguments)}return e}(),getInfoMiPerfil:function(){var t=Object(o["a"])(regeneratorRuntime.mark((function t(){var e,a,s,i=this;return regeneratorRuntime.wrap((function(t){while(1)switch(t.prev=t.next){case 0:return t.next=2,this.getRequest("configuration/account");case 2:e=t.sent,console.debug(e),a=e.data.customer,this.active=a.active,this.cuenta=a.account,this.statusLegal=a.legal.statusID,this.nameLegal=a.legal.name,this.rfc=a.legal.taxID,this.pais=a.legal.country,this.region=a.legal.region,this.codep=a.legal.zipCode,this.notas=a.legal.notes,this.addres=a.legal.address,s=a.contacts,console.debug("CONTACTOS",s),s.forEach((function(t){i.contactos.push({id:t.id,idC:t.id,name:t.name,phone:t.phone,cel:t.cel,email:t.email,tipo:t.contactType}),i.contactosFine.push({id:t.id,idC:t.id,type:t.contactTypeID,name:t.name,phone:t.phone,cel:t.cel,email:t.email,notes:t.notes}),i.id++}));case 18:case"end":return t.stop()}}),t,this)})));function e(){return t.apply(this,arguments)}return e}(),catStatusLegal:function(){var t=Object(o["a"])(regeneratorRuntime.mark((function t(){var e,a;return regeneratorRuntime.wrap((function(t){while(1)switch(t.prev=t.next){case 0:return t.next=2,this.getRequest("catalogs/legalstatus");case 2:e=t.sent,a=e.data.legalStatus,this.catLegalStatus=a;case 5:case"end":return t.stop()}}),t,this)})));function e(){return t.apply(this,arguments)}return e}(),catPeople:function(){var t=Object(o["a"])(regeneratorRuntime.mark((function t(){var e,a;return regeneratorRuntime.wrap((function(t){while(1)switch(t.prev=t.next){case 0:return t.next=2,this.getRequest("catalogs/people");case 2:e=t.sent,a=e.data.peopleTypes,this.catTipoContact=a;case 5:case"end":return t.stop()}}),t,this)})));function e(){return t.apply(this,arguments)}return e}(),zonaHoraria:function(){var t=Object(o["a"])(regeneratorRuntime.mark((function t(){var e;return regeneratorRuntime.wrap((function(t){while(1)switch(t.prev=t.next){case 0:return t.next=2,this.getRequest("catalogs/timezones");case 2:e=t.sent,!0===e.success&&(this.listZonaHoraria=e.data.timezones);case 4:case"end":return t.stop()}}),t,this)})));function e(){return t.apply(this,arguments)}return e}(),changeStatusLegal:function(){$("#divRFC").css({display:"block"}),this.labelLegal="Nombre legal / razon social",this.labelRFC="RFC / ID legal"},agregarContac:function(){var t=Object(o["a"])(regeneratorRuntime.mark((function t(){var e,a,s,i,o,n,l,r=this;return regeneratorRuntime.wrap((function(t){while(1)switch(t.prev=t.next){case 0:if(null!=this.tipoContac&&""!=this.tipoContac){t.next=4;break}return $("#alertasAD").html("<div class='alert alert-danger alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Por favor, </strong>Selecciona tipo de contacto</div>"),setTimeout((function(){$("#alertasAD").html("")}),5e3),t.abrupt("return",!1);case 4:if(null!=this.nameContac){t.next=8;break}return $("#alertasAD").html("<div class='alert alert-danger alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Por favor, </strong>Ingresa nombre de contacto</div>"),setTimeout((function(){$("#alertasAD").html("")}),5e3),t.abrupt("return",!1);case 8:if(null!=this.telefono&&""!=this.telefono||null!=this.celular&&""!=this.celular){t.next=12;break}return $("#alertasAD").html("<div class='alert alert-danger alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Por favor, </strong>Ingresa teléfono o celular</div>"),setTimeout((function(){$("#alertasAD").html("")}),5e3),t.abrupt("return",!1);case 12:if(null!=this.emailContac&&""!=this.emailContac){t.next=16;break}return $("#alertasAD").html("<div class='alert alert-danger alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Por favor, </strong>Ingresa correo electrónico de contacto</div>"),setTimeout((function(){$("#alertasAD").html("")}),5e3),t.abrupt("return",!1);case 16:if(null==this.emailContac){t.next=22;break}if(e=this.validar_email(this.emailContac),e){t.next=22;break}return $("#alertasAD").html("<div class='alert alert-danger alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Error!, </strong>El correo no es valido</div>"),setTimeout((function(){$("#alertasAD").html("")}),5e3),t.abrupt("return",!1);case 22:if(this.$store.state.loader=!0,a=0,s=this.catTipoContact.find((function(t){return t.id==r.tipoContac})),!(this.contactos.length<3)){t.next=47;break}if(i=!0,"editar"!=this.$store.state.modal.datosDymanic.accion){t.next=36;break}return o={contactType:this.tipoContac,name:this.nameContac.toUpperCase(this.nameContac),phone:this.telefono,cel:this.celular,email:this.emailContac.toUpperCase(this.emailContac),notes:this.notasContac},n={},n["contact"]=o,console.debug("DATOOS",n),t.next=34,this.postRequest("accounts/"+this.$store.state.modal.datosDymanic.clientID+"/contacts",n);case 34:l=t.sent,!0===l.success?(i=!0,a=l.data.contactID,this.$store.state.loader=!1):(i=!1,this.$store.state.loader=!1,$("#alertasAD").html("<div class='alert alert-danger alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Error, </strong>No se ha agregado el contacto</div>"),setTimeout((function(){$("#alertasAD").html("")}),5e3));case 36:if(0!=this.seccion){t.next=46;break}return this.$store.state.loader=!0,o={contactType:this.tipoContac,name:this.nameContac.toUpperCase(this.nameContac),phone:this.telefono,cel:this.celular,email:this.emailContac.toUpperCase(this.emailContac),notes:this.notasContac},n={},n["contact"]=o,console.debug("DATOOS",n),t.next=44,this.postRequest("accounts/contacts",n);case 44:l=t.sent,!0===l.success?(a=l.data.contactID,this.$store.state.loader=!1,i=!0):(i=!1,this.$store.state.loader=!1,$("#alertasAD").html("<div class='alert alert-danger alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Error, </strong>No se ha agregado el contacto</div>"),setTimeout((function(){$("#alertasAD").html("")}),5e3));case 46:i&&("editar"!=this.$store.state.modal.datosDymanic.accion&&(a=this.id),this.contactos.push({id:a,idC:a,name:this.nameContac,phone:this.telefono,cel:this.celular,email:this.emailContac,tipo:s.name}),this.contactosFine.push({id:a,idC:a,type:this.tipoContac,name:this.nameContac.toUpperCase(this.nameContac),phone:this.telefono,cel:this.celular,email:this.emailContac.toUpperCase(this.emailContac),notes:this.notasContac}),this.id++);case 47:if(3!=this.contactos.length){t.next=57;break}return this.$store.state.loader=!1,$("#alertasAD").html("<div class='alert alert-info alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Excelente, </strong>Limite de 3 contactos alcanzado</div>"),setTimeout((function(){$("#alertasAD").html("")}),5e3),$("#agregarContac").attr("disabled","disabled"),this.nameContac=null,this.telefono=null,this.celular=null,this.emailContac=null,t.abrupt("return",!0);case 57:this.nameContac=null,this.telefono=null,this.celular=null,this.emailContac=null,this.$store.state.loader=!1;case 62:case"end":return t.stop()}}),t,this)})));function e(){return t.apply(this,arguments)}return e}(),eliminarcontac:function(){var t=Object(o["a"])(regeneratorRuntime.mark((function t(e){var a,s,i,o,n,l;return regeneratorRuntime.wrap((function(t){while(1)switch(t.prev=t.next){case 0:if(s=0,this.contactos.filter((function(t,i){if(t.id==e)return a=i,s=t,!0})),console.debug("TIPO",s,this.$store.state.modal.datosDymanic.accion,this.seccion),i=!0,this.$store.state.loader=!0,"editar"!=this.$store.state.modal.datosDymanic.accion&&0!=this.seccion){t.next=17;break}return o={},n={},t.next=10,this.deleteRequest("accounts/contacts/"+s.idC,o,n);case 10:return l=t.sent,t.t0=console,t.next=14,l;case 14:t.t1=t.sent,t.t0.debug.call(t.t0,"REQUEST_DELETE",t.t1),1==l.success?(this.$store.state.loader=!1,i=!0):(i=!1,this.$store.state.loader=!1,$("#alertasAD").html("<div class='alert alert-danger alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Error, </strong>No se ha eliminado el contacto</div>"),setTimeout((function(){$("#alertasAD").html("")}),5e3));case 17:i&&(this.contactos.splice(a,1),this.contactosFine.splice(a,1)),$("#agregarContac").removeAttr("disabled"),this.$store.state.loader=!1;case 20:case"end":return t.stop()}}),t,this)})));function e(e){return t.apply(this,arguments)}return e}(),SendForm:function(){var t=Object(o["a"])(regeneratorRuntime.mark((function t(){var e,a,s,i,o,n,l,r,c,u=this;return regeneratorRuntime.wrap((function(t){while(1)switch(t.prev=t.next){case 0:if(e=0,a="",0!=this.contactosFine.length){t.next=6;break}return $("#alertasAD").html("<div class='alert alert-danger alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Error! </strong>Debes agregar al menos un contacto<button type='button' class='close' data-dismiss='alert' aria-label='Close' style='padding-top: 0px;'><span aria-hidden='true'>&times;</span></button></div>"),setTimeout((function(){$("#alertasAD").html("")}),5e3),t.abrupt("return",!1);case 6:if(this.$store.state.loader=!0,"editar"!=this.$store.state.modal.datosDymanic.accion){t.next=22;break}if(console.debug("EDITAR CLIENTES_DISTRIBUIDOR"),""==this.statusLegal||null==this.statusLegal||null==this.nameLegal||""==this.nameLegal||null==this.pais||""==this.pais||null==this.region||""==this.region||null==this.codep||""==this.codep||null==this.addres||""==this.addres||null==this.rfc||""==this.rfc){t.next=20;break}return 1==this.seccion&&(e=2,a="distribuidor"),2==this.seccion&&(e=1,a="cliente"),s={},i={legal:{statusID:this.statusLegal,taxID:this.rfc.toUpperCase(this.rfc),name:this.nameLegal.toUpperCase(this.nameLegal),country:this.pais.toUpperCase(this.pais),region:this.region.toUpperCase(this.region),zipCode:this.codep.toUpperCase(this.codep),notes:this.notas,address:this.addres.toUpperCase(this.addres)}},s.customer=i,console.debug(i,"DATOS",s),t.next=18,this.putRequest("accounts/"+this.$store.state.modal.datosDymanic.clientID,s);case 18:o=t.sent,!0===o.success?(this.$store.state.loader=!1,$("#alertasAD").html("<div class='alert alert-success alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Excelente! </strong>Se ha actualizado el ".concat(a," <button type='button' class='close' data-dismiss='alert' aria-label='Close' style='padding-top: 0px;'><span aria-hidden='true'>&times;</span></button></div>")),setTimeout((function(){$("#alertasAD").html(""),u.cancel()}),3e3)):(this.$store.state.loader=!1,$("#alertasAD").html("<div class='alert alert-danger alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Error! </strong>No se ha actulizado<button type='button' class='close' data-dismiss='alert' aria-label='Close' style='padding-top: 0px;'><span aria-hidden='true'>&times;</span></button></div>"),setTimeout((function(){$("#alertasAD").html("")}),5e3));case 20:t.next=73;break;case 22:if(0!=this.seccion){t.next=36;break}if(console.debug("MI PERFIL"),""==this.statusLegal||null==this.statusLegal||null==this.nameLegal||""==this.nameLegal||null==this.pais||""==this.pais||null==this.region||""==this.region||null==this.codep||""==this.codep||null==this.addres||""==this.addres||null==this.rfc||""==this.rfc){t.next=34;break}return console.debug("MIS ENTRA"),s={},i={legal:{statusID:this.statusLegal,taxID:this.rfc.toUpperCase(this.rfc),name:this.nameLegal.toUpperCase(this.nameLegal),country:this.pais.toUpperCase(this.pais),region:this.region.toUpperCase(this.region),zipCode:this.codep.toUpperCase(this.codep),notes:this.notas,address:this.addres.toUpperCase(this.addres)}},s.customer=i,console.debug(i,"DATOS",s),t.next=32,this.putRequest("configuration/account",s);case 32:o=t.sent,!0===o.success?(this.$store.state.loader=!1,$("#alertasAD").html("<div class='alert alert-success alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Excelente! </strong>Se han actualizado tus datos<button type='button' class='close' data-dismiss='alert' aria-label='Close' style='padding-top: 0px;'><span aria-hidden='true'>&times;</span></button></div>"),setTimeout((function(){$("#alertasAD").html(""),u.cancel()}),3e3)):(this.$store.state.loader=!1,$("#alertasAD").html("<div class='alert alert-danger alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Error! </strong>No se han actulizado tus datos<button type='button' class='close' data-dismiss='alert' aria-label='Close' style='padding-top: 0px;'><span aria-hidden='true'>&times;</span></button></div>"),setTimeout((function(){$("#alertasAD").html("")}),5e3));case 34:t.next=73;break;case 36:if(console.debug("REGISTRO"),null==this.cuenta||""==this.cuenta||null==this.email||""==this.email||""==this.zonaH||null==this.zonaH||""==this.statusLegal||null==this.statusLegal||null==this.nameLegal||""==this.nameLegal||null==this.pais||""==this.pais||null==this.region||""==this.region||null==this.codep||""==this.codep||null==this.addres||""==this.addres||null==this.rfc||""==this.rfc){t.next=73;break}return 1==this.seccion&&(e=2,a="distribuidor"),2==this.seccion&&(e=1,a="cliente"),s={},n={type:e,name:this.cuenta.toLowerCase(this.cuenta),email:this.email.toLowerCase(this.email),timezone:this.zonaH},l={statusID:this.statusLegal,name:this.nameLegal.toUpperCase(this.nameLegal),country:this.pais.toUpperCase(this.pais),region:this.region.toUpperCase(this.region),zipCode:this.codep.toUpperCase(this.codep),notes:this.notas,address:this.addres.toUpperCase(this.addres),id:this.rfc.toUpperCase(this.rfc)},r=[],this.contactosFine.forEach((function(t){r.push({type:t.type,name:t.name.toUpperCase(t.name),phone:t.phone,cel:t.cel,email:t.email.toLowerCase(t.email),notes:t.notes})})),s["account"]=n,s["legal"]=l,s["contacts"]=r,console.debug("DATOS",s),t.next=51,this.postRequest("accounts",s);case 51:if(o=t.sent,!0!==o.success){t.next=58;break}this.$store.state.loader=!1,$("#alertasAD").html("<div class='alert alert-success alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Excelente! </strong>Se ha creado el ".concat(a," <button type='button' class='close' data-dismiss='alert' aria-label='Close' style='padding-top: 0px;'><span aria-hidden='true'>&times;</span></button></div>")),setTimeout((function(){$("#alertasAD").html(""),u.cancel()}),3e3),t.next=73;break;case 58:this.$store.state.loader=!1,c="",t.t0=o.error.title,t.next="USER_EXISTS"===t.t0?63:"EMAIL_EXISTS"===t.t0?65:"UNAUTHORIZED"===t.t0?67:69;break;case 63:return c="El usuario ya existe",t.abrupt("break",71);case 65:return c="El correo electrónico ya existe",t.abrupt("break",71);case 67:return c="No cuenta con los permisos para realizar la accion",t.abrupt("break",71);case 69:return c="No se ha podido crear el "+a,t.abrupt("break",71);case 71:$("#alertasAD").html("<div class='alert alert-danger alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Error! </strong>".concat(c," <button type='button' class='close' data-dismiss='alert' aria-label='Close' style='padding-top: 0px;'><span aria-hidden='true'>&times;</span></button></div>")),setTimeout((function(){$("#alertasAD").html("")}),5e3);case 73:this.$store.state.loader=!1;case 74:case"end":return t.stop()}}),t,this)})));function e(){return t.apply(this,arguments)}return e}(),cancel:function(){1==this.seccion&&this.$router.push("/ListTableDistrobuitor"),2==this.seccion&&this.$router.push("/ListTableClient")}}},u=c,d=(a("51ec"),a("2877")),h=Object(d["a"])(u,s,i,!1,null,"bc2d3572",null);e["default"]=h.exports},"51ec":function(t,e,a){"use strict";var s=a("a370"),i=a.n(s);i.a},a370:function(t,e,a){}}]);
//# sourceMappingURL=chunk-7ecb47d9.ff9e49f2.js.map