
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    body {
      background-color: #022020;
      color: white;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 1rem;
    }
    .login-container {
      background-color:rgb(3, 41, 41);
      border-radius: 10px;
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
      overflow: hidden;
      width: 100%;
      max-width: 900px;
    }
    .login-logo {
      background-color:rgb(3, 41, 41);
      text-align: center;
      padding: 2rem;
      border-right: 1px solid #ffffff22;
    }
    .login-logo img {
      width: 60px;
      margin-bottom: 1rem;
      padding-top:120px;
      align-items:center;
    }
    .login-logo h2 {
      font-size: 1.5rem;
    }
    .login-form {
      padding: 3rem 2rem;
    }
    .input-group {
      position: relative;
      margin-bottom: 1rem;
    }
    .input-group i {
      position: absolute;
      left: 12px;
      top: 50%;
      transform: translateY(-50%);
      color: #555;
    }
    .input-group input {
      width: 100%;
      padding: 12px 12px 12px 40px;
      border-radius: 5px;
      border: none;
      font-size: 1rem;
      background-color: #eaeef3;
    }
    .btn-orange {
      background-color: #f37022;
      border: none;
      width: 100%;
    }
    .btn-orange:hover {
      background-color: #d65e1e;
    }
    .forgot-link {
      margin-top: 1rem;
      display: block;
      text-align: center;
      color: #fff;
      text-decoration: underline;
    }
    
    @media (max-width: 767.98px) {
      .login-logo {
        border-right: none;
        border-bottom: 1px solid #ffffff22;
      }
      .login-logo img {
      padding-top:0px;
    }
    }
  </style>
</head>
<body>
  <div class="login-container">
    <div class="row g-0">
      <div class="col-md-6 login-logo">
        <img src="img/i1.jpeg" alt="Logo">
        <h2>Service Hub</h2>
      </div>
      <div class="col-md-6 login-form">
        <div class="text-center mb-4">
          <h3>Welcome</h3>
          <p class="text-white-50">Please login to Admin Dashboard:</p>
        </div>
        <form method="POST" action="validate_login.php">
          
          <div class="input-group">
            <i class="fas fa-user"></i>
            <input type="text" name="u_name" id="u_name" placeholder="Enter Username" required>
          </div>

          <div class="input-group">
            <i class="fas fa-lock"></i>
            <input type="password" name="password" id="password" placeholder="Enter Password" required >
          </div>

         <button type="submit" class="btn btn-orange mt-2">Login</button>
        </form>
        <a href="#" class="forgot-link">Forgotten Your Password?</a>
      </div>
    </div>
  </div>
</body>
</html>
