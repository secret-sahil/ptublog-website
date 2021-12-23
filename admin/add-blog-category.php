<?php
require_once('../includes/config.php');
require_once('../includes/functions.php');

if(!$user->is_logged_in()  or $_SESSION['username']!="admin"){ header('Location: login.php'); }
?>
<?php include("head.php");  ?>
    <title>Add New Category-PTU BLOG ADMIN</title>
    <?php include("header.php");  ?>

<div class="content">
 <h2>Add Category</h2>

    <?php

    //if form has been submitted process it
    if(isset($_POST['submit'])){

        $_POST = array_map( 'stripslashes', $_POST );

        //collect form data
        extract($_POST);

        //very basic validation
        if($categoryName ==''){
            $error[] = 'Please enter the Category.';
        }

        if(!isset($error)){

            try {

                $categorySlug = slug($categoryName);

                //insert into database
                $stmt = $db->prepare('INSERT INTO sahil_category (categoryName,categorySlug) VALUES (:categoryName, :categorySlug)') ;
                $stmt->execute(array(
                    ':categoryName' => $categoryName,
                    ':categorySlug' => $categorySlug
                ));

                //redirect to index page
                header('Location: blog-categories.php?action=added');
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

        <h2><label>Category Title</label><br>
        <input type='text' name='categoryName' value='<?php if(isset($error)){ echo $_POST['categoryName'];}?>'>
        <p><input type="submit" name="submit" value="Submit"></p>

    

</h2></form></div>



<?php include("footer.php");  ?>


 