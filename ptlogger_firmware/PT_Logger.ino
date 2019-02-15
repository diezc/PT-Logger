//PROJECT by @diezc
PRODUCT_ID(3739);
PRODUCT_VERSION(10);
//Libraries
#include <HttpClient.h>
#include <Adafruit_BMP085.h>
#include <string.h>

//Timer constants
#define HTTP_REQUEST_T (60*60*1000) //60 minutes
#define VALUE_UPDATE_T (30*60*1000) //30 minutes
//Classes
Adafruit_BMP085 bmp;
TCPClient client;
HttpClient http;
//Variables datos
double temperature=0.0;
double pressure=0.0;

//variables timers
unsigned long last_t_http=millis();
unsigned long last_t_metric=millis();

//Headers
http_header_t headers[] = {
    //  { "Content-Type", "application/json" },
    //  { "Accept" , "application/json" },
    { "Accept" , "*/*"},
    { NULL, NULL } // NOTE: Always terminate headers will NULL
};

http_request_t request;
http_response_t response;


void setup() {
    Particle.publish("STATUS","BOOT OK");
    bmp.begin();
    delay(1000);
    Spark.syncTime();  
    Time.zone(+2);
    Particle.variable("temperature", &temperature, DOUBLE);
    Particle.variable("pressure", &pressure, DOUBLE);
    Particle.function("httpRequest", http_update);
    Particle.function("metricUpdate", measurement_update);
    measurement_update("extra");
    Particle.publish("STATUS","SETUP OK");
}

void loop() {
   
   if(millis()-last_t_http>=HTTP_REQUEST_T){
       last_t_http=millis();
       http_update("extra");
   }
   
   
   if(millis()-last_t_metric>=VALUE_UPDATE_T){
       last_t_metric=millis();
       measurement_update("extra");
   }
}

///////////////////////////////////////////////////////////////////////////////////////////
int measurement_update(String extra)
{
    Particle.publish("METRIC","BEGIN");
    temperature=bmp.readTemperature();
    delay(500); //0.5 second cooldown
    pressure=bmp.readPressure()/100.00; 
    Particle.publish("METRIC","END");
    return 0;
}

int http_update(String extra)
{    
    measurement_update("extra");
    Particle.publish("HTTP", "BEGIN");
    pressure_http();
    delay(2500); //2.5 second cooldown
    temperature_http();
    Particle.publish("HTTP", "END");
    return 0;
}

//////////////////////////////////////////////////////////////////////////////////////////////
void pressure_http(){
    request.hostname = "diezc.ddns.net";
    request.port = 80;
    request.path = "/ptlogger/updateRequest.php?device_id=54ff6a066667515124071567&value_type=2";
    Particle.publish("HTTP", "PRESSURE");
    http.get(request, response, headers);
    Particle.publish("HTTP", response.body);
}


void temperature_http(){
    request.hostname = "diezc.ddns.net";
    request.port = 80;
    request.path = "/ptlogger/updateRequest.php?device_id=54ff6a066667515124071567&value_type=1";
    Particle.publish("HTTP", "TEMPERATURE");
    http.get(request, response, headers);
    Particle.publish("HTTP", response.body);
}

