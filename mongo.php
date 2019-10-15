<?php
if (@$_POST['sub']){
 $host=$_POST['host'];
 $username=$_POST['username'];
 $password=$_POST['password'];
 $userdb=$_POST['database'];
 $database=$userdb.".phptest";
  try{
       $manager = new MongoDB\Driver\Manager("mongodb://{$host}/{$userdb}", array("username" => $username, "password" => $password));
       if ($manager) {
        $bulk = new MongoDB\Driver\BulkWrite;
        $bulk->insert(['x' => 1]);
        $bulk->insert(['x' => 2]);
        $bulk->insert(['x' => 3]);
        $manager->executeBulkWrite($database, $bulk);
        $filter = ['x' => ['$gt' => 1]];
        $options = [
            'projection' => ['_id' => 0],
            'sort' => ['x' => -1],
        ];
        $query = new MongoDB\Driver\Query($filter, $options);
        $cursor = $manager->executeQuery($database, $query);
            }
  }catch(Exception $e){
    echo  "<center><h1>Error de conexión.</h1></center>";
    print_r($e);
        exit;
  }
}
if ($host){
 $manager = new MongoDB\Driver\Manager("mongodb://{$host}/{$userdb}", array("username" => $username, "password" => $password));
 echo "<center><h2>Bienvenido $username</h2></center>";
 $listcollections = new MongoDB\Driver\Command(["listCollections" => 1]);
 $result = $manager->executeCommand($userdb, $listcollections);
 $collections = $result->toArray();
 foreach ($collections as $collection) {
     $fila = $collection->name;
     echo "<form method=post action=coleccion.php>";
     echo "<input type=hidden name=host value={$_POST['host']}>";
     echo "<input type=hidden name=user value={$_POST['username']}>";
     echo "<input type=hidden name=password value={$_POST['password']}>";
     echo "<input type=hidden name=db value={$_POST['database']}>";
     echo "<input type=submit name=fila value={$fila}>";
     echo "</form>";
 }
}
?>
