(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-2da9bddb"],{"1af6":function(t,e,r){var n=r("63b6");n(n.S,"Array",{isArray:r("9003")})},"3cbd":function(t,e,r){"use strict";var n=r("4131"),a=r.n(n);a.a},4131:function(t,e,r){},"469f":function(t,e,r){r("6c1c"),r("1654"),t.exports=r("7d7b")},"54a1":function(t,e,r){r("6c1c"),r("1654"),t.exports=r("95d5")},"5d73":function(t,e,r){t.exports=r("469f")},"768b":function(t,e,r){"use strict";var n=r("a745"),a=r.n(n);function o(t){if(a()(t))return t}var s=r("5d73"),i=r.n(s),c=r("c8bb"),u=r.n(c);function l(t,e){if(u()(Object(t))||"[object Arguments]"===Object.prototype.toString.call(t)){var r=[],n=!0,a=!1,o=void 0;try{for(var s,c=i()(t);!(n=(s=c.next()).done);n=!0)if(r.push(s.value),e&&r.length===e)break}catch(l){a=!0,o=l}finally{try{n||null==c["return"]||c["return"]()}finally{if(a)throw o}}return r}}function d(){throw new TypeError("Invalid attempt to destructure non-iterable instance")}function f(t,e){return o(t)||l(t,e)||d()}r.d(e,"a",(function(){return f}))},"7d7b":function(t,e,r){var n=r("e4ae"),a=r("7cd6");t.exports=r("584a").getIterator=function(t){var e=a(t);if("function"!=typeof e)throw TypeError(t+" is not iterable!");return n(e.call(t))}},"83d8":function(t,e,r){"use strict";r.r(e);var n=function(){var t=this,e=t.$createElement,r=t._self._c||e;return r("div",{staticClass:"col-12",staticStyle:{"margin-top":"50px"}},[t.isEmptyReports?t._e():r("div",{staticClass:"col-12"},[t._m(0)]),t.showData&&!t.isEmptyReports?r("div",{staticClass:"table-responsive"},[r("table",{staticClass:"display table nowrap table-striped table-hover",staticStyle:{width:"100%"},attrs:{id:"zero-configuration"}},[t._m(1),r("tbody",t._l(t.gwtData,(function(e,n){return r("tr",{key:n},[r("td",[t._v(t._s(e.alias))]),r("td",[t._v(t._s(e.from.date))]),r("td",[t._v(t._s(e.to.date))]),r("td",[t._v(t._s(e.infractions)+" ")]),r("td",[t._v(t._s(e.maxSpeedReached)+" km/hr")])])})),0)])]):t._e(),t.isEmptyReports?r("div",{staticStyle:{"margin-bottom":"30px"}},[t._v("No se encontraron resultados")]):t._e()])},a=[function(){var t=this,e=t.$createElement,r=t._self._c||e;return r("h5",{staticClass:"float-left text-muted",staticStyle:{"font-size":"20px","padding-bottom":"10px"}},[r("b",[t._v("Velocidad")])])},function(){var t=this,e=t.$createElement,r=t._self._c||e;return r("thead",[r("tr",[r("th",[t._v("Unidad")]),r("th",[t._v("Fecha inicial")]),r("th",[t._v("Fecha final")]),r("th",[t._v("Exceso de velocidad")]),r("th",[t._v("Velocidad maxima")])])])}],o=r("768b"),s=(r("ffc1"),r("ac6a"),r("96cf"),r("3b8d")),i=r("08e6"),c=r("d3e3"),u={name:"ReportesTableVel",mixins:[i["a"]],data:function(){return{data:null,reports:[],resultado:!1}},inject:["getDraggableProperties"],created:function(){this.$store.state.loader=!0,this.getDataTable(this.$store.state.modal.datosDymanic.filters)},mounted:function(){var t=Object(s["a"])(regeneratorRuntime.mark((function t(){return regeneratorRuntime.wrap((function(t){while(1)switch(t.prev=t.next){case 0:return $("#containerPrincipal").css({"margin-left":this.$store.state.widthMenu}),$("#containerPrincipal").css({"margin-top":this.$store.state.topMenu}),this.$store.state.seccionMenu="reportes",t.next=5,c["a"].$emit("NAVBAR_MenuSimple","reportes");case 5:$("#zero-configuration").DataTable({scrollY:"550px",language:{sLengthMenu:"Mostrar _MENU_ registros",emptyTable:"No se encontraron datos",info:"Mostrando del _START_ al _END_ de _TOTAL_ resultados",infoEmpty:"Mostrando 0 al 0 de 0 resultados",loadingRecords:"Obteniendo datos...",processing:"Procesando datos...",search:"Buscar:",zeroRecords:"No se encontraron datos",paginate:{first:"Primero",last:"Último",next:"Siguiente",previous:"Anterior"}}}),this.$store.state.loader=!1;case 7:case"end":return t.stop()}}),t,this)})));function e(){return t.apply(this,arguments)}return e}(),methods:{getDataTable:function(){var t=Object(s["a"])(regeneratorRuntime.mark((function t(){var e,r;return regeneratorRuntime.wrap((function(t){while(1)switch(t.prev=t.next){case 0:this.$store.state.loader=!0,e=this.getDraggableProperties(),console.debug("RESUTALDO_R_TABLE",e),r=[],[],Object.entries(e).forEach((function(t){var e=Object(o["a"])(t,2),n=e[0],a=e[1];console.debug(n,"ELEMT",a),Object.entries(a.devices).forEach((function(t){var e=Object(o["a"])(t,2),n=(e[0],e[1]);n.from=a.from,n.to=a.to,console.debug(a.from.date,a.to.date,"ELEMENTO",n),r.push(n)})),console.debug(n,"ELEMT",a,r)})),this.reports=r,this.resultado=!0,this.$store.state.loader=!1;case 9:case"end":return t.stop()}}),t,this)})));function e(){return t.apply(this,arguments)}return e}()},computed:{showData:function(){return this.resultado},gwtData:function(){return this.reports},isEmptyReports:function(){return $.isEmptyObject(this.reports)}}},l=u,d=(r("3cbd"),r("2877")),f=Object(d["a"])(l,n,a,!1,null,null,null);e["default"]=f.exports},9003:function(t,e,r){var n=r("6b4c");t.exports=Array.isArray||function(t){return"Array"==n(t)}},"95d5":function(t,e,r){var n=r("40c3"),a=r("5168")("iterator"),o=r("481b");t.exports=r("584a").isIterable=function(t){var e=Object(t);return void 0!==e[a]||"@@iterator"in e||o.hasOwnProperty(n(e))}},a745:function(t,e,r){t.exports=r("f410")},c8bb:function(t,e,r){t.exports=r("54a1")},f410:function(t,e,r){r("1af6"),t.exports=r("584a").Array.isArray},ffc1:function(t,e,r){var n=r("5ca1"),a=r("504c")(!0);n(n.S,"Object",{entries:function(t){return a(t)}})}}]);
//# sourceMappingURL=chunk-2da9bddb.2b32a7c3.js.map