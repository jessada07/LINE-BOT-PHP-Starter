<html>
  <head>
    <?php
$verz="1.0";
exec("mode COM3: BAUD=9600 PARITY=n DATA=8 STOP=1 to=off dtr=off rts=off"); 
$fp = fopen("COM3", "w"); 

switch($_POST)
	{
		case isset($_POST['submitOn']):
			fwrite($fp, "1"); //write string to serial  // Turn On LED 1
			break;
		case isset($_POST['submitOff']):
			fwrite($fp, "0"); //write string to serial  // Turn Off LED 1
			break;

	}
fclose($fp);
?>
  </head>

  <body>

    <h1>Control Panel</h1>

    <form  method="post" action=""
      <?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
      <input type='submit' name='submitOn' value='Turn LED 1 ON'>
        <input type='submit' name='submitOff' value='Turn LED 1 OFF'>

	</form>

  </body>

</html>
