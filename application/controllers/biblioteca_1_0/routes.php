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
    http://localhost/biblioteca/server/index.php/biblioteca_1_0 \
    -d '{"nombre":"El Quijote","autor":"Cervantes","posicion":"XXX","leido":"true","origen":"BIB"}'

    EDITAR EDICION BIBLIOTECA
  curl -i -X PUT \
    -H "Content-Type: application/json" \
    -H "X-API-KEY: 21232f297a57a5a743894a0e4a801fc3" \
    http://localhost/biblioteca/server/index.php/biblioteca_1_0 \
    -d '{"id":"1","nombre":"El Quijote","autor":"Cervantes","posicion":"XX","leido":"false","origen":"BIB"}'

    LISTAR BIBLIOTECA
  curl -i -X GET \
    -H "Content-Type: application/json" \
    -H "X-API-KEY: 21232f297a57a5a743894a0e4a801fc3" \
    http://localhost/biblioteca/server/index.php/biblioteca_1_0/bibliotecas    

    RECUPERAR EDICION BIBLIOTECA
  curl -i -X GET \
    -H "Content-Type: application/json" \
    -H "X-API-KEY: 21232f297a57a5a743894a0e4a801fc3" \
    http://localhost/biblioteca/server/index.php/biblioteca_1_0/bibliotecas/1   

    ELIMINAR EDICION BIBLIOTECA
  curl -i -X DELETE \
    -H "Content-Type: application/json" \
    -H "X-API-KEY: 21232f297a57a5a743894a0e4a801fc3" \
    http://localhost/biblioteca/server/index.php/biblioteca_1_0/bibliotecas/ \
    -d '{"id":"1"}'
 
 *     
 */
$route['biblioteca_1_0/bibliotecas/(:num)'] = 'biblioteca_1_0/biblioteca/$1';
$route['biblioteca_1_0/bibliotecas'] = 'biblioteca_1_0/biblioteca';
$route['biblioteca_1_0'] = 'biblioteca_1_0/biblioteca';
