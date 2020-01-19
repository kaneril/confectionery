<?php
ini_set('session.gc_maxlifetime', 60*60*24);
 session_start();
 
 if($_POST['submit']){

   require_once 'login.php';
   $conn=new mysqli($hn, $un, $pw, $db);

   if($conn->connect_error) die ("Fatal Error");
   $login=mysql_entites_fix_string($conn, $_POST['login']);
   $password=mysql_entites_fix_string($conn, $_POST['password']);

   $query="SELECT * FROM managers WHERE login = '$login' AND password = '$password'";
   $result=$conn->query($query);
    
   if(!$result) die ("Сбой при доступе к базе данных");

   if($result->num_rows >0){
      $_SESSION['logged_user'] = $login;
      $row=$result->fetch_array(MYSQLI_ASSOC);
      $result->close();

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

function mysql_entites_fix_string($conn, $string){
   return htmlentities(mysql_fix_string($conn, $string));
}
function mysql_fix_string($conn, $string){
   if(get_magic_quotes_gpc()) $string = stripcslashes($string);
   return $conn->real_escape_string($string);
}
 ?>
 
