<?php
require_once "includes/dbconnect.php";

$selID=0;
$title=NULL;
$author=NULL;
$story=NULL;
$dateposted=NULL;

if (isset($_GET['editid'])) {
    try {
        $selID = $_GET['editid'];
        $selSQL = "SELECT * FROM news WHERE md5(newsID) = ?";
        $selData=array($selID);
        $stmtSel=$con->prepare($selSQL);
        $stmtSel->execute($selData);
        if($stmtSel->rowCount()!=0){$rowSel = $stmtSel->fetch();
            $title = ($rowSel[1]);  
            $author = ($rowSel[2]);
            $story=($rowSel[3]);
        }
         
    } catch (\Throwable $th) {
        //throw $th;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Tables - SB Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">
    <!--Header-->
    <?php include "includes/header.php" ?>
    <!--End of Header-->

    <!--Side Bar-->
    <div id="layoutSidenav">
        <?php include "includes/sidebar.php" ?>
    </div>
    <!--End of Side Bar-->
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">News</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                    <li class="breadcrumb-item active">Tables</li>
                </ol>
                <div class="card mb-4">
                    <div class="card-body">
                        This page allows end-users to facilitate adding, modifying, updating, and deleting ABOUT US.
                        <div class="d-grid gap-2 d-md-block">
                            <button class="btn btn-primary" type="button">Add new record</button>
                        </div>
                    </div>
                </div>

                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane"
                            type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">Records</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="data-tab" data-bs-toggle="tab" data-bs-target="#data-tab-pane"
                            type="button" role="tab" aria-controls="data-tab-pane" aria-selected="false">Data Entry</button>
                    </li>
                </ul>

                <!--Tab Panels-->
                <div class="tab-content" id="myTabContent">
                    <!--Table-->
                    <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab"
                        tabindex="0">

                        <div class="card mb-4">
                            <div class="card-header">
                                Aboutus Record
                            </div>
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Title</th>
                                            <th>Author</th>
                                            <th>Date Posted</th>
                                            <th>Story</th>
                                            <th>Picture</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $sqlnews = "SELECT newsID,title,author,datePosted,story,picture, md5(newsID) FROM news";
                                        $stmtnews = $con->prepare($sqlnews);
                                        $stmtnews->execute();
                                        $strTable = "";
                                        while ($row = $stmtnews->fetch()) {
                                            $strTable .= "<tr>";
                                            $strTable .= "<td>{$row[0]}</td>";
                                            $strTable .= "<td>{$row[1]}</td>";
                                            $strTable .="<td>{$row[2]}</td>";
                                            $strTable .="<td>{$row[3]}</td>";
                                            $strTable .="<td>{$row[4]}</td>";
                                            $strTable .="<td>{$row[5 ]}</td>";

                                            $strDelButton = "<button class='btn btn-warning' title='Delete Record'>
                                                                <a href='save_news.php?delid={$row[0]}'>
                                                                <i class='bx bx-trash'></i>
                                                                </a>
                                                            </button>";
                                            $strEditButton = "<button class='btn btn-info' title='Edit Record'>
                                                                 <a href='news.php?editid={$row[0]}'>
                                                                <i class='bx bx-message-square-edit'></i>
                                                                </a>
                                                            </button>";
                                            $strTable .= "<td><div style='white-space:nowrap'>{$strDelButton} {$strEditButton}</div></td>";
                                            $strTable .= "</tr>";
                                        }
                                        echo $strTable;
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>

                    <!--Data Entry-->
                    <div class="tab-pane fade" id="data-tab-pane" role="tabpanel" aria-labelledby="data-tab" tabindex="0">
                        <br>
                        <h1>Data Entry:</h1>

                        <form action="save_news.php" method="POST">
                        <input type="hidden" class="form-control" name="txtid" id="txtid" required
                        value='<?php echo htmlspecialchars($rowSel[0]); ?>'>
                            <div class="mb-3">
                                <label for="txtTitle" class="form-label">Title:</label>
                                <input type="text" class="form-control" name="txtTitle" id="txtTitle" required
                                value='<?php echo htmlspecialchars($title); ?>'>
                            </div>
                            <div class="row">
                                <div class="col col-lg-6">
                                    <div class="mb-3">
                                        <label for="txtAuthor" class="form-label">Author:</label>
                                        <input type="text" class="form-control" name="txtAuthor" id="txtAuthor" required
                                        value='<?php echo htmlspecialchars($title); ?>'>
                                    </div>
                                </div>

                                <div class="col col-lg-6">
                                    <div class="mb-3">
                                        <label for="datePosted" class="form-label">Date Posted:</label>
                                        <input type="date" class="form-control" name="datePosted" id="datePosted" required
                                        value='<?php echo htmlspecialchars($title); ?>'>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="txtStory" class="form-label">Story:</label>
                                <textarea class="form-control" name="txtStory" id="exampleFormControlTextarea1" rows="5"
                                    required><?php echo htmlspecialchars($story); ?></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="txtPicture" class="form-label">Image:</label>
                                <input type="file" id="fileUpload" name="picture" accept="image/*" class="form-control">
                            </div>
                            <button type="submit">Submit</button>

                        </form>
                    </div>

                </div>
            </div>
        </main>
        <?php include "includes/footer.php" ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
        crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>
</body>

</html>
