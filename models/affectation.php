<?php
require_once '../config/database.php';

class Affectation {
    private $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function affecterEncadreur($idEtudiant, $idEncadreur) {
        $query = "INSERT INTO affectations (etudiant_id, encadreur_id) VALUES (:etudiant_id, :encadreur_id)";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([
            'etudiant_id' => $idEtudiant,
            'encadreur_id' => $idEncadreur
        ]);
    }

    public function getAffectationEtudiant($idEtudiant) {
        $query = "SELECT e.nom AS encadreur_nom, e.prenom AS encadreur_prenom
                  FROM affectations a
                  JOIN encadreurs e ON a.encadreur_id = e.id
                  WHERE a.etudiant_id = :etudiant_id";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['etudiant_id' => $idEtudiant]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}