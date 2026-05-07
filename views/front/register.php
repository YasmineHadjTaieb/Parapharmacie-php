<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>ParaHealth - Inscription</title>
    <link rel="stylesheet" href="https://bootswatch.com/5/minty/bootstrap.min.css">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow-sm border-primary">
                <div class="card-header bg-primary text-white text-center">
                    <h4>Créer un compte</h4>
                </div>
                <div class="card-body">
                    <form action="../../controllers/AuthController.php?action=register" method="POST">
                        <div class="mb-3">
                            <label class="form-label">Nom Complet</label>
                            <input type="text" name="nom_complet" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="mb-2 row">
                            <div class="col">
                                <label class="form-label">Téléphone</label>
                                <input type="text" name="telephone" class="form-control">
                            </div>
                            <div class="col">
                                <label class="form-label">Mot de passe</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Adresse</label>
                            <textarea name="adresse" class="form-control" rows="2"></textarea>
                        </div>
                        <button type="submit" class="btn btn-success w-100">S'inscrire</button>
                    </form>
                    <div class="text-center mt-3">
                        <a href="login.php" class="small">Déjà un compte ? Connectez-vous</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>