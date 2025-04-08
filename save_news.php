<?php
require_once "includes/dbconnect.php";

if (isset($_GET['delid'])) {
    $delSQL = "DELETE FROM news WHERE newsID = ?";
    $data = array($_GET['delid']);
    try {
        $stmtDEL = $con->prepare($delSQL);
        $stmtDEL->execute($data);
        header("Location: news.php");
        exit(); 
    } catch (PDOException $th) {
        echo $th->getMessage();
    }
}

if (isset($_POST['txtTitle'])) {
    $id=$_POST['txtid'];
    $title = htmlspecialchars(trim($_POST['txtTitle']));
    $author = htmlspecialchars(trim($_POST['txtAuthor']));    
    $story = trim($_POST['txtStory']);
    $dateposted=$_POST['datePosted'];
    $picture=($_POST['picture']);
    $story = filter_var($story, FILTER_SANITIZE_STRING); 
    try {
        $sql = "INSERT INTO news(title, author,datePosted,story,picture) VALUES(?, ?,?,?,?)";
        $data = array($title, $author, $dateposted, $story,$picture);

        $stmt = $con->prepare($sql);
        $stmt->execute($data);
        header("Location: news.php");
        exit(); 
    } 
    
    catch (PDOException $th) {
        echo $th->getMessage();
    }
    }
?>
