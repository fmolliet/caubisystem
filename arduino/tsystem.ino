#include "SIM900.h"
#include <SoftwareSerial.h>
#include "inetGSM.h"
#include "DHT.h"

#define DHTPIN 2  // PRECISA MUDAR DEPOIS
#define DHTTYPE DHT22 
#define APPKEY '' // Colocar APPKEY

//Tutorial DHT22 https://www.filipeflop.com/blog/estacao-meteorologica-com-arduino/
DHT dht(DHTPIN, DHTTYPE);

// Verificar as pinagens https://www.filipeflop.com/blog/controlando-um-lcd-16x2-com-arduino/
// https://playground.arduino.cc/Main/LiquidCrystal
LiquidCrystal lcd(<pino RS>, <pino enable>, <pino D4>, <pino D5>, <pino D6>, <pino D7>); 


InetGSM inet;

char inSerial[50];
int i=0;
boolean started=false;

void setup()
{
    // Inicia seriais
    Serial.begin(9600);
    // Inicia lcd
    lcd.begin(16, 2);
    apresentacao();
    // Inicia DHT
    dht.begin();
    Serial.println("DHT22 INIC");
    
    lcdStatus("DHT22 INIC");
    Serial.println("Testando Shield GSM.");
    lcdStatus("GSM INIC");
    if (gsm.begin(2400)) {
        Serial.println("\nstatus=PRONTO");
        lcdStatus("GSM READY");
        started=true;
    } 
    else {
        Serial.println("\nstatus=IDLE");
        lcdStatus("GSM IDLE");
    }

    delay(2000);

    if(started) {
        if (inet.attachGPRS("internet.wind", "", ""))
            Serial.println("status=ATTACHED");
        else 
            Serial.println("status=ERROR");

        delay(1000);

        gsm.SimpleWriteln("AT+CIFSR");
        delay(5000);
        gsm.WhileSimpleRead();
     }
};

void loop()
{
    Serial.println(acessaSite(montaURL(APPKEY,'normal')));
};


/////////////////////
////// FUNÇÕES //////
/////////////////////

char acessaSite(char url[500])
{
    char msg[50];
    int numdata;
    numdata=inet.httpGET("http://nextrest.hopto.org", 8080, url, msg, 50);
    return msg;
}

float getTemp()
{
    delay(2000);
    float t = dht.readTemperature();
    return t;
}

float getHum()
{
    delay(1000);
    float h = dht.readHumidity();
    return h;
}

/* Exemplo concat de URL */
char montaURL(char appkey[33],char type[16])
{
    //url1[0]=0;
    char url[500] = "/rest/insdata.php?appkey=";
    //strcpy( url1, url);
    strcat( url, appkey);
    strcat( url, "&type=");   
    strcat( url, type);        
    strcat( url, "&stemp=");   
    strcat( url, getTemp() );
    strcat( url, "&stemp=");   
    strcat( url, getHum() );
    return url;
    //numdata=inet.httpGET("http://nextrest.hopto.org", 8080, url1, msg, 50);
    //dtemp=%f&hum=%f&id=%s&geo=%s&stemp=%f.
}


void apresentacao()
{
    lcd.clear();
    lcd.setCursor(3, 0);
    lcd.print("CAUBI");
    lcd.setCursor(3, 1);
    lcd.print("SYSTEM :3");
    delay(20000);
    lcd.clear();
}

void lcdStatus(char status[12])
{
    lcd.clear();
    lcd.setCursor(3, 0);
    lcd.print(status);
}