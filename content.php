<!DOCTYPE html>
       <!--Similar comments are ommitted -->
       
       
       
<html>
    <head>
        <title>Content</title>
    </head>
    <body>
        <?php
            session_start();
            require 'database.php';
            
            if ($_SESSION['loginstatus']!=1){
                header("Location: simple news site.html");
                exit;
            }
            
    
            $id=$_GET['id'];
            $_SESSION['id']=$id;
            $token=$_SESSION['token'];
            
            $stmt = $mysqli ->prepare("select pk_ID, username, time_created, content, url from stories where pk_ID=?");    
                if(!$stmt){
                    printf("Query Prep Failed: %s\n", $mysqli-> error);
                    exit;
                }
            $stmt->bind_param('s',$id);
            $stmt -> execute();
            $stmt ->bind_result($id, $user,$time_created,$content,$url);
            
            $stmt->fetch();
            
			#Adam css
			echo "<h1> Story Content </h1>";
			
			printf("\t %s %s:<br/> %s <br/> URL: %s \n",
                   htmlentities($user),
                   htmlentities($time_created),
                   htmlentities($content),
                   htmlentities($url)
                   );
			echo "<br>";
            if ($user==$_SESSION['username']){//this line checks if the user has rights to delete and edit the story
                print "<form action='delete.php' method='POST'>";
                print "<input type='hidden' name= 'id' value='$id'/>";
                print "<input type='hidden' name='token' value='$token'/>";
                print "<input type= 'submit' value= 'Delete Story'/>";
                print "</form>";
                
                print "<form action='edit.php' method='POST'>";
                print "<input type='hidden' name= 'id' value='$id'/>";
                print "<input type='hidden' name='token' value='$token' />";
                print "<input type= 'submit' value= 'Edit Story'/>";
                print "</form>";
            }
            $stmt->close();
			
			#Added for css
			echo "<br> <br> <h2> Comments </h2>";
            
            $stmt = $mysqli ->prepare("select pk_ID2, comments.username, comments.time_created, comments.content from comments join stories on (stories.pk_ID=comments.pk_ID1) where pk_ID1=? order by time_created");    
                if(!$stmt){
                    printf("Query Prep Failed: %s\n", $mysqli-> error);
                    exit;
                }
            $stmt -> bind_param('s',$id);
            $stmt -> execute();
            $stmt ->bind_result($idC, $user,$time_created,$content);
            

            while ($stmt->fetch()){
                print "<br/>";
				print "<br/>";
                printf("\t  %s %s:<br/> %s \n",
                       htmlentities($user),
                       htmlentities($time_created),
                       htmlentities($content)
                       );
                if ($user==$_SESSION['username']){//this lien checks if the user has the right to delete or edit the comment
                    print "<form action='commentdelete.php' method='POST'>";
                    print "<input type='hidden' name= 'id' value='$idC'>";
                    print "<input type='hidden' name='token' value='$token'>";
                    print "<input type= 'submit' value= 'Delete Comment'>";
                    print "</form>";
                    
                    print "<form action='commentedit.php' method='POST'>";
                    print "<input type='hidden' name= 'id' value='$idC'>";
                    print "<input type='hidden' name='token' value='$token' />";
                    print "<input type= 'submit' value= 'Edit Comment'>";
                    print "</form>";
                }
            }
            $stmt->close();
        ?>
        <br>
		<br>
		<!-- changed from Back -->
        <form action="back.php" method="GET">
                <input type="submit" value="Back to Stories"/>
        </form>
        <br>
		<br>
        <textarea rows="4" cols="50" name="content" form="write">Write your comment here.</textarea>
        <br/>
        <form action="commentwrite.php" method="POST" id="write">
			<!-- from Submit -->
            <input type="submit" value="Submit Comment"/>
        </form>
        
    </body>
</html>
