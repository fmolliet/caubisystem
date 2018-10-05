#include <DFRobot_sim808.h>
#include <SoftwareSerial.h>
#include <Adafruit_Sensor.h>
#include <DHT.h>
#include <TimeAlarms.h>

#define DHTONE 39
#define DHTTWO 40
#define DHTTRE 42
#define DHTTYPE DHT22

#define PIN_TX    10
#define PIN_RX    11
#define PIN_DR    A0

#define pinoSensor A15

DHT dht(DHTONE, DHTTYPE);
DHT dht2(DHTTWO, DHTTYPE);
DHT dht3(DHTTRE, DHTTYPE);

float t = 0, h = 0;



const char APPKEY[] = 'c4ca4238a0b923820dcc509a6f75849b';
const char MACID[] = 'C0000001';

char buff_h1[6];
char buff_t1[6];

char lat[12];
char lon[12];

SoftwareSerial mySerial(PIN_TX, PIN_RX);
DFRobot_SIM808 sim808(&mySerial);//Connect RX,TX,PWR,
char http_cmd[180] = "";
//char http_cmd[] = "GET /rest/view/event.php?appkey=c4ca4238a0b923820dcc509a6f75849b&type=normal&mac_id=C0000001&stemp=2.0&hum=35.0&eng=10&dtemp=14.3 HTTP/1.1\r\nHost: 179.208.244.198:8080\r\n\r\n";
char buffer[512];


void getTemp(){
  t = dht.readTemperature();
  delay(2000);
  t += dht2.readTemperature();
  delay(2000);
  t += dht3.readTemperature();
  delay(2000);
  t = t/3;
}

void getHum(){
  h = dht.readHumidity();
  delay(2000);
  h += dht2.readHumidity();
  delay(2000);
  h += dht3.readHumidity();
  delay(2000);
  h = h/3;
}

void updateSensorsData(){
  delay(500);
  dtostrf(h,5, 2, buff_h1);
  dtostrf(t,5, 2, buff_t1);
  delay(500);
}

void getLocation(){
  float la = sim808.GPSdata.lat;
  float lo = sim808.GPSdata.lon;
  dtostrf(la, 6, 2, lat); 
  dtostrf(lo, 6, 2, lon);
}



void setup()
{
  mySerial.begin(9600);
  Serial.begin(9600);
  delay(1000);
  Serial.println("[INFO]: INICIADO");
  dht.begin();
  pinMode(pinoSensor, INPUT); 
  Serial.print("1");
  lcd.begin(16, 2);
  mySerial.println("DEL ALL\"");
  delay(500);
  pinMode(PIN_DR, INPUT);

  while (!sim808.init())
  {
    Serial.print("[ERROR]: Erro ao inicar o SIM808\r\n");
    delay(1000);
  }
  Serial.println("[INFO]: SIM808 iniciado");

  //Tenta conectar na internet
  while (!sim808.join(F("cmnet"))) {
    Serial.println("[ERROR]: Falha ao entrar na conexão do SIM808");
    delay(1000);
  }

  if( sim808.attachGPS())
      Serial.println("[INFO]: Sucesso ao ligar o GPS");
  else 
      Serial.println("[ERROR]: Falha ao ligar o GPS");

  while(!sim808.getGPS())
  {
    Serial.println("[ERROR]: Falha ao buscar localização GPS do SIM808");
    delay(1000);
  }
  
  /* Debug de IP
  Serial.println("[INFO]: SIM808 Conectado a internet");
  Serial.print("[INFO]: O endereço IP é: ");
  Serial.println(sim808.getIPAddress());
  */

  // Verifica o IP do REST
  if (!sim808.connect(TCP, "179.208.244.198", 8080)) {
    Serial.println("[ERROR]: Conexao com erro");
  } else {
    Serial.println("[INFO]: Connectado com o rest com sucesso");
  }

  Serial.println("[INFO]: Inicialização Finalizada com sucesso!");

  getTemp();
  getHum();
  updateSensorsData();
  Serial.println("[TESTE]: Teste de envio de dados ...");
  sprintf(http_cmd, "GET /rest/view/event.php?appkey=%s&type=normal&mac_id=%s&stemp=%s&hum=%s&eng=10&dtemp=%s HTTP/1.1\r\nHost: 179.208.244.198:8080\r\n\r\n",APPKEY,MACID, buff_t1, buff_h1, buff_t1);
  sim808.send(http_cmd, sizeof(http_cmd) - 1);
  Serial.println("[TESTE]: Fim do teste ...");
  /* DEBUG DE RETORNO DO BUFFER
  while (true) {
    int ret = sim808.recv(buffer, sizeof(buffer) - 1);
    if (ret <= 0) {
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
  //sim808.close();
  //sim808.disconnect();

}
int status_anterior = 1;

void loop() {
  //fica gerando novas leituras de dados
  getTemp();
  getHum();
  delay(500);
  Serial.println(t);
  Serial.println(h);
  updateSensorsData();
  // pode armazenar os dados em uma nova função com vetor
  
    /*
    int status_atual = digitalRead(PIN_DR);
    if (status_anterior == 1 && status_atual == 0) {    // se estÃ¡ aberta...

    }
    else if (status_anterior == 0 && status_atual == 1) { // se estÃ¡ fechada...

    }
    status_anterior = status_atual;
    */
  if (digitalRead(pinoSensor) == LOW){
    //GERA ALERTA ao cair energia
  } 
  // chama a função a cada 15 minutos
  Alarm.timerRepeat(900, func_send);
  sim808.detachGPS();
  //sim808.close();
  //sim808.disconnect();
}

void func_send(){
  // Limpa o buffer antes de enviar
  mySerial.println("DEL ALL\"");
  getTemp();
  getHum();
  updateSensorsData();
  delay(500);
  sprintf(http_cmd, "GET /rest/view/event.php?appkey=%s&type=normal&mac_id=%s&stemp=%s&hum=%s&eng=10&dtemp=%s HTTP/1.1\r\nHost: 179.208.244.198:8080\r\n\r\n",APPKEY,MACID, buff_t1, buff_h1, buff_t1);
  sim808.send(http_cmd, sizeof(http_cmd) - 1);
}

void func_alert(char msg[]){
  // Limpa o buffer antes de enviar
  mySerial.println("DEL ALL\"");
  getTemp();
  getHum();
  updateSensorsData();
  delay(500);
  // get para enviar alerta
  //sprintf(http_cmd, "GET /rest/view/event.php?appkey=%s&type=normal&mac_id=%s&stemp=%s&hum=%s&eng=10&dtemp=%s HTTP/1.1\r\nHost: 179.208.244.198:8080\r\n\r\n",APPKEY,MACID, buff_t1, buff_h1, buff_t1);
  sim808.send(http_cmd, sizeof(http_cmd) - 1);
}

void apresentacao()
{
    //lcd.clear();
    lcd.setCursor(4, 0);
    lcd.print("CAUBI");
    lcd.setCursor(3, 1);
    lcd.print("SYSTEM");
    delay(2000);
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

