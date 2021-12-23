<?php
// include header file
include 'header.php'; ?>
<?php
    if(!isset($_SESSION['user_id']) or $_SESSION['user_role'] != 'user') {
        echo '<h4>You are blocked by Admin. To unblock Please Contact Sahil Kumar (+919814740275)</h4><br><br><br><br>';
    }
?>
    <?php if(isset($_SESSION['user_id']) and $_SESSION['user_role'] == 'user') {?>
    <div class="admin-content-container">
        <h2 class="admin-heading">Add New Product</h2>
        <form id="createProduct" class="add-post-form row" method="post" enctype="multipart/form-data">
            <div class="col-md-9">
                <div class="form-group">
                    <label for="">Product Title</label>
                    <input type="text" class="form-control product_title" name="product_title" placeholder="Product Title" requried/>
                </div>
                <div class="form-group category">
                    <label for="">Product Category</label>
                    <?php
                    $db = new Database();
                    $db->select('categories','*',null,null,'categories.cat_id DESC',null);
                    // $sql = "SELECT * FROM categories ORDER BY categories.cat_id DESC";
                    $categories = $db->getResult();?>
                    <select class="form-control product_category" name="product_cat">
                        <option value="" selected disabled>Select Category</option>
                        <?php if ($categories > 0) {  
                            foreach($categories as $category) { ?>
                            <option value="<?php echo $category['cat_id']; ?>"><?php echo $category['cat_title']; ?></option>
                            <?php } 
                            } ?>
                    </select>
                </div>
                <div class="form-group sub_category">
                    <label for="">Product Sub-Category</label>
                    <select class="form-control product_sub_category" name="product_sub_cat">
                        <option value="" selected disabled>First Select Category</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="">Product Description</label>
                    <textarea class="form-control product_description" name="product_desc" rows="8" cols="80" requried></textarea>
                </div>
                <div class="show-error"></div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="">Featured Image</label>
                    <input type="file" class="product_image" requried name="featured_img" id="file" onchange="Filevalidation()" />
                    <img id="image" src="" width="150px"/>
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
                </div>
                <div class="form-group">
                    <label for="">Product Price</label>
                    <input type="text" class="form-control product_price" name="product_price" requried value="">
                </div>
                <div class="form-group">
                    <label for="">Available Quantity</label>
                    <input type="number" class="form-control product_qty" name="product_qty" requried value="">
                </div>
                <div class="form-group">
                    <input type="hidden" class="form-control user_id" name="user_id" value="<?php echo $_SESSION['user_id'] ?>">
                </div>
                <div class="form-group">
                    <input type="submit" class="btn add-new" name="submit" value="Submit">
                </div>
            </div>
        </form>
    </div>
    <?php } ?>
<?php
// include footer file
include "footer.php";
?>
