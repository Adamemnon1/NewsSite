<!DOCTYPE html>
    <!--Similar comments are ommitted -->
    
    
<html>
    <head>
        <title>comment change</title>
    </head>
    <body>
        <?php
            session_start();
            require 'database.php';
            if ($_SESSION['loginstatus']!=1){
                header("Location: simple news site.html");
                exit;
            }

            $username=$_SESSION['username'];
            
            $content=filter_var($_POST['content'], FILTER_SANITIZE_STRING);
            $id=$_SESSION['id'];
              
            //the code below updates the cotent of comments searching by the id of the comment
            $stmt = $mysqli->prepare("update comments set content=? where pk_ID2=?");
            if (!$stmt){
                printf("Query Prep Failed: %s\n", $mysqli->error);
                exit;
            }
            $stmt->bind_param('ss',$content,$id);
            $stmt->execute();
            $stmt->close();
            header("Location: stories.php");
        ?>
