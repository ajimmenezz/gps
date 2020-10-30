# google-maps

componente google maps

## Props

<!-- @vuese:google-maps:props:start -->
|Name|Description|Type|Required|Default|
|---|---|---|---|---|
|name|nombre|`String`|`true`|-|
|lat|latitud|`Number`|`false`|-|
|lng|longitud|`Number`|`false`|-|
|zoom|zoom mapa|`Number`|`false`|5|
|height|alto de mapa|`Number`|`false`|600|
|width|ancho de mapa|`Number`|`false`|600|
|top|top|`Number`|`false`|-|
|left|derecha|`Number`|`false`|-|
|zoomControl|panel de zoom de mapa|`Boolean`|`false`|-|
|streetViewControl|panel de stree view|`Boolean`|`false`|-|
|fullScreenControl|panel de pantalla completa|`Boolean`|`false`|-|
|rotateControl|panel de rotacion|`Boolean`|`false`|-|
|scaleControl|control de escala|`Boolean`|`false`|-|
|mapTypeControl|tipo de mapa|`Boolean`|`false`|-|
|trafficControl|panel de trafico de mapa|`Boolean`|`false`|-|
|clusters|clusters|`Boolean`|`false`|-|
|clustersMaxZoom|maximo zoom de clusters|`Number`|`false`|15|
|clustersZoomOnClick|control de zoom en clusters|`Boolean`|`false`|-|
|followDevice|seguir dispositivo|`String`|`false`|-|

<!-- @vuese:google-maps:props:end -->


## Events

<!-- @vuese:google-maps:events:start -->
|Event Name|Description|Parameters|
|---|---|---|
|onMapReady|-|-|
|onMarkerInfoWindowsClose|-|-|
|onMapClick|-|-|
|onMapZoomChanged|-|-|
|onMarkerClick|-|-|
|onMarkerPositionChanged|-|-|
|onMarkerAnimationPositionChanged|-|-|
|onMarkerEndAnimationPositionChanged|console.debug(`google-map/ onMarkerEndAnimationPositionChanged ${id}`, position)|-|
|editDrawingCircle|-|-|
|completeDrawing|-|-|
|completeDrawingPlygon|-|-|
|completeRuta|-|-|
|dataCreateRuta|-|-|
|editDrawingPolygon|-|-|

<!-- @vuese:google-maps:events:end -->


## Methods

<!-- @vuese:google-maps:methods:start -->
|Method|Description|Parameters|
|---|---|---|
|extendsPolygonBounds|Obtiene puntos de poligono|-|
|extendsPolylineBounds|Obtiene puntos de polilinea|-|
|initializeMap|MAP METHODS Metodos para la manipulacion del mapa Inicializa librerias y mapa que ocupara|-|
|centerMap|Funcion que centra el mapa en una posicion dada|`lat` latitud `lng` longitud `zoom` zoom del mapa|
|centerMapToBounds|Funcion que centra el mapa en una posicion dada de puntos|`bounds` puntos a centrar en el mapa|
|setZoom|Funcion que establece zoom de mapa|`zoom` zoom de mapa|
|setMapStyle|Muestra u oculta los puntos de interes parametro feature puede ser alguno de las siguientes cadenas poi.attraction        selecciona atracciones turísticas. poi.business          selecciona negocios. poi.government        selecciona edificios gubernamentales. poi.medical           selecciona elementos relacionados con emergencias, (hospitales, farmacias, estaciones de policía y médicos, entre otros). poi.park              selecciona parques. poi.place_of_worship  selecciona lugares de culto religioso (iglesias, templos y mezquitas, entre otros). poi.school            selecciona escuelas. poi.sports_complex    selecciona complejos deportivos. Establece estilo del mapa|`feature` `visibility` visible|
|setAllMapStyle|Establece estilo del mapa|`styleArr`|
|addMarker|MARKER METHODS Metodos para la creacion y manipulacion de marcadores crea y muestra marcador en mapa|`id` id del marcador `lat` latitud `lng` longitud `markerType` tipo de marcador a mostrar `titulo` titulo de marcador, por defecto=null `infoWindowsConent`  contenedor de infowindows, por defecto=null|
|registerMarkerListeners|Se suscribe a los eventos del marcador|`id` id del marcador `marker` marcador|
|moveMarker|mueve un marcador|`id` id del marcador `lat` latitud `lng` longitud `animate` animacion, por defecto=false `duration` velocidad de aninacion, por defecto=10000|
|deleteMarker|elimina marcador|`id` id del marcador|
|setMarkerIcon|cambia imagen (icono) de marcador|`id` id del marcador `markerName` tipo de icono marcador|
|setMarkerTitle|Establece titulo a marcador|`id` id del marcador `title` titulo marcador|
|showMarkerInfoWindow|Muestra infowindows al marcador|`id` id del marcador|
|closeMarkerInfoWindow|Cierra infowindows de marcador|`id` id del marcador|
|closeAllMarkerInfoWindow|Cierra todos los infowindows|-|
|setMarkerInfoWindow|Establece el contenido de infowindows a marcador|`id` id del marcador `content` contenido de infowindows|
|animateMarker|Establece animacion a marcador|`id` id del marcador `timeout` tiempo de animacion, por defecto=3000|
|setMarkerVisible|Establece si es visible o no|`id` id del marcador `visibility` visibilidad de marcador|
|showAllMarkers|Muestra u oculta marcadores|`show` mostrar o no|
|getMarkersBounds|Obtiene los puntos de todos los marcadores|`arrID` arreglo de marcadores|
|setBoundsAllMarkers|Establece los puntos de todos los marcadores y centra mapa|-|
|initializeClusterManager|CLUSTER METHODS Metodos para la gestion de clusters Inicializa libreria para cluster|-|
|registerClusterListeners|Se suscribe a los eventos del cluster|-|
|addAllMarkersToCluster|Agrega todos los marcadores al cluster|-|
|addMarkerToCluster|Agrega un marcador al cluster|`marker`  marcador|
|removeMarkerFromCluster|Elimina marcador del cluster|`marker`  marcador|
|removeAllMarkersFromCluster|Elimina marcadores del cluster|-|
|getClusters|Obtiene cluster|-|
|redrawCluster|Dibuja cluster|-|
|onClusterClick|Eventos click cluster|-|
|addPolyline|POLYLINE METHODS Metodos para la creacion y manipulacion de lineas Elimina marcador del cluster|`positions`  arreglo de posiciones `id`  id de polilinea, por defecto='temp_simbol' `color`  color, por defecto=null `showArrows`  puntos, por defecto=false `arrowRepeat`  valor puntos `animate`  animacion, por defecto=false `opacity`  opacidad, por defecto=2 `weight`  grosor, por defecto=3|
|deletePolyline|Elimina polilinea|`id`  id polilinea|
|showAllPolyline|Muestra todas las polilineas|`visible`  visibilidad o no|
|animatePolyline|anima la polilinea|`line` polilinea|
|getPolylineBounds|Obtiene puntos de polilinea|`id`  id polilinea|
|setBoundsAllPolylines|Establece puntos de polilinea|-|
|onMarkerInfoWindowsClose|EVENT HANDLERS Metodos que menejan los eventos del mapa, marcadores, etc y que se encargan de emitir dichos eventos al componente padre Evento cuando cierra infowindows|`id`  id marcador|
|onMapClick|Evento click en mapa|`e`  evento|
|onMapZoomChanged|Evento zoom en mapa|`e`  evento|
|onMarkerClick|Evento click en marcador|`id`  id marcador|
|onMarkerPositionChanged|Evento cambia posicion de marcador|`id`  id marcador `marker`   marcador|
|onMarkerAnimationPositionChanged|Evento cambia posicion de marcador y animacion|`id`  id marcador `marker`   marcador|
|changed_circle|POLYLON, CIRCLE METHODS Metodos para la creacion y manipulacion de poligonos, circulos TODO: METODOS DEL CIRCLE Evento edita circulos|`id`  id circulo|
|getCircle|Evento obtiene datos circulo|`id`  id circulo|
|createCircle|Evento crea circulos|`id`  id circulo `lat`  latitud circulo `lng`  longitud circulo `radio`  radio  circulo `seccion`  seccion `color`  color circulo, por defecto='#77d2ff' (azul) `opacidad`  opacidad, por defecto=0.3 `border`  borde, por defecto=1 `centerOnMap`  centrar mapa en ciculo, por defecto=false|
|getCircleBounds|Obtiene puntos de circulo|`id`  id circulo|
|getCirclesBounds|Obtiene puntos de circulos|`arrID`  arreglo  circulos|
|setRadius|Establece radio de circulo|`id`  id circulo, por defecto='temp_simbol' `radio` radio|
|getRadius|Obtiene radio de circulo|`id`  id circulo, por defecto='temp_simbol'|
|registerListenerCircle|Se suscribe a eventos de circulo|`id`  id circulo `cicle` ciculo|
|initDrawing|TODO: METODOS COMPARTIDOS DRAWING y simbols Inicia libreria de dibujo|-|
|SetControlDrawingVisible|Establece si se muestra o no panel de control de dibujo|`state` valor|
|SetControlDrawingOptions|Establece opciones del panel de control de dibujo|`stateControl`  panel de control|
|deleteDrawing|Elimina dibujo|`id`  id circulo, por defecto='temp_simbol'|
|showAllDrawing|Muestra u oculta todos los dibujos|`visible`  visibilidad|
|DrawingMap|activa dibujo, para dibujar en mapa: `circulo`, `poligono`, `marcador`|`tipo` tipo de dibujo `radio` radio, por defecto=null `contRuta` contador ruta ,por defecto=null `color` color, por defecto='#77d2ff'(azul) `opacidad` opacidad, por defecto=0.3 `editable` por defeco=false `border` borde=1|
|drawingCircleComplete|Evento cuando se termina de dibujar circulo|`circle`  circulo|
|drawingPolygonComplete|Evento cuando se termina de dibujar un poligono|`polygon`  poligono|
|getPolygonBounds|Obtiene puntos de poligono|`id`  id poligono|
|saveDrawing|guarda en array dibujo|`id`  id dibujo, por defecto='temp_simbol'|
|setEditDrawing|Establece si es editable o no el dibujo|`id`  id dibujo `isEdit` editable o no|
|isVisibleDrawing|Establece si es visible o no el dibujo|`id`  id dibujo `visible` visible o no|
|setcolorDrawing|Establece color del dibujo|`id`  id dibujo `color` color|
|setBorderDrawing|Establece color y grosor del borde del dibujo|`id`  id dibujo `border` borde `color` color|
|setOpacityDrawing|Establece opacidad del dibujo|`id`  id dibujo `opacity` opacidad|
|deshabilitarDrawingMode|Deshabilita modo de dibujo|-|
|registerListenerDrawing|Se suscribe aeventos de dibujo|-|
|initDirections|TODO: METODOS DE RUTAS Inicia libreria de rutas|-|
|drawingRutasComplete|Evento cuando se acompleta la ruta|`id`  marcador|
|crearRuta|Evento para crear ruta|`origen`  origen `destino` destino `id` id, por defecto='temp_simbol'|
|getDataRuta|Evento para obtener datos de ruta|`response`  respuesta ruta|
|changed_ruta|Evento cuando modifica la ruta|`id`  ruta|
|setEditRuta|Establece si es editable o no la ruta|`id`  id ruta='temp_simbol' `isEdit` editable o no|
|registerListenerRuta|Se suscribe a eventos de ruta|`id`  id ruta `ruta` ruta|
|registerListenerPolygon|TODO: METODOS DE POLYGON Se suscribe a eventos de poligono|`id`  id poligono `polygon` poligono|
|mouseup|Evento cuando edita poligono|`id`  id poligono|
|createpolygon|Crea poligono|`id` id de poligono `positions` posicion `color` color, por defecto='#77d2ff'(azul) `opacidad` opacidad, por defecto=0.3 `border` borde=1|
|getPolygon|Obtiene poligono|`id` id de poligono|

<!-- @vuese:google-maps:methods:end -->


## Watch

<!-- @vuese:google-maps:watch:start -->
|Name|Description|Parameters|
|---|---|---|
|zoomControl|panel de zoom|-|
|streetViewControl|panel de street view|-|
|fullScreenControl|panel de pantalla completa|-|
|rotateControl|panel de rotacion|-|
|scaleControl|panel de escala|-|
|mapTypeControl|tipo de mapa|-|
|trafficControl|panel de trafico|-|
|clusters|mostrar cluster|-|
|clustersMaxZoom|zoom maximo de cluster|-|
|clustersZoomOnClick|control de zoom de cluster|-|

<!-- @vuese:google-maps:watch:end -->


