(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-9cf36670"],{"501f":function(t,e,n){},b110:function(t,e,n){"use strict";n.r(e);var i=function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("div",{staticClass:" row "},[t._m(0),n("div",{staticClass:" col-12"},[n("div",{staticClass:"card"},[n("div",{staticClass:"card-header row"},[t._m(1),n("div",{staticClass:"col-3",staticStyle:{height:"30px"}},[n("button",{staticClass:"btn btn-primary float-right btn-sm",attrs:{type:"button"},on:{click:function(e){return t.modalFormKit()}}},[t._v("NUEVO")])])]),n("div",{staticClass:"card-body"},[n("div",{staticClass:"table-responsive scrollTable"},[n("table",{staticClass:"table table-hover header_fijo"},[t._m(2),n("tbody",t._l(t.listKits,(function(e,i){return n("tr",{key:e.id},[n("td",[t._v(t._s(i+1))]),n("td",[t._v(t._s(e.kitName))]),n("td",[t._v(" "+t._s(t._f("moment")(1e3*e.creationTimestamp,"DD MMMM YYYY")))]),n("td",[n("span",{staticClass:"cursor"},[n("i",{staticClass:"icon icon-md universalicon-pencil cursor",on:{click:function(n){return t.modalEdit(e.id)}}})]),n("span",{on:{click:function(n){return t.eliminar(e.id,e.kitName)}}},[n("i",{staticClass:"cursor icon-small icon universalicon-trash-2 colorText-red"})])])])})),0)])])])])])])},s=[function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("div",{staticClass:"col-12"},[n("h5",{staticClass:"float-left",staticStyle:{"font-size":"20px","padding-bottom":"10px"}},[n("b",[t._v("Catálogos - Kits")])])])},function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("div",{staticClass:"col-9"},[n("h5",{staticClass:" float-left"},[t._v("Lista de kits")])])},function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("thead",[n("tr",[n("th",[t._v("#")]),n("th",[t._v("Kit")]),n("th",[t._v("Fecha de creación")]),n("th",[t._v("Acciones")])])])}],r=(n("96cf"),n("3b8d")),a=n("08e6"),c=n("2d60"),o=n("ed73"),u=n("d3e3"),l={name:"tablaSims",mixins:[a["a"]],data:function(){return{listKits:null}},components:{cModalDelete:o["a"]},created:function(){this.$store.state.StoreCliente=this.$store.state.modal.datosDymanic.idCliente,this.getlistKit()},mounted:function(){var t=Object(r["a"])(regeneratorRuntime.mark((function t(){return regeneratorRuntime.wrap((function(t){while(1)switch(t.prev=t.next){case 0:return this.$store.state.seccionMenu="catalogos",t.next=3,u["a"].$emit("NAVBAR_MenuSimple","catalogos");case 3:$("#containerPrincipal").css({"margin-left":this.$store.state.widthMenu}),$("#containerPrincipal").css({"margin-top":this.$store.state.topMenu}),this.suscribeToDeviceEvents();case 6:case"end":return t.stop()}}),t,this)})));function e(){return t.apply(this,arguments)}return e}(),beforeDestroy:function(){this.unsuscribreToDeviceEvents()},methods:{getlistKit:function(){var t=Object(r["a"])(regeneratorRuntime.mark((function t(){var e;return regeneratorRuntime.wrap((function(t){while(1)switch(t.prev=t.next){case 0:return t.next=2,this.getRequest("kits");case 2:e=t.sent,!0===e.success&&(this.listKits=e.data.kits);case 4:case"end":return t.stop()}}),t,this)})));function e(){return t.apply(this,arguments)}return e}(),modalFormKit:function(){var t=Object(r["a"])(regeneratorRuntime.mark((function t(){var e;return regeneratorRuntime.wrap((function(t){while(1)switch(t.prev=t.next){case 0:return this.$store.state.loader=!0,this.$store.commit("CLEAR_MODAL_DINAMIC"),e={component:c["default"],datos:{seccion:"kit",accion:"nuevo"}},console.debug(e),t.next=6,this.$store.commit("ADD_COMPONENT_DINAMIC",e);case 6:return t.next=8,this.$store.commit("ADD_COMPONENT_DINAMIC_STATE",!0);case 8:case"end":return t.stop()}}),t,this)})));function e(){return t.apply(this,arguments)}return e}(),modalEdit:function(){var t=Object(r["a"])(regeneratorRuntime.mark((function t(e){var n;return regeneratorRuntime.wrap((function(t){while(1)switch(t.prev=t.next){case 0:return this.$store.state.loader=!0,this.$store.commit("CLEAR_MODAL_DINAMIC"),n={component:c["default"],datos:{seccion:"kit",accion:"editar",id:e}},t.next=5,this.$store.commit("ADD_COMPONENT_DINAMIC",n);case 5:return t.next=7,this.$store.commit("ADD_COMPONENT_DINAMIC_STATE",!0);case 7:case"end":return t.stop()}}),t,this)})));function e(e){return t.apply(this,arguments)}return e}(),eliminar:function(){var t=Object(r["a"])(regeneratorRuntime.mark((function t(e,n){var i;return regeneratorRuntime.wrap((function(t){while(1)switch(t.prev=t.next){case 0:return this.$store.commit("CLEAR_MODAL_DINAMIC"),i={component:o["a"],datos:{ID:e,name:n,tipo:"kit"}},t.next=4,this.$store.commit("ADD_COMPONENT_DINAMIC",i);case 4:return t.next=6,this.$store.commit("ADD_COMPONENT_DINAMIC_STATE",!0);case 6:case"end":return t.stop()}}),t,this)})));function e(e,n){return t.apply(this,arguments)}return e}(),suscribeToDeviceEvents:function(){var t=this;u["a"].$on("GET_LIST_kits",(function(e){t.getlistKit()}))},unsuscribreToDeviceEvents:function(){u["a"].$off("GET_LIST_kits")}},computed:{}},m=l,d=(n("d4f9"),n("2877")),h=Object(d["a"])(m,i,s,!1,null,null,null);e["default"]=h.exports},d4f9:function(t,e,n){"use strict";var i=n("501f"),s=n.n(i);s.a}}]);
//# sourceMappingURL=chunk-9cf36670.c6a98f72.js.map