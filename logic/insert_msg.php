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

    // Encrypter le message en fonction de la méthode choisie
    if ($encryption_method === "cesar") {
        // Appeler la fonction pour le chiffrement César
        $msg = chiffrement_cesar($msg, $cesar_direction, $cesar_shift_value)[0];
    } else if ($encryption_method === "shift") {
        // Appeler la fonction pour le décalage
        $msg = chiffrement_decalage($msg, $shift_value)[0];
    } else if ($encryption_method === "affine") {
        // Appeler la fonction pour le chiffrement affine
        $msg = chiffrement_affine($msg, 5, 8)[0];
    }

    
  // Insérer le message chiffré dans la base de données
$query_user = mysqli_query($conn, "INSERT INTO user_msg(incoming_id, outgoing_id, messages, message_decrypter) VALUES('$incoming_id','$outgoing_id','$msg', '{$_POST['user_inp']}')");

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

function chiffrement_cesar($texte, $direction, $decalage=1) {
    $alphabet = 'abcdefghijklmnopqrstuvwxyz0123456789';
    $resultat = '';

    for ($i = 0; $i < strlen($texte); $i++) {
        $lettre = $texte[$i];
        if (strpos($alphabet, $lettre) !== false) {
            if ($direction == 'droite') {
                $indice = (strpos($alphabet, $lettre) + $decalage) % strlen($alphabet);
            } else {
                $indice = (strpos($alphabet, $lettre) - $decalage) % strlen($alphabet);
            }
            $resultat .= $alphabet[$indice];
        } else {
            $resultat .= $lettre;
        }
    }
    return array($resultat, $decalage);
}

function chiffrement_decalage($texte, $decalage) {
    $alphabet = 'abcdefghijklmnopqrstuvwxyz';
    $resultat = '';

    for ($i = 0; $i < strlen($texte); $i++) {
        $lettre = $texte[$i];
        if (strpos($alphabet, $lettre) !== false) {
            $indice = (strpos($alphabet, $lettre) + $decalage) % strlen($alphabet);
            $resultat .= $alphabet[$indice];
        } else {
            $resultat .= $lettre;
        }
    }
    return array($resultat, $decalage);
}
function pgcd($a, $b) {
    while ($b != 0) {
        $t = $b;
        $b = $a % $b;
        $a = $t;
    }
    return $a;
}

function chiffrement_affine($texte, $a, $b) {
    $alphabet = 'abcdefghijklmnopqrstuvwxyz';
    $m = strlen($alphabet);
    $resultat = '';
    $espaces = [];

    if (pgcd($a, $m) != 1) {
        throw new Exception("a and m must be coprime.");
    }

    for ($i = 0; $i < strlen($texte); $i++) {
        $lettre = $texte[$i];
        if (strpos($alphabet, $lettre) !== false) {
            $x = strpos($alphabet, $lettre);
            $indice = (bcmod(bcmul($a, $x), $m) + $b) % $m;
            $resultat .= $alphabet[$indice];
        } elseif ($lettre == ' ') {
            $espaces[] = strlen($resultat);
            $resultat .= ' ';
        }
    }
    return array($resultat, $espaces);
}
?>