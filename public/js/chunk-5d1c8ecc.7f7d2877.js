(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-5d1c8ecc"],{"4d3c":function(e,t,a){"use strict";a.r(t);var r=function(){var e=this,t=e.$createElement,a=e._self._c||t;return a("div",{staticClass:"row justify-content-center"},[a("hr",{staticStyle:{width:"90%","margin-top":"-30px"}}),a("div",{staticClass:"col-11"},[a("form",{attrs:{id:"validation-form123",action:""},on:{submit:function(e){e.preventDefault()}}},[a("div",{staticClass:"row float-left"},[a("div",{staticClass:"col-12  text-left"},[a("m-select",{ref:"username",attrs:{nameSelect:"validation-select",data:e.getDatUsers,filterby:"username",title:"usuarios *"},on:{selectionChanged:e.OnUserSelected}})],1),a("div",{staticClass:"col-10"},[a("config-text-typography",{attrs:{texto:"Fecha de inicio *"}}),a("input",{staticClass:"form-control",attrs:{type:"text",id:"date-start1",placeholder:"Fecha de inicio",name:"validation-fechaIni"}})],1),e._m(0),a("div",{staticClass:"col-10"},[a("config-text-typography",{attrs:{texto:"Fecha final *"}}),a("input",{staticClass:"form-control",attrs:{type:"text",id:"date-end1",placeholder:"Fecha final",name:"validation-fechaFin"}})],1),e._m(1)]),e._m(2),a("div",{staticClass:"modal-footer row"},[a("div",{staticClass:"col-12"},[a("button",{staticClass:"btn btn-outline-primary",attrs:{type:"button"},on:{click:function(t){return e.cancel()}}},[e._v("CANCELAR")]),a("button",{staticClass:"btn btn-primary ",attrs:{id:"registerSubmit",type:"submit"},on:{click:function(t){return e.SendForm()}}},[e._v("GENERAR REPORTE")])])])])])])},n=[function(){var e=this,t=e.$createElement,a=e._self._c||t;return a("div",{staticClass:"input-group-prepend float-right col-2",staticStyle:{color:"#fff","background-color":"#04a9f5","border-color":"#04a9f5",left:"-17px","margin-top":"27px","padding-left":"22px"}},[a("i",{staticClass:" icon-md universalicon-calendar ",staticStyle:{padding:"4px","padding-top":"5px"}})])},function(){var e=this,t=e.$createElement,a=e._self._c||t;return a("div",{staticClass:"input-group-prepend float-right col-2",staticStyle:{color:"#fff","background-color":"#04a9f5","border-color":"#04a9f5",left:"-17px","margin-top":"27px","padding-left":"22px"}},[a("i",{staticClass:" icon-md universalicon-calendar ",staticStyle:{padding:"4px","padding-top":"5px"}})])},function(){var e=this,t=e.$createElement,a=e._self._c||t;return a("div",{staticClass:"row"},[a("div",{staticClass:"col-12",staticStyle:{"margin-top":"30px"},attrs:{id:"alertReportConfig"}})])}],i=(a("7514"),a("96cf"),a("3b8d")),s=a("08e6"),o=a("511d"),l=(a("d3e3"),a("b381")),c=a("afef"),d={name:"reportAccesos",mixins:[o["a"],s["a"]],components:{mSelect:l["a"]},data:function(){return{userList:[],user:null,order:1,fechaIni:null,fechaFin:null,email:null}},created:function(){var e=Object(i["a"])(regeneratorRuntime.mark((function e(){return regeneratorRuntime.wrap((function(e){while(1)switch(e.prev=e.next){case 0:this.$store.state.loader=!0;case 1:case"end":return e.stop()}}),e,this)})));function t(){return e.apply(this,arguments)}return t}(),mounted:function(){var e=Object(i["a"])(regeneratorRuntime.mark((function e(){var t,a,r,n;return regeneratorRuntime.wrap((function(e){while(1)switch(e.prev=e.next){case 0:return e.next=2,this.getUsers();case 2:$(".modal-header").css({"border-bottom":"10px solid  rgba(233, 236, 239, 0)"}),$((function(){console.debug("FUNCION VALIDATE"),$.validator.addMethod("phone_format",(function(e,t){return this.optional(t)||/^\(\d{3}\)[ ]\d{3}\-\d{4}$/.test(e)}),"Invalid phone number."),$("#validation-form123").validate({ignore:".ignore, .select2-input",focusInvalid:!1,rules:{"validation-select":{required:!0},"validation-fechaIni":{required:!0},"validation-fechaFin":{required:!0}},errorPlacement:function(e,t){console.debug("errorPlacement",e,t);var a=$(t).parents(".form-group");a.find(".jquery-validation-error").length||a.append(e.addClass("jquery-validation-error small form-text invalid-feedback"))},highlight:function(e){console.debug("highlight:MAL",e);var t=$(e);t.parents(".form-group");t.addClass("is-invalid"),(t.hasClass("select2-hidden-accessible")||"tagsinput"===t.attr("data-role"))&&t.parent().addClass("is-invalid")},unhighlight:function(e){console.debug("unhighlight_BIEN",e),$(e).parents(".form-group").find(".is-invalid").removeClass("is-invalid"),"input.form-control"==e&&console.debug("ENTRA_FIN_BIEN")}})})),$("#validation-email-error").html("Este campo es requerido"),this.$store.state.loader=!1,t=new Date,a=t.getDate(),r=t.getMonth(),n=t.getFullYear(),$("#date-end1").bootstrapMaterialDatePicker({weekStart:0,lang:"es",format:"MMMM DD, YYYY HH:mm:ss",shortTime:!0,year:!0,date:!0,time:!1,maxDate:this.$moment(new Date).endOf("day"),minDate:this.$moment(new Date).startOf("day"),currentDate:this.$moment(new Date).endOf("day")}),$("#date-start1").bootstrapMaterialDatePicker({weekStart:0,lang:"es",format:"MMMM DD, YYYY HH:mm:ss",currentDate:this.$moment(new Date).startOf("day"),maxDate:this.$moment(new Date).endOf("day"),shortTime:!0,year:!0,date:!0,time:!1}).on("change",(function(e,t){var i=new Date(t);this.fechaInicio=t;var s=i.getFullYear(),o=i.getDate();console.debug(this.fechaInicio,"fech sin formato",i);var l=i.getMonth(),c=i.setMonth(l+3),d=i.getMonth(),u=i.getFullYear();console.debug("actual",l,s),console.debug(i,"fecha mas3",d,u,"nueva fecha",c),u>n?(console.debug("año diferente",a,o),i=new Date):u==n&&(console.debug("mismo año"),d>l&&(i=new Date),d==r&&o>a&&(console.debug("dia mayor, mismo mes"),i=new Date)),console.debug("fecha FINAL",i),$("#date-end1").bootstrapMaterialDatePicker("setMinDate",t),$("#date-end1").bootstrapMaterialDatePicker("setMaxDate",i)})).on("change",(function(e,t){this.fechaFinal=t,console.debug("FECHA_FIANL",this.fechaFinal)}));case 12:case"end":return e.stop()}}),e,this)})));function t(){return e.apply(this,arguments)}return t}(),destroyed:function(){},methods:{getUsers:function(){var e=Object(i["a"])(regeneratorRuntime.mark((function e(){var t,a,r;return regeneratorRuntime.wrap((function(e){while(1)switch(e.prev=e.next){case 0:return e.next=2,this.getRequest("users");case 2:if(t=e.sent,!0!==t.success){e.next=8;break}a=t.data.users,this.userList=a,e.next=22;break;case 8:this.userList=[],this.$store.state.loader=!1,r="",e.t0=t.error.title,e.next="UNAUTHORIZED"===e.t0?14:16;break;case 14:return r="No cuenta con los permisos para realizar la petición.",e.abrupt("break",18);case 16:return r="No se puedo realizar la petición.",e.abrupt("break",18);case 18:notify("",r,"top","right","danger"),$("#modalReportCreate").modal("hide"),this.$store.commit("CLEAR_MODAL_DINAMIC"),this.$router.push("reports");case 22:console.debug("USUARIOS",this.userList);case 23:case"end":return e.stop()}}),e,this)})));function t(){return e.apply(this,arguments)}return t}(),OnUserSelected:function(e){console.debug("user",e),-1==e||(this.user=e.id)},SendForm:function(){var e=Object(i["a"])(regeneratorRuntime.mark((function e(){var t,a,r,n,i,s,o;return regeneratorRuntime.wrap((function(e){while(1)switch(e.prev=e.next){case 0:if(console.debug("LLAMDA"),null==this.user||""==this.user||""==this.order){e.next=36;break}if(console.debug("entra"),this.$store.state.loader=!0,t=$("#date-start1").val(),a=$("#date-end1").val(),this.fechaIni=t,this.fechaFin=a,t=this.fechaEsp(t),a=this.fechaEsp(a),1==this.order&&(i="desc"),2==this.order&&(i="asc"),s={deviceID:parseInt(this.user),order:i},""!=t||""!=a){e.next=16;break}e.next=26;break;case 16:if(""==t||""==a){e.next=23;break}r=Date.parse(t)/1e3,n=Date.parse(a)/1e3,s.fromTimestamp=r,s.toTimestamp=n,e.next=26;break;case 23:return $("#alertReportConfig").html("<div class='alert alert-danger alert-dismissible fade show' role='alert' style='text-align: initial;'><strong>Error! </strong>Debe ingresar las 2 fechas<button type='button' class='close' data-dismiss='alert' aria-label='Close' style='padding-top: 0px;'><span aria-hidden='true'>&times;</span></button></div>"),setTimeout((function(){$("#alertReportConfig").html("")}),3e3),e.abrupt("return",0);case 26:s.limit=500,o=this.sessionGet("timezone"),console.debug("TIMEZONE",o),s.timezone=o,console.debug("FECHAS_FIN",this.fechaIni,this.fechaFin),this.modalSend(s),this.$store.state.loader=!0,this.$router.push("reportResults"),e.next=37;break;case 36:$("#alertReportConfig").html("<div class='alert alert-danger alert-dismissible fade show' role='alert' style='text-align: initial;'> Hemos detectado parámetros INCOMPLETOS . <span>COMPLETA los parámetro marcados con un asterisco son obligatorios para generar tu reporte.</span><button type='button' class='close' data-dismiss='alert' aria-label='Close' style='padding-top: 0px;'><span aria-hidden='true'>&times;</span></button></div>");case 37:case"end":return e.stop()}}),e,this)})));function t(){return e.apply(this,arguments)}return t}(),modalSend:function(){var e=Object(i["a"])(regeneratorRuntime.mark((function e(t){var a,r;return regeneratorRuntime.wrap((function(e){while(1)switch(e.prev=e.next){case 0:return this.$store.state.loader=!0,console.debug("modal_cancel"),$("#modalReportCreate").modal("hide"),a="Permite diseñar desde el inicio la estructura de un reporte y el tipo de datos que va a incluir.",r={component:this.$store.state.modal.component,datos:{seccion:"reporte",id:this.$store.state.modal.datosDymanic.id,tittle:this.$store.state.modal.datosDymanic.tittle,subtittle:a,fechaIni:this.fechaIni,fechaFin:this.fechaFin,filters:t}},this.$store.commit("CLEAR_MODAL_DINAMIC"),e.next=8,this.$store.commit("ADD_COMPONENT_DINAMIC",r);case 8:return this.$store.commit("CLEAR_MODAL_DINAMIC_modaloader"),r={component:c["a"],datos:{}},e.next=12,this.$store.commit("ADD_COMPONENT_DINAMIC_modaloader",r);case 12:return e.next=14,this.$store.commit("ADD_COMPONENT_DINAMIC_STATE_modaloader",!0);case 14:console.debug("MODAl_modaloader",this.$store.state.modal.datosDymanic);case 15:case"end":return e.stop()}}),e,this)})));function t(t){return e.apply(this,arguments)}return t}(),cancel:function(){var e=Object(i["a"])(regeneratorRuntime.mark((function e(){return regeneratorRuntime.wrap((function(e){while(1)switch(e.prev=e.next){case 0:console.debug("CANCEL"),$("#modalReportCreate").modal("hide"),this.$router.push("cancelReports");case 3:case"end":return e.stop()}}),e,this)})));function t(){return e.apply(this,arguments)}return t}()},computed:{getDatUsers:function(){return this.userList}}},u=d,m=a("2877"),p=Object(m["a"])(u,r,n,!1,null,null,null);t["default"]=p.exports},afef:function(e,t,a){"use strict";var r=function(){var e=this,t=e.$createElement;e._self._c;return e._m(0)},n=[function(){var e=this,t=e.$createElement,a=e._self._c||t;return a("div",{staticClass:"modal fade",attrs:{id:"modalLoaderReport",tabindex:"-1",role:"dialog","aria-labelledby":"exampleModalCenterTitle","aria-hidden":"true"}},[a("div",{staticClass:"modal-dialog modal-dialog-centered",attrs:{role:"document"}},[a("div",{staticClass:"modal-content"},[a("div",{staticClass:"modal-body"},[a("p",[e._v("Espere por favor")]),a("div",{staticClass:"spinner-border",staticStyle:{}})])])])])}],i=(a("d3e3"),a("08e6")),s={name:"modalLoaderReporte",mixins:[i["a"]],data:function(){return{}},mounted:function(){$("#modalLoaderReport").modal("show")},destroyed:function(){},methods:{},computed:{}},o=s,l=a("2877"),c=Object(l["a"])(o,r,n,!1,null,null,null);t["a"]=c.exports},b381:function(e,t,a){"use strict";var r=function(){var e=this,t=e.$createElement,a=e._self._c||t;return a("div",{staticClass:"text-left",staticStyle:{"margin-bottom":"10px"}},[a("label",[e._v(e._s(e.title))]),a("select",{directives:[{name:"model",rawName:"v-model",value:e.selectedItem,expression:"selectedItem"}],staticClass:"form-control",attrs:{name:e.nameSelect,refs:"select"},on:{change:[function(t){var a=Array.prototype.filter.call(t.target.options,(function(e){return e.selected})).map((function(e){var t="_value"in e?e._value:e.value;return t}));e.selectedItem=t.target.multiple?a:a[0]},e.onChange]}},[a("option",{attrs:{disabled:"",value:""}},[e._v("Seleccione")]),e._l(e.data,(function(t,r){return a("option",{key:r,domProps:{value:t}},[e._v(e._s(t[e.filterby]))])}))],2)])},n=[],i={name:"MSelect",props:{data:{type:Array,required:!0},filterby:{type:String,required:!0},title:{default:"Seleccione",type:String},nameSelect:{type:String,required:!1}},data:function(){return{selectedItem:""}},created:function(){},methods:{onChange:function(){this.$emit("selectionChanged",this.selectedItem)}},watch:{data:function(){this.selectedItem=""}}},s=i,o=a("2877"),l=Object(o["a"])(s,r,n,!1,null,null,null);t["a"]=l.exports}}]);
//# sourceMappingURL=chunk-5d1c8ecc.7f7d2877.js.map