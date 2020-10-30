# panelDispositivos

Panel de lista de dispositivos creados

## Events

<!-- @vuese:panelDispositivos:events:start -->
|Event Name|Description|Parameters|
|---|---|---|
|lockDraggable|-|-|
|onClose|manda a cerrar o abrir el panel|-|

<!-- @vuese:panelDispositivos:events:end -->


## Methods

<!-- @vuese:panelDispositivos:methods:start -->
|Method|Description|Parameters|
|---|---|---|
|CrearArregloFiltered|Crea arreglo con los dispositivos en relacion con su respectiva flotilla|-|
|filterLista|Obtiene resultados de coincidencias del string con lista de dispsitivos|`searchTerm` String de filtro|
|suscribeToDeviceEvents|TODO: evenbus se suscribe a eventos eventBus para: `MapModule_CloseInfowindowsDevices` Cerrar infowindows `MapModule_OpenInfowindowsDevices` Abrir infowindows `Ws_LOCATE_SELECT` Inidcador dispositivo localizado|-|
|unsuscribreFromDeviceEvents|Se destruye la suscripcion al eventBus|-|
|onMapClick|Obtiene latitud y longitud de donde se dio click|`position` posicion de puntero|
|centerMap|Centra mapa en la posicion indicada|-|
|showDraggable|Abre paneles secundarios segun sea el caso|-|
|onDraggableClose|Cierran paneles secundarios|-|
|lockDraggable|Bloquea/Desbloquea paneles secundarios|`lock` booleano indicativo|
|intervalLocationStatus|TODO: LOCATION STATUS Ejecuta la funcion `locationsStatusDevices` cada minuto|-|
|locationsStatusDevices|verifica y establece el estatus de dispositivos si se encuentran: `localizado o sin localizar` `nota:` Se tiene una tolerancia de 3 intentos de acuerdo al tiempo de reporte que tenga el dispositivo, si no reporta en ese tiempo se marca como no localizado.|-|
|clearDevices|TODO: metodos list devices Limpia valores y store de dispositivos|-|
|countSelectedDEvices|Devuelve arreglo con dispositivos seleccionados|-|
|getFleets|Obtiene lista de flotillas y crea arreglo con sus respectivos indicadores de estatus e iconos colapsados|-|
|localizar|Manda a localizar dispositivo mediente webSocket|-|
|localizar_lista|Manda a localizar dispositivo mediente webSocket masivamente|-|
|showAllMarkers|Muestra todos los marcadores|-|
|closeAllInfoWindow|Manda a cerrar infowindows|-|
|onDeviceSelected|Seleccion un dispositivo, cambia el estatus del ckeckbox y manda a mostrar el infowindows (si es 1) o mostrar marcadores (si es mas de 1) segun sea el caso|-|
|onClose|Cierra o abre el panel|-|
|onDeviceChecked|Selecciona/des selecciona un dispositivo|`e` Status del ckeckBox `deviceID` Id de dispositivo `deviceImei` Imei de dispositivo|
|onFleetChecked|Selecciona/des selecciona flotilla con sus respectivos dispositivos|`e` Status de checkBox `fleerID` Id de la flotilla|
|fleetDevicesChecked|Crea arreglo de flotillas con su estatus de cuantos dispositivos tiene|-|
|ChangeCheckDecvices|Cambia indocadores de checkBox segun sea el caso y si el total de dispostivos de ujna flotilla selecciona le checkBox de flotilla y dispostivos, de lo contrario la des selecciona|-|
|checkDeviceSelected|Selecciona/des selecciona dispoaitivo manualmente|-|
|deviceParoMotor|Abre modal para realizar paro de motor a una unidad|-|
|setIconCollapse|Cambia el indicador de icono collapsado segun sea el caso|-|
|openInfowindowsDevices|Abre infowindows de dispostivo y lo selecciona|-|
|closeInfowindows|Cierra infowindows de dispostivo y lo des selecciona|-|
|recorrido|Abre panel para generar recorrido|-|
|TooglUbicados|Muestra los dispositivo ubicados o todos segun sea el caso|-|
|ToogleSinUbicados|Muestra los dispositivo sin ubicar o todos segun sea el caso|-|
|deviceEventBotton|Procesa y obtiene arreglo con dispositivo ubicados o sin ubicar|-|

<!-- @vuese:panelDispositivos:methods:end -->


## Computed

<!-- @vuese:panelDispositivos:computed:start -->
|Computed|Type|Description|From Store|
|---|---|---|---|
|deviceList2|-|Obtiene lista de disitivos final procesado a mostrar|No|
|fleetsList|-|Obtiene lista de flotillas a mostrar|No|
|permission_paroMotor|-|Obtiene si tiene permiso para realizar paro de motor|No|
|deviceSelected|-|Devuelve si el dispostivo esta seleccionado o no|No|

<!-- @vuese:panelDispositivos:computed:end -->


## MixIns

<!-- @vuese:panelDispositivos:mixIns:start -->
|MixIn|
|---|
|Functions|
|API|

<!-- @vuese:panelDispositivos:mixIns:end -->


