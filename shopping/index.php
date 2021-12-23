<?php include 'config.php'; ?>
<?php include 'header.php'; ?>

    <div class="product-section content">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <?php
                    $limit = 8;
                    $db = new Database();
                    $db->select('products','*',null,'product_status = 1 AND qty > 0','product_id DESC',$limit);
                    $result = $db->getResult();
                    if(count($result) > 0){
                        foreach($result as $row){ ?>
                            <div class="col-md-3 col-sm-6">
                                <div class="product-grid">
                                    <div class="product-image latest">
                                        <a class="image" href="single_product.php?pid=<?php echo $row['product_id']; ?>">
                                            <img class="pic-1" src="product-images/<?php echo $row['featured_image']; ?>">
                                        </a>
                                    </div>
                                    <div class="product-content">
                                        <h3 class="title">
                                            <a href="single_product.php?pid=<?php echo $row['product_id']; ?>"><?php echo $row['product_title']; ?></a>
                                        </h3>
                                        <div class="price"><?php echo $cur_format; ?> <?php echo $row['product_price']; ?></div>
                                    </div>
                                </div>
                            </div>
                        <?php    }
                    } ?>
                </div>
                <div class="col-md-12">
                    <div class="pagination-outer">
                    <?php echo $db->pagination('products',null,'product_status = 1 AND qty > 0',$limit); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php include 'footer.php'; ?>