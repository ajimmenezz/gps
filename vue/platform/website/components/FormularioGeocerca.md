# FormularioGeocerca

Formulario de crear, editar y consultar geocercas

## Props

<!-- @vuese:FormularioGeocerca:props:start -->
|Name|Description|Type|Required|Default|
|---|---|---|---|---|
|geofenceID|-|—|`false`|-|
|accion|-|—|`false`|-|
|dataDrawing|-|—|`false`|-|

<!-- @vuese:FormularioGeocerca:props:end -->


## Events

<!-- @vuese:FormularioGeocerca:events:start -->
|Event Name|Description|Parameters|
|---|---|---|
|showAllDrawing|-|booleano oculta dibujos de mapa|
|setRadiusCircle|-|-|
|DrawingGeocerca|-|-|
|onClose|manda a cerrar o abrir el panel|-|

<!-- @vuese:FormularioGeocerca:events:end -->


## Methods

<!-- @vuese:FormularioGeocerca:methods:start -->
|Method|Description|Parameters|
|---|---|---|
|limparAll|Limpia variables|-|
|showAllDrawingGeo|Oculta dibujos de geocerca en mapa|-|
|limpiarDatos|Limpia variables|-|
|getRadioGeofence|Modifica el radio de geocerca|`value` radio de geocerca|
|tipo|Manda a dibujar la geocerca en caso de nueva|`tipoGeo` tipo de geocerca. 1: radial(circular), 2: poligonal|
|saveGeofence|Guarda lso datos de una geocerca nueva|-|
|cancelFormGeofence|Cierra o abre el panel|-|
|configuracion|Abre el modal de configuracion de geocerca|-|

<!-- @vuese:FormularioGeocerca:methods:end -->


## Computed

<!-- @vuese:FormularioGeocerca:computed:start -->
|Computed|Type|Description|From Store|
|---|---|---|---|
|showTipoGeocerca|-|Obtiene tipo de geocerca|No|
|tipoAccion|-|Obtiene accion. puede ser: `nueva`, `editar`|No|
|getDataDrawing|-|Obtiene datos de geocerca y crea arreglos con la informacion correspondiente|No|

<!-- @vuese:FormularioGeocerca:computed:end -->


## MixIns

<!-- @vuese:FormularioGeocerca:mixIns:start -->
|MixIn|
|---|
|API|

<!-- @vuese:FormularioGeocerca:mixIns:end -->


