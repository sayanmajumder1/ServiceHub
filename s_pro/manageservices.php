<?php
	 
	 session_start();
     if(!isset($_SESSION["email"]))
     {
         header("location:/serviceHub/Signup_login/login.php");
         exit;
     }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Services</title>
    <link rel="stylesheet" href="style.css">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php include 'sidebar.php'; ?>

<div class="main-content">

    <h1 class="page-title">Manage Services</h1>

    <div class="table-container">
        <table class="custom-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Image</th>
                    <th>Sub Service Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Action</th>
                </tr>
            </thead>
            <?php
                                     
                 include_once "connection.php";
                $res=mysqli_query($con,"select subservice.* from subservice inner join service_providers on subservice.service_id=service_providers.service_id
                where subservice.service_id='".$_SESSION['service_id']."'");
                 $count=1;
                 while($row=mysqli_fetch_array($res))
                {
            ?>
            <tbody>
                <tr>
                    <td><?php   echo $count++?></td>
                    <td>
                        <img src="/ServiceHub/Admin/img/<?php echo $row['image']?> "height="125px"width="150px">
                    </td>

                    <td><?php   echo $row['subservice_name']?></td>
                    <td><?php   echo $row['service_des']?></td>
                     <td></td>
                    <td>
                        <a href="#.php?id="><button class="btn-accept">Add</button>
                        <a href="#.php?id="><button class="btn-reject">Edit</button>
                    </td>
                </tr>
                <?php
                    }
                ?>
            </tbody>
        </table>
    </div>

</div>
<script src="script.js"></script>
</body>
</html>
