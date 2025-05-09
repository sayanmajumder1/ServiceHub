<?php

    session_start();
   
	 

     if(!isset($_SESSION["email"]))
     {
         header("location:/project_php/serviceHub/Signup_login/login.php");
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
</head>
<body>
<?php include 'sidebar.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard | Service Provider</title>
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
            $res=mysqli_query($con,"select service_providers.* ,service.service_name from service_providers inner join service on
            service_providers.service_id =service.service_id where email='".$_SESSION['email']."'");
            $row=mysqli_fetch_array($res);
        ?>
        <!-- Main content area -->
        <div class="col-md-9 ms-sm-auto col-lg-10 px-md-4 mt-4">
            <h2>Provider Details Update</h2>
            <form action="profile_update_data.php" method="POST" >
                <div class="mb-3">
                    <input type="text" class="form-control" id="id" name="id" value='<?php echo $row['provider_id']?>'required hidden>
                    <!-- <label for="name" class="form-label">Provider Name</label>
                    <input type="text" class="form-control" id="name" name="name" value='<?php echo $row['provider_name']?>'required> -->
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Provider Email</label>
                    <input type="email" class="form-control" id="email" name="email" value='<?php echo $row['email']?>'required>
                </div>

                <div class="mb-3">
                    <label for="no" class="form-label">Phone No</label>
                    <input type="tel" class="form-control" id="no" name="no" value='<?php echo $row['phone']?>'required>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <input type="text" class="form-control" id="description" name="description" value='<?php echo $row['description']?>'required>
                </div>

                <div class="mb-3">
                    <label for="address" class="form-label">Location</label>
                    <input type="text" class="form-control" id="address" name="address" value='<?php echo $row['address']?>' required>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="text" class="form-control" id="password" name="password" value='<?php echo $row['password']?>' required>
                </div>

                <button type="submit" class="btn btn-outline-success">Update Details</button>
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
