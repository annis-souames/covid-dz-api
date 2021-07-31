<?php

namespace App\Http\Controllers;

use Google\Client;
use Google\Service\Sheets\ValueRange;
use Laravel\Lumen\Http\Request;
use Revolution\Google\Sheets\Facades\Sheets;
use Google_Client;
class SheetController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function getOxygen(Request $request)
    {

        /**
        $sheets = new Sheets();
        $sheets->setService($service);
        */

        $client = new Google_Client();

        $client->setApplicationName('Google Sheets and PHP');

        $client->setScopes([\Google_Service_Sheets::SPREADSHEETS]);

        $client->setAccessType('offline');
        $client->setAuthConfig(storage_path('credentials.json'));

        $service = new \Google_Service_Sheets($client);
        $spreadsheetID = "1a4N_yGTUOmGVFRLODbfv6NNJO7hcgdXpayRFSufj1sk";
        $range = "Sheet1";
        $response = $service->spreadsheets_values->get($spreadsheetID, $range);
        $values = $response->getValues();
        $response = $this->buildJSONResponse($values);
        return $response;
    }

    /**
     * @param $values
     * Convert $values 2D array into a JSON response
     */
    public function buildJSONResponse($values){
        $resp = [];
        $headers = $values[0];
        $data = array_slice($values,1);

        foreach ($data as $row){
            $rowObj = [];
            //dd($headers);
            foreach ($row as $i=>$colValue){
                $header = $headers[$i];
                $rowObj[$header] = $colValue;
            }
            array_push($resp,$rowObj);
        }
        return $resp;
    }


    //
}
