<?php

function get_omschrijving() 
{
 	 $html = "";
	$url = 'http://www.veiligstallen.nl/veiligstallen.xml';
		$xml = simpleXML_load_file($url,"SimpleXmlElement");
?>
		<select name="years">
<?php
		foreach ($xml->Fietsenstalling as $oms) 
		{

			echo "<option ><strong>Gemeente:</strong> ".$oms->Gemeente."</option><br/>";


			echo "</p>";
		}
		?>
		</select>
		<?php
}



?>
