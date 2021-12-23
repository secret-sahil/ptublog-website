<?php
//include config
require_once('../includes/config.php');

//if not logged in redirect to login page
if(!$user->is_logged_in() or $_SESSION['group']=="c"){ header('Location: login.php'); }

//show message from add / edit page
if(isset($_GET['delcat'])){ 

    $stmt = $db->prepare('DELETE FROM sahil_category WHERE categoryId = :categoryId') ;
    $stmt->execute(array(':categoryId' => $_GET['delcat']));

    header('Location: blog-categories.php?action=deleted');
    exit;
} 

?>
<?php include("head.php");  ?>
  <title>Categories-PTU BLOG ADMIN</title>
  <script language="JavaScript" type="text/javascript">
  function delcat(id, title)
  {
      if (confirm("Are you sure you want to delete '" + title + "'"))
      {
          window.location.href = 'blog-categories.php?delcat=' + id;
      }
  }
  </script>
  <?php include("header.php");  ?>

<div class="content">
 <?php 
    //show message from add / edit page
    if(isset($_GET['action'])){ 
        echo '<h3>Category '.$_GET['action'].'.</h3>'; 
    } 
    ?>

    <table>
    <tr>
        <th>Title</th>
        <?php if($_SESSION['username'] == "admin"){?>
        <th>Operation</th>
        <?php }?>
    </tr>
    <?php
        try {

            $stmt = $db->query('SELECT categoryId, categoryName, categorySlug FROM sahil_category ORDER BY categoryName DESC');
            while($row = $stmt->fetch()){
                
                echo '<tr>';
                echo '<td>'.$row['categoryName'].'</td>';
                ?>

                <td>
                <?php if($_SESSION['username'] == "admin"){?>
                    <button class="editbtn">  <a href="edit-blog-category.php?id=<?php echo $row['categoryId'];?>">Edit</a>   </button> 
                    <button class="delbtn">  <a href="javascript:delcat('<?php echo $row['categoryId'];?>','<?php echo $row['categorySlug'];?>')">Delete</a></button>
                <?php }?>
                </td>
                
                <?php 
                echo '</tr>';

            }

        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    ?>
    </table>
    <?php if($_SESSION['username'] == "admin"){?>
    <p><button class="editbtn"><a href='add-blog-category.php'>Add New Category</a></button></p><?php }?>
</div>
<?php include("footer.php");  ?>
 