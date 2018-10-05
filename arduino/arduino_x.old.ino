#include <DFRobot_sim808.h>
#include <SoftwareSerial.h>
#include <Adafruit_Sensor.h>
#include <DHT.h>

#define DHTONE 38
#define DHTTWO 40
#define DHTTRE 42
#define DHTTYPE DHT22 


#define PIN_TX    10
#define PIN_RX    11
#define PIN_DR    A0


const char APPKEY[] = 'c4ca4238a0b923820dcc509a6f75849b';
const char MACID[] = 'C0000001';


//Tutorial DHT22 https://www.filipeflop.com/blog/estacao-meteorologica-com-arduino/
//DHT dht(DHTPIN, DHTTYPE);
DHT dht_one(DHTONE, DHTTYPE);
DHT dht_two(DHTTWO, DHTTYPE);
DHT dht_tre(DHTTRE, DHTTYPE);


// Verificar as pinagens https://www.filipeflop.com/blog/controlando-um-lcd-16x2-com-arduino/
// https://playground.arduino.cc/Main/LiquidCrystal
//LiquidCrystal lcd(<pino RS>, <pino enable>, <pino D4>, <pino D5>, <pino D6>, <pino D7>); 


SoftwareSerial mySerial(PIN_TX,PIN_RX);
DFRobot_SIM808 sim808(&mySerial);
//char http_cmd[] = "GET /rest/view/event.php?appkey=c4ca4238a0b923820dcc509a6f75849b&type=normal&mac_id=C0000001&stemp=14.0&hum=50.0&eng=10&dtemp=14.3 HTTP/1.1\r\nHost: 179.208.244.198:8080\r\n\r\n";
char buffer[512];

float getTemp()
{
    float t = dht_one.readTemperature();
    //t += dht.readTemperature();
    //t += dht.readTemperature();
    delay(4000);
    return t;
}

float getHum()
{
    float h = dht_one.readHumidity();
    // h += dht.readHumidity();
    //h += dht.readHumidity();
    delay(4000);
    return h;
}

  
void setup() {
  mySerial.begin(9600);
  Serial.begin(9600);
  //dht.begin();
  dht.begin();
  //dhr.begin();
  lcd.begin(16, 2);
  apresentacao();
    // pino de entrada para porta
  pinMode(PIN_DR, INPUT);


  while(!sim808.init()) {
      Serial.print("[ERROR]: Erro na Inicialização do SIM808\r\n");
      delay(1000);
    }
    delay(2000);  
   //Tenta conectar na internet
    while(!sim808.join(F("cmnet"))) {
      Serial.println("[ERROR]: Falha ao entrar na conexão do SSIM808");
      delay(2000);
    }
    
    Serial.print("O endereço IP é: ");
    Serial.println(sim808.getIPAddress()); 
    
    if(!sim808.connect(TCP,"179.208.244.198", 8080)) {
      Serial.println("[ERROR]: Conexao com erro");
    }else{
      Serial.println("Connectado com o rest com sucesso");
    }
    delay(2000);
    
    Serial.println("Aguardando retorno ...");
    sim808.send(http_cmd, sizeof(http_cmd)-1);
    /* DEBUG De RETORNO
    while (true) {
        int ret = sim808.recv(buffer, sizeof(buffer)-1);
        if (ret <= 0){
            Serial.println("fetch over...");
            break; 
        }
        buffer[ret] = '\0';
        Serial.print("Recv: ");
        Serial.print(ret);
        Serial.print(" bytes: ");
        Serial.println(buffer);
        break;
    }
    */
    sim808.close();
    sim808.disconnect();
    
}

int status_anterior = 1;

void loop() {
    /*
    int status_atual = digitalRead(PIN_DR);
    if (status_anterior == 1 && status_atual == 0) {    // se está aberta...

    }
    else if (status_anterior == 0 && status_atual == 1) { // se está fechada...

    }
    status_anterior = status_atual;
    */
   Serial.println(getHum());
   Serial.println(getTemp());
    delay(3000);
 
}


void normal_env(char appkey[], char type[], char machine_id[]){
    char url[] = "GET /rest/view/event.php?appkey=";
    //strcpy( url1, url);
    strcat( url, appkey);
    strcat( url, "&type=");   
    strcat( url, type);  
    strcat( url, "&mac_id=");
    strcat( url, machine_id); 
    strcat( url, "&stemp=");   
    strcat( url, String(4.6) );
    strcat( url, "&hum=");   
    strcat( url, String(42) );
    strcat( url, "&eng=");   
    strcat( url, String(0.500) );
    strcat( url, "&dtemp=");   
    strcat( url, String(5.5) );
    //FINALIZA
    strcat( url, " HTTP/1.1\r\nHost: 179.208.244.198:8080\r\n\r\n");  

    //GET &stemp=14.0&hum=50.0&eng=10&dtemp=14.3";
    return url;
}

void apresentacao()
{
    //lcd.clear();
    lcd.setCursor(4, 0);
    lcd.print("CAUBI");
    lcd.setCursor(3, 1);
    lcd.print("SYSTEM :3");
    delay(20000);
    lcd.clear();
}

void lcdStatus(char lineone[], char linetwo[])
{
    lcd.clear();
    // Setting up the LCD screen
    lcd.clrScr(); // Clear the screen buffer
    //lcd.drawBitmap(0,0, temperatureIcon, 84, 48); // Drawing the Temperature icon
    x = strlen(lineone);
    lcd.setCursor(2, 0);
    lcd.print(lineone);
    lcd.setCursor(2, 1);
    lcd.print(linetwo);
}
