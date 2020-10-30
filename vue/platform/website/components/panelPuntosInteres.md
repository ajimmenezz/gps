# panelPuntosInteres

Panel de punto de interes

## Events

<!-- @vuese:panelPuntosInteres:events:start -->
|Event Name|Description|Parameters|
|---|---|---|
|lockDraggable|-|-|

<!-- @vuese:panelPuntosInteres:events:end -->


## Methods

<!-- @vuese:panelPuntosInteres:methods:start -->
|Method|Description|Parameters|
|---|---|---|
|limpiarVariables|limpia variables|-|
|filterLista|Obtiene resultados de coincidencias del string con lista de puntos de interes|`searchTerm` String de filtro|
|suscribeToGeofencesEvents|TODO: evenbus se suscribe a eventos eventBus para: `Modal_GET_LIST_GEOFENCES` obtiene lista de puntos de interes `MapModule_editDataDrawing` editar dibujo poligonal|-|
|unsuscribreFromGeofencesEvents|Se destruye la suscripcion al eventBus|-|
|getlistGeofence|Obtiene listado de puntos de interes|-|
|showNewPuntoInteres|Abre paneles secundarios segun sea el caso|-|
|DrawingGeocerca|Manda a activar el dibujo de puntos de interes en caso de nueva|`payload` Datos de puntos de interes|
|onMapClickCreatePunto|Manda a dibujar puntos de interes en caso de nueva, cuando da click en mapa|`position` latitud y longitud de donde se pintara el punto de interes|
|setRadiusCircleGeo|Modifica el radio de putos de interes|`datos` radio de putos de interes|
|unSelectedPuntos|Deselecciona los puntos de interes|-|
|onGeofenceChecked|Selecciona/deselecciona punto de interes|`e` Valor ingresado por checkBox `id` Id punto de interes `opc` 1:valor ingresado por checkBox, 2:valor ingresado manual. Valor por defecto: 1|
|consultarGeofences|crea punto de interes, para cuando ya esta creada|`payload` datos punto de interes|
|showAllDrawingGeo|muestra/oculta punto de interes|`visible` Booleano true/false `tipo` geocerca o punto de interes|
|editarPuntoInteres|Obtiene datos de punto de interes a editar|`PuntoInteresID` Id de punto de interes|
|editPuntoInteres|Dibuja punto de interes y manda datos a formulario de editar|`payload` datos punto de interes|
|editDataDrawing|Actualiza arreglo con los nuevos datos de la punto de interes dibujada y modificada|`payload` datos de punto de interes|
|verCarPuntoInteres|guarda id de punto y manda a mostrar panel|`id` id de punto de interes|
|verCarrosPuntoInteres|Manda datos a formulario de editar|`payload` datos de punto de interes|
|onDevicesSelectedPoi|muestra marcadores cerca de punto de interes|`payload` datos de punto|
|eliminarPuntoInteres|Abre el modal de confirmacion para eliminar el punto de interes|`id` Id de punto de interes `name` nombre de punto de interes|
|onDraggableClose|Cierran paneles secundarios|-|
|lockDraggable|Bloquea/Desbloquea paneles secundarios|`lock` booleano indicativo|
|clearComponentsForm|Limpiar paneles y variables de paneles|-|

<!-- @vuese:panelPuntosInteres:methods:end -->


## Computed

<!-- @vuese:panelPuntosInteres:computed:start -->
|Computed|Type|Description|From Store|
|---|---|---|---|
|fPuntosIList|-|Obtiene lista de puntos de interes|No|
|faccion|-|Obtiene accion. puede ser: `nueva`, `editar`|No|
|fseccion|-|Obtiene seccion. puede ser: `puntoInteres`, `puntoInteresCarros`|No|
|fidPuntoCars|-|Obtiene id de carros|No|
|fdataGeocerca|-|Obtiene datos de punto de interes|No|

<!-- @vuese:panelPuntosInteres:computed:end -->


## MixIns

<!-- @vuese:panelPuntosInteres:mixIns:start -->
|MixIn|
|---|
|API|
|Functions|
|mapModuleDrawing|

<!-- @vuese:panelPuntosInteres:mixIns:end -->


