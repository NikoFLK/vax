<?php
include ('inc/pdo.php');
include ('inc/fonction.php');


$id = $_GET['id'];
$sql = "UPDATE vax_vaccins
        SET status = '0'
        WHERE id = $id";
$query = $pdo -> prepare($sql);
$query -> execute();

header('Location:vaccins_back.php');
