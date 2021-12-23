<?php include 'config.php'; ?>
<?php include 'header.php'; ?>

<div class="product-cart-container">
    <div class="container">
        <div class="row">
            <div class="col-md-12 clearfix">
                <h2 class="section-head">My Cart</h2>
                <?php
                    if(isset($_COOKIE['user_cart'])){
                        $pid = json_decode($_COOKIE['user_cart']);
                        if(is_object($pid)){
                            $pid = get_object_vars($pid);
                        }
                        $pids = implode(',',$pid);
                        $db = new Database();
                        $db->select('products','*',null,'product_id IN ('.$pids.')',null,null);
                        $result = $db->getResult();
                        if(count($result) > 0){ ?>
                                <table class="table table-bordered">
                                    <thead>
                                    <th>Product Image</th>
                                    <th>Product Name</th>
                                    <th width="120px">Product Price</th>
                                    <th>Action</th>
                                    </thead>
                                    <tbody>
                                <?php foreach($result as $row){ ?>
                                    <tr class="item-row">
                                        <td><img src="product-images/<?php echo $row['featured_image']; ?>" alt="" width="70px" /></td>
                                        <td><?php echo $row['product_title']; ?></td>
                                        <td><?php echo $cur_format; ?> <span class="product-price"><?php echo $row['product_price']; ?></span></td>
                                        <td>
                                        <a class="btn btn-sm btn-primary remove-cart-item" href="" data-id="<?php echo $row['product_id']; ?>"><i class="fa fa-remove"></i></a>
                                        <?php if(isset($_SESSION['user_role'])){ ?>
                                        <form action="seller-details.php" class="pull-right" method="POST">
                                        <?php $user_id = $row['user_id'];
                                        ?>
                                        <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                                        <input type="submit" class="btn btn-sm btn-primary" value="&#128100;">
                                        </form>
                                        <?php }?>
                                        </td>
                                    </tr>
                        <?php    } ?>
                                    </tbody>
                                </table>
                                <a class="btn btn-sm btn-primary" href="<?php echo $hostname; ?>" >Continue Shopping</a>
                                <?php if(isset($_SESSION['user_role'])){ ?>
                                <?php }else{ ?>
                                    <a class="btn btn-sm btn-success pull-right" href="#" data-toggle="modal" data-target="#userLogin_form" >See Seller Contact Details</a>
                                <?php } ?>
                <?php   }
                    }else{ ?>
                        <div class="empty-result">
                            Your cart is currently empty.
                        </div>
                    <?php }
                ?>


            </div>
        </div>
    </div>
</div>


<?php include 'footer.php'; ?>