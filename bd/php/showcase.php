<?php
    require_once 'login.php';
    $conn=new mysqli($hn, $un, $pw, $db);

    if($conn->connect_error) die ("Fatal Error");

    $query="SELECT * FROM products WHERE availability=1";
    $result=$conn->query($query);
    
    if(!$result) die ("Сбой при доступе к базе данных");

    $rows=$result->num_rows;
    
    echo<<<_END
    <html>
        <head>
        <title>Витрина</title>
            <meta charset = "utf-8">
            <link rel = "stylesheet" type = "text/css" href = "../css/vitrina.css">
        </head>
        <body>
            <div class="head">
                <h1> Ассортимент </h1>
                <a class="wsbutton" href="../html/Main.html">
                    <h2 align="center">На главную</h2>
                </a>
            </div>
            <form action="showcase.php" method="post"  id="form_showcase">
                <div class="container_full">
            
        
_END;

    for ($j = 0; $j<$rows; ++$j){
        $row = $result->fetch_array(MYSQLI_NUM);
        $r0=htmlspecialchars($row[0]);
        $r1=htmlspecialchars($row[1]);
        $r2=htmlspecialchars($row[2]);
        $r3=htmlspecialchars($row[3]);
        if (isset($_POST['view_order'])){
            $r4=htmlspecialchars($_POST[$r0]);
        }
        else{
            $r4=0;
        }
        
        echo <<<_END
        <div class="b1 f1" id="product">
            <div class="container_photo">
                <img src="../images/Products/$r3" class="img">
            </div>
            <div class="text">
                <h3 align="center">$r1</h3>
                <h4 align="center">Цена - $r2 р/шт</h4>
            </div>
            <div class="colvo">
                <h5> Количество: </h5>
                <p><input type="number" size="3" name="$r0" min="0" max="100" value="$r4" class="number"></p>
            </div>            
        </div>
_END;
    }
    $result->close();
    echo<<<_END
        </div>
        <footer>
            <div class="footer">
                <input type="submit" class="show_order" value="Оформить заказ">
                <input type="reset" class="show_order" value="Сбросить">
                
            </div>
        </footer>
        <input type="hidden" name="view_order" value='yes'>
    </form>
_END;

if (isset($_POST['get_order'])){
    $id=mysql_insert_order($conn);
    echo<<<_END
    <div id="fade" class="black-overlay"></div>
    <div id="thank_you" class="thanks">
    <img class="close-btn" src="../images/icons/cross.png" onclick = "document.getElementById('thank_you').style.display='none';document.getElementById('fade').style.display='none'">
    <div class="phone">
    <br>
    <h8> Спасибо за Ваш заказ!</h8> <br>
    <h9> Наши менеджеры свяжутся с Вами </h9><br>
    <h9>для уточнения параметров &nbspзаказа! </h9>
    <br>
    <div class="track_code">
        <br>        
        <h8> Номер для отслеживания&nbsp</h8>
        <h9> $id</h9>
        <br>
    </div>
    </div>
    
</div>
_END;


}

if (isset($_POST['view_order'])){
    echo<<<_END
    <div id="fade" class="black-overlay"></div>
        <form action="showcase.php" method="post" id="order_list" class="order">
			<img class="close-btn" src="../images/icons/cross.png" onclick = "document.getElementById('order_list').style.display='none';document.getElementById('fade').style.display='none'">
			<div class="spisok_tovarov">
				<h7 class="list_products">Список товаров</h7>
                <div class="table">
                    <table class="table_order_list">
                        <tr><th>№</th><th>Название</th><th>Кол-во</th><th>Цена</th><th>Стоимость</th></tr>
_END;
$number = 0;
$summ=0;
$result=$conn->query($query);
    
    if(!$result) die ("Сбой при доступе к базе данных");

    $rows=$result->num_rows;
for ($j = 0; $j<$rows; ++$j){
    $row = $result->fetch_array(MYSQLI_NUM);
    $r0=htmlspecialchars($row[0]);
    
    $r1=htmlspecialchars($row[1]);
    $r2=htmlspecialchars($row[2]);
    $r3=htmlspecialchars($row[3]);   
    
    if ((isset($_POST[$r0]))&&
    (mysql_fix_string($conn, $_POST[$r0]) > 0)){
        $number++;
        $count=mysql_fix_string($conn, $_POST[$r0]);
        $elem_summ=$count*$r2;
        $summ+=$elem_summ;
        echo<<<_END
        <input type="hidden" name=$r0 value=$count>
        <tr><td>$number&nbsp</td><td>$r1&nbsp</td><td>$count&nbsp</td><td>$r2 р&nbsp</td><td>$elem_summ р&nbsp</td></tr>
_END;
    }
}  
$result->close();
echo<<<_END
    </table>
    </div>
    </div>
      <div class="amount">
          <h7>ИТОГО &nbsp $summ p</h7> 
          <input type="hidden" name="summ" value=$summ>
      </div>
      <div class="phone">
      <br><h7>Для оформления заказа заполните поля ниже </h7>
        <input name="phone_number" placeholder="Введите номер телефона" class="textbox" required />
        <input name="name" placeholder="Введите Имя" class="textbox" required />
        <div class="footer">
                <input type="submit" class="show_order" value="Оформить заказ">
                <input type="reset" class="show_order" value="Сбросить">
                
        </div>
        <input type="hidden" name="get_order" value='yes'>
        </div>
      </form>

_END;

}

    echo<<<_END
        
        
        
    </body>
    </html>
_END;


$conn->close(); 

function mysql_insert_order($conn){
    $id=0;
    if (isset($_POST['get_order']) &&
    isset($_POST['name']) &&
    isset($_POST['phone_number'])){
        $stmt=$conn->prepare('INSERT INTO orders(phone_number, customer_name, production_cost) VALUES(?,?,?)');
        $stmt->bind_param('ssd',$phone_number,$name,$summ);
        
        $name=get_post($conn, 'name');
        $phone_number=get_post($conn, 'phone_number');
        $summ=get_post($conn, 'summ');
        
        $stmt->execute();
        $stmt->close();

        $query="SELECT id FROM orders WHERE phone_number=$phone_number ORDER BY created_date DESC LIMIT 1";
        $result=$conn->query($query);        
        if(!$result) die ("Сбой при доступе к базе данных1");
        $id=$result->fetch_array(MYSQLI_NUM)[0];
        $result->close();
        $stmt=$conn->prepare('INSERT INTO order_processing(order_id, order_status, manager_id) VALUES(?,?,?)');
        $stmt->bind_param('isi',$order_id, $order_status, $manager_id);
        
        $order_id=$id;
        $order_status='new';
        $manager_id=4;
        
        $stmt->execute();
        $stmt->close();
        
        
        
        $query="SELECT * FROM products WHERE availability=1";
        $result=$conn->query($query);    
        if(!$result) die ("Сбой при доступе к базе данных");
        $rows=$result->num_rows;
        for ($j = 0; $j<$rows; ++$j){
            $row = $result->fetch_array(MYSQLI_NUM);
            $r0=htmlspecialchars($row[0]);
            $r1=htmlspecialchars($row[1]);
            $r2=htmlspecialchars($row[2]);
            $r3=htmlspecialchars($row[3]);
            if (isset($_POST[$r0])){
                $stmt=$conn->prepare('INSERT INTO order_list(order_id, product_id, quantity, cost) VALUES(?,?,?,?)');
                $stmt->bind_param('iiid',$order_id, $product_id, $quantity, $cost);
                
                $order_id=$id;
                $product_id=$r0;
                $quantity=get_post($conn, $r0);
                $cost=$r2;
                $stmt->execute();
                $stmt->close();
            }
        }
            
        $result->close();     

    }
    return $id;
    
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