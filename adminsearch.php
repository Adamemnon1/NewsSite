<!DOCTYPE html>
<html>
    <!--Similar comments are ommitted -->
    
    <head>
        <title>Admin Search</title>
    </head>
    <body>
        <?php
            session_start();
            require 'database.php';
            
             if ($_SESSION['loginstatus']!=1){
                header("Location: simple news site.html");
                exit;
            }
            
            $query=$_POST['query'];
            $type= $_POST['type'];
            
            //the conditional statements below help distiguish the type of search that the user selects 
            if ($type== "story"){
                $stmt = $mysqli ->prepare("select pk_ID, username, time_created, content from stories where content like '%$query%' order by time_created");
                }elseif($type=="username"){
                     $stmt = $mysqli ->prepare("select pk_ID, username, time_created, content from stories where username like '%$query%' order by time_created");
                }else{
                 $stmt = $mysqli ->prepare("select pk_ID2, username, time_created, content from comments where content like '%$query%' order by time_created");   
                }
            
               
                if(!$stmt){
                    printf("Query Prep Failed: %s\n", $mysqli-> error);
                    exit;
                }
            
            $stmt -> execute();
            $stmt ->bind_result($id, $user,$time_created,$content);
            
            while ($stmt->fetch()){
                printf("\t %s %s:<br/> %s \n",
                       htmlentities($user),
                       htmlentities($time_created),
                       htmlentities($content)
                       );
                print "<form action='delete.php' method='POST'>";
                print "<input type='hidden' name= 'id' value='$id'>";
                print "<input type= 'submit' value= 'Delete'>";
                print "</form>";
                    
                print "<form action='edit.php' method='POST'>";
                print "<input type='hidden' name= 'id' value='$id'>";
                print "<input type= 'submit' value= 'Edit'>";
                print "</form>";
                
                print "<form action='comment.php' method='POST'>";
                print "<input type='hidden' name= 'id' value='$id'>";
                print "<input type= 'submit' value= 'View Comments'>";
                print "</form>";
            }
            $stmt->close();
        ?>
        
        <form action="logout.php" method="GET">
            <input type="submit" value="Logout"/>
        </form>
    </body>
</html>
