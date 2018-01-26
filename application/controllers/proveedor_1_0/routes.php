<?php
//----------------------------------------------------------------
// PROVEEDOR_1_0
//----------------------------------------------------------------
/*
 * 
 * 
  INSERTAR EDICION PROVEEDOR
  curl -i -X POST \
    -H "Content-Type: application/json" \
    -H "X-API-KEY: 21232f297a57a5a743894a0e4a801fc3" \
    http://192.168.0.163/server/index.php/proveedor_1_0 \
    -d '{"nombre":"EMpresa A","codigo":"2013","direccion":"Calle de arriba","ciudad":"BCN","provincia":"BCN","estado":"Spain","cp":"35012","persona_contacto":"Juan Diego","telefono":"666","movil":"666","fax":"666","email":"Enterprise A","url":"www.enterprise.com","comentarios":"comentarios"}'

    EDITAR EDICION PROVEEDOR
  curl -i -X PUT \
    -H "Content-Type: application/json" \
    -H "X-API-KEY: 21232f297a57a5a743894a0e4a801fc3" \
    http://192.168.0.163/server/index.php/proveedor_1_0 \
    -d '{"id":"45","nombre":"EMpresa ABC","codigo":"2013","direccion":"Calle de arriba","ciudad":"BCN","provincia":"BCN","estado":"Spain","cp":"35012","persona_contacto":"Juan Diego","telefono":"666","movil":"666","fax":"666","email":"Enterprise A","url":"www.enterprise.com","comentarios":"comentarios"}'

    LISTAR EDICION PROVEEDOR
  curl -i -X GET \
    -H "Content-Type: application/json" \
    -H "X-API-KEY: 21232f297a57a5a743894a0e4a801fc3" \
    http://192.168.0.163/server/index.php/proveedor_1_0/proveedores    

    RECUPERAR EDICION PROVEEDOR
  curl -i -X GET \
    -H "Content-Type: application/json" \
    -H "X-API-KEY: 21232f297a57a5a743894a0e4a801fc3" \
    http://192.168.0.163/server/index.php/proveedor_1_0/proveedores/4    

    ELIMINAR EDICION PROVEEDOR
  curl -i -X DELETE \
    -H "Content-Type: application/json" \
    -H "X-API-KEY: 21232f297a57a5a743894a0e4a801fc3" \
    http://192.168.0.163/server/index.php/proveedor_1_0/proveedores/ \
    -d '{"id":"4"}'
 
 *     
 */
$route['proveedor_1_0/proveedores/(:num)'] = 'proveedor_1_0/proveedores/$1';
$route['proveedor_1_0/proveedores'] = 'proveedor_1_0/proveedores';
$route['proveedor_1_0'] = 'proveedor_1_0/proveedores';
