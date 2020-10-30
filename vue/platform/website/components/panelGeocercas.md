# panelGeocercas

Panel de geocercas

## Events

<!-- @vuese:panelGeocercas:events:start -->
|Event Name|Description|Parameters|
|---|---|---|
|lockDraggable|-|-|

<!-- @vuese:panelGeocercas:events:end -->


## Methods

<!-- @vuese:panelGeocercas:methods:start -->
|Method|Description|Parameters|
|---|---|---|
|limpiarVariables|limpia variables|-|
|filterLista|Obtiene resultados de coincidencias del string con lista de geocercas|`searchTerm` String de filtro|
|suscribeToGeofencesEvents|TODO: evenbus se suscribe a eventos eventBus para: `MapModule_editDataDrawing` editar dibujo circular `MapModule_editDataDrawingPolygon` editar dibujo poligonal `Modal_GET_LIST_GEOFENCES` mostrar listado de geocercas|-|
|unsuscribreFromGeofencesEvents|Se destruye la suscripcion al eventBus|-|
|getlistGeofence|Obtiene listado de geocercas|-|
|showNewGeofence|Abre paneles secundarios segun sea el caso|-|
|DrawingGeocerca|Manda a activar el dibujo de geocerca en caso de nueva|`payload` Datos de geocerca|
|setRadiusCircleGeo|Modifica el radio de geocerca|`datos` radio de geocerca|
|unSelectedGeofences|Deselecciona las geocercas|-|
|onGeofenceChecked|Selecciona/deselecciona geocerca|`e` Valor ingresado por checkBox `id` Id geocerca `opc` 1:valor ingresado por checkBox, 2:valor ingresado manual. Valor por defecto: 1|
|consultarGeofences|crea geocerca poligonal o circular, para cuando ya esta creada|`payload` datos geocerca|
|showAllDrawingGeo|muestra/oculta geocercas|`visible` Booleano true/false `tipo` geocerca o punto de interes|
|editarGeofence|Obtiene datos de geocerca a editar|`id` Id geocerca|
|editGeofence|Dibuja geocerca y manda datos a formulario de editar|`payload` datos geocerca|
|editDataDrawing|Actualiza arreglo con los nuevos datos de la geocerca dibujada y modificada|`payload` datos de geocerca|
|editDataDrawingPolygon|Actualiza arreglo con los nuevos datos de la geocerca poligonal dibujada y modificada|`payload` datos de geocerca|
|onDraggableClose|Cierran paneles secundarios|-|
|lockDraggable|Bloquea/Desbloquea paneles secundarios|`lock` booleano indicativo|
|eliminarGeofence|Abre el modal de confirmacion para eliminar el geocerca|`id` Id de geocerca `name` nombre de geocerca|
|clearComponentsForm|Limpiar paneles y variables de paneles|-|

<!-- @vuese:panelGeocercas:methods:end -->


## Computed

<!-- @vuese:panelGeocercas:computed:start -->
|Computed|Type|Description|From Store|
|---|---|---|---|
|GeofenceList|-|Obtiene lista de geocercas|No|
|fgeofenceID|-|Obtiene id de geocerca|No|
|faccion|-|Obtiene accion. puede ser: `nueva`, `editar`|No|
|fdataGeocerca|-|Obtiene datos de geocerca|No|

<!-- @vuese:panelGeocercas:computed:end -->


## MixIns

<!-- @vuese:panelGeocercas:mixIns:start -->
|MixIn|
|---|
|API|
|Functions|
|mapModuleDrawing|

<!-- @vuese:panelGeocercas:mixIns:end -->


