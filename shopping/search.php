<?php
include 'config.php';
if($_GET['search'] == ''){
    header("Location: " . $hostname);
}else {
    $db = new Database();
    $db->select('options','site_title',null,null,null,null);
    $result = $db->getResult();
    if(!empty($result)){ 
        $title = $result[0]['site_title']; 
    }else{ 
        $title = "Shopping Project";
    }
    include 'header.php';  ?>
    <div class="product-section content">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="section-head">Search Results</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-md-10">
                    <?php
                    $limit = 8;
                    $db->select('products','*',null,"product_title LIKE '%{$search}%'",null,$limit);
                    $result3 = $db->getResult();
                    if (count($result3) > 0) {
                        foreach($result3 as $row3) {
                            ?>
                            <div class="col-md-3 col-sm-6">
                                <div class="product-grid">
                                    <div class="product-image">
                                        <a class="image" href="single_product.php?pid=<?php echo $row3['product_id']; ?>">
                                            <img class="pic-1"
                                                 src="product-images/<?php echo $row3['featured_image']; ?>">
                                        </a>
                                    </div>
                                    <div class="product-content">
                                        <h3 class="title">
                                            <a href="single_product.php?pid=<?php echo $row3['product_id']; ?>"><?php echo substr($row3['product_title'],0,30).'...'; ?></a>
                                        </h3>
                                        <div class="price"><?php echo $cur_format; ?> <?php echo $row3['product_price']; ?></div>
                                    </div>
                                </div>
                            </div>
                        <?php
                        }
                    } else {
                        ?>
                        <div class="empty-result">!!! Result Not Found !!!</div>
                    <?php } ?>
                    <div class="pagination-outer">
                        <?php
                        echo $db->pagination('products',null,"product_title LIKE '%{$search}%'",$limit);
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php include 'footer.php';

} ?>