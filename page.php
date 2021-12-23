<?php require('includes/config.php'); 

$stmt = $db->prepare('SELECT pageId,pageTitle,pageSlug,pageContent,pageDescrip,pageKeywords FROM sahil_pages WHERE pageSlug = :pageSlug');
$stmt->execute(array(':pageSlug' => $_GET['pageId']));
$row = $stmt->fetch();

//if post does not exists redirect user.
if($row['pageId'] == ''){
    header('Location: ../');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo $row['pageTitle'];?>-PTU Blog</title>
<!--   Navigation -->
<?php include "./header.php";?>
    <!-- Main Site Section Start -->
    <?php
    echo'<main>
        <section class="container">
            <div class="site-content">
                <div class="posts">
                    <div class="post-content" data-aos="zoom-in" data-aos-delay="200">

                        <div class="post-title">';
                        echo '<h2>'.$row['pageTitle'].'</h2>';
                        echo '<p>'.$row['pageContent'].'</p>';
                        echo'</div>
                    </div>
                    <hr>';
                    ?>
                </div>
                
            </div>
        </section>
    </main>
    <!-- Main Site Section Ended -->
    <!-- <div class="post-image">
                            <div>
                                <img src="../assets/Blog-post/'.$row['featuredImg'].'" class="img" alt="blog1">
                            </div>
                        </div> -->

    <!--  Footer  -->
    <?php include "./footer.php";?>
</body>
</html>