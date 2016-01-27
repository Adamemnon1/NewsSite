<!DOCTYPE html>
    <!--Similar comments are ommitted -->
    
    
<html>
    <head>
        <title>Comment Delete</title>
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

            //the code below deletes all info associated with a comment which has a specific ID 
            $stmt = $mysqli->prepare("delete from comments where pk_ID2=? ");
            if (!$stmt){
                printf("Query Prep Failed: %s\n", $mysqli->error);
                exit;
            }
            $stmt->bind_param('s',$id);
            $stmt->execute();
            $stmt->close();
            header("Location: stories.php");
        ?>
    </body>
</html>
