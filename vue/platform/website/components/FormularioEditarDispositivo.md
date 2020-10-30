# FormularioEditarDispositivo

formulario para editar datos de un dispositivo y tiempos de reporte

## Events

<!-- @vuese:FormularioEditarDispositivo:events:start -->
|Event Name|Description|Parameters|
|---|---|---|
|SET_MARKER_ICON|-|-|

<!-- @vuese:FormularioEditarDispositivo:events:end -->


## Methods

<!-- @vuese:FormularioEditarDispositivo:methods:start -->
|Method|Description|Parameters|
|---|---|---|
|getFleets|obtiene las flotillas|-|
|getMarkers|obtiene catalogo de marcadores|-|
|getDevice|obtiene toda informacion del dispositivo a consultar|-|
|cancel|cancela el proceso y regresa una pagina anterior|-|
|editar|Guarda la informacion del dipositivo modificada, asi como cambia el tiempo de reporte en detenido/movimiento (el dispositivo necesita estar conectado a la plataforma)|-|
|WS_INTEVAL_REPORT|Llamada al webSocket para cambiar los tiempos de reporte del dispositivo|`interval` Tiempo en movimiento (en segundos) `intervalParking` Tiempo en detenido (en segundos) `imeiDevice` Imei del dispostivo|

<!-- @vuese:FormularioEditarDispositivo:methods:end -->


## MixIns

<!-- @vuese:FormularioEditarDispositivo:mixIns:start -->
|MixIn|
|---|
|API|

<!-- @vuese:FormularioEditarDispositivo:mixIns:end -->


