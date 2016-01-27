<!DOCTYPE html>
    <!--Similar comments are ommitted -->
    
    
<html>
    <head>
        <title>Comment Write</title>
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
            
            // the codes inserts info about the enter comment into the comments datatable 
            $stmt = $mysqli->prepare("insert into comments (pk_ID1, username, content) values (?,?,?)");
            if (!$stmt){
                printf("Query Prep Failed: %s\n", $mysqli->error);
                exit;
            }
            $stmt->bind_param('sss', $id ,$username, $content);
            $stmt->execute();
            $stmt->close();
            header("Location: stories.php");
        ?>
    </body>
</html>
