<?php
 $host=$_POST['host'];
 $username=$_POST['user'];
 $password=$_POST['password'];
 $userdb=$_POST['db'];
 $fila=$_POST['fila'];
 $manager = new MongoDB\Driver\Manager("mongodb://{$host}/{$userdb}", array("username" => $username, "password" => $password));
 echo "<center><h2>Coleccion $fila</h2></center>";
 $filter = [];
 $options = [];
 $query = new MongoDB\Driver\Query($filter, $options);
 $cursor = $manager->executeQuery("{$userdb}.{$fila}", $query);
 $array = $cursor->toArray();
 foreach($array as $document) {
     $document = json_decode(json_encode($document),true);
     print_r($document);
     echo "<br/>";
 }
?>
