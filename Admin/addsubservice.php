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
    <title>Add service</title>
    <!-- Bootstrap 5 CSS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="custom.css">
    <link rel="stylesheet" href="hideScrollbar.css">
    <style>
        .modal-header{
            background-color:rgb(150, 60, 186);
            color: white;
        }
       
    </style>
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
                <div class="col-md-8">
                    <div class="card-body ab2">
                        <h2>Add Sub Services:</h2>
                        <p class="card-text"> 
                         <?php
                           
                    
                          ?>
                            <form method="POST" action="subservice_data.php" enctype="multipart/form-data">
                                <div class="mb-3">
                                    <label>Service Name:</label><br>
                                    <select id="s_id" name="s_id" class="con1" required>  
                                        <option >Select Service</option>  
                                    <?php
                                        include_once "connection.php";
                                        $res=mysqli_query($con,"select * from service");
                                        while($row=mysqli_fetch_array($res))
                                        {
                                    ?> 
                                                     
                                    <option value="<?php echo $row['service_id']?>"><?php echo $row['service_name']?></option>
                                    
                                
                                    <?php
                                        }
                                    ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label>Sub Service Name:</label><br>
                                    <input type="text" name="sub_name" id="sub_name" Placeholder="Enter Sub Service Name"class="con1" required>
                                </div>

                                <div class="mb-3">
                                    <label>Sub Service Description:</label><br>
                                    <input type="text" name="s_des" id="s_des" Placeholder="Enter Service Description"class="con1" required>
                                </div>

                              
                              
                                <div class="mb-3">
                                    <label>Images:</label><br>
                                    <input type="file" name="s_img" id="s_img" class="con1"required>
                                </div>
                                <button type="submit" class="btn btn-outline-success">Add Sub Services</button>
                            </form>
                        </p>
                    </div>
                </div>
            </div>
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
        if (isset($_GET['add']) && $_GET['add'] == 1)
        {
        ?>
            Sub Service added Successfully!
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
    
    <script src="btn.js"></script>
<?php 
 
 if(isset($_GET['add']) && $_GET['add'] == 1)
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

</body>
</html>