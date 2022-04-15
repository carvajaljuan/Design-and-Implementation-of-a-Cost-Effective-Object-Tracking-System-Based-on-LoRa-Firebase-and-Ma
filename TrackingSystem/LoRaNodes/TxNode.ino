#include <SoftwareSerial.h>
#include <TinyGPS.h>//incluimos TinyGPS
#include <avr/sleep.h>


float flag=0,LatitudeSend,LongitudeSend,Latitude,Longitude;
String consta,consta2,LongitudeText,LatitudeText,ID,fracsString,fracs2String;
String ivalString,ivalString2,SignoLat,SignoLong;
String str,str2,str3;
int c,Sleep;
float latitude, longitude;
 long int fracs,fracs2,ival,ival2,frac,frac2;
unsigned long Limite=0,Limite2=0;
byte intCounter, adcsra, mcucr1, mcucr2;




TinyGPS gps;//Declaramos el objeto gps
// software serial #1: RX = digital pin 10, TX = digital pin 11
SoftwareSerial loraSerial(9, 12); //antes 9,12 o 5 y 6
SoftwareSerial serialgps(4,3);//Declaramos el pin 4 Tx y 3 Rx
unsigned long time;
// software serial #2: RX = digital pin 8, TX = digital pin 9
// on the Mega, use other pins instead, since 8 and 9 don't work on the Mega
String CoordMsg="2020";
int Reset=7;
void setup() {
   ID="AA";
  Latitude=4.32968;
Longitude=-74.65126;
  // Open serial communications and wait for port to open:
  Serial.begin(9600);
  loraSerial.begin(9600);

  pinMode(Reset, OUTPUT);
  digitalWrite(Reset, LOW);
  delay(500);
  digitalWrite(Reset, HIGH);
  delay(100);
  Serial.flush();
  lora_autobaud();
  //loraSerial.setTimeout(1000);
  
  Serial.println("Initing LoRa");
  
  loraSerial.listen();
  str = loraSerial.readStringUntil('\n');
  Serial.println(str);
  loraSerial.println("sys get ver");
  str = loraSerial.readStringUntil('\n');
  Serial.println(str);
  
  loraSerial.println("mac pause");     // Activates P2P transmission between the modules 
  str = loraSerial.readStringUntil('\n');
  Serial.println(str);
  
//  loraSerial.println("radio set bt 0.5");
//  wait_for_ok();
  
  loraSerial.println("radio set mod lora");
  str = loraSerial.readStringUntil('\n');
  Serial.println(str);
  
  loraSerial.println("radio set freq 915000000");
  str = loraSerial.readStringUntil('\n');
  Serial.println(str);
  
  loraSerial.println("radio set pwr 14");
  str = loraSerial.readStringUntil('\n');
  Serial.println(str);
  
  loraSerial.println("radio set sf sf7");
  str = loraSerial.readStringUntil('\n');
  Serial.println(str);
  
  loraSerial.println("radio set afcbw 41.7");
  str = loraSerial.readStringUntil('\n');
  Serial.println(str);
  
  loraSerial.println("radio set rxbw 125");
  str = loraSerial.readStringUntil('\n');
  Serial.println(str);
  
//  loraSerial.println("radio set bitrate 50000");
//  wait_for_ok();
  
//  loraSerial.println("radio set fdev 25000");
//  wait_for_ok();
  
  loraSerial.println("radio set prlen 8");
  str = loraSerial.readStringUntil('\n');
  Serial.println(str);
  
  loraSerial.println("radio set crc on");
  str = loraSerial.readStringUntil('\n');
  Serial.println(str);
  
  loraSerial.println("radio set iqi off");
  str = loraSerial.readStringUntil('\n');
  Serial.println(str);
  
  loraSerial.println("radio set cr 4/5");
  str = loraSerial.readStringUntil('\n');
  Serial.println(str);
  
  loraSerial.println("radio set wdt 60000"); //disable for continuous reception
  str = loraSerial.readStringUntil('\n');
  Serial.println(str);
  
  loraSerial.println("radio set sync 12");
  str = loraSerial.readStringUntil('\n');
  Serial.println(str);
  
  loraSerial.println("radio set bw 125");
  str = loraSerial.readStringUntil('\n');
  Serial.println(str);
  serialgps.begin(9600);
  Serial.println("starting loop");
  EICRA = 0x00; 
  Coord2String();
  serialgps.listen();
  delay(1000);
  //uint8_t setPSM[] = { 0xB5, 0x62, 0x06, 0x11, 0x02, 0x00, 0x08, 0x01, 0x22, 0x92 }; // Setup for Power Save Mode (Default Cyclic 1s)
  //sendUBX(setPSM, sizeof(setPSM)/sizeof(uint8_t));
}

void loop() {
  // By default, the last intialized port is listening.
  // when you want to listen on a port, explicitly select it:
 //portOne.listen();
  // while there is data coming in, read it
  // and send to the hardware serial port:
  Serial.println(flag);
if (flag==1){
  loraSerial.listen();
  consta="radio tx ";
  consta2=consta +ID+LongitudeText;
  consta= consta +ID+LatitudeText;
  loraSerial.println(consta);   //This line does the actual transmission.  
  str = loraSerial.readStringUntil('\n');
  Serial.println(str);
  Serial.println(consta);
  str = loraSerial.readStringUntil('\n');
  flag=0;
  Serial.println(str);
  Serial.println(consta2);
  loraSerial.println(consta2);   //This line does the actual transmission.  
  str = loraSerial.readStringUntil('\n');
  Serial.println(str);
  str = loraSerial.readStringUntil('\n');
  flag=0;
  Serial.println(str);
  Serial.println(Sleep);

   Sleep=1;
   loraSerial.println("sys sleep 30000");
   fsleep();

   
   //delay(30000);
  // wake();
  while (Sleep==1){
       str2 = loraSerial.readStringUntil('\n');
       Serial.println(str2);
       if ((str2!="")||(str3!="")){
       Sleep=0;
       wake();
       uint8_t GPSon[] = {0xB5, 0x62, 0x02, 0x41, 0x08, 0x00, 0x00, 0x00, 0x00, 0x00, 0x01, 0x00, 0x00, 0x00, 0x4C, 0x37};
       sendUBX(GPSon, sizeof(GPSon)/sizeof(uint8_t));
       }
      str3 = loraSerial.readStringUntil('\n');
}

  

  // blank line to separate data from the two ports:
  // Now listen on the second port 
 serialgps.listen();
 time = millis();
  while(serialgps.available()) 
  {
     int c = serialgps.read();
    if(gps.encode(c))  
    {
      //float latitude, longitude;
      gps.f_get_position(&latitude, &longitude);
     // Serial.print("Latitud/Longitud: "); 
      Latitude=Serial.print(latitude,5); 
     Serial.println(Latitude,5);  
      Serial.print('\n'); 
      Longitude=Serial.println(longitude,5);
      uint8_t GPSoff[] = {0xB5, 0x62, 0x02, 0x41, 0x08, 0x00, 0x00, 0x00, 0x00, 0x00, 0x02, 0x00, 0x00, 0x00, 0x4D, 0x3B};
      sendUBX(GPSoff, sizeof(GPSoff)/sizeof(uint8_t));
      flag=1;
      Coord2String();
    }
  }
}
}
void lora_autobaud()
{
  String response = "";
  while (response=="")
  {
    delay(1000);
    loraSerial.write((byte)0x00);
    loraSerial.write(0x55);
    loraSerial.println();
    loraSerial.println("sys get ver");
    response = loraSerial.readStringUntil('\n');
    Serial.println(response);
  }
}

/*
 * This function blocks until the word "ok\n" is received on the UART,
 * or until a timeout of 3*5 seconds.
 */
int wait_for_ok()
{
  str = loraSerial.readStringUntil('\n');
  if ( str.indexOf("ok") == 0 ) {
    return 1;
  }
  else return 0;
}


void lora_autobaud2()
{
  String response = "";
  
  while (c<5)
  {
    delay(1000);
    loraSerial.write((byte)0x00);
    loraSerial.write(0x55);
    loraSerial.println();
    loraSerial.println("sys get ver");
    response = loraSerial.readStringUntil('\n');
    Serial.println(response);
    c=c+1;
    Serial.println(c);
  }
}
void fsleep()
{
sleep_enable();                    
    set_sleep_mode(SLEEP_MODE_PWR_DOWN);
    EIMSK |= _BV(INT0);            //Se activa INT0 para poder recibir interrupciones externas
    adcsra = ADCSRA;               //Se guarda los valores del ADC Y del status register de la conversión.
    ADCSRA = 0;                    //Se deshabilita el ADC.
    cli();
    mcucr1 = MCUCR | _BV(BODS) | _BV(BODSE);  //Se apaga el detector Brown-out 
    mcucr2 = mcucr1 & ~_BV(BODSE);     
    MCUCR = mcucr1;
    MCUCR = mcucr2;
    sei();                         //Se comprueban la habilitacion la interrupciones 
    sleep_cpu();                   //Se pone a dormir el MCU
}

void wake()
{
sleep_disable();               //wake up here
    ADCSRA = adcsra;               //restore ADCSRA
}
ISR(INT0_vect)
{
    intCounter++;
    EIMSK &= ~_BV(INT0);           //one interrupt to wake up only
}

void sendUBX(uint8_t *MSG, uint8_t len) {  
  for(int i=0; i<len; i++) {  //Ciclo para transmitir a traves del puerto
   serialgps.write(MSG[i]);  //serial del GPS cada trama hexadecimal.
  }
}
void Coord2String() {
     if (longitude<0)
     {
      ival2 = -(int)longitude;
      frac2 = (-longitude - ival2) * 100000;
     fracs2=(-longitude - ival2)*100 ; 
     SignoLong="B";
     }
     else
     {
       ival2 = (int)longitude;
      frac2 = (longitude - ival2) * 100000;
     fracs2=(longitude - ival2)*100 ;
     SignoLong="A";
     }
     if (latitude<0)
     {
     ival = -(int)latitude;
      frac = (-latitude- ival) * 100000;
     fracs=(-latitude - ival)*100 ;
     SignoLat="B";
     }
     else
     {
      ival = (int)latitude;
      frac = (latitude- ival)*100000 ;
     fracs=(latitude - ival)*100 ;
     SignoLat="A";
     }

     //Para el decimal
     if (fracs2 < 10)
     {
     fracs2String="0"+String(frac2);
     }
     else 
     {
      fracs2String=String(frac2);
     }
     if (fracs < 10)
     {
     fracsString="0"+String(frac);
     }
     else 
     {
      fracsString=String(frac);
     }
     //-----------------------------
     //Para el valor menor a 10 y agregar un 0
     if (ival < 10)
     {
     ivalString="00"+String(ival);
     }
     else 
     {
      ivalString="0"+String(ival);
     }
     if (ival2 < 10)
     {
     ivalString2="00"+String(ival2);
     }
     else if (ival2 < 100)
     {
      ivalString2="0"+String(ival2);
     }
     else
     {
      ivalString2=String(ival2);
     }
     //-------------------------------------
     LatitudeText="E"+ivalString+fracsString+SignoLat;
     LongitudeText="F"+ivalString2+fracs2String+SignoLong;
     Serial.println(LatitudeText);
     Serial.println(LongitudeText);

}
