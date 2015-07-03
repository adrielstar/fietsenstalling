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
    const COORDINATE_LAT = 'lat';
    const COORDINATE_LNG = 'lng';

    private $_guzzleClient;

    public $aantalStallingen;
    private $_stallingen = array();

    public function __construct()
    {
        $this->setStallingen();
    }

    /**
     * @return bool
     */
    private function getFietsenStallingen()
    {
        $request = $this->getGuzzleClient()->createRequest('GET', self::VEILIGSTALLEN_URL);
        $response = $request->send()->getBody();

        $xml = simplexml_load_string($response) or die("Error: Cannot create object");
        return $xml;
    }

    /**
     * Create stalling objects and place them into the stallingen array
     */
    public function setStallingen()
    {
        if (empty($this->_stallingen)) {
            $this->aantalStallingen = count($this->getFietsenStallingen()->Document->Placemark);

            foreach ($this->getFietsenStallingen()->Document->Placemark as $placemark) {
                $stalling = new stdClass();
                $stalling->name = (String) $placemark->name;

                foreach($placemark->ExtendedData->Data as $a) {
                    $key = (String) $a["name"];
                    $stalling->$key = (String) $a->value;
                }

                $coordinates = (String) $placemark->Point->coordinates;
                $stalling->lat = floatval($this->getCoordinate($coordinates, 'lat'));
                $stalling->lng = floatval($this->getCoordinate($coordinates, 'lng'));

                array_push($this->_stallingen, $stalling);
            }
        }
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

    /**
     * @return stdClass array
     */
    public function getStallingen()
    {
        if (is_null($this->_stallingen)) {
            $this->setStallingen();
        }
        return $this->_stallingen;
    }

    /**
     * @param string $coordinates
     * @param $type
     * @return bool | string
     */
    private function getCoordinate($coordinates, $type)
    {
        if ($type == self::COORDINATE_LAT && is_string($coordinates)) {
            $string = explode(",", $coordinates);
            return $string[1];
        } elseif ($type == self::COORDINATE_LNG && is_string($coordinates)) {
            $string = explode(",", $coordinates);
            return $string[0];
        } else {
            return false;
        }
    }

}