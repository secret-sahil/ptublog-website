<?php //include connection file 
require_once('../includes/config.php');
require_once('../includes/functions.php');

if(!$user->is_logged_in() or $_SESSION['username']!="admin"){ header('Location: login.php'); }
?>

<?php include("head.php");  ?>
    <title>EDIT Category-PTU BLOG ADMIN</title>
    <?php include("header.php");  ?>

<div class="content">
 <h2>Edit Category-sahil Smarter</h2>


    <?php

    //if form has been submitted process it
    if(isset($_POST['submit'])){

        $_POST = array_map( 'stripslashes', $_POST );

        //collect form data
        extract($_POST);

        //very basic validation
        if($categoryId ==''){
            $error[] = 'Invalid id.';
        }

        if($CategoryName ==''){
            $error[] = 'Please enter the Category Title .';
        }

        if(!isset($error)){

            try {

                $categorySlug = slug($CategoryName);

                //insert into database
                $stmt = $db->prepare('UPDATE sahil_category SET CategoryName = :CategoryName, categorySlug = :categorySlug WHERE categoryId = :categoryId') ;
                $stmt->execute(array(
                    ':CategoryName' => $CategoryName,
                    ':categorySlug' => $categorySlug,
                    ':categoryId' => $categoryId
                ));

                //redirect to categories  page
                header('Location: blog-categories.php?action=updated');
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

            $stmt = $db->prepare('SELECT categoryId, CategoryName FROM sahil_category WHERE categoryId = :categoryId') ;
            $stmt->execute(array(':categoryId' => $_GET['id']));
            $row = $stmt->fetch(); 

        } catch(PDOException $e) {
            echo $e->getMessage();
        }

    ?>

    <form action="" method="post">
        <input type='hidden' name='categoryId' value='<?php echo $row['categoryId'];?>'>

        <p><label>Category Title</label><br>
        <input type='text' name='CategoryName' value='<?php echo $row['CategoryName'];?>'>

        </p><p><input type="submit" name="submit" value="Update"></p>

    </form>


</div>



<?php include("footer.php");  ?>