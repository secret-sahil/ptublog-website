<?php
//include connection file 
require_once('../includes/config.php');

//check logged in or not 
if(!$user->is_logged_in() or $_SESSION['username']!="admin"){ header('Location: login.php'); }

// add / edit page
if(isset($_GET['deluser'])){ 

  
  if($_GET['deluser'] !='1'){

    $stmt = $db->prepare('DELETE FROM sahil_blog_users WHERE userId = :userId') ;
    $stmt->execute(array(':userId' => $_GET['deluser']));

    header('Location: blog-users.php?action=deleted');
    exit;

  }
} 

?>

<?php include("head.php");  ?>
  <title>Users-PTU BLOG ADMIN</title>
  <script language="JavaScript" type="text/javascript">
  function deluser(id, title)
  {
    if (confirm("Are you sure you want to delete '" + title + "'"))
    {
      window.location.href = 'blog-users.php?deluser=' + id;
    }
  }
  </script>
  <?php include("header.php");  ?>

<div class="content">


 <?php 
  //show message from add / edit page
  if(isset($_GET['action'])){ 
    echo '<h3>User '.$_GET['action'].'.</h3>'; 
  } 
  ?>

  <table>
  <tr>
    <th>Username </th>
    <th>Email </th>
    <th>Edit </th>
    <th>Delete </th>

  </tr>
   <?php
    try {

      $stmt = $db->query('SELECT userId, username, email FROM sahil_blog_users ORDER BY userId');
      while($row = $stmt->fetch()){
        
        echo ' <tr>';
        echo ' <td>'.$row['username'].' </td>';
        echo ' <td>'.$row['email'].' </td>';
        ?>

        <td>
          <button class="editbtn"><a href="edit-blog-user.php?id=<?php echo $row['userId'];?>">Edit</a> </button>
          <?php if($row['userId'] != 1){?>
          </td>
            <td><button class="delbtn"><a href="javascript:deluser('<?php echo $row['userId'];?>','<?php echo $row['username'];?>')">Delete</a></button>

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

  <p><button class="editbtn"><a href='add-blog-user.php'>Add User</a></button></p>


</div>
  



<?php include("footer.php");  ?>


