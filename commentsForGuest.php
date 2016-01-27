<!DOCTYPE html>
    <!--Similar comments are ommitted -->
    
    
<html>
    <head>
        <title>Comments</title>
    </head>
    <body>
        <?php
            session_start();
            require 'database.php';
    
            $id=$_POST['id'];
            $_SESSION['id']=$id;
            
            $stmt = $mysqli ->prepare("select pk_ID2, comments.username, comments.time_created, comments.content from comments join stories on (stories.pk_ID=comments.pk_ID1) where pk_ID1=? order by time_created");    
                if(!$stmt){
                    printf("Query Prep Failed: %s\n", $mysqli-> error);
                    exit;
                }
            $stmt -> bind_param('s',$id);
            $stmt -> execute();
            $stmt ->bind_result($idC, $user,$time_created,$content);
            
            while ($stmt->fetch()){
                printf("\t %s %s:<br/> %s\n",
                       htmlentities($user),
                       htmlentities($time_created),
                       htmlentities($content)
                       );
                print "<br/>";
                print "<br/>";
            }
            
            $stmt->close();
        ?>
        
        <form action="back.php" method="GET">
                <input type="submit" value="Back"/>
        </form>
        
        
    </body>
</html>
