(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-458fd62e"],{"1af6":function(t,e,r){var a=r("63b6");a(a.S,"Array",{isArray:r("9003")})},"469f":function(t,e,r){r("6c1c"),r("1654"),t.exports=r("7d7b")},"54a1":function(t,e,r){r("6c1c"),r("1654"),t.exports=r("95d5")},"5d73":function(t,e,r){t.exports=r("469f")},"768b":function(t,e,r){"use strict";var a=r("a745"),n=r.n(a);function s(t){if(n()(t))return t}var i=r("5d73"),o=r.n(i),c=r("c8bb"),l=r.n(c);function u(t,e){if(l()(Object(t))||"[object Arguments]"===Object.prototype.toString.call(t)){var r=[],a=!0,n=!1,s=void 0;try{for(var i,c=o()(t);!(a=(i=c.next()).done);a=!0)if(r.push(i.value),e&&r.length===e)break}catch(u){n=!0,s=u}finally{try{a||null==c["return"]||c["return"]()}finally{if(n)throw s}}return r}}function h(){throw new TypeError("Invalid attempt to destructure non-iterable instance")}function p(t,e){return s(t)||u(t,e)||h()}r.d(e,"a",(function(){return p}))},"7d7b":function(t,e,r){var a=r("e4ae"),n=r("7cd6");t.exports=r("584a").getIterator=function(t){var e=n(t);if("function"!=typeof e)throw TypeError(t+" is not iterable!");return a(e.call(t))}},9003:function(t,e,r){var a=r("6b4c");t.exports=Array.isArray||function(t){return"Array"==a(t)}},"95d5":function(t,e,r){var a=r("40c3"),n=r("5168")("iterator"),s=r("481b");t.exports=r("584a").isIterable=function(t){var e=Object(t);return void 0!==e[n]||"@@iterator"in e||s.hasOwnProperty(a(e))}},a745:function(t,e,r){t.exports=r("f410")},c8bb:function(t,e,r){t.exports=r("54a1")},e242:function(t,e,r){"use strict";r.r(e);var a=function(){var t=this,e=t.$createElement,r=t._self._c||e;return r("div",{staticClass:"col-12",staticStyle:{"margin-top":"50px"}},[r("div",{staticClass:"row",staticStyle:{"margin-left":"10px","margin-right":"10px"}},[r("div",{directives:[{name:"show",rawName:"v-show",value:!t.isEmptyReports,expression:"!isEmptyReports"}],staticClass:"col-12"},[t._m(0),r("div",{staticStyle:{width:"100%",height:"350px"},attrs:{id:"chart-highchart-pie1"}})]),r("div",{directives:[{name:"show",rawName:"v-show",value:!t.isEmptyReports,expression:"!isEmptyReports"}],staticClass:"col-12"},[r("hr",{staticStyle:{"margin-top":"60px","margin-bottom":"60px"}})]),r("div",{directives:[{name:"show",rawName:"v-show",value:!t.isEmptyReports,expression:"!isEmptyReports"}],staticClass:"col-12"},[t._m(1),r("div",{staticClass:"row",staticStyle:{"margin-top":"5px","margin-bottom":"25px"}},[r("div",{staticClass:"col-3 cursor",attrs:{id:"barMes"},on:{click:function(e){return t.initChartBar(1)}}},[t._v("Mensual")]),r("div",{staticClass:"col-3 cursor",attrs:{id:"barSem"},on:{click:function(e){return t.initChartBar(2)}}},[t._v("Semanal")])]),r("div",{staticStyle:{width:"100%",height:"450px"},attrs:{id:"chart-highchart-bar"}})]),r("div",{directives:[{name:"show",rawName:"v-show",value:t.isEmptyReports,expression:"isEmptyReports"}],staticClass:"col-12",staticStyle:{"margin-bottom":"30px"}},[t._v("No se encontraron resultados")])])])},n=[function(){var t=this,e=t.$createElement,r=t._self._c||e;return r("div",{staticClass:"row"},[r("span",{staticStyle:{content:"''","background-color":"#04a9f5",position:"absolute",width:"4px",height:"20px"}}),r("h5",{staticClass:"float-left",staticStyle:{"margin-left":"20px"}},[t._v("Promedio de uso de motor")])])},function(){var t=this,e=t.$createElement,r=t._self._c||e;return r("div",{staticClass:"row"},[r("span",{staticStyle:{content:"''","background-color":"#04a9f5",position:"absolute",width:"4px",height:"20px"}}),r("h5",{staticClass:"float-left",staticStyle:{"margin-left":"20px"}},[t._v("Hora de uso de motor")])])}],s=r("768b"),i=(r("ffc1"),r("ac6a"),r("96cf"),r("3b8d")),o=r("08e6"),c=r("511d"),l=r("d3e3"),u={name:"ReportesGraphDist",mixins:[o["a"],c["a"]],data:function(){return{data:null,reports:[],resultado:!1}},inject:["dataGraph"],created:function(){var t=Object(i["a"])(regeneratorRuntime.mark((function t(){return regeneratorRuntime.wrap((function(t){while(1)switch(t.prev=t.next){case 0:this.$store.state.loader=!0,this.getDataGraph(this.$store.state.modal.datosDymanic.filters);case 2:case"end":return t.stop()}}),t,this)})));function e(){return t.apply(this,arguments)}return e}(),mounted:function(){var t=Object(i["a"])(regeneratorRuntime.mark((function t(){return regeneratorRuntime.wrap((function(t){while(1)switch(t.prev=t.next){case 0:return $("#containerPrincipal").css({"margin-left":this.$store.state.widthMenu}),$("#containerPrincipal").css({"margin-top":this.$store.state.topMenu}),this.$store.state.seccionMenu="reportes",t.next=5,l["a"].$emit("NAVBAR_MenuSimple","reportes");case 5:return $("#lineMes").css({"font-weight":"normal"}),$("#lineSem").css({"font-weight":"normal"}),$("#barMes").css({"font-weight":"normal"}),$("#barSem").css({"font-weight":"normal"}),t.next=11,this.initChartLine(1);case 11:return t.next=13,this.initChartBar(1);case 13:$("#modalLoaderReport").modal("hide"),this.$store.commit("ADD_COMPONENT_DINAMIC_STATE_modaloader",!1);case 15:case"end":return t.stop()}}),t,this)})));function e(){return t.apply(this,arguments)}return e}(),methods:{getDataGraph:function(){var t=Object(i["a"])(regeneratorRuntime.mark((function t(e){return regeneratorRuntime.wrap((function(t){while(1)switch(t.prev=t.next){case 0:this.$store.state.loader=!0,this.reports=this.dataGraph(),console.debug("RESUTALDO_R",this.reports),this.resultado=!0;case 4:case"end":return t.stop()}}),t,this)})));function e(e){return t.apply(this,arguments)}return e}(),initChartLine:function(t){var e=[],r=[],a=[],n=[],s=parseInt(this.reports.engineRunningTime.totalSeconds)+parseInt(this.reports.engineOffTime.totalSeconds),i=100*parseInt(this.reports.engineRunningTime.totalSeconds)/parseInt(s),o=100*parseInt(this.reports.engineOffTime.totalSeconds)/parseInt(s);e.push(i),n.push(o),a.push({name:this.reports.device.alias+" - Encendido",y:i}),a.push({name:this.reports.device.alias+" - Apagado",y:o}),console.debug("DATOS_porcen motor",a,"cat",r),Highcharts.chart("chart-highchart-pie1",{chart:{plotBackgroundColor:null,plotBorderWidth:null,plotShadow:!1,type:"pie"},colors:["#1de9b6","#1dc4e9","#A389D4","#899FD4","#f44236","#f4c22b"],title:{text:""},tooltip:{pointFormat:"{data.name}: <b>{point.percentage:.1f}%</b>"},plotOptions:{pie:{allowPointSelect:!0,cursor:"pointer",dataLabels:{enabled:!1},showInLegend:!0}},legend:{layout:"vertical",align:"right",verticalAlign:"middle"},series:[{colorByPoint:!0,data:a}]}),$(".highcharts-credits").css("display","none"),this.$store.state.loader=!1},initChartBar:function(t){var e=this;$("#barMes").css({"font-weight":"normal"}),$("#barSem").css({"font-weight":"normal"});var r=[],a=[],n=[],i=[];switch(t){case 1:$("#barMes").css({"font-weight":"bold"}),Object.entries(this.reports.monthPeriods).forEach((function(t){var r=Object(s["a"])(t,2),a=r[0],i=r[1];n.push(e.obtenerMesString(a)+" "+a.substr(3,4)),console.debug(a.substr(3,4),"",a,"ELEMT_sub:BAR",i)})),Object.entries(this.reports.monthPeriods).forEach((function(t){var e=Object(s["a"])(t,2),n=(e[0],e[1]);r.push(n.engineRunningTime.hours),a.push(n.engineOffTime.hours)})),i.push({name:this.reports.device.alias+" - Encendido",data:r}),i.push({name:this.reports.device.alias+" - Apagado",data:a}),console.debug("DATOS_BAR",i,"cat",n);break;case 2:$("#barSem").css({"font-weight":"bold"}),Object.entries(this.reports.weekPeriods).forEach((function(t){var e=Object(s["a"])(t,2),r=e[0],a=e[1];n.push(a.from.date+" al <br>"+a.to.date+"<br> (<b>Semana "+r.substr(0,2)+"</b>)"),console.debug("Sem "+r,"ELEMT_sub",a)})),Object.entries(this.reports.weekPeriods).forEach((function(t){var n=Object(s["a"])(t,2),i=(n[0],n[1]);r.push(i.engineRunningTime.hours),a.push(i.engineOffTime.hours);var o=new Date(1e3*i.engineRunningTime.totalSeconds),c=e.$moment(o).fromNow(),l=e.$moment(o).format(" MMMM DD YYYY, h:mm a"),u="".concat(l," (").concat(c,")"),h=new Date(1e3*i.engineOffTime.totalSeconds),p=e.$moment(h).fromNow(),d=e.$moment(h).format(" MMMM DD YYYY, h:mm a"),m="".concat(d," (").concat(p,")");console.debug(u,"HACE",m)})),i.push({name:this.reports.device.alias+" - Encendido",data:r}),i.push({name:this.reports.device.alias+" - Apagado",data:a}),console.debug("DATOS_sem_BAR",i,"cat",n,"array",r,a);break}Highcharts.chart("chart-highchart-bar",{chart:{type:"column"},colors:["#1de9b6","#1dc4e9","#A389D4","#899FD4"],title:{text:""},subtitle:{text:""},xAxis:{categories:n,crosshair:!0},yAxis:{min:0,title:{text:"Horas uso de motor"}},tooltip:{headerFormat:'<span style="font-size:10px">{point.key}</span><table>',pointFormat:'<tr><td style="color:{series.color};padding:0">{series.name}: </td><td style="padding:0"><b>{point.y:.1f} hrs</b></td></tr>',footerFormat:"</table>",shared:!0,useHTML:!0},plotOptions:{column:{pointPadding:.2,borderWidth:0}},series:i}),$(".highcharts-credits").css("display","none"),this.$store.state.loader=!1}},computed:{showData:function(){return this.resultado},gwtData:function(){return this.reports},isEmptyReports:function(){return $.isEmptyObject(this.reports.monthPeriods)}}},h=u,p=r("2877"),d=Object(p["a"])(h,a,n,!1,null,null,null);e["default"]=d.exports},f410:function(t,e,r){r("1af6"),t.exports=r("584a").Array.isArray},ffc1:function(t,e,r){var a=r("5ca1"),n=r("504c")(!0);a(a.S,"Object",{entries:function(t){return n(t)}})}}]);
//# sourceMappingURL=chunk-458fd62e.00e9720c.js.map