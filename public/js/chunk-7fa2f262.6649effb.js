(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-7fa2f262"],{"3cb3":function(t,e,r){"use strict";r.r(e);var s=function(){var t=this,e=t.$createElement,r=t._self._c||e;return r("div",{staticClass:"row",staticStyle:{"margin-bottom":"150px"}},[t._m(0),r("div",{staticClass:"col-12 card",staticStyle:{"margin-top":"40px"}},[r("div",{staticClass:"card-body"},[r("div",{staticClass:"row"},[r("div",{staticClass:"col-12 text-left"},[r("ul",{staticClass:"nav nav-tabs",attrs:{role:"tablist"}},[r("li",{staticClass:"nav-item"},[r("a",{staticClass:"nav-link active cursor",attrs:{"data-toggle":"tab",role:"tab","aria-selected":"true"},on:{click:function(e){return t.showProductSelector()}}},[t._v("Agregar Producto\n              ")])])])]),r("div",{staticClass:"col-12",staticStyle:{border:"solid 1px lightgrey",padding:"10px"}},[r(t.currentProductSelectorTab,{tag:"component",on:{OnProductSelected:t.OnProductSelected,OnProductsSelected:t.OnProductsSelected}})],1)]),r("div",{staticClass:"row",staticStyle:{"margin-top":"70px"}},[t._m(1),r("div",{staticClass:"col-12",staticStyle:{"margin-top":"15px"}},[r("table",{staticClass:"table table-hover header_fijo"},[t._m(2),r("tbody",t._l(t.products,(function(e,s){return r("tr",{key:s},[r("td",[t._v(t._s(e.productType))]),r("td",[t._v(t._s(e.factory))]),r("td",[t._v(t._s(e.id))]),r("td",[t._v(t._s(e.kit))]),r("td",[r("span",[r("i",{staticClass:"icon icon-md universalicon-trash-2 colorText-red cursor",on:{click:function(r){return t.removeProduct(e.productTypeID,e.id)}}})])])])})),0)])])]),r("div",{staticClass:"row",staticStyle:{"margin-top":"50px"}},[t._m(3),r("div",{staticClass:"col-6 col-lg-5 text-left"},[r("m-select",{ref:"customerSelect",attrs:{data:t.customer.customers,filterby:"name",title:"Seleccione cliente"},on:{selectionChanged:t.OnCustomerSelected}})],1),r("div",{staticClass:"col-6 col-lg-7 text-right align-self-end"},[r("button",{staticClass:"btn btn-sm btn-secondary",attrs:{type:"button"},on:{click:t.goReturn}},[t._v("CANCELAR")]),r("button",{staticClass:"btn btn-sm btn-primary",attrs:{type:"button",disabled:!t.confirmSaleBtnEnabled},on:{click:t.confirmSale}},[t._v("CONFIRMAR")])])])])])])},n=[function(){var t=this,e=t.$createElement,r=t._self._c||e;return r("div",{staticClass:"col-12"},[r("h5",{staticClass:"float-left",staticStyle:{"font-size":"20px","padding-bottom":"10px"}},[r("b",[t._v("Nueva Venta")])])])},function(){var t=this,e=t.$createElement,r=t._self._c||e;return r("div",{staticClass:"col-12 text-left",staticStyle:{"font-size":"16px"}},[r("b",[t._v("Productos seleccionados")])])},function(){var t=this,e=t.$createElement,r=t._self._c||e;return r("thead",[r("tr",[r("th",[t._v("Tipo de Producto")]),r("th",[t._v("Marca")]),r("th",[t._v("IMEI/Serie")]),r("th",[t._v("KIT")]),r("th",[t._v("Acciones")])])])},function(){var t=this,e=t.$createElement,r=t._self._c||e;return r("div",{staticClass:"col-12"},[r("hr")])}],c=(r("20d6"),r("ac6a"),r("96cf"),r("3b8d")),a=r("08e6"),o=r("b381"),i=r("8150"),u=r("d3e3"),l={name:"NewSale",mixins:[a["a"]],components:{productSelector:i["a"],mSelect:o["a"]},mounted:function(){var t=Object(c["a"])(regeneratorRuntime.mark((function t(){return regeneratorRuntime.wrap((function(t){while(1)switch(t.prev=t.next){case 0:return this.$store.state.seccionMenu="operacion",t.next=3,u["a"].$emit("NAVBAR_MenuSimple","operacion");case 3:this.$store.state.loader=!0,$("#containerPrincipal").css({"margin-left":this.$store.state.widthMenu}),$("#containerPrincipal").css({"margin-top":this.$store.state.topMenu}),this.$store.state.loader=!1,this.getCustomers();case 8:case"end":return t.stop()}}),t,this)})));function e(){return t.apply(this,arguments)}return e}(),data:function(){return{currentProductSelectorTab:i["a"],products:[],customer:{customers:[],selected:""},confirmSaleBtnEnabled:!0}},methods:{getCustomers:function(){var t=Object(c["a"])(regeneratorRuntime.mark((function t(){var e;return regeneratorRuntime.wrap((function(t){while(1)switch(t.prev=t.next){case 0:return this.$store.state.loader=!0,t.next=3,this.getRequest("accounts");case 3:e=t.sent,this.customer.customers=e.data.customers,this.$store.state.loader=!1;case 6:case"end":return t.stop()}}),t,this)})));function e(){return t.apply(this,arguments)}return e}(),showProductSelector:function(){this.currentProductSelectorTab=i["a"]},showKitSelector:function(){this.currentProductSelectorTab=null},OnProductSelected:function(t){console.debug("ProductSelected",t),this.addProduct(t)},OnProductsSelected:function(t){var e=this;t.forEach((function(t){e.addProduct(t)}))},OnCustomerSelected:function(t){this.customer.selected=t},addProduct:function(t){var e=this.products.findIndex((function(e){return e.id==t.id&&e.productTypeID==t.productTypeID}));-1==e?this.products.push(t):notify("","El producto ya se encuentra agregado","top","right","danger")},removeProduct:function(t,e){var r=this.products.findIndex((function(r){return r.id==e&&r.productTypeID==t}));r>-1&&this.products.splice(r,1)},confirmSale:function(){this.validateTransaction()&&this.processTransaction()},goReturn:function(){this.$router.push("/transactions/sales")},validateTransaction:function(){var t=!0;return this.products.length?this.$refs.customerSelect.selectedItem&&-1!=this.$refs.customerSelect.selectedItem||(t=!1,notify("Error, ","Debe seleccionar el cliente","top","right","danger")):(t=!1,notify("Error, ","Debe seleccionar por lo menos 1 producto","top","right","danger")),t},processTransaction:function(){var t=Object(c["a"])(regeneratorRuntime.mark((function t(){var e,r,s,n=this;return regeneratorRuntime.wrap((function(t){while(1)switch(t.prev=t.next){case 0:return this.$store.state.loader=!0,this.confirmSaleBtnEnabled=!1,e=[],this.products.forEach((function(t){var r={id:t.productID,type:t.productTypeID,kitID:t.kitID};e.push(r)})),r={transaction:{clientID:this.customer.selected.id,transactionType:1},products:e},t.next=7,this.postRequest("transactions",r);case 7:if(s=t.sent,this.$store.state.loader=!1,!s.success){t.next=15;break}return notify("","Transaccion realizada con exito","top","rigth","success"),t.next=13,setTimeout((function(){n.goReturn()}),3e3);case 13:t.next=17;break;case 15:notify("","Error al realizar la transaccion","top","right","danger"),this.confirmSaleBtnEnabled=!0;case 17:case"end":return t.stop()}}),t,this)})));function e(){return t.apply(this,arguments)}return e}()}},d=l,p=(r("f6b2"),r("2877")),h=Object(p["a"])(d,s,n,!1,null,"04bc69c8",null);e["default"]=h.exports},"48a7":function(t,e,r){},f6b2:function(t,e,r){"use strict";var s=r("48a7"),n=r.n(s);n.a}}]);
//# sourceMappingURL=chunk-7fa2f262.6649effb.js.map