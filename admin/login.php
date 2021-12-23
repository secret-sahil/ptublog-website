<?php 
//Your connection file 
require_once('../includes/config.php');


// user looged in or not 
if( $user->is_logged_in()){ header('Location: index.php'); } 
?>
<!DOCTYPE html>
<head>
  <meta charset="utf-8">
  <title>PTU BLOG ADMIN</title>

  <link rel="stylesheet" href="assets/style.css">
</head>
<body>

<div id="login">

<?php 

   //Login form for submit 
    if(isset($_POST['submit'])){

        $username = trim($_POST['username']);
        $password = trim($_POST['password']);
        
        if($user->login($username,$password)){ 

            //If looged in , the redirects to index page 
            header('Location: index.php');
            exit;
        

        } else {
            $message = '<p class="invalid">Invalid username or Password</p>';
        }

    }

    if(isset($message)){ echo $message; }
?>

    <form action="" method="POST" class="form">
   <label>Username</label>
   <input type="text" name="username" value=""  required />
<br>
 <label>Password</label>
 <input type="password" name="password" value="" required />
<br>
    <label></label><input type="submit" name="submit" value="SignIn"  />

    

</div>
</body>
</html>