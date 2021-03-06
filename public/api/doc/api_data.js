define({ "api": [
  {
    "type": "get",
    "url": "/store",
    "title": "Almacen",
    "name": "GetStore",
    "group": "Almacen",
    "description": "<p>Obtiene los productos del almacen</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": true,
            "field": "clientID",
            "description": "<p>ID del almacen del cliente <br><b>NOTA: </b> Si no se proporciona se utilizara el id del cliente proporcionado por el token</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": true,
            "field": "id",
            "description": "<p>Imei|Telefono|Serie|ID del producto</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": true,
            "field": "productType",
            "description": "<p>Tipo de producto</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": true,
            "field": "factory",
            "description": "<p>Marca del producto</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": true,
            "field": "model",
            "description": "<p>Modelo del producto</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": true,
            "field": "limit",
            "description": "<p>Numero de resultados por consulta (paginacion) <br><b>NOTA: </b>Si no se proporciona, se entregaran todos los registros que resulten de la consulta</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": true,
            "field": "paginationToken",
            "description": "<p>Token para cargar el siguiente bloque de resultados. <br><b>NOTA: </b>Si se proporciona este campo, cualquier otro parametro proporcionado en la consulta sera ignorado</p>"
          },
          {
            "group": "Parameter",
            "type": "boolean",
            "optional": true,
            "field": "onTransfers",
            "defaultValue": "true",
            "description": "<p>Determina si debe incluir en los resultados, productos que se encuentran actualmente en progreso de transferencia <br><b>NOTA: </b>Si no se proporciona este campo se tomara el valor por default</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Example 1:",
          "content": "/store?productType=2&factory=1&model=7&limit=4&ontransfers=false",
          "type": "json"
        },
        {
          "title": "Example 2:",
          "content": "/store?productType=2&factory=1&model=7&limit=4",
          "type": "json"
        },
        {
          "title": "Example 3:",
          "content": "/store?clientID=50&id=0004",
          "type": "json"
        },
        {
          "title": "Paginacion:",
          "content": "/store?paginationToken=Tzo4OiJzdGRDbGFzcyI6Nzp7czo4OiJjbGllbnRJRCI7czoxOiIyIjtzOjI6ImlkIjtOO3M6MTE6InByb2R1Y3RUeXBlIjtOO3M6NzoiZmFjdG9yeSI7TjtzOjU6Im1vZGVsIjtOO3M6NToibGltaXQiO3M6MToiMiI7czoxMDoicGFnaW5hdGlvbiI7aTo0O30=",
          "type": "json"
        }
      ]
    },
    "success": {
      "examples": [
        {
          "title": "Success-Example ",
          "content": "{\"success\":true,\"statusCode\":200,\"pagination\":{\"self\":\"Tzo4OiJzdGRDbGFzcyI6Nzp7czo4OiJjbGllbnRJRCI7czoxOiIyIjtzOjI6ImlkIjtOO3M6MTE6InByb2R1Y3RUeXBlIjtOO3M6NzoiZmFjdG9yeSI7TjtzOjU6Im1vZGVsIjtOO3M6NToibGltaXQiO3M6MToiNCI7czoxMDoicGFnaW5hdGlvbiI7aTowO30=\",\"next\":\"Tzo4OiJzdGRDbGFzcyI6Nzp7czo4OiJjbGllbnRJRCI7czoxOiIyIjtzOjI6ImlkIjtOO3M6MTE6InByb2R1Y3RUeXBlIjtOO3M6NzoiZmFjdG9yeSI7TjtzOjU6Im1vZGVsIjtOO3M6NToibGltaXQiO3M6MToiNCI7czoxMDoicGFnaW5hdGlvbiI7aTo0O30=\",\"prev\":\"\"},\"data\":{\"products\":[{\"id\":\"0004\",\"productTypeID\":\"1\",\"productType\":\"DISPOSITIVO GPS\",\"factoryID\":\"1\",\"factory\":\"DEMO\",\"modelID\":\"7\",\"model\":\"PRUEBAS\"},{\"id\":\"0005\",\"productTypeID\":\"1\",\"productType\":\"DISPOSITIVO GPS\",\"factoryID\":\"1\",\"factory\":\"DEMO\",\"modelID\":\"7\",\"model\":\"PRUEBAS\"},{\"id\":\"K5GDJSWE\",\"productTypeID\":\"3\",\"productType\":\"GENERICO\",\"factoryID\":\"4\",\"factory\":\"LOGITECH\",\"modelID\":\"8\",\"model\":\"LG58SX\"},{\"id\":\"KFHRDC\",\"productTypeID\":\"3\",\"productType\":\"GENERICO\",\"factoryID\":\"5\",\"factory\":\"TESLA\",\"modelID\":\"9\",\"model\":\"SF35\"}]}}",
          "type": "json"
        }
      ],
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "array",
            "optional": false,
            "field": "products",
            "description": "<p>Arreglo que contiene los resultados de la consulta.</p>"
          },
          {
            "group": "Success 200",
            "type": "object",
            "optional": false,
            "field": "product",
            "description": "<p>Objeto que contiene la informacion del producto</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "product.id",
            "description": "<p>ID|Imei|Telefono|Serie del producto</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "product.productTypeID",
            "description": "<p>Tipo de producto</p>"
          },
          {
            "group": "Success 200",
            "type": "string",
            "optional": false,
            "field": "product.productType",
            "description": "<p>Nombre del tipo de producto</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "product.factoryID",
            "description": "<p>Marca del producto</p>"
          },
          {
            "group": "Success 200",
            "type": "string",
            "optional": false,
            "field": "product.factory",
            "description": "<p>Nombre de la marca del producto</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "product.modelID",
            "description": "<p>Modelo del producto</p>"
          },
          {
            "group": "Success 200",
            "type": "string",
            "optional": false,
            "field": "product.model",
            "description": "<p>Nombre del modelo del producto.</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "apidoc/store.php",
    "groupTitle": "Almacen",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "string",
            "allowedValues": [
              "JsonWebToken"
            ],
            "optional": false,
            "field": "authorization",
            "description": "<p>Bearer Token requerido para la autorizacion</p>"
          }
        ]
      }
    }
  },
  {
    "type": "get",
    "url": "/store/summary",
    "title": "Resumen de Almacen",
    "name": "GetStoreSummary",
    "group": "Almacen",
    "description": "<p>Obtiene el resumen del almacen del cliente</p>",
    "success": {
      "examples": [
        {
          "title": "Success-Example ",
          "content": "{\"success\":true,\"statusCode\":200,\"pagination\":{\"self\":\"\",\"next\":\"\",\"prev\":\"\"},\"data\":{\"summary\":[{\"productTypeID\":\"1\",\"productType\":\"DISPOSITIVO GPS\",\"factoryID\":\"1\",\"factory\":\"DEMO\",\"modelID\":\"7\",\"model\":\"PRUEBAS\",\"quantity\":\"2\"},{\"productTypeID\":\"3\",\"productType\":\"GENERICO\",\"factoryID\":\"4\",\"factory\":\"LOGITECH\",\"modelID\":\"8\",\"model\":\"LG58SX\",\"quantity\":\"1\"},{\"productTypeID\":\"3\",\"productType\":\"GENERICO\",\"factoryID\":\"5\",\"factory\":\"TESLA\",\"modelID\":\"9\",\"model\":\"SF35\",\"quantity\":\"1\"},{\"productTypeID\":\"2\",\"productType\":\"SIM\",\"factoryID\":\"1\",\"factory\":\"TELCEL\",\"modelID\":null,\"model\":null,\"quantity\":\"1\"},{\"productTypeID\":\"2\",\"productType\":\"SIM\",\"factoryID\":\"2\",\"factory\":\"MOVISTAR (TELEFONICA)\",\"modelID\":null,\"model\":null,\"quantity\":\"1\"},{\"productTypeID\":\"2\",\"productType\":\"SIM\",\"factoryID\":\"3\",\"factory\":\"AT&T\",\"modelID\":null,\"model\":null,\"quantity\":\"1\"}]}}",
          "type": "json"
        }
      ],
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "array",
            "optional": false,
            "field": "summary",
            "description": "<p>Arreglo que los elmentos del resumen de productos del almacen</p>"
          },
          {
            "group": "Success 200",
            "type": "object",
            "optional": false,
            "field": "product",
            "description": "<p>Objeto que contiene la informacion del producto</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "product.productTypeID",
            "description": "<p>ID del tipo de producto</p>"
          },
          {
            "group": "Success 200",
            "type": "string",
            "optional": false,
            "field": "product.productType",
            "description": "<p>Nombre del tipo de producto</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "product.factoryID",
            "description": "<p>Id del la marca del producto</p>"
          },
          {
            "group": "Success 200",
            "type": "string",
            "optional": false,
            "field": "product.factory",
            "description": "<p>Nombre de la marca del producto</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "product.modelID",
            "description": "<p>ID del modelo del producto</p>"
          },
          {
            "group": "Success 200",
            "type": "string",
            "optional": false,
            "field": "product.model",
            "description": "<p>Nombre del modelo del producto</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "product.quantity",
            "description": "<p>Numero de elementos en el almacen de ese tipo de producto.</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "apidoc/store.php",
    "groupTitle": "Almacen",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "string",
            "allowedValues": [
              "JsonWebToken"
            ],
            "optional": false,
            "field": "authorization",
            "description": "<p>Bearer Token requerido para la autorizacion</p>"
          }
        ]
      }
    }
  },
  {
    "type": "get",
    "url": "/catalogs/markers",
    "title": "Marcadores",
    "name": "GetMarkers",
    "group": "Catalogos",
    "description": "<p>Obtiene el listado marcadores disponibles</p>",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Object[]",
            "optional": false,
            "field": "markers",
            "description": "<p>Arreglo que contiene objetos marcador</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "marker",
            "description": "<p>Objeto que contiene la informacion de un marcador</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "marker.id",
            "description": "<p>ID del marcador</p>"
          },
          {
            "group": "Success 200",
            "type": "string",
            "optional": false,
            "field": "marker.name",
            "description": "<p>Nombre del marcador</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Example ",
          "content": "{\"success\":true,\"statusCode\":200,\"pagination\":{\"self\":\"\",\"next\":\"\",\"prev\":\"\"},\"data\":{\"markers\":[{\"id\":\"3\",\"name\":\"CAR\"},{\"id\":\"1\",\"name\":\"DEFAULT\"},{\"id\":\"4\",\"name\":\"DIGGER\"},{\"id\":\"5\",\"name\":\"PICKUP\"},{\"id\":\"2\",\"name\":\"SMARTPHONE\"}]}}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "apidoc/catalogs.php",
    "groupTitle": "Catalogos",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "string",
            "allowedValues": [
              "JsonWebToken"
            ],
            "optional": false,
            "field": "authorization",
            "description": "<p>Bearer Token requerido para la autorizacion</p>"
          }
        ]
      }
    }
  },
  {
    "type": "get",
    "url": "/catalogs/products/factories",
    "title": "Marcas de producto",
    "name": "GetProductFactories",
    "group": "Catalogos",
    "description": "<p>Obtiene la lista de marcas de producto</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": true,
            "field": "productType",
            "description": "<p>Filtra el resultado de marcas por tipo de producto</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Example ",
          "content": "{\"success\":true,\"statusCode\":200,\"pagination\":{\"self\":\"\",\"next\":\"\",\"prev\":\"\"},\"data\":{\"factories\":[{\"id\":\"1\",\"name\":\"DEMO\",\"productType\":\"1\",\"productTypeName\":\"DISPOSITIVO GPS\"},{\"id\":\"4\",\"name\":\"LOGITECH\",\"productType\":\"3\",\"productTypeName\":\"GENERICO\"},{\"id\":\"3\",\"name\":\"SUNTECH\",\"productType\":\"1\",\"productTypeName\":\"DISPOSITIVO GPS\"}]}}",
          "type": "json"
        }
      ],
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "factories[]",
            "optional": false,
            "field": "factories",
            "description": "<p>Arreglo que contiene objectos Marca</p>"
          },
          {
            "group": "Success 200",
            "type": "factory",
            "optional": false,
            "field": "factory",
            "description": "<p>objecto que representa una marca</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "factory.id",
            "description": "<p>ID de la marca</p>"
          },
          {
            "group": "Success 200",
            "type": "string",
            "optional": false,
            "field": "factory.name",
            "description": "<p>Nombre de la marca</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "factory.productType",
            "description": "<p>Tipo de producto al que pertenece la marca</p>"
          },
          {
            "group": "Success 200",
            "type": "string",
            "optional": false,
            "field": "factory.productTypeName",
            "description": "<p>Nombre del tipo de producto al que pertenece la marca</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "apidoc/catalogs.php",
    "groupTitle": "Catalogos",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "string",
            "allowedValues": [
              "JsonWebToken"
            ],
            "optional": false,
            "field": "authorization",
            "description": "<p>Bearer Token requerido para la autorizacion</p>"
          }
        ]
      }
    }
  },
  {
    "type": "get",
    "url": "/catalogs/products/factories/:factoryID/models",
    "title": "Modelos de producto",
    "name": "GetProductModels",
    "group": "Catalogos",
    "description": "<p>Obtiene la lista de modelos de producto de una marca determinada</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "factoryID",
            "description": "<p>Marca a la que pertenecen los modelos que seran devueltos en el resultado</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Example ",
          "content": "{\"success\":true,\"statusCode\":200,\"pagination\":{\"self\":\"\",\"next\":\"\",\"prev\":\"\"},\"data\":{\"models\":[{\"id\":\"1\",\"name\":\"ST300\"},{\"id\":\"3\",\"name\":\"ST300K\"},{\"id\":\"6\",\"name\":\"ST600MD\"}]}}",
          "type": "json"
        }
      ],
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "factories[]",
            "optional": false,
            "field": "models",
            "description": "<p>Arreglo que contiene objectos Modelo</p>"
          },
          {
            "group": "Success 200",
            "type": "object",
            "optional": false,
            "field": "model",
            "description": "<p>objecto que representa un modelo</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "model.id",
            "description": "<p>ID del modelo</p>"
          },
          {
            "group": "Success 200",
            "type": "string",
            "optional": false,
            "field": "model.name",
            "description": "<p>Nombre del modelo</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "apidoc/catalogs.php",
    "groupTitle": "Catalogos",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "string",
            "allowedValues": [
              "JsonWebToken"
            ],
            "optional": false,
            "field": "authorization",
            "description": "<p>Bearer Token requerido para la autorizacion</p>"
          }
        ]
      }
    }
  },
  {
    "type": "get",
    "url": "/catalogs/timezones",
    "title": "Timezones",
    "name": "GetTimezones",
    "group": "Catalogos",
    "description": "<p>Obtiene el listado de zonas horarias</p>",
    "success": {
      "examples": [
        {
          "title": "Success-Example ",
          "content": "{\"success\":true,\"statusCode\":200,\"pagination\":{\"self\":\"\",\"next\":\"\",\"prev\":\"\"},\"data\":{\"timezones\":[{\"id\":\"2\",\"name\":\"(GMT-11:00) Samoa \",\"timezone\":\"Pacific/Samoa\"},{\"id\":\"1\",\"name\":\"(GMT-11:00) Midway Island \",\"timezone\":\"Pacific/Midway\"},{\"id\":\"3\",\"name\":\"(GMT-10:00) Hawaii \",\"timezone\":\"Pacific/Honolulu\"},{\"id\":\"4\",\"name\":\"(GMT-09:00) Alaska \",\"timezone\":\"America/Anchorage\"}]}}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "apidoc/catalogs.php",
    "groupTitle": "Catalogos",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "string",
            "allowedValues": [
              "JsonWebToken"
            ],
            "optional": false,
            "field": "authorization",
            "description": "<p>Bearer Token requerido para la autorizacion</p>"
          }
        ]
      }
    }
  },
  {
    "type": "delete",
    "url": "/accounts/contacts/:id",
    "title": "Eliminar contacto",
    "name": "DeleteContact",
    "group": "Clientes",
    "description": "<p>Elimina un contacto</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "id",
            "description": "<p>ID del contacto a eliminar</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "apidoc/accounts.php",
    "groupTitle": "Clientes",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "string",
            "allowedValues": [
              "JsonWebToken"
            ],
            "optional": false,
            "field": "authorization",
            "description": "<p>Bearer Token requerido para la autorizacion</p>"
          }
        ]
      }
    }
  },
  {
    "type": "get",
    "url": "/accounts/:id",
    "title": "Informacion del cliente",
    "name": "GetAccount",
    "group": "Clientes",
    "description": "<p>Obtiene informacion de una cuenta</p>",
    "version": "0.0.0",
    "filename": "apidoc/accounts.php",
    "groupTitle": "Clientes",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "id",
            "description": "<p>ID del cliente a consultar</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Example ",
          "content": "{\"success\":true,\"statusCode\":200,\"pagination\":{\"self\":\"\",\"next\":\"\",\"prev\":\"\"},\"data\":{\"customer\":{\"id\":\"3\",\"ownerID\":\"2\",\"clientTypeID\":\"1\",\"clientType\":\"CLIENTE\",\"account\":\"aviles\",\"creationTimestamp\":\"0\",\"legal\":{\"statusID\":\"1\",\"status\":\"NINGUNO\",\"name\":\"NOE AVILES\",\"country\":\"MEXICO\",\"region\":\"MORELOS\",\"zipCode\":\"62460\",\"note\":null,\"taxID\":null},\"contacts\":[{\"id\":\"3\",\"contactTypeID\":\"3\",\"contactType\":\"RESPONSABLE\",\"name\":\"Noe \",\"phone\":\"123456\",\"cel\":\"789456\",\"email\":\"naviles@globalgps.com.mx\",\"creationTimestamp\":\"1579043528\",\"notes\":null}]}}}",
          "type": "json"
        }
      ],
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "object",
            "optional": false,
            "field": "customer",
            "description": "<p>Objeto que contine la informacion del cliente</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "customer.id",
            "description": "<p>ID de la cuenta</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "customer.ownerID",
            "description": "<p>ID del propietario de la cuenta</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "customer.clientTypeID",
            "description": "<p>ID del tipo de cliente</p>"
          },
          {
            "group": "Success 200",
            "type": "string",
            "optional": false,
            "field": "customer.clientType",
            "description": "<p>Tipo de cliente</p>"
          },
          {
            "group": "Success 200",
            "type": "string",
            "optional": false,
            "field": "customer.account",
            "description": "<p>Nombre de la cuenta / cliente</p>"
          },
          {
            "group": "Success 200",
            "type": "long",
            "optional": false,
            "field": "customer.creationTimestamp",
            "description": "<p>Fecha de registro</p>"
          },
          {
            "group": "Success 200",
            "type": "object",
            "optional": false,
            "field": "legal",
            "description": "<p>Objeto que contiene la informacion legal y de facturacion</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "legal.statusID",
            "description": "<p>ID del estado legal</p>"
          },
          {
            "group": "Success 200",
            "type": "string",
            "optional": false,
            "field": "legal.status",
            "description": "<p>Estado legal (Persona Fisica, Moral o ninguno)</p>"
          },
          {
            "group": "Success 200",
            "type": "string",
            "optional": false,
            "field": "legal.name",
            "description": "<p>Nombre legal o Razon Social</p>"
          },
          {
            "group": "Success 200",
            "type": "string",
            "optional": false,
            "field": "legal.country",
            "description": "<p>Pais</p>"
          },
          {
            "group": "Success 200",
            "type": "string",
            "optional": false,
            "field": "legal.region",
            "description": "<p>Ciudad o region</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "legal.zipCode",
            "description": "<p>Codigo Postal</p>"
          },
          {
            "group": "Success 200",
            "type": "string",
            "optional": false,
            "field": "legal.notes",
            "description": "<p>Notas adicionales</p>"
          },
          {
            "group": "Success 200",
            "type": "string",
            "optional": false,
            "field": "customer.taxID",
            "description": "<p>RFC o ID legal</p>"
          },
          {
            "group": "Success 200",
            "type": "array",
            "optional": false,
            "field": "contacts",
            "description": "<p>Arreglo que contiene informacion de los contactos</p>"
          },
          {
            "group": "Success 200",
            "type": "object",
            "optional": false,
            "field": "contact",
            "description": "<p>Representa un contacto</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "contact.id",
            "description": "<p>ID del contacto</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "contact.contactTypeID",
            "description": "<p>ID del tipo de contacto</p>"
          },
          {
            "group": "Success 200",
            "type": "string",
            "optional": false,
            "field": "contact.contactType",
            "description": "<p>Tipo de contacto</p>"
          },
          {
            "group": "Success 200",
            "type": "string",
            "optional": false,
            "field": "contact.name",
            "description": "<p>Nombre del contacto</p>"
          },
          {
            "group": "Success 200",
            "type": "string",
            "optional": false,
            "field": "contact.phone",
            "description": "<p>Numero de telefono del contacto</p>"
          },
          {
            "group": "Success 200",
            "type": "string",
            "optional": false,
            "field": "contact.cel",
            "description": "<p>Numero celular del contacto</p>"
          },
          {
            "group": "Success 200",
            "type": "string",
            "optional": false,
            "field": "contact.email",
            "description": "<p>Correo electronico del contacto</p>"
          },
          {
            "group": "Success 200",
            "type": "string",
            "optional": false,
            "field": "contact.creationTimestamp",
            "description": "<p>Fecha de registro del contacto</p>"
          },
          {
            "group": "Success 200",
            "type": "string",
            "optional": false,
            "field": "contact.notes",
            "description": "<p>Notas adicionales</p>"
          }
        ]
      }
    },
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "string",
            "allowedValues": [
              "JsonWebToken"
            ],
            "optional": false,
            "field": "authorization",
            "description": "<p>Bearer Token requerido para la autorizacion</p>"
          }
        ]
      }
    }
  },
  {
    "type": "get",
    "url": "/accounts",
    "title": "Lista de clientes",
    "name": "GetAccounts",
    "group": "Clientes",
    "description": "<p>Obtiene la lista de clientes de un cliente (distribuidor / administrador)</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": true,
            "field": "status",
            "description": "<p>Estado de los clientes (Activos, Elimindos). si no se especifica la funcion devolvera los clientes activos</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Example ",
          "content": "{\"success\":true,\"statusCode\":200,\"pagination\":{\"self\":\"\",\"next\":\"\",\"prev\":\"\"},\"data\":{\"customers\":[{\"id\":\"3\",\"clientTypeID\":\"1\",\"clientType\":\"CLIENTE\",\"customer\":\"aviles\",\"creationTimestamp\":\"0\"},{\"id\":\"4\",\"clientTypeID\":\"1\",\"clientType\":\"CLIENTE\",\"customer\":\"maguersa\",\"creationTimestamp\":\"1576882215\"}]}}",
          "type": "json"
        }
      ],
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "array",
            "optional": false,
            "field": "customer",
            "description": "<p>Arreglo que contine informacion de cada cliente</p>"
          },
          {
            "group": "Success 200",
            "type": "object",
            "optional": false,
            "field": "client",
            "description": "<p>Objeto que representa un cliente</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "product.id",
            "description": "<p>ID del cliente</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "product.clientTypeID",
            "description": "<p>ID del tipo de cliente</p>"
          },
          {
            "group": "Success 200",
            "type": "string",
            "optional": false,
            "field": "product.clientType",
            "description": "<p>Tipo de cliente</p>"
          },
          {
            "group": "Success 200",
            "type": "string",
            "optional": false,
            "field": "product.customer",
            "description": "<p>Nombre de la cuenta / cliente</p>"
          },
          {
            "group": "Success 200",
            "type": "long",
            "optional": false,
            "field": "product.creationTimestamp",
            "description": "<p>Fecha de registro</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "apidoc/accounts.php",
    "groupTitle": "Clientes",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "string",
            "allowedValues": [
              "JsonWebToken"
            ],
            "optional": false,
            "field": "authorization",
            "description": "<p>Bearer Token requerido para la autorizacion</p>"
          }
        ]
      }
    }
  },
  {
    "type": "post",
    "url": "/accounts/:id/contacts",
    "title": "Registrar contacto a cliente",
    "name": "PostAccountContact",
    "group": "Clientes",
    "description": "<p>Registra un nuevo contacto a un cliente determinado</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "id",
            "description": "<p>ID del cliente a actualizar</p>"
          },
          {
            "group": "Parameter",
            "type": "object",
            "optional": false,
            "field": "contact",
            "description": "<p>Objeto que contine la informacion del contacto</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "contact.contactType",
            "description": "<p>Tipo de contacto</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "contact.name",
            "description": "<p>Nombre del contacto</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "contact.phone",
            "description": "<p>Telefono</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "contact.cel",
            "description": "<p>Telefono celular</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "contact.email",
            "description": "<p>Correo electronico</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "contact.notes",
            "description": "<p>Notas adicionales</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Example",
          "content": "{\"contact\":{\"contactType\":1,\"name\":\"new name\",\"phone\":\"123456\",\"cel\":\"777123456\",\"email\":\"email\",\"notes\":\"some notes\"}}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "apidoc/accounts.php",
    "groupTitle": "Clientes",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "string",
            "allowedValues": [
              "JsonWebToken"
            ],
            "optional": false,
            "field": "authorization",
            "description": "<p>Bearer Token requerido para la autorizacion</p>"
          }
        ]
      }
    }
  },
  {
    "type": "post",
    "url": "/accounts",
    "title": "Registrar Cuenta",
    "name": "PostAccounts",
    "group": "Clientes",
    "description": "<p>Realiza el Registro un nuevo cliente o distribuidor en la plataforma</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "object",
            "optional": false,
            "field": "account",
            "description": "<p>Objeto que contiene la informacion de la nueva cuenta</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "account.type",
            "description": "<p>Tipo de cuenta (Cliente o Distribuidor)</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "account.name",
            "description": "<p>Nombre de la cuenta</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "account.email",
            "description": "<p>Correo de la cuenta</p>"
          },
          {
            "group": "Parameter",
            "type": "object",
            "optional": false,
            "field": "legal",
            "description": "<p>Objecto que contiene la informacion de los datos legales y/o para facturacion</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "legal.status",
            "description": "<p>Estado legal del la cuenta</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "legal.name",
            "description": "<p>Nombre legal de la compañia o del representante legal</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "legal.country",
            "description": "<p>Pais</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "legal.region",
            "description": "<p>Region o Estado</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "legal.zipcode",
            "description": "<p>Codigo postal</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "legal.notes",
            "description": "<p>notas adicionales</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "legal.address",
            "description": "<p>Direccion</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "legal.id",
            "description": "<p>RFC o ID legal</p>"
          },
          {
            "group": "Parameter",
            "type": "array",
            "optional": false,
            "field": "contacts",
            "description": "<p>Arreglo que contiene objectos contacto</p>"
          },
          {
            "group": "Parameter",
            "type": "object",
            "optional": false,
            "field": "contact",
            "description": "<p>Objecto que representa un contacto</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "contact.type",
            "description": "<p>Tipo de contacto</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "contact.name",
            "description": "<p>Nombre del contacto</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "contact.phone",
            "description": "<p>Telefono local o de oficina del contacto</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "contact.cel",
            "description": "<p>Telefono celular del contacto</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "contact.email",
            "description": "<p>Correo del contacto</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "contact.notes",
            "description": "<p>Notas adicionales</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Request-Example:",
          "content": "{\"account\":{\"type\":2,\"name\":\"distribuidor avilex\",\"email\":\"naviles@globalgps.com.mx\"},\"legal\":{\"status\":1,\"name\":\"aviles sa de cv\",\"country\":\"Mexico\",\"region\":\"Morelos\",\"zipcode\":62460,\"notes\":\"notas varias\",\"address\":\"direccion\",\"id\":\"RFC123456\"},\"contacts\":[{\"type\":1,\"name\":\"noe aviles\",\"phone\":\"123456\",\"cel\":\"777123456\",\"email\":\"contact@email\",\"notes\":\"notas contact\"},{\"type\":2,\"name\":\"marco aviles\",\"phone\":\"22222\",\"cel\":\"77733333\",\"email\":\"contact2@email\",\"notes\":\"notas 2 contact\"}]}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "apidoc/accounts.php",
    "groupTitle": "Clientes",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "string",
            "allowedValues": [
              "JsonWebToken"
            ],
            "optional": false,
            "field": "authorization",
            "description": "<p>Bearer Token requerido para la autorizacion</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success",
          "content": "{\"success\":true,\"statusCode\":200,\"pagination\":{\"self\":\"\",\"next\":\"\",\"prev\":\"\"},\"data\":[]}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "post",
    "url": "/accounts/contacts",
    "title": "Registrar contacto",
    "name": "PostMyAccountContact",
    "group": "Clientes",
    "description": "<p>Registra un nuevo contacto</p>",
    "version": "0.0.0",
    "filename": "apidoc/accounts.php",
    "groupTitle": "Clientes",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "string",
            "allowedValues": [
              "JsonWebToken"
            ],
            "optional": false,
            "field": "authorization",
            "description": "<p>Bearer Token requerido para la autorizacion</p>"
          }
        ]
      }
    },
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "object",
            "optional": false,
            "field": "contact",
            "description": "<p>Objeto que contine la informacion del contacto</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "contact.contactType",
            "description": "<p>Tipo de contacto</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "contact.name",
            "description": "<p>Nombre del contacto</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "contact.phone",
            "description": "<p>Telefono</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "contact.cel",
            "description": "<p>Telefono celular</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "contact.email",
            "description": "<p>Correo electronico</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "contact.notes",
            "description": "<p>Notas adicionales</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Example",
          "content": "{\"contact\":{\"contactType\":1,\"name\":\"new name\",\"phone\":\"123456\",\"cel\":\"777123456\",\"email\":\"email\",\"notes\":\"some notes\"}}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "put",
    "url": "/accounts/:id",
    "title": "Actualizar cliente",
    "name": "PutAccount",
    "group": "Clientes",
    "description": "<p>Actualiza la informacion del cliente</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "id",
            "description": "<p>ID del cliente a actualizar</p>"
          },
          {
            "group": "Parameter",
            "type": "object",
            "optional": false,
            "field": "customer",
            "description": "<p>Objeto que contine la informacion del cliente</p>"
          },
          {
            "group": "Parameter",
            "type": "object",
            "optional": false,
            "field": "legal",
            "description": "<p>Objeto que contiene la informacion legal y de facturacion</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": true,
            "field": "legal.statusID",
            "description": "<p>ID del estado legal (Persona Fisica, Moral o ninguno)</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": true,
            "field": "legal.name",
            "description": "<p>Nombre legal o Razon Social <br/><b>Nota: </b> Si el parametro se proporciona vacio, el contenido sera actualizado a nulo/vacio</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": true,
            "field": "legal.country",
            "description": "<p>Pais <br/><b>Nota: </b> Si el parametro se proporciona vacio, el contenido sera actualizado a nulo/vacio</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": true,
            "field": "legal.region",
            "description": "<p>Ciudad o region <br/><b>Nota: </b> Si el parametro se proporciona vacio, el contenido sera actualizado a nulo/vacio</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": true,
            "field": "legal.zipCode",
            "description": "<p>Codigo Postal <br/><b>Nota: </b> Si el parametro se proporciona vacio, el contenido sera actualizado a nulo/vacio</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": true,
            "field": "legal.notes",
            "description": "<p>Notas adicionales <br/><b>Nota: </b> Si el parametro se proporciona vacio, el contenido sera actualizado a nulo/vacio</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": true,
            "field": "legal.taxID",
            "description": "<p>RFC o ID legal <br/><b>Nota: </b> Si el parametro se proporciona vacio, el contenido sera actualizado a nulo/vacio</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": true,
            "field": "legal.address",
            "description": "<p>Direccion legal <br/><b>Nota: </b> Si el parametro se proporciona vacio, el contenido sera actualizado a nulo/vacio</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Example",
          "content": "{\"customer\":{\"legal\":{\"country\":\"MEXICO\",\"region\":\"MORELOS\",\"address\":\"Azucena 140\",\"zipCode\":\"62000\",\"notes\":\"\",\"taxID\":\"\"}}}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "apidoc/accounts.php",
    "groupTitle": "Clientes",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "string",
            "allowedValues": [
              "JsonWebToken"
            ],
            "optional": false,
            "field": "authorization",
            "description": "<p>Bearer Token requerido para la autorizacion</p>"
          }
        ]
      }
    }
  },
  {
    "type": "put",
    "url": "/accounts/:id/status",
    "title": "Suspender Cuenta",
    "name": "PutAccountStatus",
    "group": "Clientes",
    "description": "<p>Actualiza el estado de una cuenta (suspender)</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "id",
            "description": "<p>ID de la cuenta a suspender</p>"
          },
          {
            "group": "Parameter",
            "type": "bool",
            "optional": false,
            "field": "status",
            "description": "<p>Indica el estado de la cuenta <br> True = Cuenta activa <br> False = Cuenta suspendida</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Ejemplo",
          "content": "{\"status\":false}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "apidoc/accounts.php",
    "groupTitle": "Clientes",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "string",
            "allowedValues": [
              "JsonWebToken"
            ],
            "optional": false,
            "field": "authorization",
            "description": "<p>Bearer Token requerido para la autorizacion</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success",
          "content": "{\"success\":true,\"statusCode\":200,\"pagination\":{\"self\":\"\",\"next\":\"\",\"prev\":\"\"},\"data\":[]}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "get",
    "url": "/configuration/eventpassword/exists",
    "title": "Comprobar existencia de contraseña de eventos",
    "name": "GetEventPasswordExists",
    "group": "Configuration",
    "description": "<p>Consulta si la cuenta tiene definida una contraseña de eventos</p>",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "boolean",
            "optional": false,
            "field": "eventPasswordExists",
            "description": "<p>Indica si la cuenta tiene contraseña definida.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "SuccessExample",
          "content": "{\"success\":true,\"statusCode\":200,\"pagination\":{\"self\":\"\",\"next\":\"\",\"prev\":\"\"},\"data\":{\"eventPasswordExists\":true}}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "apidoc/configurations.php",
    "groupTitle": "Configuration",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "string",
            "allowedValues": [
              "JsonWebToken"
            ],
            "optional": false,
            "field": "authorization",
            "description": "<p>Bearer Token requerido para la autorizacion</p>"
          }
        ]
      }
    }
  },
  {
    "type": "get",
    "url": "/configuration/eventpassword/expiration",
    "title": "Comprobar expiracion de contraseña de eventos",
    "name": "GetEventPasswordExpiration",
    "group": "Configuration",
    "description": "<p>Consulta el timestamp de expiracion de la contraseña de eventos</p>",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "timestampExpiration",
            "description": "<p>timestamp que indica cuando expira la contraseña de eventos</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "SuccessExample",
          "content": "{\"success\":true,\"statusCode\":200,\"pagination\":{\"self\":\"\",\"next\":\"\",\"prev\":\"\"},\"data\":{\"timestampExpiration\":\"1568844000\"}}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "apidoc/configurations.php",
    "groupTitle": "Configuration",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "string",
            "allowedValues": [
              "JsonWebToken"
            ],
            "optional": false,
            "field": "authorization",
            "description": "<p>Bearer Token requerido para la autorizacion</p>"
          }
        ]
      }
    }
  },
  {
    "type": "get",
    "url": "/configuration/eventpassword/validate",
    "title": "Comprobar si la contraseña de eventos es correcta",
    "name": "GetEventPasswordValidate",
    "group": "Configuration",
    "description": "<p>Comprueba si la contraseña de eventos es valida</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "password",
            "description": "<p>Contraseña a comprobar</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "boolean",
            "optional": false,
            "field": "isValidEventPassword",
            "description": "<p>resultado de comprobar si la contraseña de eventos es valida</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "SuccessExample",
          "content": "{\"success\":true,\"statusCode\":200,\"pagination\":{\"self\":\"\",\"next\":\"\",\"prev\":\"\"},\"data\":{\"isValidEventPassword\":true}}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "apidoc/configurations.php",
    "groupTitle": "Configuration",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "string",
            "allowedValues": [
              "JsonWebToken"
            ],
            "optional": false,
            "field": "authorization",
            "description": "<p>Bearer Token requerido para la autorizacion</p>"
          }
        ]
      }
    }
  },
  {
    "type": "get",
    "url": "/configuration/account",
    "title": "Informacion de la cuenta",
    "name": "GetMyAccountInfo",
    "group": "Configuration",
    "description": "<p>Obtiene informacion de la cuenta</p>",
    "version": "0.0.0",
    "filename": "apidoc/configurations.php",
    "groupTitle": "Configuration",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "id",
            "description": "<p>ID del cliente a consultar</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Example ",
          "content": "{\"success\":true,\"statusCode\":200,\"pagination\":{\"self\":\"\",\"next\":\"\",\"prev\":\"\"},\"data\":{\"customer\":{\"id\":\"3\",\"ownerID\":\"2\",\"clientTypeID\":\"1\",\"clientType\":\"CLIENTE\",\"account\":\"aviles\",\"creationTimestamp\":\"0\",\"legal\":{\"statusID\":\"1\",\"status\":\"NINGUNO\",\"name\":\"NOE AVILES\",\"country\":\"MEXICO\",\"region\":\"MORELOS\",\"zipCode\":\"62460\",\"note\":null,\"taxID\":null},\"contacts\":[{\"id\":\"3\",\"contactTypeID\":\"3\",\"contactType\":\"RESPONSABLE\",\"name\":\"Noe \",\"phone\":\"123456\",\"cel\":\"789456\",\"email\":\"naviles@globalgps.com.mx\",\"creationTimestamp\":\"1579043528\",\"notes\":null}]}}}",
          "type": "json"
        }
      ],
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "object",
            "optional": false,
            "field": "customer",
            "description": "<p>Objeto que contine la informacion del cliente</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "customer.id",
            "description": "<p>ID de la cuenta</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "customer.ownerID",
            "description": "<p>ID del propietario de la cuenta</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "customer.clientTypeID",
            "description": "<p>ID del tipo de cliente</p>"
          },
          {
            "group": "Success 200",
            "type": "string",
            "optional": false,
            "field": "customer.clientType",
            "description": "<p>Tipo de cliente</p>"
          },
          {
            "group": "Success 200",
            "type": "string",
            "optional": false,
            "field": "customer.account",
            "description": "<p>Nombre de la cuenta / cliente</p>"
          },
          {
            "group": "Success 200",
            "type": "long",
            "optional": false,
            "field": "customer.creationTimestamp",
            "description": "<p>Fecha de registro</p>"
          },
          {
            "group": "Success 200",
            "type": "object",
            "optional": false,
            "field": "legal",
            "description": "<p>Objeto que contiene la informacion legal y de facturacion</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "legal.statusID",
            "description": "<p>ID del estado legal</p>"
          },
          {
            "group": "Success 200",
            "type": "string",
            "optional": false,
            "field": "legal.status",
            "description": "<p>Estado legal (Persona Fisica, Moral o ninguno)</p>"
          },
          {
            "group": "Success 200",
            "type": "string",
            "optional": false,
            "field": "legal.name",
            "description": "<p>Nombre legal o Razon Social</p>"
          },
          {
            "group": "Success 200",
            "type": "string",
            "optional": false,
            "field": "legal.country",
            "description": "<p>Pais</p>"
          },
          {
            "group": "Success 200",
            "type": "string",
            "optional": false,
            "field": "legal.region",
            "description": "<p>Ciudad o region</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "legal.zipCode",
            "description": "<p>Codigo Postal</p>"
          },
          {
            "group": "Success 200",
            "type": "string",
            "optional": false,
            "field": "legal.notes",
            "description": "<p>Notas adicionales</p>"
          },
          {
            "group": "Success 200",
            "type": "string",
            "optional": false,
            "field": "customer.taxID",
            "description": "<p>RFC o ID legal</p>"
          },
          {
            "group": "Success 200",
            "type": "array",
            "optional": false,
            "field": "contacts",
            "description": "<p>Arreglo que contiene informacion de los contactos</p>"
          },
          {
            "group": "Success 200",
            "type": "object",
            "optional": false,
            "field": "contact",
            "description": "<p>Representa un contacto</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "contact.id",
            "description": "<p>ID del contacto</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "contact.contactTypeID",
            "description": "<p>ID del tipo de contacto</p>"
          },
          {
            "group": "Success 200",
            "type": "string",
            "optional": false,
            "field": "contact.contactType",
            "description": "<p>Tipo de contacto</p>"
          },
          {
            "group": "Success 200",
            "type": "string",
            "optional": false,
            "field": "contact.name",
            "description": "<p>Nombre del contacto</p>"
          },
          {
            "group": "Success 200",
            "type": "string",
            "optional": false,
            "field": "contact.phone",
            "description": "<p>Numero de telefono del contacto</p>"
          },
          {
            "group": "Success 200",
            "type": "string",
            "optional": false,
            "field": "contact.cel",
            "description": "<p>Numero celular del contacto</p>"
          },
          {
            "group": "Success 200",
            "type": "string",
            "optional": false,
            "field": "contact.email",
            "description": "<p>Correo electronico del contacto</p>"
          },
          {
            "group": "Success 200",
            "type": "string",
            "optional": false,
            "field": "contact.creationTimestamp",
            "description": "<p>Fecha de registro del contacto</p>"
          },
          {
            "group": "Success 200",
            "type": "string",
            "optional": false,
            "field": "contact.notes",
            "description": "<p>Notas adicionales</p>"
          }
        ]
      }
    },
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "string",
            "allowedValues": [
              "JsonWebToken"
            ],
            "optional": false,
            "field": "authorization",
            "description": "<p>Bearer Token requerido para la autorizacion</p>"
          }
        ]
      }
    }
  },
  {
    "type": "put",
    "url": "/configuration/eventpassword",
    "title": "Actualizar contraseña de eventos",
    "name": "PutEventPassword",
    "group": "Configuration",
    "description": "<p>Define / actualiza la contraseña de eventos</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "password",
            "description": "<p>Contraseña que se actualizara</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "apidoc/configurations.php",
    "groupTitle": "Configuration",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "string",
            "allowedValues": [
              "JsonWebToken"
            ],
            "optional": false,
            "field": "authorization",
            "description": "<p>Bearer Token requerido para la autorizacion</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success",
          "content": "{\"success\":true,\"statusCode\":200,\"pagination\":{\"self\":\"\",\"next\":\"\",\"prev\":\"\"},\"data\":[]}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "put",
    "url": "/configuration/account",
    "title": "Actualizar datos de la cuenta",
    "name": "PutMyAccountInfo",
    "group": "Configuration",
    "description": "<p>Actualiza la informacion de la cuenta</p>",
    "version": "0.0.0",
    "filename": "apidoc/configurations.php",
    "groupTitle": "Configuration",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "string",
            "allowedValues": [
              "JsonWebToken"
            ],
            "optional": false,
            "field": "authorization",
            "description": "<p>Bearer Token requerido para la autorizacion</p>"
          }
        ]
      }
    },
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "object",
            "optional": false,
            "field": "customer",
            "description": "<p>Objeto que contine la informacion del cliente</p>"
          },
          {
            "group": "Parameter",
            "type": "object",
            "optional": false,
            "field": "legal",
            "description": "<p>Objeto que contiene la informacion legal y de facturacion</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": true,
            "field": "legal.statusID",
            "description": "<p>ID del estado legal (Persona Fisica, Moral o ninguno)</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": true,
            "field": "legal.name",
            "description": "<p>Nombre legal o Razon Social <br/><b>Nota: </b> Si el parametro se proporciona vacio, el contenido sera actualizado a nulo/vacio</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": true,
            "field": "legal.country",
            "description": "<p>Pais <br/><b>Nota: </b> Si el parametro se proporciona vacio, el contenido sera actualizado a nulo/vacio</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": true,
            "field": "legal.region",
            "description": "<p>Ciudad o region <br/><b>Nota: </b> Si el parametro se proporciona vacio, el contenido sera actualizado a nulo/vacio</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": true,
            "field": "legal.zipCode",
            "description": "<p>Codigo Postal <br/><b>Nota: </b> Si el parametro se proporciona vacio, el contenido sera actualizado a nulo/vacio</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": true,
            "field": "legal.notes",
            "description": "<p>Notas adicionales <br/><b>Nota: </b> Si el parametro se proporciona vacio, el contenido sera actualizado a nulo/vacio</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": true,
            "field": "legal.taxID",
            "description": "<p>RFC o ID legal <br/><b>Nota: </b> Si el parametro se proporciona vacio, el contenido sera actualizado a nulo/vacio</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": true,
            "field": "legal.address",
            "description": "<p>Direccion legal <br/><b>Nota: </b> Si el parametro se proporciona vacio, el contenido sera actualizado a nulo/vacio</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Example",
          "content": "{\"customer\":{\"legal\":{\"country\":\"MEXICO\",\"region\":\"MORELOS\",\"address\":\"Azucena 140\",\"zipCode\":\"62000\",\"notes\":\"\",\"taxID\":\"\"}}}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "put",
    "url": "/devices/:id",
    "title": "Actualizar informacion de dispositivo",
    "name": "PutDevices",
    "group": "Dispositivos",
    "description": "<p>Actualiza la informacion de un dispositivo</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "id",
            "description": "<p>ID del dispositivo a actualizar</p>"
          },
          {
            "group": "Parameter",
            "type": "object",
            "optional": true,
            "field": "device",
            "description": "<p>Objeto que contiene la informacion del dispositivo</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": true,
            "field": "device.marker",
            "description": "<p>ID del usuario</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": true,
            "field": "device.alias",
            "description": "<p>Alias del dispositivo</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": true,
            "field": "device.notes",
            "description": "<p>Notas adicionales</p>"
          },
          {
            "group": "Parameter",
            "type": "object",
            "optional": true,
            "field": "vehicle",
            "description": "<p>Objeto que contiene la informacion del vehiculo</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": true,
            "field": "vehicle.brand",
            "description": "<p>Marca del vehiculo</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": true,
            "field": "vehicle.model",
            "description": "<p>Modelo del vehiculo</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": true,
            "field": "vehicle.year",
            "description": "<p>Año del vehiculo</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": true,
            "field": "vehicle.vin",
            "description": "<p>Serie identificador del motor</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": true,
            "field": "vehicle.colour",
            "description": "<p>Color del vehiculo</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": true,
            "field": "vehicle.carPlate",
            "description": "<p>Placas del vehiculo</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": true,
            "field": "vehicle.country",
            "description": "<p>Pais de las placas</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": true,
            "field": "vehicle.region",
            "description": "<p>Ciudad o region de las placas</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": true,
            "field": "vehicle.insurance",
            "description": "<p>Seguro del vehiculo</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": true,
            "field": "vehicle.insuranceID",
            "description": "<p>Numero de Seguro del vehiculo</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": true,
            "field": "vehicle.notes",
            "description": "<p>Notas adicionales</p>"
          },
          {
            "group": "Parameter",
            "type": "object",
            "optional": true,
            "field": "driver",
            "description": "<p>Objeto que contiene la informacion del conductor</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": true,
            "field": "driver.name",
            "description": "<p>Nombre del conductor</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": true,
            "field": "driver.phone",
            "description": "<p>Telefono del conductor</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Request-Example 1:",
          "content": "{\"device\":{\"marker\":2,\"alias\":\"DELTA PEREZ\",\"notes\":\"\"},\"vehicle\":{\"brand\":\"FORD\",\"model\":\"FOCUS\",\"year\":\"2013\",\"vin\":\"ADG5168ER\",\"colour\":\"ROJO\",\"carPlate\":\"DS-FRG-S\",\"country\":\"MEXICO\",\"region\":\"CDMX\",\"insurance\":\"NO\",\"insuranceID\":\"\",\"notes\":\"Vehiculo nuevo\"},\"driver\":{\"name\":\"MARCO PEREZ\",\"phone\":\"777123456\"}}",
          "type": "json"
        },
        {
          "title": "Request-Example 2:",
          "content": "{\"device\":{\"marker\":2},\"driver\":{\"phone\":\"777123456\"}}",
          "type": "json"
        },
        {
          "title": "Request-Example 3:",
          "content": "{\"vehicle\":{\"brand\":\"FORD\",\"model\":\"FOCUS\",\"year\":\"2013\",\"vin\":\"ADG5168ER\",\"colour\":\"ROJO\",\"carPlate\":\"DS-FRG-S\",\"country\":\"MEXICO\",\"region\":\"CDMX\",\"insurance\":\"NO\",\"insuranceID\":\"\",\"notes\":\"Vehiculo nuevo\"},\"driver\":{\"name\":\"MARCO PEREZ\",\"phone\":\"777123456\"}}",
          "type": "json"
        },
        {
          "title": "Request-Example 4:",
          "content": "{\"vehicle\":{\"brand\":\"FORD\",\"model\":\"FOCUS\",\"year\":\"2013\",\"vin\":\"ADG5168ER\",\"colour\":\"ROJO\",\"carPlate\":\"DS-FRG-S\",\"country\":\"MEXICO\",\"region\":\"CDMX\",\"insurance\":\"NO\",\"insuranceID\":\"\",\"notes\":\"Vehiculo nuevo\"}}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "apidoc/devices.php",
    "groupTitle": "Dispositivos",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "string",
            "allowedValues": [
              "JsonWebToken"
            ],
            "optional": false,
            "field": "authorization",
            "description": "<p>Bearer Token requerido para la autorizacion</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success",
          "content": "{\"success\":true,\"statusCode\":200,\"pagination\":{\"self\":\"\",\"next\":\"\",\"prev\":\"\"},\"data\":[]}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "put",
    "url": "/devices/:id/fleets",
    "title": "Actualizar Flotilla de un dispositivo",
    "name": "PutDevicesFleet",
    "group": "Dispositivos",
    "description": "<p>Cambia la flotilla a la que pertenece un dispositivo</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "id",
            "description": "<p>ID del dispositivo</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": true,
            "field": "fleetID",
            "description": "<p>ID de la flotilla a la que pertenecera.<br> <b>Nota: </b>Si no se proporciona este campo o se manda vacio, el dispositivo sera retirado de la flotilla actual y se mandara a &quot;sin asignar&quot;</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Request-Example 1:",
          "content": "{\"fleetID\":6}",
          "type": "json"
        },
        {
          "title": "Request-Example 2:",
          "content": "{\"fleetID\":\"\"}",
          "type": "json"
        },
        {
          "title": "Request-Example 3:",
          "content": "{}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "apidoc/devices.php",
    "groupTitle": "Dispositivos",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "string",
            "allowedValues": [
              "JsonWebToken"
            ],
            "optional": false,
            "field": "authorization",
            "description": "<p>Bearer Token requerido para la autorizacion</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success",
          "content": "{\"success\":true,\"statusCode\":200,\"pagination\":{\"self\":\"\",\"next\":\"\",\"prev\":\"\"},\"data\":[]}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "delete",
    "url": "/fleets/:id",
    "title": "Eliminar Flotilla",
    "name": "DeleteFleet",
    "group": "Flotillas",
    "description": "<p>Elimina una flotilla</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "id",
            "description": "<p>ID de la flotilla a eliminar</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "apidoc/fleets.php",
    "groupTitle": "Flotillas",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "string",
            "allowedValues": [
              "JsonWebToken"
            ],
            "optional": false,
            "field": "authorization",
            "description": "<p>Bearer Token requerido para la autorizacion</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success",
          "content": "{\"success\":true,\"statusCode\":200,\"pagination\":{\"self\":\"\",\"next\":\"\",\"prev\":\"\"},\"data\":[]}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "get",
    "url": "/fleets/:id",
    "title": "Informacion de Flotilla",
    "name": "GetFleet",
    "group": "Flotillas",
    "description": "<p>Obtiene la informacion de una flotilla</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "id",
            "description": "<p>ID de la flotilla a consultar</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "object",
            "optional": false,
            "field": "fleet",
            "description": "<p>Objecto que contiene la informacion de la flotilla</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "fleet.id",
            "description": "<p>ID de la flotilla</p>"
          },
          {
            "group": "Success 200",
            "type": "string",
            "optional": false,
            "field": "fleet.name",
            "description": "<p>Nombre de la flotilla</p>"
          },
          {
            "group": "Success 200",
            "type": "int[]",
            "optional": false,
            "field": "fleet.devices",
            "description": "<p>Arreglo que contiene los id's de los dispositivos asociados a la flotilla</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Example ",
          "content": "{\"success\":true,\"statusCode\":200,\"pagination\":{\"self\":\"\",\"next\":\"\",\"prev\":\"\"},\"data\":{\"fleet\":{\"id\":\"11\",\"name\":\"Nueva flota\",\"devices\":[\"46\",\"45\",\"47\"]}}}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "apidoc/fleets.php",
    "groupTitle": "Flotillas",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "string",
            "allowedValues": [
              "JsonWebToken"
            ],
            "optional": false,
            "field": "authorization",
            "description": "<p>Bearer Token requerido para la autorizacion</p>"
          }
        ]
      }
    }
  },
  {
    "type": "get",
    "url": "/fleets",
    "title": "Lista de flotillas",
    "name": "GetFleets",
    "group": "Flotillas",
    "description": "<p>Obtiene la lista de las flotillas del usuario</p>",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "object[]",
            "optional": false,
            "field": "fleets",
            "description": "<p>Arreglo que contiene flotillas</p>"
          },
          {
            "group": "Success 200",
            "type": "object",
            "optional": false,
            "field": "fleet",
            "description": "<p>Objecto que contiene la informacion de la flotilla</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "fleet.id",
            "description": "<p>ID de la flotilla</p>"
          },
          {
            "group": "Success 200",
            "type": "string",
            "optional": false,
            "field": "fleet.name",
            "description": "<p>Nombre de la flotilla</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Example ",
          "content": "{\"success\":true,\"statusCode\":200,\"pagination\":{\"self\":\"\",\"next\":\"\",\"prev\":\"\"},\"data\":{\"fleets\":[{\"id\":\"6\",\"name\":\"FLOTA A\"},{\"id\":\"7\",\"name\":\"FLOTA B\"},{\"id\":\"11\",\"name\":\"Nueva flota\"}]}}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "apidoc/fleets.php",
    "groupTitle": "Flotillas",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "string",
            "allowedValues": [
              "JsonWebToken"
            ],
            "optional": false,
            "field": "authorization",
            "description": "<p>Bearer Token requerido para la autorizacion</p>"
          }
        ]
      }
    }
  },
  {
    "type": "post",
    "url": "/fleets",
    "title": "Registrar Flotilla",
    "name": "PostFleets",
    "group": "Flotillas",
    "description": "<p>Registra una nueva flotilla</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "object",
            "optional": false,
            "field": "fleet",
            "description": "<p>Objeto que contiene la informacion de la nueva flotilla</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "fleet.name",
            "description": "<p>Nombre de la flotilla</p>"
          },
          {
            "group": "Parameter",
            "type": "int[]",
            "optional": false,
            "field": "fleet.devices",
            "description": "<p>Arreglo de id´s de dispositivos que seran agregados a la flotilla</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Request-Example:",
          "content": "{\"fleet\":{\"name\":\"Nueva flota\",\"devices\":[45,46,47]}}",
          "type": "json"
        }
      ]
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "fleetID",
            "description": "<p>ID de la flotilla creada</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Example ",
          "content": "{\"success\":true,\"statusCode\":201,\"data\":{\"fleetID\":\"11\"}}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "apidoc/fleets.php",
    "groupTitle": "Flotillas",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "string",
            "allowedValues": [
              "JsonWebToken"
            ],
            "optional": false,
            "field": "authorization",
            "description": "<p>Bearer Token requerido para la autorizacion</p>"
          }
        ]
      }
    }
  },
  {
    "type": "put",
    "url": "/fleets/:id",
    "title": "Actualizar Flotilla",
    "name": "PutFleets",
    "group": "Flotillas",
    "description": "<p>Registra una nueva flotilla</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "id",
            "description": "<p>ID de la flotilla a consultar</p>"
          },
          {
            "group": "Parameter",
            "type": "object",
            "optional": false,
            "field": "fleet",
            "description": "<p>Objeto que contiene la informacion de la nueva flotilla</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": true,
            "field": "fleet.name",
            "description": "<p>Nombre de la flotilla</p>"
          },
          {
            "group": "Parameter",
            "type": "int[]",
            "optional": true,
            "field": "fleet.devices",
            "description": "<p>Arreglo de id´s de dispositivos que contendr la flotilla</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Request-Example:",
          "content": "{\"fleet\":{\"name\":\"Nueva flota\",\"devices\":[46,47]}}",
          "type": "json"
        },
        {
          "title": "Request-Example 2:",
          "content": "{\"fleet\":{\"name\":\"Nueva flota\"}}",
          "type": "json"
        },
        {
          "title": "Request-Example 3:",
          "content": "{\"fleet\":{\"devices\":[46,47]}}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "apidoc/fleets.php",
    "groupTitle": "Flotillas",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "string",
            "allowedValues": [
              "JsonWebToken"
            ],
            "optional": false,
            "field": "authorization",
            "description": "<p>Bearer Token requerido para la autorizacion</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success",
          "content": "{\"success\":true,\"statusCode\":200,\"pagination\":{\"self\":\"\",\"next\":\"\",\"prev\":\"\"},\"data\":[]}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "delete",
    "url": "/geofences/:id/devices/:deviceID",
    "title": "desVincular dispositivo de geocerca",
    "name": "DeleteDeviceFromGeofence",
    "group": "Geocercas",
    "description": "<p>Elimina el vinculo de dispositivo gps con una geocerca</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "id",
            "description": "<p>ID de la geocerca</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "deviceID",
            "description": "<p>id del dispositivo gps a vincular</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "SuccessExample",
          "content": "{\"success\":true,\"statusCode\":200,\"data\":[]}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "apidoc/geofences.php",
    "groupTitle": "Geocercas",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "string",
            "allowedValues": [
              "JsonWebToken"
            ],
            "optional": false,
            "field": "authorization",
            "description": "<p>Bearer Token requerido para la autorizacion</p>"
          }
        ]
      }
    }
  },
  {
    "type": "delete",
    "url": "/geofences/:id/subscribers/emails/:emailID",
    "title": "Eliminar correo suscriptor de la geocerca",
    "name": "DeleteGeofenceEmailSubscriber",
    "group": "Geocercas",
    "description": "<p>Eliminar el correo suscrito a las notificaciones de la geocerca</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "id",
            "description": "<p>ID de la geocerca</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "emailID",
            "description": "<p>ID del correo suscrito</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "SuccessExample",
          "content": "{\"success\":true,\"statusCode\":200,\"pagination\":{\"self\":\"\",\"next\":\"\",\"prev\":\"\"},\"data\":[]}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "apidoc/geofences.php",
    "groupTitle": "Geocercas",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "string",
            "allowedValues": [
              "JsonWebToken"
            ],
            "optional": false,
            "field": "authorization",
            "description": "<p>Bearer Token requerido para la autorizacion</p>"
          }
        ]
      }
    }
  },
  {
    "type": "delete",
    "url": "/geofences/:id",
    "title": "Eliminar Geocerca",
    "name": "DeleteGeofences",
    "group": "Geocercas",
    "description": "<p>elimina (de forma logica) un registro de geocerca o punto de interes asi como correos electronicos suscritos y dispositivos vinculados a la misma</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "id",
            "description": "<p>ID de la geocerca</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "apidoc/geofences.php",
    "groupTitle": "Geocercas",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "string",
            "allowedValues": [
              "JsonWebToken"
            ],
            "optional": false,
            "field": "authorization",
            "description": "<p>Bearer Token requerido para la autorizacion</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success",
          "content": "{\"success\":true,\"statusCode\":200,\"pagination\":{\"self\":\"\",\"next\":\"\",\"prev\":\"\"},\"data\":[]}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "get",
    "url": "/geofences/:id",
    "title": "Informacion de Geocerca",
    "name": "GetGeofence",
    "group": "Geocercas",
    "description": "<p>Obtiene la informacion de una geocerca o punto de interes</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "id",
            "description": "<p>ID de la geocerca</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Circular Geofence",
          "content": "{\"success\":true,\"statusCode\":200,\"pagination\":{\"self\":\"\",\"next\":\"\",\"prev\":\"\"},\"data\":{\"geofence\":{\"id\":\"14\",\"userID\":\"70\",\"geofenceType\":\"1\",\"behavior\":\"1\",\"figureType\":\"1\",\"name\":\"Circular 441\",\"timestampCreation\":\"1561685480\",\"coords\":[{\"lat\":\"18.968009\",\"lng\":\"-99.240219\"}],\"radio\":\"150\"}}}",
          "type": "json"
        },
        {
          "title": "Success-Polygonal Geofence",
          "content": "{\"success\":true,\"statusCode\":200,\"pagination\":{\"self\":\"\",\"next\":\"\",\"prev\":\"\"},\"data\":{\"geofence\":{\"id\":\"19\",\"userID\":\"70\",\"geofenceType\":\"1\",\"behavior\":\"1\",\"figureType\":\"2\",\"name\":\"Circular 441\",\"timestampCreation\":\"1562007287\",\"coords\":[{\"lat\":\"18.968009\",\"lng\":\"-99.240219\"},{\"lat\":\"18.968009\",\"lng\":\"-99.240219\"},{\"lat\":\"18.968009\",\"lng\":\"-99.240219\"}]}}}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "apidoc/geofences.php",
    "groupTitle": "Geocercas",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "string",
            "allowedValues": [
              "JsonWebToken"
            ],
            "optional": false,
            "field": "authorization",
            "description": "<p>Bearer Token requerido para la autorizacion</p>"
          }
        ]
      }
    }
  },
  {
    "type": "get",
    "url": "/geofences/:id/devices",
    "title": "Dispositivos de la geocerca",
    "name": "GetGeofenceDevices",
    "group": "Geocercas",
    "description": "<p>Obtiene la lista de dispositivos de la geocerca</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "id",
            "description": "<p>ID de la geocerca</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "array",
            "optional": false,
            "field": "devices[]",
            "description": "<p>arreglo que contiene objetos con la informacion del dispositivo</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "device.geofenceID",
            "description": "<p>ID de la geocerca</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "device.deviceID",
            "description": "<p>ID del dispositivo</p>"
          },
          {
            "group": "Success 200",
            "type": "string",
            "optional": false,
            "field": "device.deviceImei",
            "description": "<p>Imei del dispositivo</p>"
          },
          {
            "group": "Success 200",
            "type": "string",
            "optional": false,
            "field": "device.deviceAlias",
            "description": "<p>Alias del dispositivo</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "SuccessExample",
          "content": "{\"success\":true,\"statusCode\":200,\"pagination\":{\"self\":\"\",\"next\":\"\",\"prev\":\"\"},\"data\":{\"devices\":[{\"geofenceID\":\"53\",\"deviceID\":\"48\",\"deviceImei\":\"0003\",\"deviceAlias\":\"Disp Prueba 3\"},{\"geofenceID\":\"53\",\"deviceID\":\"45\",\"deviceImei\":\"0001\",\"deviceAlias\":\"Disp Prueba\"}]}}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "apidoc/geofences.php",
    "groupTitle": "Geocercas",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "string",
            "allowedValues": [
              "JsonWebToken"
            ],
            "optional": false,
            "field": "authorization",
            "description": "<p>Bearer Token requerido para la autorizacion</p>"
          }
        ]
      }
    }
  },
  {
    "type": "get",
    "url": "/geofences/:id/subscribers/emails",
    "title": "Correos suscritos a la geocerca",
    "name": "GetGeofenceEmailSubscribers",
    "group": "Geocercas",
    "description": "<p>Obtiene la lista de correos electronicos suscritos a las notificaciones de la geocerca</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "id",
            "description": "<p>ID de la geocerca</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "geofenceID",
            "description": "<p>ID de la geocerca</p>"
          },
          {
            "group": "Success 200",
            "type": "array",
            "optional": false,
            "field": "emailSubscribers[]",
            "description": "<p>arreglo que contiene los correos suscritos a la geocerca</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "email.id",
            "description": "<p>ID del correo suscrito a la geocerca</p>"
          },
          {
            "group": "Success 200",
            "type": "string",
            "optional": false,
            "field": "email.correo",
            "description": "<p>correo electronico suscrito a la geocerca</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "SuccessExample",
          "content": "{\"success\":true,\"statusCode\":200,\"pagination\":{\"self\":\"\",\"next\":\"\",\"prev\":\"\"},\"data\":{\"geofenceID\":\"51\",\"emailSubscribers\":[{\"id\":\"2\",\"correo\":\"naviles@globalgps.com.mx\"},{\"id\":\"9\",\"correo\":\"juan.perez@ejemplo.com\"},{\"id\":\"10\",\"correo\":\"ejimenez@globalgps.com.mx\"},{\"id\":\"11\",\"correo\":\"martinez@ejemplo.com\"}]}}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "apidoc/geofences.php",
    "groupTitle": "Geocercas",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "string",
            "allowedValues": [
              "JsonWebToken"
            ],
            "optional": false,
            "field": "authorization",
            "description": "<p>Bearer Token requerido para la autorizacion</p>"
          }
        ]
      }
    }
  },
  {
    "type": "get",
    "url": "/geofences",
    "title": "Obtener Lista de Geocercas",
    "name": "GetGeofences",
    "group": "Geocercas",
    "description": "<p>Obtiene la lista de geocercas o puntos de interes</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "allowedValues": [
              "1",
              "2"
            ],
            "optional": false,
            "field": "geofenceType",
            "description": "<p>Tipo de geocercas a obtener<br> 1 = Normal <br> 2 = Puntos de interes</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success",
          "content": "{\"success\":true,\"statusCode\":200,\"pagination\":{\"self\":\"\",\"next\":\"\",\"prev\":\"\"},\"data\":{\"geofences\":[{\"id\":\"14\",\"geofenceType\":\"1\",\"behavior\":\"1\",\"figureType\":\"1\",\"name\":\"Circular 441\"},{\"id\":\"17\",\"geofenceType\":\"1\",\"behavior\":\"1\",\"figureType\":\"2\",\"name\":\"Circular 441\"},{\"id\":\"18\",\"geofenceType\":\"1\",\"behavior\":\"1\",\"figureType\":\"2\",\"name\":\"Circular 441\"}]}}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "apidoc/geofences.php",
    "groupTitle": "Geocercas",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "string",
            "allowedValues": [
              "JsonWebToken"
            ],
            "optional": false,
            "field": "authorization",
            "description": "<p>Bearer Token requerido para la autorizacion</p>"
          }
        ]
      }
    }
  },
  {
    "type": "get",
    "url": "/geofences/:id/devices/near",
    "title": "Dispositivos Cercanos a POI",
    "name": "GetGeofencesDevicesNear",
    "group": "Geocercas",
    "description": "<p>Obtiene los dispositivos cercanos a un punto de interes</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "id",
            "description": "<p>ID de la geocerca</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "maxDistance",
            "description": "<p>Distancia maxima en metros, entre un dispositivo y el centro del punto de interes</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "object",
            "optional": false,
            "field": "position",
            "description": "<p>Contiene las coordenas del punto de interes</p>"
          },
          {
            "group": "Success 200",
            "type": "double",
            "optional": false,
            "field": "position.lat",
            "description": "<p>latitud del punto de interes</p>"
          },
          {
            "group": "Success 200",
            "type": "double",
            "optional": false,
            "field": "position.lng",
            "description": "<p>longitud del punto de interes</p>"
          },
          {
            "group": "Success 200",
            "type": "array",
            "optional": false,
            "field": "devices",
            "description": "<p>Arreglo que contiene objetos dispositivo</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "device.id",
            "description": "<p>ID del dispositivo</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "device.clientID",
            "description": "<p>ID del usuario al que pertenece el dispositivo</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "device.markerType",
            "description": "<p>ID del tipo de marcador</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "device.distance",
            "description": "<p>Distancia en metros entre la ubicacion del dispositivo y el punto de interes</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "SuccessExample",
          "content": "{\"success\":true,\"statusCode\":200,\"pagination\":{\"self\":\"\",\"next\":\"\",\"prev\":\"\"},\"data\":{\"position\":{\"lat\":\"19.36253536792485\",\"lng\":\"-99.18309526237994\"},\"devices\":[{\"id\":\"19\",\"clientID\":\"42\",\"markerType\":\"4\",\"markerName\":\"DIGGER\",\"imei\":\"008703929\",\"alias\":\"KZ-47-945\",\"lat\":\"19.356496\",\"lng\":\"-99.156372\",\"address\":\"Privada Corina 35, Del Carmen, Coyoacan, Ciudad de Mexico, 04100, MEX\",\"timestampReport\":\"1550386668\",\"distance\":2882.78},{\"id\":\"46\",\"clientID\":\"42\",\"markerType\":\"1\",\"markerName\":\"DEFAULT\",\"imei\":\"008748872\",\"alias\":\"Laboratorio Siccob\",\"lat\":\"19.36233\",\"lng\":\"-99.183401\",\"address\":\"\",\"timestampReport\":\"1557957660\",\"distance\":39.37}]}}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "apidoc/geofences.php",
    "groupTitle": "Geocercas",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "string",
            "allowedValues": [
              "JsonWebToken"
            ],
            "optional": false,
            "field": "authorization",
            "description": "<p>Bearer Token requerido para la autorizacion</p>"
          }
        ]
      }
    }
  },
  {
    "type": "post",
    "url": "/geofences/:id/devices/:deviceID",
    "title": "Vincular dispositivo a geocerca",
    "name": "PostDeviceToGeofence",
    "group": "Geocercas",
    "description": "<p>Vincula un dispositivo gps con una geocerca</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "id",
            "description": "<p>ID de la geocerca</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "deviceID",
            "description": "<p>id del dispositivo gps a vincular</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "SuccessExample",
          "content": "{\"success\":true,\"statusCode\":201,\"data\":[]}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "apidoc/geofences.php",
    "groupTitle": "Geocercas",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "string",
            "allowedValues": [
              "JsonWebToken"
            ],
            "optional": false,
            "field": "authorization",
            "description": "<p>Bearer Token requerido para la autorizacion</p>"
          }
        ]
      }
    }
  },
  {
    "type": "post",
    "url": "/geofences/:id/subscribers/emails",
    "title": "Agregar correo suscriptor a la geocerca",
    "name": "PostGeofenceEmailSubscriber",
    "group": "Geocercas",
    "description": "<p>Agrega un correo suscriptor a las notificaciones de la geocerca</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "id",
            "description": "<p>ID de la geocerca</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "email",
            "description": "<p>correo que se suscribira a las notificaciones de la geocerca</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Request-Example:",
          "content": "{\"email\": \"martinez@ejemplo.com\" }",
          "type": "json"
        }
      ]
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "emailID",
            "description": "<p>ID del correo suscrito a la geocerca</p>"
          },
          {
            "group": "Success 200",
            "type": "string",
            "optional": false,
            "field": "email",
            "description": "<p>correo suscrito a la geocerca</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "SuccessExample",
          "content": "{\"success\":true,\"statusCode\":201,\"data\":{\"email\":\"martinez@ejemplo.com\",\"emailID\":\"12\"}}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "apidoc/geofences.php",
    "groupTitle": "Geocercas",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "string",
            "allowedValues": [
              "JsonWebToken"
            ],
            "optional": false,
            "field": "authorization",
            "description": "<p>Bearer Token requerido para la autorizacion</p>"
          }
        ]
      }
    }
  },
  {
    "type": "post",
    "url": "/geofences",
    "title": "Crear Geocerca",
    "name": "PostGeofences",
    "group": "Geocercas",
    "description": "<p>Crea un nuevo registro de geocerca o punto de interes</p>",
    "version": "0.0.0",
    "filename": "apidoc/geofences.php",
    "groupTitle": "Geocercas",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "string",
            "allowedValues": [
              "JsonWebToken"
            ],
            "optional": false,
            "field": "authorization",
            "description": "<p>Bearer Token requerido para la autorizacion</p>"
          }
        ]
      }
    },
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "json",
            "optional": false,
            "field": "geofence",
            "description": "<p>objeto que contiene la informacion de la geocerca <br><br> <b style=\"color:red\">Importante</b>: El objeto debe ser proporcionado en el body / data de la peticion y no como un parametro</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "allowedValues": [
              "1",
              "2"
            ],
            "optional": false,
            "field": "geofence.geofenceType",
            "description": "<p>Tipo de geocerca a registrar: <br> 1 = Geocerca <br> 2 = Punto de interes</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "allowedValues": [
              "1",
              "2"
            ],
            "optional": false,
            "field": "geofence.figureType",
            "description": "<p>Tipo de figura a registrar: <br> 1 = Circular <br> 2 = Poligonal</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "allowedValues": [
              "1",
              "2",
              "3"
            ],
            "optional": false,
            "field": "geofence.behavior",
            "description": "<p>Comportamiento para la geocerca <br> 1 = Entradas <br> 2 = Salidas <br> 3 = Ambos</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "geofence.name",
            "description": "<p>Nombre que llevara la geocerca</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "geofence.radio",
            "description": "<p>Radio de la geocerca (en metros)</p>"
          },
          {
            "group": "Parameter",
            "type": "array",
            "optional": false,
            "field": "geofence.coords",
            "description": "<p>Conjunto de coordenadas que definen al objeto (para la geocerca circular solo es requerido un item en el arreglo)</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Ejemplo-Circular",
          "content": "{\"geofenceType\":1,\"figureType\":1,\"behavior\":1,\"name\":\"Geocerca 1\",\"radio\":10,\"coords\":[{\"lat\":123,\"lng\":456}]}",
          "type": "json"
        },
        {
          "title": "Ejemplo-Polygon",
          "content": "{\"geofenceType\":1,\"figureType\":2,\"behavior\":3,\"name\":\"Geocerca Polygon 1\",\"coords\":[{\"lat\":123,\"lng\":456},{\"lat\":123,\"lng\":789},{\"lat\":123,\"lng\":12345},{\"lat\":789,\"lng\":456}]}",
          "type": "json"
        }
      ]
    },
    "success": {
      "examples": [
        {
          "title": "Success",
          "content": "{\"success\":true,\"statusCode\":201,\"pagination\":{\"self\":\"\",\"next\":\"\",\"prev\":\"\"},\"data\":[]}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "put",
    "url": "/geofences/:id/behavior/:behavior",
    "title": "Actualizar comportamiento de geocerca",
    "name": "PutGeofenceBehavior",
    "group": "Geocercas",
    "description": "<p>Actualiza el comportamiento de una geocerca</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "id",
            "description": "<p>ID de la geocerca</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "allowedValues": [
              "1",
              "2",
              "3"
            ],
            "optional": false,
            "field": "behavior",
            "description": "<p>tipo de comportamiento</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "SuccessExample",
          "content": "{\"success\":true,\"statusCode\":200,\"pagination\":{\"self\":\"\",\"next\":\"\",\"prev\":\"\"},\"data\":[]}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "apidoc/geofences.php",
    "groupTitle": "Geocercas",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "string",
            "allowedValues": [
              "JsonWebToken"
            ],
            "optional": false,
            "field": "authorization",
            "description": "<p>Bearer Token requerido para la autorizacion</p>"
          }
        ]
      }
    }
  },
  {
    "type": "put",
    "url": "/geofences/:id",
    "title": "Editar Geocerca",
    "name": "PutGeofences",
    "group": "Geocercas",
    "description": "<p>Edita un registro de geocerca o punto de interes</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "json",
            "optional": false,
            "field": "geofence",
            "description": "<p>objeto que contiene la informacion de la geocerca <br><br> <b style=\"color:red\">Importante</b>: El objeto debe ser proporcionado en el body / data de la peticion y no como un parametro <br><b style=\"color:blue\">Nota</b>: El objeto debe ser proporcionado con todos los valores incluyendo los que no fueron modificados, es decir si, por ejemplo, el parametro geofence.behavior no fue modificado, esté debera ir con el valor actual.</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "id",
            "description": "<p>ID de la geocerca</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "allowedValues": [
              "1",
              "2",
              "3"
            ],
            "optional": false,
            "field": "geofence.behavior",
            "description": "<p>Comportamiento para la geocerca <br> 1 = Entradas <br> 2 = Salidas <br> 3 = Ambos</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "geofence.name",
            "description": "<p>Nombre que llevara la geocerca</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "geofence.radio",
            "description": "<p>Radio de la geocerca (en metros)</p>"
          },
          {
            "group": "Parameter",
            "type": "array",
            "optional": false,
            "field": "geofence.coords",
            "description": "<p>Conjunto de coordenadas que definen al objeto (para la geocerca circular solo es requerido un item en el arreglo)</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Ejemplo-Circular",
          "content": "{\"behavior\":1,\"name\":\"Geocerca 1\",\"radio\":10,\"coords\":[{\"lat\":123,\"lng\":456}]}",
          "type": "json"
        },
        {
          "title": "Ejemplo-Polygon",
          "content": "{\"behavior\":3,\"name\":\"Geocerca Polygon 1\",\"coords\":[{\"lat\":123,\"lng\":456},{\"lat\":123,\"lng\":789},{\"lat\":123,\"lng\":12345},{\"lat\":789,\"lng\":456}]}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "apidoc/geofences.php",
    "groupTitle": "Geocercas",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "string",
            "allowedValues": [
              "JsonWebToken"
            ],
            "optional": false,
            "field": "authorization",
            "description": "<p>Bearer Token requerido para la autorizacion</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success",
          "content": "{\"success\":true,\"statusCode\":200,\"pagination\":{\"self\":\"\",\"next\":\"\",\"prev\":\"\"},\"data\":[]}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "delete",
    "url": "/kits/:id",
    "title": "Eliminar Kit",
    "name": "DeleteKit",
    "group": "Kits",
    "description": "<p>Elimina el kit</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "id",
            "description": "<p>ID del kit a eliminar</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "apidoc/kit.php",
    "groupTitle": "Kits",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "string",
            "allowedValues": [
              "JsonWebToken"
            ],
            "optional": false,
            "field": "authorization",
            "description": "<p>Bearer Token requerido para la autorizacion</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success",
          "content": "{\"success\":true,\"statusCode\":200,\"pagination\":{\"self\":\"\",\"next\":\"\",\"prev\":\"\"},\"data\":[]}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "get",
    "url": "/kits/:id",
    "title": "Informacion del Kit",
    "name": "GetKit",
    "group": "Kits",
    "description": "<p>Obtiene la informacion del kit</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "id",
            "description": "<p>ID del kit a consultar</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "object",
            "optional": false,
            "field": "kit",
            "description": "<p>Objecto que contiene la informacion del kit</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "kit.id",
            "description": "<p>ID del kit</p>"
          },
          {
            "group": "Success 200",
            "type": "string",
            "optional": false,
            "field": "kit.kitName",
            "description": "<p>Nombre del kit</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "kit.clientID",
            "description": "<p>ID del cliente propietario del kit</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "kit.creationTimestamp",
            "description": "<p>Fecha en Unix timestamp de registro del kit</p>"
          },
          {
            "group": "Success 200",
            "type": "string",
            "optional": false,
            "field": "kit.notes",
            "description": "<p>Notas del kit</p>"
          },
          {
            "group": "Success 200",
            "type": "array",
            "optional": false,
            "field": "products",
            "description": "<p>Arreglo que contiene los productos que componen la plantilla kitW</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "product.id",
            "description": "<p>ID del registro del detalle de la plantilla</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "product.productTypeID",
            "description": "<p>Tipo de producto</p>"
          },
          {
            "group": "Success 200",
            "type": "string",
            "optional": false,
            "field": "product.productType",
            "description": "<p>Tipo de producto</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "product.modelID",
            "description": "<p>Modelo del producto</p>"
          },
          {
            "group": "Success 200",
            "type": "string",
            "optional": false,
            "field": "product.model",
            "description": "<p>Modelo del producto</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "product.factoryID",
            "description": "<p>Marca del producto</p>"
          },
          {
            "group": "Success 200",
            "type": "string",
            "optional": false,
            "field": "product.factory",
            "description": "<p>Marca del producto</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "product.quantity",
            "description": "<p>Cantidad de elementos del producto</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Example ",
          "content": "{\"success\":true,\"statusCode\":200,\"pagination\":{\"self\":\"\",\"next\":\"\",\"prev\":\"\"},\"data\":{\"kit\":{\"id\":\"17\",\"kitName\":\"Kit Prueba\",\"clientID\":\"2\",\"creationTimestamp\":\"1577822804\",\"notes\":\"Kit Inicial notas\",\"products\":[{\"id\":\"13\",\"productTypeID\":\"1\",\"productType\":\"DISPOSITIVO GPS\",\"modelID\":\"2\",\"model\":\"IOS\",\"factoryID\":\"2\",\"factory\":\"SMARTPHONE\",\"quantity\":\"2\"},{\"id\":\"14\",\"productTypeID\":\"3\",\"productType\":\"GENERICO\",\"modelID\":\"5\",\"model\":\"ST640LC\",\"factoryID\":\"3\",\"factory\":\"SUNTECH\",\"quantity\":\"3\"}]}}}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "apidoc/kit.php",
    "groupTitle": "Kits",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "string",
            "allowedValues": [
              "JsonWebToken"
            ],
            "optional": false,
            "field": "authorization",
            "description": "<p>Bearer Token requerido para la autorizacion</p>"
          }
        ]
      }
    }
  },
  {
    "type": "get",
    "url": "/kits",
    "title": "Lista de Kits",
    "name": "GetKits",
    "group": "Kits",
    "description": "<p>Obtiene la lista de kits</p>",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "array",
            "optional": false,
            "field": "kits",
            "description": "<p>Arreglo que contiene los kits del cliente</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "kit.id",
            "description": "<p>ID del kit</p>"
          },
          {
            "group": "Success 200",
            "type": "string",
            "optional": false,
            "field": "kit.kitName",
            "description": "<p>Nombre del kit</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "kit.clientID",
            "description": "<p>ID del cliente propietario del kit</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "kit.creationTimestamp",
            "description": "<p>Fecha en Unix timestamp de registro del kit</p>"
          },
          {
            "group": "Success 200",
            "type": "string",
            "optional": false,
            "field": "kit.notes",
            "description": "<p>Notas del kit</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Example ",
          "content": "{\"success\":true,\"statusCode\":200,\"pagination\":{\"self\":\"\",\"next\":\"\",\"prev\":\"\"},\"data\":{\"kits\":[{\"id\":\"16\",\"kitName\":\"Nuevo nombre\",\"clientID\":\"2\",\"creationTimestamp\":\"1577822754\",\"notes\":\"nuevas notas 1024\"},{\"id\":\"17\",\"kitName\":\"Kit Prueba\",\"clientID\":\"2\",\"creationTimestamp\":\"1577822804\",\"notes\":\"Kit Inicial notas\"},{\"id\":\"18\",\"kitName\":\"StarterPak\",\"clientID\":\"2\",\"creationTimestamp\":\"1578337469\",\"notes\":\"paquete inicial\"}]}}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "apidoc/kit.php",
    "groupTitle": "Kits",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "string",
            "allowedValues": [
              "JsonWebToken"
            ],
            "optional": false,
            "field": "authorization",
            "description": "<p>Bearer Token requerido para la autorizacion</p>"
          }
        ]
      }
    }
  },
  {
    "type": "post",
    "url": "/kits",
    "title": "Registrar Kit",
    "name": "PostKit",
    "group": "Kits",
    "description": "<p>Registra una plantilla de kit de productos</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "object",
            "optional": false,
            "field": "kit",
            "description": "<p>Objeto que contiene la informacion del nuevo kit</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "kit.name",
            "description": "<p>Nombre del kit</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "kit.notes",
            "description": "<p>Notas del kit</p>"
          },
          {
            "group": "Parameter",
            "type": "array",
            "optional": false,
            "field": "products",
            "description": "<p>Arreglo que contiene los productos del kit</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "product.productType",
            "description": "<p>Tipo de producto</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "product.model",
            "description": "<p>Modelo del producto</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "product.quantity",
            "description": "<p>Cantidad de productos de ese modelo especifico</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Request-Example:",
          "content": "{\"kit\":{\"name\":\"StarterPak\",\"notes\":\"paquete inicial\"},\"products\":[{\"productType\":2,\"model\":4,\"quantity\":7},{\"productType\":3,\"model\":2,\"quantity\":7}]}",
          "type": "json"
        }
      ]
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "kitID",
            "description": "<p>ID de la plantilla kit generada</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Example ",
          "content": "{\"success\":true,\"statusCode\":200,\"pagination\":{\"self\":\"\",\"next\":\"\",\"prev\":\"\"},\"data\":{\"kitID\":\"18\"}}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "apidoc/kit.php",
    "groupTitle": "Kits",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "string",
            "allowedValues": [
              "JsonWebToken"
            ],
            "optional": false,
            "field": "authorization",
            "description": "<p>Bearer Token requerido para la autorizacion</p>"
          }
        ]
      }
    }
  },
  {
    "type": "put",
    "url": "/kits/:id",
    "title": "Editar Kit",
    "name": "PutKit",
    "group": "Kits",
    "description": "<p>Actualiza la informacion del kit</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "id",
            "description": "<p>ID del kit a editar</p>"
          },
          {
            "group": "Parameter",
            "type": "object",
            "optional": false,
            "field": "kit",
            "description": "<p>Objeto que contiene la informacion del nuevo kit</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": true,
            "field": "kit.name",
            "description": "<p>Nombre del kit</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": true,
            "field": "kit.notes",
            "description": "<p>Notas del kit</p>"
          },
          {
            "group": "Parameter",
            "type": "array",
            "optional": false,
            "field": "products",
            "description": "<p>Arreglo que contiene los productos del kit <br><br><b>NOTA IMPORTANTE </b> La funcion actualizara la lista de productos de la plantilla basado en el contenido proporcionado, si el arreglo se manda vacio. se entiende que la plantilla esta vacia, asi pues si se quieren conservar los productos existentes en la plantilla deveran volver a enviarse junto a esta peticion</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "product.productType",
            "description": "<p>Tipo de producto</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "product.model",
            "description": "<p>Modelo del producto</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "product.quantity",
            "description": "<p>Cantidad de productos de ese modelo especifico</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Example",
          "content": "{\"kit\":{\"name\":\"Nuevo nombre\"},\"products\":[{\"productType\":2,\"model\":4,\"quantity\":7},{\"productType\":3,\"model\":2,\"quantity\":7}]}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "apidoc/kit.php",
    "groupTitle": "Kits",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "string",
            "allowedValues": [
              "JsonWebToken"
            ],
            "optional": false,
            "field": "authorization",
            "description": "<p>Bearer Token requerido para la autorizacion</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success",
          "content": "{\"success\":true,\"statusCode\":200,\"pagination\":{\"self\":\"\",\"next\":\"\",\"prev\":\"\"},\"data\":[]}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "delete",
    "url": "/products/generic/:id",
    "title": "Eliminar producto",
    "name": "DeleteProduct",
    "group": "Productos",
    "description": "<p>Elimina un producto del almacen</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "id",
            "description": "<p>ID del producto eliminar</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "apidoc/products.php",
    "groupTitle": "Productos",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "string",
            "allowedValues": [
              "JsonWebToken"
            ],
            "optional": false,
            "field": "authorization",
            "description": "<p>Bearer Token requerido para la autorizacion</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success",
          "content": "{\"success\":true,\"statusCode\":200,\"pagination\":{\"self\":\"\",\"next\":\"\",\"prev\":\"\"},\"data\":[]}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "get",
    "url": "/products/generic/:id",
    "title": "Informacion de producto",
    "name": "GetProduct",
    "group": "Productos",
    "description": "<p>Obtiene la informacion de un producto</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "id",
            "description": "<p>ID del producto a consultar</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Example ",
          "content": "{\"success\":true,\"statusCode\":200,\"pagination\":{\"self\":\"\",\"next\":\"\",\"prev\":\"\"},\"data\":{\"product\":{\"id\":\"7\",\"clientID\":\"3\",\"serial\":\"XBRKL2\",\"factoryID\":\"4\",\"modelID\":\"8\",\"factoryName\":\"LOGITECH\",\"modelName\":\"LG58SX\",\"productStatusID\":\"1\",\"productStatusName\":\"PAGADO\",\"notes\":\"version editado 2\",\"creationTimestamp\":\"1577140095\"}}}",
          "type": "json"
        }
      ],
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "object",
            "optional": false,
            "field": "product",
            "description": "<p>Objeto que contiene la informacion del producto consultado</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "product.id",
            "description": "<p>ID del producto</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "product.clientID",
            "description": "<p>ID del propietario del producto</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "product.serial",
            "description": "<p>Serie o ID del producto</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "product.factoryID",
            "description": "<p>ID de la marca del producto</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "product.modelID",
            "description": "<p>ID del modelo del producto</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "product.factoryName",
            "description": "<p>Marca del producto</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "product.modelName",
            "description": "<p>Modelo del producto</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "product.productStatusID",
            "description": "<p>ID del estado del producto</p>"
          },
          {
            "group": "Success 200",
            "type": "string",
            "optional": false,
            "field": "product.productStatusName",
            "description": "<p>Estado del producto</p>"
          },
          {
            "group": "Success 200",
            "type": "string",
            "optional": false,
            "field": "product.notes",
            "description": "<p>Notas adicionales</p>"
          },
          {
            "group": "Success 200",
            "type": "long",
            "optional": false,
            "field": "product.creationTimestamp",
            "description": "<p>Fecha de registro del producto</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "apidoc/products.php",
    "groupTitle": "Productos",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "string",
            "allowedValues": [
              "JsonWebToken"
            ],
            "optional": false,
            "field": "authorization",
            "description": "<p>Bearer Token requerido para la autorizacion</p>"
          }
        ]
      }
    }
  },
  {
    "type": "get",
    "url": "/products/generic",
    "title": "Lista de productos",
    "name": "GetProducts",
    "group": "Productos",
    "description": "<p>Obtiene la lista de productos del almacen de un cliente / cuenta</p>",
    "success": {
      "examples": [
        {
          "title": "Success-Example ",
          "content": "{\"success\":true,\"statusCode\":200,\"pagination\":{\"self\":\"\",\"next\":\"\",\"prev\":\"\"},\"data\":{\"products\":[{\"id\":\"9\",\"clientID\":\"2\",\"serial\":\"K5GDJSWE\",\"factoryID\":\"4\",\"modelID\":\"8\",\"factoryName\":\"LOGITECH\",\"modelName\":\"LG58SX\",\"productStatusID\":\"1\",\"productStatusName\":\"PAGADO\",\"notes\":\"alguna nota\",\"creationTimestamp\":\"1577394955\"},{\"id\":\"10\",\"clientID\":\"2\",\"serial\":\"KFHRDC\",\"factoryID\":\"5\",\"modelID\":\"9\",\"factoryName\":\"TESLA\",\"modelName\":\"SF35\",\"productStatusID\":\"1\",\"productStatusName\":\"PAGADO\",\"notes\":\"alguna nota\",\"creationTimestamp\":\"1577394959\"}]}}",
          "type": "json"
        }
      ],
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "object[]",
            "optional": false,
            "field": "products",
            "description": "<p>Arreglo que contiene objectos Producto</p>"
          },
          {
            "group": "Success 200",
            "type": "object",
            "optional": false,
            "field": "product",
            "description": "<p>objecto que representa un producto</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "product.id",
            "description": "<p>ID del producto</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "product.clientID",
            "description": "<p>ID del propietario del producto</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "product.serial",
            "description": "<p>Serie o ID del producto</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "product.factoryID",
            "description": "<p>ID de la marca del producto</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "product.modelID",
            "description": "<p>ID del modelo del producto</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "product.factoryName",
            "description": "<p>Marca del producto</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "product.modelName",
            "description": "<p>Modelo del producto</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "product.productStatusID",
            "description": "<p>ID del estado del producto</p>"
          },
          {
            "group": "Success 200",
            "type": "string",
            "optional": false,
            "field": "product.productStatusName",
            "description": "<p>Estado del producto</p>"
          },
          {
            "group": "Success 200",
            "type": "string",
            "optional": false,
            "field": "product.notes",
            "description": "<p>Notas adicionales</p>"
          },
          {
            "group": "Success 200",
            "type": "long",
            "optional": false,
            "field": "product.creationTimestamp",
            "description": "<p>Fecha de registro del producto</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "apidoc/products.php",
    "groupTitle": "Productos",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "string",
            "allowedValues": [
              "JsonWebToken"
            ],
            "optional": false,
            "field": "authorization",
            "description": "<p>Bearer Token requerido para la autorizacion</p>"
          }
        ]
      }
    }
  },
  {
    "type": "post",
    "url": "/products/generic",
    "title": "Registrar producto",
    "name": "PostProducts",
    "group": "Productos",
    "description": "<p>Registra una nuevo producto en el almacen</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "object",
            "optional": false,
            "field": "product",
            "description": "<p>Objeto que contiene la informacion del nuevo producto</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": true,
            "field": "product.clientID",
            "description": "<p>ID del cliente al que se le asignara el producto, si no se proporciona se asignara al cliente del token actual</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "product.model",
            "description": "<p>Modelo del producto</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "product.productStatus",
            "description": "<p>Estado de adquision del producto</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "product.serial",
            "description": "<p>ID o numero serial Unico para la identificacion del producto</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": true,
            "field": "product.notes",
            "description": "<p>Notas adicionales</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Request-Example:",
          "content": "{\"product\":{\"model\":6,\"productStatus\":1,\"notes\":\"producto chino\",\"serial\":\"DKHLK\"}}",
          "type": "json"
        }
      ]
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "productID",
            "description": "<p>ID del producto registrado</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Example ",
          "content": "{\"success\":true,\"statusCode\":200,\"pagination\":{\"self\":\"\",\"next\":\"\",\"prev\":\"\"},\"data\":{\"productID\":\"12\"}}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "apidoc/products.php",
    "groupTitle": "Productos",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "string",
            "allowedValues": [
              "JsonWebToken"
            ],
            "optional": false,
            "field": "authorization",
            "description": "<p>Bearer Token requerido para la autorizacion</p>"
          }
        ]
      }
    }
  },
  {
    "type": "put",
    "url": "/products/generic/:id",
    "title": "Actualizar producto",
    "name": "UpdateProduct",
    "group": "Productos",
    "description": "<p>Actualiza los datos de un producto</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "id",
            "description": "<p>ID del producto a actualizar</p>"
          },
          {
            "group": "Parameter",
            "type": "object",
            "optional": false,
            "field": "product",
            "description": "<p>Objeto que contiene la informacion del producto</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": true,
            "field": "product.serial",
            "description": "<p>Nuevo Serial o ID del producto <br><b>NOTA:</b>Solo podra actualizar este campo el nuevo serial no esta registrado</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": true,
            "field": "product.model",
            "description": "<p>Modelo del producto</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": true,
            "field": "product.productStatus",
            "description": "<p>Estado del Producto</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": true,
            "field": "product.notes",
            "description": "<p>Notas adicionales</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Request-Example:",
          "content": "{\"product\":{\"model\":7,\"productStatus\":1,\"notes\":\"Nueva nota\",\"serial\":\"DKHLKA\"}}",
          "type": "json"
        },
        {
          "title": "Request-Example 2:",
          "content": "{\"product\":{\"model\":7,\"productStatus\":1}}",
          "type": "json"
        },
        {
          "title": "Request-Example 3:",
          "content": "{\"product\":{\"notes\":\"Nueva nota\"}}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "apidoc/products.php",
    "groupTitle": "Productos",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "string",
            "allowedValues": [
              "JsonWebToken"
            ],
            "optional": false,
            "field": "authorization",
            "description": "<p>Bearer Token requerido para la autorizacion</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success",
          "content": "{\"success\":true,\"statusCode\":200,\"pagination\":{\"self\":\"\",\"next\":\"\",\"prev\":\"\"},\"data\":[]}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "get",
    "url": "/reports/geofences",
    "title": "Reporte de Geocercas",
    "name": "GetGeofenceReport",
    "group": "Reportes",
    "description": "<p>Obtiene el reporte de geocercas</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "deviceID",
            "description": "<p>id del dispositivo</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "allowedValues": [
              "asc",
              "desc"
            ],
            "optional": true,
            "field": "order",
            "description": "<p>orden de los resultados (ascendetes o descendentes)</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": true,
            "field": "limit",
            "defaultValue": "300",
            "description": "<p>limite de resultados<br> <b>NOTA:</b> Si el valor es 0 entregara todos los resultados</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": true,
            "field": "fromTimestamp",
            "defaultValue": "today midnight",
            "description": "<p>Fecha inicial del reporte, si no se proporciona</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": true,
            "field": "tillTimestamp",
            "description": "<p>Fecha final del reporte.</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "allowedValues": [
              "1",
              "2"
            ],
            "optional": true,
            "field": "behavior",
            "description": "<p>Comportamiento. Filtro que permite obtener solo resultados de entradas o salidas.<br> 1 = ENTRADAS<br> 2 = SALIDAS</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": true,
            "field": "geofenceID",
            "description": "<p>ID de geocerca. Filtro que permite obtener solo reportes de una geocerca especifica.</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": true,
            "field": "paginationToken",
            "description": "<p>Token que sera utilizado para avanzar o retroseder en la paginacion.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "object[]",
            "optional": false,
            "field": "reports",
            "description": "<p>Arreglo que contiene reportes</p>"
          },
          {
            "group": "Success 200",
            "type": "object",
            "optional": false,
            "field": "report",
            "description": "<p>objeto que contiene la informacion de un reporte</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "report.id",
            "description": "<p>ID de la notificacion</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "report.timestamp",
            "description": "<p>Timestamp de la notificacion</p>"
          },
          {
            "group": "Success 200",
            "type": "string",
            "optional": false,
            "field": "report.behaviorID",
            "description": "<p>Tipo de comportamiento</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "report.behaviorString",
            "description": "<p>Tipo de comportamiento en formato string</p>"
          },
          {
            "group": "Success 200",
            "type": "string",
            "optional": false,
            "field": "report.geofenceType",
            "description": "<p>Tipo (geocerca o punto de interes)</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "report.geofenceString",
            "description": "<p>Tipo (geocerca o punto de interes) en formato string</p>"
          },
          {
            "group": "Success 200",
            "type": "string",
            "optional": false,
            "field": "report.geofenceID",
            "description": "<p>ID de la geocerca</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "report.geofenceNamee",
            "description": "<p>Nombre de la geocerca</p>"
          },
          {
            "group": "Success 200",
            "type": "double",
            "optional": false,
            "field": "report.reportID",
            "description": "<p>ID del reporte (reporte del dispositivo) que activo la alerta</p>"
          },
          {
            "group": "Success 200",
            "type": "double",
            "optional": false,
            "field": "report.lat",
            "description": "<p>Latitud del dispositivo cuando se genero la notificacion</p>"
          },
          {
            "group": "Success 200",
            "type": "string",
            "optional": false,
            "field": "report.lng",
            "description": "<p>Longitud del dispositivo cuando se genero la notificacion</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "report.address",
            "description": "<p>Direccion donde se encontraba el dispositivo cuando se genero la notificacion</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "report.deviceID",
            "description": "<p>ID del dispositivo</p>"
          },
          {
            "group": "Success 200",
            "type": "string",
            "optional": false,
            "field": "report.deviceImei",
            "description": "<p>Imei del dispositivo</p>"
          },
          {
            "group": "Success 200",
            "type": "object",
            "optional": false,
            "field": "report.deviceAlias",
            "description": "<p>Alias del dispositivo</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Example ",
          "content": "{\"success\":true,\"statusCode\":200,\"pagination\":{\"self\":\"Tzo4OiJzdGRDbGFzcyI6ODp7czoxMDoiZGV2aWNlSW1laSI7czo0OiIwMDAxIjtzOjEzOiJmcm9tVGltZXN0YW1wIjtzOjEwOiIxNTY2NTg3MTU3IjtzOjEzOiJ0aWxsVGltZXN0YW1wIjtOO3M6NToib3JkZXIiO047czo1OiJsaW1pdCI7aTozMDA7czo4OiJiZWhhdmlvciI7TjtzOjEwOiJnZW9mZW5jZUlEIjtzOjI6IjcxIjtzOjEwOiJwYWdpbmF0aW9uIjtpOjA7fQ==\",\"next\":\"\",\"prev\":\"\"},\"data\":{\"reports\":[{\"id\":\"49\",\"timestamp\":\"1566587167\",\"behaviorID\":\"1\",\"behaviorString\":\"IN\",\"geofenceType\":\"1\",\"geofenceTypeString\":\"GEOFENCE\",\"geofenceID\":\"71\",\"geofenceName\":\"Parque Hundido\",\"reportID\":\"556731\",\"lat\":\"19.378077430849\",\"lng\":\"-99.1791200637817\",\"address\":\"Avenida Insurgentes Sur, Tlacoquemecatl, Benito Juarez, Ciudad de Mexico, 03200, MEX\",\"deviceID\":\"45\",\"imei\":\"0001\",\"alias\":\"Disp Prueba\"},{\"id\":\"48\",\"timestamp\":\"1566587161\",\"behaviorID\":\"2\",\"behaviorString\":\"OUT\",\"geofenceType\":\"1\",\"geofenceTypeString\":\"GEOFENCE\",\"geofenceID\":\"71\",\"geofenceName\":\"Parque Hundido\",\"reportID\":\"556730\",\"lat\":\"19.3761746634512\",\"lng\":\"-99.1768455505371\",\"address\":\"Magnolias, Tlacoquemecatl, Benito Juarez, Ciudad de Mexico, 03200, MEX\",\"deviceID\":\"45\",\"imei\":\"0001\",\"alias\":\"Disp Prueba\"},{\"id\":\"47\",\"timestamp\":\"1566587157\",\"behaviorID\":\"1\",\"behaviorString\":\"IN\",\"geofenceType\":\"1\",\"geofenceTypeString\":\"GEOFENCE\",\"geofenceID\":\"71\",\"geofenceName\":\"Parque Hundido\",\"reportID\":\"556729\",\"lat\":\"19.3781583991814\",\"lng\":\"-99.1786050796509\",\"address\":\"Avenida Insurgentes Sur, Tlacoquemecatl, Benito Juarez, Ciudad de Mexico, 03200, MEX\",\"deviceID\":\"45\",\"imei\":\"0001\",\"alias\":\"Disp Prueba\"}]}}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "apidoc/reports.php",
    "groupTitle": "Reportes",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "string",
            "allowedValues": [
              "JsonWebToken"
            ],
            "optional": false,
            "field": "authorization",
            "description": "<p>Bearer Token requerido para la autorizacion</p>"
          }
        ]
      }
    }
  },
  {
    "type": "get",
    "url": "/reports/historical",
    "title": "Reporte Historico",
    "name": "GetReportHistorical",
    "group": "Reportes",
    "description": "<p>Obtiene el reporte historico de una unidad</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "deviceID",
            "description": "<p>id del dispositivo</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "allowedValues": [
              "asc",
              "desc"
            ],
            "optional": true,
            "field": "order",
            "description": "<p>orden de los resultados (ascendetes o descendentes)</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": true,
            "field": "limit",
            "defaultValue": "300",
            "description": "<p>limite de resultados<br> <b>NOTA:</b> Si el valor es 0 entregara todos los resultados</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": true,
            "field": "fromTimestamp",
            "defaultValue": "today midnight",
            "description": "<p>Fecha inicial del reporte, si no se proporciona</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": true,
            "field": "tillTimestamp",
            "description": "<p>Fecha final del reporte.</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": true,
            "field": "paginationToken",
            "description": "<p>Token que sera utilizado para avanzar o retroseder en la paginacion.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "object[]",
            "optional": false,
            "field": "reports",
            "description": "<p>Arreglo que contiene reportes</p>"
          },
          {
            "group": "Success 200",
            "type": "object",
            "optional": false,
            "field": "report",
            "description": "<p>objeto que contiene la informacion de un reporte</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "report.timestamp",
            "description": "<p>Timestamp del reporte</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "report.reportTypeString",
            "description": "<p>Tipo de reporte en formato string</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "report.reportType",
            "description": "<p>Tipo de reporte</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "report.lat",
            "description": "<p>Latitud</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "report.lng",
            "description": "<p>Longitud</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "report.address",
            "description": "<p>Direccion</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "report.speed",
            "description": "<p>Velocidad en km/hr</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "report.validPosition",
            "description": "<p>Indica si la posicion era valida</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Example ",
          "content": "{\"success\":true,\"statusCode\":200,\"pagination\":{\"self\":\"Tzo4OiJzdGRDbGFzcyI6Njp7czoxMDoiZGV2aWNlSW1laSI7czo0OiIwMDAxIjtzOjEzOiJmcm9tVGltZXN0YW1wIjtzOjEwOiIxNTY1MzkwMzMwIjtzOjEzOiJ0aWxsVGltZXN0YW1wIjtOO3M6NToib3JkZXIiO3M6MzoiYXNjIjtzOjU6ImxpbWl0IjtzOjE6IjIiO3M6MTA6InBhZ2luYXRpb24iO2k6Njt9\",\"next\":\"Tzo4OiJzdGRDbGFzcyI6Njp7czoxMDoiZGV2aWNlSW1laSI7czo0OiIwMDAxIjtzOjEzOiJmcm9tVGltZXN0YW1wIjtzOjEwOiIxNTY1MzkwMzMwIjtzOjEzOiJ0aWxsVGltZXN0YW1wIjtOO3M6NToib3JkZXIiO3M6MzoiYXNjIjtzOjU6ImxpbWl0IjtzOjE6IjIiO3M6MTA6InBhZ2luYXRpb24iO2k6ODt9\",\"prev\":\"Tzo4OiJzdGRDbGFzcyI6Njp7czoxMDoiZGV2aWNlSW1laSI7czo0OiIwMDAxIjtzOjEzOiJmcm9tVGltZXN0YW1wIjtzOjEwOiIxNTY1MzkwMzMwIjtzOjEzOiJ0aWxsVGltZXN0YW1wIjtOO3M6NToib3JkZXIiO3M6MzoiYXNjIjtzOjU6ImxpbWl0IjtzOjE6IjIiO3M6MTA6InBhZ2luYXRpb24iO2k6NDt9\"},\"data\":{\"reports\":[{\"timestamp\":\"1565390347\",\"reportTypeString\":\"Auto reporte\",\"reportType\":\"1001\",\"lat\":\"19.3764681768931\",\"lng\":\"-99.1780579090118\",\"address\":\"Metrobus 1, Tlacoquemecatl, Benito Juarez, Ciudad de Mexico, 03200, MEX\",\"speed\":\"0.296\",\"validPosition\":\"0\"},{\"timestamp\":\"1565390348\",\"reportTypeString\":\"Auto reporte\",\"reportType\":\"1001\",\"lat\":\"19.3760430882883\",\"lng\":\"-99.1770601272583\",\"address\":\"Manzanas, Tlacoquemecatl, Benito Juarez, Ciudad de Mexico, 03200, MEX\",\"speed\":\"0.296\",\"validPosition\":\"0\"}]}}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "apidoc/reports.php",
    "groupTitle": "Reportes",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "string",
            "allowedValues": [
              "JsonWebToken"
            ],
            "optional": false,
            "field": "authorization",
            "description": "<p>Bearer Token requerido para la autorizacion</p>"
          }
        ]
      }
    }
  },
  {
    "type": "get",
    "url": "/transactions/:id",
    "title": "Informacion de transaccion",
    "name": "GetTransaction",
    "group": "Transacciones",
    "description": "<p>Obtiene las transacciones realizadas</p>",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "object",
            "optional": false,
            "field": "transaction",
            "description": "<p>Contiene los datos de la transaccion</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "transaction.id",
            "description": "<p>ID de la transaccion</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "transaction.fromClientID",
            "description": "<p>ID del cliente que realiza la transaccion</p>"
          },
          {
            "group": "Success 200",
            "type": "string",
            "optional": false,
            "field": "transaction.fromClient",
            "description": "<p>Nombre del cliente que realiza la transaccion</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "transaction.toClientID",
            "description": "<p>ID del cliente involucrado en la transaccion</p>"
          },
          {
            "group": "Success 200",
            "type": "string",
            "optional": false,
            "field": "transaction.toClient",
            "description": "<p>Nombre del cliente involucrado en la transaccion</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "transaction.transactionTypeID",
            "description": "<p>ID del Tipo de transaccion</p>"
          },
          {
            "group": "Success 200",
            "type": "string",
            "optional": false,
            "field": "transaction.transactionType",
            "description": "<p>Tipo de transaccion</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "transaction.timestampTransaction",
            "description": "<p>Timestamp de la transaccion</p>"
          },
          {
            "group": "Success 200",
            "type": "array",
            "optional": false,
            "field": "transaction.products",
            "description": "<p>Contiene el arreglo de productos involucrados en la transaccion</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "transaction.product.id",
            "description": "<p>ID del producto</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "transaction.product.productTypeID",
            "description": "<p>ID del tipo de producto</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "transaction.product.productType",
            "description": "<p>Tipo de producto</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "transaction.product.productID",
            "description": "<p>ID del producto</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "transaction.product.product",
            "description": "<p>Imei o Serie o Telefono del producto</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "transaction.product.kitID",
            "description": "<p>ID del kit al que pertenece el producto</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "transaction.product.kitName",
            "description": "<p>Nombre del kit al que pertenece el producto</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success",
          "content": "{\"success\":true,\"statusCode\":200,\"pagination\":{\"self\":\"\",\"next\":\"\",\"prev\":\"\"},\"data\":{\"transactions\":[{\"id\":\"39\",\"fromClientID\":\"2\",\"fromClient\":\"gps infinity\",\"toClientID\":\"3\",\"toClient\":\"aviles\",\"transactionTypeID\":\"1\",\"transactionType\":\"VENTA\",\"timestampTransaction\":\"1578507018\"},{\"id\":\"40\",\"fromClientID\":\"2\",\"fromClient\":\"gps infinity\",\"toClientID\":\"3\",\"toClient\":\"aviles\",\"transactionTypeID\":\"1\",\"transactionType\":\"VENTA\",\"timestampTransaction\":\"1578518249\"}]}}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "apidoc/transactions.php",
    "groupTitle": "Transacciones",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "string",
            "allowedValues": [
              "JsonWebToken"
            ],
            "optional": false,
            "field": "authorization",
            "description": "<p>Bearer Token requerido para la autorizacion</p>"
          }
        ]
      }
    }
  },
  {
    "type": "get",
    "url": "/transactions",
    "title": "Obtener transacciones",
    "name": "GetTransactions",
    "group": "Transacciones",
    "description": "<p>Obtiene las transacciones realizadas</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": true,
            "field": "clientID",
            "description": "<p>Filtrar resultados por un cliente especifico</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": true,
            "field": "fromTimestamp",
            "description": "<p>Filtrar resultados desde una fecha especifica</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": true,
            "field": "tillTimestamp",
            "description": "<p>Filtrar resultados hasta una fecha especifica</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "array",
            "optional": false,
            "field": "transactions",
            "description": "<p>Arreglo que contiene las transacciones realizadas</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "transaction.id",
            "description": "<p>ID de la transaccion</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "transaction.fromClientID",
            "description": "<p>ID del cliente que realiza la transaccion</p>"
          },
          {
            "group": "Success 200",
            "type": "string",
            "optional": false,
            "field": "transaction.fromClient",
            "description": "<p>Nombre del cliente que realiza la transaccion</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "transaction.toClientID",
            "description": "<p>ID del cliente involucrado en la transaccion</p>"
          },
          {
            "group": "Success 200",
            "type": "string",
            "optional": false,
            "field": "transaction.toClient",
            "description": "<p>Nombre del cliente involucrado en la transaccion</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "transaction.transactionTypeID",
            "description": "<p>ID del Tipo de transaccion</p>"
          },
          {
            "group": "Success 200",
            "type": "string",
            "optional": false,
            "field": "transaction.transactionType",
            "description": "<p>Tipo de transaccion</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "transaction.timestampTransaction",
            "description": "<p>Timestamp de la transaccion</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success",
          "content": "{\"success\":true,\"statusCode\":200,\"pagination\":{\"self\":\"\",\"next\":\"\",\"prev\":\"\"},\"data\":{\"transactions\":[{\"id\":\"39\",\"fromClientID\":\"2\",\"fromClient\":\"gps infinity\",\"toClientID\":\"3\",\"toClient\":\"aviles\",\"transactionTypeID\":\"1\",\"transactionType\":\"VENTA\",\"timestampTransaction\":\"1578507018\"},{\"id\":\"40\",\"fromClientID\":\"2\",\"fromClient\":\"gps infinity\",\"toClientID\":\"3\",\"toClient\":\"aviles\",\"transactionTypeID\":\"1\",\"transactionType\":\"VENTA\",\"timestampTransaction\":\"1578518249\"}]}}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "apidoc/transactions.php",
    "groupTitle": "Transacciones",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "string",
            "allowedValues": [
              "JsonWebToken"
            ],
            "optional": false,
            "field": "authorization",
            "description": "<p>Bearer Token requerido para la autorizacion</p>"
          }
        ]
      }
    }
  },
  {
    "type": "post",
    "url": "/transactions",
    "title": "Registrar transaccion",
    "name": "PostTransactions",
    "group": "Transacciones",
    "description": "<p>Registra una nueva transaccion</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "object",
            "optional": false,
            "field": "transaction",
            "description": "<p>Objeto que contiene la informacion de la transaccion</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "transaction.clientID",
            "description": "<p>ID del cliente involucrado en la transaccion</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "transaction.transactionType",
            "description": "<p>Tipo de transaccion</p>"
          },
          {
            "group": "Parameter",
            "type": "array",
            "optional": false,
            "field": "products",
            "description": "<p>Arreglo de productos involucrados en la transaccion</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "product.id",
            "description": "<p>ID del producto</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "product.type",
            "description": "<p>Tipo de producto</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Request-Example 1:",
          "content": "{\"transaction\":{\"clientID\":3,\"transactionType\":1},\"products\":[{\"id\":5,\"type\":1},{\"id\":6,\"type\":2,\"kitID\":23},{\"id\":15,\"type\":3,\"kitID\":23}]}",
          "type": "json"
        }
      ]
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "transactionID",
            "description": "<p>ID de la transaccion</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success",
          "content": "{\"success\":true,\"statusCode\":200,\"pagination\":{\"self\":\"\",\"next\":\"\",\"prev\":\"\"},\"data\":{\"transactionID\":\"40\"}}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "apidoc/transactions.php",
    "groupTitle": "Transacciones",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "string",
            "allowedValues": [
              "JsonWebToken"
            ],
            "optional": false,
            "field": "authorization",
            "description": "<p>Bearer Token requerido para la autorizacion</p>"
          }
        ]
      }
    }
  },
  {
    "type": "delete",
    "url": "/transfers/:id",
    "title": "Cancelar Transferencia",
    "name": "DeleteTransfer",
    "group": "Transferencias",
    "description": "<p>Cancela una transferencia o devulucion realizada <b>con estatus pendiente</b></p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "id",
            "description": "<p>ID de la tranferencia a cancelar <br><b>NOTA: </b>Solo se pueden cancelar transferencias o devoluciones que tienen estatus pendiente y que fueron realizadas por el cliente que esta realizando la consulta</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "notes",
            "description": "<p>Razon por la cual se cancela la transferencia</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Request-Example 1:",
          "content": "{{url}}/transfers/43?notes=Los productos involucrados estan incorrectos",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "apidoc/transfers.php",
    "groupTitle": "Transferencias",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "string",
            "allowedValues": [
              "JsonWebToken"
            ],
            "optional": false,
            "field": "authorization",
            "description": "<p>Bearer Token requerido para la autorizacion</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success",
          "content": "{\"success\":true,\"statusCode\":200,\"pagination\":{\"self\":\"\",\"next\":\"\",\"prev\":\"\"},\"data\":[]}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "get",
    "url": "/transfers/:id",
    "title": "Consultar Transferencia",
    "name": "GetTransfer",
    "group": "Transferencias",
    "description": "<p>Consulta los detalles de una transferencia especifica</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "id",
            "description": "<p>ID de la transferencia a consultar</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "object",
            "optional": false,
            "field": "transfer",
            "description": "<p>Objeto que contiene la informacion del la transferencia</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "transfer.id",
            "description": "<p>ID de la transferencia a consultar</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "transfer.fromClientID",
            "description": "<p>ID del cliente que realiza la transferencia</p>"
          },
          {
            "group": "Success 200",
            "type": "string",
            "optional": false,
            "field": "transfer.fromClient",
            "description": "<p>Nombre del cliente que realiza la transferencia</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "transfer.toClientID",
            "description": "<p>ID del cliente que recibe la transferencia</p>"
          },
          {
            "group": "Success 200",
            "type": "string",
            "optional": false,
            "field": "transfer.toClient",
            "description": "<p>Nombre del cliente que recibe la transferencia</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "transfer.typeID",
            "description": "<p>Tipo de transferencia</p>"
          },
          {
            "group": "Success 200",
            "type": "string",
            "optional": false,
            "field": "transfer.type",
            "description": "<p>Tipo de transferencia</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "transfer.stateID",
            "description": "<p>Estado de la transferencia</p>"
          },
          {
            "group": "Success 200",
            "type": "string",
            "optional": false,
            "field": "transfer.state",
            "description": "<p>Estado de la transferencia</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "transfer.creationTimestamp",
            "description": "<p>Fecha en la que se registro la tranferencia</p>"
          },
          {
            "group": "Success 200",
            "type": "string",
            "optional": false,
            "field": "transfer.notes",
            "description": "<p>Notas adicionales</p>"
          },
          {
            "group": "Success 200",
            "type": "array",
            "optional": false,
            "field": "products",
            "description": "<p>Arreglo que contiene los productos involucrados en la transferencia</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "product.transferID",
            "description": "<p>ID de la transferencia</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "product.typeID",
            "description": "<p>Tipo de producto</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "product.type",
            "description": "<p>Tipo de producto</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "product.stateID",
            "description": "<p>Estado de la transferencia</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "product.state",
            "description": "<p>Estado de la transferencia</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "product.productID",
            "description": "<p>ID del producto</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "product.serie",
            "description": "<p>Imei/Serie/Telefono del producto</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "product.factoryID",
            "description": "<p>Marca del producto</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "product.factory",
            "description": "<p>Marca del producto</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "product.modelID",
            "description": "<p>Modelo del producto</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "product.model",
            "description": "<p>Modelos del producto</p>"
          },
          {
            "group": "Success 200",
            "type": "array",
            "optional": false,
            "field": "bitacora",
            "description": "<p>Arreglo que contiene los registros de bitacora realizados en la transferencia</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "bitacora.clientID",
            "description": "<p>ID del cliente</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "bitacora.client",
            "description": "<p>Nombre del cliente</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "bitacora.userID",
            "description": "<p>ID del usuario</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "bitacora.user",
            "description": "<p>Nombre del usuario</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "bitacora.actionID",
            "description": "<p>Accion realizada</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "product.action",
            "description": "<p>Accion realizada</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "product.notes",
            "description": "<p>Notas</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "product.creationTimestamp",
            "description": "<p>Fecha en la que se registro en bitacora</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success",
          "content": "{\"success\":true,\"statusCode\":200,\"pagination\":{\"self\":\"\",\"next\":\"\",\"prev\":\"\"},\"data\":{\"transfer\":{\"id\":\"22\",\"fromClientID\":\"2\",\"fromClient\":\"gps infinity\",\"toClientID\":\"3\",\"toClient\":\"aviles\",\"typeID\":\"1\",\"type\":\"TRANSFERENCIA\",\"stateID\":\"2\",\"state\":\"COMPLETADO\",\"creationTimestamp\":\"1580325037\",\"notes\":\"transferencia de prueba\",\"products\":[{\"transferID\":\"22\",\"typeID\":\"1\",\"type\":\"DISPOSITIVO GPS\",\"stateID\":\"1\",\"state\":\"PENDIENTE\",\"productID\":\"9\",\"serie\":\"0002\",\"factoryID\":\"1\",\"factory\":\"DEMO\",\"modelID\":\"1\",\"model\":\"DEMO\"},{\"transferID\":\"22\",\"typeID\":\"2\",\"type\":\"SIM\",\"stateID\":\"2\",\"state\":\"ACEPTADO\",\"productID\":\"6\",\"serie\":\"223456\",\"factoryID\":\"3\",\"factory\":\"AT&T\",\"modelID\":null,\"model\":null},{\"transferID\":\"22\",\"typeID\":\"3\",\"type\":\"GENERICO\",\"stateID\":\"3\",\"state\":\"RECHAZADO\",\"productID\":\"13\",\"serie\":\"GEN01\",\"factoryID\":\"2\",\"factory\":\"DEMO B\",\"modelID\":\"11\",\"model\":\"GEN DEMO\"}],\"bitacora\":[{\"clientID\":\"3\",\"client\":\"aviles\",\"userID\":\"3\",\"user\":\"aviles\",\"actionID\":\"2\",\"action\":\"FINALIZAR\",\"notes\":\"SIMOn\",\"creationTimestamp\":\"1580337788\"},{\"clientID\":\"2\",\"client\":\"gps infinity\",\"userID\":\"2\",\"user\":\"gps infinity\",\"actionID\":\"1\",\"action\":\"REGISTRAR\",\"notes\":\"\",\"creationTimestamp\":\"1580325037\"}]}}}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "apidoc/transfers.php",
    "groupTitle": "Transferencias",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "string",
            "allowedValues": [
              "JsonWebToken"
            ],
            "optional": false,
            "field": "authorization",
            "description": "<p>Bearer Token requerido para la autorizacion</p>"
          }
        ]
      }
    }
  },
  {
    "type": "get",
    "url": "/transfers",
    "title": "Consultar Transferencias",
    "name": "GetTransfers",
    "group": "Transferencias",
    "description": "<p>Consulta las transferenceias realizadas</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": true,
            "field": "tranfer.clientID",
            "description": "<p>ID del cliente que estuvo involucrado en transferencias con el ID del cliente que realiza la solicitud es decir transferencias entre 2 clientes especificos. el cliente que realiza la peticion y el cliente que se proporciona en este parametro <br><b>NOTA: </b>Si no se proporciona este parametro, los resultados seran todas las transferencias en las que el cliente que realiza la peticion estuvo involucrado</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": true,
            "field": "fromTimestamp",
            "description": "<p>Consulta transferencias desde la fecha proporcionada</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": true,
            "field": "toTimestamp",
            "description": "<p>Consulta transferencias hasta la fecha proporcionada</p>"
          },
          {
            "group": "Parameter",
            "type": "array",
            "optional": true,
            "field": "transferStates",
            "description": "<p>Consulta las transferencias donde el estado de la transferencia coincida con los valores proporcionados. <br><b>Nota:</b> Si no se proporciona devolvera todas las tranferencias sin distincion de su estado</p>"
          },
          {
            "group": "Parameter",
            "type": "array",
            "optional": true,
            "field": "transferTypes",
            "description": "<p>Consulta las transferencias donde el tipo de transferencia coincida con los valores proporcionados <br><b>Nota: </b> Si no se proporciona se devolveran todas las transferencias sin importar el tipo de transferencia</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": true,
            "field": "limit",
            "description": "<p>Limite de registros por consulta</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Request-Example 1:",
          "content": "{{url}}/transfers?clientID=3&transferStates[]=1&transferStates[]=2&transferTypes[]=1&transferTypes[]=2",
          "type": "json"
        },
        {
          "title": "Request-Example 2:",
          "content": "{{url}}/transfers?fromTimestamp=123456&transferTypes[]=1&transferTypes[]=2",
          "type": "json"
        }
      ]
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "array",
            "optional": false,
            "field": "transfers",
            "description": "<p>Arreglo que contiene las transferencias</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "transfer.id",
            "description": "<p>ID de la transferencia</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "transfer.fromClientID",
            "description": "<p>ID del cliente que realiza la transferencia</p>"
          },
          {
            "group": "Success 200",
            "type": "string",
            "optional": false,
            "field": "transfer.fromClient",
            "description": "<p>Nombre del cliente que realiza la transferencia</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "transfer.toClientID",
            "description": "<p>ID del cliente que recibe la transferencia</p>"
          },
          {
            "group": "Success 200",
            "type": "string",
            "optional": false,
            "field": "transfer.toClient",
            "description": "<p>Nombre del cliente que recibe la transferencia</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "transfer.typeID",
            "description": "<p>Tipo de transferencia</p>"
          },
          {
            "group": "Success 200",
            "type": "string",
            "optional": false,
            "field": "transfer.type",
            "description": "<p>Tipo de transferencia</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "transfer.stateID",
            "description": "<p>Estado de la transferencia</p>"
          },
          {
            "group": "Success 200",
            "type": "string",
            "optional": false,
            "field": "transfer.state",
            "description": "<p>Estado de la transferencia</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "transfer.creationTimestamp",
            "description": "<p>Fecha en la que se registro la tranferencia</p>"
          },
          {
            "group": "Success 200",
            "type": "string",
            "optional": false,
            "field": "transfer.notes",
            "description": "<p>Notas adicionales</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "allowedValues": [
              "1",
              "0"
            ],
            "optional": false,
            "field": "transfer.isTransferReceived",
            "description": "<p>Indica si la transferencia fue enviada al cliente que realiza la peticion</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success",
          "content": "{\"success\":true,\"statusCode\":200,\"pagination\":{\"self\":\"\",\"next\":\"\",\"prev\":\"\"},\"data\":{\"transfers\":[{\"id\":\"32\",\"fromClientID\":\"4\",\"fromClient\":\"maguersa\",\"toClientID\":\"2\",\"toClient\":\"gps infinity\",\"typeID\":\"2\",\"type\":\"DEVOLUCION\",\"stateID\":\"2\",\"state\":\"COMPLETADO\",\"creationTimestamp\":\"1580407888\",\"notes\":null,\"isReceivedTransfer\":\"1\"},{\"id\":\"31\",\"fromClientID\":\"1\",\"fromClient\":\"administrador\",\"toClientID\":\"2\",\"toClient\":\"gps infinity\",\"typeID\":\"1\",\"type\":\"TRANSFERENCIA\",\"stateID\":\"1\",\"state\":\"PENDIENTE\",\"creationTimestamp\":\"1580337907\",\"notes\":null,\"isReceivedTransfer\":\"1\"},{\"id\":\"28\",\"fromClientID\":\"2\",\"fromClient\":\"gps infinity\",\"toClientID\":\"1\",\"toClient\":\"administrador\",\"typeID\":\"2\",\"type\":\"DEVOLUCION\",\"stateID\":\"2\",\"state\":\"COMPLETADO\",\"creationTimestamp\":\"1580325076\",\"notes\":\"transferencia de prueba\",\"isReceivedTransfer\":\"0\"},{\"id\":\"27\",\"fromClientID\":\"2\",\"fromClient\":\"gps infinity\",\"toClientID\":\"1\",\"toClient\":\"administrador\",\"typeID\":\"2\",\"type\":\"DEVOLUCION\",\"stateID\":\"3\",\"state\":\"CANCELADO\",\"creationTimestamp\":\"1580325074\",\"notes\":\"transferencia de prueba\",\"isReceivedTransfer\":\"0\"},{\"id\":\"26\",\"fromClientID\":\"2\",\"fromClient\":\"gps infinity\",\"toClientID\":\"4\",\"toClient\":\"maguersa\",\"typeID\":\"1\",\"type\":\"TRANSFERENCIA\",\"stateID\":\"1\",\"state\":\"PENDIENTE\",\"creationTimestamp\":\"1580325067\",\"notes\":\"transferencia de prueba\",\"isReceivedTransfer\":\"0\"},{\"id\":\"25\",\"fromClientID\":\"2\",\"fromClient\":\"gps infinity\",\"toClientID\":\"3\",\"toClient\":\"aviles\",\"typeID\":\"1\",\"type\":\"TRANSFERENCIA\",\"stateID\":\"1\",\"state\":\"PENDIENTE\",\"creationTimestamp\":\"1580325045\",\"notes\":\"transferencia de prueba\",\"isReceivedTransfer\":\"0\"},{\"id\":\"24\",\"fromClientID\":\"2\",\"fromClient\":\"gps infinity\",\"toClientID\":\"3\",\"toClient\":\"aviles\",\"typeID\":\"1\",\"type\":\"TRANSFERENCIA\",\"stateID\":\"1\",\"state\":\"PENDIENTE\",\"creationTimestamp\":\"1580325042\",\"notes\":\"transferencia de prueba\",\"isReceivedTransfer\":\"0\"},{\"id\":\"23\",\"fromClientID\":\"2\",\"fromClient\":\"gps infinity\",\"toClientID\":\"3\",\"toClient\":\"aviles\",\"typeID\":\"1\",\"type\":\"TRANSFERENCIA\",\"stateID\":\"3\",\"state\":\"CANCELADO\",\"creationTimestamp\":\"1580325041\",\"notes\":\"transferencia de prueba\",\"isReceivedTransfer\":\"0\"},{\"id\":\"22\",\"fromClientID\":\"2\",\"fromClient\":\"gps infinity\",\"toClientID\":\"3\",\"toClient\":\"aviles\",\"typeID\":\"1\",\"type\":\"TRANSFERENCIA\",\"stateID\":\"2\",\"state\":\"COMPLETADO\",\"creationTimestamp\":\"1580325037\",\"notes\":\"transferencia de prueba\",\"isReceivedTransfer\":\"0\"}]}}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "apidoc/transfers.php",
    "groupTitle": "Transferencias",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "string",
            "allowedValues": [
              "JsonWebToken"
            ],
            "optional": false,
            "field": "authorization",
            "description": "<p>Bearer Token requerido para la autorizacion</p>"
          }
        ]
      }
    }
  },
  {
    "type": "post",
    "url": "/transfers",
    "title": "Registrar Transferencia",
    "name": "PostTransfer",
    "group": "Transferencias",
    "description": "<p>Registra una nueva transferencia</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "object",
            "optional": false,
            "field": "transfer",
            "description": "<p>Objeto que contiene la informacion de la transferencia</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": true,
            "field": "tranfer.clientID",
            "description": "<p>ID del cliente al que se le enviaran los productos <br><b>NOTA: </b>Si este valor no es proporcionado, la transferencia sera considerada como devolucion, por lo que la transferencia estara dirigida hacia el distribuidor del cliente que realiza la accion</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "tranfer.notes",
            "description": "<p>Notas adicionales</p>"
          },
          {
            "group": "Parameter",
            "type": "array",
            "optional": false,
            "field": "products",
            "description": "<p>Arreglo de productos involucrados en la transferencia</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "product.id",
            "description": "<p>ID del producto</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "product.type",
            "description": "<p>Tipo de producto</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Request-Example 1:",
          "content": "{\"transfer\":{\"clientID\":2,\"notes\":\"\"},\"products\":[{\"type\":2,\"id\":6},{\"type\":1,\"id\":7},{\"type\":3,\"id\":8}]}",
          "type": "json"
        }
      ]
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "transferID",
            "description": "<p>ID de la transferencia</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success",
          "content": "{\"success\":true,\"statusCode\":200,\"pagination\":{\"self\":\"\",\"next\":\"\",\"prev\":\"\"},\"data\":{\"transferID\":\"19\"}}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "apidoc/transfers.php",
    "groupTitle": "Transferencias",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "string",
            "allowedValues": [
              "JsonWebToken"
            ],
            "optional": false,
            "field": "authorization",
            "description": "<p>Bearer Token requerido para la autorizacion</p>"
          }
        ]
      }
    }
  },
  {
    "type": "delete",
    "url": "/users/:userID",
    "title": "Eliminar usuario",
    "name": "DeleteUser",
    "group": "Usuarios",
    "description": "<p>Elimina un usuario de la plataforma</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "userID",
            "description": "<p>Id del usuario a eliminar</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "apidoc/users.php",
    "groupTitle": "Usuarios",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "string",
            "allowedValues": [
              "JsonWebToken"
            ],
            "optional": false,
            "field": "authorization",
            "description": "<p>Bearer Token requerido para la autorizacion</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success",
          "content": "{\"success\":true,\"statusCode\":200,\"pagination\":{\"self\":\"\",\"next\":\"\",\"prev\":\"\"},\"data\":[]}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "get",
    "url": "/users/:id",
    "title": "Informacion de usuario",
    "name": "GetUser",
    "group": "Usuarios",
    "description": "<p>Obtiene la informacion de un usuario</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "id",
            "description": "<p>ID del usuario a consultar</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "object",
            "optional": false,
            "field": "user",
            "description": "<p>Objeto que contiene la informacion del usuario</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "user.id",
            "description": "<p>ID del usuario</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "user.userType",
            "description": "<p>tipo de usuario</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "user.timezone",
            "description": "<p>ID del timezone del usuario</p>"
          },
          {
            "group": "Success 200",
            "type": "string",
            "optional": false,
            "field": "user.username",
            "description": "<p>Nombre del usuario</p>"
          },
          {
            "group": "Success 200",
            "type": "string",
            "optional": false,
            "field": "user.email",
            "description": "<p>Correo electronico del usuario</p>"
          },
          {
            "group": "Success 200",
            "type": "string",
            "optional": false,
            "field": "user.name",
            "description": "<p>Nombre del usuario</p>"
          },
          {
            "group": "Success 200",
            "type": "string",
            "optional": false,
            "field": "user.paternalSurname",
            "description": "<p>Apellido paterno del usuario</p>"
          },
          {
            "group": "Success 200",
            "type": "string",
            "optional": false,
            "field": "user.maternalSurname",
            "description": "<p>Apellido materno del usuario</p>"
          },
          {
            "group": "Success 200",
            "type": "string",
            "optional": false,
            "field": "user.phone",
            "description": "<p>Telefono del usuario</p>"
          },
          {
            "group": "Success 200",
            "type": "string",
            "optional": false,
            "field": "user.address",
            "description": "<p>Direccion del usuario</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "user.creationTimestamp",
            "description": "<p>Timestamp en la que se creo el usuario</p>"
          },
          {
            "group": "Success 200",
            "type": "string",
            "optional": false,
            "field": "user.notes",
            "description": "<p>Notas adicionales.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object[]",
            "optional": false,
            "field": "user.permissions",
            "description": "<p>Arreglo que contiene los permisos con los que cuenta el usuario</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "user.permissions.permission",
            "description": "<p>Objecto que contiene la informacion de un permiso</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "user.permissions.permission.id",
            "description": "<p>ID del usuario</p>"
          },
          {
            "group": "Success 200",
            "type": "string",
            "optional": false,
            "field": "user.permissions.permission.code",
            "description": "<p>Codigo del permiso</p>"
          },
          {
            "group": "Success 200",
            "type": "Object[]",
            "optional": false,
            "field": "devices",
            "description": "<p>Arreglo que contiene los ID de dispositivos que se asociaran a la cuenta</p>"
          },
          {
            "group": "Success 200",
            "type": "object",
            "optional": false,
            "field": "devices.device",
            "description": "<p>Objeto que contiene la informacion de un dispositivo</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "devices.device.id",
            "description": "<p>ID del dispositivo</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "devices.device.distributorID",
            "description": "<p>ID del distribuidor del dispositivo</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "devices.device.clientID",
            "description": "<p>ID del cliente del dispositivo</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "devices.device.imei",
            "description": "<p>Imei del dispositivo</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "devices.device.alias",
            "description": "<p>Alias del dispositivo</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Example ",
          "content": "{\"success\":true,\"statusCode\":200,\"pagination\":{\"self\":\"\",\"next\":\"\",\"prev\":\"\"},\"data\":{\"user\":{\"id\":\"89\",\"userType\":\"2\",\"timezoneID\":\"14\",\"username\":\"ejimenez3\",\"email\":\"ejimenez@globalgps.com.mx\",\"creationTimestamp\":\"4294967295\",\"notes\":\"alguna nota\",\"name\":\"Esme\",\"paternalSurname\":\"Jimenez\",\"maternalSurname\":\"pepino\",\"phone\":\"777123456\",\"address\":\"alguna direccion\",\"permissions\":[{\"id\":\"1\",\"code\":\"SLOC\"},{\"id\":\"2\",\"code\":\"SREP\"},{\"id\":\"3\",\"code\":\"SALT\"}]},\"devices\":[{\"id\":\"45\",\"distributorID\":\"17\",\"clientID\":\"70\",\"imei\":\"0001\",\"alias\":\"Disp Prueba\"},{\"id\":\"46\",\"distributorID\":\"17\",\"clientID\":\"42\",\"imei\":\"008748872\",\"alias\":\"Laboratorio Siccob\"},{\"id\":\"47\",\"distributorID\":\"17\",\"clientID\":\"71\",\"imei\":\"0002\",\"alias\":\"Disp Prueba 2\"},{\"id\":\"48\",\"distributorID\":\"17\",\"clientID\":\"70\",\"imei\":\"0003\",\"alias\":\"Disp Prueba 3\"}]}}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "apidoc/users.php",
    "groupTitle": "Usuarios",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "string",
            "allowedValues": [
              "JsonWebToken"
            ],
            "optional": false,
            "field": "authorization",
            "description": "<p>Bearer Token requerido para la autorizacion</p>"
          }
        ]
      }
    }
  },
  {
    "type": "get",
    "url": "/users",
    "title": "Lista de usuarios",
    "name": "GetUsers",
    "group": "Usuarios",
    "description": "<p>Obtiene la lista de usuarios de un cliente o distribuidor</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "object[]",
            "optional": false,
            "field": "users",
            "description": "<p>Objeto que contiene la informacion de los usuarios</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "object",
            "optional": false,
            "field": "user",
            "description": "<p>Objeto que contiene la informacion del usuario</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "user.id",
            "description": "<p>ID del usuario</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "user.userType",
            "description": "<p>tipo de usuario</p>"
          },
          {
            "group": "Success 200",
            "type": "string",
            "optional": false,
            "field": "user.username",
            "description": "<p>Nombre del usuario</p>"
          },
          {
            "group": "Success 200",
            "type": "string",
            "optional": false,
            "field": "user.email",
            "description": "<p>Correo electronico del usuario</p>"
          },
          {
            "group": "Success 200",
            "type": "string",
            "optional": false,
            "field": "user.name",
            "description": "<p>Nombre del usuario</p>"
          },
          {
            "group": "Success 200",
            "type": "string",
            "optional": false,
            "field": "user.paternalSurname",
            "description": "<p>Apellido Paterno usuario</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "user.creationTimestamp",
            "description": "<p>Timestamp en la que se creo el usuario</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Example ",
          "content": "{\"success\":true,\"statusCode\":200,\"pagination\":{\"self\":\"\",\"next\":\"\",\"prev\":\"\"},\"data\":{\"users\":[{\"id\":\"84\",\"userType\":\"2\",\"username\":\"omartinez\",\"email\":\"omartinez@globalgps.com.mx\",\"creationTimestamp\":\"4294967295\",\"name\":\"Omar\",\"paternalSurname\":\"Martinez\"},{\"id\":\"86\",\"userType\":\"2\",\"username\":\"ejimenez\",\"email\":\"ejimenez@globalgps.com.mx\",\"creationTimestamp\":\"4294967295\",\"name\":\"Esme\",\"paternalSurname\":\"Jimenez\"}]}}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "apidoc/users.php",
    "groupTitle": "Usuarios",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "string",
            "allowedValues": [
              "JsonWebToken"
            ],
            "optional": false,
            "field": "authorization",
            "description": "<p>Bearer Token requerido para la autorizacion</p>"
          }
        ]
      }
    }
  },
  {
    "type": "post",
    "url": "/users",
    "title": "Registrar usuario",
    "name": "PostUsers",
    "group": "Usuarios",
    "description": "<p>Registra un nuevo usuario de tipo asociado en la plataforma</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "object",
            "optional": false,
            "field": "user",
            "description": "<p>Objeto que contiene la informacion del nuevo usuario</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "allowedValues": [
              "2"
            ],
            "optional": false,
            "field": "user.userType",
            "description": "<p>tipo de usuario</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "user.timezone",
            "description": "<p>ID del timezone que regira al usuario</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "user.username",
            "description": "<p>Nombre del usuario</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "user.email",
            "description": "<p>Correo electronico del usuario</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "user.notes",
            "description": "<p>Notas adicionales.</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "user.name",
            "description": "<p>Nombre del usuario.</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "user.paternalSurname",
            "description": "<p>Apellido Paterno del usuario.</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "user.maternalSurname",
            "description": "<p>Apellido Materno del usuario.</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "user.phone",
            "description": "<p>Telefono del usuario.</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "user.address",
            "description": "<p>Direccion del usuario.</p>"
          },
          {
            "group": "Parameter",
            "type": "int[]",
            "optional": false,
            "field": "user.permissions",
            "description": "<p>Arreglo que contiene los ID de permisos extra con los que contara el usuario</p>"
          },
          {
            "group": "Parameter",
            "type": "int[]",
            "optional": false,
            "field": "devices",
            "description": "<p>Arreglo que contiene los ID de dispositivos que se asociaran a la cuenta</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Request-Example:",
          "content": "{\"user\":{\"userType\":\"2\",\"timezone\":\"14\",\"username\":\"ejimenez3\",\"email\":\"ejimenez@globalgps.com.mx\",\"name\":\"Esme\",\"paternalSurname\":\"Jimenez\",\"maternalSurname\":\"pepino\",\"phone\":\"777123456\",\"address\":\"alguna direccion\",\"notes\":\"alguna nota\",\"permissions\":[1,2]},\"devices\":[45,46,47,48]}",
          "type": "json"
        }
      ]
    },
    "success": {
      "examples": [
        {
          "title": "Success-Example ",
          "content": "{\"success\":true,\"statusCode\":201,\"data\":{\"userID\":\"86\"}}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "apidoc/users.php",
    "groupTitle": "Usuarios",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "string",
            "allowedValues": [
              "JsonWebToken"
            ],
            "optional": false,
            "field": "authorization",
            "description": "<p>Bearer Token requerido para la autorizacion</p>"
          }
        ]
      }
    }
  },
  {
    "type": "put",
    "url": "/users/:id/status",
    "title": "Suspender Usuario",
    "name": "PutUserStatus",
    "group": "Usuarios",
    "description": "<p>Actualiza el estado del usuario (suspender)</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "id",
            "description": "<p>ID del usuario a suspender</p>"
          },
          {
            "group": "Parameter",
            "type": "bool",
            "optional": false,
            "field": "status",
            "description": "<p>Indica estado del usuario <br> True = Usuario activo <br> False = Usuario suspendido</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Ejemplo",
          "content": "{\"status\":false}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "apidoc/users.php",
    "groupTitle": "Usuarios",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "string",
            "allowedValues": [
              "JsonWebToken"
            ],
            "optional": false,
            "field": "authorization",
            "description": "<p>Bearer Token requerido para la autorizacion</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success",
          "content": "{\"success\":true,\"statusCode\":200,\"pagination\":{\"self\":\"\",\"next\":\"\",\"prev\":\"\"},\"data\":[]}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "post",
    "url": "/users/:userID/devices",
    "title": "Agregar dispositivos al usuario",
    "name": "SuscribeUserToDevices",
    "group": "Usuarios",
    "description": "<p>Vincula dispositivos a un usuario para que pueda monitorearlos e interactuar con ellos</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "userID",
            "description": "<p>Id del usuario</p>"
          },
          {
            "group": "Parameter",
            "type": "int[]",
            "optional": false,
            "field": "devices",
            "description": "<p>Arreglo de id's de dispositivos a vincular</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Request-Example:",
          "content": "{\"devices\":[46,47,48]}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "apidoc/users.php",
    "groupTitle": "Usuarios",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "string",
            "allowedValues": [
              "JsonWebToken"
            ],
            "optional": false,
            "field": "authorization",
            "description": "<p>Bearer Token requerido para la autorizacion</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success",
          "content": "{\"success\":true,\"statusCode\":200,\"pagination\":{\"self\":\"\",\"next\":\"\",\"prev\":\"\"},\"data\":[]}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "delete",
    "url": "/users/:userID/devices/:deviceID",
    "title": "Quitar dispositivo al usuario",
    "name": "UnscribeUserFromoDevices",
    "group": "Usuarios",
    "description": "<p>Elimina la relacion entre un dispositivo y un usuario (el usuario ya no podra monitorear ni interactuar con el dispositivo)</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "userID",
            "description": "<p>ID del usuario</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "deviceID",
            "description": "<p>ID del dispositivo</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "apidoc/users.php",
    "groupTitle": "Usuarios",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "string",
            "allowedValues": [
              "JsonWebToken"
            ],
            "optional": false,
            "field": "authorization",
            "description": "<p>Bearer Token requerido para la autorizacion</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success",
          "content": "{\"success\":true,\"statusCode\":200,\"pagination\":{\"self\":\"\",\"next\":\"\",\"prev\":\"\"},\"data\":[]}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "put",
    "url": "/users/:userID",
    "title": "Actualizar datos de usuario",
    "name": "UpdateUser",
    "group": "Usuarios",
    "description": "<p>Actualiza los datos de un usuario</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "userID",
            "description": "<p>Id del usuario a actualizar</p>"
          },
          {
            "group": "Parameter",
            "type": "object",
            "optional": false,
            "field": "user",
            "description": "<p>Objeto que contiene la informacion del nuevo usuario</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": true,
            "field": "user.timezone",
            "description": "<p>ID del timezone que regira al usuario</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": true,
            "field": "user.username",
            "description": "<p>Nombre del usuario</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": true,
            "field": "user.email",
            "description": "<p>Correo electronico del usuario</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": true,
            "field": "user.notes",
            "description": "<p>Notas adicionales.</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": true,
            "field": "user.name",
            "description": "<p>Nombre del usuario.</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": true,
            "field": "user.paternalSurname",
            "description": "<p>Apellido Paterno del usuario.</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": true,
            "field": "user.maternalSurname",
            "description": "<p>Apellido Materno del usuario.</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": true,
            "field": "user.phone",
            "description": "<p>Telefono del usuario.</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": true,
            "field": "user.address",
            "description": "<p>Direccion del usuario.</p>"
          },
          {
            "group": "Parameter",
            "type": "int[]",
            "optional": true,
            "field": "user.permissions",
            "description": "<p>Arreglo que contiene los ID de permisos extra con los que contara el usuario</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Request-Example1:",
          "content": "{\"user\":{\"username\":\"esme5\",\"timezone\":16,\"notes\":\"nueva nota\",\"name\":\"nuev Esme\",\"paternalSurname\":\"nuev Jimenez\",\"maternalSurname\":\"nuev pepino\",\"phone\":\"1777123456\",\"address\":\"n\",\"permissions\":[1,2]}}",
          "type": "json"
        },
        {
          "title": "Request-Example2:",
          "content": "{\"user\":{\"username\":\"newName\",\"email\":\"newName@mail.com\"}}",
          "type": "json"
        },
        {
          "title": "Request-Example3:",
          "content": "{\"user\":{\"name\":\"nuev Esme\",\"paternalSurname\":\"nuev Jimenez\",\"maternalSurname\":\"nuev pepino\"}}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "apidoc/users.php",
    "groupTitle": "Usuarios",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "string",
            "allowedValues": [
              "JsonWebToken"
            ],
            "optional": false,
            "field": "authorization",
            "description": "<p>Bearer Token requerido para la autorizacion</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success",
          "content": "{\"success\":true,\"statusCode\":200,\"pagination\":{\"self\":\"\",\"next\":\"\",\"prev\":\"\"},\"data\":[]}",
          "type": "json"
        }
      ]
    }
  },
  {
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "optional": false,
            "field": "varname1",
            "description": "<p>No type.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "varname2",
            "description": "<p>With type.</p>"
          }
        ]
      }
    },
    "type": "",
    "url": "",
    "version": "0.0.0",
    "filename": "apidoc/template/main.js",
    "group": "c__Work_SICCOB_Universal_platform_apidoc_template_main_js",
    "groupTitle": "c__Work_SICCOB_Universal_platform_apidoc_template_main_js",
    "name": ""
  }
] });
