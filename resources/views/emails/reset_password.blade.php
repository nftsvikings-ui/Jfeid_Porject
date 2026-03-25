<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Jfeid Password Reset</title>
<style>
  /* CSS Reset */
  body, h1, p {
    margin: 0;
    padding: 0;
  }
  body {
  font-family: Arial, sans-serif;
  font-size: 16px;
   height: 100%;
  margin: 0;
  display: flex;
  justify-content: center;  
  align-items: center;     
  background-color: #ebe1e1; 
}

.container {
  max-width: 600px;
  padding: 20px;
  background-color: #fff;
  border-radius: 5px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}
  h1 {
    color: #333;
    margin-bottom: 20px;
  }
  p {
    padding: 15px;
    color: #666;
    margin-bottom: 20px;
  }
  .button {
    display: flex;
    justify-content: center;
    align-items: center;
    text-align: center;
    margin: 30px;
    padding: 10px 20px;
    background-color: #007bff;
    color: #fff;
    text-decoration: none;
    border-radius: 5px;
  }
</style>
</head>
<body>
  <div class="container">
    <h1>Password Reset</h1>
    <p>Hello,</p>
    <p>We received a request to reset your password for the Jfeid app. To proceed, please click the button below:</p>
    <a href="{{ route('password.reset', ['token' => $token]) }}" class="button">Reset Password</a>
    <p>If you didn't request a password reset, you can ignore this email. Your password will remain unchanged.</p>
    <p>Thank you,<br>The Jfeid App Team</p>
  </div>
</body>
</html>

