# menuFlotanteLocalizacionMovil

Panel menu flotante localización movil

## Methods

<!-- @vuese:menuFlotanteLocalizacionMovil:methods:start -->
|Method|Description|Parameters|
|---|---|---|
|onWindowResize|Manda a llamar la funcion para calcular los tamaños de pantalla|-|
|resizeDraggable|Se obtiene el alto y ancho de pantalla total y se estable la posicion del menu para panel de dispositivos.|-|
|suscribeToDeviceEvents|TODO: evenbus se suscribe a eventos eventBus para: `MapModule_OpenInfowindowsDevicesMovil` Abre infowindows de un dispositivo `'Ws_LOCATE_SELECT_movil` Inidcador dispositivo localizado|-|
|unsuscribreFromDeviceEvents|Se destruye la suscripcion al eventBus|-|
|getDraggableProperties|Obtiene los valores de las propiedades del componente padre|-|
|getDraggablePropertiesDeviceInfo|Obtiene los valores de las propiedades de dispositivo del componente padre|-|
|loadListDevicesComponent|Llena y muestra el componente de panel de listado de dispositivos|-|
|loadDynamicComponent|Asigna los valores de las variables del componente dinamico a mostrar|-|
|clearComponentsDinamic|Limpia las variables del componenete dinamico|-|
|openInfowindowsDevicesMovil|Centra el mapa y coloca marcador en la posicion del dispositivo a consultar asi como abre infowindows del mismo|-|
|openDeviceDataInfo|Llena y muestra el componente de infowindows de dispositivo|-|

<!-- @vuese:menuFlotanteLocalizacionMovil:methods:end -->


