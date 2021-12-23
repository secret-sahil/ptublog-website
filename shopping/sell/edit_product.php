<?php include 'header.php'; ?>
<?php
    if(!isset($_SESSION['user_id']) or $_SESSION['user_role'] != 'user') {
        echo '<h4>You are blocked by Admin. To unblock Please Contact Sahil Kumar (+919814740275)</h4><br><br><br><br>';
    }
?>
<?php if(isset($_SESSION['user_id']) and $_SESSION['user_role'] == 'user') {?>
<div class="admin-content-container">
    <h2 class="admin-heading">Edit Product</h2>
    <?php
    $id = $_GET['id'];
    $db = new Database();
    $db->select('products','*',null,"product_id = $id",null,null);
    $result = $db->getResult();
    if ($result > 0) {
        foreach($result as $row) { ?>
            <form id="updateProduct" class="add-post-form row" method="post" enctype="multipart/form-data">
                <div class="col-md-9">
                    <div class="form-group">
                        <label>Status</label>
                        <select class="form-control" name="product_status">
                            <option value="<?php echo $row['product_status']; ?>" >Mask Sold Later</option>
                            <option value="2">Mark Sold</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Product Title</label>
                        <input type="hidden" name="product_id" value="<?php echo $row['product_id']; ?>"/>
                        <input type="text" class="form-control product_title" name="product_title"
                               value="<?php echo $row['product_title']; ?>" placeholder="Product Title"/>
                    </div>
                    <div class="form-group category">
                        <label for="">Product Category</label>
                        <?php
                        $db->select('categories','*',null,null,null,null);
                        $result2 = $db->getResult();
                        if ($result2 > 0) { ?>
                            <select class="form-control product_category" name="product_cat">
                                <?php foreach($result2 as $row2) {
                                    if($row['product_cat'] == $row2['cat_id']){ ?>
                                        <option selected value="<?php echo $row2['cat_id']; ?>"><?php echo $row2['cat_title']; ?></option>
                                    <?php }else{ ?>
                                        <option value="<?php echo $row2['cat_id']; ?>"><?php echo $row2['cat_title']; ?></option>
                                  <?php  } ?>
                                <?php } ?>
                            </select>
                        <?php } ?>
                    </div>
                    <div class="form-group sub_category">
                        <label for="">Product Sub-Category</label>
                        <?php
                        $db->select('sub_categories','*',null,"cat_parent = '{$row['product_cat']}'",null,null);
                        $result3 = $db->getResult();
                            
                        if ($result3 > 0) { ?>

                        <select class="form-control product_sub_category" name="product_sub_cat">
                            <?php foreach($result3 as $row3) {
                                if($row['product_sub_cat'] == $row3['sub_cat_id']){ ?>
                                    <option selected value="<?php echo $row3['sub_cat_id']; ?>"><?php echo $row3['sub_cat_title']; ?></option>
                        <?php   }else{ ?>
                                    <option value="<?php echo $row3['sub_cat_id']; ?>"><?php echo $row3['sub_cat_title']; ?></option>
                            <?php    }
                            } ?>
                        </select>
                        <?php } ?>
                    </div>
                    <div class="form-group">
                        <label for="">Product Description</label>
                        <textarea class="form-control product_description" name="product_desc" rows="8"
                                  cols="80"><?php echo $row['product_desc']; ?></textarea>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">Featured Image</label>
                        <input type="file" class="product_image" name="new_image" id="file" onchange="Filevalidation()" />
                        <p id="size"></p>
                        <script>
                            Filevalidation = () => {
                                const fi = document.getElementById('file');
                                // Check if any file is selected.
                                if (fi.files.length > 0) {
                                    for (const i = 0; i <= fi.files.length - 1; i++) {
                        
                                        const fsize = fi.files.item(i).size;
                                        const filesize = Math.round((fsize / 1024));
                                        // The size of the file.
                                        if (filesize >= 2040) {
                                            $(file).val('');
                                            document.getElementById('size').innerHTML = '<p style="color:red;">'+ "Image size too Big, please select an image less than 2mb" + '</p>';
                                            setTimeout(function(){
                                            document.getElementById('size').innerHTML = '';
                                            },5000); 
                                        } 
                                    }
                                }
                            }
                        </script>
                        <input type="hidden" class="old_image" name="old_image" value="<?php echo $row['featured_image']; ?>">
                        <img id="image" src="../product-images/<?php echo $row['featured_image']; ?>" alt="" width="100px"/>
                    </div>
                    <div class="form-group">
                        <label for="">Product Price</label>
                        <input type="text" class="form-control product_price" name="product_price" value="<?php echo $row['product_price']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="">Available Quantity</label>
                        <input type="number" class="form-control product_qty" name="product_qty" value="<?php echo $row['qty']; ?>">
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn add-new" name="submit" value="Update">
                    </div>
                </div>
            </form>
        <?php
        }
    }
    ?>
</div>
<?php } ?>
<?php
//    include footer file
    include "footer.php";
?>