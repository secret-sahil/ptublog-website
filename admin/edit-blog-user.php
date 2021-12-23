<?php //include config
require_once('../includes/config.php');

//if not logged in redirect to login page
if(!$user->is_logged_in() or $_SESSION['username']!="admin"){
    header('Location: login.php'); }
?>

<?php include("head.php");  ?>
    <title>Edit User-PTU BLOG ADMIN</title>
    <?php include("header.php");  ?>

<div class="content">
 
<h2>Edit User</h2>


    <?php

    //if form has been submitted process it
    if(isset($_POST['submit'])){

        //collect form data
        extract($_POST);

        //very basic validation
        if($username ==''){
            $error[] = 'Please enter the username.';
        }

        if( strlen($password) > 0){

            if($password ==''){
                $error[] = 'Please enter the password.';
            }

            if($passwordConfirm ==''){
                $error[] = 'Please confirm the password.';
            }

            if($password != $passwordConfirm){
                $error[] = 'Passwords do not match.';
            }

        }
        

        if($email ==''){
            $error[] = 'Please enter the email address.';
        }

        if(!isset($error)){

            try {

                if(isset($password)){

                    $hashedpassword = $user->create_hash($password);

                    //update into database
                    $stmt = $db->prepare('UPDATE sahil_blog_users SET username = :username, password = :password, email = :email WHERE userId = :userId') ;
                    $stmt->execute(array(
                        ':username' => $username,
                        ':password' => $hashedpassword,
                        ':email' => $email,
                        ':userId' => $userId
                    ));


                } else {

                    //update database
                    $stmt = $db->prepare('UPDATE sahil_blog_users SET username = :username, email = :email WHERE userId = :userId') ;
                    $stmt->execute(array(
                        ':username' => $username,
                        ':email' => $email,
                        ':userId' => $userId
                    ));

                }
                

                //redirect to users page
                header('Location: blog-users.php?action=updated');
                exit;

            } catch(PDOException $e) {
                echo $e->getMessage();
            }

        }

    }

    ?>


    <?php
    //check for any errors
    if(isset($error)){
        foreach($error as $error){
            echo $error.'<br>';
        }
    }

        try {

            $stmt = $db->prepare('SELECT userId, username, email FROM sahil_blog_users WHERE userId = :userId') ;
            $stmt->execute(array(':userId' => $_GET['id']));
            $row = $stmt->fetch(); 

        } catch(PDOException $e) {
            echo $e->getMessage();
        }

    ?>

    <form action="" method="post">
        <input type="hidden" name="userId" value="<?php echo $row['userId'];?>">

        <p><label>Username</label><br>
        <input type="text" name="username" value="<?php echo $row['username'];?>"></p>

        <p><label>Password (only to change)</label><br>
        <input type="password" name="password" value=""></p>

        <p><label>Confirm Password</label><br>
        <input type="password" name="passwordConfirm" value=""></p>

        <p><label>Email</label><br>
        <input type="text" name="email" value="<?php echo $row['email'];?>"></p>

        <p><input type="submit" name="submit" value="Update"></p>

    </form>

</div>



<?php include("footer.php");  ?>
