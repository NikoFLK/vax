<?php
include ('inc/pdo.php');
include ('inc/fonction.php');
include ('inc/header.php');
?>

<div class="profil">
  <div class="pp"><img class="bonhomme" src="img/bonhomme.png" alt=""></div>
  <div class="clear"></div>
  <div class="trait"></div>
  <p> le BG <?php echo tab($_SESSION['user']); ?>
  </p>
  <div class="trait"></div>
  <ul>
    <li><a href="#">vaccin 1</a></li>
    <li><a href="#">vaccin 2</a></li>
    <li><a href="#">vaccin 3</a></li>
  </ul>
</div>

<div class="liste">
  <ul>
    <li><a href="#"> Date | Maladie | Vaccin </a></li>
    <li><a href="#"> Date | Maladie | Vaccin </a></li>
    <li><a href="#"> Date | Maladie | Vaccin </a></li>
  </ul>
</div>

<p>
  <?php echo rappel(); ?>
</p>

<div class="clear"></div>

<?php include 'inc/footer.php';
