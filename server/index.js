// var conn = new WebSocket('ws://localhost:8080');
var conn = new WebSocket('ws://192.168.0.119:8081');
let callflg = 0;
conn.onopen = function(e) {//引数eにてイベントオブジェクトを取得
    console.log("Connection established!");
};

conn.onmessage = function(e) {
    console.log(e.data,"からデータ受信");
    ipaddress = e.data;
    for(i=0; i < settingwifiitems.length; i++){
        if(settingwifiitems[i].name == ipaddress){
            settingwifiitems[i].style.transform = "";
            settingwifiitems[i].style.background = "";
            settingwifiitems[i].style.color = "";
            settingwifiitems[i].style.opacity = "";
            settingwifiitems[i].textContent = settingwifiitems[i].wifi_machine_name;
        } 
    }
};

function bugle(e){
    let ipaddress = e.target.name;
    if(callflg == 0){//呼出し命令が未実施であれば呼出実施
        callflg = 1;
        conn.send(concatenation([ipaddress,",F"]));//ipaddress/F or G
        CSSButtonImageChange(e,callflg);
    }else if(callflg == 1){//呼出し命令が実施済であれば呼出停止
        callflg = 0;
        conn.send(concatenation([ipaddress,",G"]));
        CSSButtonImageChange(e,callflg);
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

function CSSButtonImageChange(e,callflg){
    let wificlassname;
    let wifi_machine_name;
    let SplitClassName = e.target.className.split(' ');//イベントが発生した要素のクラスを配列にして取得
    SplitClassName.forEach(element => {//イベントが発生した要素のwifiクラス名のみ取得
        if(element.search(/wifi/)!== -1){
            wificlassname = element;
        }
    });
    let cssbutton = document.getElementsByClassName(wificlassname)[0];
    for(i=0;i < settingwifiitems.length;i++){
        if(settingwifiitems[i] == cssbutton){
            wifi_machine_name = settingwifiitems[i].wifi_machine_name;
        }
    }
    if(callflg == 1){//呼出実施時
        cssbutton.style.transform = "scale(0.7,0.7)";
        cssbutton.style.backgroundColor = "#FF82B2";
        cssbutton.style.color = "#fff";
        cssbutton.style.opacity = "0.3";
        cssbutton.textContent = "送信中";
    }else if(callflg == 0){//呼出停止時
        cssbutton.style.transform = "";
        cssbutton.style.background = "";
        cssbutton.style.color = "";
        cssbutton.style.opacity = "";
        cssbutton.textContent = wifi_machine_name;
    }else if(callflg = 2){//wifi子機応答時

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