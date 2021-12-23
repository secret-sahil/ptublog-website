<?php 
//include connection file 
require_once('../includes/config.php');

//check login or not 
if(!$user->is_logged_in() or $_SESSION['group']=="c"){ header('Location: login.php'); }


if(isset($_GET['delpost'])){ 

    $stmt = $db->prepare('DELETE FROM sahil_blog WHERE articleId = :articleId') ;
    $stmt->execute(array(':articleId' => $_GET['delpost']));

    header('Location: index.php?action=deleted');
    exit;
} 

?>

<?php include("head.php");  ?>

  <title>PTU BLOG ADMIN</title>
  <script language="JavaScript" type="text/javascript">
  function delpost(id, title)
  {
      if (confirm("Are you sure you want to delete '" + title + "'"))
      {
          window.location.href = 'index.php?delpost=' + id;
      }
  }
  </script>
  <?php include("header.php");  ?>

<div class="content">
<?php 
    //show message from add / edit page
    if(isset($_GET['action'])){ 
        echo '<h3>Post '.$_GET['action'].'.</h3>'; 
    } 
    ?>

    <table>
    <tr>
        <th>Article Title</th>
        <th>Posted Date</th>
        <th>Status</th>
        <?php if($_SESSION['username'] == "admin"){?>
        <th>Update</th>
         <th>Delete</th>
        <?php }?>
    </tr>
    <?php
    echo "Welcome ".$_SESSION["username"]."!";
    ?>
    <?php
        try {

            $stmt = $db->query('SELECT articleId, articleTitle, articleDate, status FROM sahil_blog ORDER BY articleId DESC');
            while($row = $stmt->fetch()){
                echo '<tr>';
                echo '<td>'.$row['articleTitle'].'</td>';
                echo '<td>'.date('jS M Y', strtotime($row['articleDate'])).'</td>';
                echo '<td>'.$row['status'].'</td>';
                ?>
                <?php if($_SESSION['username'] == "admin"){?>
                <td>
                     <button class="editbtn" > <a href="edit-blog-article.php?id=<?php echo $row['articleId'];?>" >Edit </a >  </button ></td> <td>
                    <button class="delbtn" >    <a href="javascript:delpost('<?php echo $row['articleId'];?>','<?php echo $row['articleTitle'];?>')" >Delete </a > </button >
                </td>
                <?php }?>
                <?php 
                echo '</tr>';

            }

        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    ?>
    </table>

    <p> <button class="editbtn"><a href='add-blog-article.php'>Add New Article</a></button></p>       
</p></div>

<?php include("footer.php");  ?>