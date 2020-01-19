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

  if ((isset($_POST['view_orders'])) &&
  (isset($_POST['order_status'])) &&
  (isset($_POST['order_by'])) &&
  (isset($_POST['manager']))
  ){
    $status_list=[
        'processed'=>'Выполняются',
        'new'=>'Новые',
        'made'=>'Готовы',
        'received'=>'Получены',
        'canceled'=>'Отменены',
        'all'=>'Все',
    ];  
    $order_list=[
        'asc'=>'Сначала старые',
        'desc'=>'Сначала новые',
    ];  
    $manager_list=[
        'all'=>'Все',
        $name=>'Только мои',
        
    ]; 
      
  $order_status=$status_list[get_post($conn, 'order_status')]; 
  $order_by=$order_list[get_post($conn, 'order_by')]; 
  $manager=$manager_list[get_post($conn, 'manager')];
  }
  else{
    $order_status='-- Статус заказа --'; 
    $order_by='-- Сортировка --'; 
    $manager='-- Сопровождающий менеджер --';
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
        
        <form class="order_number" action="supermanager.php" method="post">
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
		<form class="order_number" action="supermanager.php" method="post">
			<h1> &nbspНомер заказа <input name="order_number" type="number"/></h1>
			<div class="form_button">
				<input type="submit" class="show_order" value="Найти заказ">
			</div>	
			<input type="hidden" name="view_order" value='yes'>				
        </form>
        <form class="order_number" action="supermanager.php" method="post">
			<h1> &nbspНомер заказа <input name="order_number" type="number"/></h1>
			<div class="form_button">
				<input type="submit" class="show_order" value="Удалить заказ">
			</div>	
			<input type="hidden" name="del_order" value='yes'>				
		</form>
		<form class="filters" action="supermanager.php" method="post">
        <h1> &nbspПросмотреть заказы </h1>    
        <select name="order_status">
				<option value="hide" selected disabled hidden>$order_status</option>
				<option value="new">Новые</option>
				<option value="processed">Выполняются</option>
				<option value="made">Готовы</option>
				<option value="recieved">Получены</option>
				<option value="canceled">Отменены</option>
				<option value="all">Все</option>
				
			</select> 					
			<select name="order_by">
				<option value="hide" selected disabled hidden>$order_by</option>
				<option value="asc">Сначала старые</option>
				<option value="desc">Сначала новые</option>
			</select>
			<select name="manager">
				<option value="hide" selected disabled hidden>$manager</option>
				<option value='$name'>Только мои</option>
				<option value="all">Все</option>
			</select>
			<div class="form_button">
				<input type="submit" class="show_order" value="Применить">
			</div>
			<input type="hidden" name="view_orders" value='yes'>
		</form>			
		
  
_END;


if ((isset($_POST['view_order'])) &&
($_POST['order_number'] != '')
){
    $order_info=find_order_info($conn, get_post($conn, 'order_number'));
	if (htmlspecialchars($order_info["id"])==-1){
		echo<<<_END
		<div id="fade" class="black-overlay"></div>
		<div class="order">
			<a  href="supermanager.php"><img class="close-button" src="../images/icons/cross.png" onclick = "document.getElementById('order').style.display='none';document.getElementById('fade').style.display='none'"></a>
			<h2>Заказ с таким номером не найден!</h2>
		</div>
_END;		
	}
	else{
		$id=htmlspecialchars($order_info["id"]);
		$customer_name=htmlspecialchars($order_info["customer_name"]);
		$customer_phone=htmlspecialchars($order_info["phone_number"]);
		$created_date=htmlspecialchars($order_info["created_date"]);
		$changing_date=htmlspecialchars($order_info["changing_date"]);
		$order_status=htmlspecialchars($order_info["order_status"]);
        $login=htmlspecialchars($order_info["login"]);
        $summ=htmlspecialchars($order_info["production_cost"]);
        $status_list=[
            'processed'=>'Выполняется',
            'new'=>'Новый',
            'made'=>'Готов',
            'received'=>'Получен',
            'canceled'=>'Отменен',
        ];
        $order_list=find_order_list($conn, $id);
        $rows=count($order_list);
        $products_list='';        
		echo<<<_END
    <div id="fade" class="black-overlay"></div>
        <form action="supermanager.php" method="post" id="order_list" class="order">
			<img class="close-btn" src="../images/icons/cross.png" onclick = "document.getElementById('order_list').style.display='none';document.getElementById('fade').style.display='none'">
			<div class="info">
				<h3>    Номер заказа: $id<br>
				    Имя покупателя: <input name="customer_name" value='$customer_name' /><br>
				    Номер телефона: <input name="customer_phone" value= '$customer_phone' /><br>
				    Создан: $created_date<br>
				    Последнее обновление: $changing_date<br>
				    Сопровождающий менеджер: $login<br>
				    Статус 
				<select name="order_status">
					<option value="actual" selected disabled hidden>$status_list[$order_status]</option>
					<option value="new">Новый</option>
					<option value="processed">Выполняется</option>
					<option value="made">Готов</option>
					<option value="recieved">Получен</option>
                    <option value="canceled">Отменен</option>
                    <input type="hidden" name="actual_order_status" value='$status_list[$order_status]'>
					
				</select> 	
				</h3>
			</div>
			<div class="spisok_tovarov">
				<h7 class="list_products">Список товаров</h7>
                <div class="table">
                    <table class="table_order_list">
                        <tr><th>№</th><th>Название</th><th>кол-во</th><th>Цена</th><th>Стоимость</th></tr>
_END;
        for ($j = 0; $j<$rows; ++$j){
            $number=$j+1;
            $o_l_id=htmlspecialchars($order_list[$j]['id']);
            $o_l_name=htmlspecialchars($order_list[$j]['name']);
            $o_l_quantity=htmlspecialchars($order_list[$j]['quantity']);
            $o_l_cost=htmlspecialchars($order_list[$j]['cost']);
            $o_l_summ=$o_l_quantity*$o_l_cost;
            $products_list.=$o_l_id;
            $products_list.=',';
            echo<<<_END
            <tr>
            <td>$number&nbsp</td>
            <td>$o_l_name&nbsp</td>
            <td>
            <input type="number" size="100" name="$o_l_id-quantity" min="0" max="100" value="$o_l_quantity" class="number">
            </td>
            <td>
            <input type="number" size="3" name="$o_l_id-cost" value="$o_l_cost" class="number" min="0" max="10000"> р&nbsp
            </td>
            <td><input type="number" size=20 name="$o_l_id-summ" value="$o_l_summ" class="number" min="0" max="10000"> р&nbsp</td>
            </tr>
_END;
            
        } 
        echo<<<_END
    </table>
    </div>
    </div>
    <div class="amount">
          <h3>  ИТОГО &nbsp <input type="number" size="3" name="summ" value='$summ' class="number" min="0" max="100000"> p</h3> 
          
    </div>
    <div class="form_button">
        <input type="submit" class="show_order" value="Внести изменения">
    </div>
    <input type="hidden" name="change_order" value='$id'>
    <input type="hidden" name="products_list" value='$products_list'>
    </form>
_END;
	}
	
	

}

if ((isset($_POST['view_orders'])) &&
(isset($_POST['order_status'])) &&
(isset($_POST['order_by'])) &&
(isset($_POST['manager']))
){
    
	
    $order_status=get_post($conn, 'order_status'); 
    $order_by=get_post($conn, 'order_by'); 
    $manager=get_post($conn, 'manager');
    $orders=find_orders($conn, $order_status, $order_by, $manager);
    $status_list=[
        'processed'=>'Выполняется',
        'new'=>'Новый',
        'made'=>'Готов',
        'received'=>'Получен',
        'canceled'=>'Отменен',
    ];
    $rows=count($orders);
    if ($rows==0){
        echo<<<_END
        <div class="order_list">
        <h3>Список заказов пуст</h3>
        </div>
    _END;
    }
    else{
        echo<<<_END
    <div class="order_list">
    <h3>Список заказов</h3>
                    <div class="table">
                        <table class="table_order_list">
                            <tr><th>№</th><th>ID заказа</th><th>Менеджер</th><th>Дата создания</th><th>Дата последнего изменения</th><th>Статус заказа</th><th>Имя покупателя</th><th>Телефон для связи</th><th>Стоимость заказа</th></tr>
    _END;
    for ($j = 0; $j<$rows; ++$j){
        $number=$j+1;
        $o_id=htmlspecialchars($orders[$j]['id']);
        $o_manager=htmlspecialchars($orders[$j]['login']);
        $o_created_date=htmlspecialchars($orders[$j]['created_date']);
        $o_changing_date=htmlspecialchars($orders[$j]['changing_date']);
        $o_order_status=$status_list[htmlspecialchars($orders[$j]['order_status'])];
        $o_customer_name=htmlspecialchars($orders[$j]['customer_name']);
        $o_phone_number=htmlspecialchars($orders[$j]['phone_number']);
        $o_production_cost=htmlspecialchars($orders[$j]['production_cost']);
        
        
        echo<<<_END
        <tr>
        <td>$number&nbsp</td>
        <td><form action="supermanager.php" method="post">
        <input type="hidden" name="order_number" value="$o_id"/>
        <input type="submit"  value="$o_id">
        <input type="hidden" name="view_order" value='yes'>				
    </form>&nbsp</td>
        <td>$o_manager&nbsp</td>
        <td>$o_created_date&nbsp</td>
        <td>$o_changing_date&nbsp</td>
        <td>$o_order_status&nbsp</td>
        <td>$o_customer_name&nbsp</td>
        <td>$o_phone_number&nbsp</td>
        <td>$o_production_cost р&nbsp</td>
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

if ((isset($_POST['del_order'])) &&
($_POST['order_number'] != '')
){
   $id=del_order($conn, get_post($conn, 'order_number'));
	if (htmlspecialchars($id)==-1){
		echo<<<_END
		<div id="fade" class="black-overlay"></div>
		<div class="order">
			<a  href="supermanager.php"><img class="close-button" src="../images/icons/cross.png" onclick = "document.getElementById('order').style.display='none';document.getElementById('fade').style.display='none'"></a>
			<h2>Заказ с таким ID не найден!</h2>
		</div>
_END;		
	}
	else{
        echo<<<_END
		<div id="fade" class="black-overlay"></div>
		<div class="order">
			<a  href="supermanager.php"><img class="close-button" src="../images/icons/cross.png" onclick = "document.getElementById('order').style.display='none';document.getElementById('fade').style.display='none'"></a>
			<h2>Заказ с ID - $id успешно удален!</h2>
		</div>
_END;		
	}
	
	

}
if (isset($_POST['change_password'])){
         
    echo<<<_END
 <div id="fade" class="black-overlay"></div>
     <form action="supermanager.php"  method="post" id="order_list" class="order">
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
			<a  href="supermanager.php"><img class="close-button" src="../images/icons/cross.png" onclick = "document.getElementById('order').style.display='none';document.getElementById('fade').style.display='none'"></a>
			<h2>$str</h2>
		</div>
_END;
    
}

if (isset($_POST['change_order'])){
     
    mysql_change_order($conn); 
}

echo<<<_END

</div>	
</div>
</body>
</html>     
_END;	


$conn->close(); 

function del_order($conn, $id){
	$query="SELECT * from orders
	WHERE id=$id";
	$result=$conn->query($query);        
	if(!$result) die ("Сбой при доступе к базе данных");
	if ($result->num_rows==0){
        $result->close();
        return -1;
	}
	else{
        $result->close();
        $query="DELETE from order_list
	WHERE order_id=$id";
	$result=$conn->query($query);        
	if(!$result) die ("Сбой при доступе к базе данных");
    //$result->close();

        $query="DELETE from order_processing
	WHERE order_id=$id";
	$result=$conn->query($query);        
    if(!$result) die ("Сбой при доступе к базе данных");
    //$result->close();

		$query="DELETE from orders
	WHERE id=$id";
	$result=$conn->query($query);        
    if(!$result) die ("Сбой при доступе к базе данных");
    //$result->close();
    add_log($conn, 'delete_order', $id);
		return $id;
	}
}

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

        $stmt=$conn->prepare("UPDATE managers SET  `password`=? WHERE `login`=? AND `password`=?");
        $stmt->bind_param('sss',$new_pass,$log,$old_password);
        
        $new_pass=$new_pass1;
        $log=$login;
        $old_password=$old_pass;  
        
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

function mysql_change_order($conn){
    if (isset($_POST['change_order'])){
        $id=get_post($conn,'change_order');
        $stmt=$conn->prepare('UPDATE orders SET phone_number=?, customer_name=?, production_cost=?  WHERE id=?');
        $stmt->bind_param('ssdi',$phone_number,$name,$summ,$id);
        
        $name=get_post($conn, 'customer_name');
        $phone_number=get_post($conn, 'customer_phone');
        $summ=get_post($conn, 'summ');
        
        $stmt->execute();
        $stmt->close();  
        
        $stmt=$conn->prepare('INSERT INTO order_processing(order_id, order_status, manager_id) VALUES(?,?,?)');
        $stmt->bind_param('isi',$order_id, $order_status, $manager_id);
        
        $login=$conn->real_escape_string($_SESSION['logged_user']);
        $query="SELECT id FROM managers WHERE login LIKE '$login' LIMIT 1";
        $result=$conn->query($query);        
        if(!$result) die ("Сбой при доступе к базе данных");
        $manager_id=$result->fetch_array(MYSQLI_NUM)[0];
        $result->close();
        $order_id=$id;
        if (isset($_POST['order_status'])){
            $order_status=get_post($conn,'order_status');
        } else{
            $status_list=[
                'Выполняется'=>'processed',
                'Новый'=>'new',
                'Готов'=>'made',
                'Получен'=>'received',
                'Отменен'=>'canceled',
            ];
            $order_status=$status_list[get_post($conn,'actual_order_status')];
        } 
        $stmt->execute();
        $stmt->close(); 
        
        $products_list=get_post($conn,'products_list');
        preg_match_all('|\d+|', $products_list, $products); 
                
        $rows=count($products[0]);
        for ($j = 0; $j<$rows; ++$j){

            $order_list_id=$conn->real_escape_string($products[0][$j]);

            $stmt=$conn->prepare('UPDATE order_list SET quantity=?, cost=? WHERE id=?');
            $stmt->bind_param('idi',$quantity, $cost, $order_list_id);
            
            $quantity=get_post($conn,$order_list_id.'-quantity');
            $cost=get_post($conn,$order_list_id.'-cost');
            $order_list_summ=get_post($conn,$order_list_id.'-summ');

            $stmt->execute();
            $stmt->close();

            
            
        }
        add_log($conn, 'change_order', $id);
            

    }
    return $id;
    
}


function find_order_info($conn, $id){
	$query="SELECT o.id, o.customer_name, o.phone_number,o.created_date, o_p.changing_date, o_p.order_status, m.login, o.production_cost FROM `orders` as o 
	join (SELECT * FROM order_processing WHERE order_id=$id ORDER BY changing_date DESC LIMIT 1) as o_p on o.id=o_p.order_id
	join managers as m on o_p.manager_id=m.id
	WHERE o.id=$id";
	$result=$conn->query($query);        
	if(!$result) die ("Сбой при доступе к базе данных");
	if ($result->num_rows==0){
		$order_info=[
			"id"=>-1,
        ];
        $result->close();
		return $order_info;
	}
	else{
		$order_info = $result->fetch_array(MYSQLI_ASSOC);

        $result->close();
		return $order_info;
	}
}
 
function find_order_list($conn, $id){
	$query="SELECT o_l.id, p.name, o_l.quantity, o_l.cost FROM `order_list` as o_l 
    join products as p on o_l.product_id=p.id 
    WHERE o_l.order_id=$id";
	$result=$conn->query($query);        
    if(!$result) die ("Сбой при доступе к базе данных");
    $rows=$result->num_rows;   
    $order_list=[];     
	if ($rows==0){
        $result->close();
		return $order_list;
	}
	else{        
        for ($j = 0; $j<$rows; ++$j){
            $order_list[$j]= $result->fetch_array(MYSQLI_ASSOC); 
        }
        $result->close();
        return $order_list;
	}
}


function find_orders($conn, $order_status, $order_by, $manager){
    if ($order_status=='all'){
        $order_status='%';
    }
    if ($manager=='all'){
        $manager='%';
    }

    $query="SELECT o.id, m.login,o.created_date, o_p.changing_date, o_p.order_status, o.customer_name, o.phone_number, o.production_cost from 
    (SELECT o.id, o.customer_name, o.phone_number, o.created_date, o.production_cost, max(o_p.changing_date) as max_changing_date  FROM `orders` as o
        join order_processing as o_p on o.id=o_p.order_id	
        GROUP BY o.id) as o
        join order_processing as o_p on o.id=o_p.order_id
        join managers as m on o_p.manager_id=m.id
        WHERE o.max_changing_date=o_p.changing_date and o_p.order_status LIKE '$order_status' and m.login LIKE '$manager'
        ORDER BY created_date $order_by";
	$result=$conn->query($query);        
    if(!$result) die ("Сбой при доступе к базе данных");
    $rows=$result->num_rows;   
    $orders=[];     
	if ($rows==0){
        $result->close();
		return $orders;
	}
	else{        
        for ($j = 0; $j<$rows; ++$j){
            $orders[$j]= $result->fetch_array(MYSQLI_ASSOC); 
        }
        $result->close();
        return $orders;
	}
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
 
	