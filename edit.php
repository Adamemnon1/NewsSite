<!DOCTYPE html>
       <!--Similar comments are ommitted -->
       
       
<html>
    <head>
        <title>Edit</title>
    </head>
    <body>
        <?php
            session_start();
            require 'database.php';
            
            $id=$_POST['id'];
            $_SESSION['id']=$id;
            
            if ($_SESSION['loginstatus']!=1){
                header("Location: simple news site.html");
                exit;
            }
            
            if($_SESSION['token'] !== $_POST['token']){
                die("Request forgery detected");
            }

            $username=$_SESSION['username'];
              
            $stmt = $mysqli->prepare("select content from stories where pk_ID=? ");
            if (!$stmt){
                printf("Query Prep Failed: %s\n", $mysqli->error);
                exit;
            }
            $stmt->bind_param('s',$id);
            $stmt->execute();
            $stmt ->bind_result($content);
            $stmt ->fetch();
            $stmt->close();
            print "<textarea rows='4' cols='50' name='content' form='edit'>";
            echo $content;
            print "</textarea>";
        ?>
        
        
        <br/>
        <form action="change.php" method="POST" id="edit">
            <input type="submit" value="Submit"/>
        </form>
    </body>
</html>
