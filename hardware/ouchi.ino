/*  ___   ___  ___  _   _  ___   ___   ____ ___  ____  
 * / _ \ /___)/ _ \| | | |/ _ \ / _ \ / ___) _ \|    \ 
 *| |_| |___ | |_| | |_| | |_| | |_| ( (__| |_| | | | |
 * \___/(___/ \___/ \__  |\___/ \___(_)____)___/|_|_|_|
 *                  (____/ 
 * Osoyoo Wifi IoT  lesson 2
 * Remote control LED over UDP
 * tutorial url: https://osoyoo.com/?p=10000
 */

#include "WiFiEsp.h"
#include "WiFiEspUdp.h"
#include "SoftwareSerial.h"
#define ledPin 13
#define buzzer 9  //buzzer connect to D9
#define pullupSwitch 7
SoftwareSerial softserial(4, 5); // A9 to ESP_TX, A8 to ESP_RX by default
char ssid[] = "TP-LINK_8A3C";            // your network SSID (name)
char pass[] = "30960961";        // your network password
int status = WL_IDLE_STATUS;     // the Wifi radio's status
WiFiEspUDP Udp;
unsigned int localPort = 8888;              // local port to listen on
char packetBuffer[5];
 
void setup() {
  //pinMode Configration
  pinMode(ledPin,OUTPUT);
  pinMode(buzzer, OUTPUT);
  pinMode(pullupSwitch, INPUT_PULLUP);
  digitalWrite(buzzer,HIGH);

  Serial.begin(9600);   // initialize serial for debugging
    softserial.begin(115200);
  softserial.write("AT+CIOBAUD=9600\r\n");
  softserial.write("AT+RST\r\n");
  softserial.begin(9600);    // initialize serial for ESP module
  WiFi.init(&softserial);    // initialize ESP module

  // check for the presence of the shield:
  if (WiFi.status() == WL_NO_SHIELD) {
    Serial.println("WiFi shield not present");
    // don't continue:
    while (true);
  }

  // attempt to connect to WiFi network
  while ( status != WL_CONNECTED) {
    Serial.print("Attempting to connect to WPA SSID: ");
    Serial.println(ssid);
    // Connect to WPA/WPA2 network
    status = WiFi.begin(ssid, pass);
  }
  
  Serial.println("Connected to wifi");
  printWifiStatus();
 
  // if you get a connection, report back via serial:
  Udp.begin(localPort);
  
  Serial.print(" target port ");
  Serial.println(localPort);
     
}
 
void loop() {
  int pullupSwitch_value = digitalRead( pullupSwitch );//test
  int ledPin_value = digitalRead( ledPin );//test
  
  int packetSize = Udp.parsePacket();
  if (packetSize) {                               // if you get a client,
     Serial.print("Received packet of size ");
    Serial.println(packetSize);
    int len = Udp.read(packetBuffer, 255);
    if (len > 0) {
      packetBuffer[len] = 0;
    }
      char c=packetBuffer[0];
      switch (c)    //serial control instructions
      {  
 
        case 'F': 
        digitalWrite(ledPin, HIGH); //TURN ON LED
        digitalWrite(buzzer,LOW); //buzzer ON
        break;
        
        case 'G':
        digitalWrite(ledPin, LOW); //TURN OFF LED
        digitalWrite(buzzer,HIGH);//buzzer OFF
        break;
 
        default:break;
      }
    }
  
  if(pullupSwitch_value == LOW && ledPin_value == HIGH){
    digitalWrite(ledPin,LOW); //TURN OFF LED
    digitalWrite(buzzer,HIGH);//buzzer OFF
  }
    
}

void printWifiStatus()
{
  // print the SSID of the network you're attached to
  Serial.print("SSID: ");
  Serial.println(WiFi.SSID());

  // print your WiFi shield's IP address
  IPAddress ip = WiFi.localIP();
  Serial.print("IP Address: ");
  Serial.println(ip);
  
  // print where to go in the browser
  Serial.println();
  Serial.print("please set your UDP APP target IP to: ");
  Serial.print(ip);
 
}
