<template>
    <div>

        <h5 class="configMarginLF configMarginTB" v-if="title!=null"><span style="font-size: 15px;" v-if="titledisp">Dispositivo: </span>{{title}}</h5>
        <h6 class="configMarginLF configMarginTB text-muted" v-if="subtitle!=null" v-bind:style="{color:color}">{{subtitle}}</h6>
        <p class="card-text  configMarginTB"  v-if="texto!=null && label==null" v-bind:style="{textAlign: textAlign}"><strong>{{texto}}</strong></p>
        <p class="card-text configMarginLF configMarginTB" v-if="texto!=null && label!=null" v-bind:style="{marginLeft: marginLeft, marginRight: marginRight}"><strong>{{texto}}</strong></p>

    </div>

</template>

<script>
/**
* @vuese
 * @group components/basico
 * componente de tipografia para: titulos, subtitulos y texto normal
 */
export default {
  name: 'typography',
  data () {
    return {
      titledisp: false,
      alingText: 'left'
    }
  },
  props: {
    // color del texto
    color: {
      type: String,
      required: false
    },
    // valor de titulo
    title: {
      type: String,
      required: false
    },
    // valor de subtitulo
    subtitle: {
      type: String,
      required: false
    },
    // valor de texto
    texto: {
      // type: String,
      required: false
    },
    // valor de etiqueta
    label: {
      type: String,
      required: false
    },
    // valor de titulo y valor
    dispTitle: {
      type: String,
      required: false
    },
    // valor de margen izquierdo
    marginLeft: {
      type: String,
      required: false
    },
    // valor de margen derecho
    marginRight: {
      type: String,
      required: false
    },
    // valor de alineacion del texto
    textAlign: {
      type: String,
      required: false
    }
  },
  created: function () {
    this.titledisp = this.dispTitle

    if (this.textAlign != null || this.textAlign != 'undefined') {
      this.textAlign = this.textAlign
    } else {
      this.textAlign = this.alingText
    }
  }
}

</script>

<style>
.configMarginLF{
  /* margin-left: 7px !important; */
   margin-right: 7px !important;

}

.configMarginTB{
  margin-top: 3px !important;
   margin-bottom: 3px !important;
}

</style>
