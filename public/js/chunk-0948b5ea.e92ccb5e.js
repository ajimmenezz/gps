(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-0948b5ea"],{"03d4":function(t,e,i){"use strict";var s=i("e88d"),a=i.n(s);a.a},e385:function(t,e,i){"use strict";i.r(e);var s=function(){var t=this,e=t.$createElement,i=t._self._c||e;return i("div",{staticClass:" row "},[i("div",{staticClass:"col-12"},[i("h5",{staticClass:"float-left",staticStyle:{"font-size":"20px","padding-bottom":"10px"}},["editar"!=t.accion?i("b",[t._v("Flotillas - Nueva flotilla")]):t._e(),"editar"==t.accion?i("b",[t._v("Flotillas - Editar flotilla")]):t._e()])]),i("div",{staticClass:" col-12"},[i("div",{staticClass:"card"},[i("div",{staticClass:"card-header row"},["editar"!=t.accion?i("h5",{staticClass:" float-left"},[t._v("Crear flotilla")]):t._e(),"editar"==t.accion?i("h5",{staticClass:" float-left"},[t._v("Editar flotilla")]):t._e()]),i("div",{staticClass:"card-body float-left"},[i("div",{staticClass:"row justify-content-center"},[t._m(0),i("div",{staticClass:"col-12 col-md-6"},[i("div",{staticClass:"row"},[i("div",{staticClass:"col-9"},[i("config-input",{attrs:{id:"alias",label:"Nombre de la flotilla",typeinput:"text",placeholder:"Nombre",required:"true",valor:t.alias},model:{value:t.alias,callback:function(e){t.alias="string"===typeof e?e.trim():e},expression:"alias"}})],1),i("hr"),t._m(1),i("div",{staticClass:"col-12"},[i("button",{staticClass:"btn btn-primary   m-b-10",staticStyle:{padding:"4px 11px","font-size":"14px"},attrs:{type:"button"},on:{click:t.agregarTodos}},[t._v("Seleccionar todos")]),i("button",{staticClass:"btn btn-primary   m-b-10",staticStyle:{padding:"4px 11px","font-size":"14px"},attrs:{type:"button"},on:{click:t.quitarTodos}},[t._v("Deseleccionar todos")])]),i("div",{staticClass:"col-12"},[i("select",{staticClass:"searchable",attrs:{id:"custom-headers",multiple:"multiple"}},t._l(t.dispositivoSinAsignar,(function(e){return i("option",{key:e.id,domProps:{value:e.id,selected:e.selectOptions}},[t._v(t._s(e.alias))])})),0)])])])]),t._m(2),i("div",{staticClass:"row  justify-content-center"},[i("div",{staticClass:"col-6 ",staticStyle:{"margin-top":"30px","text-align":"center"}},[i("button",{staticClass:"btn btn-secondary ",on:{click:function(e){return t.cancel()}}},[t._v("CANCELAR")]),"editar"!=t.accion?i("button",{staticClass:"btn btn-primary ",on:{click:function(e){return t.registrar()}}},[t._v("REGISTRAR")]):t._e(),"editar"==t.accion?i("button",{staticClass:"btn btn-primary ",on:{click:function(e){return t.editar()}}},[t._v("EDITAR")]):t._e()])])])])])])},a=[function(){var t=this,e=t.$createElement,i=t._self._c||e;return i("div",{staticClass:"col-12"},[i("p",{staticClass:"text-muted",staticStyle:{"text-align":"justify","font-size":"12px","margin-top":"7px"}},[t._v("\n           A continuación podrás agrupar unidades con un nombre especifico (flotilla) que poras visualizar en la sección de localizacion-dispositivos ")])])},function(){var t=this,e=t.$createElement,i=t._self._c||e;return i("div",{staticClass:"col-12 ",staticStyle:{"margin-top":"20px"}},[i("h5",[t._v("Asignar dispositivos a flotilla")])])},function(){var t=this,e=t.$createElement,i=t._self._c||e;return i("div",{staticClass:"row",staticStyle:{"margin-top":"20px"}},[i("div",{staticClass:"col-12",attrs:{id:"alerts"}})])}],l=(i("8615"),i("7f7f"),i("ac6a"),i("7514"),i("96cf"),i("3b8d")),r=i("08e6"),n=i("d3e3"),o={name:"FormularioFlotilla",mixins:[r["a"]],data:function(){return{alias:"",dispositivosFlotilla:[],accion:"",idFleet:0,dispositivoSinAsignar:[],dataFlotilla:[]}},created:function(){var t=Object(l["a"])(regeneratorRuntime.mark((function t(){return regeneratorRuntime.wrap((function(t){while(1)switch(t.prev=t.next){case 0:this.accion=this.$route.params.accion,this.idFleet=this.$route.params.id;case 2:case"end":return t.stop()}}),t,this)})));function e(){return t.apply(this,arguments)}return e}(),mounted:function(){var t=Object(l["a"])(regeneratorRuntime.mark((function t(){return regeneratorRuntime.wrap((function(t){while(1)switch(t.prev=t.next){case 0:return this.$store.commit("CLEAR_MODAL_DINAMIC"),this.$store.state.submenuActive="config",this.$store.state.itemSubmenuActive="itemFlotilla",t.next=5,n["a"].$emit("NAVBAR_MenuOpciones","config","itemFlotilla");case 5:return t.next=7,this.getDevices();case 7:return t.next=9,$(".searchable").multiSelect({selectableHeader:"<div class='custom-header'>Dispositivos disponibles</div><input type='text' class='form-control' autocomplete='off' placeholder='Disponibles'>",selectionHeader:"<div class='custom-header'>Dispositivos asignados</div><input type='text' class='form-control' autocomplete='off' placeholder='Asignados'>",afterInit:function(t){var e=this,i=e.$selectableUl.prev(),s=e.$selectionUl.prev(),a="#"+e.$container.attr("id")+" .ms-elem-selectable:not(.ms-selected)",l="#"+e.$container.attr("id")+" .ms-elem-selection.ms-selected";e.qs1=i.quicksearch(a).on("keydown",(function(t){if(40===t.which)return e.$selectableUl.focus(),!1})),e.qs2=s.quicksearch(l).on("keydown",(function(t){if(40==t.which)return e.$selectionUl.focus(),!1}))},afterSelect:function(t){var e=parseInt(t),i=0;i=this.dispositivosFlotilla.find((function(t){return t==e})),console.debug("DISP",i),void 0==i&&this.dispositivosFlotilla.push(e)}.bind(this),afterDeselect:function(t){var e;parseInt(t);this.dispositivosFlotilla.filter((function(i,s){if(i==t)return e=s,!0})),this.dispositivosFlotilla.splice(e,1)}.bind(this)});case 9:$("#containerPrincipal").css({"margin-left":this.$store.state.widthMenu}),$("#containerPrincipal").css({"margin-top":this.$store.state.topMenu}),this.$store.state.loader=!1;case 12:case"end":return t.stop()}}),t,this)})));function e(){return t.apply(this,arguments)}return e}(),methods:{agregarTodos:function(){var t=this;return console.debug("ENTRA TODOS"),this.dispositivoSinAsignar.forEach((function(e){var i=t.dispositivosFlotilla.find((function(t){return t==e.id}));console.debug("DISP",i),void 0==i&&t.dispositivosFlotilla.push(e.id)})),$(".searchable").multiSelect("select_all"),!1},quitarTodos:function(){return console.debug("quitar TODOS"),$(".searchable").multiSelect("deselect_all"),this.dispositivosFlotilla=[],!1},getFleet:function(){var t=Object(l["a"])(regeneratorRuntime.mark((function t(){var e,i,s,a,l=this;return regeneratorRuntime.wrap((function(t){while(1)switch(t.prev=t.next){case 0:return t.next=2,this.getRequest("fleets/"+this.idFleet);case 2:e=t.sent,!0===e.success&&(i=e.data.fleet),this.dataFlotilla=i,this.alias=i.name,s=i.devices,a=Object.values(this.$store.state.devices.devices),a.forEach((function(t){s.forEach((function(e){parseInt(t.id)==e&&(l.dispositivoSinAsignar.push({id:parseInt(t.id),alias:t.alias,selectOptions:!0}),l.dispositivosFlotilla.push(parseInt(t.id)))}))}));case 9:case"end":return t.stop()}}),t,this)})));function e(){return t.apply(this,arguments)}return e}(),getDevices:function(){var t=Object(l["a"])(regeneratorRuntime.mark((function t(){var e,i=this;return regeneratorRuntime.wrap((function(t){while(1)switch(t.prev=t.next){case 0:if(e=Object.values(this.$store.state.devices.devices),this.dispositivoSinAsignar=[],e.forEach((function(t){null==t.fleetID&&i.dispositivoSinAsignar.push({id:parseInt(t.id),alias:t.alias,selectOptions:!1})})),"editar"!==this.accion){t.next=6;break}return t.next=6,this.getFleet();case 6:case"end":return t.stop()}}),t,this)})));function e(){return t.apply(this,arguments)}return e}(),registrar:function(){var t=Object(l["a"])(regeneratorRuntime.mark((function t(){var e,i,s,a,l,r=this;return regeneratorRuntime.wrap((function(t){while(1)switch(t.prev=t.next){case 0:if(""!==this.alias){t.next=4;break}return $("#alerts").html("<div class='alert alert-danger alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Error! </strong>Por favor ingresa por lo menos el nombre de la flotilla</div>"),setTimeout((function(){$("#alerts").html("")}),3e3),t.abrupt("return",!1);case 4:if(!(this.dispositivosFlotilla.length<=0)){t.next=8;break}return $("#alerts").html("<div class='alert alert-danger alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Error! </strong>Por favor selecciona por lo menos 1 dispositivo</div>"),setTimeout((function(){$("#alerts").html("")}),3e3),t.abrupt("return",!1);case 8:return e={name:this.alias,devices:this.dispositivosFlotilla},i={},i["fleet"]=e,t.next=13,this.postRequest("fleets",i);case 13:s=t.sent,!0===s.success?(a=s.data.fleetID,l=Object.values(this.$store.state.devices.devices),l.forEach((function(t){r.dispositivosFlotilla.forEach((function(e){parseInt(t.id)==e&&(t.fleetID=a,r.$store.state.devices.devices[t.imei].fleetID=a)}))})),$("#alerts").html("<div class='alert alert-success alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Excelente! </strong>Se ha registrado la flotilla<button type='button' class='close' data-dismiss='alert' aria-label='Close' style='padding-top: 0px;'><span aria-hidden='true'>&times;</span></button></div>"),setTimeout((function(){$("#alerts").html(""),r.cancel()}),3e3)):$("#alerts").html("<div class='alert alert-danger alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Error! </strong>No se ha registrado la flotilla<button type='button' class='close' data-dismiss='alert' aria-label='Close' style='padding-top: 0px;'><span aria-hidden='true'>&times;</span></button></div>");case 15:case"end":return t.stop()}}),t,this)})));function e(){return t.apply(this,arguments)}return e}(),editar:function(){var t=Object(l["a"])(regeneratorRuntime.mark((function t(){var e,i,s,a,l,r,n,o=this;return regeneratorRuntime.wrap((function(t){while(1)switch(t.prev=t.next){case 0:if(""!==this.alias){t.next=4;break}return $("#alerts").html("<div class='alert alert-danger alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Error! </strong>Por favor ingresa por lo menos el nombre de la flotilla</div>"),setTimeout((function(){$("#alerts").html("")}),3e3),t.abrupt("return",!1);case 4:if(!(this.dispositivosFlotilla.length<=0)){t.next=8;break}return $("#alerts").html("<div class='alert alert-danger alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Error! </strong>Por favor ingresa por lo menos 1 dispositivo</div>"),setTimeout((function(){$("#alerts").html("")}),3e3),t.abrupt("return",!1);case 8:return this.dispositivosFlotilla.length<=0&&(this.dispositivosFlotilla=[]),e={name:this.alias,devices:this.dispositivosFlotilla},i={},i["fleet"]=e,t.next=14,this.putRequest("fleets/"+this.idFleet,i);case 14:s=t.sent,!0===s.success?(a=this.idFleet,l=this.dataFlotilla.devices,r=Object.values(this.$store.state.devices.devices),r.forEach((function(t){l.forEach((function(e){parseInt(t.id)==e&&(t.fleetID=null,o.$store.state.devices.devices[t.imei].fleetID=null)}))})),n=Object.values(this.$store.state.devices.devices),n.forEach((function(t){o.dispositivosFlotilla.forEach((function(e){parseInt(t.id)==e&&(t.fleetID=a,o.$store.state.devices.devices[t.imei].fleetID=a)}))})),$("#alerts").html("<div class='alert alert-success alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Excelente! </strong>Se ha actualizado la flotilla<button type='button' class='close' data-dismiss='alert' aria-label='Close' style='padding-top: 0px;'><span aria-hidden='true'>&times;</span></button></div>"),setTimeout((function(){$("#alerts").html(""),o.cancel()}),3e3)):$("#alerts").html("<div class='alert alert-danger alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Error! </strong>No se ha actualizado la flotilla<button type='button' class='close' data-dismiss='alert' aria-label='Close' style='padding-top: 0px;'><span aria-hidden='true'>&times;</span></button></div>");case 16:case"end":return t.stop()}}),t,this)})));function e(){return t.apply(this,arguments)}return e}(),cancel:function(){this.$router.push("/flotillas")}},computed:{}},c=o,d=(i("03d4"),i("2877")),u=Object(d["a"])(c,s,a,!1,null,null,null);e["default"]=u.exports},e88d:function(t,e,i){}}]);
//# sourceMappingURL=chunk-0948b5ea.e92ccb5e.js.map