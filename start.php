<?php

$pdo = new PDO(
  'mysql:host=localhost;dbname=blog',
  'root',
  '');

$res = $pdo->query("SELECT * FROM `posts`");

foreach ($res AS $row)
{
  var_dump($row);
}



 ?>
