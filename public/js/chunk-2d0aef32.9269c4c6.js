(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-2d0aef32"],{"0bf0":function(t,e,s){"use strict";s.r(e);var i=function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",{staticClass:"row m-r-5"},[s("div",{staticClass:"col-12",staticStyle:{"margin-top":"20px"}},[s("h5",{staticClass:"float-left",staticStyle:{"padding-bottom":"10px"}},[s("b",[t._v("Eliminar / "+t._s(this.title))])])]),s("div",{staticClass:"col-12",staticStyle:{"margin-top":"-15px"}},[s("h6",{staticClass:"float-left",staticStyle:{"padding-bottom":"10px"}},[t._v("A continuación te mostramos un formulario donde podras rescatar productos del "+t._s(this.title))]),s("hr",{staticStyle:{"margin-top":"25px"}})]),s("div",{staticClass:"col-12"},[s("div",{staticClass:"card"},[s("div",{staticClass:"card-body float-left"},[s("form",{on:{submit:function(t){t.preventDefault()}}},[s("div",{staticClass:"row"},[s("div",{staticClass:"col-12",staticStyle:{"margin-top":"10px"}},[s("h5",{staticClass:"float-left"},[t._v("Cliente "+t._s(this.$store.state.modal.datosDymanic.nameCliente))])]),s("div",{staticClass:"row justify-content-center",staticStyle:{"margin-top":"10px","margin-bottom":"20px"}},[s("div",{staticClass:"col-12 col-md-10 text-center"},[t._v("En esta sección podrás recuperar los productos de tus cliente "+t._s(this.$store.state.modal.datosDymanic.nameCliente)+"\n                                           selecciona los productos a recuperar rellenando los siguientes campos\n                                           (los producto recuperados se mostrarán en la lista de abajo)\n                                        ")])]),2==this.$store.state.modal.datosDymanic.seccion?s("div",{staticClass:"col-12",staticStyle:{"margin-top":"10px"}},[s("h5",{staticClass:"float-left"},[t._v("Clientes a recuperar")]),s("hr",{staticStyle:{"margin-top":"2rem"}})]):t._e(),2==this.$store.state.modal.datosDymanic.seccion?s("div",{staticClass:" col-8 col-sm-6 col-md-4"},[s("m-select",{ref:"customerSelect",attrs:{data:t.listCustomers,filterby:"name",title:"Clientes"},on:{selectionChanged:t.OnCustomerSelected}})],1):t._e(),2==this.$store.state.modal.datosDymanic.seccion?s("div",{staticClass:"col-4 "},[s("button",{staticClass:" shadow-2 mb-4 btn btn-primary",staticStyle:{"margin-top":"30px"},attrs:{type:"button"},on:{click:function(e){return t.agregarCustomer()}}},[t._v("AGREGAR")])]):t._e(),2==this.$store.state.modal.datosDymanic.seccion?s("div",{staticClass:"col-12",staticStyle:{"margin-top":"15px"}},[s("table",{staticClass:"table table-hover header_fijo"},[t._m(0),s("tbody",t._l(t.listCustomersFin,(function(e,i){return s("tr",{key:i},[s("td",[t._v(t._s(i+1))]),s("td",[t._v(t._s(e.name))]),1==e.active?s("td",[t._v("Activo")]):t._e(),0==e.active?s("td",[t._v("Suspendido")]):t._e(),s("td",[s("span",[s("i",{staticClass:"icon icon-md universalicon-trash-2 colorText-red cursor",on:{click:function(s){return t.removeCustomer(e.id)}}})])])])})),0)])]):t._e(),2==this.$store.state.modal.datosDymanic.seccion&&t.listCustomersFin.length>0?s("div",{staticClass:" col-8 col-sm-6 col-md-4"},[s("m-select2",{ref:"customerSelect",attrs:{data:t.listdist,filterby:"name",title:"Selecciona distribuidor al que se le transferiran los clientes a recuperar"},on:{selectionChanged:t.OnDistSelected}})],1):t._e(),2==this.$store.state.modal.datosDymanic.seccion?s("div",{staticClass:"col-12",staticStyle:{"margin-bottom":"90px"}},[t._v(" ")]):t._e()]),s("div",{staticClass:"row"},[s("div",{staticClass:"col-12 col-sm-4"},[s("div",{staticClass:"form-group"},[s("label",{attrs:{for:"exampleFormControlSelect2"}},[t._v("Tipo Producto")]),s("select",{directives:[{name:"model",rawName:"v-model",value:t.tipoProduct,expression:"tipoProduct"}],staticClass:"form-control",attrs:{id:"exampleFormControlSelect2"},on:{change:[function(e){var s=Array.prototype.filter.call(e.target.options,(function(t){return t.selected})).map((function(t){var e="_value"in t?t._value:t.value;return e}));t.tipoProduct=e.target.multiple?s:s[0]},function(e){return t.showContent()}]}},[s("option",{attrs:{value:"0"}},[t._v("Ninguno")]),s("option",{attrs:{value:"1"}},[t._v("Gps")]),s("option",{attrs:{value:"2"}},[t._v("Sim")]),s("option",{attrs:{value:"3"}},[t._v("Producto genérico")])])])])]),s("div",{staticClass:"row"},[1==t.getTipoProduct?s("div",{staticClass:"col-12 col-sm-6"},[s("div",{staticClass:"form-group"},[s("label",{attrs:{for:"marca"}},[t._v("Marca")]),s("select",{directives:[{name:"model",rawName:"v-model",value:t.marca,expression:"marca"}],staticClass:"form-control",attrs:{id:"marca",valor:t.marca},on:{change:[function(e){var s=Array.prototype.filter.call(e.target.options,(function(t){return t.selected})).map((function(t){var e="_value"in t?t._value:t.value;return e}));t.marca=e.target.multiple?s:s[0]},function(e){return t.listmodel()}]}},[s("option",{attrs:{value:""}},[t._v("Selecciona")]),t._l(t.listFactories,(function(e){return s("option",{key:e.id,domProps:{value:e.id}},[t._v(t._s(e.factory))])}))],2)])]):t._e(),1==t.getTipoProduct?s("div",{staticClass:"col-12 col-sm-6"},[s("div",{staticClass:"form-group"},[s("label",{attrs:{for:"model"}},[t._v("Modelo")]),s("select",{directives:[{name:"model",rawName:"v-model",value:t.model,expression:"model"}],staticClass:"form-control",attrs:{id:"model",valor:t.model},on:{change:[function(e){var s=Array.prototype.filter.call(e.target.options,(function(t){return t.selected})).map((function(t){var e="_value"in t?t._value:t.value;return e}));t.model=e.target.multiple?s:s[0]},function(e){return t.listproducts()}]}},[s("option",{attrs:{value:""}},[t._v("Selecciona")]),t._l(t.listmodels,(function(e){return s("option",{key:e.id,domProps:{value:e.id}},[t._v(t._s(e.model))])}))],2)])]):t._e(),2==t.getTipoProduct?s("div",{staticClass:"col-12 col-md-6"},[s("div",{staticClass:"form-group"},[s("label",{attrs:{for:"carrier"}},[t._v("Compañia")]),s("select",{directives:[{name:"model",rawName:"v-model",value:t.marca,expression:"marca"}],staticClass:"form-control",attrs:{id:"carrier",valor:t.marca},on:{change:[function(e){var s=Array.prototype.filter.call(e.target.options,(function(t){return t.selected})).map((function(t){var e="_value"in t?t._value:t.value;return e}));t.marca=e.target.multiple?s:s[0]},function(e){return t.listmodel()}]}},[s("option",{attrs:{value:""}},[t._v("Selecciona")]),t._l(t.listFactories,(function(e){return s("option",{key:e.id,domProps:{value:e.id}},[t._v(t._s(e.name))])}))],2)])]):t._e(),3==t.getTipoProduct?s("div",{staticClass:"col-12 col-sm-6"},[s("div",{staticClass:"form-group"},[s("label",{attrs:{for:"marca"}},[t._v("Marca")]),s("select",{directives:[{name:"model",rawName:"v-model",value:t.marca,expression:"marca"}],staticClass:"form-control",attrs:{id:"marca",valor:t.marca},on:{change:[function(e){var s=Array.prototype.filter.call(e.target.options,(function(t){return t.selected})).map((function(t){var e="_value"in t?t._value:t.value;return e}));t.marca=e.target.multiple?s:s[0]},function(e){return t.listmodel()}]}},[s("option",{attrs:{value:""}},[t._v("Selecciona")]),t._l(t.listFactories,(function(e){return s("option",{key:e.id,domProps:{value:e.id}},[t._v(t._s(e.name))])}))],2)])]):t._e(),3==t.getTipoProduct?s("div",{staticClass:"col-12 col-sm-6"},[s("div",{staticClass:"form-group"},[s("label",{attrs:{for:"model"}},[t._v("Modelo")]),s("select",{directives:[{name:"model",rawName:"v-model",value:t.model,expression:"model"}],staticClass:"form-control",attrs:{id:"model",valor:t.model},on:{change:[function(e){var s=Array.prototype.filter.call(e.target.options,(function(t){return t.selected})).map((function(t){var e="_value"in t?t._value:t.value;return e}));t.model=e.target.multiple?s:s[0]},function(e){return t.listproducts()}]}},[s("option",{attrs:{value:""}},[t._v("Selecciona")]),t._l(t.listmodels,(function(e){return s("option",{key:e.id,domProps:{value:e.id}},[t._v(t._s(e.name))])}))],2)])]):t._e(),0!=t.getTipoProduct&&2!=t.getTipoProduct?s("div",{staticClass:"col-12"},[s("div",{staticClass:"form-group"},[s("label",{attrs:{for:"disp"}},[t._v("Dispositivos")]),s("select",{directives:[{name:"model",rawName:"v-model",value:t.Dispositivos,expression:"Dispositivos"}],staticClass:"form-control",attrs:{id:"disp",valor:t.Dispositivos},on:{change:function(e){var s=Array.prototype.filter.call(e.target.options,(function(t){return t.selected})).map((function(t){var e="_value"in t?t._value:t.value;return e}));t.Dispositivos=e.target.multiple?s:s[0]}}},[s("option",{attrs:{value:""}},[t._v("Selecciona")]),s("option",{attrs:{value:"-1"}},[t._v("Seleccionar todos")]),t._l(t.listDisp,(function(e){return s("option",{key:e.id,domProps:{value:e.id}},[t._v(t._s(e.id))])}))],2)])]):t._e(),0!=t.getTipoProduct&&2==t.getTipoProduct?s("div",{staticClass:"col-6"},[s("div",{staticClass:"form-group"},[s("label",{attrs:{for:"disp"}},[t._v("Dispositivos")]),s("select",{directives:[{name:"model",rawName:"v-model",value:t.Dispositivos,expression:"Dispositivos"}],staticClass:"form-control",attrs:{id:"disp",valor:t.Dispositivos},on:{change:function(e){var s=Array.prototype.filter.call(e.target.options,(function(t){return t.selected})).map((function(t){var e="_value"in t?t._value:t.value;return e}));t.Dispositivos=e.target.multiple?s:s[0]}}},[s("option",{attrs:{value:""}},[t._v("Selecciona")]),s("option",{attrs:{value:"-1"}},[t._v("Seleccionar todos")]),t._l(t.listDisp,(function(e){return s("option",{key:e.id,domProps:{value:e.id}},[t._v(t._s(e.id))])}))],2)])]):t._e(),0!=t.getTipoProduct?s("div",{staticClass:"col-12  float-right"},[s("button",{staticClass:" shadow-2 mb-4 btn btn-primary",staticStyle:{"margin-top":"30px"},attrs:{type:"button"},on:{click:function(e){return t.funproductoSeleted()}}},[t._v("Confirmar")])]):t._e()]),s("div",{staticClass:"col-12",staticStyle:{"margin-top":"15px"}},[s("table",{staticClass:"table table-hover header_fijo"},[t._m(1),s("tbody",t._l(t.productoSeleted,(function(e,i){return s("tr",{key:i},[s("td",[t._v(t._s(e.productType))]),s("td",[t._v(t._s(e.factory))]),2!=e.productTypeID?s("td",[t._v(t._s(e.model))]):s("td",[t._v(" - ")]),s("td",[t._v(t._s(e.id))]),s("td",[s("span",[s("i",{staticClass:"icon icon-md universalicon-trash-2 colorText-red cursor",on:{click:function(s){return t.removeProduct(e.productTypeID,e.id)}}})])])])})),0)])]),t._m(2),s("div",{staticClass:"col-12",staticStyle:{"margin-top":"20px"},attrs:{id:"alertasACD"}}),s("div",{staticClass:"row justify-content-center",staticStyle:{"margin-top":"15px"}},[s("div",{staticClass:"col-6 float-right"},[s("button",{staticClass:" float-right btn  btn-outline-primary  shadow-2 mb-4 ",on:{click:function(e){return t.goReturn()}}},[t._v("CANCELAR")])]),s("div",{staticClass:"col-6 float-left"},[s("button",{staticClass:"float-left btn btn-primary shadow-2 mb-4 ",attrs:{type:"submit"},on:{click:function(e){return t.SendForm()}}},[t._v("CONFIRMAR")])])])])])])])])},o=[function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("thead",[s("tr",[s("th",[t._v("#")]),s("th",[t._v("Cliente")]),s("th",[t._v("Estado")]),s("th",[t._v("Acciones")])])])},function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("thead",[s("tr",[s("th",[t._v("Tipo de Producto")]),s("th",[t._v("Marca")]),s("th",[t._v("Modelo")]),s("th",[t._v("IMEI/Serie")]),s("th",[t._v("Acciones")])])])},function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",{staticClass:"row justify-content-center",staticStyle:{"margin-top":"40px","margin-bottom":"35px"}},[s("div",{staticClass:"col-12 col-md-10 text-center"},[t._v("\n                                          A continuación si quieres eliminar a uno de tus clientes haz click\n                                          en el botón CONFIRMAR para eliminarlo.\n                                        ")])])}],r=(s("7f7f"),s("7514"),s("20d6"),s("ac6a"),s("96cf"),s("3b8d")),a=s("08e6"),n=s("d3e3"),c=s("b381"),l=s("2edb"),u=s("a588"),d={name:"elimnarClienteDist",mixins:[a["a"]],components:{mSelect:l["a"],mSelect2:c["a"]},data:function(){return{tipoProduct:0,listFactories:null,listmodels:null,listDisp:[],Dispositivos:"",model:"",marca:"",title:"",productoSeleted:[],productosFin:[],listCustomers:[],cliente:null,listCustomersFin:[],listdist:[],dist:null,listdistFin:[]}},created:function(){2==this.$store.state.modal.datosDymanic.seccion&&(this.getCustomers(),this.getDist())},mounted:function(){var t=Object(r["a"])(regeneratorRuntime.mark((function t(){return regeneratorRuntime.wrap((function(t){while(1)switch(t.prev=t.next){case 0:if(1!=this.$store.state.modal.datosDymanic.seccion){t.next=5;break}return this.$store.state.seccionMenu="Clientes",t.next=4,n["a"].$emit("NAVBAR_MenuSimple","Clientes");case 4:this.title="Cliente";case 5:if(2!=this.$store.state.modal.datosDymanic.seccion){t.next=10;break}return this.$store.state.seccionMenu="Distribuidores",t.next=9,n["a"].$emit("NAVBAR_MenuSimple","Distribuidores");case 9:this.title="Distribuidor";case 10:this.$store.state.loader=!0,$("#containerPrincipal").css({"margin-left":this.$store.state.widthMenu}),$("#containerPrincipal").css({"margin-top":this.$store.state.topMenu}),this.$store.state.loader=!1;case 14:case"end":return t.stop()}}),t,this)})));function e(){return t.apply(this,arguments)}return e}(),methods:{getCustomers:function(){var t=Object(r["a"])(regeneratorRuntime.mark((function t(){var e,s;return regeneratorRuntime.wrap((function(t){while(1)switch(t.prev=t.next){case 0:return this.$store.state.loader=!0,e={clientID:this.$store.state.modal.datosDymanic.clientID},t.next=4,this.getRequest("accounts",e);case 4:s=t.sent,this.listCustomers=s.data.customers,console.debug("CLEINTES",this.listCustomers),this.$store.state.loader=!1;case 8:case"end":return t.stop()}}),t,this)})));function e(){return t.apply(this,arguments)}return e}(),getDist:function(){var t=Object(r["a"])(regeneratorRuntime.mark((function t(){var e;return regeneratorRuntime.wrap((function(t){while(1)switch(t.prev=t.next){case 0:return this.$store.state.loader=!0,t.next=3,this.getRequest("accounts");case 3:e=t.sent,this.listdist=e.data.customers,console.debug("dist",this.listdist),this.$store.state.loader=!1;case 7:case"end":return t.stop()}}),t,this)})));function e(){return t.apply(this,arguments)}return e}(),showContent:function(){console.debug("SHOWCONTENT"),0!=this.tipoProduct&&this.factories()},factories:function(){var t=Object(r["a"])(regeneratorRuntime.mark((function t(){var e,s;return regeneratorRuntime.wrap((function(t){while(1)switch(t.prev=t.next){case 0:if(this.$store.state.loader=!0,this.marca="",this.model="",this.listmodels=null,this.listFactories=null,1!=this.tipoProduct){t.next=10;break}return t.next=8,this.getRequest("catalogs/devices/factories");case 8:e=t.sent,!0===e.success&&(this.listFactories=e.data.deviceFactories);case 10:if(2!=this.tipoProduct){t.next=15;break}return t.next=13,this.getRequest("catalogs/sims/carriers");case 13:e=t.sent,!0===e.success&&(this.listFactories=e.data.simCarriers);case 15:if(3!=this.tipoProduct){t.next=21;break}return s={productType:3},t.next=19,this.getRequest("catalogs/products/factories",s);case 19:e=t.sent,!0===e.success&&(this.listFactories=e.data.factories);case 21:this.$store.state.loader=!1;case 22:case"end":return t.stop()}}),t,this)})));function e(){return t.apply(this,arguments)}return e}(),listmodel:function(){var t=Object(r["a"])(regeneratorRuntime.mark((function t(){var e,s,i;return regeneratorRuntime.wrap((function(t){while(1)switch(t.prev=t.next){case 0:if(this.$store.state.loader=!0,this.model="",this.listmodels=null,1!=this.tipoProduct){t.next=10;break}return console.debug("entra modelo",this.marca),t.next=7,this.getRequest("catalogs/devices/factories/"+this.marca+"/models");case 7:e=t.sent,console.debug("RESP",e),!0===e.success&&(this.listmodels=e.data.deviceModels);case 10:if(3!=this.tipoProduct){t.next=18;break}return s={productType:3},console.debug("entra modelo",this.marca),t.next=15,this.getRequest("catalogs/products/factories/"+this.marca+"/models",s);case 15:e=t.sent,console.debug("RESP",e),!0===e.success&&(this.listmodels=e.data.models);case 18:if(2!=this.tipoProduct){t.next=26;break}return this.listDisp=[],i={clientID:this.$store.state.modal.datosDymanic.clientID,productType:this.tipoProduct,factory:this.marca},t.next=23,this.getRequest("store",i);case 23:e=t.sent,!0===e.success&&(this.listDisp=e.data.products),console.debug(i,"STORE",e,this.listDisp);case 26:this.$store.state.loader=!1;case 27:case"end":return t.stop()}}),t,this)})));function e(){return t.apply(this,arguments)}return e}(),listproducts:function(){var t=Object(r["a"])(regeneratorRuntime.mark((function t(){var e,s;return regeneratorRuntime.wrap((function(t){while(1)switch(t.prev=t.next){case 0:return this.$store.state.loader=!0,this.listDisp=[],e={clientID:this.$store.state.modal.datosDymanic.clientID,productType:this.tipoProduct,factory:this.marca,model:this.model},t.next=5,this.getRequest("store",e);case 5:s=t.sent,console.debug(e,"STORE",s),!0===s.success&&(this.listDisp=s.data.products),this.$store.state.loader=!1;case 9:case"end":return t.stop()}}),t,this)})));function e(){return t.apply(this,arguments)}return e}(),funproductoSeleted:function(){var t=Object(r["a"])(regeneratorRuntime.mark((function t(){var e,s,i=this;return regeneratorRuntime.wrap((function(t){while(1)switch(t.prev=t.next){case 0:if(""!=this.marca&&null!=this.marca){t.next=3;break}return notify("Por favor!","  Selecciona marca","top","right","danger"),t.abrupt("return",!1);case 3:if(2==this.tipoProduct||""!=this.model&&null!=this.model){t.next=6;break}return notify("Por favor!","  Selecciona modelo","top","right","danger"),t.abrupt("return",!1);case 6:if(""!=this.Dispositivos&&null!=this.Dispositivos){t.next=9;break}return notify("Por favor!","  Selecciona un dispositivo","top","right","danger"),t.abrupt("return",!1);case 9:if(0!=this.listDisp.length){t.next=12;break}return notify("","  No se encontraron dispositivos","top","right","danger"),t.abrupt("return",!1);case 12:this.$store.state.loader=!0,console.debug(this.Dispositivos),-1==this.Dispositivos?this.listDisp.forEach((function(t){var e=i.productoSeleted.findIndex((function(e){return e.id==t.id}));-1==e?(i.productoSeleted.push({id:t.id,productID:t.productID,productTypeID:t.productTypeID,productType:t.productType,factoryID:t.factoryID,factory:t.factory,modelID:t.modelID,model:t.model}),i.productosFin.push({idd:t.id,id:t.productID,type:t.productTypeID})):notify("","El producto ya se encuentra agregado","top","right","danger")})):(e=this.listDisp.find((function(t){return t.id==i.Dispositivos})),s=this.productoSeleted.findIndex((function(t){return t.id==e.id})),-1==s?(this.productoSeleted.push({id:e.id,productID:e.productID,productTypeID:e.productTypeID,productType:e.productType,factoryID:e.factoryID,factory:e.factory,modelID:e.modelID,model:e.model}),this.productosFin.push({idd:e.id,id:e.productID,type:e.productTypeID})):notify("","El producto ya se encuentra agregado","top","right","danger")),this.Dispositivos="",this.$store.state.loader=!1;case 17:case"end":return t.stop()}}),t,this)})));function e(){return t.apply(this,arguments)}return e}(),removeProduct:function(t,e){var s;this.$store.state.loader=!0;this.productoSeleted.filter((function(t,i){if(t.id==e)return s=i,t,!0})),this.productoSeleted.splice(s,1),this.productosFin.filter((function(t,i){if(t.idd==e)return s=i,t,!0})),this.productosFin.splice(s,1),this.$store.state.loader=!1},agregarCustomer:function(){var t=Object(r["a"])(regeneratorRuntime.mark((function t(){var e,s,i=this;return regeneratorRuntime.wrap((function(t){while(1)switch(t.prev=t.next){case 0:if(""!=this.cliente&&null!=this.cliente){t.next=3;break}return notify("Por favor!","  Selecciona cliente","top","right","danger"),t.abrupt("return",!1);case 3:this.$store.state.loader=!0,console.debug(this.cliente),-1==this.cliente?this.listCustomers.forEach((function(t){var e=i.listCustomersFin.findIndex((function(e){return e.id==t.id}));-1==e?i.listCustomersFin.push({id:t.id,name:t.name,active:t.active,creationTimestamp:t.creationTimestamp}):notify("","El cliente ya se encuentra agregado","top","right","danger")})):(e=this.listCustomers.find((function(t){return t.id==i.cliente.id})),s=this.listCustomersFin.findIndex((function(t){return t.id==e.id})),-1==s?this.listCustomersFin.push({id:e.id,name:e.name,active:e.active}):notify("","El cliente ya se encuentra agregado","top","right","danger")),this.$store.state.loader=!1;case 7:case"end":return t.stop()}}),t,this)})));function e(){return t.apply(this,arguments)}return e}(),removeCustomer:function(t){var e;this.$store.state.loader=!0;this.listCustomersFin.filter((function(s,i){if(s.id==t)return e=i,s,!0})),this.listCustomersFin.splice(e,1),this.$store.state.loader=!1},OnCustomerSelected:function(t){this.cliente=t},OnDistSelected:function(t){this.dist=t},SendForm:function(){var t=Object(r["a"])(regeneratorRuntime.mark((function t(){var e,s,i,o;return regeneratorRuntime.wrap((function(t){while(1)switch(t.prev=t.next){case 0:if(console.debug("SEND",this.productosFin,this.listCustomersFin,this.dist),!(2==this.$store.state.modal.datosDymanic.seccion&&this.listCustomersFin.length>0)){t.next=5;break}if(null!=this.dist&&""!=this.dist){t.next=5;break}return notify("Por favor!","  Selecciona distribuidor","top","right","danger"),t.abrupt("return",!1);case 5:return this.$store.state.loader=!0,e=this.$store.state.modal.datosDymanic.clientID,s=this.$store.state.modal.datosDymanic.nameCliente,i=this.$store.state.modal.datosDymanic.seccion,this.$store.commit("CLEAR_MODAL_DINAMIC"),o={component:u["a"],datos:{clientID:e,name:s,seccion:i,customers:this.listCustomersFin,products:this.productosFin}},2==i&&(0==this.listCustomersFin.length?o.datos.distransf=null:o.datos.distransf=this.dist.id),1==i&&(o.datos.distransf=null),t.next=15,this.$store.commit("ADD_COMPONENT_DINAMIC",o);case 15:return t.next=17,this.$store.commit("ADD_COMPONENT_DINAMIC_STATE",!0);case 17:this.$store.state.loader=!1;case 18:case"end":return t.stop()}}),t,this)})));function e(){return t.apply(this,arguments)}return e}(),goReturn:function(){this.$router.push("/ListaCliente")}},computed:{getTipoProduct:function(){return this.tipoProduct},getlistDisp:function(){return this.listDisp}}},p=d,m=s("2877"),v=Object(m["a"])(p,i,o,!1,null,null,null);e["default"]=v.exports}}]);
//# sourceMappingURL=chunk-2d0aef32.9269c4c6.js.map