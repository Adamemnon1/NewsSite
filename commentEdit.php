<!DOCTYPE html>
    <!--Similar comments are ommitted -->
    
    
<html>
    <head>
        <title>Comment Edit</title>
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

            $username=$_SESSION['username'];
            
            //the code below displays the content of the comment in a textarea   
            $stmt = $mysqli->prepare("select content from comments where pk_ID2=? ");
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
        <form action="commentchange.php" method="POST" id="edit">
            <input type="submit" value="Submit"/>
        </form>
    </body>
</html>
