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
    echo 'swal("変更したい設定箇所を変更し、「実行」ボタンを押してください。");';
    echo '}';
    echo 'add();';
    echo '</script>';
?>
    <main>
        <table class="setting_change_table">
            <tr>
            <th>ID</th>
            <th>設定名</th>
            <th>ipアドレス</th>
            <th>変更を実施</th>
            </tr>
            <form action="index.php" method="post" class="Registration">
                <input type="hidden" name="command" value="update <?php echo $token;?>">
            <!-- <input type="text" name="ipaddress" class="input-form" placeholder="ipアドレス"> -->
                <div class="bugletrigger">
                    <?php
                        $i = 1;
                        $pdo = new PDO('mysql:host=localhost;dbname=bugle;charset=utf8','staff','password');
                        foreach($pdo->query('select * from wifi_machine') as $row){
                            echo '<tr>';

                            echo "<input type='hidden' class='wifi$i' name=";
                            echo "\"";
                            echo "id";
                            echo "\"";
                            echo " value=";
                            echo "\"";
                            echo $row['id'];
                            echo "\"";
                            echo ">";

                            echo '<td>';
                            echo $row['id'];
                            echo '</td>';

                            echo '<td>';
                            echo "<input type='text' class='wifi$i' name=";
                            echo "\"";
                            echo "wifi_machine_name";
                            echo "\"";
                            echo " value=";
                            echo "\"";
                            echo $row['wifi_machine_name'];
                            echo "\"";
                            echo ">";
                            echo '</td>';
                            
                            echo '<td>';
                            echo "<input type='text' class='wifi$i' name=";
                            echo "\"";
                            echo "ip_address";
                            echo "\"";
                            echo " value=";
                            echo "\"";
                            echo long2ip($row['ip_address']);
                            echo "\"";
                            echo ">";
                            echo '</td>';

                            echo '<td class="change_submit">';
                            echo "<input type='submit' class='change_submit' name=";
                            echo "\"";
                            echo "button";
                            echo "\"";
                            echo " value=";
                            echo "\"";
                            echo "実行";
                            echo "\"";
                            echo ">";
                            echo '</td>';

                            echo '<tr>';
                            echo "\n"; 
                            $i++;
                        }
                    ?>
                </div>
            </form>
            </tr>
        </table>
    </main>
<?php
    require __DIR__ . '\footer.php';
?>