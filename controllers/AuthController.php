<?php
// C:\xampp\htdocs\gestion_encadreur\controllers\AuthController.php

class AuthController
{
    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom     = trim($_POST['nom']);
            $prenom  = trim($_POST['prenom']);
            $email   = trim($_POST['email']);
            $db      = Database::getConnection();

            // 1) Vérif e-mail unique
            $check = $db->prepare("SELECT 1 FROM etudiants WHERE email = :email");
            $check->execute([':email' => $email]);
            if ($check->fetch()) {
                $error = "Cet e-mail est déjà utilisé.";
                require __DIR__ . '/../views/etudiant/register.php';
                exit;
            }

            // 2) Insert
            $pwdHash = password_hash($_POST['mot_de_passe'], PASSWORD_BCRYPT);
            $stmt    = $db->prepare("
                INSERT INTO etudiants (nom, prenom, email, mot_de_passe)
                VALUES (:nom, :prenom, :email, :mot_de_passe)
            ");
            $stmt->execute([
                ':nom'          => $nom,
                ':prenom'       => $prenom,
                ':email'        => $email,
                ':mot_de_passe' => $pwdHash,
            ]);

            header('Location: login.php');
            exit;
        }

        require __DIR__ . '/../views/etudiant/register.php';
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email   = trim($_POST['email']);
            $pwd     = $_POST['mot_de_passe'];
            $role    = ($_POST['role'] === 'admin') ? 'admin' : 'etudiant';
            $table   = ($role === 'admin') ? 'administrateurs' : 'etudiants';
            $db      = Database::getConnection();
            $stmt    = $db->prepare("SELECT * FROM $table WHERE email = :email");
            $stmt->execute([':email' => $email]);
            $user    = $stmt->fetch();

            if ($user && password_verify($pwd, $user['mot_de_passe'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['role']    = $role;
                header('Location: dashboard.php');
                exit;
            }

            $error = "Identifiants incorrects.";
            require __DIR__ . '/../views/login.php';
            exit;
        }

        require __DIR__ . '/../views/login.php';
    }

    public function logout()
    {
        session_unset();
        session_destroy();
        header('Location: login.php');
        exit;
    }

    public function profil()
    {
        checkAuth('etudiant');

        $db   = Database::getConnection();
        $stmt = $db->prepare("
            SELECT nom, prenom, email, theme, binome, cahier_des_charges
            FROM etudiants
            WHERE id = :id
        ");
        $stmt->execute([':id' => $_SESSION['user_id']]);
        $etudiant = $stmt->fetch();

        require __DIR__ . '/../views/etudiant/profil.php';
    }
}
