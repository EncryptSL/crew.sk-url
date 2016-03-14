crew.sk url callbacks
=====================

URL callbacky dokumentácia + príklad skriptu na VIP systém crew.sk

Postup
-------
**1. Vytvorenie callbacku**
K vytvorenej bráne priradte VIP callback a vyplňte údaje podľa nasledujúceho obrázka
![Vytvorenie VIP](http://www.crew.sk/assets/uploads/kubke/crew_url_1.png)


----------
**2. Volanie skriptu**
Parametre:
```php
action
 - activate   #pri úspešnom zakúpení VIP
 - deactivate #pri vyrpšaní platnosti VIP

method
 - smssk  #Platba pomocou SMS zo Slovenska
 - smscz  #Platba pomocou SMS z Českej republiky
 - paypal #Platba pomocou PayPal-u

price     #cena VIP (float)

days      #počet dní, na ktoré bude VIP aktívne (napr. 30)

variables #pole s premennými (napr. ak je vo VIP bráne nastavené; napr. 'nick' => 'galovik')

sms_text  #Text SMS (len v prípade smssk/smscz method)

key       #Klúč, ktorý ste nastavili v pridávaní URL callbacku

code      #Unikátný kód, ktorý sa nastavuje pri pridávaní VIP Brány
```


----------
**Príkladný skript nájdete sem:** [`/examples/callback.php`](/examples/callback.php)


----------


V prípade akýchkoľvek otázok kontaktujte podporu na [podpore crew.sk](http://crew.sk/user/support/tickets)