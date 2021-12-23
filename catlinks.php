<?php require('includes/config.php'); 

$stmt = $db->prepare('SELECT categoryId,categoryName FROM sahil_category WHERE categorySlug = :categorySlug');
$stmt->execute(array(':categorySlug' => $_GET['id']));
$row = $stmt->fetch();

//if post does not exists redirect user.
if($row['categoryId'] == ''){
    header('Location: ./');
    exit;
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo $row['categoryName'];?>-PTU Blog</title>
<!--   Navigation -->
    <?php include "./header.php";?>
    <!-- Main Site Section Start -->
    <main>
        <!--  Site Content -->
        
        <section class="container">
            <div class="site-content">
                <div class="posts">
    <h2>Category: <?php echo $row['categoryName'];?></h2>
                <?php
                try {
                    $stmt = $db->prepare('
                        SELECT 
                            sahil_blog.articleId,sahil_blog.featuredImg, sahil_blog.articleTitle, sahil_blog.articleSlug, sahil_blog.articleDescrip, sahil_blog.articleDate 
                        FROM 
                            sahil_blog,
                            sahil_cat_links
                        WHERE
                             sahil_blog.articleId =  sahil_cat_links.articleId
                             AND  sahil_cat_links.categoryId = :categoryId
                             AND sahil_blog.status="Published"
                        ORDER BY 
                            articleId DESC
                        ');
                    $stmt->execute(array(':categoryId' => $row['categoryId']));
                    while($row = $stmt->fetch()){
                    echo '<div class="post-content" data-aos="zoom-in" data-aos-delay="200">
                        <div class="post-image">
                            <div>
                                <img src="../assets/Blog-post/'.$row['featuredImg'].'" class="img" alt="blog1">
                            </div>
                            <div class="post-info flex-row">';
                                echo'<span><i class="fas fa-calendar-alt text-gray"></i>&nbsp;&nbsp;&nbsp;&nbsp;'.date('jS M Y', strtotime($row['articleDate'])). '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fas fa-hashtag text-gray"></i></span>';
                                $stmt2 = $db->prepare('SELECT categoryName, categorySlug   FROM sahil_category, sahil_cat_links WHERE sahil_category.categoryId = sahil_cat_links.categoryId AND sahil_cat_links.articleId = :articleId');
                                $stmt2->execute(array(':articleId' => $row['articleId']));
                                $catRow = $stmt2->fetchAll(PDO::FETCH_ASSOC);
                                $links = array();
                                foreach ($catRow as $cat){
                                    $links[]="<span><a href='category/".$cat['categorySlug']."'>".$cat['categoryName']."</a></span>";
                                }
                                echo implode($links);
                            echo'</div>
                        </div>
                        <div class="post-title">';
                            echo '<a href="../'.$row['articleSlug'].'">'.$row['articleTitle'].'</a>';
                            $stmt2 = $db->prepare('SELECT categoryName, categorySlug   FROM sahil_category, sahil_cat_links WHERE sahil_category.categoryId = sahil_cat_links.categoryId AND sahil_cat_links.articleId = :articleId');
                            $stmt2->execute(array(':articleId' => $row['articleId']));

                            $catRow = $stmt2->fetchAll(PDO::FETCH_ASSOC);

                            $links = array();
                            foreach ($catRow as $cat)
                            {
                                $links[] = "<a href='".$cat['categorySlug']."'>".$cat['categoryName']."</a>";
                            }
                            // echo implode(", ", $links);
                            echo '<p>'.$row['articleDescrip'].'</p>';
                            echo '<p><button class="btn post-btn"><a href="../'.$row['articleSlug'].'">Read More</a></button></p>';
                        echo'</div>
                    </div>
                    <hr>';
                        }
                    } catch(PDOException $e) {
                        echo $e->getMessage();
                    }
                ?>
                </div>
                <!-- Side Bar -->
                <?php include("./sidebar.php")?>
                <!-- closed sidebar -->
            </div>
        </section>
    </main>
    <!-- Main Site Section Ended -->

    <!--  Footer  -->
    <?php include "./footer.php";?>
</body>

</html>