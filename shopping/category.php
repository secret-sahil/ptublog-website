<?php
include 'config.php';

$db = new Database();
$cat = $db->escapeString($_GET['cat']);

$db->select('sub_categories','sub_cat_title',null,"sub_cat_id = '{$cat}'",null,null);
$result = $db->getResult();
if(!empty($result)){ 
    $title = $result[0]['sub_cat_title'].' : Buy '.$result[0]['sub_cat_title'].' at Best Price'; 

}else{ 
    $title = "Result Not Found";
}
$page_head = $result[0]['sub_cat_title'];

?>
<?php include 'header.php'; ?>
    <div class="product-section content">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="section-head"><?php echo $page_head; ?></h2>
                </div>
            </div>
            <?php if(!empty($result)){ ?>
            <div class="row">
                <div class="col-md-9">
                    <?php
                    $limit = 8;
                    $db->select('products','*',null,"product_sub_cat = '{$cat}' AND product_status = 1 AND qty > 0",null,null);
                    $result3 = $db->getResult();
                    if(count($result3) > 0){
                        foreach($result3 as $row3){ ?>
                            <div class="col-md-4 col-sm-6">
                                <div class="product-grid">
                                    <div class="product-image">
                                        <a class="image" href="single_product.php?pid=<?php echo $row3['product_id']; ?>">
                                            <img class="pic-1" src="product-images/<?php echo $row3['featured_image']; ?>">
                                        </a>
                                    </div>
                                    <div class="product-content">
                                        <h3 class="title">
                                            <a href="single_product.php?pid=<?php echo $row3['product_id']; ?>"><?php echo substr($row3['product_title'],0,30),'...'; ?></a>
                                        </h3>
                                        <div class="price"><?php echo $cur_format; ?> <?php echo $row3['product_price']; ?></div>
                                    </div>
                                </div>
                            </div>
                        <?php    }
                    }else{ ?>
                        <div class="empty-result">Result Empty</div>
                <?php } ?>
                <div class="col-md-12 pagination-outer">
                        <?php
                            echo $db->pagination('products',null,"product_sub_cat = '{$cat}' AND product_status = 1 AND qty > 0",$limit);
                        ?>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>

<?php include 'footer.php'; ?>