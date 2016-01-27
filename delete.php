<!DOCTYPE html>
<html>
       <!--Similar comments are ommitted -->
       
       
    <head>
        <title>delete</title>
    </head>
    <body>
        <?php
            session_start();
            require 'database.php';
            
            $id=$_POST['id'];
            
            if ($_SESSION['loginstatus']!=1){
                header("Location: simple news site.html");
                exit;
            }

            if($_SESSION['token'] !== $_POST['token']){
                die("Request forgery detected");
            }

            $username=$_SESSION['username'];
              
            $stmt = $mysqli->prepare("delete from stories where pk_ID=? ");
            if (!$stmt){
                printf("Query Prep Failed: %s\n", $mysqli->error);
                exit;
            }
            $stmt->bind_param('s',$id);
            $stmt->execute();
            $stmt->close();
            
            //after deleting the story, redirects to the main story page according to who the user is
            if ($_SESSION['username']==admin){
                     header("Location: admin.php");
                    exit;
                }else{
                header("Location: stories.php");
                exit;
                }
        ?>
    </body>
</html>
