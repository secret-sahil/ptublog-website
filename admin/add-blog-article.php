<?php require_once('../includes/config.php'); 
require_once('../includes/functions.php'); 
if(!$user->is_logged_in()or $_SESSION['group']=="c"){ header('Location: login.php'); }
?>
<?php
error_reporting(0);
?>
<?php include("head.php");  ?>
<!-- On page head area--> 
  <title>Add New Article-PTU BLOG ADMIN</title>
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
  <?php include("header.php"); 

   ?>

<div class="content">
 
    <h1>Add New Article</h1>

    <?php

    //if form has been submitted process it
    if(isset($_POST['submit'])){

        $targetDir = "../assets/Blog-post/";
        $fileName = basename($_FILES["file"]["name"]);
        $targetFilePath = $targetDir . $fileName;
        $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);

        if(isset($_POST["submit"]) && !empty($_FILES["file"]["name"])){
            // Allow certain file formats
            $allowTypes = array('jpg','png','jpeg','gif','pdf');
            if(in_array($fileType, $allowTypes)){
                // Upload file to server
                if(move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)){
                        $statusMsg = "The file ".$fileName. " has been uploaded successfully."; 
                }else{
                    $error[] = "Please select a file to upload. Only JPG, JPEG, PNG, GIF, & PDF files are allowed to upload.";
                }
            }
        }

        //collect form data
        extract($_POST);
        $author=$_SESSION["username"];

        //very basic validations
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

        $articleSlug=slug($articleTitle);

    //insert into database
    $stmt = $db->prepare('INSERT INTO sahil_blog (articleTitle,articleSlug,articleDescrip,articleContent,articleDate,articleTags,featuredImg,author) VALUES (:articleTitle, :articleSlug, :articleDescrip, :articleContent, :articleDate, :articleTags, :featuredImg, :author)') ;
  



    $stmt->execute(array(
        ':articleTitle' => $articleTitle,
        ':articleSlug' => $articleSlug,
        ':articleDescrip' => $articleDescrip,
        ':articleContent' => $articleContent,
        ':articleDate' => date('Y-m-d H:i:s'),
        ':articleTags' => $articleTags,
        ':featuredImg' => $fileName,
        ':author'=> $author
    ));
//add categories
 
$articleId = $db->lastInsertId();
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
    header('Location: index.php?action=added');
    exit;

}catch(PDOException $e) {
                echo $e->getMessage();
            }

        }

    }

    //check for any errors
    if(isset($error)){
        foreach($error as $error){
            echo '<p class="message">'.$error.'</p>';
        }
    }
    ?>
 <form action="" method="post" enctype="multipart/form-data">

        <h2><label>Article Title</label><br>
        <input type="text" name="articleTitle" style="width:100%;height:40px" value="<?php if(isset($error)){ echo $_POST['articleTitle'];}?>"></h2>

        <h2><label>Upload Featured Image</label></h2>
        <input type="file" name="file">

        <h2><label>Short Description(Meta Description) </label><br>
        <textarea name="articleDescrip" style="width:100%;" cols="120" rows="6"><?php if(isset($error)){ echo $_POST['articleDescrip'];}?></textarea></h2>

        <h2><label>Long Description(Body Content)</label><br>
        <textarea name="articleContent" id="myTextarea" class="mceEditor" cols="120" rows='20'><?php if(isset($error)){ echo $_POST['articleContent'];}?></textarea></h2>
        
        <fieldset>
            <h2><legend>Categories</legend>

            <?php    
        $checked = null;
            $stmt2 = $db->query('SELECT categoryId, categoryName FROM sahil_category ORDER BY categoryName');

            while($row2 = $stmt2->fetch()){

                if(isset($_POST['categoryId'])){

                    if(in_array($row2['categoryId'], $_POST['categoryId'])){
                    $checked="checked='checked'";
                    }else{
                    

                    }
                }

        echo "<input type='checkbox' name='categoryId[]' value='".$row2['categoryId']."' $checked> ".$row2['categoryName']."<br />";
            }

            ?>
        </h2>
        </fieldset>
        <h2><label>Articles Tags (Separated by comma without space)</label><br>
        <input type='text' name='articleTags' value='<?php if(isset($error)){ echo $_POST['articleTags'];}?>' style="width:100%;height:40px"></h2>
 
        <button name="submit" class="subbtn">Submit</button>


    </form>



</div>

<?php include("footer.php");  ?>

 