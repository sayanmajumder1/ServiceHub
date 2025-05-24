<!DOCTYPE html>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Page</title>
       <!-- Bootstrap CSS -->
       <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
      <!-- Font Awesome for Icons -->
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="style.css">
<!-- SideBar Functionality  Js  Code Integrated Here  -->
    <script src= "SideBarFunction.js"></script>
    <style>
.contact-section {
  margin-top: 100px;
  padding: 40px 20px;
  background-color: #f3eaff;
  font-family: 'Arial', sans-serif;
}
.contact-container {
  max-width: 1100px;
  margin: auto;
  display: flex;
  flex-wrap: wrap;
  background: #fff;
  border-radius: 12px;
  overflow: hidden;
  box-shadow: 0 10px 20px rgba(0,0,0,0.08);
}
.contact-info {
  flex: 1;
  padding: 30px;
  background: #ece3ff;
}

.contact-info h2 {
  color: #6a1b9a;
  margin-bottom: 20px;
}

.contact-info p {
  color: #333;
  margin: 12px 0;
  font-size: 15px;
  display: flex;
  align-items: center;
}

.contact-info i {
  color: #fff;
  margin-right: 3px;
  font-size: 18px;
}

.social-icons {
  margin-top: 10px;
}

.social-icons a {
  display: inline-block;
  color: #fff;
  background: #ad67c8;
  width: 35px;
  height: 35px;
  line-height: 35px;
  text-align: center;
  margin-right: 8px;
  border-radius: 50%;
  transition: all 0.3s ease;
}

.social-icons a:hover {
  background: #8b4ea7;
}


.contact-form {
  flex: 1;
  padding: 30px;
}

.contact-form h2 {
  color: #ad67c8;
  margin-bottom: 20px;
}

.contact-form input,
.contact-form textarea {
  width: 100%;
  padding: 12px;
  margin-bottom: 15px;
  border: 1px solid #ccc;
  border-radius: 8px;
  font-size: 14px;
}

.contact-form textarea {
  min-height: 100px;
  resize: vertical;
}

.contact-form button {
  background:rgb(154, 27, 150);
  color: white;
  padding: 12px;
  border: none;
  border-radius: 8px;
  cursor: pointer;
  font-size: 16px;
}

.contact-form button:hover {
  background:rgb(126, 20, 140);
}

@media screen and (max-width: 768px) {
  .contact-container {
    flex-direction: column;
  }
}
</style>
</head>
<body>

<?php
include "navbar.php"
?>
<!--Contact Section-->
   <section class="contact-section">
  <div class="contact-container">
    <div class="contact-info">
      <h2>Get In Touch</h2>
      <p><i class="fas fa-envelope"></i> support@example.com</p>
      <p><i class="fas fa-phone"></i> +123 456 7890</p>
      <p><i class="fas fa-map-marker-alt"></i> 123 Main St, Your City</p>
      <div class="social-icons">
        <a href="#"><i class="fab fa-facebook-f"></i></a>
        <a href="#"><i class="fab fa-twitter"></i></a>
        <a href="#"><i class="fab fa-instagram"></i></a>
        <a href="#"><i class="fab fa-linkedin"></i></a>
      </div>
    </div>
    <div class="contact-form">
      <h2>Contact Us</h2>
      <?php if (isset($_GET['status']) && $_GET['status'] === 'success'): ?>
        <p class="success-msg">Message sent successfully!</p>
    <?php elseif (isset($_GET['status']) && $_GET['status'] === 'error'): ?>
        <p class="error-msg">Something went wrong. Try again.</p>
      <?php endif; ?>
      <form action="submit_contact.php" method="post">
        <input type="text" id="name" name="name" placeholder="Your Name" required>
        <input type="email" id="email" name="email" placeholder="Your Email" required>
        <textarea name="message" id="message" required></textarea>
        <button type="submit">Send Message</button>
      </form>
    </div>
  </div>
</section>



    <?php
        include_once "footer.php"; 
    ?>
    

</body>
</html>