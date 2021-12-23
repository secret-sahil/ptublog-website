<link href="assets/css-min.css" rel="stylesheet" type="text/css">
<link href="../assets/style.css" rel="stylesheet" type="text/css">
<link href="assets/bootstrap.min.css" rel="stylesheet" type="text/css">
</head>
<body>
    <ul class="nav justify-content-center">
    
    <li class="nav-item"><a class="nav-link" href='index.php'>Articles</a></li>
    <li class="nav-item"><a class="nav-link" href="blog-categories.php">Categories</a></li>
    <li class="nav-item"><a class="nav-link" href='blog-pages.php'>Pages</a></li>
    <?php if($_SESSION['username'] == "admin"){?>
    <li class="nav-item"><a class="nav-link" href='blog-users.php'>Users</a></li> <?php }?>
    <li class="nav-item"><a class="nav-link" href="../" target="_blank">Visit Blog </a></li>
    <li class="nav-item"><a class="nav-link" href='logout.php'><font color="red">Logout</font></a></li>
    </ul>
    
