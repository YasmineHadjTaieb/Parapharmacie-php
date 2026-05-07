<?php

/**
 * Classe Categorie (Model)
 */
class Categorie
{
    public $id;
    public $nom_categorie;

    /**
     * Lister toutes les catégories
     */
    public function listCategories()
    {
        require_once(__DIR__ . '/../config/db.php');
        global $pdo;


        // On utilise nom_categorie comme vu dans votre capture d'écran
        $req = "SELECT id, nom_categorie FROM categories";
        try {
            $stmt = $pdo->query($req);
            // On récupère tout sous forme de tableau pour pouvoir faire le count et le json_encode facilement
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // En cas d'erreur, on l'affiche pour debugger
            error_log("Erreur listCategories : " . $e->getMessage());
            return [];
        }
    }
}
?>