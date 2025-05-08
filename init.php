<?php
// C:\xampp\htdocs\gestion_encadreur\init.php

// 1) On active l’affichage des erreurs pour le dev
ini_set('display_errors', 1);
error_reporting(E_ALL);

// 2) Démarrage de la session en amont de toute sortie
session_start();

// 3) Chargement des fonctions de middleware
require_once __DIR__ . '/middlewares/AuthMiddleware.php';

// 4) Chargement automatique des classes si besoin
spl_autoload_register(function($class) {
    $paths = [
        __DIR__ . '/config/'      . $class . '.php',
        __DIR__ . '/controllers/' . $class . '.php',
    ];
    foreach ($paths as $file) {
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});
