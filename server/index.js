// var conn = new WebSocket('ws://localhost:8080');
var conn = new WebSocket('ws://192.168.0.119:8081');
let callflg = 0;
conn.onopen = function(e) {//引数eにてイベントオブジェクトを取得
    console.log("Connection established!");
};

conn.onmessage = function(e) {//サーバからの送信受信時処理
    let splitStr = e.data.split(' ');
    let EventObject;
    console.log(splitStr[0],"からデータ受信");
    ipaddress = splitStr[0];
    for(i=0; i < settingwifiitems.length; i++){
        if(settingwifiitems[i].name == ipaddress){
            EventObject = settingwifiitems[i];
            EventObject.classList.toggle('send-signal');
            EventObject.textContent = EventObject.wifi_machine_name;
            if(splitStr[1] == "STOP"){
                EventObject.classList.toggle('stop-response');
                EventObject.textContent = "反応しました";
                EventObject.sendflg = 0;
                setTimeout(function(){
                EventObject.classList.toggle('stop-response');
                EventObject.textContent = EventObject.wifi_machine_name;
                }, 5000);
            }else if(splitStr[1] == "NON"){
                EventObject.classList.toggle('non-response');
                EventObject.textContent = "反応なし";
                EventObject.sendflg = 0;
                setTimeout(function(){
                EventObject.classList.toggle('non-response');
                EventObject.textContent = EventObject.wifi_machine_name;
                }, 5000);
            }
        } 
    }
};

function bugle(e){
    let ipaddress = e.target.name;
    let SplitClassName = e.target.className.split(' ');//イベントが発生した要素のクラスを配列にして取得
    SplitClassName.forEach(element => {//イベントが発生した要素のwifiクラス名のみ取得
        if(element.search(/wifi/)!== -1){
            wificlassname = element;
        }
    });
    let cssbutton = document.getElementsByClassName(wificlassname)[0]; //イベントが発生したwifiクラスを取得
    for(i=0;i < settingwifiitems.length;i++){
        if(settingwifiitems[i] == cssbutton){
            if(settingwifiitems[i].sendflg == 0){//呼出し命令が未実施であれば呼出実施
                settingwifiitems[i].sendflg = 1;
                conn.send(concatenation([ipaddress,",F"]));//ipaddress/F or G
                CSSButtonImageChange(e);
                break;
            }else if(settingwifiitems[i].sendflg == 1){//呼出し命令が実施済であれば呼出停止
                settingwifiitems[i].sendflg = 0;
                conn.send(concatenation([ipaddress,",G"]));
                CSSButtonImageChange(e);
                break;
            }
        }
    }

}

function concatenation(segments){
    let sumLength = 0;
    for(let i = 0; i < segments.length; ++i){
        if(i == 0){
            sumLength = segments[i];
        }else{
            sumLength += segments[i];
        }
    }
    return sumLength;
}

function staticwifiitems(){
    let cssbutton = document.getElementsByClassName("buglebutton");
    for(i=0;i<cssbutton.length;i++){
        cssbutton[i].wifi_machine_name = cssbutton[i].textContent;
        cssbutton[i].sendflg = 0;
    }
    return cssbutton;
}
const settingwifiitems = staticwifiitems();

function CSSButtonImageChange(e){
    let wificlassname;
    let wifi_machine_name;
    let SplitClassName = e.target.className.split(' ');//イベントが発生した要素のクラスを配列にして取得
    SplitClassName.forEach(element => {//イベントが発生した要素のwifiクラス名のみ取得
        if(element.search(/wifi/)!== -1){
            wificlassname = element;
        }
    });
    let cssbutton = document.getElementsByClassName(wificlassname)[0]; //イベントが発生したwifiクラスを取得
    for(i=0;i < settingwifiitems.length;i++){
        if(settingwifiitems[i] == cssbutton){
            wifi_machine_name = settingwifiitems[i].wifi_machine_name;
            if(settingwifiitems[i].sendflg == 1){//呼出実施時
                cssbutton.classList.toggle('send-signal');
                cssbutton.textContent = "送信中";
            }else if(settingwifiitems[i].sendflg == 0){//呼出停止時
                cssbutton.classList.toggle('send-signal');
                cssbutton.textContent = wifi_machine_name;
            }
        }
    }
}

function add(){
    swal('アラートが実行されました!');
}

const setFillHeight = () => {
    const vh = window.innerHeight * 0.01;
    document.documentElement.style.setProperty('--vh', `${vh}px`);
  }
  
  // 画面のサイズ変動があった時に高さを再計算する
  window.addEventListener('resize', setFillHeight);
  
  // 初期化
  setFillHeight();