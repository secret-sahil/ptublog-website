$(document).ready(function(){

    var origin = window.location.origin;
    var path = window.location.pathname.split( '/' );
    var URL = origin+'/'+path[1]+'/';
    

    
    // show sub categories
    $('.product_category').change(function(){
        var id = $('.product_category option:selected').val();
        $.ajax({
            url    : "./php_files/products.php",
            type   : "POST",
            data   : {p_cat:id},
            success: function(response){
                var res = JSON.parse(response);
                if(res.hasOwnProperty('sub_category')){
                    var sub_cat = '<option value="" selected disabled>Select Sub Category</option>';
                    var sub_cat_length = res.sub_category.length;
                    for(var i = 0;i<sub_cat_length;i++){
                        sub_cat += '<option value="'+res.sub_category[i].sub_cat_id+'">'+res.sub_category[i].sub_cat_title+'</option>';
                    }
                    $('.product_sub_category').html(sub_cat);
                }
                if(res.hasOwnProperty('brands')){
                    var brand = '<option value="" selected disabled>Select Brand</option>';
                    var brand_length = res.brands.length;
                    if(brand_length > 0){
                        for(var j = 0;j<brand_length;j++){
                            brand += '<option value="'+res.brands[j].brand_id+'">'+res.brands[j].brand_title+'</option>';
                        }
                    }else{
                        brand = '<option value="" selected disabled>No Brands Found</option>';
                    }
                    
                    $('.product_brands').html(brand);
                }
            }
        });
    });

    // load product image with jquery
    $('.product_image').change(function(){
        readURL(this);
    })

    // add product
    $('#createProduct').submit(function(e){
        e.preventDefault();
        $('.alert').hide();
        var title = $('.product_title').val();
        var user_id = $('.user_id').val();
        var cat = $('.product_category option:selected').val();
        var sub_cat = $('.product_sub_category option:selected').val();
        var des = $('.product_description').val();
        var price = $('.product_price').val();
        var qty = $('.product_qty').val();
        var status ='2';
        var image = $('.product_image').val();
        if(title == ''){
            $('#createProduct').prepend('<div class="alert alert-danger">Title Field is Empty.</div>');
        }else if(cat == ''){
            $('#createProduct').prepend('<div class="alert alert-danger">Category Field is Empty.</div>');
        }else if(sub_cat == ''){
            $('#createProduct').prepend('<div class="alert alert-danger">Sub Category Field is Empty.</div>');
        }else if(des == ''){
            $('#createProduct').prepend('<div class="alert alert-danger">Description Field is Empty.</div>');
        }else if(qty == ''){
            $('#createProduct').prepend('<div class="alert alert-danger">Quantity Field is Empty.</div>');
        }else if(image == ''){
            $('#createProduct').prepend('<div class="alert alert-danger">Image Field is Empty.</div>');
        }else{
            var formdata = new FormData(this);
            formdata.append('create',1);
            $.ajax({
                url    : "./php_files/products.php",
                type   : "POST",
                data   : formdata,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function(response){
                    $('.alert').hide();
                    console.log(response);
                    var res = response;
                    if(res.hasOwnProperty('success')){
                        $('#createProduct').prepend('<div class="alert alert-success">Product Added Successfully.</div>');
                        setTimeout(function(){ window.location = URL+'sell/products.php'; }, 1000);
                        
                    }else if(res.hasOwnProperty('error')){
                        $('#createProduct').prepend('<div class="alert alert-danger">'+res.error+'</div>');
                    }
                }
            });
        }

    });

    // update product
    $('#updateProduct').submit(function(e){
        e.preventDefault();
        $('.alert').hide();
        var title = $('.product_title').val();
        var cat = $('.product_category option:selected').val();
        var sub_cat = $('.product_sub_category option:selected').val();
        var des = $('.product_description').val();
        var price = $('.product_price').val();
        var qty = $('.product_qty').val();
        var status = $('.product_status').val();
        var image = $('.product_image').val();
        var old_image = $('.old_image').val();
        if(title == ''){
            $('#updateProduct').prepend('<div class="alert alert-danger">Title Field is Empty.</div>');
        }else if(cat == ''){
            $('#updateProduct').prepend('<div class="alert alert-danger">Category Field is Empty.</div>');
        }else if(sub_cat == ''){
            $('#updateProduct').prepend('<div class="alert alert-danger">Sub Category Field is Empty.</div>');
        }else if(des == ''){
            $('#updateProduct').prepend('<div class="alert alert-danger">Description Field is Empty.</div>');
        }else if(qty == ''){
            $('#updateProduct').prepend('<div class="alert alert-danger">Quantity Field is Empty.</div>');
        }else if(image == '' && old_image == ''){
            $('#updateProduct').prepend('<div class="alert alert-danger">Image Field is Empty.</div>');
        }else{
            var formdata = new FormData(this);
            formdata.append('update',1);
            $.ajax({
                url    : "./php_files/products.php",
                type   : "POST",
                data   : formdata,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function(response){
                    $('.alert').hide();
                    console.log(response);
                    var res = response;
                    if(res.hasOwnProperty('success')){
                        $('#updateProduct').prepend('<div class="alert alert-success">Product Added Successfully.</div>');
                        setTimeout(function(){ window.location = URL+'sell/products.php'; }, 1000);
                        
                    }else if(res.hasOwnProperty('error')){
                        $('#updateProduct').prepend('<div class="alert alert-danger">'+res.error+'</div>');
                    }
                }
            });
        }

    });


    // delete product
    $('.delete_product').click(function(){
        var tr = $(this);
        var id = $(this).attr('data-id');
        var sub_cat = $(this).attr('data-subcat');
        if(confirm('Are you Sure want to delete this')){
            $.ajax({
                url: './php_files/products.php',
                type: 'POST',
                data: {delete_id:id,p_subcat:sub_cat},
                dataType: 'json',
                success: function(response){
                    var res = response;
                    if(res.hasOwnProperty('success')){
                        tr.parent().parent('tr').remove();
                        
                    }else if(res.hasOwnProperty('error')){
                        // $('#updateProduct').prepend('<div class="alert alert-danger">'+res.error+'</div>');
                    }
                }
            });
        }
    });
});

