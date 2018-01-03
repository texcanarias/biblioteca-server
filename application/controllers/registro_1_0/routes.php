<?php

//----------------------------------------------------------------
// REGISTRO_1_0
//----------------------------------------------------------------
/*
  curl -i -X POST \
  -H "Content-Type: application/json" \
  http://192.168.50.238/server/index.php/registro_1_0/login \
  -d '{"usuario":"admin","pass":"adclick"}'
 */
$route['registro_1_0/login'] = 'registro_1_0/registro/login';

/*
  curl -i -X POST \
  -H "Content-Type: application/json" \
  http://192.168.50.238/server/index.php/registro_1_0/recuperar \
  -d '{"email":"antonio@adclick.es"}'
 */
$route['registro_1_0/recuperar'] = 'registro_1_0/registro/recuperar';

/*
  curl -i -X POST \
  -H "Content-Type: application/json" \
  -H "X-API-KEY: ee5e5095d84d719884d82a738cde5c46" \
  http://192.168.50.238/server/index.php/registro_1_0/desbloquear \
  -d '{"id":"2"}'
 */
$route['registro_1_0/desbloquear'] = 'registro_1_0/registro/desbloquear';

/*
  curl -i -X PATCH  \
  -H "Content-Type: application/json" \
  -H "X-API-KEY: ee5e5095d84d719884d82a738cde5c46" \
  http://192.168.50.238/server/index.php/registro_1_0/set_nombre_email \
  -d '{"id":"2","nombre":"admin2","email":"antonio.tex@gmail.com"}'
 */
$route['registro_1_0/set_nombre_email'] = 'registro_1_0/registro/nombre_email';

/*
  curl -i -X PATCH \
  -H "Content-Type: application/json" \
  -H "X-API-KEY: ee5e5095d84d719884d82a738cde5c46" \
  http://192.168.50.238/server/index.php/registro_1_0/set_pass \
  -d '{"id":"2","password":"123456789"}'
 */
$route['registro_1_0/set_pass'] = 'registro_1_0/registro/pass';
