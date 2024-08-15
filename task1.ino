
#include <WiFi.h>
#include <HTTPClient.h>

const char* ssid = "";
const char* password = "";

const char* serverUrl = "http://127.0.0.1/task1,2/task1/getData.php";
void setup() {
  Serial.begin(115200);

  WiFi.begin(ssid, password);
  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }
  Serial.println("WiFi connected");
}

void loop() {
  HTTPClient http;

  http.begin(serverUrl);
  int httpCode = http.GET();

  if (httpCode > 0) {
    Serial.printf("HTTP Code: %d\n", httpCode);

    String response = http.getString();
    Serial.println(response);

  
  } else {
    Serial.printf("Error code: %s\n", http.errorToString(httpCode).c_str());
  }

  http.end();

  delay(5000);
}
