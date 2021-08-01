<?php

namespace App\Http\Controllers;

use Google\Client;
use Google\Service\Sheets\ValueRange;
use Illuminate\Http\Response;
use Laravel\Lumen\Http\Request;
use Revolution\Google\Sheets\Facades\Sheets;
use Google_Client;
class SheetController extends Controller
{
    /**
     * Create a new Google client instance and set up the account service
     *
     * @return \Google_Service_Sheets
     */
    public function createGoogleService()
    {

        $client = new Google_Client();

        $client->setApplicationName('Google Sheets and PHP');

        $client->setScopes([\Google_Service_Sheets::SPREADSHEETS]);

        $client->setAccessType('offline');
        $client->setAuthConfig(storage_path('credentials.json'));

        $service = new \Google_Service_Sheets($client);
        return $service;
    }
    public function getOxygen(Request $request)
    {
        $service = $this->createGoogleService();
        $spreadsheetID = "1c0MaJsvSgtCdyFwv4Wigp_y9DB7BsefMC5I8WSk68fc";
        $range = "SheetOxy";
        $response = $service->spreadsheets_values->get($spreadsheetID,$range);

        $values = $response->getValues();
        $response = $this->buildJSONResponse($values);
        //dd($response);
        return response()->json($response,200,[], JSON_UNESCAPED_UNICODE);
    }

    public function getLovenox(Request $request){
        $service = $this->createGoogleService();
        $spreadsheetID = "1qB3V0aB7u8KICw0G3x78-r3J1MVxSQgConeONS9j8Iw";
        $range = "Sheet1";
        $response = $service->spreadsheets_values->get($spreadsheetID, $range);
        $values = $response->getValues();
        $response = $this->buildJSONResponse($values);
        return response()->json($response,200,[], JSON_UNESCAPED_UNICODE);
    }

    /**
     * @param $values
     * Convert $values 2D array into a JSON response
     */
    public function buildJSONResponse($values){
        $resp = [];
        //dd($values);
        $headers = $values[0];
        $data = array_slice($values,1);

        foreach ($data as $row){
            $rowObj = [];
            //dd($headers);
            foreach ($row as $i=>$colValue){
                $header = $headers[$i];
                if ($colValue == "NA" || $colValue == "na")
                {
                    $colValue = "";
                }
                $rowObj[$header] = $colValue;
            }
            array_push($resp,$rowObj);
        }
        return $resp;
    }


    //
}
