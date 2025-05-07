<?php
require_once '../config/database.php';

class Administrateur {
    private $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    /** 📌 Connexion d'un administrateur */
    public function connecter($email, $motDePasse) {
        $query = "SELECT id, mot_de_passe FROM administrateurs WHERE email = :email";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['email' => $email]);
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($admin && password_verify($motDePasse, $admin['mot_de_passe'])) {
            session_start();
            $_SESSION['admin_id'] = $admin['id'];
            return true; // Connexion réussie
        }
        return false; // Échec de connexion
    }

    /** 📌 Déconnexion de l'administrateur */
    public function deconnecter() {
        session_start();
        session_destroy();
        header("Location: /connexion_admin.php");
        exit();
    }

    /** 📌 Vérification de l'accès (protéger les pages) */
    public static function estConnecte() {
        session_start();
        return isset($_SESSION['admin_id']);
    }
}