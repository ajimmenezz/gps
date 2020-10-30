# InfowindowsInfoDispositivo

Paneles y formularios para geenerar y mostrar el recorrido del dia en curso de una unidad.

## Props

<!-- @vuese:InfowindowsInfoDispositivo:props:start -->
|Name|Description|Type|Required|Default|
|---|---|---|---|---|
|deviceID|id de dispoaitivo|—|`true`|-|

<!-- @vuese:InfowindowsInfoDispositivo:props:end -->


## Events

<!-- @vuese:InfowindowsInfoDispositivo:events:start -->
|Event Name|Description|Parameters|
|---|---|---|
|lockDraggable|-|-|

<!-- @vuese:InfowindowsInfoDispositivo:events:end -->


## Methods

<!-- @vuese:InfowindowsInfoDispositivo:methods:start -->
|Method|Description|Parameters|
|---|---|---|
|lockDraggable|Bloquea los paneles principales cuando se abre panel de formularios|-|
|onTimeStartChanged|Obtiene la fecha inicio|-|
|onTimeEndChanged|Obtiene la fecha final|-|
|getRoute|Obtiene toda la informacion del reporte-recorrido a consultar en un rango de fechas|-|
|close|Cierra el panel de recorrido y actualiza la lista de dispositivo|-|
|drawLines|Dibuja lineas con google maps el resultado del recorrido de la unidad para mostrarlo en el mapa|-|
|onViewRoute|hace zoom y resalta ese trazo de recorrido o detenido de la unidad.|-|
|boundsRoute|Centra el mapa en el trazo y resultados obtenidos|-|
|clearPolylines|Limpia el recorrido visualizado|-|
|clearMarkers|Limpia los marcadores de representacion de recorrido|-|
|playAnimationRoute|#AnimationRoute Inicia animacion simulando el recorrido|-|
|stopAnimationRoute|Detiene la animacion de recorrido en curso|-|
|setSpeedAnimationRoute|Cambia la velocidad con la que se anima la representacion de recorrido|`speed` milisegundas acttual de velocidad de animacion|
|AnimateRoute|Procesa el arreglo de recorrido creado, para generar recorrido y  mostrarlo en mapa, con marcadores.|-|
|setPositionsItemRoute|Crea item para cada punto del arreglo y hacer referencia a ellos y manupularlos|-|
|scrollTo|genera interactividad entre el recorrido y la tabla del listado de puntos.|`index` item del arreglo|
|onMarkerAnimationPositionChanged|muestra y centra marcador|`id` Id del marcador `Position` Posicion del marcador|
|setAnimationRouteButtons|muestra iconoces de animacion para el recorrido|`play` Play de recorrido `stop` Stop de recorrido `speend` Velocidad del recorrido|

<!-- @vuese:InfowindowsInfoDispositivo:methods:end -->


## MixIns

<!-- @vuese:InfowindowsInfoDispositivo:mixIns:start -->
|MixIn|
|---|
|API|

<!-- @vuese:InfowindowsInfoDispositivo:mixIns:end -->


## Watch

<!-- @vuese:InfowindowsInfoDispositivo:watch:start -->
|Name|Description|Parameters|
|---|---|---|
|reportsReady|Si se obtuvieron resulados de recorrido|`value` Valor booleano|

<!-- @vuese:InfowindowsInfoDispositivo:watch:end -->


