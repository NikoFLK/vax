<?php
include 'inc/pdo.php';
include 'inc/fonction.php';
include 'inc/request.php';
include 'inc/header.php';

if (isLogged()==false){
 header('Location:403.php');
}

if($_SESSION['user']['status'] == 'banni'){
  header('Location:403.php');
}

if(!empty($_SESSION['user']['taille']) && !empty($_SESSION['user']['poids'])){
  $taille = $_SESSION['user']['taille']/100;
  $poids = $_SESSION['user']['poids'];
  $imc = $taille*$taille;
  $imc = $poids/$imc;

  if ($imc<=20){
    $resultimc = 'insuffisance';
  }
  else if ($imc>20 && $imc<=25){
    $resultimc = 'bon';
  }
  else if ($imc>=25 && $imc<=27){
    $resultimc = 'exces';
  }
  else{
    $resultimc = 'risque';
  }
}
?>

<div class="profil">
  <aside class="aside">
    <div class="pp"><img class="bonhomme" src="img/avatar.jpg" alt=""></div>
      <div class="trait"></div>
      <div class="clear"></div>
      <h3>Informations principales : </h3>

        <?php //infos profil
        
              if(!empty($_SESSION['user']['prenom'])){
                echo '<p>'.$_SESSION['user']['prenom'].'</p>';
              }
              if(!empty($_SESSION['user']['nom'])){
                echo '<p>'.$_SESSION['user']['nom'].'</p>';
              }
              if(!empty($_SESSION['user']['taille'])){
                echo '<p> taille : '.$_SESSION['user']['taille'].' cm</p>';
              }
              if(!empty($_SESSION['user']['poids'])){
                echo '<p> poids :'.$_SESSION['user']['poids'].' kg</p>';
              }
              if(!empty($_SESSION['user']['taille']) && !empty($_SESSION['user']['poids'])){
                echo '<p>IMC = '.round($imc, 3).'</p>';
              }
        ?>

  </aside>
  <div class="carnet">
    <h2>Votre Carnet</h2>

    <div class="listeVaccin">
      <form action="carnet.php" method="post">

          <?php 
            $listeVaccin = b_select_vaccin_from_vaccins();
            $listeVaccinUser = b_select_vaccinanduser_from_pivot($_SESSION['user']['id']);
            $nope = 1;
            print_r($_POST);
            br();            

            foreach($listeVaccin as $cle=>$valeur){
              
              $nom = $listeVaccin[$cle]['nom'];
              $date = $listeVaccin[$cle]['nom'].'_Rappel';

              if (!empty($_POST)){

                foreach($_POST as $cursor=>$valeur){
                  if ($cursor == $nom){
                    b_insert_vaccin_in_pivot($_SESSION['user']['id'],$listeVaccin[$cle]['id']);
                  }
                  if ($cursor == $date){
                    echo $_POST[$cursor];
                    $rappel = str_replace($_POST[$cursor],"-", "/"); //probleme ps pense a la requete en update
                    echo $rappel;
                    //b_update_rappel_in_pivot($rappel);
                  }
                }
              }
              
                foreach($listeVaccinUser as $key=>$valeur){

                    if ($listeVaccin[$cle]['id'] == $listeVaccinUser[$key]['id_vaccins']){
                      ?>
                      <input type="checkbox" name="<?php echo $nom;?>" checked="checked" disabled="disabled">
                      <input type="date" name="<?php echo $nom; ?>_Rappel" value="confirmer">
                      <span class="check"><?php echo $nom; ?></span><br/> <?php
                      $nope = 0;
                      break;
                    }
                    else {
                      $nope = 1;
                    }
                }
                  if ($nope == 1) {
                  ?>
                  <input type="checkbox" name="<?php echo $listeVaccin[$cle]['nom'];?>">
                  <span><?php echo $listeVaccin[$cle]['nom']; ?></span><br/> <?php
                }
              
            } ?>
    </div>
    
          <input type="submit" name="listeRappel" value="confirmer">
      </form>
    

    </div>
    <a class="myButton button"href="profil_edit.php">éditer profil</a>
    <a class="myButton"href="carnet.php">Mon carnet</a>
    <div class="clear"></div>
  </div>
</div>

<div class="clear"></div>
<?php include 'inc/footer.php';
