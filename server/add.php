<?php
    require __DIR__ . '\header.php';
?>
<?php
    session_start();

    // 二重送信防止用トークンの発行
    $token = uniqid('', true);;

    //トークンをセッション変数にセット
    $_SESSION['token'] = $token;
?>
    <main>
        <form action="index.php" method="post" class="Registration">
            <input type="hidden" name="command" value="insert <?php echo $token;?>">

            <label class="input-form-label">IPアドレス</label>
            <input type="text" name="ipaddress" class="input-form" placeholder="ipアドレス">

            <label class="input-form-label">NAME</label>
            <input type="text" name="name" class="input-form" placeholder="呼び出す部屋名など...">
            
            <input type="submit" value="追加" class="input-form">
        </form>
    </main>
<?php
    require __DIR__ . '\footer.php';
?>