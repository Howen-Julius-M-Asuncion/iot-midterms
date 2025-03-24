#include <WiFi.h>
#include <HTTPClient.h>
#include <DHT.h>

const char *ssid = "";
const char *password = "";
String URL = "http://IP/midterms-iot/query/store.php";

#define DHTPIN 5
#define DHTTYPE DHT11
DHT dht(DHTPIN, DHTTYPE);

void connectWiFi()
{
    WiFi.mode(WIFI_STA);
    WiFi.begin(ssid, password);

    while (WiFi.status() != WL_CONNECTED)
    {
        delay(500);
        Serial.print(".");
    }

    Serial.println("\nConnected to WiFi!");
    Serial.print("IP Address: ");
    Serial.println(WiFi.localIP());
}

void setup()
{
    // put your setup code here, to run once:
    Serial.begin(115200);
    dht.begin();
    delay(2000);

    connectWiFi();
}

void loop()
{
    // put your main code here, to run repeatedly:
    if (WiFi.status() != WL_CONNECTED)
    {
        connectWiFi();
    }

    delay(1000);

    float temperature = dht.readTemperature();
    float humidity = dht.readHumidity();

    if (isnan(temperature) || isnan(humidity))
    {
        Serial.println(" Failed to read from DHT sensor! Retrying...");
        return;
    }

    HTTPClient http;
    http.begin(URL);
    http.addHeader("Content-Type", "application/x-www-form-urlencoded");

    String postData = "temperature=" + String(temperature, 1) + "&humidity=" + String(humidity, 1);

    int httpCode = http.POST(postData);
    String payload = http.getString();

    Serial.println("--------------------------------------");
    Serial.print("Data Sent: ");
    Serial.println(postData);
    Serial.print("HTTP Code: ");
    Serial.println(httpCode);
    Serial.print("Response: ");
    Serial.println(payload);
    Serial.print("Temperature: ");
    Serial.println(temperature);
    Serial.print("Humidity: ");
    Serial.println(humidity);
    Serial.println("--------------------------------------");

    delay(4000);
}
