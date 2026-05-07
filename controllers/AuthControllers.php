<?php
session_start();
require_once(__DIR__ . '/../config/db.php');
require_once(__DIR__ . '/../models/Utilisateur.php');

$action = $_GET['action'] ?? $_POST['action'] ?? 'home';

if ($action == 'login') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $auth = new Utilisateur();
        $user = $auth->connexion($_POST['email'] ?? '');

        if ($user && password_verify($_POST['password'] ?? '', $user['mot_de_passe'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['nom'] = $user['nom_complet'];
            $_SESSION['role'] = $user['role'];

            if ($user['role'] == 'admin') {
                header('Location: ../views/admin/dashboard.php');
                exit();
            } else {
                header('Location: ../views/produit/listeProduit.php');
                exit();
            }
        } else {
            header('Location: ../views/auth/login.php?error=1');
            exit();
        }
    }
}

if ($action == 'register') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $auth = new Utilisateur();
        $res = $auth->inscription(
            $_POST['nom_complet'] ?? '',
            $_POST['email'] ?? '',
            $_POST['password'] ?? '',
            $_POST['adresse'] ?? '',
            $_POST['telephone'] ?? ''
        );
        if ($res) {
            header('Location: ../views/auth/login.php?success=1');
            exit();
        }
    }
}

if ($action == 'logout') {
    session_destroy();
    header('Location: ../views/produit/listeProduit.php');
    exit();
}
