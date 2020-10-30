(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-c2493670"],{"01f4":function(t,e,s){"use strict";s.r(e);var a=function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",{staticClass:" row "},[t._m(0),s("div",{staticClass:" col-12"},[s("div",{staticClass:"card"},[s("div",{staticClass:"card-header row"},[s("div",{staticClass:"col-6"},["editar"!=t.accion?s("h5",{staticClass:" float-left"},[t._v("Crear usuario")]):t._e(),"editar"==t.accion?s("h5",{staticClass:" float-left"},[t._v("Editar usuario")]):t._e()])]),s("div",{staticClass:"card-body float-left"},[s("div",{attrs:{id:"smartwizard"}},[t._m(1),s("div",[s("div",{staticClass:"mpConf",attrs:{id:"step-1"}},[s("div",{staticClass:"row"},[t._m(2),s("div",{staticClass:"col-12"},["editar"==t.accion?s("p",{staticClass:"text-muted",staticStyle:{"text-align":"justify","font-size":"12px","margin-top":"7px"}},[t._v("\n           A continuación podras consultar y modifcar los datos personales del usuario, agregar/quitar los permisos que tiene en la plataforma asi como que dispositivos que podrá visulizar y monitorear")]):s("p",{staticClass:"text-muted",staticStyle:{"text-align":"justify","font-size":"12px","margin-top":"7px"}},[t._v("\n           A continuación podras registrar los datos personales del usuario, agregarle los permisos que tendrá en la plataforma asi como que dispositivos que podrá visulizar y monitorear")])]),s("hr"),s("div",{staticClass:"col-6"},[s("config-input",{attrs:{id:"name",label:"Nombre",typeinput:"text",placeholder:"Nombre",required:"true",valor:t.userName},model:{value:t.userName,callback:function(e){t.userName="string"===typeof e?e.trim():e},expression:"userName"}})],1),s("div",{staticClass:"col-6"},[s("config-input",{attrs:{id:"name1",label:"Apellido paterno",typeinput:"text",placeholder:"Apellido Paterno",required:"true",valor:t.apaterno},model:{value:t.apaterno,callback:function(e){t.apaterno="string"===typeof e?e.trim():e},expression:"apaterno"}})],1)]),s("div",{staticClass:"row"},[s("div",{staticClass:"col-6"},[s("config-input",{attrs:{id:"ap2",label:"Apellido materno",typeinput:"text",placeholder:"Apellido materno",required:"true",valor:t.amaterno},model:{value:t.amaterno,callback:function(e){t.amaterno="string"===typeof e?e.trim():e},expression:"amaterno"}})],1),s("div",{staticClass:"col-6"},[s("config-input",{attrs:{id:"user_minus",label:"Usuario",typeinput:"text",placeholder:"Usuario",required:"true",valor:t.user,toLowerUperCase:"lowercase"},on:{input:t.onKeyUp},model:{value:t.user,callback:function(e){t.user="string"===typeof e?e.trim():e},expression:"user"}})],1)]),s("hr"),s("div",{staticClass:"row"},[s("div",{staticClass:"col-6"},[s("config-input",{attrs:{id:"email",label:"Correo electrónico",typeinput:"email",placeholder:"Correo electrónico",required:"true",valor:t.email,toLowerUperCase:"lowercase"},model:{value:t.email,callback:function(e){t.email="string"===typeof e?e.trim():e},expression:"email"}})],1),s("div",{staticClass:"col-6"},[s("config-input",{attrs:{id:"tel",label:"Teléfono",typeinput:"number",placeholder:"Teléfono",required:"true",valor:t.telefono},model:{value:t.telefono,callback:function(e){t.telefono="string"===typeof e?e.trim():e},expression:"telefono"}})],1),s("div",{staticClass:"col-6"},[s("config-input",{attrs:{id:"direc",label:"Dirección",typeinput:"text",placeholder:"Dirección",required:"true",valor:t.direc},model:{value:t.direc,callback:function(e){t.direc="string"===typeof e?e.trim():e},expression:"direc"}})],1),s("div",{staticClass:"col-6"},[s("div",{staticClass:"form-group"},[s("label",{attrs:{for:"zonaH"}},[t._v("Zona horaria")]),s("select",{directives:[{name:"model",rawName:"v-model",value:t.zonaH,expression:"zonaH"}],staticClass:"form-control",attrs:{id:"zonaH",valor:t.zonaH},on:{change:function(e){var s=Array.prototype.filter.call(e.target.options,(function(t){return t.selected})).map((function(t){var e="_value"in t?t._value:t.value;return e}));t.zonaH=e.target.multiple?s:s[0]}}},[s("option",{attrs:{value:"0"}},[t._v("Selecciona")]),t._l(t.listZonasHor,(function(e){return s("option",{key:e.id,domProps:{value:e.id}},[t._v(t._s(e.name))])}))],2)])]),s("div",{staticClass:"col-6"},[s("config-input",{attrs:{id:"notes",label:"Notas",typeinput:"text",placeholder:"Notas",required:"false",valor:t.notas},model:{value:t.notas,callback:function(e){t.notas="string"===typeof e?e.trim():e},expression:"notas"}})],1)]),s("div",{staticClass:"row",staticStyle:{"margin-top":"30px"}},[s("div",{staticClass:"col-6"},[s("button",{staticClass:"btn btn-secondary float-left",staticStyle:{position:"absolute","z-index":"10000"},on:{click:function(e){return t.cancel()}}},[t._v("CANCELAR")])])])]),s("div",{staticClass:"mpConf",attrs:{id:"step-2"}},[s("div",{staticClass:"row"},[t._m(3),t._m(4),s("hr"),s("div",{staticClass:"col-12"},[s("config-text-typography",{attrs:{texto:"Asignar permisos:"}}),s("select",{staticClass:"js-example-basic-multiple col-sm-12",attrs:{id:"permisos",multiple:"multiple"}},t._l(t.listPermissions,(function(e){return s("option",{key:e.id,domProps:{value:e.id}},[t._v(t._s(e.name))])})),0),1==this.$store.state.clientType?s("div",{staticClass:"text-muted",staticStyle:{"margin-top":"20px","text-align":"justify","font-size":"12px"}},[s("b",[t._v("Nota: ")]),t._v("Los usuarios  tendran por default asignados los permiso de: "),s("br"),s("span",{staticClass:"badge badge-secondary",staticStyle:{"font-size":"11px !important"}},[t._v("SECCION LOCALIZACIÓN")]),t._v(" \n                              "),s("span",{staticClass:"badge badge-secondary",staticStyle:{"font-size":"11px !important","margin-bottom":"10px"}},[t._v("GESTION DE GEOCERCAS Y PI")])]):t._e()],1)]),s("hr"),1==this.$store.state.clientType?s("div",{staticClass:"row"},[t._m(5),t._m(6),s("div",{staticClass:"col-12"},[s("button",{staticClass:"btn btn-primary   m-b-10",staticStyle:{padding:"4px 11px","font-size":"14px"},attrs:{type:"button"},on:{click:t.agregarTodos}},[t._v("Seleccionar todos")]),s("button",{staticClass:"btn btn-primary   m-b-10",staticStyle:{padding:"4px 11px","font-size":"14px"},attrs:{type:"button"},on:{click:t.quitarTodos}},[t._v("Deseleccionar todos")])]),s("div",{staticClass:"col-12"},[s("select",{staticClass:"searchable",attrs:{id:"custom-headers",multiple:"multiple"}},t._l(t.listDEviceC,(function(e){return s("option",{key:e.id,domProps:{value:e.id,selected:e.selectOptions}},[t._v(t._s(e.alias))])})),0)])]):t._e(),t._m(7),s("div",{staticClass:"row  justify-content-center"},[s("div",{staticClass:"col-6 ",staticStyle:{"margin-top":"30px","text-align":"center"}},[s("button",{staticClass:"btn btn-secondary ",on:{click:function(e){return t.cancel()}}},[t._v("CANCELAR")]),"editar"!==t.accion?s("button",{staticClass:"btn btn-primary ",attrs:{type:"submit"},on:{click:function(e){return t.register()}}},[t._v("REGISTRAR")]):t._e(),"editar"===t.accion?s("button",{staticClass:"btn btn-primary ",attrs:{type:"submit"},on:{click:function(e){return t.editar()}}},[t._v("EDITAR")]):t._e()])])])])])])])])])},i=[function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",{staticClass:"col-12"},[s("h5",{staticClass:"float-left",staticStyle:{"font-size":"20px","padding-bottom":"10px"}},[s("b",[t._v("Usuarios")])])])},function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("ul",[s("li",[s("a",{attrs:{href:"#step-1"}},[s("h6",[t._v("Paso 1")]),s("p",{staticClass:"m-0"},[t._v("Datos")])])]),s("li",[s("a",{attrs:{href:"#step-2"}},[s("h6",[t._v("Paso 2")]),s("p",{staticClass:"m-0"},[t._v("Permisos")])])])])},function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",{staticClass:"col-12 "},[s("h5",[t._v("Datos")])])},function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",{staticClass:"col-12 "},[s("h5",[t._v("Permisos")])])},function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",{staticClass:"col-12"},[s("p",{staticClass:"text-muted",staticStyle:{"text-align":"justify","font-size":"12px","margin-top":"7px"}},[t._v("\n           A continuación podras agregar o quitar los permisos que tendrá el usuario en la plataforma asi como que dispositivos que podrá visulizar y monitorear.")])])},function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",{staticClass:"col-12 "},[s("h5",[t._v("Dispositivos a visualizar")])])},function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",{staticClass:"col-12"},[s("p",{staticClass:"text-muted",staticStyle:{"text-align":"justify","font-size":"12px","margin-top":"7px"}},[t._v("\n           A continuación podrás seleccionar que dispositivos podrá visualizar el usuario")])])},function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",{staticClass:"row",staticStyle:{"margin-top":"20px"}},[s("div",{staticClass:"col-12",attrs:{id:"alertUser"}})])}],r=(s("7f7f"),s("8615"),s("ac6a"),s("7514"),s("96cf"),s("3b8d")),n=s("08e6"),o=s("d3e3"),l={name:"FormularioUsers",mixins:[n["a"]],data:function(){return{userName:"",user:"",password:"",email:"",telefono:0,direc:"",tipoUser:0,apaterno:"",amaterno:"",dispositivosUser:[],dispositivos_list:[],accion:"",userID:"",userData:[],permisos:[],listZonaHoraria:[],zonaH:14,getDevicesUser:[],showDevice:!1,deviceesUs:[],listPermissions:[],notas:null}},created:function(){var t=Object(r["a"])(regeneratorRuntime.mark((function t(){return regeneratorRuntime.wrap((function(t){while(1)switch(t.prev=t.next){case 0:this.accion=this.$route.params.accion,this.userID=this.$route.params.id,this.zonaHoraria(),this.catPermissions();case 4:case"end":return t.stop()}}),t,this)})));function e(){return t.apply(this,arguments)}return e}(),mounted:function(){var t=Object(r["a"])(regeneratorRuntime.mark((function t(){return regeneratorRuntime.wrap((function(t){while(1)switch(t.prev=t.next){case 0:return this.$store.state.submenuActive="config",this.$store.state.itemSubmenuActive="itemUser",t.next=4,o["a"].$emit("NAVBAR_MenuOpciones","config","itemUser");case 4:return t.next=6,this.getDevices();case 6:return $("#containerPrincipal").css({"margin-left":this.$store.state.widthMenu}),$("#containerPrincipal").css({"margin-top":this.$store.state.topMenu}),t.next=10,$(".searchable").multiSelect({selectableHeader:"<input type='text' class='form-control' autocomplete='off' placeholder='Disponibles'>",selectionHeader:"<input type='text' class='form-control' autocomplete='off' placeholder='Asignados'>",afterInit:function(t){var e=this,s=e.$selectableUl.prev(),a=e.$selectionUl.prev(),i="#"+e.$container.attr("id")+" .ms-elem-selectable:not(.ms-selected)",r="#"+e.$container.attr("id")+" .ms-elem-selection.ms-selected";e.qs1=s.quicksearch(i).on("keydown",(function(t){if(40===t.which)return e.$selectableUl.focus(),!1})),e.qs2=a.quicksearch(r).on("keydown",(function(t){if(40==t.which)return e.$selectionUl.focus(),!1}))},afterSelect:function(){var t=Object(r["a"])(regeneratorRuntime.mark((function t(e){var s,a;return regeneratorRuntime.wrap((function(t){while(1)switch(t.prev=t.next){case 0:s=parseInt(e),a=this.dispositivosUser.find((function(t){return t==s})),console.debug("DISP",a),void 0==a&&this.dispositivosUser.push(s);case 4:case"end":return t.stop()}}),t,this)})));return function(e){return t.apply(this,arguments)}}().bind(this),afterDeselect:function(){var t=Object(r["a"])(regeneratorRuntime.mark((function t(e){var s;return regeneratorRuntime.wrap((function(t){while(1)switch(t.prev=t.next){case 0:parseInt(e),this.dispositivosUser.filter((function(t,a){if(t==e)return s=a,!0})),this.dispositivosUser.splice(s,1);case 3:case"end":return t.stop()}}),t,this)})));return function(e){return t.apply(this,arguments)}}().bind(this)});case 10:$("#smartwizard").smartWizard({theme:"dots",transitionEffect:"fade",autoAdjustHeight:!1,useURLhash:!1,showStepURLhash:!1}),$("#smartwizard .sw-toolbar").appendTo($("#smartwizard .sw-container")),$(".js-example-basic-multiple").select2({placeholder:"Selecciona permisos",tags:!0,tokenSeparators:[","," "]}),this.$store.state.loader=!1,$(".sw-btn-next").click((function(){window.scrollTo(0,0)})),$(".sw-btn-prev").click((function(){window.scrollTo(0,0)}));case 16:case"end":return t.stop()}}),t,this)})));function e(){return t.apply(this,arguments)}return e}(),methods:{agregarTodos:function(){var t=this;return console.debug("ENTRA TODOS"),this.dispositivos_list.forEach((function(e){var s=t.dispositivosUser.find((function(t){return t==e.id}));console.debug("DISP",s),void 0==s&&t.dispositivosUser.push(e.id)})),$(".searchable").multiSelect("select_all"),!1},quitarTodos:function(){return console.debug("quitar TODOS"),$(".searchable").multiSelect("deselect_all"),this.dispositivosUser=[],!1},getDevices:function(){var t=Object(r["a"])(regeneratorRuntime.mark((function t(){var e,s=this;return regeneratorRuntime.wrap((function(t){while(1)switch(t.prev=t.next){case 0:if(e=Object.values(this.$store.state.devices.devices),this.dispositivos_list=[],e.forEach((function(t){s.dispositivos_list.push({id:parseInt(t.id),alias:t.alias,selectOptions:!1})})),"editar"!==this.accion){t.next=8;break}return t.next=6,this.getUser(this.userID);case 6:t.next=9;break;case 8:this.showDevice=!0;case 9:case"end":return t.stop()}}),t,this)})));function e(){return t.apply(this,arguments)}return e}(),catPermissions:function(){var t=Object(r["a"])(regeneratorRuntime.mark((function t(){var e,s,a=this;return regeneratorRuntime.wrap((function(t){while(1)switch(t.prev=t.next){case 0:return t.next=2,this.getRequest("permissions");case 2:e=t.sent,!0===e.success&&(s=e.data.permissions,1==this.$store.state.clientType?s.forEach((function(t){1!=t.id&&16!=t.id&&a.listPermissions.push({id:t.id,code:t.code,name:t.name})})):this.listPermissions=s);case 4:case"end":return t.stop()}}),t,this)})));function e(){return t.apply(this,arguments)}return e}(),register:function(){var t=Object(r["a"])(regeneratorRuntime.mark((function t(){var e,s,a,i,r,n,o,l,c=this;return regeneratorRuntime.wrap((function(t){while(1)switch(t.prev=t.next){case 0:if(""!=this.user){t.next=4;break}return $("#alertUser").html("<div class='alert alert-danger alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Error! </strong>Ingresa usuario<button type='button' class='close' data-dismiss='alert' aria-label='Close' style='padding-top: 0px;'><span aria-hidden='true'>&times;</span></button></div>"),setTimeout((function(){$("#alertUser").html("")}),3e3),t.abrupt("return",!1);case 4:if(""==this.email){t.next=12;break}if(e=this.validar_email(this.email),e){t.next=10;break}return $("#alertUser").html("<div class='alert alert-danger alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Error! </strong>El correo electrónico no es valido<button type='button' class='close' data-dismiss='alert' aria-label='Close' style='padding-top: 0px;'><span aria-hidden='true'>&times;</span></button></div>"),setTimeout((function(){$("#alertUser").html("")}),3e3),t.abrupt("return",!1);case 10:t.next=15;break;case 12:return $("#alertUser").html("<div class='alert alert-danger alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Error! </strong>Ingresa correo electrónico<button type='button' class='close' data-dismiss='alert' aria-label='Close' style='padding-top: 0px;'><span aria-hidden='true'>&times;</span></button></div>"),setTimeout((function(){$("#alertUser").html("")}),3e3),t.abrupt("return",!1);case 15:if(0!=this.zonaH){t.next=19;break}return $("#alertUser").html("<div class='alert alert-danger alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Error! </strong>Selecciona zona horaria<button type='button' class='close' data-dismiss='alert' aria-label='Close' style='padding-top: 0px;'><span aria-hidden='true'>&times;</span></button></div>"),setTimeout((function(){$("#alertUser").html("")}),3e3),t.abrupt("return",!1);case 19:return s=2,a=$("#permisos").val(),i=[],1==this.$store.state.clientType&&(i.push(1),i.push(16)),a.forEach((function(t){t=parseInt(t),i.push(t)})),r={userType:s,timezone:this.zonaH,username:this.user.toLowerCase(this.user),email:this.email.toLowerCase(this.email),notes:this.notas,name:this.userName,paternalSurname:this.apaterno,maternalSurname:this.amaterno,phone:this.telefono,permissions:i,address:this.direc},n={},n["user"]=r,n["devices"]=[],1==this.$store.state.clientType&&(n.clientID=0,n.userType=this.tipoUser,n["devices"]=Object.values(this.dispositivosUser)),t.next=31,this.postRequest("users",n);case 31:if(o=t.sent,!0!==o.success){t.next=37;break}$("#alertUser").html("<div class='alert alert-success alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Excelente! </strong>Se ha creado el usuario<button type='button' class='close' data-dismiss='alert' aria-label='Close' style='padding-top: 0px;'><span aria-hidden='true'>&times;</span></button></div>"),setTimeout((function(){$("#alertUser").html(""),c.cancel()}),3e3),t.next=51;break;case 37:l="",t.t0=o.error.title,t.next="USER_EXISTS"===t.t0?41:"EMAIL_EXISTS"===t.t0?43:"UNAUTHORIZED"===t.t0?45:47;break;case 41:return l="El usuario ya existe",t.abrupt("break",49);case 43:return l="El correo electrónico ya existe",t.abrupt("break",49);case 45:return l="No cuenta con los permisos para realizar la accion",t.abrupt("break",49);case 47:return l="No se ha creado el usuario",t.abrupt("break",49);case 49:$("#alertUser").html("<div class='alert alert-danger alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Error! </strong>".concat(l,"<button type='button' class='close' data-dismiss='alert' aria-label='Close' style='padding-top: 0px;'><span aria-hidden='true'>&times;</span></button></div>")),setTimeout((function(){$("#alertUser").html("")}),3e3);case 51:case"end":return t.stop()}}),t,this)})));function e(){return t.apply(this,arguments)}return e}(),editar:function(){var t=Object(r["a"])(regeneratorRuntime.mark((function t(){var e,s,a,i,n,o,l,c,u,p,d,m=this;return regeneratorRuntime.wrap((function(t){while(1)switch(t.prev=t.next){case 0:if(""!=this.user){t.next=4;break}return $("#alertUser").html("<div class='alert alert-danger alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Error! </strong>Ingresa usuario<button type='button' class='close' data-dismiss='alert' aria-label='Close' style='padding-top: 0px;'><span aria-hidden='true'>&times;</span></button></div>"),setTimeout((function(){$("#alertUser").html("")}),3e3),t.abrupt("return",!1);case 4:if(""==this.email){t.next=12;break}if(e=this.validar_email(this.email),e){t.next=10;break}return $("#alertUser").html("<div class='alert alert-danger alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Error! </strong>El correo electrónico no es valido<button type='button' class='close' data-dismiss='alert' aria-label='Close' style='padding-top: 0px;'><span aria-hidden='true'>&times;</span></button></div>"),setTimeout((function(){$("#alertUser").html("")}),3e3),t.abrupt("return",!1);case 10:t.next=15;break;case 12:return $("#alertUser").html("<div class='alert alert-danger alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Error! </strong>Ingresa correo electrónico<button type='button' class='close' data-dismiss='alert' aria-label='Close' style='padding-top: 0px;'><span aria-hidden='true'>&times;</span></button></div>"),setTimeout((function(){$("#alertUser").html("")}),3e3),t.abrupt("return",!1);case 15:if(0!=this.zonaH){t.next=19;break}return $("#alertUser").html("<div class='alert alert-danger alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Error! </strong>Selecciona zona horaria<button type='button' class='close' data-dismiss='alert' aria-label='Close' style='padding-top: 0px;'><span aria-hidden='true'>&times;</span></button></div>"),setTimeout((function(){$("#alertUser").html("")}),3e3),t.abrupt("return",!1);case 19:return s=$("#permisos").val(),a=[],1==this.$store.state.clientType&&(a.push(1),a.push(16)),s.forEach((function(t){t=parseInt(t),a.push(t)})),i=2,n={userType:i,timezone:this.zonaH,notes:this.notas,name:this.userName,paternalSurname:this.apaterno,maternalSurname:this.amaterno,phone:this.telefono,permissions:a,address:this.direc},o={},o["user"]=n,this.user!==this.userData.username&&(o.user.username=this.user),e=!1,this.email!==this.userData.email?o.user.email=this.email.toLowerCase(this.email):e=!0,t.next=32,this.putRequest("users/"+this.userID,o);case 32:if(l=t.sent,!0!==l.success){t.next=48;break}return!1,!1,c=this.deviceesUs,c.forEach(function(){var t=Object(r["a"])(regeneratorRuntime.mark((function t(e){var s;return regeneratorRuntime.wrap((function(t){while(1)switch(t.prev=t.next){case 0:return t.next=2,m.deleteRequest("users/"+m.userID+"/devices/"+e.id);case 2:s=t.sent,!0===s.success;case 4:case"end":return t.stop()}}),t)})));return function(e){return t.apply(this,arguments)}}()),u={},u["devices"]=Object.values(this.dispositivosUser),t.next=42,this.postRequest("users/"+this.userID+"/devices",u);case 42:p=t.sent,!0===p.success,$("#alertUser").html("<div class='alert alert-success alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Excelente! </strong>Se ha actualizado el usuario<button type='button' class='close' data-dismiss='alert' aria-label='Close' style='padding-top: 0px;'><span aria-hidden='true'>&times;</span></button></div>"),setTimeout((function(){$("#alertUser").html(""),m.cancel()}),3e3),t.next=61;break;case 48:d="",t.t0=l.error.title,t.next="USER_EXISTS"===t.t0?52:"EMAIL_EXISTS"===t.t0?54:"UNAUTHORIZED"===t.t0?56:58;break;case 52:return d="El usuario ya existe",t.abrupt("break",60);case 54:return d="El correo electrónico ya existe",t.abrupt("break",60);case 56:return d="No cuenta con los permisos para realizar la accion",t.abrupt("break",60);case 58:return d="No se ha actualizado el usuario",t.abrupt("break",60);case 60:$("#alertUser").html("<div class='alert alert-danger alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Error! </strong>".concat(d,"<button type='button' class='close' data-dismiss='alert' aria-label='Close' style='padding-top: 0px;'><span aria-hidden='true'>&times;</span></button></div>"));case 61:case"end":return t.stop()}}),t,this)})));function e(){return t.apply(this,arguments)}return e}(),validar_email:function(t){var e=/^[-\w.%+]{1,64}@(?:[A-Z0-9-]{1,63}\.){1,125}[A-Z]{2,63}$/i;return!!e.test(t)},getUser:function(){var t=Object(r["a"])(regeneratorRuntime.mark((function t(e){var s,a,i,r=this;return regeneratorRuntime.wrap((function(t){while(1)switch(t.prev=t.next){case 0:return t.next=2,this.getRequest("users/"+e);case 2:s=t.sent,!0===s.success&&(this.userData=s.data.user,this.userName=this.userData.name,this.user=this.userData.username,this.email=this.userData.email,this.telefono=this.userData.phone,this.direc=this.userData.address,this.tipoUser=this.userData.userType,this.apaterno=this.userData.paternalSurname,this.amaterno=this.userData.maternalSurname,this.zonaH=this.userData.timezoneID,this.notas=this.userData.notes,this.permisos=this.userData.permissions,a=[],this.permisos.forEach((function(t){var e=t.id;a.push(e)})),this.permisos=Object.values(a),$("#permisos").val(this.permisos),this.getDevicesUser=[],this.dispositivosUser=[],i=s.data.devices,this.deviceesUs=s.data.devices,i.forEach((function(t){var e;r.dispositivos_list.filter((function(s,a){if(s.id==t.id)return e=a,!0})),r.dispositivos_list.splice(e,1)})),i.forEach((function(t){r.dispositivos_list.push({id:parseInt(t.id),alias:t.alias,selectOptions:!0}),r.dispositivosUser.push(parseInt(t.id))}))),this.showDevice=!0;case 5:case"end":return t.stop()}}),t,this)})));function e(e){return t.apply(this,arguments)}return e}(),zonaHoraria:function(){var t=Object(r["a"])(regeneratorRuntime.mark((function t(){var e;return regeneratorRuntime.wrap((function(t){while(1)switch(t.prev=t.next){case 0:return t.next=2,this.getRequest("catalogs/timezones");case 2:e=t.sent,!0===e.success&&(this.listZonaHoraria=e.data.timezones);case 4:case"end":return t.stop()}}),t,this)})));function e(){return t.apply(this,arguments)}return e}(),onKeyUp:function(t){var e=t.toLowerCase();this.user=e},cancel:function(){this.$router.push("/listUser")}},computed:{listZonasHor:function(){return this.listZonaHoraria},listDEviceC:function(){return this.dispositivos_list},getTypeUser:function(){return this.$store.state.userType,this.$store.state.clientType,this.dispositivos_list}}},c=l,u=(s("9290"),s("2877")),p=Object(u["a"])(c,a,i,!1,null,null,null);e["default"]=p.exports},"0c8c":function(t,e,s){},9290:function(t,e,s){"use strict";var a=s("0c8c"),i=s.n(a);i.a}}]);
//# sourceMappingURL=chunk-c2493670.a25411bd.js.map