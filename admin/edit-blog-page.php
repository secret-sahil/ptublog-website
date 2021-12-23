<?php require_once('../includes/config.php'); 
require_once('../includes/functions.php');
if(!$user->is_logged_in() or $_SESSION['username']!="admin"){
     header('Location: login.php'); }
?>
<?php include("head.php");  ?>
    <title>Update Page-PTU BLOG ADMIN</title>
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
        if($pageId ==''){
            $error[] = 'Invalid ID .';
        }

        if($pageTitle ==''){
            $error[] = 'Please enter the Page title.';
        }

        if($pageDescrip ==''){
            $error[] = 'Please enter the Page description.';
        }

        if($pageContent ==''){
            $error[] = 'Please enter the content.';
        }
          
        if($pageKeywords ==''){
            $error[] = 'Please enter the Article Keywords.';
        }



        if(!isset($error)){
try {

   
 $pageSlug = slug($pageTitle);
    //insert into database
    $stmt = $db->prepare('UPDATE sahil_pages SET pageTitle = :pageTitle, pageSlug = :pageSlug, pageDescrip = :pageDescrip, pageContent = :pageContent, pageKeywords = :pageKeywords WHERE pageId = :pageId') ;
$stmt->execute(array(
    ':pageTitle' => $pageTitle,
    ':pageSlug' => $pageSlug,
    ':pageDescrip' => $pageDescrip,
    ':pageContent' => $pageContent,
    ':pageId' => $pageId,
    ':pageKeywords' => $pageKeywords
));

    //redirect to index page
    header('Location: blog-pages.php?action=updated');
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

           $stmt = $db->prepare('SELECT pageId, pageSlug,pageTitle, pageDescrip, pageContent, pageKeywords FROM sahil_pages WHERE pageId = :pageId') ;
            $stmt->execute(array(':pageId' => $_GET['pageId']));
            $row = $stmt->fetch(); 

        } catch(PDOException $e) {
            echo $e->getMessage();
        }

    ?>

    <form action='' method='post'>
        <input type='hidden' name='pageId' value='<?php echo $row['pageId'];?>'>

           <h2><label>Page Title</label><br>
        <input type='text' name='pageTitle' style="width:100%;height:40px" value='<?php echo $row['pageTitle'];?>'></h2>
        


       <h2><label>Short Description(Meta Description) </label><br>
        <textarea name='pageDescrip' style="width:100%;" cols='120' rows='6'><?php echo $row['pageDescrip'];?></textarea></h2>

       <h2><label>Long Description(Body Content)</label><br>
        <textarea name='pageContent' style="width:100%;" id='myTextarea' class='mceEditor' cols='120' rows='20'><?php echo $row['pageContent'];?></textarea></h2>
      
<h2><label>Page Keywords (Seprated by comma without space)</label><br>
<input type='text' name='pageKeywords' style="width:100%;height:40px;"value='<?php echo $row['pageKeywords'];?>' 
<br></h2>

        <input type='submit' class="editbtn" name='submit' value='Update'>

    </form>

</div>
<?php include("footer.php");  ?>
 