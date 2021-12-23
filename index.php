<?php 
//connection File 
require_once('includes/config.php'); ?>
<?php include("head.php");  ?>
    <meta property="og:title" content="PTU BLOG" />
    <meta property="og:type" content="article" />
    <meta property="og:url" content="https://ptublog.in/" />
    <meta property="og:image" content="https://ptublog.in/assets/ptu-blog.png" />
    <meta property="og:description" content="On ptublog.in you found many articles related to Punjab Technical University. It's PTU blog on which authors post frequently on different topics about university." />
    <meta property="og:site_name" content="PTU BLOG" />
    <meta property="og:image:type" content="image/png" />
    <meta property="og:image:width" content="1200" />
    <meta property="og:image:height" content="600" />
    <title>Punjab Technical University - Blog</title>
    <style>
    #keyword{
        border: #717476 1px solid; border-radius: 7px; padding: 10px;background:url("assets/images/search.png") no-repeat center right 7px;
    }
    .search_box{ 
    text-align:right;margin:10px 0px;
    }
    .pagination_btn{
        margin-right:9px;
        padding:8px 20px;
        color:#FEFEFE;
        border: #009900 1px solid; 
        background:#66ad44;
        border-radius:4px;
        cursor:pointer;
    }
    .pagination_btn:hover{background:#010000;}
    .pagination_btn.current{background:#FC0527;}
    </style>
<?php include "header.php";?>
<?php   
    $search_query = 'SELECT * FROM  sahil_blog where status="Published" order by articleID desc';
    $pdo_stmt = $db->prepare($search_query);
    $pdo_stmt->execute();
    $result = $pdo_stmt->fetchAll();
?>
    <!-- Main Site Section Start -->
    <main>
        <section class="site-title">
            <div class="site-background" data-aos="fade-up" data-aos-delay="100">
                <h3>Best State Govt. Technical University in Punjab</h3>
                <h1>Punjab Technical University</h1>
                <!-- <button class="btn">Explore</button> -->
            </div>
        </section>

        <!-- Site Title End-->

        <!--  Blog Carousel  -->
        <!--<?php //include "carousel.php";?>-->
        <!--  Blog Carousel  -->

        <!--  Site Content -->
        
        <section class="container">
            <div class="site-content">
                <div class="posts">
                <?php
    if(!empty($result)) { 
        foreach($result as $row) {
    ?>
                <?php
                    echo '<div class="post-content" data-aos="zoom-in" data-aos-delay="10">
                        <div class="post-image">
                            <div>
                                <img src="assets/Blog-post/'.$row['featuredImg'].'" class="img" alt="blog1">
                            </div>
                            <div class="post-info flex-row">';
                                echo'<span><i class="fas fa-pen-nib text-gray">&nbsp;</i>'.$row['author'].'&nbsp;&nbsp;&nbsp;&nbsp;</i>';
                                echo'<i class="fas fa-calendar-alt text-gray"></i>&nbsp;'.date('jS M Y', strtotime($row['articleDate'])). '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fas fa-hashtag text-gray"></i></span>';
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
                            echo '<a href="'.$row['articleSlug'].'">'.$row['articleTitle'].'</a>';
                            echo '<p>'.$row['articleDescrip'].'</p>';
                            echo '<p><button class="btn post-btn"><a href="'.$row['articleSlug'].'">Read More</a></button></p>';
                        echo'</div>
                    </div>
                    <hr>';
                ?>
    <?php
        }
    }
    ?>
                        <br>
                        </form>
                </div>
                <?php include "sidebar.php" ?>
            </div>
        </section>
    </main>
    <!-- Main Site Section Ended -->

    <!--  Footer  -->
    <?php include "footer.php";?>

    <!-- Jquery Library file -->
    <script src="js/Jquery3.4.1.min.js"></script>

    <!--  Owl-Carousel js -->
    <script src="js/owl.carousel.min.js"></script>

    <!--  AOS js Library   -->
    <script src="js/aos.js"></script>

    <!-- Custom Javascript file -->
    <script src="js/main.js"></script>
</body>

</html>