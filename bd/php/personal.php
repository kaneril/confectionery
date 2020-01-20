<?php
  session_start();
  $role='supermanager';
  if(!((isset($_SESSION['logged_user'])) &&
  ($_SESSION['role']==$role)
  )){
    header("Location: ../html/Main.html");
    exit;
  }
  $name=$_SESSION['logged_user'];

  require_once 'login_supermanager.php';
  require_once 'useful.php';

  $conn=new mysqli($hn, $un, $pw, $db);

  if($conn->connect_error) die ("Fatal Error");

  if ((isset($_POST['view_managers'])) &&
  (isset($_POST['role_status'])) 
  ){
    $role_list=[
        'supermanager'=>'Суперменеджеры',
        'manager'=>'Менеджеры',        
        'anouther'=>'Технические',
        'all'=>'Все',
    ];  
    
      
  $role_status=$role_list[get_post($conn, 'role_status')]; 
  
  }
  else{
    $role_status='-- Роль менеджера --'; 
    
  }

  echo<<<_END
  <!DOCTYPE HTML>
<html>
	<head>
		<title>Для менеджера</title>
		<meta charset = "utf-8">
		<link rel = "stylesheet" type = "text/css" href = "../css/for_manager.css">
	</head>
	
	<body>
	<div class="forma_for_manager">
	<div class="session">
		<ul class="filters">
			<li><a href="supermanager.php">Заказы</a></li>
			<li><a href="products_sm.php">Продукция</a></li>
            <li><a href="personal.php">Персонал</a></li>
            <li><a href="logs.php">Логи</a></li>
		</ul>
		
		<div class="user">
			<h3>Супер менеджер $name</h3>
		</div>
        
        <form class="order_number" action="personal.php" method="post">
			<h3>
				<input type="submit" class="show_order1" align="right" value="Сменить пароль">
			</h3>	
			<input type="hidden" name="change_password" value='yes'>				
        </form>
		<div class="sign_out">
			<a class="exit" href="Close.php">
			<h3 align="center">Выход</h3>
			</a>
		</div>
	</div>
	
	<div class="orders">
		<form class="order_number" action="personal.php" method="post">
            <h1> &nbspID менеджера <input type="number" name="manager_id"/></h1>
            <div class="form_button">
				<input type="submit" class="show_order" value="Найти менеджера">
			</div>	
			<input type="hidden" name="view_manager" value='yes'>				
        </form>
        <form class="order_number" action="personal.php" method="post">
        <h1> &nbspID менеджера <input type="number" name="manager_id" /></h1>
			<div class="form_button">
				<input type="submit" class="show_order" value="Удалить менеджера">
			</div>	
			<input type="hidden" name="del_manager" value='yes'>				
		</form>
        <form class="order_number" action="personal.php" method="post">
			
			<div class="form_button">
				<input type="submit" class="show_order" value="Добавить менеджера">
			</div>	
			<input type="hidden" name="add_manager" value='yes'>				
        </form>
        
		<form class="filters" action="personal.php" method="post">
        <h1> &nbspПросмотреть список менеджеров </h1>    
        <select name="role_status">
				<option value="hide" selected disabled hidden>$role_status</option>
				<option value="supermanager">Суперменеджеры</option>
                <option value="manager">Менеджеры</option>
                <option value="anouther">Технические</option>
				<option value="all">Все</option>
				
			</select> 					
			
			<div class="form_button">
				<input type="submit" class="show_order" value="Применить">
			</div>
			<input type="hidden" name="view_managers" value='yes'>
		</form>			
		
  
_END;


if ((isset($_POST['view_manager'])) &&
($_POST['manager_id'] != '')
){
   $manager_info=find_manager($conn, get_post($conn, 'manager_id'));
	if (htmlspecialchars($manager_info["id"])==-1){
		echo<<<_END
		<div id="fade" class="black-overlay"></div>
		<div class="order">
			<a  href="personal.php"><img class="close-button" src="../images/icons/cross.png" onclick = "document.getElementById('order').style.display='none';document.getElementById('fade').style.display='none'"></a>
			<h2>Менеджер с таким ID не найден!</h2>
		</div>
_END;		
	}
	else{
        $role_list=[
            'supermanager'=>'Суперменеджер',
            'manager'=>'Менеджер',        
            'anouther'=>'Технический',        
        ];
		$id=htmlspecialchars($manager_info["id"]);
		$login=htmlspecialchars($manager_info['login']);
        $password=htmlspecialchars($manager_info['password']);
        $p_role_status=$role_list[htmlspecialchars($manager_info['role'])];
        
        echo<<<_END
<div id="fade" class="black-overlay"></div>
    <form action="personal.php"  method="post" id="order_list" class="order">
        <img class="close-btn" src="../images/icons/cross.png" onclick = "document.getElementById('order_list').style.display='none';document.getElementById('fade').style.display='none'">
        
        <div class="text">
            <h1 align=center>
            <h1 align="center">ID - $id <br><br>
            Логин: <input name="login" value="$login"><br><br>
            Пароль: <input name="password" value="password"><br><br>
            Роль:            
            <select align="center" name="role_status">
            <option value="hide" selected disabled hidden>$p_role_status</option>
                <option value="supermanager">Суперменеджер</option>
                <option value="manager">Менеджер</option>
                <option value="anouther">Технический</option>
            </select> <br></h1> 
            <input type="hidden" name="actual_role_status" value="$p_role_status">
            
            <div class="form_button">
                    <input type="submit" class="show_order" value="Внести изменения">
            </div>
            <input type="hidden" name="change_manager" value="$id">
            
        </div>                       
    </div>
        

</form>
_END;
        
        
        
	}
	
	

}

if ((isset($_POST['view_managers'])) &&
  (isset($_POST['role_status'])) 
  ){
    
    $role_status=get_post($conn, 'role_status'); 
    $managers=find_managers($conn, $role_status);
    $role_list=[
        'supermanager'=>'Суперменеджер',
        'manager'=>'Менеджер',        
        'anouther'=>'Технический',        
    ];
    $rows=count($managers);
    if ($rows==0){
        echo<<<_END
        <div class="order_list">
        <h3>Список менеджеров пуст</h3>
        </div>
    _END;
    }
    else{
        echo<<<_END
        <div class="order_list">
        <h3>Список менеджеров</h3>
                        <div class="table">
                            <table class="table_order_list">
                                <tr><th>№</th><th>ID менеджера</th><th>Логин</th><th>Роль</th></tr>
_END;
    for ($j = 0; $j<$rows; ++$j){
        $number=$j+1;
        $id=htmlspecialchars($managers[$j]['id']);
        $login=htmlspecialchars($managers[$j]['login']);
        $password=htmlspecialchars($managers[$j]['password']);
        $p_role_status=$role_list[htmlspecialchars($managers[$j]['role'])];
                
        echo <<<_END
        <tr>
        <td>$number&nbsp</td>
        <td><form action="personal.php" method="post">
        <input type="hidden" name="manager_id" value="$id"/>
        <input type="submit"  value="$id">
        <input type="hidden" name="view_manager" value='yes'>				
    </form>&nbsp</td>
        <td>$login&nbsp</td>
        <td>$p_role_status&nbsp</td>
        
        </tr>
_END;
        
} 
echo<<<_END
</table>
</div>
</div>        
        

_END;


}
        

}

if (isset($_POST['change_manager'])){
    
    $flag=mysql_change_manager($conn); 
    if ($flag===0){
        echo<<<_END
		<div id="fade" class="black-overlay"></div>
		<div class="order">
			<a  href="personal.php"><img class="close-button" src="../images/icons/cross.png" onclick = "document.getElementById('order').style.display='none';document.getElementById('fade').style.display='none'"></a>
			<h2>Извините, что-то пошло не так!</h2>
		</div>
_END;
    }else{
        echo<<<_END
		<div id="fade" class="black-overlay"></div>
		<div class="order">
			<a  href="personal.php"><img class="close-button" src="../images/icons/cross.png" onclick = "document.getElementById('order').style.display='none';document.getElementById('fade').style.display='none'"></a>
			<h2>Изменения сохранены!</h2>
		</div>
_END;
}	
}

if (isset($_POST['add_manager'])){
         
   echo<<<_END
<div id="fade" class="black-overlay"></div>
    <form action="personal.php"  method="post" id="order_list" class="order">
        <img class="close-btn" src="../images/icons/cross.png" onclick = "document.getElementById('order_list').style.display='none';document.getElementById('fade').style.display='none'">
        
        <div class="text">
            <h1 align=center>
            Логин: <input name="login" required /><br><br>
            Пароль: <input name="password" required ><br><br>
            Роль:            
            <select align="center" required name="role_status">
                <option value="supermanager">Суперменеджер</option>
                <option value="manager" selected>Менеджер</option>
                <option value="anouther">Технический</option>
            </select> <br></h1> 
            
            
            <div class="form_button">
                    <input type="submit" class="show_order" value="Добавить менеджера">
            </div>
            <input type="hidden" name="db_add_manager" value="yes">
            
        </div>                       
    </div>
        

</form>
_END;
    
}

if (isset($_POST['db_add_manager'])){
    $flag=mysql_add_manager($conn); 
    if ($flag===0){
        echo<<<_END
		<div id="fade" class="black-overlay"></div>
		<div class="order">
			<a  href="personal.php"><img class="close-button" src="../images/icons/cross.png" onclick = "document.getElementById('order').style.display='none';document.getElementById('fade').style.display='none'"></a>
			<h2>Извините, что-то пошло не так!</h2>
		</div>
_END;
    }else{
        echo<<<_END
		<div id="fade" class="black-overlay"></div>
		<div class="order">
			<a  href="personal.php"><img class="close-button" src="../images/icons/cross.png" onclick = "document.getElementById('order').style.display='none';document.getElementById('fade').style.display='none'"></a>
			<h2>Менеджер добавлен!</h2>
		</div>
_END;
}	
}

if ((isset($_POST['del_manager'])) &&
($_POST['manager_id'] != '')
){
   $id=del_manager($conn, get_post($conn, 'manager_id'));
	if (htmlspecialchars($id)==-1){
		echo<<<_END
		<div id="fade" class="black-overlay"></div>
		<div class="order">
			<a  href="personal.php"><img class="close-button" src="../images/icons/cross.png" onclick = "document.getElementById('order').style.display='none';document.getElementById('fade').style.display='none'"></a>
			<h2>Менеджер с таким ID не найден!</h2>
		</div>
_END;		
	}
	else{
        echo<<<_END
		<div id="fade" class="black-overlay"></div>
		<div class="order">
			<a  href="personal.php"><img class="close-button" src="../images/icons/cross.png" onclick = "document.getElementById('order').style.display='none';document.getElementById('fade').style.display='none'"></a>
			<h2>Менеджер с ID - $id успешно удален!</h2>
		</div>
_END;		
	}
	
	

}

if (isset($_POST['change_password'])){
         
    echo<<<_END
 <div id="fade" class="black-overlay"></div>
     <form action="personal.php"  method="post" id="order_list" class="order">
         <img class="close-btn" src="../images/icons/cross.png" onclick = "document.getElementById('order_list').style.display='none';document.getElementById('fade').style.display='none'">
         
         <div class="text">
             <h1 align=center>
             Старый пароль: <input type="password" name="old_pass" required><br><br>
             Новый пароль: <input type="password" name="new_pass1" required><br><br>
             Повторите новый пароль: <input type="password" name="new_pass2" required><br><br>
             </h1> 
             
             
             <div class="form_button">
                     <input type="submit" class="show_order" value="Сменить пароль">
             </div>
             <input type="hidden" name="db_change_pass" value="yes">
             
         </div>                       
     </div>
         
 
 </form>
 _END;
     
 }
 

 if (isset($_POST['db_change_pass'])){
    $str=mysql_change_pass($conn); 
    echo<<<_END
		<div id="fade" class="black-overlay"></div>
		<div class="order">
			<a  href="personal.php"><img class="close-button" src="../images/icons/cross.png" onclick = "document.getElementById('order').style.display='none';document.getElementById('fade').style.display='none'"></a>
			<h2>$str</h2>
		</div>
_END;
    
}


echo<<<_END

</div>	
</div>
</body>
</html>     
_END;	


$conn->close(); 

function mysql_add_manager($conn){
    if (isset($_POST['db_add_manager'])){

        
        $stmt=$conn->prepare('INSERT INTO managers (`login`, `password`, `role`) VALUES(?,?,?)');
        $stmt->bind_param('sss',$login,$password,$role);
        
          
        $login=get_post($conn, 'login');
        $password=password_hash(get_post($conn, 'password'), PASSWORD_DEFAULT);
        
        $role=get_post($conn,'role_status');
                
        
        $flag=$stmt->execute();
        $stmt->close(); 

        $query="SELECT id from managers
	ORDER BY id DESC LIMIT 1";
	$result=$conn->query($query);        
	if(!$result) die ("Сбой при доступе к базе данных");
    $id=$result->fetch_array(MYSQLI_NUM)[0];
    $result->close();
    
        add_log($conn, 'add_manager', $id); 
        return $flag;
        
    }    
    
    
    
}



function mysql_change_manager($conn){
    if (isset($_POST['change_manager'])){
           
        $pass=get_post($conn, 'password');
        if ($pass=='password'){
            $stmt=$conn->prepare('UPDATE managers SET `login`=?, `role`=?  WHERE `id`=?');
            $stmt->bind_param('ssi',$login,$role,$id);
        }else{
            $stmt=$conn->prepare('UPDATE managers SET `login`=?, `password`=?, `role`=?  WHERE `id`=?');
            $stmt->bind_param('sssi',$login,$password,$role,$id);
            $password=password_hash($pass, PASSWORD_DEFAULT);
        }        
        
        $id=get_post($conn,'change_manager');
        
        $login=get_post($conn, 'login');
        
        
        if (isset($_POST['role_status'])){
            $role=get_post($conn,'role_status');
        } else{
            $role_list=[
                'Менеджер'=>'manager',
                'Суперменеджер'=>'supermanager',
                'Технический'=>'anouther',
                
            ];
            $role=$role_list[get_post($conn,'actual_role_status')];
        }
    
        $flag=$stmt->execute();
        $stmt->close();  
        add_log($conn, 'change_manager', $id);
        
        
    }    
    return $flag;
    
}


function find_manager($conn, $id){
	$query="SELECT * from managers
	WHERE id=$id";
	$result=$conn->query($query);        
	if(!$result) die ("Сбой при доступе к базе данных");
	if ($result->num_rows==0){
		$manager_info=[
			"id"=>-1,
        ];
        $result->close();
		return $manager_info;
	}
	else{
		$manager_info = $result->fetch_array(MYSQLI_ASSOC);
        $result->close();
	
		return $manager_info;
	}
}

function del_manager($conn, $id){
	$query="SELECT * from managers
	WHERE id=$id";
	$result=$conn->query($query);        
	if(!$result) die ("Сбой при доступе к базе данных");
	if ($result->num_rows==0){
        $result->close();
		return -1;
	}
	else{
		$query="DELETE from managers
	WHERE id=$id";
	$result=$conn->query($query);        
	if(!$result) die ("Сбой при доступе к базе данных");
    //$result->close(); 
    add_log($conn, 'delete_manager', $id);  
    return $id;
	}
}
 

function find_managers($conn, $role_status){
    if ($role_status=='all'){
        $role_status='%';
    }   

    $query="select * from managers
        WHERE role LIKE '$role_status'
        ORDER BY id";
	$result=$conn->query($query);        
    if(!$result) die ("Сбой при доступе к базе данных");
    $rows=$result->num_rows; 
    $managers=[];     
	if ($rows==0){
        $result->close();
		return $managers;
	}
	else{        
        for ($j = 0; $j<$rows; ++$j){
            $managers[$j]= $result->fetch_array(MYSQLI_ASSOC); 
        }
        $result->close();
        return $managers;
	}
}




  
?>
 
	