<?php 
    $db = new Database();
    $db->select('options','site_name,site_logo,currency_format');
    $header = $db->getResult();
    $cur_format = '$';
    if(!empty($header[0]['currency_format'])){
        $cur_format = $header[0]['currency_format'];
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="In this store, IKGPTU Students' can buy and sell objects that they want to sell in university.">
    <meta property="og:title" content="PTU STORE|Student's Buying/Selling Platform" />
    <meta property="og:type" content="article" />
    <meta property="og:url" content="https://ptublog.com/shopping/" />
    <meta property="og:image" content="https://ptublog.in/shopping/images/ikgptustore.png" />
    <meta property="og:description" content="In this store, IKGPTU Students' can buy and sell objects that they want to sell in university." />
    <meta property="og:site_name" content="PTU STORE" />
    <meta property="og:image:type" content="image/png" />
    <meta property="og:image:width" content="1200" />
    <meta property="og:image:height" content="600" />
    <?php if(isset($title)){ ?>
        <title><?php echo $title; ?></title>
    <?php }else{ ?>
        <title>PTU STORE|Student's Buying/Selling Platform</title>
    <?php } ?>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <!-- Google font -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700,900|Montserrat:400,500,700,900" rel="stylesheet">
    <!-- Font Awesome Icon -->
    <link rel="stylesheet" href="css/font-awesome.css">
    <!-- Custom stlylesheet -->
    <link rel="stylesheet" href="css/style.css">

    <link rel="stylesheet" href="css/owl.carousel.min.css"/>
    <link rel="stylesheet" href="css/owl.theme.default.min.css"/>
    <!-- PTU HEADER -->
    <link rel="icon" type="image/x-icon" href="../assets/favicon.ico">

    <!-- Custom Style   -->
    <link rel="stylesheet" href="../css/Style.css">
    
</head>
</head>
<body>
<!-- HEADER -->
<div id="header">
    <!-- container -->
    <div class="container">
        <!-- row -->
        <div class="row">
            <!-- LOGO -->
            <div class="col-md-2">
                <?php
                    if(!empty($header[0]['site_logo'])){ ?>
                        <a href="<?php echo $hostname; ?>" class="logo-img"><img src="images/<?php echo $header[0]['site_logo']; ?>" alt=""></a>
                    <?php }else{ ?>
                        <a href="<?php echo $hostname; ?>" class="logo"><?php echo $header[0]['site_name']; ?></a>
                    <?php } ?>
            </div>
            <!-- /LOGO -->
            <div class="col-md-7">
                <form action="search.php" method="GET">
                <div class="input-group search">
                    <input type="text" class="form-control" name="search" placeholder="Search for...">
                    <span class="input-group-btn">
                        <input class="btn btn-default"  type="submit" value="Search" />
                    </span>
                </div>
                </form>
            </div>
            <div class="col-md-3">
                <ul class="header-info"><center>
                    <li class="dropdown">
                        <a class="dropdown-toggle" href="#" data-toggle="dropdown">
                            <?php
                            if (session_status() == PHP_SESSION_NONE) {
                                session_start();
                            }
                            if(isset($_SESSION["user_role"])){ ?>
                                Hello <?php echo $_SESSION["username"]; ?><i class="caret"></i>
                            <?php  }else{ ?>
                                <i class="fa fa-user"></i>
                            <?php  } ?>

                        </a>
                        <ul class="dropdown-menu">
                            <!-- Trigger the modal with a button -->
                            <?php
                                if(isset($_SESSION["user_role"])){ ?>
                                    <li><a href="user_profile.php" class="" >My Profile<i class='fa fa-vcard-o'></i></a></li>
                                    <li><a href="sell/dashboard.php" class="" >Sell My Product<i class='fa fa-shopping-bag'></i></a></li>
                                    <li><a href="javascript:void()" class="user_logout" >Logout<i class='fa fa-sign-out'></i></a></li>
                            <?php  }else{ ?>
                                    <li><a data-toggle="modal" data-target="#userLogin_form" href="#">login<i class='fa fa-sign-in'></i></a></li>
                                    <li><a href="register.php">Register<i class='fa fa-address-card'></i></a></li>
                              <?php  } ?>

                        </ul>
                    </li>
                    <li>
                        <a href="https://ptublog.in/"><i class='fa fa-home'></i>
                        </a>
                    </li></center>
                </ul>
            </div>
            <!-- Modal -->
            <div class="modal fade" id="userLogin_form" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <div class="modal-body">
                            <!-- Form -->
                            <form  id="loginUser" method ="POST">
                                <div class="customer_login"> 
                                    <h2>login here</h2>
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="email" class="form-control username" placeholder="Username" autocomplete="off" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Password</label>
                                        <input type="password" class="form-control password" placeholder="password" autocomplete="off" required>
                                    </div>
                                    <input type="submit" name="login" class="btn" value="login"/>
                                    <span>Don't Have an Account <a href="register.php">Register</a></span>
                                </div>
                            </form>
                            <!-- /Form -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Modal -->
        </div>
    </div>
</div>
<div id="header-menu">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <ul class="menu-list">  
                <li><a href="index.php">Home</a></li>  
                    <?php
                    $db = new Database();
                    $db->select('sub_categories','*',null,'cat_products > 0 AND show_in_header = "1"',null,null);
                    $result = $db->getResult();
                    if(count($result) > 0){
                        foreach($result as $res){ ?>
                            <li><a href="category.php?cat=<?php echo $res['sub_cat_id']; ?>"><?php echo $res['sub_cat_title']; ?></a></li>
                        <?php    }
                    } ?>  
            </ul>
            </div>
        </div>
    </div>
</div>