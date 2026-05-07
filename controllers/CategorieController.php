<?php
class Categorie
{
    private $id;
    private $nom;
    private $description;

    // 1. Lister toutes les catégories (pour le menu de navigation ou sidebar)
    public function listCategories()
    {
        try {
            require 'config.php'; // Ou db.php selon ton projet
            global $pdo;

            $sql = "SELECT * FROM categorie";
            $stmt = $pdo->query($sql);
            $res = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // DEBUG : On envoie vers la console JS pour voir ce qui sort de la BD
            echo "<script>console.log('SQL Result:', " . json_encode($res) . ");</script>";

            return $res;
        } catch (PDOException $e) {
            echo "<script>console.error('Erreur SQL:', " . json_encode($e->getMessage()) . ");</script>";
            return [];
        }
    }
    // 2. Récupérer les infos d'une catégorie précise (pour afficher le titre sur la page)
    public function getCategorieById($id)
    {
        require(__DIR__ . '/../config/db.php');
        global $pdo;

        $req = "SELECT * FROM categories WHERE id = :id";
        try {
            $stmt = $pdo->prepare($req);
            $stmt->execute([':id' => $id]);
            return $stmt->fetch();
        } catch (PDOException $e) {
            return null;
        }
    }
}
?>