<?php
$host="localhost";
$dbase="dbValdez";
$username="root";
$password="";
$dsn="mysql:host={$host};dbname={$dbase}";

try{
    $con=new PDO($dsn,$username,$password);
    if($con){
        // echo "Connection Successful";
    }
}catch(PDOException $th){
    echo "Error :" .$th->getMessage();
}

?>