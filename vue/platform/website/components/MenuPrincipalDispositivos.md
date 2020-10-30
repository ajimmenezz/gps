# MenuPrincipalDispositivos

pantalla principal, con el panel para resetear, crear contraseña de eventos y editar dispositivo

## Methods

<!-- @vuese:MenuPrincipalDispositivos:methods:start -->
|Method|Description|Parameters|
|---|---|---|
|passwordExist|PanelContraseña: verifica si ya ha creado contraseña|-|
|passwordExpired|PanelContraseña: verifica si la cantraseña se encuentra vigente|-|
|funResetea|panelContraseña: restablece los valores|-|
|saveEventPassword|PanelContraseña: hace la llamada api y guarda la contraseña ingresada|-|
|ValidatePasswordParo|PanelContraseña: valida que las contraselas seas igual, y cumplan con 6 digitos y solo números|`passw`, `compass` contraseñas introducidas|
|cancelar|cancela el proceso|-|
|showPoliciesPanel|PanelContraseña: abre modal con la información de las politicas de contraseña|-|

<!-- @vuese:MenuPrincipalDispositivos:methods:end -->


## MixIns

<!-- @vuese:MenuPrincipalDispositivos:mixIns:start -->
|MixIn|
|---|
|ValidateVariables|
|API|

<!-- @vuese:MenuPrincipalDispositivos:mixIns:end -->


