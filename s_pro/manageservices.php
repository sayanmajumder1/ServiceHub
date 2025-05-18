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
                 $res=mysqli_query($con,"select * from subservice where service_id='".$_SESSION['service_id']."'");
                 
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
                    <?php
                        $res1=mysqli_query($con,"select price from subservice_price_map where subservice_id='".$row['subservice_id']."'");
                        $row1=mysqli_fetch_assoc($res1);
                        if(empty($row1['price']))
                        {
                    ?>
                    <td> <?php   echo "Nil"?></td>
                    <?php
                        }
                        else
                        {
                    ?>
                        <td> <?php   echo $row1['price']?></td>

                    <?php
                        }
                    ?>
                    
                 
                    <td>
                        <?php
                            if(empty($row1['price']))
                            {
                            ?>
                            <a href="addsubservice_price.php?id=<?php echo $row['subservice_id'] ?>"><button class="btn-accept">Add Price</button>
                        <?php
                            }
                            else
                            {
                        ?>
                        <a href="updatesubservice_price.php?id=<?php echo $row['subservice_id'] ?>"><button class="btn btn-primary">Edit Price</button>
                        <?php
                            }
                        ?>
                        
                        
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
