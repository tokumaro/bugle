<?php
    // $socket = socket_create(AF_INET,SOCK_DGRAM,SOL_UDP);

    // if (isset($_POST['on'])){
    //     $msg = "F";
    //     $len = strlen($msg);
    //     socket_sendto($socket,$msg,$len,0,'192.168.0.106',8888);
    // }else if(isset($_POST['off'])){
    //     $msg = "G";
    //     $len = strlen($msg);
    //     socket_sendto($socket,$msg,$len,0,'192.168.0.106',8888);
    // }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>welcome remote system!!</title>
</head>
<body>
    <div class="title-str">Success, welcome remote system!! PHP</div>
    <!-- <form action="index.php" method="post">
    <button type="submit" name="on">on</button>
    <button type="submit" name="off">off</button>
    </form> -->
    <input type="button" value="on" onclick="ledon()">
    <input type="button" value="off" onclick="ledoff()">

    <script type="text/javascript">
        var conn = new WebSocket('ws://localhost:8080');
        conn.onopen = function(e) {
            console.log("Connection established!");
        };
        
        function ledon(){
            conn.send("F");
        }
        function ledoff(){
            conn.send("G");
        }
        // conn.onmessage = function(e) {
        //     console.log(e.data);
        // };
    </script>

</body>
</html>
