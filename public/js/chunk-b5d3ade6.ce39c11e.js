(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-b5d3ade6"],{"1af6":function(t,e,r){var a=r("63b6");a(a.S,"Array",{isArray:r("9003")})},"469f":function(t,e,r){r("6c1c"),r("1654"),t.exports=r("7d7b")},"54a1":function(t,e,r){r("6c1c"),r("1654"),t.exports=r("95d5")},"5d73":function(t,e,r){t.exports=r("469f")},"768b":function(t,e,r){"use strict";var a=r("a745"),s=r.n(a);function n(t){if(s()(t))return t}var i=r("5d73"),o=r.n(i),c=r("c8bb"),u=r.n(c);function l(t,e){if(u()(Object(t))||"[object Arguments]"===Object.prototype.toString.call(t)){var r=[],a=!0,s=!1,n=void 0;try{for(var i,c=o()(t);!(a=(i=c.next()).done);a=!0)if(r.push(i.value),e&&r.length===e)break}catch(l){s=!0,n=l}finally{try{a||null==c["return"]||c["return"]()}finally{if(s)throw n}}return r}}function h(){throw new TypeError("Invalid attempt to destructure non-iterable instance")}function p(t,e){return n(t)||l(t,e)||h()}r.d(e,"a",(function(){return p}))},"7d7b":function(t,e,r){var a=r("e4ae"),s=r("7cd6");t.exports=r("584a").getIterator=function(t){var e=s(t);if("function"!=typeof e)throw TypeError(t+" is not iterable!");return a(e.call(t))}},9003:function(t,e,r){var a=r("6b4c");t.exports=Array.isArray||function(t){return"Array"==a(t)}},"95d5":function(t,e,r){var a=r("40c3"),s=r("5168")("iterator"),n=r("481b");t.exports=r("584a").isIterable=function(t){var e=Object(t);return void 0!==e[s]||"@@iterator"in e||n.hasOwnProperty(a(e))}},a745:function(t,e,r){t.exports=r("f410")},c8bb:function(t,e,r){t.exports=r("54a1")},e499:function(t,e,r){"use strict";r.r(e);var a=function(){var t=this,e=t.$createElement,r=t._self._c||e;return r("div",{staticClass:"col-12",staticStyle:{"margin-top":"50px"}},[r("div",{staticClass:"row",staticStyle:{"margin-left":"10px","margin-right":"10px"}},[r("div",{directives:[{name:"show",rawName:"v-show",value:!t.isEmptyReports,expression:"!isEmptyReports"}],staticClass:"col-12"},[t._m(0),r("div",{staticClass:"row",staticStyle:{"margin-top":"5px","margin-bottom":"25px"}},[r("div",{staticClass:"col-3 cursor",attrs:{id:"barMes"},on:{click:function(e){return t.initChartBar(1)}}},[t._v("Mensual")]),r("div",{staticClass:"col-3 cursor",attrs:{id:"barSem"},on:{click:function(e){return t.initChartBar(2)}}},[t._v("Semanal")])]),r("div",{staticStyle:{width:"100%",height:"450px"},attrs:{id:"chart-highchart-bar"}})]),r("div",{directives:[{name:"show",rawName:"v-show",value:t.isEmptyReports,expression:"isEmptyReports"}],staticClass:"col-12",staticStyle:{"margin-bottom":"30px"}},[t._v("No se encontraron resultados")])])])},s=[function(){var t=this,e=t.$createElement,r=t._self._c||e;return r("div",{staticClass:"row"},[r("span",{staticStyle:{content:"''","background-color":"#04a9f5",position:"absolute",width:"4px",height:"20px"}}),r("h5",{staticClass:"float-left",staticStyle:{"margin-left":"20px"}},[t._v("Número de accesos")])])}],n=r("768b"),i=(r("ffc1"),r("ac6a"),r("96cf"),r("3b8d")),o=r("08e6"),c=r("511d"),u=r("d3e3"),l={name:"ReportesGraphDist",mixins:[o["a"],c["a"]],data:function(){return{data:null,reports:[],resultado:!1}},inject:["dataGraph"],created:function(){var t=Object(i["a"])(regeneratorRuntime.mark((function t(){return regeneratorRuntime.wrap((function(t){while(1)switch(t.prev=t.next){case 0:this.getDataGraph(this.$store.state.modal.datosDymanic.filters);case 1:case"end":return t.stop()}}),t,this)})));function e(){return t.apply(this,arguments)}return e}(),mounted:function(){var t=Object(i["a"])(regeneratorRuntime.mark((function t(){return regeneratorRuntime.wrap((function(t){while(1)switch(t.prev=t.next){case 0:return $("#containerPrincipal").css({"margin-left":this.$store.state.widthMenu}),$("#containerPrincipal").css({"margin-top":this.$store.state.topMenu}),this.$store.state.seccionMenu="reportes",t.next=5,u["a"].$emit("NAVBAR_MenuSimple","reportes");case 5:return $("#lineMes").css({"font-weight":"normal"}),$("#lineSem").css({"font-weight":"normal"}),$("#barMes").css({"font-weight":"normal"}),$("#barSem").css({"font-weight":"normal"}),t.next=11,this.initChartBar(1);case 11:this.$store.state.loader=!1;case 12:case"end":return t.stop()}}),t,this)})));function e(){return t.apply(this,arguments)}return e}(),methods:{getDataGraph:function(){var t=Object(i["a"])(regeneratorRuntime.mark((function t(e){return regeneratorRuntime.wrap((function(t){while(1)switch(t.prev=t.next){case 0:this.$store.state.loader=!0,this.reports=this.dataGraph(),console.debug("RESUTALDO_R",this.reports),this.resultado=!0,this.$store.state.loader=!1;case 5:case"end":return t.stop()}}),t,this)})));function e(e){return t.apply(this,arguments)}return e}(),initChartBar:function(t){var e=this;$("#barMes").css({"font-weight":"normal"}),$("#barSem").css({"font-weight":"normal"});var r=[],a=[],s=[];switch(t){case 1:$("#barMes").css({"font-weight":"bold"}),Object.entries(this.reports.monthPeriods).forEach((function(t){var r=Object(n["a"])(t,2),s=r[0],i=r[1];a.push(e.obtenerMesString(s)+" "+s.substr(3,4)),console.debug(s.substr(3,4),"",s,"ELEMT_sub:BAR",i)})),Object.entries(this.reports.monthPeriods).forEach((function(t){var e=Object(n["a"])(t,2),a=(e[0],e[1]);r.push(a.totalAccess)})),s.push({name:this.reports.user.alias,data:r}),console.debug("DATOS_BAR",s,"cat",a);break;case 2:$("#barSem").css({"font-weight":"bold"}),Object.entries(this.reports.weekPeriods).forEach((function(t){var e=Object(n["a"])(t,2),r=e[0],s=e[1];a.push(s.from.date+" al <br>"+s.to.date+"<br> (<b>Semana "+r.substr(0,2)+"</b>)"),console.debug("Sem "+r,"ELEMT_sub",s)})),Object.entries(this.reports.weekPeriods).forEach((function(t){var e=Object(n["a"])(t,2),a=(e[0],e[1]);r.push(a.totalAccess)})),s.push({name:this.reports.user.alias,data:r}),console.debug("DATOS_sem_BAR",s,"cat",a);break}Highcharts.chart("chart-highchart-bar",{chart:{type:"column"},colors:["#1de9b6","#1dc4e9","#A389D4","#899FD4"],title:{text:""},subtitle:{text:""},xAxis:{categories:a,crosshair:!0},yAxis:{min:0,title:{text:"Número de accesos"}},tooltip:{headerFormat:'<span style="font-size:10px">{point.key}</span><table>',pointFormat:'<tr><td style="color:{series.color};padding:0">{series.name}:  </td><td style="padding:0"><b>{point.y} accesos</b></td></tr>',footerFormat:"</table>",shared:!0,useHTML:!0},plotOptions:{column:{pointPadding:.2,borderWidth:0}},series:s}),$(".highcharts-credits").css("display","none"),$("#modalLoaderReport").modal("hide"),this.$store.commit("ADD_COMPONENT_DINAMIC_STATE_modaloader",!1)}},computed:{showData:function(){return this.resultado},gwtData:function(){return this.reports},isEmptyReports:function(){return $.isEmptyObject(this.reports.monthPeriods)}}},h=l,p=r("2877"),d=Object(p["a"])(h,a,s,!1,null,null,null);e["default"]=d.exports},f410:function(t,e,r){r("1af6"),t.exports=r("584a").Array.isArray},ffc1:function(t,e,r){var a=r("5ca1"),s=r("504c")(!0);a(a.S,"Object",{entries:function(t){return s(t)}})}}]);
//# sourceMappingURL=chunk-b5d3ade6.ce39c11e.js.map