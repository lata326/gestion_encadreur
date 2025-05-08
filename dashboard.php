<?php
// dashboard.php

session_start();

// Si l'utilisateur n'est pas connecté, on le redirige vers la page de login
if (empty($_SESSION['user'])) {
    header('Location: /index.php?route=login');
    exit;
}

// Récupère les infos stockées en session
$user = $_SESSION['user'];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Tableau de bord</title>
</head>
<body>
  <h1>Bienvenue, <?= htmlspecialchars($user['username']) ?> !</h1>
  <p>Rôle : <?= htmlspecialchars($user['role']) ?></p>

  <p>
    <a href="index.php?route=logout">Se déconnecter</a>
  </p>
</body>
</html>
