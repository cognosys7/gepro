<?php
set_time_limit(10);
require_once 'whatssapp/whatsprot.class.php';
require_once 'whatssapp/events/MyEvents.php';

date_default_timezone_set('America/Lima');

function ConectaWSP($Phone,$Mensaje)
{
    $username = ''; // clave retirada: se cargará desde fuera del sitio
    $password = ''; // clave retirada: se cargará desde fuera del sitio
    $nickname = ''; // clave retirada: se cargará desde fuera del sitio
    $target   = "51".$Phone;
    $no       = $target;
    $msg      = $Mensaje;
    $debug    = false;
    $wa       = new WhatsProt($username, $nickname, $debug);
    $wa->connect();
    $wa->loginWithPassword($password);
    $wa->sendMessage($no, $msg);
    $wa->disconnect();
}