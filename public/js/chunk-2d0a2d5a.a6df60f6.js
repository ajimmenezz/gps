(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-2d0a2d5a"],{"0037":function(t,e,s){"use strict";s.r(e);var a=function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",{staticClass:"row m-r-5",staticStyle:{"padding-left":"10px"}},[s("div",{staticClass:"col-12",staticStyle:{"margin-top":"60px"}},[s("div",{staticClass:"row"},[s("div",{staticClass:"col-12"},[s("h5",{staticClass:"float-left",staticStyle:{"font-size":"20px","padding-bottom":"10px"}},[s("b",[t._v(t._s(this.$store.state.modal.datosDymanic.tittle))])])]),s("div",{staticClass:"col-12",staticStyle:{"margin-top":"-12px"}},[t.subtittle?s("p",{staticClass:"text-muted",staticStyle:{"text-align":"justify","font-size":"12px"}},[t._v("\n            "+t._s(this.subtittle))]):t._e()])])]),s("div",{staticClass:"col-12"},[s("hr",{staticStyle:{"margin-top":"-10px"}}),s("nav",{staticStyle:{"margin-top":"-16px","margin-bottom":"-15px"},attrs:{"aria-label":"breadcrumb"}},[s("ol",{staticClass:"breadcrumb"},[s("li",{staticClass:"breadcrumb-item"},[s("router-link",{attrs:{to:"/reports"}},[t._v("Reportes ")])],1),s("li",{staticClass:"breadcrumb-item active",attrs:{"aria-current":"page"}},[t._v("reporte cancelado")])])])]),s("div",{staticClass:"col-12"},[s("div",{staticClass:"card "},[s("div",{staticClass:"card-body ",staticStyle:{padding:"0px"}},[s("div",{staticClass:"row",staticStyle:{margin:"15px"}},[t._m(0),s("div",{staticClass:"col-12 float-right"},[s("button",{staticClass:"btn btn-primary btn-sm",staticStyle:{right:"15px",position:"absolute",bottom:"0px"},attrs:{type:"button"},on:{click:function(e){return t.nuevoReport()}}},[t._v("NUEVO REPORTE")])])])])])])])},i=[function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",{staticClass:"col-12 float-left",staticStyle:{height:"100px","font-size":"22px"}},[s("b",[t._v("Hemos Detectado")]),t._v(", que generaste un reporte y no se ha completado, da click en el botón para generar un "),s("b",[t._v("Nuevo Reporte")]),t._v(".\n                                    ")])}],r=(s("96cf"),s("3b8d")),n=s("08e6"),o=s("d3e3"),c={name:"ReportesCancel",mixins:[n["a"]],data:function(){return{subtittle:""}},created:function(){this.tipoClient=sessionStorage.TC,this.$store.state.loader=!0},mounted:function(){var t=Object(r["a"])(regeneratorRuntime.mark((function t(){return regeneratorRuntime.wrap((function(t){while(1)switch(t.prev=t.next){case 0:return $("#containerPrincipal").css({"margin-left":this.$store.state.widthMenu}),$("#containerPrincipal").css({"margin-top":this.$store.state.topMenu}),this.$store.state.seccionMenu="reportes",t.next=5,o["a"].$emit("NAVBAR_MenuSimple","reportes");case 5:void 0!=this.$store.state.modal.datosDymanic.subtittle&&""!=this.$store.state.modal.datosDymanic.subtittle&&null!=this.$store.state.modal.datosDymanic.subtittle?this.subtittle=this.$store.state.modal.datosDymanic.subtittle:this.subtittle="Reporte de Distancia Recorrida permite diseñar desde el inicio la estructura de un reporte y el tipo de datos que va a incluir.",this.$store.state.loader=!1;case 7:case"end":return t.stop()}}),t,this)})));function e(){return t.apply(this,arguments)}return e}(),methods:{cancel:function(){var t=Object(r["a"])(regeneratorRuntime.mark((function t(){return regeneratorRuntime.wrap((function(t){while(1)switch(t.prev=t.next){case 0:return this.$router.push("reports"),t.next=3,$("#modalReportCreate").modal("hide");case 3:this.$store.commit("CLEAR_MODAL_DINAMIC");case 4:case"end":return t.stop()}}),t,this)})));function e(){return t.apply(this,arguments)}return e}(),nuevoReport:function(){var t=Object(r["a"])(regeneratorRuntime.mark((function t(){return regeneratorRuntime.wrap((function(t){while(1)switch(t.prev=t.next){case 0:return this.$router.push("reports"),t.next=3,$("#modalReportCreate").modal("show");case 3:return t.next=5,this.$store.commit("ADD_COMPONENT_DINAMIC_STATE",!0);case 5:case"end":return t.stop()}}),t,this)})));function e(){return t.apply(this,arguments)}return e}()},computed:{}},l=c,u=s("2877"),p=Object(u["a"])(l,a,i,!1,null,null,null);e["default"]=p.exports}}]);
//# sourceMappingURL=chunk-2d0a2d5a.a6df60f6.js.map