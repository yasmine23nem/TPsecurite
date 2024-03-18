<?php 
require("../config/db.php");
if (isset($_POST['insert_data']) && isset($_POST['user_inp']) && isset($_POST['incoming_id']) && isset($_COOKIE['email']) && isset($_COOKIE['user_id'])) {
    $email = $_COOKIE['email'];
    $user_id = $_COOKIE['user_id'];
    $shift_value = $_POST['shift_value']; // Valeur du décalage



    $outgoing_id = mysqli_real_escape_string($conn, $user_id);
    $incoming_id = mysqli_real_escape_string($conn, $_POST['incoming_id']);
    $msg = mysqli_real_escape_string($conn, $_POST['user_inp']);
    $encryption_method = $_POST['encryption_method']; 
    $shift_value = $_POST['shift_value']; // Valeur du décalage
    $cesar_shift_value = $_POST['cesar_shift_value']; // Valeur du décalage pour César
    $cesar_direction = $_POST['cesar_direction']; 
    $a = $_POST['a_value']; // Valeur de a pour le chiffrement affine
    $b = $_POST['b_value']; // Valeur de b pour le chiffrement affine
    
    
   

    // Encrypter le message en fonction de la méthode choisie
    if ($encryption_method === "cesar") {
        // Appeler la fonction pour le chiffrement César
        $msg = dechiffrement_cesar($msg, $cesar_direction, $cesar_shift_value)[0];
    } else if ($encryption_method === "shift") {
        // Appeler la fonction pour le décalage
        $msg = dechiffrement_decalage($msg, $shift_value)[0];
    } else if ($encryption_method === "affine") {
        // Appeler la fonction pour le chiffrement affine
       // Récupérer les valeurs de a et b du formulaire

// Appeler la fonction pour le chiffrement affine
$msg = dechiffrement_affine($msg, $a, $b)[0];

    }

    // Insérer le message dechiffré dans la base de données
    $query_user = mysqli_query($conn, "INSERT INTO user_msg(incoming_id, outgoing_id, messages) VALUES('$incoming_id','$outgoing_id','$msg')");

    if (!$query_user) {
        echo "An error occurred";
    } else {
        // Retourner le message chiffré pour l'affichage dans le chat
        echo $msg;
    }
} else {
    header("location: ../index.php");
    die;
}
function dechiffrement_affine($texte, $a, $b) {
    $alphabet = 'abcdefghijklmnopqrstuvwxyz';
    $m = strlen($alphabet);
    $resultat = '';

    if (pgcd($a, $m) != 1) {
        throw new Exception("a and m must be coprime.");
    }

    // Calcul de l'inverse modulaire de $a modulo $m
    $inverse_a = 1;
    while (($a * $inverse_a) % $m != 1) {
        $inverse_a++;
    }

    for ($i = 0; $i < strlen($texte); $i++) {
        $lettre = $texte[$i];
        if (strpos($alphabet, $lettre) !== false) {
            $x = strpos($alphabet, $lettre);
            // Formule de déchiffrement affine : x' = (a^-1 * (x - b)) mod m
            $indice = ($inverse_a * ($x - $b)) % $m;
            if ($indice < 0) {
                $indice += $m; // Assurer que l'indice reste positif
            }
            $resultat .= $alphabet[$indice];
        } elseif ($lettre == ' ') {
            $resultat .= ' ';
        }
    }
    return $resultat;
}

?>