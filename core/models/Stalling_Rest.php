<?php
/**
 * Created by PhpStorm.
 * User: isaacdecuba
 * Date: 7/3/15
 * Time: 12:13 PM
 */
use Guzzle\Http\Client;

class Stalling_Rest {

    const VEILIGSTALLEN_URL = 'http://www.veiligstallen.nl/veiligstallen.kml';

    private $_guzzleClient;
    public $stallingen;
    public $aantalStallingen;

    /**
     * @return bool
     */
    private function _callApi()
    {
        $request = $this->getGuzzleClient()->createRequest('GET', self::VEILIGSTALLEN_URL);
        $response = $request->send()->getBody();

        return simplexml_load_string($response) or die("Error: Cannot create object");
    }

    /**
     * @return bool
     */
    public function getFietsenStallingen()
    {
        if (is_null($this->stallingen)) {
            $this->aantalStallingen = count($this->_callApi()->Document->Placemark);

            foreach ($this->_callApi()->Document->Placemark as $placemark) {
                echo "name: $placemark->name <br>";

                foreach($placemark->ExtendedData->Data as $a) {
                    echo $a["name"] . ": " . $a->value;
                    echo "<br>";
                }

                echo "<hr>";
            }
            return $this->stallingen = $this->_callApi();
        }
        return $this->stallingen;
    }

    /**
     * @return Client
     */
    public function getGuzzleClient()
    {
        if (is_null($this->_guzzleClient)) {
            return $this->_guzzleClient = new Client();
        }
        return $this->_guzzleClient;
    }

}