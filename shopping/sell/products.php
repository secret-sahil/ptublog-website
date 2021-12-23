<?php include 'header.php'; ?>
<?php
    if(!isset($_SESSION['user_id']) && $_SESSION['user_role'] != 'user') {
        header("Location: ../" );
    }

    $db = new Database();
    $db->select('options','currency_format');
    $result = $db->getResult();
    $currency_format = $result[0]['currency_format'];
?>
    <div class="admin-content-container">
        <h2 class="admin-heading">All Products</h2>
        <h5 class="not-found clearfix text-center">Note: After adding a new product, it may take few hours to verify and to become it's status active.
            <br>For more info contact: SAHIL KUMAR (+919814740275)</h5>
            <br>
            <a class="add-new pull-left" href="add_product.php">Add New Product To Sell</a>
            <br>
            <br>
            <br>
        <?php
        $limit = 10;
        $db = new Database();
        $db->select('products','products.product_id,product_title,products.product_price,products.product_status,products.featured_image,products.product_views',null,"user_id = '{$_SESSION['user_id']}'",'products.product_id DESC',null);
        $result = $db->getResult();
        if (count($result) > 0) { ?>
            <table id="productsTable" class="table table-striped table-hover table-bordered">
                <thead>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Price</th>
                    <th>Image</th>
                    <th>Status</th>
                    <th>Views</th>
                    <th width="100px">Action</th>
                </thead>
                <tbody>
                    <?php foreach($result as $row) { ?>
                    <tr>
                        <td><b><?php echo $row['product_id']; ?></b></td>
                        <td><?php echo $row['product_title']; ?></td>
                        <td><?php echo $currency_format.$row['product_price']; ?></td>
                        <td>
                            <?php  if($row['featured_image'] != ''){ ?>
                                <img src="../product-images/<?php echo $row['featured_image']; ?>" alt="<?php echo $row['featured_image']; ?>" width="50px"/>
                            <?php }else{ ?>
                                <img src="images/index.png" alt="" width="50px"/>
                            <?php } ?>
                        </td>
                        <td><?php
                                if($row['product_status'] == '1'){
                                    echo '<span class="label label-success">Active</span>';
                                }
                                elseif($row['product_status'] == '3'){
                                    echo '<span class="label label-danger">Under Verification</span>';
                                }elseif($row['product_status'] == '4'){
                                    echo '<span class="label label-danger">Blocked By Admin</span>';
                                }else{
                                    echo '<span class="label label-danger">Sold</span>';
                                }
                            ?>
                        </td>
                        <td><?php echo $row['product_views']; ?></td>
                        <td>
                            <a href="edit_product.php?id=<?php echo $row['product_id'];  ?>"><i class="fa fa-edit"></i></a>
                            <a class="delete_product" href="javascript:void()" data-id="<?php echo $row['product_id'] ?>" data-subcat="<?php echo $row['product_sub_cat'] ?>"><i class="fa fa-trash"></i></a>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        <?php }else{ ?>
            <br><br><br><br><br><br><br><br><br><br><br><br>
            <div class="not-found clearfix">!!! No Products Found !!!</div>
        <?php    } ?>
        <div class="pagination-outer">
        </div>
    </div>
<?php //    include footer file
    include "footer.php";
?>
