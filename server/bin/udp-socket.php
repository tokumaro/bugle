<?php
	class packet_format{
		public $type;
		public $message;
		public $recv_date;
	}
	
    error_reporting(E_ALL | E_STRICT);
    echo "プログラミング スタート";
	$recv_data = new packet_format;
	$port = 5051;

	//UDPのソケット作成
	$sock = socket_create(AF_INET,SOCK_DGRAM,SOL_UDP);
	socket_bind($sock,'192.168.0.119',$port);
	$from = '';
    $port = 0;
	// while(true){
		//socket_recvfrom()にてUDPのソケットを受信
        //$bufにデータを取得
        echo "プログラミング 2";
		socket_recvfrom($sock,$buf,12,0,$from,$port);
        echo "プログラミング 3";
        // echo sprintf($buf);
		//バイナリで取得しているため、unpackでデータを取得
		// $packet_data = unpack("Stype/Smessage/ITimestamp",$buf);
        
        echo "リモートアドレス $from のポート $port から $buf を受信しました。" . PHP_EOL;
	// }
	//lose socket
	socket_close($sock);
    socket_close($socket);
?>