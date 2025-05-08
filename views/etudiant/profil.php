<h1>Bienvenue, <?= htmlspecialchars($etudiant['prenom']) ?> <?= htmlspecialchars($etudiant['nom']) ?></h1>

<p>Email : <?= htmlspecialchars($etudiant['email']) ?></p>
<p>Thème : <?= htmlspecialchars($etudiant['theme']) ?></p>

<!-- Lien de déconnexion -->
<a href="/logout.php" style="color:red;">Se déconnecter</a>
