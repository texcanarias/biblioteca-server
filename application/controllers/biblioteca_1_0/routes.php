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
    http://192.168.0.163/server/index.php/biblioteca_1_0 \
    -d '{"nombre":"EMpresa A","codigo":"2013","direccion":"Calle de arriba","ciudad":"BCN","provincia":"BCN","estado":"Spain","cp":"35012","persona_contacto":"Juan Diego","telefono":"666","movil":"666","fax":"666","email":"Enterprise A","url":"www.enterprise.com","comentarios":"comentarios"}'

    EDITAR EDICION PROVEEDOR
  curl -i -X PUT \
    -H "Content-Type: application/json" \
    -H "X-API-KEY: 21232f297a57a5a743894a0e4a801fc3" \
    http://192.168.0.163/server/index.php/biblioteca_1_0 \
    -d '{"id":"45","nombre":"EMpresa ABC","codigo":"2013","direccion":"Calle de arriba","ciudad":"BCN","provincia":"BCN","estado":"Spain","cp":"35012","persona_contacto":"Juan Diego","telefono":"666","movil":"666","fax":"666","email":"Enterprise A","url":"www.enterprise.com","comentarios":"comentarios"}'

    LISTAR EDICION PROVEEDOR
  curl -i -X GET \
    -H "Content-Type: application/json" \
    -H "X-API-KEY: 21232f297a57a5a743894a0e4a801fc3" \
    http://192.168.0.163/server/index.php/biblioteca_1_0/bibliotecaes    

    RECUPERAR EDICION PROVEEDOR
  curl -i -X GET \
    -H "Content-Type: application/json" \
    -H "X-API-KEY: 21232f297a57a5a743894a0e4a801fc3" \
    http://192.168.0.163/server/index.php/biblioteca_1_0/bibliotecaes/4    

    ELIMINAR EDICION PROVEEDOR
  curl -i -X DELETE \
    -H "Content-Type: application/json" \
    -H "X-API-KEY: 21232f297a57a5a743894a0e4a801fc3" \
    http://192.168.0.163/server/index.php/biblioteca_1_0/bibliotecaes/ \
    -d '{"id":"4"}'
 
 *     
 */
$route['biblioteca_1_0/bibliotecaes/(:num)'] = 'biblioteca_1_0/bibliotecaes/$1';
$route['biblioteca_1_0/bibliotecaes'] = 'biblioteca_1_0/bibliotecaes';
$route['biblioteca_1_0'] = 'biblioteca_1_0/bibliotecaes';
