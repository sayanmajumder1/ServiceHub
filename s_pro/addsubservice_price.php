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
    <title>Add service price</title>
    <link rel="stylesheet" href="style.css">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include 'sidebar.php'; ?>
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar already included above -->
        <?php

            include_once "connection.php";
            $res=mysqli_query($con,"select * from subservice where subservice_id='".$_GET['id']."'");
            $row=mysqli_fetch_array($res);
        ?>
        <!-- Main content area -->
        <div class="col-md-9 ms-sm-auto col-lg-10 px-md-4 mt-4">
            <h2>Add Service Price</h2>
            <form action="addsubservice_price_data.php" method="POST" >
                <div class="mb-3">
                    <input type="text" class="form-control" id="provider_id" name="provider_id" value='<?php echo $_SESSION['provider_id']?>'required hidden>
                    <input type="text" class="form-control" id="service_id" name="service_id" value='<?php echo $row['service_id']?>'required hidden>
                    <input type="text" class="form-control" id="subservice_id" name="subservice_id" value='<?php echo $row['subservice_id']?>'required hidden>
                </div>
                <div class="mb-3">
                    <label for="text" class="form-label">Enter Service Price</label>
                    <input type="text" class="form-control" id="price" name="price" placeholder="Enter Service Price"required>
                </div>
                <button type="submit" class="btn btn-outline-success">Add Price</button>
            </form>
        </div>
    </div>
</div>


</body>
</html>


<script>
    document.querySelectorAll('.main-link').forEach(link => {
        if (window.location.href.includes(link.getAttribute('href'))) {
            link.classList.add('active');
        }
    });
</script>
</body>
</html>
