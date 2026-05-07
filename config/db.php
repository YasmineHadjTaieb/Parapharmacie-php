<?php

/**
 * Fichier de configuration pour la connexion à la Base de Données MySQL
 * Utilise PDO pour une connexion sécurisée et orientée objet
 */

// Paramètres de connexion
$host = 'localhost';      // Serveur MySQL (ton ordinateur)
$db = 'parapharmacie';    // Nom de la base de données
$user = 'root';           // Utilisateur MySQL (par défaut: root)
$pass = '';               // Mot de passe MySQL (vide par défaut en local)
$port = '3306';           // Port MySQL (par défaut: 3306)

// Créer la chaîne DSN (Data Source Name)
$dsn = "mysql:host=$host;dbname=$db;port=$port;charset=utf8mb4";

try {
  // Créer une nouvelle instance PDO (connexion à la BD)
  $pdo = new PDO($dsn, $user, $pass);

  // Configurer le comportement d'erreur: afficher les exceptions
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  // Configurer le mode de récupération par défaut: tableaux associatifs
  $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

  // Configurer l'encodage UTF-8
  $pdo->exec("SET NAMES utf8mb4");
} catch (PDOException $e) {
  // En cas d'erreur de connexion
  die('Erreur de connexion à la base de données: ' . $e->getMessage());
}

// La variable $pdo est maintenant disponible dans tous les fichiers qui incluent ce fichier
