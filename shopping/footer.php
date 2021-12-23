<div id ="footer">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <?php
                    $db = new Database();
                    $db->select('options','site_name,footer_text,site_desc,contact_phone,contact_email,contact_address',null,null,null,null);
                    $footer = $db->getResult();  ?>
                <h3><?php echo $footer[0]['site_name']; ?></h3>
                <a><?php echo $footer[0]['site_desc']; ?></a>
            </div>
            <div class="col-md-3">
                <h3>Categories</h3>
                <ul class="menu-list">
                    <?php
                    $db = new Database();
                    $db->select('sub_categories','*',null,'cat_products > 0 AND show_in_footer ="1"',null,null);
                    $result = $db->getResult();
                    if(count($result) > 0){
                        foreach($result as $res){ ?>
                            <li><a href="category.php?cat=<?php echo $res['sub_cat_id']; ?>"><?php echo $res['sub_cat_title']; ?></a></li>
                        <?php    }
                    } ?>
                </ul>
            </div>
            <div class="col-md-3">
                <h3>Useful Links</h3>
                <ul class="menu-list">
                    <li><a href="<?php echo $hostname; ?>">Home</a></li>
                </ul>
            </div>
            <div class="col-md-3">
                <h3>Contact Us</h3>
                <ul class="menu-list">
                    <?php if(!empty($footer[0]['contact_address'])){ ?>
                        <li><i class="fa fa-home" ></i><span>: <?php echo $footer[0]['contact_address']; ?></span></li>
                    <?php } ?>
                    <?php if(!empty($footer[0]['contact_phone'])){ ?>
                        <li><i class="fa fa-phone" ></i><span>: <?php echo $footer[0]['contact_phone']; ?></span></li>
                    <?php } ?>
                    <?php if(!empty($footer[0]['contact_email'])){ ?>
                        <li><i class="fa fa-envelope" ></i><span>: <?php echo $footer[0]['contact_email']; ?></span></li>
                    <?php } ?>
                </ul>
            </div>
            <div class="col-md-12">
            </div>
        </div>
    </div>
</div>
<footer class="footer">
    <br>
    <div class="rights flex-row">
        <h4 class="text-gray">
            Copyright ©<?php echo date("Y"); ?> All rights reserved | made by
            <a href="https://www.instagram.com/secret.sahil" target="_black">Sahil Kumar</a> | Inspired By
            <a href="https://drsatvir.in/" target="_black">Dr. Satvir Singh</a>
        </h4>
    </div>
    <br>
</footer>
<script src="js\jquery-1.10.2.min.js" type="text/javascript"></script>
<script src="js\bootstrap.min.js"></script>
<script src="js\actions.js"></script>
<!--okzoom Plugin-->
<script src="js/okzoom.min.js" type="text/javascript"></script>
<!--owl carousel plugin-->
<script type="text/javascript" src="js/owl.carousel.js"></script>
    <!-- Jquery Library file -->
    <script src="../js/Jquery3.4.1.min.js"></script>

    <!--  Owl-Carousel js -->
    <script src="../js/owl.carousel.min.js"></script>

    <!--  AOS js Library   -->
    <script src="../js/aos.js"></script>

    <!-- Custom Javascript file -->
    <script src="../js/main.js"></script>

<script>
    $(document).ready(function(){

        $('#product-img').okzoom({
            width: 200,
            height: 200,
            scaleWidth: 800
        });

        $('.banner-carousel').owlCarousel({
            loop: true,
            margin: 0,
            responsiveClass: true,
            navText : ["",""],
            responsive: {
                0: {
                    items: 1,
                    nav: true

                },
                600: {
                    items: 1,
                    nav: true
                },
                1000: {
                    items: 1,
                    nav: true,
                    loop: false,
                    margin: 10
                }
            }
        });

        $('.popular-carousel').owlCarousel({
            loop: true,
            margin: 0,
            responsiveClass: true,
            navText : ["",""],
            responsive: {
                0: {
                    items: 1,
                    nav: true

                },
                600: {
                    items: 2,
                    nav: true
                },
                800: {
                    items: 4,
                    nav: true
                },
                1000: {
                    items: 5,
                    nav: true,
                    loop: false,
                    margin: 10
                }
            }
        });

        $('.latest-carousel').owlCarousel({
            loop: true,
            margin: 0,
            responsiveClass: true,
            navText : ["",""],
            responsive: {
                0: {
                    items: 1,
                    nav: true

                },
                600: {
                    items: 2,
                    nav: true
                },
                800: {
                    items: 3,
                    nav: true
                },
                1000: {
                    items: 4,
                    nav: true,
                    loop: false,
                    margin: 5
                }
            }
        });
    });

</script>

</body>
</html>