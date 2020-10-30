# FormularioPuntosInteres

Formulario de crear, editar y consultar puntos de interes

## Props

<!-- @vuese:FormularioPuntosInteres:props:start -->
|Name|Description|Type|Required|Default|
|---|---|---|---|---|
|seccion|-|—|`false`|-|
|accion|-|—|`false`|-|
|dataDrawing|-|—|`false`|-|
|idPuntoCars|-|—|`false`|-|

<!-- @vuese:FormularioPuntosInteres:props:end -->


## Events

<!-- @vuese:FormularioPuntosInteres:events:start -->
|Event Name|Description|Parameters|
|---|---|---|
|showAllDrawing|-|-|
|setRadioGeocerca|-|-|
|DrawingGeocerca|-|-|
|onDevicesSelected|-|-|
|onClose|manda a cerrar o abrir el panel|-|

<!-- @vuese:FormularioPuntosInteres:events:end -->


## Methods

<!-- @vuese:FormularioPuntosInteres:methods:start -->
|Method|Description|Parameters|
|---|---|---|
|showAllDrawingGeo|Oculta dibujos de puntos de interes en mapa|-|
|getradioPuntoInteres|Modifica el radio de putos de interes|`value` radio de putos de interes|
|crearDrawing|Manda a dibujar la punto de interes en caso de nueva|`tipoGeo` tipo de punto de interes. 1: radial(circular), 2: poligonal|
|savePuntoInteres|Guarda lso datos de una puntos de interes nuevo|-|
|showCarsPuntoInteres|Obtiene si se encuentran carros a una distancia dada, si si collca lso marcadores de los vehiculos `nota: `La distancia minima es de 5 metros|-|
|cancelar|Cierra o abre el panel|-|

<!-- @vuese:FormularioPuntosInteres:methods:end -->


## Computed

<!-- @vuese:FormularioPuntosInteres:computed:start -->
|Computed|Type|Description|From Store|
|---|---|---|---|
|getAccion|-|Obtiene accion. puede ser: `nueva`, `editar`|No|
|getDataDrawing|-|Obtiene datos de geocerca y crea arreglos con la informacion correspondiente|No|
|getIDViewsCars|-|Obtiene id de carros|No|
|getDistanciaCars|-|Obtiene distacia da consultar carros|No|

<!-- @vuese:FormularioPuntosInteres:computed:end -->


## MixIns

<!-- @vuese:FormularioPuntosInteres:mixIns:start -->
|MixIn|
|---|
|API|

<!-- @vuese:FormularioPuntosInteres:mixIns:end -->


