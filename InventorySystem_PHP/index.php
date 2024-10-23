<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Form | Dan Aleko</title>
  <link rel="stylesheet" href="libs/css/styles.css">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
  <div class="wrapper">
   
    <form method="post" action="auth.php">
      <h1>Login </h1>      
      <div class="input-box">
        <input type="name" class="form-control" name="username" placeholder="Username" required>
        
      </div>
      <div class="input-box">

        <input type="password" name="password" class="form-control" placeholder="Password" required>

      </div>

      <button type="submit" class="btn">Login</button>
      <div class="register-link">
      </div>
    </form>
    
    
  </div>
</body>
</html>

