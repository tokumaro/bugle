## bugle
 
ブラウザ上でwifi子機とリアルタイムでの相互通信を実現するシステムです。  
※現在子機からの通信をサーバが正しく受信できておらず、完成には至っていません。

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
    │  composer.json        websocket通信実現のため、composerのPHPライブラリ「ratchet」を利用させていただいております。serverディレクトリにてcomposerを実行してください。
    │  index.php            ホームとなるページです。※未完成
    │  style.css
    │
    ├─bin
    │      chat-server.php  サーバにて常時稼働させるハンドラです。phpコマンドにて実行してください。
    │      udp-socket.php   udpにてwifi子機と通信するためのハンドラです。phpコマンドにて実行してください。※未完成
    │
    └─src
        └─Chat.php          bin\chat-server.phpで受信したwebsocketデータを処理するプログラムです。
```
        
## Note
 
※未完成であるため、実装はできません。  
パッケージ管理システムであるcomposerのratchetを利用してプログラムを構築しています。著作権の観点からリポジトリには組み込まれていません。実装にライブラリは必須となりますのでインストールをしてください。  
アプリケーションとして機能するようプログラミングされているのみで、セキュリティに関しては考慮しておりません。  
なのでapacheやマシンなどで公開する範囲をローカルネットワークに抑える必要があります。

## Author

* 作成者：tokumaro
* リンク：https://tokumaro.com/
