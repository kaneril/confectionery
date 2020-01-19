<?php
    session_start();
    $user='';
    if(isset($_SESSION['logged_user'])){
        
        close_session($_SESSION['session_id']);
        $user=$_SESSION['logged_user'];  
        unset($_SESSION['logged_user']); 
        session_destroy(); 
        header("Location: ../html/Main.html");              
    }

    function close_session($id){
        require_once 'login.php';
        $conn=new mysqli($hn, $un, $pw, $db);

        if($conn->connect_error) die ("Fatal Error");
        
        $stmt=$conn->prepare('UPDATE `sessions` SET `end_date`= current_timestamp() WHERE `id`=?');
        $stmt->bind_param('i',$session_id); 
     
        $session_id=$id;
     
        $stmt->execute();
        $stmt->close();            
        
        return $id;     
         
     }

?>
 