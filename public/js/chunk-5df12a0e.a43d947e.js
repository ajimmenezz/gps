(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-5df12a0e"],{"1af6":function(t,e,r){var s=r("63b6");s(s.S,"Array",{isArray:r("9003")})},"469f":function(t,e,r){r("6c1c"),r("1654"),t.exports=r("7d7b")},"54a1":function(t,e,r){r("6c1c"),r("1654"),t.exports=r("95d5")},"5d73":function(t,e,r){t.exports=r("469f")},6320:function(t,e,r){"use strict";r.r(e);var s=function(){var t=this,e=t.$createElement,r=t._self._c||e;return r("div",{staticClass:"col-12",staticStyle:{"margin-top":"50px"}},[r("div",{staticClass:"row",staticStyle:{"margin-left":"10px","margin-right":"10px"}},[r("div",{directives:[{name:"show",rawName:"v-show",value:!t.isEmptyReports,expression:"!isEmptyReports"}],staticClass:"col-12"},[t._m(0),r("div",{staticClass:"row",staticStyle:{"margin-top":"5px","margin-bottom":"15px"}},[r("div",{staticClass:"col-3 cursor",attrs:{id:"lineMes"},on:{click:function(e){return t.initChartLine(1)}}},[t._v("Mensual")]),r("div",{staticClass:"col-3 cursor",attrs:{id:"lineSem"},on:{click:function(e){return t.initChartLine(2)}}},[t._v("Semanal")])]),r("div",{staticStyle:{width:"100%",height:"350px"},attrs:{id:"chart-highchart-line"}})]),r("div",{directives:[{name:"show",rawName:"v-show",value:!t.isEmptyReports,expression:"!isEmptyReports"}],staticClass:"col-12"},[r("hr",{staticStyle:{"margin-top":"60px","margin-bottom":"60px"}})]),r("div",{directives:[{name:"show",rawName:"v-show",value:!t.isEmptyReports,expression:"!isEmptyReports"}],staticClass:"col-12"},[t._m(1),r("div",{staticClass:"row",staticStyle:{"margin-top":"5px","margin-bottom":"25px"}},[r("div",{staticClass:"col-3 cursor",attrs:{id:"barMes"},on:{click:function(e){return t.initChartBar(1)}}},[t._v("Mensual")]),r("div",{staticClass:"col-3 cursor",attrs:{id:"barSem"},on:{click:function(e){return t.initChartBar(2)}}},[t._v("Semanal")])]),r("div",{staticStyle:{width:"100%",height:"450px"},attrs:{id:"chart-highchart-bar"}})]),r("div",{directives:[{name:"show",rawName:"v-show",value:t.isEmptyReports,expression:"isEmptyReports"}],staticClass:"col-12",staticStyle:{"margin-bottom":"30px"}},[t._v("No se encontraron resultados")])])])},a=[function(){var t=this,e=t.$createElement,r=t._self._c||e;return r("div",{staticClass:"row"},[r("span",{staticStyle:{content:"''","background-color":"#04a9f5",position:"absolute",width:"4px",height:"20px"}}),r("h5",{staticClass:"float-left",staticStyle:{"margin-left":"20px"}},[t._v("Distancia recorrida")])])},function(){var t=this,e=t.$createElement,r=t._self._c||e;return r("div",{staticClass:"row"},[r("span",{staticStyle:{content:"''","background-color":"#04a9f5",position:"absolute",width:"4px",height:"20px"}}),r("h5",{staticClass:"float-left",staticStyle:{"margin-left":"20px"}},[t._v("Promedio distancia recorrida")])])}],i=r("768b"),n=(r("ffc1"),r("ac6a"),r("96cf"),r("3b8d")),o=r("08e6"),c=r("511d"),l=r("d3e3"),h={name:"ReportesGraphDist",mixins:[o["a"],c["a"]],data:function(){return{data:null,reports:[],resultado:!1}},inject:["dataGraph"],created:function(){var t=Object(n["a"])(regeneratorRuntime.mark((function t(){return regeneratorRuntime.wrap((function(t){while(1)switch(t.prev=t.next){case 0:this.getDataGraph(this.$store.state.modal.datosDymanic.filters);case 1:case"end":return t.stop()}}),t,this)})));function e(){return t.apply(this,arguments)}return e}(),mounted:function(){var t=Object(n["a"])(regeneratorRuntime.mark((function t(){return regeneratorRuntime.wrap((function(t){while(1)switch(t.prev=t.next){case 0:return $("#containerPrincipal").css({"margin-left":this.$store.state.widthMenu}),$("#containerPrincipal").css({"margin-top":this.$store.state.topMenu}),this.$store.state.seccionMenu="reportes",t.next=5,l["a"].$emit("NAVBAR_MenuSimple","reportes");case 5:return $("#lineMes").css({"font-weight":"normal"}),$("#lineSem").css({"font-weight":"normal"}),$("#barMes").css({"font-weight":"normal"}),$("#barSem").css({"font-weight":"normal"}),t.next=11,this.initChartLine(1);case 11:return t.next=13,this.initChartBar(1);case 13:this.$store.state.loader=!1;case 14:case"end":return t.stop()}}),t,this)})));function e(){return t.apply(this,arguments)}return e}(),methods:{getDataGraph:function(){var t=Object(n["a"])(regeneratorRuntime.mark((function t(e){return regeneratorRuntime.wrap((function(t){while(1)switch(t.prev=t.next){case 0:this.$store.state.loader=!0,this.reports=this.dataGraph(),console.debug("RESUTALDO_R",this.reports),this.resultado=!0,this.$store.state.loader=!1;case 5:case"end":return t.stop()}}),t,this)})));function e(e){return t.apply(this,arguments)}return e}(),initChartLine:function(t){var e=this,r=[],s=[],a=[];switch($("#lineMes").css({"font-weight":"normal"}),$("#lineSem").css({"font-weight":"normal"}),t){case 1:$("#lineMes").css({"font-weight":"bold"}),Object.entries(this.reports.monthPeriods).forEach((function(t){var r=Object(i["a"])(t,2),a=r[0],n=r[1];s.push(e.obtenerMesString(a)+" "+a.substr(3,4)),console.debug(a.substr(3,4),"",a,"ELEMT_sub",n)})),Object.entries(this.reports.monthPeriods).forEach((function(t){var e=Object(i["a"])(t,2),s=(e[0],e[1]);r.push(s.distanceTraveled)})),a.push({name:this.reports.device.alias,data:r}),console.debug("DATOS 1",a,"cat",s);break;case 2:$("#lineSem").css({"font-weight":"bold"}),Object.entries(this.reports.weekPeriods).forEach((function(t){var e=Object(i["a"])(t,2),r=e[0],a=e[1];s.push(a.from.date+" al <br>"+a.to.date+"<br> (<b>Semana "+r.substr(0,2)+"</b>)"),console.debug("Sem "+r,"ELEMT_sub",a)})),Object.entries(this.reports.weekPeriods).forEach((function(t){var e=Object(i["a"])(t,2),s=(e[0],e[1]);r.push(s.distanceTraveled)})),a.push({name:this.reports.device.alias,data:r}),console.debug("DATOS_sem 1",a,"cat",s);break}Highcharts.chart("chart-highchart-line",{chart:{type:"spline"},colors:["#1de9b6","#1dc4e9","#A389D4"],title:{text:""},subtitle:{text:""},xAxis:{categories:s},yAxis:{title:{text:"Distancia recorrida en kilometros"}},plotOptions:{line:{dataLabels:{enabled:!0},enableMouseTracking:!1}},tooltip:{headerFormat:'<span style="font-size:10px">{point.key}</span><table>',pointFormat:'<tr><td style="color:{series.color};padding:0">{series.name}: </td><td style="padding:0"><b>{point.y:.1f} km</b></td></tr>',footerFormat:"</table>",shared:!0,useHTML:!0},series:a,responsive:{rules:[{condition:{maxWidth:500},chartOptions:{legend:{layout:"horizontal",align:"center",verticalAlign:"bottom"}}}]}}),$(".highcharts-credits").css("display","none"),$("#modalLoaderReport").modal("hide"),this.$store.commit("ADD_COMPONENT_DINAMIC_STATE_modaloader",!1)},initChartBar:function(t){var e=this;$("#barMes").css({"font-weight":"normal"}),$("#barSem").css({"font-weight":"normal"});var r=[],s=[],a=[];switch(t){case 1:$("#barMes").css({"font-weight":"bold"}),Object.entries(this.reports.monthPeriods).forEach((function(t){var r=Object(i["a"])(t,2),a=r[0],n=r[1];s.push(e.obtenerMesString(a)+" "+a.substr(3,4)),console.debug(a.substr(3,4),"",a,"ELEMT_sub:BAR",n)})),Object.entries(this.reports.monthPeriods).forEach((function(t){var e=Object(i["a"])(t,2),s=(e[0],e[1]);r.push(s.distanceTraveledAverage)})),a.push({name:this.reports.device.alias,data:r}),console.debug("DATOS_BAR",a,"cat",s);break;case 2:$("#barSem").css({"font-weight":"bold"}),Object.entries(this.reports.weekPeriods).forEach((function(t){var e=Object(i["a"])(t,2),r=e[0],a=e[1];s.push(a.from.date+" al <br>"+a.to.date+"<br> (<b>Semana "+r.substr(0,2)+"</b>)"),console.debug("Sem "+r,"ELEMT_sub",a)})),Object.entries(this.reports.weekPeriods).forEach((function(t){var e=Object(i["a"])(t,2),s=(e[0],e[1]);r.push(s.distanceTraveledAverage)})),a.push({name:this.reports.device.alias,data:r}),console.debug("DATOS_sem_BAR",a,"cat",s);break}Highcharts.chart("chart-highchart-bar",{chart:{type:"column"},colors:["#1de9b6","#1dc4e9","#A389D4","#899FD4"],title:{text:""},subtitle:{text:""},xAxis:{categories:s,crosshair:!0},yAxis:{min:0,title:{text:"Promedio de distancia en kilometros"}},tooltip:{headerFormat:'<span style="font-size:10px">{point.key}</span><table>',pointFormat:'<tr><td style="color:{series.color};padding:0">{series.name}: </td><td style="padding:0"><b>{point.y:.1f} km</b></td></tr>',footerFormat:"</table>",shared:!0,useHTML:!0},plotOptions:{column:{pointPadding:.2,borderWidth:0}},series:a}),$(".highcharts-credits").css("display","none"),$("#modalLoaderReport").modal("hide"),this.$store.commit("ADD_COMPONENT_DINAMIC_STATE_modaloader",!1)}},computed:{showData:function(){return this.resultado},gwtData:function(){return this.reports},isEmptyReports:function(){return $.isEmptyObject(this.reports.monthPeriods)}}},u=h,d=r("2877"),p=Object(d["a"])(u,s,a,!1,null,null,null);e["default"]=p.exports},"768b":function(t,e,r){"use strict";var s=r("a745"),a=r.n(s);function i(t){if(a()(t))return t}var n=r("5d73"),o=r.n(n),c=r("c8bb"),l=r.n(c);function h(t,e){if(l()(Object(t))||"[object Arguments]"===Object.prototype.toString.call(t)){var r=[],s=!0,a=!1,i=void 0;try{for(var n,c=o()(t);!(s=(n=c.next()).done);s=!0)if(r.push(n.value),e&&r.length===e)break}catch(h){a=!0,i=h}finally{try{s||null==c["return"]||c["return"]()}finally{if(a)throw i}}return r}}function u(){throw new TypeError("Invalid attempt to destructure non-iterable instance")}function d(t,e){return i(t)||h(t,e)||u()}r.d(e,"a",(function(){return d}))},"7d7b":function(t,e,r){var s=r("e4ae"),a=r("7cd6");t.exports=r("584a").getIterator=function(t){var e=a(t);if("function"!=typeof e)throw TypeError(t+" is not iterable!");return s(e.call(t))}},9003:function(t,e,r){var s=r("6b4c");t.exports=Array.isArray||function(t){return"Array"==s(t)}},"95d5":function(t,e,r){var s=r("40c3"),a=r("5168")("iterator"),i=r("481b");t.exports=r("584a").isIterable=function(t){var e=Object(t);return void 0!==e[a]||"@@iterator"in e||i.hasOwnProperty(s(e))}},a745:function(t,e,r){t.exports=r("f410")},c8bb:function(t,e,r){t.exports=r("54a1")},f410:function(t,e,r){r("1af6"),t.exports=r("584a").Array.isArray},ffc1:function(t,e,r){var s=r("5ca1"),a=r("504c")(!0);s(s.S,"Object",{entries:function(t){return a(t)}})}}]);
//# sourceMappingURL=chunk-5df12a0e.a43d947e.js.map