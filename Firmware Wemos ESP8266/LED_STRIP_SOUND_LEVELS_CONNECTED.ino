#include <Arduino.h>

#include <WiFiManager.h>

#include <ESP8266WiFi.h>

#include <ESP8266HTTPClient.h>

#include <WiFiClient.h>

#include <Adafruit_NeoPixel.h>

#include <ArduinoJson.h>

#include "EEPROMAnything.h"

#define soundPinDigi D1
#define ledPin D4
#define buzzPin D2

const int numLeds = 3;

// Variables for periodic config retrieval
long previousMillis = 0;
long interval = 10; // interval for retrieving config in seconds
bool res; // WiFi connection success

// Variable for sound sampling
const int SAMPLE_TIME = 10;
unsigned long millisCurrent;
unsigned long millisLast = 0;
unsigned long millisElapsed = 0;

int alertRepeat = 5;
int doAudableCue = 1;
int doVisualCue = 1;
int color = 16777215;
int soundFrequency = 2000;
int soundLength = 250;

String serverName = "/RetroBit%20server/";

//BEGIN Admin config

//BEGIN RetroBit server config

//  String serverUrl = "http://192.168.2.40/RetroBit%20server/";
//  int retrobitId = 5;

  String serverUrl = "";
  int retrobitId = 0;

//END RetroBit Server config

int thresholdReset = 500;       // Set for threshold if config retrieval fails

//END admin config

int sampleBufferValue = 0;
int threshold = thresholdReset;

Adafruit_NeoPixel pixels = Adafruit_NeoPixel(numLeds, ledPin, NEO_GRB + NEO_KHZ800);

WiFiManager wm; // Global wm instance
WiFiManagerParameter custom_field_ip; // global param ( for non blocking w params )
WiFiManagerParameter custom_field_id; // global param ( for non blocking w params )
WiFiManagerParameter custom_field_threshold; // global param ( for non blocking w params )

struct { 
  char url[56] = "";
  int id = 0;
} configData;

int configAddr = 0;

void setup() {
  Serial.begin(9600);

  pinMode(soundPinDigi, INPUT);
  pinMode(ledPin, OUTPUT);
  pinMode(buzzPin, OUTPUT);

  EEPROM.begin(512);
  
  pixels.begin();    // Start serial

  pixels.setBrightness(100);     // Set brightness of Led's

  SetPixelsColor(pixels.Color(0, 0, 0)); // Turn off Strip

  getEEPROMConfig();

  connectWifi();

  getConfig();
}

void loop() {  
  millisCurrent = millis();
  millisElapsed = millisCurrent - millisLast;

  getConfigPeriodically();

  if (digitalRead(soundPinDigi) == HIGH) {
    sampleBufferValue++;
  }

  measureSample();
}

void measureSample() {
    if (millisElapsed > SAMPLE_TIME) {
    Serial.println(sampleBufferValue);
      if(sampleBufferValue > threshold) {
          alertUser();
        }
    sampleBufferValue = 0;
    millisLast = millisCurrent;
  }
}

void alertUser() {
  threshold = 1025;
  for (int i = 0; i < alertRepeat; i++){
    if (doAudableCue) { AudableCue(); }
    if (!doVisualCue) { delay(500);   }
    if (doVisualCue)  { VisualCue();  }
  }
  sendActivation(sampleBufferValue, doVisualCue, doAudableCue);
  threshold = thresholdReset;
}

void AudableCue() {
    tone(D2, soundFrequency, soundLength);
}

void VisualCue() {
    SetPixelsColor(color);
    delay(250);
    SetPixelsColor(0); 
    delay(250);
}

void SetPixelsColor(int color) {
    for(uint16_t i = 0; i < pixels.numPixels(); i++) { // Loop through pixels
        pixels.setPixelColor(i, color); // Set color
    }        
    pixels.show();
}

void getConfigPeriodically() {
  if(millisCurrent - previousMillis > interval * 1000)
     {
       previousMillis = millisCurrent;

       getConfig();
     }  
}

void getEEPROMConfig() {
  EEPROM_readAnything(configAddr, configData);

  Serial.println("url " + String(configData.url));
  Serial.println("id " + String(configData.id));

  if (String(configData.url).indexOf("http") != -1 && configData.id > 0) {
    Serial.println("Saved Config!");
    
    serverUrl = String(configData.url);
    retrobitId = configData.id;
    
  } else {
    Serial.println("No saved persistent config");
  }
}

void connectWifi() {
    
    WiFi.mode(WIFI_STA);

    new (&custom_field_ip) WiFiManagerParameter("server_ip", "RetroBit Server IP Address", "", 128,"placeholder=\"***.***.***.***\" type=\"text\""); // custom html type
    new (&custom_field_id) WiFiManagerParameter("retrobit_id", "RetroBit ID", "", 2,"placeholder=\"RetroBit ID\" type=\"number\""); // custom html type

    wm.addParameter(&custom_field_ip);
    wm.addParameter(&custom_field_id);
    wm.setSaveParamsCallback(saveParamCallback);

    std::vector<const char *> menu = {"wifi","param","sep","restart","exit"};
    wm.setMenu(menu);
    
    res = wm.autoConnect("RetroBit");

    if(!res) {
        Serial.println("Failed to connect to WIFI!");
    } 
    else {
        Serial.println("WIFI Connected!");
    }
}

String getParam(String name){
  //read parameter from server, for customhmtl input
  String value;
  if(wm.server->hasArg(name)) {
    value = wm.server->arg(name);
  }
  return value;
}

void saveParamCallback(){
  Serial.println("[CALLBACK] saveParamCallback fired");
  
  Serial.println("PARAM server_ip = " + getParam("server_ip"));
  serverUrl = "http://" + getParam("server_ip") + serverName;
  serverUrl.toCharArray(configData.url, 56); //Copy string data from param to configData.data with length 56
  
  Serial.println("PARAM retrobit_id = " + getParam("retrobit_id"));
  retrobitId = getParam("retrobit_id").toInt();
  configData.id = getParam("retrobit_id").toInt();

  EEPROM_writeAnything(configAddr, configData); // Write to RAM

  EEPROM.commit(); // Commit to Flash memory
}

void clearEEPROM() {
    for (int i = 0 ; i < EEPROM.length() ; i++) {
    EEPROM.write(i, 0);
  }
  Serial.println("Cleared EEPROM!!!");
}

void sendActivation(int sampleBufferValue, bool doVisualCue, bool doAudableCue) {
  if (res) {

    WiFiClient client;

    HTTPClient http;

    Serial.println("WIFI Connected!");
        
    String url = serverUrl + "postActivation.php/?sample=@s&audio=@a&visual=@v&retrobitId=@i&alert_repeat=@r&sound_frequency=@f&sound_length=@l&visual_color=@c/";
    url.replace("@s", String(sampleBufferValue));
    url.replace("@a", String(doAudableCue));
    url.replace("@v", String(doVisualCue));
    url.replace("@i", String(retrobitId));
    url.replace("@r", String(alertRepeat));
    url.replace("@f", String(soundFrequency));
    url.replace("@l", String(soundLength));
    url.replace("@c", String(color));

    Serial.println("Url: " + url);

    Serial.print("[HTTP] begin...\n");
    if (http.begin(client, url)) {  // HTTP. Adress of running server

      Serial.print("[HTTP] GET...\n");
      // start connection and send HTTP header
      int httpCode = http.GET();

      // httpCode will be negative on error
      if (httpCode > 0) {
        // HTTP header has been send and Server response header has been handled
        Serial.printf("[HTTP] GET... PostActivation  code: %d\n", httpCode);

        // file found at server
        if (httpCode == HTTP_CODE_OK || httpCode == HTTP_CODE_MOVED_PERMANENTLY) {
          String payload = http.getString();
          Serial.println(payload);
        }
      } else {
        Serial.printf("[HTTP] GET... PostActivation failed, error: %s\n", http.errorToString(httpCode).c_str());
      }

      http.end();
    } else {
      Serial.printf("[HTTP} Unable to connect\n");
      clearEEPROM();
      connectWifi();
    }
  }
}

void getConfig() {
   if (res) {

    WiFiClient client;

    HTTPClient http;

    Serial.println("WIFI Connected!");

    String url = serverUrl + "config.php/?retrobitId=@i/";
    url.replace("@i", String(retrobitId));

    Serial.println("Url: " + url);

    Serial.print("[HTTP] begin...\n");
    if (http.begin(client, url)) {  // HTTP. Adress of running server
  
      Serial.print("[HTTP] GET...\n");
      // start connection and send HTTP header
      int httpCode = http.GET();

      // httpCode will be negative on error
      if (httpCode > 0) {
        // HTTP header has been send and Server response header has been handled
        Serial.printf("[HTTP] GET... Config code: %d\n", httpCode);

        // file found at server
        if (httpCode == HTTP_CODE_OK || httpCode == HTTP_CODE_MOVED_PERMANENTLY) {
          String payload = http.getString();
          Serial.println(payload);

//      const size_t bufferSize = JSON_OBJECT_SIZE(2) + JSON_OBJECT_SIZE(3) + JSON_OBJECT_SIZE(5) + JSON_OBJECT_SIZE(8) + 370;
      StaticJsonDocument<350> doc;
      DeserializationError error = deserializeJson(doc, payload);

      if (error) {
        Serial.print("Json Deserialisation failed with code: ");
        Serial.println(error.c_str());
        return;
      }
      
      // Parameters
      int configId = doc["id"];
      int configAudio = doc["audio"];
      int configVisual = doc["visual"];
      int configThreshold = doc["threshold"];
      int configAlertRepeat = doc["alert_repeat"];
      int configSoundFrequency = doc["sound_frequency"];
      int configSoundLength = doc["sound_length"];
      int configVisualColor = doc["visual_color"];
      
      // Output to serial monitor
      Serial.print("CONFIG! id: ");
      Serial.println(configId);
      Serial.print("audio: ");
      Serial.println(configAudio);
      Serial.print("visual: "); 
      Serial.println(configVisual);
      Serial.print("threshold: "); 
      Serial.println(configThreshold);
      Serial.print("alertRepeat: "); 
      Serial.println(configAlertRepeat);
      Serial.print("sound_frequency: "); 
      Serial.println(configSoundFrequency);
      Serial.print("sound_length: "); 
      Serial.println(configSoundLength);
      Serial.print("visual_color: "); 
      Serial.println(configVisualColor);

      // Set all variables from config
      doAudableCue = configAudio;
      doVisualCue = configVisual;
      threshold = configThreshold;
      thresholdReset = configThreshold;
      alertRepeat = configAlertRepeat;
      soundFrequency = configSoundFrequency;
      soundLength = configSoundLength;
      color = configVisualColor;
      
        }
      } else {
        Serial.printf("[HTTP] GET... Config failed, error: %s\n", http.errorToString(httpCode).c_str());
      }

      http.end();
    } else {
      Serial.printf("[HTTP} Unable to connect\n");
      clearEEPROM();
      connectWifi();
    }
  }
}
