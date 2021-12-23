
<?php require_once('../includes/config.php'); 
error_reporting(0);
if(!$user->is_logged_in() or $_SESSION['username']!="admin"){ header('Location: login.php'); }
?>
<?php include("head.php");  ?>
    <title>Update Article-PTU BLOG ADMIN</title>
<script src='tinymce/tinymce.min.js'></script>
  <script>
          tinymce.init({
    selector: 'textarea#myTextarea',
    plugins: 'print preview paste importcss searchreplace autolink autosave save directionality code visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists wordcount imagetools textpattern noneditable help charmap quickbars emoticons',
    imagetools_cors_hosts: ['picsum.photos'],
    menubar: 'file edit view insert format tools table help',
    toolbar: 'undo redo | bold italic underline strikethrough | fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | forecolor backcolor removeformat | pagebreak | charmap emoticons | fullscreen  preview save print | insertfile image media template link anchor codesample | ltr rtl',
    toolbar_sticky: true,
    autosave_ask_before_unload: true,
    autosave_interval: "30s",
    autosave_prefix: "{path}{query}-{id}-",
    autosave_restore_when_empty: false,
    autosave_retention: "2m",
    image_advtab: true,
    /*content_css: '//www.tiny.cloud/css/codepen.min.css',*/
    image_class_list: [
        { title: 'None', value: '' },
        { title: 'Some class', value: 'class-name' }
    ],
    importcss_append: true,
    file_picker_callback: function (callback, value, meta) {
        /* Provide file and text for the link dialog */
        if (meta.filetype === 'file') {
            callback('https://www.google.com/logos/google.jpg', { text: 'My text' });
        }
    
        /* Provide image and alt text for the image dialog */
        if (meta.filetype === 'image') {
            callback('https://www.google.com/logos/google.jpg', { alt: 'My alt text' });
        }
    
        /* Provide alternative source and posted for the media dialog */
        if (meta.filetype === 'media') {
            callback('movie.mp4', { source2: 'alt.ogg', poster: 'https://www.google.com/logos/google.jpg' });
        }
    },
    templates: [
        { title: 'New Table', description: 'creates a new table', content: '<div class="mceTmpl"><table width="98%%"  border="0" cellspacing="0" cellpadding="0"><tr><th scope="col"> </th><th scope="col"> </th></tr><tr><td> </td><td> </td></tr></table></div>' },
        { title: 'Starting my story', description: 'A cure for writers block', content: 'Once upon a time...' },
        { title: 'New list with dates', description: 'New List with dates', content: '<div class="mceTmpl"><span class="cdate">cdate</span><br /><span class="mdate">mdate</span><h2>My List</h2><ul><li></li><li></li></ul></div>' }
    ],
    template_cdate_format: '[Date Created (CDATE): %m/%d/%Y : %H:%M:%S]',
    template_mdate_format: '[Date Modified (MDATE): %m/%d/%Y : %H:%M:%S]',
    height: 600,
    image_caption: true,
    quickbars_selection_toolbar: 'bold italic | quicklink h2 h3 blockquote quickimage quicktable',
    noneditable_noneditable_class: "mceNonEditable",
    toolbar_mode: 'sliding',
    contextmenu: "link image imagetools table",
});
  </script>
<?php include("header.php");  ?>

<div class="content">
 
<h2>Edit Post</h2>


    <?php

   
    if(isset($_POST['submit'])){


        //collect form data
        extract($_POST);

        //very basic validation
        if($articleId ==''){
            $error[] = 'This post is missing a valid id!.';
        }

        if($articleTitle ==''){
            $error[] = 'Please enter the title.';
        }

        if($articleDescrip ==''){
            $error[] = 'Please enter the description.';
        }

        if($articleContent ==''){
            $error[] = 'Please enter the content.';
        }
        


        if(!isset($error)){
try {

   

    //insert into database
    $stmt = $db->prepare('UPDATE sahil_blog SET articleTitle = :articleTitle, articleSlug = :articleSlug, articleDescrip = :articleDescrip, articleContent = :articleContent,articleTags = :articleTags,status = :status WHERE articleId = :articleId') ;
    $stmt->execute(array(
        ':articleTitle' => $articleTitle,
        ':articleSlug' => $articleSlug,
        ':articleDescrip' => $articleDescrip,
        ':articleContent' => $articleContent,
        ':articleTags' => $articleTags,
        ':articleId' => $articleId,
        ':status'=>$status
    ));

//category
$stmt = $db->prepare('DELETE FROM sahil_cat_links WHERE articleId = :articleId');
$stmt->execute(array(':articleId' => $articleId));

if(is_array($categoryId)){
    foreach($_POST['categoryId'] as $categoryId){
        $stmt = $db->prepare('INSERT INTO sahil_cat_links (articleId,categoryId)VALUES(:articleId,:categoryId)');
        $stmt->execute(array(
            ':articleId' => $articleId,
            ':categoryId' => $categoryId
        ));
    }
}
    //redirect to index page
    header('Location: index.php?action=updated');
    exit;

} catch(PDOException $e) {
                echo $e->getMessage();
            }

        }

    }

    ?>


    <?php
    //check for any errors
    if(isset($error)){
        foreach($error as $error){
            echo $error.'<br>';
        }
    }

        try {

            $stmt = $db->prepare('SELECT articleId, articleSlug,articleTitle, articleDescrip, articleContent,articleTags FROM sahil_blog WHERE articleId = :articleId') ; 
            $stmt->execute(array(':articleId' => $_GET['id']));
            $row = $stmt->fetch(); 

        } catch(PDOException $e) {
            echo $e->getMessage();
        }

    ?>

        <form action='' method='post'>
            <h2><label for="Status">Update Status:</label></h2>
                <select name="status" id="status">
                    <option value="Draft">Draft</option>
                    <option value="Published">Published</option>
                </select>

            <input type='hidden' name='articleId' value="<?php echo $row['articleId']; ?>">
                <h2>
                    <label>Article Title</label><br>
                    <input type='text' name='articleTitle' style=" width:100%; height: 40px" value= "<?php echo $row['articleTitle']; ?>">
                </h2>
                <h2>
                    <label>Article Slug</label><br>
                    <input type='text' name='articleSlug' style=" width:100%; height: 40px" value= "<?php echo $row['articleSlug']; ?>">
                </h2>
                <h2><label>Short Description (Meta Description) </label><br>
                <textarea name='articleDescrip' style=" width:100%;" cols='120' rows='5'><?php echo $row['articleDescrip'];?></textarea></h2>
                <h2><label> Long Description (Body Content)</label><br>
                <textarea name='articleContent' id='myTextarea' class='mceEditor' cols='120' rows='20'><?php echo $row['articleContent'];?></textarea></h2>
                <fieldset>
                    <h2><label>Categories</label>
                    <br>
                    <?php
                $checked = null;
                    $stmt2 = $db->query('SELECT categoryId, categoryName FROM sahil_category ORDER BY categoryName');
                    while($row2 = $stmt2->fetch()){

                        $stmt3 = $db->prepare('SELECT categoryId FROM sahil_cat_links WHERE categoryId = :categoryId AND articleId = :articleId') ;
                        $stmt3->execute(array(':categoryId' => $row2['categoryId'], ':articleId' => $row['articleId']));
                        $row3 = $stmt3->fetch();
                        if($row3['categoryId'] == $row2['categoryId']){
                            $checked = "checked='checked'";
                        } else {
                            $checked = null;
                        }
                        echo "<input type='checkbox' name='categoryId[]' value='".$row2['categoryId']."' $checked>".$row2['categoryName']."<br/>";
                    }
                    ?>
                </h2>
                </fieldset>
                <h2><label>Articles Tags (Seprated by comma without space)</label><br>
                <input type='text' name='articleTags' style="width:100%;height:40px;"value='<?php echo $row['articleTags'];?>'>
                <br></h2>
                <button name='submit' class="subbtn"> Update</button>

        </form>