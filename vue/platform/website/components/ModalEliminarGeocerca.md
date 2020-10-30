# ModalEliminarGeocerca

Modal para eliminar geocercas

## Methods

<!-- @vuese:ModalEliminarGeocerca:methods:start -->
|Method|Description|Parameters|
|---|---|---|
|agregarDest|Agrega distinatario (correo electronicos) a la lista|-|
|eliminarDest|elimina destinatario|`id` Id de destinatario|
|guardarEdit|Actualiza informacion de geocerca: destinatarios, dipositivos, informacion|-|
|guardarNueva|Guarda informacion de geocerca nueva: destinatarios, dipositivos, informacion|-|
|registerEmailGeofence|Guarda correo de notificacion de geocerca|-|
|registerDevicesGeofence|Guarda dispoaitivo de notificacion de geocerca|-|
|getcorreos|Obtiene correos electronicos de geocerca|-|
|getdispositivosNew|Obtener lista de dipositivos cuando es geocerca nueva|-|
|getdispositivos|Obtener lista de dipositivos que tiene una geocerca|-|

<!-- @vuese:ModalEliminarGeocerca:methods:end -->


## Computed

<!-- @vuese:ModalEliminarGeocerca:computed:start -->
|Computed|Type|Description|From Store|
|---|---|---|---|
|getListEmail|-|Obtener lista de correos a mostrar|No|
|listDevices|-|Obtener lista de dipositivos a mostrar|No|

<!-- @vuese:ModalEliminarGeocerca:computed:end -->


## MixIns

<!-- @vuese:ModalEliminarGeocerca:mixIns:start -->
|MixIn|
|---|
|API|

<!-- @vuese:ModalEliminarGeocerca:mixIns:end -->


