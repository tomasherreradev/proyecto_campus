<?php

function debuguear($variable) : string {
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}
function s($html) : string {
    $s = htmlspecialchars($html);
    return $s;
}

function pagina_actual($path) : bool {
    return str_contains($_SERVER['PATH_INFO'] ?? '/', $path) ? true  : false;
}

function isAuth() : bool {
    if(!isset($_SESSION)) { 
        session_start();
    }
    return isset($_SESSION['email']) && !empty($_SESSION);
}

function isAdmin() : bool {
    if(!isset($_SESSION)) { 
            session_start();
    } 
    return isset($_SESSION['admin']) && !empty($_SESSION['admin']);
}

function aosAnimation() : void {
    $efectos = ['fade-up', 'fade-down', 'fade-left', 'fade-right', 'flip-right', 'flip-left', 'flip-right', 'zoom-in', 'zoom-in-up', 'zoom-in-down', 'zoom-out'];

    $efecto = array_rand($efectos, 1);
    echo $efectos[$efecto];
}

