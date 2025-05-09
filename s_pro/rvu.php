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
  <title>Customer Reviews</title>
  <link rel="stylesheet" href="style.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      background: #f4f1fc;
    }

    .review-container {
      margin-left: 250px; /* adjust if sidebar width differs */
      padding: 30px;
    }

    h2 {
      color: #9810FA;
      margin-bottom: 20px;
    }

    .review-card {
      background: white;
      border-radius: 12px;
      padding: 20px;
      box-shadow: 0 5px 15px rgba(0,0,0,0.1);
      margin-bottom: 20px;
      transition: transform 0.2s;
    }

    .review-card:hover {
      transform: scale(1.02);
    }

    .review-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .review-header h4 {
      margin: 0;
      color: #333;
    }

    .review-rating {
      color: #f7b500;
      font-weight: bold;
    }

    .review-body {
      margin-top: 10px;
      font-size: 14px;
      color: #555;
    }

    @media (max-width: 768px) {
      .review-container {
        margin-left: 0;
        padding: 20px;
      }
    }
  </style>
</head>
<body>
  <?php include 'sidebar.php'; ?>
  <div class="review-container">
    <h2>Customer Reviews</h2>
    <?php

        include_once "connection.php";

        $res=mysqli_query($con,"select review.*,users.name from review inner join users on review.user_id=users.user_id where review.provider_id='".$_SESSION['id']."'");

        while($row=mysqli_fetch_array($res))
        {
    ?>
      
    <div class="review-card">
      <div class="review-header">
        <h4><?php  echo $row['name'] ?></h4>
        
     <div class="review-rating"><?php 
        for ($i = 1; $i <= 5; $i++) 
        {
          if ($i <= $row['rating'])
          {
              echo '<i class="fas fa-star text-warning"></i>'; // filled star
          } 
          else
          {
              echo '<i class="far fa-star text-muted"></i>'; // empty star
          }
        }
      ?></div>
      </div>
      <div class="review-body"><?php  echo $row['comment'] ?></div>
    </div>
    <?php
        }

    ?>
    

  </div>
  
</body>
</html>
