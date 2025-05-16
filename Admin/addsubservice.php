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
                <div class="col-md-8">
                    <div class="card-body ab2">
                        <h2>Add Sub Services:</h2>
                        <p class="card-text"> 
                         <?php
                            include_once "connection.php";
                             $res=mysqli_query($con,"select * from service");
                    
                          ?>
                            <form method="POST" action="#.php" enctype="multipart/form-data">
                                <div class="mb-3">
                                    <label>Service Name:</label><br>
                                   
                                    <!-- <input type="number" name="s_id" id="s_id" value="<?php echo $row['s_id']?>" class="con1" required>
                                    <input type="text" name="s_name" id="s_name" value="<?php echo $row['s_name']?>" class="con1" required> -->
                                  
                                    <select id="s_id" name="s_id">  
                                          <?php
                                       while($row=mysqli_fetch_array($res))
                                       {
                                    ?>                    
                                    <option value="<?php echo $row['service_id']?>"><?php echo $row['service_name']?></option>
                                    </select>
                                </div>
                            <?php
                                    }
                            ?>
                                <div class="mb-3">
                                    <label>Sub Service Name:</label><br>
                                    <input type="text" name="sub_name" id="sub_name" Placeholder="Enter Sub Service Name"class="con1" required>
                                </div>

                                <div class="mb-3">
                                    <label>Sub Service Description:</label><br>
                                    <input type="text" name="s_des" id="s_des" Placeholder="Enter Service Description"class="con1" required>
                                </div>

                                <div class="mb-3">
                                    <label>Service Price:</label><br>
                                    <input type="text" name="s_price" id="s_price" Placeholder="Enter Service Price"class="con1" required>
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
    <!-- Bootstrap JS Bundle with Popper -->
    <script src="./js/bootstrap.bundle.min.js"></script>
    <script src="btn.js"></script>
</body>
</html>