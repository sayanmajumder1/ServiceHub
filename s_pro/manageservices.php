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
    <style>
       .modal-header{
            background-color:rgb(150, 60, 186);
            color: white;
        }
    </style>
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
                        $res1=mysqli_query($con,"select price from subservice_price_map where subservice_id='".$row['subservice_id']."' and 
                        provider_id='".$_SESSION['id']."'");
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
                        <a href="updatesubservice_price.php?subservice_id=<?php echo $row['subservice_id'] ?>&provider_id=<?php echo $_SESSION['id']; ?>">
                            <button class="btn btn-primary">Edit Price</button>
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

<!-- Modal HTML -->
<div class="modal fade" id="acceptedModal"  aria-labelledby="acceptedModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="acceptedModalLabel">Message</h1>
      </div>
      <div class="modal-body">
        <?php
        if (isset($_GET['status']) && $_GET['status'] == 0)
        {
        ?>
            Thank you! for added service prices.
        <?php
        }
        else if (isset($_GET['status']) && $_GET['status'] == 1)
        {
        ?>
             Thank you! for updated service prices.
        <?php
        }
        ?>  
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">OK</button>
      </div>
    </div>
  </div>
</div>
<script src="script.js"></script>
<?php 
    if (isset($_GET['status']) && $_GET['status'] == 0)
    {
?>
    <script>
        // Show modal when page loads if accepted=1 is present in URL
        var acceptedModal = new bootstrap.Modal(document.getElementById('acceptedModal'));
        acceptedModal.show();
    </script>
<?php
    }
    else if(isset($_GET['status']) && $_GET['status'] == 1)
    {
?>
    <script>
        // Show modal when page loads if accepted=1 is present in URL
        var acceptedModal = new bootstrap.Modal(document.getElementById('acceptedModal'));
        acceptedModal.show();
    </script>
<?php
    }
?>
<script src="script.js"></script>
</body>
</html>
