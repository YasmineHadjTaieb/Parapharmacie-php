<?php
// models/Utilisateur.php

class Utilisateur
{
    private PDO $db;

    public function __construct()
    {
        // On récupère l'instance $pdo définie dans config/db.php
        global $pdo;

        if (!$pdo) {
            die("Erreur : La connexion à la base de données n'est pas disponible.");
        }
        $this->db = $pdo;
    }

    public function inscription($nom, $email, $password, $adresse, $tel)
    {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO utilisateurs (nom_complet, email, mot_de_passe, adresse, telephone, role) 
                VALUES (?, ?, ?, ?, ?, 'user')";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$nom, $email, $hash, $adresse, $tel]);
    }

    public function connexion($email)
    {
        $sql = "SELECT * FROM utilisateurs WHERE email = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>