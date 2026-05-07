<?php
require_once(__DIR__ . '/../../config/db.php');
require_once(__DIR__ . '/../../models/Produit.php');

$p = new Produit();
$id = isset($_GET['id']) ? $_GET['id'] : null;

if (!$id) {
    header('Location: listeProduit.php');
    exit();
}


$stmt = $p->getProduit($id); 
$produit = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$produit) {
    echo "Produit introuvable.";
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($produit['nom']); ?> - ParaHealth</title>
    <link rel="stylesheet" href="https://bootswatch.com/5/minty/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-5">
  <div class="container">
    <a class="navbar-brand" href="listeProduit.php">🍃 ParaHealth</a>
  </div>
</nav>

<div class="container">
    <div class="row">
        <!-- Image du produit -->
        <div class="col-md-5 mb-4">
            <div class="card shadow-sm p-3">
                <img src="<?php echo htmlspecialchars($produit['image'] ?: 'https://via.placeholder.com/400'); ?>" 
                     class="img-fluid rounded" alt="Image produit">
            </div>
        </div>

        <!-- Détails du produit -->
        <div class="col-md-7">
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="listeProduit.php" class="text-primary">Boutique</a></li>
                <li class="breadcrumb-item active"><?php echo htmlspecialchars($produit['nom']); ?></li>
              </ol>
            </nav>

            <h1 class="text-primary display-6"><?php echo htmlspecialchars($produit['nom']); ?></h1>
            <p class="text-muted mb-4">Marque : <strong><?php echo htmlspecialchars($produit['marque']); ?></strong></p>
            
            <h2 class="text-success mb-4"><?php echo number_format($produit['prix'], 2); ?> DT</h2>

            <div class="card border-light bg-light mb-4">
                <div class="card-body">
                    <h5 class="card-title"><i class="bi bi-info-circle text-primary"></i> Description</h5>
                    <p class="card-text" style="white-space: pre-line;">
                        <?php echo htmlspecialchars($produit['description']); ?>
                    </p>
                </div>
            </div>

            <p class="small text-muted">Contenance : <?php echo $produit['quantite_valeur'].' '.$produit['quantite_unite']; ?></p>

            <div class="d-grid gap-2 d-md-flex mt-4">
                <button class="btn btn-primary btn-lg px-5">
                    <i class="bi bi-cart-plus"></i> Ajouter au panier
                </button>
                <a href="listeProduit.php" class="btn btn-outline-secondary btn-lg">
                    Retour
                </a>
            </div>
        </div>
    </div>
</div>

<footer class="bg-light text-center py-4 mt-5">
    <p class="text-muted">© 2026 ParaHealth - Votre bien-être au naturel</p>
</footer>

</body>
</html>
?>