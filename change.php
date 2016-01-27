<!DOCTYPE html>
    <!--Similar comments are ommitted -->
    
    
<html>
    <head>
        <title>change</title>
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
            
            $stmt = $mysqli->prepare("update stories set content=? where pk_ID=?");
            if (!$stmt){
                printf("Query Prep Failed: %s\n", $mysqli->error);
                exit;
            }
            $stmt->bind_param('ss',$content,$id);
            $stmt->execute();
            $stmt->close();
            header("Location: stories.php");
        ?>
    </body>
</html>
