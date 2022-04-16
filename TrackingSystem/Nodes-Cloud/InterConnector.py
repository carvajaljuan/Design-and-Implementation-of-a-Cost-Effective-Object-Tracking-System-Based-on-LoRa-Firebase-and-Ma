import serial
import time
import requests
import json
import re
DatoValid=0
DatoValid2=0
firebase_url = 'https://testarduino-b4fcb.firebaseio.com/'
#Se conceta el puerto serial para la comunicacion
ser = serial.Serial('COM3', 9600, timeout=0)
fixed_interval = 0.2
Valid=0
Valid2=0
while 1:
  try:
    #Lectura del dato serial proviniente del puerto USB.      
    DatoSerial = ser.readline()
    #Se verifican los identifcadores de coordendas y signo a partir de la tercera posicion.
    ICoord = DatoSerial.find("F",2)
    ASigno = DatoSerial.find("A",2) 
    BSigno = DatoSerial.find("B",2) 
    Ident= txt [0:2]  #Filtra y almacena el identificador del nodo.
    if ICoord==2 and (ASigno== 11 or BSigno==11):
      Valid=1
      print "Dato valido"
      DatoValid= DatoSerial[3:11]    #Se guarda el dato numerico de la coordenada
      DatoValid= float(DatoValid)
      DatoValid= DatoValid/float(100000) #Se recontruye la coordenada a su valor decimal
    ASigno2 = DatoSerial.find("A",2) 
    BSigno2 = DatoSerial.find("B",2) 
    ICoord2 = DatoSerial.find("E",2) 
    if ICoord2==2 and (ASigno== 11 or BSigno==11):
      Valid2=1
      print "Dato valido"
      DatoValid2= DatoSerial[3:11]
      DatoValid2= float(DatoValid2)
      DatoValid2= DatoValid2/float(100000)
      print DatoValid2
    #Se añade el signo de la coordenada segun el identificador.
    if ASigno==11:
        print( DatoValid)
    if BSigno==11:
	    DatoValid=-1*DatoValid
        print( DatoValid)
    if ASigno2==11:
        print( DatoValid2)
    if BSigno2==11:
        DatoValid2=-1*DatoValid2
	    print( DatoValid2)

    #Almacena la fecha y hora actual
    time_hhmmss = time.strftime('%H:%M:%S')
    date_mmddyyyy = time.strftime('%d/%m/%Y')
    Localizacion1 = 'Bogota-Colombia';
    Localizacion2 = 'Bogota-Colombia2';
    DatoVivo='Dato_Actual'
    DatoVivo2='Dato_Actual2'
    if Valid==1 and Valid2==1:  
     Latitud1=DatoValid2
     Longitud1=DatoValid
     Latitud2=DatoValid2
     Longitud2=DatoValid
     #insert record
     if Ident =="AA":
        data = {'date':date_mmddyyyy,'time':time_hhmmss,'Latitud':Latitud1,'Longitud':Longitud1}
        result = requests.delete(firebase_url + '/' + DatoVivo + '/Posicion.json')
        result = requests.post(firebase_url + '/' +Localizacion1  + '/Posicion.json', data=json.dumps(data))
        result = requests.post(firebase_url + '/' + DatoVivo + '/Posicion.json', data=json.dumps(data))
     data2 = {'date':date_mmddyyyy,'time':time_hhmmss,'Latitud':Latitud2,'Longitud':Longitud2}
     if Ident =="AB":
         data2 = {'date':date_mmddyyyy,'time':time_hhmmss,'Latitud':Latitud2,'Longitud':Longitud2}
         result = requests.delete(firebase_url + '/' + DatoVivo2 + '/Posicion.json')
         result = requests.post(firebase_url + '/' + Localizacion2 + '/Posicion.json', data=json.dumps(data2))
         result = requests.post(firebase_url + '/' + DatoVivo2 + '/Posicion.json', data=json.dumps(data2))
     Valid=0
     Valid2=0
     ICoord2=-1
     ICoord=-1
     BSigno=-1
     ASigno=-1
     print 'Datos enviados a la nube = ' + str(result.status_code) + ',' + result.text
     time.sleep(fixed_interval)
  except IOError:
    print('Error! Algo salio mal.')
    ser = serial.Serial('COM3', 9600, timeout=0)
  time.sleep(fixed_interval)