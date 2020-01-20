<?php
    function mysql_entites_fix_string($conn, $string){
    return htmlentities(mysql_fix_string($conn, $string));
    }
    function mysql_fix_string($conn, $string){
    if(get_magic_quotes_gpc()) $string = stripcslashes($string);
    return $conn->real_escape_string($string);
    }
    function get_post($conn, $var){
        return $conn->real_escape_string($_POST[$var]);
    }  

    function add_log($conn, $str, $id){
        $stmt=$conn->prepare('INSERT INTO log_list (`session_id`, `action_type`, `elem_id`) VALUES(?,?,?)');
        $stmt->bind_param('isi',$session_id,$status,$elem_id);
        
            
        $session_id=$_SESSION['session_id'];
        $status=$str;
        $elem_id=$id;

        $stmt->execute();
        $stmt->close();       
        
    }

    function mysql_change_pass($conn){
        if (isset($_POST['db_change_pass'])){
    
            $login=$_SESSION['logged_user'];
            $old_pass=get_post($conn, 'old_pass');
            $new_pass1=get_post($conn, 'new_pass1');
            $new_pass2=get_post($conn, 'new_pass2');
            
            $query="SELECT `password` FROM managers WHERE `login`='$login'";
            $result=$conn->query($query);         
            if(!$result) die ("Сбой при доступе к базе данных");
            $password=$result->fetch_array(MYSQLI_ASSOC)['password'];
            $result->close();
            
            if(!password_verify($old_pass, $password)){
                
                return 'Был введен неправильный старый пароль!';
            }
           
    
            if($new_pass1 != $new_pass2){
                return 'Новые пароли не совпадают';
            }
    
            $stmt=$conn->prepare("UPDATE managers SET  `password`=? WHERE `login`=? AND `password`=?");
            $stmt->bind_param('sss',$new_pass,$log,$old_password);
            
            $new_pass=password_hash($new_pass1, PASSWORD_DEFAULT);
            
            $log=$login;
            $old_password=$password;  
            
            $flag=$stmt->execute();
            $stmt->close(); 
            if ($flag===0){
                return 'Ошибка смены пароля!';
            } else{
                add_log($conn, 'change_password', $_SESSION['session_id']);
                return 'Пароль был успешно сменен!';
            }
            
            
        }    
        
        
        
    }
?>