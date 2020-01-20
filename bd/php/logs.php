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
  $conn=new mysqli($hn, $un, $pw, $db);

  if($conn->connect_error) die ("Fatal Error");

  if ((isset($_POST['view_sessions'])) &&
  (isset($_POST['role_status'])) &&
  (isset($_POST['order_by_s'])) &&
  (isset($_POST['session_status']))&&
  (isset($_POST['start_date_s']))&&
  (isset($_POST['end_date_s']))
  ){
    $role_list=[
        'supermanager'=>'Суперменеджеры',
        'manager'=>'Менеджеры',        
        'anouther'=>'Технические',
        'all'=>'Все',
    ];  
    $order_list=[
        'asc'=>'Сначала старые',
        'desc'=>'Сначала новые',
    ];
    $session_list=[
        'active'=>'Активные',
        'completed'=>'Завершенные',        
        'all'=>'Все',
    ];  
      
  $role_status=$role_list[get_post($conn, 'role_status')]; 
  $order_by_s=$order_list[get_post($conn, 'order_by_s')];
  $session_status=$session_list[get_post($conn, 'session_status')];
  $start_date_s=get_post($conn, 'start_date_s');
  $end_date_s=get_post($conn, 'end_date_s');
  }
  else{
    $role_status='-- Роль менеджера --'; 
    $order_by_s='-- Сортировка --'; 
    $session_status='-- Статус сессии --'; 
    $start_date_s='';
    $end_date_s='';
  }

  if ((isset($_POST['view_logs'])) &&
  (isset($_POST['manager_id'])) &&
  (isset($_POST['order_by_l'])) &&
  (isset($_POST['action_type']))&&
  (isset($_POST['start_date_l']))&&
  (isset($_POST['end_date_l']))
  ){
    
    $order_list=[
        'asc'=>'Сначала старые',
        'desc'=>'Сначала новые',
    ];
    $action_list=[
        'add_product'=>'Добавление продукта',
        'change_product'=>'Изменение продукта', 
        'delete_product'=>'Удаление продукта',     
        'add_manager'=>'Добавление менеджера',
        'change_manager'=>'Изменение менеджера', 
        'delete_manager'=>'Удаление менеджера',     
        'add_order'=>'Добавление заказа',
        'change_order'=>'Изменение заказа', 
        'delete_order'=>'Удаление заказа',   
        'change_password'=>'Изменение пароля',     
        'all'=>'Все',
    ];  
      
  $manager_id=get_post($conn, 'manager_id'); 
  $order_by_l=$order_list[get_post($conn, 'order_by_l')];
  $action_type=$action_list[get_post($conn, 'action_type')];
  $start_date_l=get_post($conn, 'start_date_l');
  $end_date_l=get_post($conn, 'end_date_l');
  }
  else{
    $manager_id='0'; 
    $order_by_l='-- Сортировка --'; 
    $action_type='-- Тип действия --'; 
    $start_date_l='';
    $end_date_l='';
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
		<form class="order_number" action="logs.php" method="post">
            <h1> &nbspID сессии <input name="session_id"/></h1>
            <div class="form_button">
				<input type="submit" class="show_order" value="Найти сессию">
			</div>	
			<input type="hidden" name="view_session" value='yes'>				
        </form>
        
		<form class="filters" action="logs.php" method="post">
            <h1> &nbspПросмотреть список сессий </h1> 
            
            <select name="session_status">
				<option value="hide" selected disabled hidden>$session_status</option>
				<option value="active">Активные</option>
                <option value="completed">Завершенные</option>                
				<option value="all">Все</option>				
			</select> 
            <select name="order_by_s">
				<option value="hide" selected disabled hidden>$order_by_s</option>
				<option value="asc">Сначала старые</option>
				<option value="desc">Сначала новые</option>
            </select>
            
            <h1> &nbspВременной интервал <input type="date" name="start_date_s" value="$start_date_s" ><input type="date" name="end_date_s" value="$end_date_s"></h1>

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
			<input type="hidden" name="view_sessions" value='yes'>
		</form>			
        
        <form class="filters" action="logs.php" method="post">
            <h1> &nbspПросмотреть список логов </h1> 
            <select name="action_type">
				<option value="hide" selected disabled hidden>$action_type</option>
				<option value="add_product">Добавление продукта</option>
                <option value="change_product">Изменение продукта</option>
                <option value="delete_product">Удаление продукта</option>
                <option value="add_manager">Добавление менеджера</option>
                <option value="change_manager">Изменение менеджера</option>
                <option value="delete_manager">Удаление менеджера</option>
                <option value="add_order">Добавление заказа</option>
                <option value="change_order">Изменение заказа</option>
                <option value="delete_order">Удаление заказа</option>
                <option value="change_password">Изменение пароля</option>
				<option value="all">Все</option>
				
			</select> 	
            <h1> &nbspID менеджера (0-любой) <input type="number" value=$manager_id name="manager_id" /></h1>
            <h1> &nbspВременной интервал <input type="date" name="start_date_l" value="$start_date_l"><input type="date" name="end_date_l" value="$end_date_l"></h1>

            <select name="order_by_l">
				<option value="hide" selected disabled hidden>$order_by_l</option>
				<option value="asc">Сначала старые</option>
				<option value="desc">Сначала новые</option>
            </select>     
			
			<div class="form_button">
				<input type="submit" class="show_order" value="Применить">
			</div>
			<input type="hidden" name="view_logs" value='yes'>
		</form>			
  
_END;


if ((isset($_POST['view_session'])) &&
($_POST['session_id'] != '')
){
   $session_info=find_session($conn, get_post($conn, 'session_id'));
	if (htmlspecialchars($session_info["id"])==-1){
		echo<<<_END
		<div id="fade" class="black-overlay"></div>
		<div class="order">
			<a  href="logs.php"><img class="close-button" src="../images/icons/cross.png" onclick = "document.getElementById('order').style.display='none';document.getElementById('fade').style.display='none'"></a>
			<h2>Сессия с таким ID не найдена!</h2>
		</div>
_END;		
	}
	else{
        $role_list=[
            'supermanager'=>'Суперменеджер',
            'manager'=>'Менеджер',        
            'anouther'=>'Технический',        
        ];
        $action_list=[
            'add_product'=>'Добавление продукта',
            'change_product'=>'Изменение продукта', 
            'delete_product'=>'Удаление продукта',     
            'add_manager'=>'Добавление менеджера',
            'change_manager'=>'Изменение менеджера', 
            'delete_manager'=>'Удаление менеджера',     
            'add_order'=>'Добавление заказа',
            'change_order'=>'Изменение заказа', 
            'delete_order'=>'Удаление заказа',   
            'change_password'=>'Изменение пароля',     
            
        ];  
		$id=htmlspecialchars($session_info["id"]);
		$login=htmlspecialchars($session_info['login']);
        $role_status=$role_list[htmlspecialchars($session_info['role'])];
        $start_date=htmlspecialchars($session_info['begin_date']);
        $end_date=htmlspecialchars($session_info['end_date']);
        echo<<<_END
<div id="fade" class="black-overlay"></div>
    <form action="logs.php"  method="post" id="order_list" class="order">
        <img class="close-btn" src="../images/icons/cross.png" onclick = "document.getElementById('order_list').style.display='none';document.getElementById('fade').style.display='none'">
        
        <div class="info">
				<h3>    ID сессии: $id<br>
                    Логин менеджера: $login<br>
                    Роль менеджера: $role_status<br>
				    Начало сессии: $start_date<br>
				    Конец сессии: $end_date<br>
				</h3>
			</div>
			<div class="spisok_tovarov">
				<h7 class="list_products">Список логов</h7>
                <div class="table">
                    <table class="table_order_list">
                        <tr><th>№</th><th>Тип действия</th><th>ID элемента</th><th>Дата</th></tr>
_END;

$log_list=find_log_list($conn, $id);
$rows=count($log_list); 

for ($j = 0; $j<$rows; ++$j){
    $number=$j+1;
    $l_l_id=htmlspecialchars($log_list[$j]['id']);
    $action_type=$action_list[htmlspecialchars($log_list[$j]['action_type'])];
    $l_l_elem_id=htmlspecialchars($log_list[$j]['elem_id']);
    $created_date=htmlspecialchars($log_list[$j]['created_date']);
    
    echo<<<_END
    <tr>
    <td>$number&nbsp</td>
    <td>$action_type&nbsp</td>
    <td>$l_l_elem_id&nbsp</td>
    <td>$created_date&nbsp</tr>
_END;
    
} 
echo<<<_END
</table>
</div>
</div>
</form>
_END;      
        
	}
	
	

}

if ((isset($_POST['view_sessions'])) &&
(isset($_POST['role_status'])) &&
(isset($_POST['order_by_s'])) &&
(isset($_POST['session_status']))&&
(isset($_POST['start_date_s']))&&
(isset($_POST['end_date_s']))
  ){    
    $role_list=[
        'supermanager'=>'Суперменеджер',
        'manager'=>'Менеджер',        
        'anouther'=>'Технический',
        
    ];  
    
    $session_list=[
        'active'=>'Активная',
        'completed'=>'Завершенная', 
    ];  
      
    $role_status=get_post($conn, 'role_status'); 
    $order_by_s=get_post($conn, 'order_by_s');
    $session_status=get_post($conn, 'session_status');
    $start_date_s=get_post($conn, 'start_date_s');
    $end_date_s=get_post($conn, 'end_date_s');

    
    $sessions=find_sessions($conn, $role_status, $order_by_s, $session_status, $start_date_s, $end_date_s);
    
    $rows=count($sessions);
    if ($rows==0){
        echo<<<_END
        <div class="order_list">
        <h3>Список сессий пуст</h3>
        </div>
    _END;
    }
    else{
        echo<<<_END
        <div class="order_list">
        <h3>Список сессий</h3>
                        <div class="table">
                            <table class="table_order_list">
                                <tr><th>№</th><th>ID сессии</th><th>Логин менеджера</th><th>Роль</th><th>Статус сессии</th><th>Кол-во действий</th><th>Дата начала</th><th>Дата окончания</th></tr>
_END;
    for ($j = 0; $j<$rows; ++$j){
        $number=$j+1;
        $id=htmlspecialchars($sessions[$j]['id']);
        $login=htmlspecialchars($sessions[$j]['login']);
        $status=$session_list[htmlspecialchars($sessions[$j]['session_status'])];
        $p_role_status=$role_list[htmlspecialchars($sessions[$j]['role'])];
        $count_log=htmlspecialchars($sessions[$j]['count_log']);
        if ($count_log==''){
            $count_log=0;
        }
        $start_date=htmlspecialchars($sessions[$j]['begin_date']);
        $end_date=htmlspecialchars($sessions[$j]['end_date']);        
        echo <<<_END
        <tr>
        <td>$number&nbsp</td>
        <td><form action="logs.php" method="post">
        <input type="hidden" name="session_id" value="$id"/>
        <input type="submit"  value="$id">
        <input type="hidden" name="view_session" value='yes'>				
    </form>&nbsp</td>
        <td>$login&nbsp</td>       
        <td>$p_role_status&nbsp</td>
        <td>$status&nbsp</td>
        <td>$count_log&nbsp</td>
        <td>$start_date&nbsp</td>
        <td>$end_date&nbsp</td>
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

if ((isset($_POST['view_logs'])) &&
  (isset($_POST['manager_id'])) &&
  (isset($_POST['order_by_l'])) &&
  (isset($_POST['action_type']))&&
  (isset($_POST['start_date_l']))&&
  (isset($_POST['end_date_l']))
  ){
    
    $action_list=[
        'add_product'=>'Добавление продукта',
        'change_product'=>'Изменение продукта', 
        'delete_product'=>'Удаление продукта',     
        'add_manager'=>'Добавление менеджера',
        'change_manager'=>'Изменение менеджера', 
        'delete_manager'=>'Удаление менеджера',     
        'add_order'=>'Добавление заказа',
        'change_order'=>'Изменение заказа', 
        'delete_order'=>'Удаление заказа',   
        'change_password'=>'Изменение пароля',     
        
    ];  
      
    $manager_id=get_post($conn, 'manager_id'); 
    $order_by_l=get_post($conn, 'order_by_l');
    $action_type=get_post($conn, 'action_type');
    $start_date_l=get_post($conn, 'start_date_l');
    $end_date_l=get_post($conn, 'end_date_l');
  
    
    $logs=find_logs($conn, $manager_id, $order_by_l, $action_type, $start_date_l, $end_date_l);
    
    $rows=count($logs);
    if ($rows==0){
        echo<<<_END
        <div class="order_list">
        <h3>Список логов пуст</h3>
        </div>
    _END;
    }
    else{
        echo<<<_END
        <div class="order_list">
        <h3>Список логов</h3>
                        <div class="table">
                            <table class="table_order_list">
                            <tr><th>№</th><th>Тип действия</th><th>ID элемента</th><th>Дата</th><th>ID сессии</th><th>Логин менеджера</th></tr>
_END;
    for ($j = 0; $j<$rows; ++$j){
        $number=$j+1;
        $session_id=htmlspecialchars($logs[$j]['session_id']);
        $action_type=$action_list[htmlspecialchars($logs[$j]['action_type'])];
        $l_l_elem_id=htmlspecialchars($logs[$j]['elem_id']);
        $created_date=htmlspecialchars($logs[$j]['created_date']);
        $login=htmlspecialchars($logs[$j]['login']);
        
        echo<<<_END
        <tr>
        <td>$number&nbsp</td>
        <td>$action_type&nbsp</td>
        <td>$l_l_elem_id&nbsp</td>
        <td>$created_date&nbsp</td>
        <td>$session_id&nbsp</td>        
        <td>$login&nbsp</tr>
_END;
        
} 
echo<<<_END
</table>
</div>
</div>        
        

_END;


}
        

}





if (isset($_POST['change_password'])){
         
    echo<<<_END
 <div id="fade" class="black-overlay"></div>
     <form action="logs.php"  method="post" id="order_list" class="order">
         <img class="close-btn" src="../images/icons/cross.png" onclick = "document.getElementById('order_list').style.display='none';document.getElementById('fade').style.display='none'">
         
         <div class="text">
             <h1 align=center>
             Старый пароль: <input type="password" name="old_pass" required /><br><br>
             Новый пароль: <input type="password" name="new_pass1" required /><br><br>
             Повторите новый пароль: <input type="password" name="new_pass2" required /><br><br>
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
			<a  href="logs.php"><img class="close-button" src="../images/icons/cross.png" onclick = "document.getElementById('order').style.display='none';document.getElementById('fade').style.display='none'"></a>
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


function mysql_change_pass($conn){
    if (isset($_POST['db_change_pass'])){

        $login=$_SESSION['logged_user'];
        $old_pass=get_post($conn, 'old_pass');
        $new_pass1=get_post($conn, 'new_pass1');
        $new_pass2=get_post($conn, 'new_pass2');
        
        $query="SELECT * FROM managers WHERE `login`='$login' AND `password`='$old_pass'";
        $result=$conn->query($query);         
        if(!$result) die ("Сбой при доступе к базе данных");
        
        if($result->num_rows ==0){
            $result->close();
            return 'Был введен неправильный старый пароль!';
        }

        $result->close();

        if($new_pass1 != $new_pass2){
            return 'Новые пароли не совпадают';
        }

        $stmt=$conn->prepare("UPDATE managers SET `password`=? WHERE `login`=? AND `password`=?");
        $stmt->bind_param('sss',$new_pass,$log,$old_password);
        
        $new_pass=$new_pass1;
        $log=$login;
        $old_password=$old_pass;  
        
        $flag=$stmt->execute();
        $stmt->close(); 
        if ($flag===0){
            return 'Ошибка смены пароля!';
        } else{
            return 'Пароль был успешно сменен!';
        }
        
        
    }    
    
    
    
}



function find_session($conn, $id){
	$query="SELECT s.id, m.login, m.role, s.begin_date, s.end_date FROM `sessions` as s
    JOIN `managers` as m on s.manager_id=m.id
    WHERE s.id=$id";
	$result=$conn->query($query);        
	if(!$result) die ("Сбой при доступе к базе данных");
	if ($result->num_rows==0){
		$session_info=[
			"id"=>-1,
        ];
        $result->close();
		return $session_info;
	}
	else{
		$session_info = $result->fetch_array(MYSQLI_ASSOC);
        $result->close();
	
		return $session_info;
	}
}

function find_log_list($conn, $id){
	$query="SELECT * FROM `log_list`  
    WHERE session_id=$id";
	$result=$conn->query($query);        
    if(!$result) die ("Сбой при доступе к базе данных");
    $rows=$result->num_rows;   
    $log_list=[];     
	if ($rows==0){
        $result->close();
		return $log_list;
	}
	else{        
        for ($j = 0; $j<$rows; ++$j){
            $log_list[$j]= $result->fetch_array(MYSQLI_ASSOC); 
        }
        $result->close();
        return $log_list;
	}
}



function find_sessions($conn, $role_status, $order_by_s, $session_status, $start_date_s, $end_date_s){
    if ($role_status=='all'){
        $role_status='%';
    }     
    
    $query="SELECT s.id, m.login, m.role, ll.count_log, s.begin_date, s.end_date FROM `sessions` as s
    JOIN `managers` as m on s.manager_id=m.id
    LEFT JOIN (select count(id) as count_log, session_id from `log_list` GROUP BY session_id ) as ll on s.id=ll.session_id
    WHERE m.role LIKE '$role_status' AND (s.begin_date BETWEEN '$start_date_s' AND '$end_date_s')
    ORDER BY s.begin_date $order_by_s";

	$result=$conn->query($query);        
    if(!$result) die ("Сбой при доступе к базе данных");
    $rows=$result->num_rows; 
    $sessions=[];     
	if ($rows==0){
        $result->close();
		return $sessions;
	}
	else{ 
        $num=0;       
        for ($j = 0; $j<$rows; ++$j){
            $row = $result->fetch_array(MYSQLI_ASSOC);
            
            if (isset($row['end_date'])) {
                $row['session_status']='completed';
                
            } else{
                $row['session_status']='active';
            }
            
            if ($session_status=='all' || $session_status==$row['session_status']  ){
                $sessions[$num]=$row;
                
                $num++;
            }
             
        }
        $result->close();
        return $sessions;
	}
}

function find_logs($conn, $manager_id, $order_by_l, $action_type, $start_date_l, $end_date_l){
    if ($manager_id=='0'){
        $manager_id='%';
    }   
    if ($action_type=='all'){
        $action_type='%';
    }    
    
    $query="SELECT ll.id, ll.action_type, ll.elem_id, ll.created_date, ll.session_id, m.login FROM `log_list` as ll
	JOIN `sessions` as s on s.id=ll.session_id
    JOIN `managers` as m on s.manager_id=m.id
    WHERE m.id LIKE '$manager_id' AND ll.action_type LIKE '$action_type' AND (ll.created_date BETWEEN '$start_date_l' AND '$end_date_l')  
ORDER BY ll.created_date $order_by_l";

	$result=$conn->query($query);        
    if(!$result) die ("Сбой при доступе к базе данных");
    $rows=$result->num_rows; 
    $logs=[];     
	if ($rows==0){
        $result->close();
		return $logs;
	}
	else{ 
        $num=0;       
        for ($j = 0; $j<$rows; ++$j){
            $logs[$j] = $result->fetch_array(MYSQLI_ASSOC);
        }
        $result->close();
        return $logs;
	}
}

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
?>
 
	