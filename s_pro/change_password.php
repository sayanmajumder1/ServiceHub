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
    <title>Dashboard | Service Provider</title>
    <link rel="stylesheet" href="style.css">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="hideScrollbar.css">
</head>
<body>
<?php include 'sidebar.php'; ?>


<div class="container-fluid">
    <div class="row">
        <!-- Sidebar already included above -->
        <?php

            include_once "connection.php";
            $res=mysqli_query($con,"select service_providers.* ,service.service_name from service_providers inner join service on
            service_providers.service_id =service.service_id where email='".$_SESSION['email']."'");
            $row=mysqli_fetch_array($res);
        ?>
        <!-- Main content area -->
        <div class="col-md-9 ms-sm-auto col-lg-10 px-md-4 mt-4">
            <h2>Change Password</h2>
            <form action="change_password_data.php" method="POST" >
                <div class="mb-3">
                    <input type="text" class="form-control" id="id" name="id" value='<?php echo $row['provider_id']?>'required hidden>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Previous Password</label>
                    <input type="text" class="form-control" id="pass1" name="pass1" required>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">New Password</label>
                    <input type="password" class="form-control" id="pass2" name="pass2" required>
                </div>

                <button type="submit" class="btn btn-outline-success">Change Password</button>
                
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
