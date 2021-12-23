<?php
require_once("includes/config.php");
$stmt = $db->prepare('SELECT articleId,articleDescrip, articleSlug ,articleTitle, articleContent, articleTags, articleDate, featuredImg  FROM sahil_blog WHERE articleSlug = :articleSlug and status="Published"'); 
$stmt->execute(array(':articleSlug' => $_GET['id']));           
$row=$stmt->fetch();

if($row['articleId']==''){

header('Location:./');
exit;
}
?>
<?php include "head.php";?>
<title><?php echo $row['articleTitle'];?>-PTU BLOG</title>
<meta name="description" content="<?php echo $row['articleDescrip'];?>">
<meta name="keywords" content="<?php echo $row['articleTags'];?>">
<meta property="og:title" content="<?php echo $row['articleTitle'];?>-PTU BLOG" />
<meta property="og:type" content="article" />
<meta property="og:url" content="https://ptublog.com/<?php echo $row['articleSlug'];?>" />
<meta property="og:image" content="https://ptublog.in/assets/Blog-post/<?php echo $row['featuredImg']; ?>" />
<meta property="og:description" content="<?php echo $row['articleDescrip'];?>" />
<meta property="og:site_name" content="PTU BLOG" />
<meta property="og:image:type" content="image/png" />
<meta property="og:image:width" content="1200" />
<meta property="og:image:height" content="600" />
    <!--   Navigation -->
    <?php include "header.php";?>

    <!-- Main Site Section Start -->
    <?php
    echo'<main>
        <section class="container">
            <div class="site-content">
                <div class="posts">
                    <div class="post-content" data-aos="zoom-in" data-aos-delay="200">
                        <div class="post-image">
                            <div>
                            <img src="assets/Blog-post/'.$row['featuredImg'].'" class="img">
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
                        echo '<a>'.$row['articleTitle'].'</a>';
                        echo '<p>'.$row['articleContent'].'</p>';
                        echo'</div>
                    </div>
                    <hr>';
                    ?>
                        <?php 
    $baseUrl="http://ptublog.in/"; 
    $slug=$row['articleSlug']; 
    $articleIdc=$row['articleId']; 
    ?>             
        <p><strong>Share </strong></p>
              <ul>
                  
                <a target="_blank" href="http://www.facebook.com/sharer.php?u=<?php echo $baseUrl.$slug; ?>"> <img src="assets/social/facebook.png" >
                
                <a target="_blank" href="http://twitter.com/share?text=Read this awesome article from PTUBLOG &url=<?php echo $baseUrl.$slug; ?>&hashtags=ptublog,ikptu">
                <img src="assets/social/twitter.png" ></a>
               
                <a target="_blank" href="http://www.linkedin.com/shareArticle?mini=true&url=<?php echo $baseUrl.$slug; ?>">
                <img src="assets/social/linkedin.png" ></a>
                
                 <a target="_blank" href="http://pinterest.com/pin/create/button/?url=<?php echo $baseUrl.$slug; ?>">
                <img src="assets/social/pinterest.png" ></a>
              </ul>
                <h2> Recomended Posts:</h2>
                <?php
                // run query//select by current id and display the next 4 blog posts 
                $recom= $db->query("SELECT * from sahil_blog where articleId>$articleIdc order by articleId ASC limit 4");
                    while($row1 = $recom->fetch()){
                        echo '<h3>&bull; <a href="'.$row1['articleSlug'].'">'.$row1['articleTitle'].'</a></h3>';
                }
                ?>

                <h2> Previous Posts:</h2>
                <?php

                // run query//select by current id and display the previous 5 posts

                $previous= $db->query("SELECT * from sahil_blog where articleId<$articleIdc order by articleId DESC limit 5");

                // look through query
                    while($row1 = $previous->fetch()){
                        echo '<h3>&bull; <a href="'.$row1['articleSlug'].'">'.$row1['articleTitle'].'</a></h3>';

                }
                ?>
                </div>
                <?php include "sidebar.php" ?>
            </div>
        </section>
    </main>
    <!-- Main Site Section Ended -->

    <!--  Footer  -->
    <?php include "footer.php";?>
</body>

</html>