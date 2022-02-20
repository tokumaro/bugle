## bugle
 
ブラウザ上でwifi子機とリアルタイムでの相互通信を実現するシステムです。  

## Process Flow

![bugle drawio](https://user-images.githubusercontent.com/85043482/152045992-f8093d1c-ee1b-4fdc-811f-9c697a72fdaa.png)

## フォルダ構成

```
bugle
├─hardware                ハードウェアに対してコンパイルするプログラミングです。
│  └─wifi
│          wifi.ino         arduinoマイコンボードによって実装しました。こちらのファイルをコンパイルします。
│
└─server                  サーバ側に設置するフォルダです。index.phpをapacheのDocummentrootとします。
    │  index.php            ホームとなるページです。
    │  style.css
    │
    ├─bin
    │      chat-server.php  サーバにて常時稼働させるハンドラです。phpコマンドにて実行してください。
    │      udp-socket.php   udpにてwifi子機と通信するためのハンドラです。phpコマンドにて実行してください。
    │
    └─src
    │   └─Chat.php          bin\chat-server.phpで受信したwebsocketデータを処理するプログラムです。
    │
    └─vendor         phpライブラリであるRatchetを利用させて頂いております。ratchet(https://github.com/ratchetphp/Ratchet)
```
        
## Note
 
パッケージ管理システムであるcomposerのratchetを利用してプログラムを構築しています。  
  ・公式ドキュメント : https://github.com/ratchetphp/Ratchet  
  ・github : https://github.com/ratchetphp/Ratchet  
  ・license : https://github.com/ratchetphp/Ratchet/blob/master/LICENSE 
    
アプリケーションとして機能するようプログラミングされているのみで、セキュリティに関しては考慮しておりません。  
なのでapacheやマシンなどで公開する範囲をローカルネットワークに抑える必要があります。

## Author

* 作成者：tokumaro
* リンク：https://tokumaro.com/
