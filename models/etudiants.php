<?php
require_once '../config/database.php';

class Etudiant {
    private $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    /**  Création de compte étudiant */
    public function inscrire($nom, $prenom, $email, $motDePasse) {
        $check = $this->db->prepare("SELECT id FROM etudiants WHERE email = :email");
        $check->execute(['email' => $email]);
        if ($check->fetch()) {
            return false;
        }

        $motDePasseHash = password_hash($motDePasse, PASSWORD_BCRYPT);
        $query = "INSERT INTO etudiants (nom, prenom, email, mot_de_passe) VALUES (:nom, :prenom, :email, :mot_de_passe)";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([
            'nom' => $nom,
            'prenom' => $prenom,
            'email' => $email,
            'mot_de_passe' => $motDePasseHash
        ]);
    }

    /**  Connexion étudiant */
    public function connecter($email, $motDePasse) {
        $query = "SELECT id, mot_de_passe FROM etudiants WHERE email = :email";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['email' => $email]);
        $etudiant = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($etudiant && password_verify($motDePasse, $etudiant['mot_de_passe'])) {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            $_SESSION['etudiant_id'] = $etudiant['id'];
            return true;
        }
        return false;
    }

    /**  Déconnexion étudiant */
    public function deconnecter() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        session_destroy();
        header("Location: /connexion.php");
        exit();
    }

    /**  Soumission du projet */
    public function soumettreProjet($idEtudiant, $theme, $binome, $cheminPDF) {
        $query = "UPDATE etudiants SET theme = :theme, binome = :binome, cahier_des_charges = :pdf WHERE id = :id";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([
            'theme' => $theme,
            'binome' => $binome,
            'pdf' => $cheminPDF,
            'id' => $idEtudiant
        ]);
    }

    /**  Récupération du profil */
    public function getProfil($idEtudiant) {
        $query = "SELECT * FROM etudiants WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['id' => $idEtudiant]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
