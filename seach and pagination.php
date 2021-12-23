<?php 
//connection File 
require_once('includes/config.php'); ?>
<?php include("head.php");  ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
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
        border: #000000 1px solid; 
        background:#01cd74;
        border-radius:100px;
        cursor:pointer;
    }
    .pagination_btn:hover{background:#010000;}
    .pagination_btn.current{background:#FC0527;}
    </style>
<!--   Navigation -->
<?php include "header.php";?>
<?php   
    define("PER_PAGE_LIMIT",2); //Set blog posts limit
    $searching = '';
    if(!empty($_POST['search']['keyword'])) {
        $searching = $_POST['search']['keyword'];
    }
    /* PHP Blog Search*/
    $search_query = 'SELECT * FROM  sahil_blog WHERE articleTitle LIKE :keyword OR articleDescrip LIKE :keyword OR articleTags LIKE :keyword OR articleContent LIKE :keyword ORDER BY articleId DESC ';
  
    /* PHP Blog Pagination*/
    $per_page_item = '';
    $page = 1;
    $start=0;
    if(!empty($_POST["page"])) {
        $page = $_POST["page"];
        $start=($page-1) * PER_PAGE_LIMIT;
    }
    $limit=" limit " . $start . "," . PER_PAGE_LIMIT;
    $pagination_stmt = $db->prepare($search_query);
    $pagination_stmt->bindValue(':keyword', '%' . $searching . '%', PDO::PARAM_STR);
    $pagination_stmt->execute();

    $row_count = $pagination_stmt->rowCount();
    if(!empty($row_count)){
        $per_page_item .= '<div style="text-align:center;margin:0px 0px;">';
        $page_count=ceil($row_count/PER_PAGE_LIMIT);
        if($page_count>1) {
            for($i=1;$i<=$page_count;$i++){
                if($i==$page){
                    $per_page_item .= '<input type="submit" name="page" value="' . $i . '" class="pagination_btn current">';
                } else {
                    $per_page_item .= '<input type="submit" name="page" value="' . $i . '" class="pagination_btn">';
                }
            }
        }
        $per_page_item .= "</div>";
    }
    $query = $search_query.$limit;
    $pdo_stmt = $db->prepare($query);
    $pdo_stmt->bindValue(':keyword', '%' . $searching . '%', PDO::PARAM_STR);
    $pdo_stmt->execute();
    $result = $pdo_stmt->fetchAll();
?>
    <!-- Main Site Section Start -->
    <main>
        <!--  Site Content -->
        
        <section class="container">
            <div class="site-content">
                <div class="posts">
    <form action="" method="post">
    <div class="search_box"><input type="text" name="search[keyword]" value="<?php //echo $searching; ?>" id="keyword" maxlength="30"></div>
    <?php
    if(!empty($result)) { 
        foreach($result as $row) {
    ?>
                <?php
                    echo '<div class="post-content" data-aos="zoom-in" data-aos-delay="200">
                        <div class="post-image">
                            <div>
                                <img src="assets/Blog-post/'.$row['featuredImg'].'" class="img" alt="blog1">
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
    else{ 
    echo "'<h2>No results found for '.$searching.'</h2>'";
    } 
    ?>
    <table><tbody><tr></tr></tbody></table>
                        <?php echo $per_page_item; ?>
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