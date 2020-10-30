# MapModule

## MixIns

<!-- @vuese:MapModule:mixIns:start -->
|MixIn|
|---|
|SecureStorage|
|API|

<!-- @vuese:MapModule:mixIns:end -->


ivo

## Events

<!-- @vuese:MapModule:events:start -->
|Event Name|Description|Parameters|
|---|---|---|
|MapModule_OpenInfowindowsDevices|} eventBus open Infowindows|-|
|MapModule_CloseInfowindowsDevices|eventBus close Infowindows|-|
|MapModule_OpenInfowindowsDevicesMovil|eventBus open Infowindows|-|

<!-- @vuese:MapModule:events:end -->


## Methods

<!-- @vuese:MapModule:methods:start -->
|Method|Description|Parameters|
|---|---|---|
|setZoomControl|Estable si se muestra o no el panel de control de zoom del mapa|-|
|onMapReady|Estable si ya se crgo correctamente el mapa y estable los estilos de vista del mismo|-|
|onWindowResize|Manda a llamar las funciones para calcular los tamaños de pantalla y componentes|-|
|resizeMap|Se obtiene el alto y ancho de pantalla total y se estable el tamaño y posicion del mapa|-|
|resizeMapManual|Se obtiene el alto y ancho del mapa|-|
|resizeStreetView|Se obtiene el alto y ancho del stret view|-|
|loadMarkers|Asigna y muestra el marcador del dipositivo correspondiente|-|
|suscribeToDeviceEvents|se suscribe a eventos eventBus para: `DEVICE_POSITION_CHANGED` Cuando cambia la posicion de un dipositivo `'SET_MARKER_ICON` Cambia el marcador de un dipositivo `'App_resizeMap` Cambia valores de tamaño del mapa|-|
|unsuscribreFromDeviceEvents|Se destruye la suscripcion al eventBus|-|
|getMap|Obtiene referencia a las propiedades del componenete mapa|-|
|onMarkerClick|Cuando da clic en un marcador manda a llamar a la funcon correspondiente para mostraar informacion del dispositivo|-|
|showDeviceInfo|Carga y muestra el infowindows con la informacion del dispositivo|-|
|closeDeviceInfo|Cierran infowindows|-|
|onMarkerInfoWindowsClose|Cierra infowindow|-|
|showDeviceInfoMovil|Carga y muestra el infowindows con la informacion del dispositivo version movil|-|
|onCloseStreetView|Cierran street view|-|
|onShowStreetView|Cierra infowindows y abre stree view de dispositivo|-|
|onDevicesSelected|recibe dispositivos seleccionado y abre infowindows o muestra marcadores segun sea le caso|`payload` Arreglo de dispositivos|

<!-- @vuese:MapModule:methods:end -->


