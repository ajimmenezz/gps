# tablaUsuarios

Tabla de usuarios

## Methods

<!-- @vuese:tablaUsuarios:methods:start -->
|Method|Description|Parameters|
|---|---|---|
|flistaUsers|Obtiene la lista de usuarios|-|
|editar|Obtiene la informacion del usuario a consultar|`id` Id de usuario|
|eliminar|Abre el modal de confirmacion para eliminar el usuario|`id` Id de usuario `name` nombre de usuario|
|cancel|cancela el proceso y regresa una pagina anterior|-|
|suscribeToDeviceEvents|se suscribe a eventos eventBus para actulizar el listado de usuarios|-|
|unsuscribreToDeviceEvents|Se destruye la suscripcion al eventBus|-|

<!-- @vuese:tablaUsuarios:methods:end -->


## Computed

<!-- @vuese:tablaUsuarios:computed:start -->
|Computed|Type|Description|From Store|
|---|---|---|---|
|getUserList|-|obtiene el listado de los usuarios a mostrar|No|

<!-- @vuese:tablaUsuarios:computed:end -->


## MixIns

<!-- @vuese:tablaUsuarios:mixIns:start -->
|MixIn|
|---|
|API|

<!-- @vuese:tablaUsuarios:mixIns:end -->


