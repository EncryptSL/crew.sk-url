<?php
/**
 * @author Martin Galovic (galovik) <galovikcode@gmail.com>
 */

require_once(__DIR__.'/../lib/Rcon.php');

use thedudeguy\Rcon;

$parse = ['action', 'method', 'price', 'currency', 'days', 'variables', 'sms_text', 'key', 'code'];
foreach ($parse as $p) {
	$_GET[$p] = isset($_GET[$p]) ? $_GET[$p] : null;
}
$ip = $_SERVER['REMOTE_ADDR'];

// ===== NASTAVENIA ===== //
$expectedKey  = 'vas_kluc'; // Sem nastavte kľúč, ktorý ste použili pri pridávaní VIP URL callback-u

// Rcon: nastavte v server.properties
$rconHost     = 'mc40.crew.sk:25570'; // Rcon Host
$rconPort     = 25567; // Rcon port
$rconPassword = 'server-rcon-password'; // Rcon properties

// ===== KONIEC NASTAVENI =====

/**
 * Akcia:
 * @var string
 * - 'activate'   #Aktivácia VIP - volá sa pri úspešnom zakúpení a zaplatení VIP
 * - 'deactivate' #Deaktivácia VIP - volá sa pri vypršaní VIP
 */
$action = $_GET['action'];

/**
 * Metóda:
 * @var string
 * - 'smssk'	#Platba pomocou SMS zo Slovenska
 * - 'smscz'	#Platba pomocou SMS z Českej republiky
 * - 'paypal'	#Platba pomocou PayPal-u
 */
$method = $_GET['method'];

/**
 * Cena VIP:
 * @var float
 */
$price = $_GET['price'];

/**
 * Mena:
 * @var string
 * - 'eur' - euro (EUR)
 * - 'czk' - česká koruna (Kč)
 */
$currency = $_GET['currency'];

/**
 * Počet dní na koľko má byť VIP aktívne:
 * @var int
 */
$days = $_GET['days'];

/**
 * Premenné:
 * @var array
 * nazov_premennej => hodnota
 * Napr.: nick => galovik
 */
$variables = $_GET['variables'];

/**
 * Text odoslanej SMS:
 * @var string
 * Napr. SERVER PRO 57714 1 vip galovik
 */
$smsText = $_GET['sms_text'];

/**
 * Kľúč, ktorý ste nastavili pri pridávaní callbacku
 * @var string
 */
$key = $_GET['key'];

/**
 * Unikátny kód pre VIP bránu, ktorú ste vytvorili
 * @var string
 */
$code = $_GET['code'];

// Validácia
if ($key !== $expectedKey) exit("Wrong key");

$commands = array(); // for older PHP :/

switch ($code) {
	case 'vip_1':
		$commands[]	= 'say §2Hrac :nick si kúpil VIP 1'; 	// :nick sa automatický nahradí za premennú nick, ktorú zadal hráč
															// Môžete taktiež použiť inú premennú ako nick, napr :heslo atď
		break;
	case 'vip_2':
		$commands[] = 'say §1Hrac :nick si kúpil VIP 2';
		break;
	default:
		exit("Wrong code");
		break;
}

// Call rcon commands

$rcon = new Rcon($rconHost, $rconPort, $rconPassword);

if (!$rcon->connect()) exit("Unable to connect to rcon");

if (count($commands)) {
	
	foreach ($commands as $command) {
		$command = command($command, $variables);
		$rcon->send_command($command);
	}

}

function command($command = '', $variables = []) {
	foreach ($variables as $key => $value) {
		$command = str_replace(':'.$key, $value, $command);
	}
	return $command;
}