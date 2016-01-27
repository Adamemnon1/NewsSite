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
				display : block;
				margin-left: auto;
				margin-right: auto;}
	</style>
	<h1>Stories:</h1>
		<br>
        <?php
            session_start();
            require 'database.php';
            $stmt = $mysqli ->prepare("select pk_ID, username, time_created, content from stories order by time_created");    
                if(!$stmt){
                    printf("Query Prep Failed: %s\n", $mysqili-> error);
                    exit;
                }
            
            $stmt -> execute();
            $stmt ->bind_result($id, $user,$time_created,$content);
            
            while ($stmt->fetch()){
                printf("\t  %s %s:<br/> %s\n",
                       htmlentities($user),
                       htmlentities($time_created),
                       htmlentities($content)
                       );
                print "<form action='commentsforguest.php' method='POST'>";
                print "<input type='hidden' name= 'id' value='$id'>";
                print "<input type= 'submit' value= 'View Comments'>";
                print "</form>";
				echo "<br> <br>";
            }

            $stmt->close();
        ?>
        <br>
		<br>
        <form action="logout.php" method="GET">
                <input type="submit" value="Logout"/>
        </form>
        

        
    </body>
</html>
