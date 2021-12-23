<?php //include connection file 
require_once('../includes/config.php');

//loggedin or not 
if(!$user->is_logged_in()  or $_SESSION['username']!="admin"){ header('Location: login.php'); }
?>

<?php include("head.php");  ?>
    <title>Add User-PTU BLOG ADMIN</title>
     <?php include("header.php");  ?>

<div class="content">
 

    <h2>Add User</h2>

    <?php

    //if form has been submitted process it
    if(isset($_POST['submit'])){

        //collect form data
        extract($_POST);

        //very basic validation
        if($username ==''){
            $error[] = 'Please enter the username.';
        }

        if($password ==''){
            $error[] = 'Please enter the password.';
        }

        if($passwordConfirm ==''){
            $error[] = 'Please confirm the password.';
        }

        if($password != $passwordConfirm){
            $error[] = 'Passwords do not match.';
        }

        if($email ==''){
            $error[] = 'Please enter the email address.';
        }

        if(!isset($error)){

            $hashedpassword = $user->create_hash($password);

            try {

                //insert into database
                $stmt = $db->prepare('INSERT INTO sahil_blog_users (username,password,email,u_group) VALUES (:username, :password, :email, :u_group)') ;
                $stmt->execute(array(
                    ':username' => $username,
                    ':password' => $hashedpassword,
                    ':email' => $email,
                    ':u_group'=> "b"
                ));

                //redirect to user page 
                header('Location: blog-users.php?action=added');
                exit;

            } catch(PDOException $e) {
                echo $e->getMessage();
            }

        }

    }

    //check for any errors
    if(isset($error)){
        foreach($error as $error){
            echo '<p class="message">'.$error.'</p>';
        }
    }
    ?>

    <form action="" method="post">

        <p><label>Username</label><br>
        <input type="text" name="username" value="<?php if(isset($error)){ echo $_POST['username'];}?>"></p>

        <p><label>Password</label><br>
        <input type="password" name="password" value="<?php if(isset($error)){ echo $_POST['password'];}?>"></p>

        <p><label>Confirm Password</label><br>
         <input type="password" name="passwordConfirm" value="<?php if(isset($error)){ echo $_POST['passwordConfirm'];}?>"></p>

        <p><label>Email</label><br>
        <input type="text" name="email" value="<?php if(isset($error)){ echo $_POST['email'];}?>"></p>
        
        <button name="submit" class="subbtn"> Add User</button>

    


</div>




<?php include("footer.php");  ?>



