<?php
require_once "includes/dbconnect.php";

if (isset($_GET['delid'])) {
    $delSQL = "DELETE FROM aboutus WHERE aboutID = ?";
    $data = array($_GET['delid']);
    try {
        $stmtDEL = $con->prepare($delSQL);
        $stmtDEL->execute($data);
        header("Location: aboutus.php");
        exit(); 
    } catch (PDOException $th) {
        echo $th->getMessage();
    }
}
if (isset($_POST['txtTitle'])) {
    if (isset($_POST['txtTitle'])) {
    $title = htmlspecialchars(trim($_POST['txtTitle']));
    $content = trim($_POST['txtContent']);
    $content = filter_var($content, FILTER_SANITIZE_STRING); 
    }

    try {
        $sql = "INSERT INTO aboutus(atitle, acontent) VALUES(?, ?)";
        $data = array($title, $content);
        $stmt = $con->prepare($sql);
        $stmt->execute($data);
        header("Location: aboutus.php");
        exit(); 
    } catch (PDOException $th) {
        echo $th->getMessage();
    }

}
?>
