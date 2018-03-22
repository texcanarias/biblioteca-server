<?php
//----------------------------------------------------------------
// BIBLIOTECA_1_0
//----------------------------------------------------------------
/*
 * 
 * 
  INSERTAR EDICION BIBLIOTECA
  curl -i -X POST \
    -H "Content-Type: application/json" \
    -H "X-API-KEY: 21232f297a57a5a743894a0e4a801fc3" \
    http://192.168.0.163/server/index.php/biblioteca_1_0 \
    -d '{"nombre":"El Quijote","autor":"Cervantes","leido":"true"}'

    EDITAR EDICION BIBLIOTECA
  curl -i -X PUT \
    -H "Content-Type: application/json" \
    -H "X-API-KEY: 21232f297a57a5a743894a0e4a801fc3" \
    http://192.168.0.163/server/index.php/biblioteca_1_0 \
    -d '{"id":"4","nombre":"El Quijote","autor":"Cervantes","leido":"true"}'

    LISTAR BIBLIOTECA
  curl -i -X GET \
    -H "Content-Type: application/json" \
    -H "X-API-KEY: 21232f297a57a5a743894a0e4a801fc3" \
    http://192.168.0.163/server/index.php/biblioteca_1_0/bibliotecas    

    RECUPERAR EDICION BIBLIOTECA
  curl -i -X GET \
    -H "Content-Type: application/json" \
    -H "X-API-KEY: 21232f297a57a5a743894a0e4a801fc3" \
    http://192.168.0.163/server/index.php/biblioteca_1_0/bibliotecas/4    

    ELIMINAR EDICION BIBLIOTECA
  curl -i -X DELETE \
    -H "Content-Type: application/json" \
    -H "X-API-KEY: 21232f297a57a5a743894a0e4a801fc3" \
    http://192.168.0.163/server/index.php/biblioteca_1_0/bibliotecas/ \
    -d '{"id":"4"}'
 
 *     
 */
$route['biblioteca_1_0/bibliotecas/(:num)'] = 'biblioteca_1_0/bibliotecas/$1';
$route['biblioteca_1_0/bibliotecas'] = 'biblioteca_1_0/bibliotecas';
$route['biblioteca_1_0'] = 'biblioteca_1_0/bibliotecas';
