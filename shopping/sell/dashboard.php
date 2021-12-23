<?php
// include header file
include 'header.php'; ?>
    <div class="admin-content-container">
        <h2 class="admin-heading">Dashboard</h2>
        <div class="row">
            <div class="col-md-4">
                <?php
                    $db = new Database();
                    $db->select('products','COUNT(product_id) as p_count',null,"user_id = '{$_SESSION['user_id']}'",null,0);
                    $products = $db->getResult();
                ?>
                <div class="detail-box">
                    <span class="count"><?php echo $products[0]['p_count']; ?></span>
                    <span class="count-tag">Products Selling</span>
                </div>
            </div>
        </div>
    </div>
<?php
//    include footer file
    include "footer.php";

?>
