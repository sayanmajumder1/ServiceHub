<?php
session_start();
if (!isset($_SESSION["email"])) {
    header("location:/serviceHub/Signup_login/login.php");
    exit;
}
include_once "connection.php";

// Sanitize inputs
$subId = mysqli_real_escape_string($con, $_GET['subservice_id']);
$providerId = mysqli_real_escape_string($con, $_GET['provider_id']);

$res = mysqli_query($con, "SELECT * FROM subservice_price_map WHERE subservice_id='$subId' AND provider_id='$providerId'");
$row = mysqli_fetch_assoc($res);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Service Price</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<?php include 'sidebar.php'; ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-9 ms-sm-auto col-lg-10 px-md-4 mt-4">
            <h2>Update Service Price</h2>
            <form action="updatesubservice_price_data.php" method="POST">
                <input type="hidden" name="id" value='<?php echo $row['subprice_id']?>'>
                <div class="mb-3">
                    <label for="price" class="form-label">Enter Service Price</label>
                    <input type="number" class="form-control" id="price" name="price" value='<?php echo $row['price']?>' required >
                </div>
                <button type="submit" class="btn btn-outline-success">Update Price</button>
            </form>
        </div>
    </div>
</div>

<script>
document.querySelectorAll('.main-link').forEach(link => {
    if (window.location.href.includes(link.getAttribute('href'))) {
        link.classList.add('active');
    }
});
</script>
</body>
</html>
