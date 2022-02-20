<?php
    require __DIR__ . '\header.php';
?>
<?php
    session_start();

    // 二重送信防止用トークンの発行
    $token = uniqid('', true);;

    //トークンをセッション変数にセット
    $_SESSION['token'] = $token;

    echo '<script>';
    echo 'function add(){';
    echo 'swal("削除するボタンを選択してください。");';
    echo '}';
    echo 'add();';
    echo '</script>';

?>
    <main>
        <div class="deletemessage">削除ボタン選択</div>
        <form action="index.php" method="post" class="Registration">
        <input type="hidden" name="command" value="delete <?php echo $token;?>">
        <!-- <input type="text" name="ipaddress" class="input-form" placeholder="ipアドレス"> -->
            <div class="bugletrigger">
                <?php
                    $i = 1;
                    $pdo = new PDO('mysql:host=localhost;dbname=bugle;charset=utf8','staff','password');
                    foreach($pdo->query('select * from wifi_machine') as $row){
                        echo "<input type='submit' class='buglebutton-delete wifi$i' name=";
                        echo "\"";
                        echo $row['wifi_machine_name'];
                        echo "\"";
                        echo " value=";
                        echo "\"";
                        echo $row['wifi_machine_name'];
                        echo "\"";
                        echo ">";
                        echo "\n"; 
                        $i++;
                    }
                ?>
            </div>
        </form>
    </main>
<?php
    require __DIR__ . '\footer.php';
?>