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

  if ((isset($_POST['view_products'])) &&
  (isset($_POST['availability_status'])) 
  ){
    $availability_list=[
        '1'=>'Доступные к продаже',
        '0'=>'Недоступные к продаже',        
        'all'=>'Все',
    ];  
    
      
  $availability_status=$availability_list[get_post($conn, 'availability_status')]; 
  
  }
  else{
    $availability_status='-- Статус продукта --'; 
    
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
		<form class="order_number" action="products_sm.php" method="post">
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
		<form class="order_number" action="products_sm.php" method="post">
			<h1> &nbspID продукта <input name="product_id" type="number"/></h1>
			<div class="form_button">
				<input type="submit" class="show_order" value="Найти продукт">
			</div>	
			<input type="hidden" name="view_product" value='yes'>				
        </form>
        <form class="order_number" action="products_sm.php" method="post">
        <h1> &nbspID продукта <input name="product_id" type="number"/></h1>
			<div class="form_button">
				<input type="submit" class="show_order" value="Удалить продукт">
			</div>	
			<input type="hidden" name="del_product" value='yes'>				
		</form>
        <form class="order_number" action="products_sm.php" method="post">
			
			<div class="form_button">
				<input type="submit" class="show_order" value="Добавить продукт">
			</div>	
			<input type="hidden" name="add_product" value='yes'>				
        </form>
        
		<form class="filters" action="products_sm.php" method="post">
        <h1> &nbspПросмотреть продукты </h1>    
        <select name="availability_status">
				<option value="hide" selected disabled hidden>$availability_status</option>
				<option value="1">Доступные к продаже</option>
				<option value="0">Недоступные к продаже</option>
				<option value="all">Все</option>
				
			</select> 					
			
			<div class="form_button">
				<input type="submit" class="show_order" value="Применить">
			</div>
			<input type="hidden" name="view_products" value='yes'>
		</form>			
		
  
_END;


if ((isset($_POST['view_product'])) &&
($_POST['product_id'] != '')
){
   $product_info=find_product($conn, get_post($conn, 'product_id'));
	if (htmlspecialchars($product_info["id"])==-1){
		echo<<<_END
		<div id="fade" class="black-overlay"></div>
		<div class="order">
			<a  href="products_sm.php"><img class="close-button" src="../images/icons/cross.png" onclick = "document.getElementById('order').style.display='none';document.getElementById('fade').style.display='none'"></a>
			<h2>Продукт с таким ID не найден!</h2>
		</div>
_END;		
	}
	else{
        $availability_list=[
            '1'=>'Доступен к продаже',
            '0'=>'Недоступен к продаже',         
        ];
		$id=htmlspecialchars($product_info["id"]);
		$img_url=htmlspecialchars($product_info["img_url"]);
		$name=htmlspecialchars($product_info["name"]);
		$price=htmlspecialchars($product_info["price"]);
		$availability_status=$availability_list[htmlspecialchars($product_info['availability'])];        
		echo<<<_END
    <div id="fade" class="black-overlay"></div>
        <form action="products_sm.php" enctype="multipart/form-data" method="post" id="order_list" class="order">
			<img class="close-btn" src="../images/icons/cross.png" onclick = "document.getElementById('order_list').style.display='none';document.getElementById('fade').style.display='none'">
			<div class="b1 f1" id="product">
            <div class="container_photo">
                <img src="../images/Products/$img_url" class="img">
            </div>
            <div class="text">
                <h1 align="center">ID - $id <br>
                Название продукта: <input name="name" value="$name" /><br>
                Цена продукта: <input type="number" size="3" name="price" value="$price" class="number" min="0" max="10000">  р/шт <br>
                Изображение: <input type="hidden" name="MAX_FILE_SIZE" value="1048576" />
                <input name="userfile" type="file" accept="image/jpg, image/jpeg, image/png"/></h1>
                <input type="hidden" name="actual_img_url" value="$img_url">
                
                <select align="center" name="availability_status">
                    <option value="hide" selected disabled hidden>$availability_status</option>
                    <option value="1">Доступен к продаже</option>
                    <option value="0">Недоступен к продаже</option>
                </select>  
                <input type="hidden" name="actual_availability_status" value="$availability_status">
                
                <div class="form_button">
                        <input type="submit" class="show_order" value="Внести изменения">
                </div>
                <input type="hidden" name="change_product" value="$id">
                
            </div>                       
        </div>
			
    
    </form>
_END;
	}
	
	

}

if ((isset($_POST['view_products'])) &&
  (isset($_POST['availability_status'])) 
  ){
    
    $availability_status=get_post($conn, 'availability_status'); 
    $products=find_products($conn, $availability_status);
    $availability_list=[
        '1'=>'Доступен к продаже',
        '0'=>'Недоступен к продаже',         
    ];
    $rows=count($products);
    if ($rows==0){
        echo<<<_END
        <div class="order_list">
        <h3>Список продуктов пуст</h3>
        </div>
    _END;
    }
    else{
        echo<<<_END
    <div class="order_list">
    <h3>Список продуктов</h3>
    <div class="container_full">
_END;
    for ($j = 0; $j<$rows; ++$j){
        $id=htmlspecialchars($products[$j]['id']);
        $img_url=htmlspecialchars($products[$j]['img_url']);
        $name=htmlspecialchars($products[$j]['name']);
        $price=htmlspecialchars($products[$j]['price']);
        $p_availability_status=$availability_list[htmlspecialchars($products[$j]['availability'])];
                
        echo <<<_END
        <div class="b1 f1" id="product">
            <div class="container_photo">
                <img src="../images/Products/$img_url" class="img">
            </div>
            <div class="text">
                <h1 align="center">ID - $id</h1>
                <h1 align="center">$name</h1>
                <h1 align="center">Цена - $price р/шт</h1>
                <h1 align="center">$p_availability_status</h1>
                <form action="products_sm.php" method="post">
                    <input type="hidden" name="product_id" value="$id"/>
                    <div class="form_button">
                        <input type="submit" class="show_product" value="Изменить">
                    </div>
                    <input type="hidden" name="view_product" value='yes'>				
                </form>
            </div>                       
        </div>
_END;
        
} 



echo<<<_END
</div>
</div>        
        

_END;


}
        

}

if (isset($_POST['change_password'])){
       
   echo<<<_END
<div id="fade" class="black-overlay"></div>
    <form action="products_sm.php"  method="post" id="order_list" class="order">
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
           <a  href="products_sm.php"><img class="close-button" src="../images/icons/cross.png" onclick = "document.getElementById('order').style.display='none';document.getElementById('fade').style.display='none'"></a>
           <h2>$str</h2>
       </div>
_END;
   
}


if (isset($_POST['change_product'])){
    
    $flag=mysql_change_product($conn); 
    if ($flag===0){
        echo<<<_END
		<div id="fade" class="black-overlay"></div>
		<div class="order">
			<a  href="products_sm.php"><img class="close-button" src="../images/icons/cross.png" onclick = "document.getElementById('order').style.display='none';document.getElementById('fade').style.display='none'"></a>
			<h2>Извините, что-то пошло не так!</h2>
		</div>
_END;
    }else{
        echo<<<_END
		<div id="fade" class="black-overlay"></div>
		<div class="order">
			<a  href="products_sm.php"><img class="close-button" src="../images/icons/cross.png" onclick = "document.getElementById('order').style.display='none';document.getElementById('fade').style.display='none'"></a>
			<h2>Изменения сохранены!</h2>
		</div>
_END;
}	
}

if (isset($_POST['add_product'])){
         
    echo<<<_END
<div id="fade" class="black-overlay"></div>
    <form action="products_sm.php" enctype="multipart/form-data" method="post" id="order_list" class="order">
        <img class="close-btn" src="../images/icons/cross.png" onclick = "document.getElementById('order_list').style.display='none';document.getElementById('fade').style.display='none'">
        <div class="b1 f1" id="product">
        <div class="container_photo">
            <img src="../images/Products/0.jpg" class="img">
        </div>
        <div class="text">
            <h1 align=center>
            Название продукта: <input name="name" required /><br>
            Цена продукта: <input type="number" size="3" name="price" required class="number" min="0" max="10000">  р/шт <br>
            Изображение: <input type="hidden" name="MAX_FILE_SIZE" value="1048576" />
            <input name="userfile" type="file" accept="image/jpg, image/jpeg, image/png"/></h1>
            <input type="hidden" name="actual_img_url" value="0.jpg">
            
            <select align="center" required name="availability_status">
                <option value="1" selected>Доступен к продаже</option>
                <option value="0">Недоступен к продаже</option>
            </select>  
            
            
            <div class="form_button">
                    <input type="submit" class="show_order" value="Добавить продукт">
            </div>
            <input type="hidden" name="db_add_product" value="yes">
            
        </div>                       
    </div>
        

</form>
_END;
    
}

if (isset($_POST['db_add_product'])){
    $flag=mysql_add_product($conn); 
    if ($flag===0){
        echo<<<_END
		<div id="fade" class="black-overlay"></div>
		<div class="order">
			<a  href="products_sm.php"><img class="close-button" src="../images/icons/cross.png" onclick = "document.getElementById('order').style.display='none';document.getElementById('fade').style.display='none'"></a>
			<h2>Извините, что-то пошло не так!</h2>
		</div>
_END;
    }else{
        echo<<<_END
		<div id="fade" class="black-overlay"></div>
		<div class="order">
			<a  href="products_sm.php"><img class="close-button" src="../images/icons/cross.png" onclick = "document.getElementById('order').style.display='none';document.getElementById('fade').style.display='none'"></a>
			<h2>Продукт добавлен!</h2>
		</div>
_END;
}	
}

if ((isset($_POST['del_product'])) &&
($_POST['product_id'] != '')
){
   $id=del_product($conn, get_post($conn, 'product_id'));
	if (htmlspecialchars($id)==-1){
		echo<<<_END
		<div id="fade" class="black-overlay"></div>
		<div class="order">
			<a  href="products_sm.php"><img class="close-button" src="../images/icons/cross.png" onclick = "document.getElementById('order').style.display='none';document.getElementById('fade').style.display='none'"></a>
			<h2>Продукт с таким ID не найден!</h2>
		</div>
_END;		
	}
	else{
        echo<<<_END
		<div id="fade" class="black-overlay"></div>
		<div class="order">
			<a  href="products_sm.php"><img class="close-button" src="../images/icons/cross.png" onclick = "document.getElementById('order').style.display='none';document.getElementById('fade').style.display='none'"></a>
			<h2>Продукт с ID - $id успешно удален!</h2>
		</div>
_END;		
	}
	
	

}

echo<<<_END

</div>	
</div>
</body>
</html>     
_END;	


$conn->close(); 

function mysql_add_product($conn){
    if (isset($_POST['db_add_product'])){

        $uploaddir = '../images/Products/';
        
        $stmt=$conn->prepare('INSERT INTO products (`name`, price, img_url, `availability`) VALUES(?,?,?,?)');
        $stmt->bind_param('sdsi',$name,$price,$img_url,$availability);
        
          
        $name=get_post($conn, 'name');
        $price=get_post($conn, 'price');
        
        $availability=get_post($conn,'availability_status');
                
        if (basename($_FILES['userfile']['name'])!=''){
            $img_url=basename($_FILES['userfile']['name']);
        $uploadfile = $uploaddir . $img_url;
        move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile);
        
        } else{
            $img_url=get_post($conn,'actual_img_url');
        }
        
        //print_r($_FILES);
        $flag=$stmt->execute();
        $stmt->close(); 
        
        $query="SELECT id from products
	ORDER BY id DESC LIMIT 1";
	$result=$conn->query($query);        
	if(!$result) die ("Сбой при доступе к базе данных");
    $id=$result->fetch_array(MYSQLI_NUM)[0];
    $result->close();

        add_log($conn, 'add_product', $id);

        return $flag;
        
    }    
    
    
    
}

function mysql_change_product($conn){
    if (isset($_POST['change_product'])){
        
        $uploaddir = '../images/Products/';
        
        $stmt=$conn->prepare('UPDATE products SET `name`=?, `price`=?, `img_url`=?, `availability`=?  WHERE `id`=?');
        $stmt->bind_param('sdsii',$name,$price,$img_url,$availability,$id);
        
        $id=get_post($conn,'change_product');
        
        $name=get_post($conn, 'name');
        $price=get_post($conn, 'price');
        
        if (isset($_POST['availability_status'])){
            $availability=get_post($conn,'availability_status');
        } else{
            $availability_list=[
                'Доступен к продаже'=>'1',
                'Недоступен к продаже'=>'0',
                
            ];
            $availability=$availability_list[get_post($conn,'actual_availability_status')];
        }
        
        
        if (basename($_FILES['userfile']['name'])!=''){
            $img_url=basename($_FILES['userfile']['name']);
        $uploadfile = $uploaddir . $img_url;
        move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile);
        
        } else{
            $img_url=get_post($conn,'actual_img_url');
        }
        
        //print_r($_FILES);
        $flag=$stmt->execute();
        $stmt->close();  
        
        add_log($conn, 'change_product', $id);
    }    
    return $flag;
    
}


function find_product($conn, $id){
	$query="SELECT * from products
	WHERE id=$id";
	$result=$conn->query($query);        
	if(!$result) die ("Сбой при доступе к базе данных");
	if ($result->num_rows==0){
		$product_info=[
			"id"=>-1,
        ];
        $result->close();
		return $product_info;
	}
	else{
		$product_info = $result->fetch_array(MYSQLI_ASSOC);

        $result->close();
		return $product_info;
	}
}

function del_product($conn, $id){
	$query="SELECT * from products
	WHERE id=$id";
	$result=$conn->query($query);        
	if(!$result) die ("Сбой при доступе к базе данных");
	if ($result->num_rows==0){
        $result->close();
        return -1;
	}
	else{
		$query="DELETE from products
	WHERE id=$id";
	$result=$conn->query($query);        
    if(!$result) die ("Сбой при доступе к базе данных");
    //$result->close();
    add_log($conn, 'delete_product', $id);
	return $id;
	}
}
 

function find_products($conn, $availability_status){
    if ($availability_status=='all'){
        $availability_status='%';
    }   

    $query="select * from products
        WHERE availability LIKE '$availability_status'
        ORDER BY id";
	$result=$conn->query($query);        
    if(!$result) die ("Сбой при доступе к базе данных");
    $rows=$result->num_rows; 
    $products=[];     
	if ($rows==0){
        $result->close();
		return $products;
	}
	else{        
        for ($j = 0; $j<$rows; ++$j){
            $products[$j]= $result->fetch_array(MYSQLI_ASSOC); 
        }
        $result->close();
        return $products;
	}
}


?>
 
	