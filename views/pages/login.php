<div>
        <?include (VIEWSPATH . 'viewAssets' . DIRECTORY_SEPARATOR . 'navBar.php');?>
</div>
<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Sign Up Form</title>
        <link rel="stylesheet" href="assets/styles/login-style.css">
    </head>
    <body>

      <form action="index.html" method="post">
      
        <h1>Sign In</h1>
        
        <fieldset>
          <legend><span class="number">1</span>Your Login</legend>
          <label for="mail">Email:</label>
          <input type="email" id="mail" name="user_email">
          
          <label for="password">Password:</label>
          <input type="password" id="password" name="user_password">
        </fieldset>


</html>



        <button type="submit">Sign In</button>
      </form>
      <p>No account yet? <a href="http://localhost:8088/Project/?c=pages&a=register">Register here!</a></p>
    </body>
</html>