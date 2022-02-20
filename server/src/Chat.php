<?php
namespace MyApp;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use \PDO;

class Chat implements MessageComponentInterface {
    protected $clients;
    public $send_from;
 
    public function __construct() {
        $this->clients = new \SplObjectStorage;
        $this->send_from = 0;
        $this->test = 0;
    }
 
    public function onOpen(ConnectionInterface $conn) {
        // Store the new connection to send messages to later
        $this->clients->attach($conn);
 
        echo "New connection! ({$conn->resourceId})\n";
    }
 
    public function onMessage(ConnectionInterface $from, $msg) {
        $numRecv = count($this->clients) - 1;
        // echo sprintf('Connection %d sending message "%s" to %d other connection%s' . "\n"
        //     , $from->resourceId, $msg, $numRecv, $numRecv == 1 ? '' : 's');
            
            $this->send_from = $from; //ローカル関数udpstatus_loop()用に送信用オブジェクトをストックする。
            $pieces = explode(",",$msg);//クライアントから送信されたメッセージを分解して格納する。
            
            $pdo = new PDO('mysql:host=localhost;dbname=bugle;charset=utf8','staff','password');
            $sql = $pdo->prepare('update wifi_machine set client_status=? where INET_NTOA(ip_address) = ?');
            if($pieces[1] == "F"){
                $sql->execute(["呼出要求",$pieces[0]]);//データベースに呼出要求中フラグ格納
            }else if($pieces[1] == "G"){
                $sql->execute(["取消要求",$pieces[0]]);//データベースに呼出要求中フラグ格納
            }

            foreach($pdo->query('select * from wifi_machine') as $row){
                if(long2ip($row['ip_address']) == $pieces[0] && ($row['client_status'] == "呼出要求" or $row['client_status'] == "取消要求")){
                    echo("webブラウザから " . long2ip($row['ip_address']). " に " . $row['client_status'] . PHP_EOL . PHP_EOL);
                    break;
                }
            }

        if ($pieces[1] == "F" || $pieces[1] == "G"){
            $socket = socket_create(AF_INET,SOCK_DGRAM,SOL_UDP);
            $len = strlen($pieces[1]);//クライアントからの実送信メッセージ格納
            socket_sendto($socket,$pieces[1],$len,0,$pieces[0],8888);
        }
        $pdo = null;
    }
 
    public function onClose(ConnectionInterface $conn) {
        // The connection is closed, remove it, as we can no longer send it messages
        $this->clients->detach($conn);
 
        echo "Connection {$conn->resourceId} has disconnected\n";
    }
 
    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "An error has occurred: {$e->getMessage()}\n";
 
        $conn->close();
    }

    public function udpstatus_loop(){
        $pdo =new PDO('mysql:host=localhost;dbname=bugle;charset=utf8','staff','password');
        $sql = $pdo->prepare('update wifi_machine set client_status=? where INET_NTOA(ip_address) = ?');
        foreach($pdo->query('select * from wifi_machine') as $row){
            if($row['client_status'] == "停止要求"){
                $this->send_from->send(long2ip($row['ip_address']));
                $sql->execute([null,long2ip($row['ip_address'])]);
                echo("クライアントからの次操作受信開始" . PHP_EOL);
            }
        }
        $pdo = null;
    }

}