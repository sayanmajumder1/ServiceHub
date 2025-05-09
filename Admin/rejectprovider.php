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
    <title>Reject Provider</title>
    <!-- Bootstrap 5 CSS -->
    <link href="./css/bootstrap.min.css" rel="stylesheet" >
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="custom.css">
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
                    <p style="padding:5px;font-size:2.2rem">Rejected Service provider</p>
                    <table class="table">
                    <thead>
                        <tr>
                        <th scope="col">#</th>
                        <th scope="col">Provider Name</th>
                        <th scope="col">Service Category</th>
                        <th colspan='2'>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php

                        $count=1;
                        $value='rejected';
                        include_once "connection.php";
                        $res = mysqli_query($con, "SELECT *, service.service_name FROM service_providers INNER JOIN service ON
                        service_providers.service_id = service.service_id WHERE service_providers.approved_action = '$value'");
                        while($row=mysqli_fetch_array($res))
                        {

                    ?>
                        <tr>
                        <th scope="row"><?php echo $count++ ?></th>
                        <td data-label="Provider Name"><?php echo $row['provider_name'] ?></td>
                        <td data-label="Service category"><?php echo $row['service_name'] ?></td>
                        <td data-label="Action"><a href="review.php?id=<?php echo $row['provider_id']; ?>"><button type="button" class="btn btn-outline-primary">Review</button></a></td>
                        <!-- <td data-label="Action"><button type="button" class="btn btn-outline-danger">Deactive</button></td> -->
                        </tr>
                    <?php
                        }
                    ?>
                    </tbody>
                    </table>
                </div>
        </div>
    </div>
    <!-- Bootstrap JS Bundle with Popper -->
    <script src="./js/bootstrap.bundle.min.js"></script>
    <script src="btn.js"></script>
</body>
</html>