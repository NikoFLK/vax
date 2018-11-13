<?php
include 'inc/pdo.php';
include ('inc/request.php');
include 'inc/fonction.php';
include 'inc/header.php';

if (isLogged() == false && $_SESSION['user']['status'] != 'admin'){
  header('Location:403.php');
}
// Requete sql pagination
  $countVaccins = b_vaccins_back();

// Variables pagination
$nbVaccins = $countVaccins['nbVaccins'];
$vaccinsParPages = 2;
$nbPages = ceil($nbVaccins/$vaccinsParPages);

if(!empty($_GET['p']) && $_GET['p']>0 && $_GET['p'] <= $nbPages){
  $cPage = $_GET['p'];
}else{
  $cPage = 1;
}

// Requete SQL affichage
  $vaccins = b_vaccins_back1($cPage, $vaccinsParPages);
?>

<!-- Affichage des vaccins en tableau -->
<table>
  <thead>
    <th>id</th>
    <th>nom du vaccin</th>
    <th>maladie ciblée</th>
    <th>Informations complémentaires</th>
    <th>Âge Recommandé</th>
    <th>Supprimer un vaccin</th>
    <th>statut (0 = supprimé, 1 = visible)</th>
  </thead>
  <tbody>
    <?php foreach ($vaccins as $vaccin):?>
      <td><?php echo $vaccin['id'] ?></td>
      <td><?php echo $vaccin['nom'] ?></td>
      <td><?php echo $vaccin['maladie_cible'] ?></td>
      <td><?php echo $vaccin['info'] ?></td>
      <td><?php echo $vaccin['age_recommande'] ?></td>
      <td> <a class="myButton" href="b_rm_vaccin.php?id=<?php echo $vaccin['id'] ?>">Supprimer</a>
           <a class="myButton" href="b_cancel_vaccin.php?id=<?php echo $vaccin['id'] ?>">Annuler</a> </td>
      <td><?php echo $vaccin['status'] ?></td>
    </tbody>
  <?php endforeach; ?>
</table>

<?php // liens de pagination
for ($i = 1; $i <=  $nbPages; $i++) {
  if ($i==$cPage) {
    echo $i, '/';
  }else {
    echo '<a href="b_vaccins_back.php?p='.$i.'">'.$i.'</a>/';
  }
}?>

<!-- Boutons pratiques -->
<br><a class="myButton" href="b_add_vaccin.php">Ajouter un vaccin</a>
<br><a class="myButton" href="b_back.php">Retour à l'accueil</a>

<?php include 'inc/footer.php'; ?>
