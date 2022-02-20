<?php
    require __DIR__ . '\header.php';
?>
<?php
    session_start();
    // POSTされたトークンを取得
    $token=0;
    if(isset($_POST["command"])){
        $pieces = explode(" ",$_POST["command"]);
        $command = $pieces[0];
        $token = $pieces[1];
    }
    // セッション変数のトークンを取得
    $session_token = isset($_SESSION["token"]) ? $_SESSION["token"] : "";
    // セッション変数のトークンを削除
    unset($_SESSION["token"]);
    $id = 0;
    $pdo = new PDO('mysql:host=localhost;dbname=bugle;charset=utf8','staff','password');
    foreach($pdo->query('select * from wifi_machine') as $row){
        if($id < $row['id']){
            $id = $row['id'];
        }
    }
    if($token != "" && $token == $session_token) {
        switch($command){
            case 'insert':
                $sql = $pdo->prepare('insert into wifi_machine values(?,INET_ATON(?),?,NULL)');
                $sql->execute(
                    [$id+1,htmlspecialchars($_REQUEST['ipaddress']),htmlspecialchars($_REQUEST['name'])]
                );
                echo '<script>';
                echo 'function add(){';
                echo 'swal("登録が完了しました。");';
                echo '}';
                echo 'add();';
                echo '</script>';
                break;
            
            case 'delete':           
                $i = 0;     
                foreach($_POST as $row){
                    $post[$i] = $row;
                    $i++;
                }
                $delete_item = $post[count($post)-1];
                $sql = $pdo->prepare('delete from wifi_machine where wifi_machine_name=?');
                $sql->execute([htmlspecialchars($delete_item)]);
                echo '<script>';
                echo 'function add(){';
                echo 'swal("削除されました。");';
                echo '}';
                echo 'add();';
                echo '</script>';
                break;

            case 'update':
                $sql = $pdo->prepare('update wifi_machine set wifi_machine_name=?,ip_address=INET_ATON(?) where id=?');
                $sql->execute(
                    [htmlspecialchars($_POST['wifi_machine_name']),htmlspecialchars($_POST['ip_address']),htmlspecialchars($_POST['id'])]
                );
                echo '<script>';
                echo 'function add(){';
                echo 'swal("変更が完了しました。");';
                echo '}';
                echo 'add();';
                echo '</script>';
                break;
        }
    }
?>
    <main>
        <div class="bugletrigger">
            <?php
                $i = 1;
                $pdo = new PDO('mysql:host=localhost;dbname=bugle;charset=utf8','staff','password');
                foreach($pdo->query('select * from wifi_machine') as $row){
                    echo "<button class='buglebutton wifi$i' name=";
                    echo "\"";
                    echo long2ip($row['ip_address']);
                    echo "\"";
                    echo " type='button' onclick='bugle(event)'>";
                    echo $row['wifi_machine_name'];
                    echo '</button>';
                    echo "\n"; 
                    $i++;
                }
            ?>
        </div>
    </main>
<?php
    require __DIR__ . '\footer.php';
?>