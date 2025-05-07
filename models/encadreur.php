<?php
require_once '../config/database.php';

class Encadreur {
    private $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    /** 📌 Ajout d'un encadreur avec compétence */
    public function ajouterEncadreur($nom, $prenom, $competence) {
        // Liste des compétences valides
        $competencesSimples = ['AL', 'SI', 'SRC'];
        $competencesDoubles = ['AL, SI', 'AL, SRC', 'SI, SRC'];
        $competencesTriples = ['AL, SI, SRC'];

        // Vérification que la compétence est valide
        if (!in_array($competence, array_merge($competencesSimples, $competencesDoubles, $competencesTriples))) {
            throw new Exception("Compétence invalide !");
        }

        $query = "INSERT INTO encadreurs (nom, prenom, competence) VALUES (:nom, :prenom, :competence)";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([
            'nom' => $nom,
            'prenom' => $prenom,
            'competence' => $competence
        ]);
    }

    /** 📌 Suppression d'un encadreur */
    public function supprimerEncadreur($id) {
        $query = "DELETE FROM encadreurs WHERE id = :id";
        $stmt = $this->db->prepare($query);
        return $stmt->execute(['id' => $id]);
    }

    /** 📌 Modification d'un encadreur (Nom, Prénom, Compétence) */
    public function modifierEncadreur($id, $nom, $prenom, $competence) {
        // Vérification que la compétence est valide
        $competencesSimples = ['AL', 'SI', 'SRC'];
        $competencesDoubles = ['AL, SI', 'AL, SRC', 'SI, SRC'];
        $competencesTriples = ['AL, SI, SRC'];

        if (!in_array($competence, array_merge($competencesSimples, $competencesDoubles, $competencesTriples))) {
            throw new Exception("Compétence invalide !");
        }

        $query = "UPDATE encadreurs SET nom = :nom, prenom = :prenom, competence = :competence WHERE id = :id";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([
            'nom' => $nom,
            'prenom' => $prenom,
            'competence' => $competence,
            'id' => $id
        ]);
    }

    /** 📌 Filtrer les encadreurs par compétence */
    public function getEncadreursParCompetence($type) {
        $query = "SELECT * FROM encadreurs WHERE competence = :type";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['type' => $type]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}