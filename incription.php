<?php
include ('inc/pdo.php');
include ('inc/fonction.php');
include ('inc/request.php');

$errors = array();
$success = false;
if(!empty($_POST['submit'])){
  // failles XSS

  $mail = trim(strip_tags($_POST['mail']));
  $mdp = trim(strip_tags($_POST['mdp']));
  $mdpV = trim(strip_tags($_POST['mdpV']));



  // Verif mail
  if(!empty($_POST['mail'])){
    if(filter_var($mail, FILTER_VALIDATE_EMAIL)){
      if(strlen($mail) < 5 || (strlen($mail) >150)){
        $errors['mail'] = "Veuillez entrer un mail valide";
      }else{
        incription($mail);
        if(!empty($userMail)){
          $errors['mail'] = "Adresse mail déja utilisée";
        }
      }
    }else{
      $errors['mail'] = 'Veuillez entrer une adresse mail valide';
    }
  }else{
      $errors['mail'] = "Veuillez renseigner une adresse mail";
  }

  // Verif taille mdp
  if(!empty($_POST['mdp'])){
    if(strlen($mdp) < 6 || strlen($mdp) > 100){
      $errors['mdp'] = "Veuillez entrer un mot de passe valide";
    }
  } else{
      $errors['mdp'] = "Veuillez entrer un mot de passe valide";
    }

  // MDPS identiques
  if($mdp != $mdpV){
    $errors['mdp'] = "Les mots de passe ne correspondent pas";
  }


  // S'il n'y a pas d'erreurs
  if(count($errors) == 0){
    $success = true;
    $hash = password_hash($mdp, PASSWORD_DEFAULT);
    $token = generateRandomString(120);
    incription1($mail, $token, $hash);
    header('Location:redirection.php');
  }
}

?>
