<?php
include 'inc/pdo.php';
include 'inc/request.php';
include 'inc/fonction.php';
include 'inc/header.php';

if (isLogged()==false){
 header('Location:403.php');
}

if($_SESSION['user']['status'] == 'banni'){
  header('Location:403.php');
}

$id = $_SESSION['user']['id'];
$user = profil($id);

if(!empty($user['taille']) && !empty($user['poids'])){
  $taille = $user['taille']/100;
  $poids = $user['poids'];
  $imc = $taille*$taille;
  $imc = $poids/$imc;
  $imc = round($imc, 3);

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
<div class='profil'>

  <h2>Votre profil</h2>

    <aside>
      <?php if(!empty($user['sexe']) && $user['sexe'] == 'homme'){
        echo '<img src="img/avatar.jpg"    alt="avatar">';
      }elseif(!empty($user['sexe'] && $user['sexe'] == 'femme')){
        echo '<img src="img/avatar2.jpg" alt="avatar">';
      }else{
        echo '<img src="img/avatar3.jpg" alt="avatar">';

      } ?>
        <div class="trait"></div>
        <h3>Informations principales : </h3>
        <ol>
          <li><?php echo $user['prenom'] ?></li>
          <li><?php echo $user['nom'] ?></li>
          <li><?php echo $user['mail'] ?></li>
        </ol>
    </aside>

    <div class='main'>
        <h3>Informations à remplir :</h3>
        <ul>
          <li>date de naissance : <?php echo $user['ddn'] ?></li>
          <li>sexe : <?php echo $user['sexe'] ?></li>
          <li>taille : <?php echo $user['taille'] ?></li>
          <li>poids : <?php echo $user['poids'] ?></li>
          <li>statut : <?php echo $user['status'] ?></li>
          <li class="<?php echo $resultimc ?>">Indice de masse corporelle : <?php if(!empty($imc)){ echo $imc; } ?></li>
          <li><a class="myButton button"href="profil_edit.php">éditer profil</a></li>
          <li><a class="myButton" href="carnet.php">Mon carnet</a></li>
        </ul>
  </div>
</div>


<?php
include 'inc/footer.php'; ?>
