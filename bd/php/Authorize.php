<?php
ini_set('session.gc_maxlifetime', 60*60*24);
session_start();
 
 if($_POST['submit']){

   require_once 'login.php';
   require_once 'useful.php';

   $conn=new mysqli($hn, $un, $pw, $db);

   if($conn->connect_error) die ("Fatal Error");
   $login=mysql_entites_fix_string($conn, $_POST['login']);
   $password=mysql_entites_fix_string($conn, $_POST['password']);

   $query="SELECT * FROM managers WHERE login = '$login'";
   $result=$conn->query($query);
    
   if(!$result) die ("Сбой при доступе к базе данных");   
   $row=$result->fetch_array(MYSQLI_ASSOC);
   $result->close();
   if ( 
   (password_verify($password, $row['password']))
   ){
      $_SESSION['logged_user'] = $login;
      

      $role=htmlspecialchars($row['role']);
      $id=htmlspecialchars($row['id']);
      $_SESSION['session_id']=open_session($conn,$id);
      $_SESSION['role'] = $role;
      

      if ($role==='supermanager'){
         header("Location: supermanager.php");
      }
      else{
         header("Location: manager.php");
      }      
      exit;
   }
   }
   echo<<<_END
    <html>
    <head>
       <title>Сладкое королевство</title>
       <meta charset = "utf-8">
       <link rel = "stylesheet" type = "text/css" href = "../css/auth_error.css">
    </head>
    
    <body>
       <div class="auth_error">
          <a  href="../html/Main.html"><img class="close-button" src="../images/icons/cross.png"></a>
          <h2>Ошибка авторизации!</h2>
       </div>
       
    </body>  
    </html>       
_END;


function open_session($conn, $id){
   $stmt=$conn->prepare('INSERT INTO `sessions` (`manager_id`) VALUES(?)');
   $stmt->bind_param('i',$manager_id); 

   $manager_id=$id;

   $stmt->execute();
   $stmt->close(); 
      
   $query="SELECT id FROM `sessions` WHERE manager_id=$id ORDER BY begin_date DESC LIMIT 1";
        $result=$conn->query($query);        
        if(!$result) die ("Сбой при доступе к базе данных");
        $id=$result->fetch_array(MYSQLI_NUM)[0];
        $result->close();


   return $id;     
    
}


 ?>
 
