<?php
    
    session_start();
    if(!isset($_SESSION["username"]))
    {
        header("location:adminlog.php");
        exit;
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Update</title>
    <!-- Bootstrap 5 CSS -->
    <link href="./css/bootstrap.min.css" rel="stylesheet" >
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="custom.css">
    <link rel="stylesheet" href="hideScrollbar.css">
</head>
<body>
    <div class="d-flex ">
    <!-- Sidebar -->
        <?php
            include_once "sidenav.php";
        ?>
        <div class="main-content p-4" id="mainContent">
            <button class="btn btn-primary d-lg-none mb-3" id="sidebarToggle">
                <i class="bi bi-list"></i> Menu
            </button>
            <div class="o35">
                <?php

                    include_once "connection.php";

                    $res=mysqli_query($con,"select * from admin where admin_id='".$_GET['id']."'");

                    $row=mysqli_fetch_array($res);
                ?>
                <div class="col-md-8">
                    <div class="card-body ab2">
                        <h2>Admin Details Update:</h2>
                        <p class="card-text"> 
                            <form method="POST" action="adminupdate_data.php" >
                                <div class="mb-3">
                                    <label>Name:</label><br>
                                    <input type="text" name="id" id="id" value="<?php echo $row['admin_id']?>" class="con1" hidden>
                                    <input type="text" name="name" id="name" value="<?php echo $row['name'] ?>" class="con1" required>
                                </div>
                                <div class="mb-3">
                                    <label>User Name:</label><br>
                                    <input type="text" name="uname" id="uname" value="<?php echo $row['username']?>" class="con1" required>
                                </div>
                                <div class="mb-3">
                                    <label>Email:</label><br>
                                    <input type="text" name="umail" id="umail" value="<?php echo $row['email'] ?>" class="con1" required>
                                </div>
                                <div class="mb-3">
                                    <label>Phone:</label><br>
                                    <input type="text" name="uphone" id="uphone" value="<?php echo $row['no'] ?>" class="con1"required>
                                </div>
                                <div class="mb-3">
                                    <label>Password:</label><br>
                                    <input type="text" name="upass" id="upass" value="<?php echo $row['password'] ?>" class="con1" required>
                                </div>
                                <button type="submit" class="btn btn-outline-success">Update Details</button>
                            </form>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap JS Bundle with Popper -->
    <script src="./js/bootstrap.bundle.min.js"></script>
    <script src="btn.js"></script>
</body>
</html>