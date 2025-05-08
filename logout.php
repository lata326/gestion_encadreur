<?php
// C:\xampp\htdocs\gestion_encadreur\logout.php
require_once __DIR__ . '/init.php';
$ctrl = new AuthController();
$ctrl->logout();
