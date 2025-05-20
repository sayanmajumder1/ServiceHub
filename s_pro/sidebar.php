<?php
include_once "connection.php";
$res = mysqli_query($con, "SELECT service_providers.*, service.service_name 
    FROM service_providers 
    INNER JOIN service ON service_providers.service_id = service.service_id 
    WHERE service_providers.provider_id = " . $_SESSION['provider_id']);
$row = mysqli_fetch_assoc($res);
?>
<style>
    /* The switch - the box around the slider */
    .switch {
        font-size: 17px;
        position: relative;
        display: inline-block;
        width: 3.5em;
        height: 2em;
        margin: 10px;
    }

    /* Hide default HTML checkbox */
    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    /* The slider */
    .slider {
        position: absolute;
        cursor: pointer;
        inset: 0;
        background: #d4acfb;
        border-radius: 50px;
        transition: all 0.4s cubic-bezier(0.23, 1, 0.320, 1);
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 1.4em;
        width: 1.4em;
        left: 0.3em;
        bottom: 0.3em;
        background-color: white;
        border-radius: 50px;
        box-shadow: 0 0px 20px rgba(0, 0, 0, 0.4);
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    .switch input:checked+.slider {
        background: #b84fce;
    }

    .switch input:focus+.slider {
        box-shadow: 0 0 1px #b84fce;
    }

    .switch input:checked+.slider:before {
        transform: translateX(1.6em);
        width: 2em;
        height: 2em;
        bottom: 0;
    }
</style>
<div class="sidebar">
    <div class="logo">
        <img src="../Homepage/assets/images/logo.png" alt="ServiceHub" class="circle">
        <h6>Welcome 👋🏽</h6>
        <h4><?php echo $row['businessname'] ?></h4><br>
        <label class="switch">
            <input type="checkbox">
            <span class="slider"></span>
        </label>
        <h6>Enable/Disable Services</h6>
        <hr>

    </div>
    <nav>
        <a href="dash.php" class="main-link">Dashboard</a>
        <a href="manageservices.php" class="main-link">Manage Services</a>
        <a href="bookings.php" class="main-link">Bookings</a>
        <a href="ongoingbooking.php" class="main-link">Ongoing Booking</a>

        <a href="pay.php" class="main-link">Payment</a>
        <a href="rvu.php" class="main-link">Review</a>
        <a href="lout.php" class="main-link logout">Log Out 🔓</a>
    </nav>
</div>