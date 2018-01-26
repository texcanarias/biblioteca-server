<?php
//----------------------------------------------------------------
// CLIENTE_1_0
//----------------------------------------------------------------
/*
    LISTAR TODOS TIPOS DE USUARIOS
  curl -i -X GET \
    -H "Content-Type: application/json" \
    -H "X-API-KEY: 21232f297a57a5a743894a0e4a801fc3" \
    http://192.168.0.163/server/index.php/cliente_1_0/tipos/
 
 

  INSERTAR EDICION CLIENTE
  curl -i -X POST \
    -H "Content-Type: application/json" \
    -H "X-API-KEY: 21232f297a57a5a743894a0e4a801fc3" \
    http://192.168.0.163/server/index.php/cliente_1_0 \
    -d '{"nombre":"EMpresa A","codigo":"2012","direccion":"Calle de arriba","ciudad":"BCN","provincia":"BCN","estado":"Spain","cp":"35012","persona_contacto":"Juan Diego","telefono":"666","movil":"666","fax":"666","email":"Enterprise A","url":"www.enterprise.com","comentarios":"comentarios","dias_vencimiento":"30","tipo":"1"}'
 
    
      EDITAR EDICION CLIENTE
  curl -i -X PUT \
    -H "Content-Type: application/json" \
    -H "X-API-KEY: 21232f297a57a5a743894a0e4a801fc3" \
    http://192.168.0.163/server/index.php/cliente_1_0 \
    -d '{"id":"371","nombre":"EMpresa ABC","codigo":"2012","direccion":"Calle de arriba","ciudad":"BCN","provincia":"BCN","estado":"Spain","cp":"35012","persona_contacto":"Juan Diego","telefono":"666","movil":"666","fax":"666","email":"Enterprise A","url":"www.enterprise.com","comentarios":"comentarios","dias_vencimiento":"30","tipo":"1"}'

    LISTAR EDICION CLIENTE
  curl -i -X GET \
    -H "Content-Type: application/json" \
    -H "X-API-KEY: 21232f297a57a5a743894a0e4a801fc3" \
    http://192.168.0.163/server/index.php/cliente_1_0/clientes    

    RECUPERAR EDICION CLIENTE
  curl -i -X GET \
    -H "Content-Type: application/json" \
    -H "X-API-KEY: 21232f297a57a5a743894a0e4a801fc3" \
    http://192.168.0.163/server/index.php/cliente_1_0/clientes/4    

    ELIMINAR EDICION CLIENTE
  curl -i -X DELETE \
    -H "Content-Type: application/json" \
    -H "X-API-KEY: 21232f297a57a5a743894a0e4a801fc3" \
    http://192.168.0.163/server/index.php/cliente_1_0 \
    -d '{"id":"4"}'
 
 *     
 */

$route['cliente_1_0/clientes/(:num)'] = 'cliente_1_0/clientes/$1';

$route['cliente_1_0/clientes'] =        'cliente_1_0/clientes';
$route['cliente_1_0/tipos'] =           'cliente_1_0/tipos';

$route['cliente_1_0'] =                 'cliente_1_0/clientes';
