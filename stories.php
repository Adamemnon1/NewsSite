<!DOCTYPE html>
       <!--Similar comments are ommitted -->
       
       
<html>
    <head>
        <title>Stories</title>
    </head>
    <body>
	
	<style scoped type = "text/css">
		form {text-align : center;}
		textarea {text-align : center;
			display: block;
			margin-left: auto;
			margin-right:auto;
			}
	</style>
		<h1>Stories:</h1>
		<br>
        <?php
            session_start();
            require 'database.php';
            
             if ($_SESSION['loginstatus']!=1){
                header("Location: simple news site.html");
                exit;
            }
            
            $token=$_SESSION['token'];
            
            $stmt = $mysqli ->prepare("select pk_ID, username, time_created, content from stories order by time_created");    
                if(!$stmt){
                    printf("Query Prep Failed: %s\n", $mysqli-> error);
                    exit;
                }
            
            $stmt -> execute();
            $stmt ->bind_result($id, $user,$time_created,$content);
            
            while ($stmt->fetch()){
                
				printf("\t%s %s:<br/> %s\n",
                       htmlentities($user),
                       htmlentities($time_created),
                       htmlentities($content)
                       );
                print "<form action='content.php' method='GET'>";
                print "<input type='hidden' name= 'id' value='$id'/>";
                print "<input type= 'submit' value= 'View Content'/>";
                print "</form>";
				echo "<br> <br>";
            }

            $stmt->close();
        ?>
        
		<br>
		<br>
        
        <textarea rows="4" cols="50" name="content" form="write">Write your story here.</textarea>
        <br/>
        <form action="write.php" method="POST" id="write">
            URL (optional): <input type="text" name="url"/>
			<br>
            <input type="submit" value="Submit Story"/>
            <input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
        </form>
        <br/>
        
         <form action="search.php" method="POST">
            <input type="text" name="query" />
            <select name="type">
                <option value="username">Username</option>
                <option value="story">Story</option>
                <option value="comment">Comment</option>
            </select>
            <input type="submit" value="Search"/>
        </form>
        <br>
        <form action="logout.php" method="GET">
            <input type="submit" value="Logout"/>
        </form>
    </body>
</html>
