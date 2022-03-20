<?php

function udpsocket_loop(){
        //ここでデータベースの値であるブラウザからの送信状態を読み取って、送信をしている場合処理実行

	    $pdo =new PDO('mysql:host=localhost;dbname=bugle;charset=utf8','staff','password');
		
	    error_reporting(E_ALL | E_STRICT);
	    $udp_port = 5051;
   
	    //UDPのソケット作成
	    $udp_socket = socket_create(AF_INET,SOCK_DGRAM,SOL_UDP);
	    socket_bind($udp_socket,'****',$udp_port);

	//socket_set_nonblock($udp_socket);//socket_recvfrom()にてノンブロッキングでudp受信
	    echo("データ受信開始 : ");
	    while(true){

		    //socket_recvfrom()にてUDPのソケットを受信
		    socket_recvfrom($udp_socket,$udp_buf,50,0,$wifi_from,$wifi_port);
			echo "リモートアドレス $wifi_from のポート $wifi_port から $udp_buf を受信" . PHP_EOL;

			$sql = $pdo->prepare('update wifi_machine set client_status=? where INET_NTOA(ip_address) = ?');
			// $sql->execute(["呼出停止",$wifi_from]);//データベースに呼出停止フラグ格納
		    foreach($pdo->query('select * from wifi_machine') as $row){
				if(long2ip($row['ip_address']) == $wifi_from && $udp_buf == "STOP"){
					if($row['client_status'] == "呼出要求"){
						$sql->execute(["停止要求",$wifi_from]);
						echo($wifi_from . " より停止要求". PHP_EOL. PHP_EOL);
					}
					break;
				}else if(long2ip($row['ip_address']) == $wifi_from && $udp_buf == "NON"){
					if($row['client_status'] == "呼出要求"){
						$sql->execute(["応答無",$wifi_from]);
						echo($wifi_from . " より応答無". PHP_EOL. PHP_EOL);
					}
					break;
				}
			}

		   $wifi_from = "";
		   $wifi_port = "";
		   $udp_buf = "";
		   echo("次のudpデータ受信開始 : ");
	    }

	    //lose socket
	    socket_close($udp_socket);
   
}

udpsocket_loop();

?>