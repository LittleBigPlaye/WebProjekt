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
      
        <h1>Sign Up</h1>
        
        <fieldset>
          <legend><span class="number">1</span>Your basic info</legend>
          <label for="name">Firstname:</label>
          <input type="text" id="name" name="user_firstname">
          
          <label for="name">Lastname:</label>
          <input type="text" id="name" name="user_lastname">

          <label for="mail">Email:</label>
          <input type="email" id="mail" name="user_email">
          
          <label for="password">Password:</label>
          <input type="password" id="password" name="user_password">
          
          <label>Gender:</label>
          <input type="radio" id="female" value="female" name="gender"><label for="female" class="light">Female</label><br>
          <input type="radio" id="male" value="male" name="gender"><label for="male" class="light">Male</label><br>
          <input type="radio" id="divers" value="divers" name="divers"><label for="divers" class="light">Divers</label><br><br>
          <label>Age:</label>
          <input type="date" id="date" name="birthdate">
          <label>Adresse</label>
          <input type="text" id="date" name="addressID">
          
          
        
        </fieldset>
        <button type="submit">Sign Up</button>
      </form>
      
    </body>
</html>