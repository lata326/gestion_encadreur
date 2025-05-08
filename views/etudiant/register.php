<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <form action="/register" method="POST" class="needs-validation" novalidate>
        <div class="mb-3">
            <label for="nom" class="form-label">Nom</label>
            <input type="text" name="nom" class="form-control" id="nom" placeholder="Nom" required>
            <div class="invalid-feedback">
                Veuillez entrer votre nom.
            </div>
        </div>
        <div class="mb-3">
            <label for="prenom" class="form-label">Prénom</label>
            <input type="text" name="prenom" class="form-control" id="prenom" placeholder="Prénom" required>
            <div class="invalid-feedback">
                Veuillez entrer votre prénom.
            </div>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" class="form-control" id="email" placeholder="Email" required>
            <div class="invalid-feedback">
                Veuillez entrer un email valide.
            </div>
        </div>
        <div class="mb-3">
            <label for="mot_de_passe" class="form-label">Mot de passe</label>
            <input type="password" name="mot_de_passe" class="form-control" id="mot_de_passe" placeholder="Mot de passe" required>
            <div class="invalid-feedback">
                Veuillez entrer un mot de passe.
            </div>
        </div>
        <button type="submit" class="btn btn-primary">S'inscrire</button>
    </form>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
