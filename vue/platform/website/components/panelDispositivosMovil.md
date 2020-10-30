# panelDispositivosMovil

Panel de lista de dispositivos creados

## Events

<!-- @vuese:panelDispositivosMovil:events:start -->
|Event Name|Description|Parameters|
|---|---|---|
|lockDraggable|-|-|
|closeList|manda a cerrar el panel|-|

<!-- @vuese:panelDispositivosMovil:events:end -->


## Methods

<!-- @vuese:panelDispositivosMovil:methods:start -->
|Method|Description|Parameters|
|---|---|---|
|onWindowResize|Manda a llamar la funcion para calcular los tamaños de pantalla|-|
|resizeDraggable|Se obtiene el alto y ancho de pantalla total y se estable el tamaño y posicion del panel de dispositivos restandole los valores de head y footer para establecer el scroll del contenido|-|
|CrearArregloFiltered|Crea arreglo con los dispositivos en relacion con su respectiva flotilla|-|
|filterLista|Obtiene resultados de coincidencias del string con lista de dispsitivos|`searchTerm` String de filtro|
|onMapClick|Obtiene latitud y longitud de donde se dio click|`position` posicion de puntero|
|centerMap|Centra mapa en la posicion indicada|-|
|lockDraggable|Bloquea/Desbloquea paneles secundarios|`lock` booleano indicativo|
|closeList|Cierra el panel|-|
|intervalLocationStatus|TODO: LOCATION STATUS Ejecuta la funcion `locationsStatusDevices` cada minuto|-|
|locationsStatusDevices|verifica y establece el estatus de dispositivos si se encuentran: `localizado o sin localizar` `nota:` Se tiene una tolerancia de 3 intentos de acuerdo al tiempo de reporte que tenga el dispositivo, si no reporta en ese tiempo se marca como no localizado.|-|
|clearDevices|TODO: metodos list devices Limpia valores y store de dispositivos|-|
|getFleets|Obtiene lista de flotillas y crea arreglo con sus respectivos indicadores de estatus e iconos colapsados|-|
|onDeviceSelected|Seleccion un dispositivo, cambia el estatus del ckeckbox y manda a mostrar el infowindows (si es 1) o mostrar marcadores (si es mas de 1) segun sea el caso|-|
|setIconCollapse|Cambia el indicador de icono collapsado segun sea el caso|-|
|TooglUbicados|Muestra los dispositivo ubicados o todos segun sea el caso|-|
|ToogleSinUbicados|Muestra los dispositivo sin ubicar o todos segun sea el caso|-|
|deviceEventBotton|Procesa y obtiene arreglo con dispositivo ubicados o sin ubicar|-|

<!-- @vuese:panelDispositivosMovil:methods:end -->


## Computed

<!-- @vuese:panelDispositivosMovil:computed:start -->
|Computed|Type|Description|From Store|
|---|---|---|---|
|deviceList2|-|Obtiene lista de disitivos final procesado a mostrar|No|
|fleetsList|-|Obtiene lista de flotillas a mostrar|No|
|permission_paroMotor|-|Obtiene si tiene permiso para realizar paro de motor|No|
|deviceSelected|-|Devuelve si el dispostivo esta seleccionado o no|No|
|isMovileOrTable|-|Devuelve si estamos en un dipositivo movil o tablet|Yes|

<!-- @vuese:panelDispositivosMovil:computed:end -->


## MixIns

<!-- @vuese:panelDispositivosMovil:mixIns:start -->
|MixIn|
|---|
|Functions|
|API|

<!-- @vuese:panelDispositivosMovil:mixIns:end -->


