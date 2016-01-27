<!DOCTYPE html>
    <!--Similar comments are ommitted -->
    
    
<html>
    <head>
        <title>back</title>
    </head>
    <body>
        <?php
            session_start();
            //the conditional statement directs different users to their main story page accordingly
            if ($_SESSION['loginstatus']==1){
                if ($_SESSION['username']==admin){
                     header("Location: admin.php");
                    exit;
                }
                header("Location: stories.php");
                exit;
            }elseif ($_SESSION['loginstatus']==0){
                header("Location: storiesforguest.php");
                exit;
            }
           
        ?>
    </body>
</html>
