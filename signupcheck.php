<?php 

   require 'db.php' ;

 
    if(!isset($_POST['submit'])){
        echo '<script language="javascript"> alert("Access Denied") </script>'; 
        header("Refresh: 1; url=usersignup.php");
    }

    else{

        if(isset($_POST['Name']) && isset($_POST['Enroll']) && isset($_POST['Email']) && isset($_POST['Password'])){
            $Name = htmlentities($_POST['Name']);
            $Enroll = htmlentities($_POST['Enroll']);
            $Pass = md5(htmlentities($_POST['Password']));
            $Email = htmlentities($_POST['Email']);
        }
        else{
                    echo '<script language="javascript">alert("Try Again!")</script>';
                    header("Refresh: 1; url=usersignup.php");
                }

      
        

        try {
            
        
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $connection->prepare('SELECT * FROM users WHERE Email = :email');
            $stmt->execute(['email' => $Email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if($user != Null){
                echo '<script language="javascript"> alert("Email Already Exists") </script>' ;   
                header("Refresh: 1; url=usersignup.php"); 
            }

            else{
                $sql = $connection->prepare("INSERT INTO users (Name,Enroll,Email,Password) VALUES (:name,:enroll,:email,:pass)");
                $cmd = $sql->execute(['name' => $Name , 'enroll' => $Enroll, 'email' => $Email,'pass' => $Pass]);

                if($cmd){
                      echo '<script language="javascript"> alert("Succesfully Registered , You can login now") </script>' ; 
                    header("Refresh: 1; url=index.php"); 
                }
                  
                else{
                    echo '<script language="javascript"> alert("Try Again !") </script>' ;     
                    header("Refresh: 1; url=usersignup.php");
                }
                
            }

        }
        
        catch(PDOException $e){
                echo '<script language="javascript">';
                echo '$sql . "<br>" . $e->getMessage();';
                echo '</script>';   
                header("Refresh: 1; url=usersignup.php");
            }

        $connection = null;
    }

?>