(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-95c89212"],{"91e0":function(e,t,s){"use strict";var a=s("d941"),r=s.n(a);r.a},d941:function(e,t,s){},e9c0:function(e,t,s){"use strict";s.r(t);var a=function(){var e=this,t=e.$createElement,s=e._self._c||t;return s("div",{staticClass:"card-body float-left row"},[s("div",{staticClass:"col-12"},[s("config-input",{attrs:{id:"userName",label:"Nombre *",typeinput:"text",placeholder:"Nombre",required:"true",valor:e.userName},model:{value:e.userName,callback:function(t){e.userName="string"===typeof t?t.trim():t},expression:"userName"}})],1),s("div",{staticClass:"col-12"},[s("config-input",{attrs:{id:"apaterno",label:"Apellido paterno *",typeinput:"text",placeholder:"Apellido Paterno",required:"true",valor:e.apaterno},model:{value:e.apaterno,callback:function(t){e.apaterno="string"===typeof t?t.trim():t},expression:"apaterno"}})],1),s("div",{staticClass:"col-12"},[s("config-input",{attrs:{id:"amaterno",label:"Apellido materno *",typeinput:"text",placeholder:"Apellido materno",required:"true",valor:e.amaterno},model:{value:e.amaterno,callback:function(t){e.amaterno="string"===typeof t?t.trim():t},expression:"amaterno"}})],1),s("div",{staticClass:"col-12"},[s("config-input",{attrs:{id:"user",label:"Usuario *",typeinput:"text",placeholder:"Usuario",required:"true",valor:e.user,toLowerUperCase:"lowercase"},on:{input:e.onKeyUp},model:{value:e.user,callback:function(t){e.user="string"===typeof t?t.trim():t},expression:"user"}})],1),s("div",{staticClass:"col-12 "},[s("config-input",{attrs:{id:"notas",label:"Notas",typeinput:"text",placeholder:"Notas",required:"false",valor:e.notas},model:{value:e.notas,callback:function(t){e.notas="string"===typeof t?t.trim():t},expression:"notas"}})],1),s("div",{staticClass:"col-12",staticStyle:{"margin-top":"40px","margin-bottom":"15px"},attrs:{id:"alertUser"}}),s("div",{staticClass:"col-12  float-right"},[e.Getdisabled?e._e():s("button",{staticClass:"btn btn-primary",attrs:{id:"editSubmit",type:"submit"},on:{click:function(t){return e.editarCampos(!0)}}},[e._v("Editar")]),e.Getdisabled?s("button",{staticClass:"btn btn-outline-primary ",attrs:{type:"button"},on:{click:function(t){return e.cancel()}}},[e._v("Cancelar")]):e._e(),e.Getdisabled?s("button",{staticClass:"btn btn-primary ",attrs:{id:"registerSubmit",type:"submit"},on:{click:function(t){return e.editar()}}},[e._v("Guardar")]):e._e()])])},r=[],i=(s("8615"),s("ac6a"),s("7f7f"),s("96cf"),s("3b8d")),n=s("08e6"),o=s("d3e3"),u={name:"FormularioEditLegalesUSer",mixins:[n["a"]],data:function(){return{userName:"",user:"",password:"",email:"",telefono:0,direc:"",tipoUser:0,apaterno:"",amaterno:"",dispositivosUser:[],dispositivos_list:[],accion:"",userID:"",userData:[],permisos:[],listZonaHoraria:[],zonaH:14,getDevicesUser:[],showDevice:!1,deviceesUs:[],listPermissions:[],notas:null,dynamicComponent:{component:null,properties:null,events:{}},visible:!1,setDisabled:!0}},created:function(){var e=Object(i["a"])(regeneratorRuntime.mark((function e(){return regeneratorRuntime.wrap((function(e){while(1)switch(e.prev=e.next){case 0:this.accion=this.$route.params.accion,this.userID=this.$route.params.id;case 2:case"end":return e.stop()}}),e,this)})));function t(){return e.apply(this,arguments)}return t}(),mounted:function(){var e=Object(i["a"])(regeneratorRuntime.mark((function e(){return regeneratorRuntime.wrap((function(e){while(1)switch(e.prev=e.next){case 0:return this.editarCampos(!1),this.$store.state.submenuActive="config",this.$store.state.itemSubmenuActive="itemUser",e.next=5,o["a"].$emit("NAVBAR_MenuOpciones","config","itemUser");case 5:return e.next=7,this.getUser(this.userID);case 7:$("#containerPrincipal").css({"margin-left":this.$store.state.widthMenu}),$("#containerPrincipal").css({"margin-top":this.$store.state.topMenu}),$(".sw-btn-next").click((function(){window.scrollTo(0,0)})),$(".sw-btn-prev").click((function(){window.scrollTo(0,0)})),this.$store.state.loader=!1;case 12:case"end":return e.stop()}}),e,this)})));function t(){return e.apply(this,arguments)}return t}(),methods:{editarCampos:function(e){console.debug("editarCampos",e),this.setDisabled=e,1==e&&($("#userName").removeAttr("disabled"),$("#apaterno").removeAttr("disabled"),$("#amaterno").removeAttr("disabled"),$("#user").removeAttr("disabled"),$("#notas").removeAttr("disabled"),$("#editSubmit").html("Guardar")),0==e&&($("#userName").attr("disabled","disabled"),$("#apaterno").attr("disabled","disabled"),$("#amaterno").attr("disabled","disabled"),$("#user").attr("disabled","disabled"),$("#notas").attr("disabled","disabled"),$("#editSubmit").html("Editar"))},getUser:function(){var e=Object(i["a"])(regeneratorRuntime.mark((function e(t){var s,a,r,i=this;return regeneratorRuntime.wrap((function(e){while(1)switch(e.prev=e.next){case 0:return e.next=2,this.getRequest("users/"+t);case 2:s=e.sent,!0===s.success&&(this.userData=s.data.user,this.userName=this.userData.name,this.user=this.userData.username,this.email=this.userData.email,this.telefono=this.userData.phone,this.direc=this.userData.address,this.tipoUser=this.userData.userType,this.apaterno=this.userData.paternalSurname,this.amaterno=this.userData.maternalSurname,this.zonaH=this.userData.timezoneID,this.notas=this.userData.notes,this.permisos=this.userData.permissions,a=[],this.permisos.forEach((function(e){var t=e.id;a.push(t)})),this.permisos=Object.values(a),$("#permisos").val(this.permisos),this.getDevicesUser=[],this.dispositivosUser=[],r=s.data.devices,this.deviceesUs=s.data.devices,r.forEach((function(e){var t;i.dispositivos_list.filter((function(s,a){if(s.id==e.id)return t=a,!0})),i.dispositivos_list.splice(t,1)})),r.forEach((function(e){i.dispositivos_list.push({id:parseInt(e.id),alias:e.alias,selectOptions:!0}),i.dispositivosUser.push(parseInt(e.id))}))),this.showDevice=!0;case 5:case"end":return e.stop()}}),e,this)})));function t(t){return e.apply(this,arguments)}return t}(),editar:function(){var e=Object(i["a"])(regeneratorRuntime.mark((function e(){var t,s,a,r,i,n=this;return regeneratorRuntime.wrap((function(e){while(1)switch(e.prev=e.next){case 0:if(""!=this.user){e.next=4;break}return $("#alertUser").html("<div class='alert alert-danger alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Error! </strong>Ingresa usuario<button type='button' class='close' data-dismiss='alert' aria-label='Close' style='padding-top: 0px;'><span aria-hidden='true'>&times;</span></button></div>"),setTimeout((function(){$("#alertUser").html("")}),3e3),e.abrupt("return",!1);case 4:return t=2,s={userType:t,notes:this.notas,name:this.userName,paternalSurname:this.apaterno,maternalSurname:this.amaterno},a={},a["user"]=s,this.user!==this.userData.username&&(a.user.username=this.user),e.next=11,this.putRequest("users/"+this.userID,a);case 11:if(r=e.sent,!0!==r.success){e.next=17;break}$("#alertUser").html("<div class='alert alert-success alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Excelente! </strong>Se ha actualizado el usuario<button type='button' class='close' data-dismiss='alert' aria-label='Close' style='padding-top: 0px;'><span aria-hidden='true'>&times;</span></button></div>"),setTimeout((function(){$("#alertUser").html(""),n.getUser(n.userID)}),3e3),e.next=30;break;case 17:i="",e.t0=r.error.title,e.next="USER_EXISTS"===e.t0?21:"EMAIL_EXISTS"===e.t0?23:"UNAUTHORIZED"===e.t0?25:27;break;case 21:return i="El usuario ya existe",e.abrupt("break",29);case 23:return i="El correo electrónico ya existe",e.abrupt("break",29);case 25:return i="No cuenta con los permisos para realizar la accion",e.abrupt("break",29);case 27:return i="No se ha actualizado el usuario",e.abrupt("break",29);case 29:$("#alertUser").html("<div class='alert alert-danger alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Error! </strong>".concat(i,"<button type='button' class='close' data-dismiss='alert' aria-label='Close' style='padding-top: 0px;'><span aria-hidden='true'>&times;</span></button></div>"));case 30:case"end":return e.stop()}}),e,this)})));function t(){return e.apply(this,arguments)}return t}(),onKeyUp:function(e){var t=e.toLowerCase();this.user=t},cancel:function(){this.$router.push("/listaUsers")}},computed:{Getdisabled:function(){return this.setDisabled}}},l=u,c=(s("91e0"),s("2877")),d=Object(c["a"])(l,a,r,!1,null,null,null);t["default"]=d.exports}}]);
//# sourceMappingURL=chunk-95c89212.7a656742.js.map