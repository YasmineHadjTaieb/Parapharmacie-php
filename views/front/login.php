<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>ParaHealth - Connexion</title>
    <link rel="stylesheet" href="https://bootswatch.com/5/minty/bootstrap.min.css">
</head>

<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card shadow-sm border-primary">
                    <div class="card-header bg-primary text-white text-center">
                        <h4>Connexion</h4>
                    </div>
                    <div class="card-body">
                        <?php if (isset($_GET['error'])) echo '<div class="alert alert-danger">Identifiants incorrects</div>'; ?>
                        <form action="../../controllers/AuthController.php" method="POST">
                            <input type="hidden" name="action" value="login">

                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Mot de passe</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Se connecter</button>
                        </form>
                        <hr>
                        <div class="text-center">
                            <p class="small">Pas encore de compte ? <a href="register.php">Inscrivez-vous ici</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>