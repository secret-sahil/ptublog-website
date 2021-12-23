<?php
include 'config.php';
session_start();
if (!isset($_SESSION['user_id'])){
    header("Location: " . $hostname);
}
include 'header.php';
if($_SESSION['user_role'] != 'user') {
    echo '<center><h4><br><br>You are blocked by Admin. To unblock Please Contact Sahil Kumar (+919814740275)</h4><br><br><br><br></center>';
}
?>
    <?php if($_SESSION['user_role'] == 'user') { ?>
    <div id="user_profile-content">
        <div class="container">
            <div class="row">
                <div class="col-md-offset-3 col-md-6">
                    <h2 class="section-head">Seller Contact Details</h2>
                    <?php
                        $user_id = $_POST["user_id"];
                        $db = new Database();
                        $db->select('user','*',null,"user_id = '{$user_id}'",null,null);
                        $result = $db->getResult();
                        if (count($result) > 0) {
                            $table = '<table>';
                            foreach($result as $row) { ?>
                                <table class="table table-bordered table-responsive">
                                    <tr>
                                        <td><b>First Name :</b></td>
                                        <td><?php echo $row["f_name"]; ?></td>
                                    </tr>
                                    <tr>
                                        <td><b>Last Name :</b></td>
                                        <td><?php echo $row["l_name"]; ?></td>
                                    </tr>
                                    <tr>
                                        <td><b>Mobile :</b></td>
                                        <td><?php echo $row["mobile"]; ?></td>
                                    </tr>
                                    <tr>
                                        <td><b>Address :</b></td>
                                        <td><?php echo $row["address"]; ?></td>
                                    </tr>
                                    <tr>
                                        <td><b>City :</b></td>
                                        <td><?php echo $row["city"]; ?></td>
                                    </tr>
                                </table>
                            <?php }
                        }
                        ?>
                        <a class="modify-btn btn" href="tel:<?php echo $row["mobile"]; ?>">Call Now</a>
                        <a class="modify-btn btn" href="./">Continue Shopping</a>
                </div>
            </div>
        </div>
    </div>
    <?php }?>
<?php include 'footer.php';


?>
  