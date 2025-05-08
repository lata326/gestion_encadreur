<?php
// C:\xampp\htdocs\gestion_encadreur\middlewares\AuthMiddleware.php

/**
 * Vérifie que l'utilisateur est connecté et (optionnel) de bon rôle.
 *
 * @param string|null $requiredRole 'admin' ou 'etudiant'
 */
function checkAuth(string $requiredRole = null): void
{
    if (!isset($_SESSION['user_id'])) {
        header('Location: login.php');
        exit;
    }
    if ($requiredRole !== null && ($_SESSION['role'] ?? '') !== $requiredRole) {
        header('HTTP/1.1 403 Forbidden');
        echo "Accès refusé.";
        exit;
    }
}
