<?php

/**
 * Classe Produit (Model)
 */
class Produit
{
    /* Attributs basés sur la structure de la table */
    public $id;
    public $nom;
    public $description;
    public $marque;
    public $prix;
    public $stock;
    public $image;
    public $quantite_valeur;
    public $quantite_unite;
    public $id_categorie;

    /**
     * Insérer un nouveau produit
     */
    public function insertProduit()
    {
        require_once(__DIR__ . '/../config/db.php');
        global $pdo;

        $req = "INSERT INTO produit (nom, description, marque, prix, stock, image, quantite_valeur, quantite_unite, id_categorie) 
                VALUES (:nom, :description, :marque, :prix, :stock, :image, :quantite_valeur, :quantite_unite, :id_categorie)";

        try {
            $stmt = $pdo->prepare($req);
            $result = $stmt->execute([
                ':nom' => $this->nom,
                ':description' => $this->description,
                ':marque' => $this->marque,
                ':prix' => $this->prix,
                ':stock' => $this->stock,
                ':image' => $this->image,
                ':quantite_valeur' => $this->quantite_valeur,
                ':quantite_unite' => $this->quantite_unite,
                ':id_categorie' => $this->id_categorie
            ]);
            return $result;
        } catch (PDOException $e) {
            echo "Erreur lors de l'insertion : " . $e->getMessage();
            return false;
        }
    }

    /**
     * Lister les produits (éventuellement filtrés par catégorie)
     */
    public function listProduits($id_cat = null)
    {
        require_once(__DIR__ . '/../config/db.php');
        global $pdo;

        if ($id_cat) {
            $req = "SELECT * FROM produits WHERE id_categorie = :id_cat";
            try {
                $stmt = $pdo->prepare($req);
                $stmt->execute([':id_cat' => $id_cat]);
                return $stmt;
            } catch (PDOException $e) {
                echo "Erreur lors du filtrage : " . $e->getMessage();
                return false;
            }
        } else {
            $req = "SELECT * FROM produits";
            try {
                $res = $pdo->query($req);
                return $res;
            } catch (PDOException $e) {
                echo "Erreur lors de la récupération : " . $e->getMessage();
                return false;
            }
        }
    }

    /**
     * Récupérer un produit par son ID
     */
    public function getProduit($id)
    {
        require_once(__DIR__ . '/../config/db.php');
        global $pdo;

        $req = "SELECT * FROM produits WHERE id = :id";
        try {
            $stmt = $pdo->prepare($req);
            $stmt->execute([':id' => $id]);
            return $stmt;
        } catch (PDOException $e) {
            echo "Erreur lors de la récupération du produit : " . $e->getMessage();
            return false;
        }
    }

    /**
     * Mettre à jour un produit
     */
    public function updateProduit($id)
    {
        require_once(__DIR__ . '/../config/db.php');
        global $pdo;

        $req = "UPDATE produits SET 
                nom = :nom, 
                description = :description, 
                marque = :marque, 
                prix = :prix, 
                stock = :stock, 
                image = :image, 
                quantite_valeur = :quantite_valeur, 
                quantite_unite = :quantite_unite, 
                id_categorie = :id_categorie 
                WHERE id = :id";

        try {
            $stmt = $pdo->prepare($req);
            $result = $stmt->execute([
                ':nom' => $this->nom,
                ':description' => $this->description,
                ':marque' => $this->marque,
                ':prix' => $this->prix,
                ':stock' => $this->stock,
                ':image' => $this->image,
                ':quantite_valeur' => $this->quantite_valeur,
                ':quantite_unite' => $this->quantite_unite,
                ':id_categorie' => $this->id_categorie,
                ':id' => $id
            ]);
            return $result;
        } catch (PDOException $e) {
            echo "Erreur lors de la modification : " . $e->getMessage();
            return false;
        }
    }

    /**
     * Supprimer un produit
     */
    public function deleteProduit($id)
    {
        require_once(__DIR__ . '/../config/db.php');
        global $pdo;

        $req = "DELETE FROM produits WHERE id = :id";
        try {
            $stmt = $pdo->prepare($req);
            $result = $stmt->execute([':id' => $id]);
            return $result;
        } catch (PDOException $e) {
            echo "Erreur lors de la suppression : " . $e->getMessage();
            return false;
        }
    }
}
?>