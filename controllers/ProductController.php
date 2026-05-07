<?php
require_once('../../models/Produit.php');
require_once('../../models/Categorie.php');
$action = $_GET['action'] ?? '';

if ($action == 'add' || $action == 'update') {
    $p = new Produit();
    $p->nom = $_POST['nom'];
    $p->description = $_POST['description'];
    $p->marque = $_POST['marque'];
    $p->prix = $_POST['prix'];
    $p->stock = $_POST['stock'];
    $p->image = $_POST['image'];
    $p->quantite_valeur = $_POST['quantite_valeur'];
    $p->quantite_unite = $_POST['quantite_unite'];
    $p->id_categorie = $_POST['id_categorie'];

    if ($action == 'add') {
        $p->insertProduit();
    } else {
        $p->updateProduit($_GET['id']);
    }
    header('Location: listeProduit.php');
} elseif ($action == 'delete') {
    $p = new Produit();
    $p->deleteProduit($_GET['id']);
    header('Location: listeProduit.php');
}
function listByCategorie($idCategorie)
{
    $c = new Categorie();
    $p = new Produit();

    $categoryInfo = $c->getCategorieById($idCategorie);
    // On appelle une méthode du modèle Produit qui filtre par id_categorie
    if (method_exists($p, 'getProduitsByCategorie')) {
        $listeProduits = call_user_func([$p, 'getProduitsByCategorie'], $idCategorie);
    } elseif (method_exists($p, 'getProduits')) {
        $listeProduits = [];
        foreach ($p->getProduits() as $produit) {
            if ($produit->id_categorie == $idCategorie) {
                $listeProduits[] = $produit;
            }
        }
    } else {
        $listeProduits = [];
    }

    require('views/front/listeProduit.php');
}
