<?php
// 1. DÉMARRAGE DE LA SESSION (Toujours en haut de page)
session_start();

// 2. INCLUSION DES MODÈLES
require_once(__DIR__ . '/../../config/db.php');
require_once(__DIR__ . '/../../models/Produit.php');
require_once(__DIR__ . '/../../models/Categorie.php');

// 3. LOGIQUE PRODUITS & CATÉGORIES
$p = new Produit();
$id_cat = isset($_GET['id_cat']) ? $_GET['id_cat'] : null;
$stmt = $p->listProduits($id_cat);

$catModel = new Categorie();
$categories = $catModel->listCategories();

// On vérifie si l'utilisateur est connecté
$isLoggedIn = isset($_SESSION['user_id']);
$userRole = $isLoggedIn ? $_SESSION['role'] : null;
$userName = $isLoggedIn ? $_SESSION['nom_complet'] : 'Invité';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ParaHealth - Boutique</title>
    <!-- CSS Bootstrap Minty -->
    <link rel="stylesheet" href="https://bootswatch.com/5/minty/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        .product-card { transition: transform 0.3s shadow 0.3s; }
        .product-card:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important; }
        .product-link { text-decoration: none; color: inherit; }
        .navbar-brand { font-weight: bold; font-size: 1.5rem; }
    </style>
</head>
<body>

<!-- BARRE DE NAVIGATION DYNAMIQUE -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-5 shadow-sm">
  <div class="container">
    <a class="navbar-brand" href="listeProduit.php">🍃 ParaHealth</a>
    
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarMain">
      <ul class="navbar-nav me-auto">
        <li class="nav-item">
          <a class="nav-link active" href="listeProduit.php"><i class="bi bi-shop"></i> Boutique</a>
        </li>
      </ul>

      <!-- ZONE DE CONNEXION / PROFIL -->
      <ul class="navbar-nav ms-auto">
        <?php if (!$isLoggedIn): ?>
            <!-- SI NON CONNECTÉ -->
            <li class="nav-item">
                <a class="nav-link" href="login.php"><i class="bi bi-box-arrow-in-right"></i> Connexion/ register</a>
            </li>
            <li class="nav-item">
                <a class="nav-link btn btn-light text-primary ms-lg-2" href="register.php">Inscription</a>
            </li>
        <?php else: ?>
            <!-- SI CONNECTÉ -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                    <i class="bi bi-person-circle"></i> Bonjour, <?php echo htmlspecialchars($userName); ?>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <?php if ($userRole === 'admin'): ?>
                        <li><a class="dropdown-item text-danger fw-bold" href="admin/dashboard.php"><i class="bi bi-speedometer2"></i> Administration</a></li>
                        <li><hr class="dropdown-divider"></li>
                    <?php endif; ?>
                    <li><a class="dropdown-item" href="profil.php"><i class="bi bi-person"></i> Mon Profil</a></li>
                    <li><a class="dropdown-item" href="commandes.php"><i class="bi bi-bag-check"></i> Mes Commandes</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item text-muted" href="logout.php"><i class="bi bi-power"></i> Déconnexion</a></li>
                </ul>
            </li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>

<div class="container">
    <div class="row">
        <!-- COLONNE GAUCHE : FILTRES -->
        <div class="col-md-3 mb-4">
            <div class="card border-primary shadow-sm">
                <div class="card-header bg-primary text-white">
                    <i class="bi bi-filter-square"></i> Nos Rayons
                </div>
                <div class="list-group list-group-flush">
                    <a href="listeProduit.php" class="list-group-item list-group-item-action <?php echo !$id_cat ? 'active text-white' : ''; ?>">
                        Tous les produits
                    </a>
                    <?php
                    if (!empty($categories)) {
                        foreach($categories as $cat) {
                            $activeClass = ($id_cat == $cat['id']) ? 'active text-white' : '';
                            echo '<a href="listeProduit.php?id_cat='.$cat['id'].'" class="list-group-item list-group-item-action '.$activeClass.'">
                                    '.htmlspecialchars($cat['nom_categorie']).'
                                  </a>';
                        }
                    }
                    ?>
                </div>
            </div>
            
            <div class="alert alert-info mt-4 shadow-sm">
                <h6 class="alert-heading"><i class="bi bi-megaphone"></i> Offre du moment</h6>
                <p class="small mb-0">-15% sur tous les produits Bio ce mois-ci !</p>
            </div>
        </div>

        <!-- COLONNE DROITE : GRILLE PRODUITS -->
        <div class="col-md-9">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="text-primary fw-bold">Espace Parapharmacie</h2>
                <span class="badge bg-secondary"><?php echo $stmt ? $stmt->rowCount() : 0; ?> produits trouvés</span>
            </div>

            <div class="row">
                <?php if ($stmt && $stmt->rowCount() > 0): ?>
                    <?php while($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="card h-100 shadow-sm border-primary product-card">
                                <!-- Image cliquable -->
                                <a href="detailsProduit.php?id=<?php echo $row['id']; ?>">
                                    <img src="<?php echo htmlspecialchars($row['image'] ?: 'https://via.placeholder.com/200'); ?>" 
                                         class="card-img-top" alt="Produit" style="height: 180px; object-fit: contain; padding: 15px;">
                                </a>
                                
                                <div class="card-body">
                                    <a href="detailsProduit.php?id=<?php echo $row['id']; ?>" class="product-link">
                                        <h5 class="card-title text-dark h6 mb-1"><?php echo htmlspecialchars($row['nom']); ?></h5>
                                    </a>
                                    <p class="card-subtitle mb-2 text-muted small"><?php echo htmlspecialchars($row['marque']); ?></p>
                                    
                                    <div class="d-flex justify-content-between align-items-center mt-3">
                                        <span class="h5 mb-0 text-success fw-bold"><?php echo number_format($row['prix'], 2); ?> DT</span>
                                    </div>
                                </div>
                                
                                <div class="card-footer bg-transparent border-0 d-grid gap-2 pb-3">
                                    <a href="detailsProduit.php?id=<?php echo $row['id']; ?>" class="btn btn-outline-primary btn-sm">
                                        <i class="bi bi-eye"></i> Voir détails
                                    </a>
                                    <button class="btn btn-primary btn-sm">
                                        <i class="bi bi-cart-plus"></i> Ajouter au panier
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="col-12 text-center py-5">
                        <i class="bi bi-emoji-frown fs-1 text-muted"></i>
                        <p class="mt-3 text-muted">Aucun produit ne correspond à cette catégorie.</p>
                        <a href="listeProduit.php" class="btn btn-primary">Voir tous les produits</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<footer class="bg-light text-center py-4 mt-5 border-top">
    <p class="text-muted mb-0">© 2026 ParaHealth - Votre bien-être au naturel</p>
</footer>

<!-- Scripts Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
