(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-2a5c2016"],{"1b65":function(t,e,s){"use strict";var a=function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",{staticClass:"modal fade ",attrs:{id:"modalPolicies",tabindex:"-1",role:"dialog","aria-labelledby":"exampleModalCenterTitle","aria-hidden":"true"}},[s("div",{staticClass:"modal-dialog  ",attrs:{role:"document"}},[s("div",{staticClass:"modal-content"},[t._m(0),t._m(1),s("div",{staticClass:"modal-footer"},[s("div",{staticClass:"col-12"},[s("button",{staticClass:"btn btn-secondary",attrs:{id:"guardar",type:"button"},on:{click:function(e){return t.cancel()}}},[t._v("CERRAR")])])])])])])},r=[function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",{staticClass:"modal-header"},[s("h5",{staticClass:"modal-title",attrs:{id:"exampleModalCenterTitle"}},[t._v("Políticas de Uso")]),s("button",{staticClass:"close",attrs:{type:"button","data-dismiss":"modal","aria-label":"Close"}},[s("span",{attrs:{"aria-hidden":"true"}},[t._v("×")])])])},function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",{staticClass:"modal-body "},[s("div",{staticClass:"container"},[s("div",{staticClass:"row"},[s("div",{staticClass:"col-12"},[s("p",{staticClass:"float-left"},[t._v("\n                                Lorem, ipsum dolor sit amet consectetur adipisicing elit. Quisquam vitae officia nihil commodi inventore nulla dolores sequi, iure ab in. Consequuntur alias aut, cum iure nisi necessitatibus perspiciatis ab aspernatur?\n                            ")])])])])])}],i={name:"panelDePoliticas",mounted:function(){$("#modalPolicies").modal("show")},methods:{cancel:function(){this.$store.commit("CLEAR_MODAL_DINAMIC"),$("#modalPolicies").modal("hide")}},computed:{}},n=i,o=s("2877"),c=Object(o["a"])(n,a,r,!1,null,null,null);e["a"]=c.exports},"47a7":function(t,e,s){"use strict";s.d(e,"a",(function(){return a}));var a={data:function(){return{}},methods:{ValidatePassword:function(t,e){if(t===e){if(t.length>=8){for(var s=!1,a=!1,r=!1,i=!1,n=0;n<t.length;n++)t.charCodeAt(n)>=65&&t.charCodeAt(n)<=90?s=!0:t.charCodeAt(n)>=97&&t.charCodeAt(n)<=122?a=!0:t.charCodeAt(n)>=48&&t.charCodeAt(n)<=57?r=!0:(t.charCodeAt(n)>=35&&t.charCodeAt(n)<=38||t.charCodeAt(n)>=45&&t.charCodeAt(n)<=46)&&(i=!0);if(1==s&&1==a&&1==i&&1==r)return 1}return 0}return 2}}}},a998:function(t,e,s){"use strict";s.r(e);var a=function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",{staticClass:" row justify-content-md-center"},[t._m(0),s("div",{staticClass:"col-12 col-md-6"},[s("div",{staticClass:"card"},[t.statusPasswordFirst?s("h5",{staticClass:"card-header"},[t._v("Nueva contraseña")]):t._e(),t.statusPasswordFirst?t._e():s("h5",{staticClass:"card-header"},[t._v("Resetear contraseña")]),s("div",{staticClass:"card-body"},[t.statusPasswordFirst?s("p",{staticClass:"card-text"},[t._v("Actualmente no cuenta con una contraseña para confirmar eventos con sus dispositivos.  Puede definir una contraseña llenando lo campos solicitados.")]):t._e(),t.statusPasswordFirst?t._e():s("p",{staticClass:"card-text"},[t._v("Usa el formulario de abajo para cambiar la  contraseña.")]),t.passwordExpired?t._e():s("p",{staticClass:"card-text"},[t._v("Usa el formulario de abajo para cambiar la  contraseña.")]),s("div",{staticClass:"row justify-content-center"},[s("div",{staticClass:"col-8"},[s("config-input",{attrs:{id:"pwd",label:"null",typeinput:"password",placeholder:"Contraseña",valor:t.passw,required:"true",disabled:t.resetea},model:{value:t.passw,callback:function(e){t.passw="string"===typeof e?e.trim():e},expression:"passw"}}),s("config-input",{attrs:{id:"pwd2",label:"null",typeinput:"password",placeholder:"Confirma contraseña",valor:t.confirmPassw,required:"true",disabled:t.resetea},model:{value:t.confirmPassw,callback:function(e){t.confirmPassw="string"===typeof e?e.trim():e},expression:"confirmPassw"}})],1)]),s("div",{staticClass:"col-12",attrs:{id:"alertasCP"}}),s("div",{staticClass:"row justify-content-center"},[s("div",{staticClass:"col-5"},[s("button",{staticClass:"btn btn-secondary",attrs:{id:"cancel",type:"button"},on:{click:function(e){return t.cancelar()}}},[t._v("CANCELAR")])]),s("div",{staticClass:"col-5"},[t.statusPasswordFirst||!t.statusPasswordFirst&&!t.resetea?s("button",{staticClass:"btn btn-primary",attrs:{id:"confirm",type:"button"},on:{click:function(e){return t.saveEventPassword()}}},[t._v("GUARDAR")]):t._e(),!t.statusPasswordFirst&&t.resetea?s("button",{staticClass:"btn btn-primary",attrs:{id:"confirm",type:"button"},on:{click:function(e){return t.funResetea()}}},[t._v("RESETEAR")]):t._e()])]),t._m(1),s("div",{staticClass:"col-12",staticStyle:{"margin-top":"30px"}},[s("span",{staticClass:"col-12 text-muted ",staticStyle:{cursor:"pointer"},on:{click:function(e){return t.showPoliciesPanel()}}},[t._v("Politicas de uso")])])])])])])},r=[function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",{staticClass:"col-12"},[s("h5",{staticClass:"float-left",staticStyle:{"font-size":"20px","padding-bottom":"10px"}},[s("b",[t._v("Configurar dispositivos - Contraseña de eventos")])])])},function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",{staticClass:"col-12",staticStyle:{"margin-top":"15px"}},[s("p",{staticClass:"text-muted"},[s("b",[t._v("Nota:")]),t._v(" Esta contraseña se utiliza para activar diferentes eventos de los dispositivo.  Por lo que se recomienda utilizar con precaución")])])}],i=(s("96cf"),s("3b8d")),n=s("08e6"),o=s("1b65"),c=s("47a7"),l={name:"no",mixins:[c["a"],n["a"]],components:{politicas:o["a"]},data:function(){return{havePassword:!1,passwEvent:null,checkPasswEvent:null,confirmPassw:"",passw:"",resetea:!0,statusPasswordFirst:!1,PasswordExpired:!1}},created:function(){var t=Object(i["a"])(regeneratorRuntime.mark((function t(){return regeneratorRuntime.wrap((function(t){while(1)switch(t.prev=t.next){case 0:return t.next=2,this.passwordExist();case 2:case"end":return t.stop()}}),t,this)})));function e(){return t.apply(this,arguments)}return e}(),mounted:function(){var t=Object(i["a"])(regeneratorRuntime.mark((function t(){return regeneratorRuntime.wrap((function(t){while(1)switch(t.prev=t.next){case 0:this.$store.state.submenuActive="config",this.$store.state.itemSubmenuActive="itemDevice",$("#containerPrincipal").css({"margin-left":this.$store.state.widthMenu}),$("#containerPrincipal").css({"margin-top":this.$store.state.topMenu});case 4:case"end":return t.stop()}}),t,this)})));function e(){return t.apply(this,arguments)}return e}(),methods:{passwordExist:function(){var t=Object(i["a"])(regeneratorRuntime.mark((function t(){var e,s;return regeneratorRuntime.wrap((function(t){while(1)switch(t.prev=t.next){case 0:return t.next=2,this.getRequest("configuration/eventpassword/exists");case 2:return s=t.sent,console.debug("requesPassword",s),e=!0===s.success&&s.data.eventPasswordExists,e?this.statusPasswordFirst=!1:this.statusPasswordFirs=!0,this.statusPasswordFirst?this.resetea=!1:this.resetea=!0,this.resetea&&($("#pwd").attr("disabled","disabled"),$("#pwd2").attr("disabled","disabled")),this.resetea||($("#pwd").removeAttr("disabled"),$("#pwd2").removeAttr("disabled")),t.abrupt("return",e);case 10:case"end":return t.stop()}}),t,this)})));function e(){return t.apply(this,arguments)}return e}(),passwordExpired:function(){var t=Object(i["a"])(regeneratorRuntime.mark((function t(){var e,s,a;return regeneratorRuntime.wrap((function(t){while(1)switch(t.prev=t.next){case 0:return t.next=2,this.getRequest("configuration/eventpassword/expiration");case 2:return s=t.sent,e=!0===s.success&&s.data.timestampExpiration,0!=e&&(a=Math.floor(Date.now()/1e3),console.debug("timestampsNow",a,e),a<=e?(console.debug("No ha expirado"),e=!0):(console.debug("ya expiro"),e=!1),this.resetea=!1),this.PasswordExpired=e,t.abrupt("return",e);case 7:case"end":return t.stop()}}),t,this)})));function e(){return t.apply(this,arguments)}return e}(),funResetea:function(){this.resetea=!1,$("#pwd").removeAttr("disabled"),$("#pwd2").removeAttr("disabled")},saveEventPassword:function(){var t=Object(i["a"])(regeneratorRuntime.mark((function t(){var e,s,a,r=this;return regeneratorRuntime.wrap((function(t){while(1)switch(t.prev=t.next){case 0:if(""===this.passw||""===this.confirmPassw||null===this.passw||null===this.confirmPassw){t.next=12;break}if(e=this.ValidatePassword(this.passw,this.confirmPassw),1!==e){t.next=9;break}return s={password:this.passw},t.next=6,this.putRequest("configuration/eventpassword",s);case 6:a=t.sent,console.log("RESPUESTA",a),!0===a.success?($("#alertasCP").html("<div class='alert alert-success alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Excelente! </strong>Se ha guardado la contraseña. </br> Por favor revisar su correo donde se le ha mandado la nueva contraseña. Se recomienda leer las políticas de uso antes de utilizar la contraseña en el sistema.<button type='button' class='close' data-dismiss='alert' aria-label='Close' style='padding-top: 0px;'><span aria-hidden='true'>&times;</span></button></div>"),setTimeout((function(){console.log("setTime"),$("#alertasCP").html(""),r.cancelar()}),6e3)):$("#alertasCP").html("<div class='alert alert-danger alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Error! </strong>No se ha guardado la contraseña<button type='button' class='close' data-dismiss='alert' aria-label='Close' style='padding-top: 0px;'><span aria-hidden='true'>&times;</span></button></div>");case 9:0===e&&$("#alertasCP").html("<div class='alert alert-danger alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Error! </strong>La contraseña debe contener como minimo 8 caracteres (entre ellos: mayúsculas, minúculas, números y caracteres especiales) <button type='button' class='close' data-dismiss='alert' aria-label='Close' style='padding-top: 0px;'><span aria-hidden='true'>&times;</span></button></div>"),t.next=14;break;case 12:$("#alertasCP").html("<div class='alert alert-danger alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Error! </strong>Por favor ingresa todos los campos <button type='button' class='close' data-dismiss='alert' aria-label='Close' style='padding-top: 0px;'><span aria-hidden='true'>&times;</span></button></div>"),setTimeout((function(){$("#alertasCP").html("")}),3e3);case 14:case"end":return t.stop()}}),t,this)})));function e(){return t.apply(this,arguments)}return e}(),cancelar:function(){this.passw=null,this.confirmPassw=null,this.$router.push("/listDevice")},showPoliciesPanel:function(){var t=Object(i["a"])(regeneratorRuntime.mark((function t(){var e;return regeneratorRuntime.wrap((function(t){while(1)switch(t.prev=t.next){case 0:return this.$store.commit("CLEAR_MODAL_DINAMIC"),e={component:o["a"]},t.next=4,this.$store.commit("ADD_COMPONENT_DINAMIC",e);case 4:return t.next=6,this.$store.commit("ADD_COMPONENT_DINAMIC_STATE",!0);case 6:case"end":return t.stop()}}),t,this)})));function e(){return t.apply(this,arguments)}return e}()}},d=l,u=s("2877"),p=Object(u["a"])(d,a,r,!1,null,null,null);e["default"]=p.exports}}]);
//# sourceMappingURL=chunk-2a5c2016.25899ff0.js.map