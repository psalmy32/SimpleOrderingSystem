Due to Time constraint, some things were not considered.
and some few things might have to be run from terminal.

API DOCUMENTATION: https://documenter.getpostman.com/view/6890514/TzRVg729

PLEASE BEAR WITH ME.
THANKS FOR UNDERSTANDING

STEPS TO RUN THE SCRIPT
1. Clone the Project from this repository
2. Create Database called factoryirisii
3. Navigate to the foler cd FactoryIrisiiOrder
4. run the following command: **php artisan migrate** this creates the migration for the project
5. start the project using Docker: **docker-compose up**. project will be started on port 8080
6. You can either test manually or run the unit test
7. the API documentation is in the above link https://documenter.getpostman.com/view/6890514/TzRVg729
8. to run unit test, run the following: **./vendor/bin/phpunit**

DUE TO TIME CONSTRAINT, GOOGLE MAP WASNT USED, SO I FETCHED THE LATITUDE AND LONGITUDE MANUALLY 
BELOW CODE GETS THE DISTANCE USING GOOLE MAP API

//SOURCE CODEXWORLD


    function getDistance($addressFrom, $addressTo, $unit = ''){
        // Google API key
        $apiKey = 'Your_Google_API_Key';

        // Change address format
        $formattedAddrFrom    = str_replace(' ', '+', $addressFrom);
        $formattedAddrTo     = str_replace(' ', '+', $addressTo);

        // Geocoding API request with start address
        $geocodeFrom = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$formattedAddrFrom.'&sensor=false&key='.$apiKey);
        $outputFrom = json_decode($geocodeFrom);
        if(!empty($outputFrom->error_message)){
            return $outputFrom->error_message;
        }

        // Geocoding API request with end address
        $geocodeTo = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$formattedAddrTo.'&sensor=false&key='.$apiKey);
        $outputTo = json_decode($geocodeTo);
        if(!empty($outputTo->error_message)){
            return $outputTo->error_message;
        }

        // Get latitude and longitude from the geodata
        $latitudeFrom    = $outputFrom->results[0]->geometry->location->lat;
        $longitudeFrom    = $outputFrom->results[0]->geometry->location->lng;
        $latitudeTo        = $outputTo->results[0]->geometry->location->lat;
        $longitudeTo    = $outputTo->results[0]->geometry->location->lng;

        // Calculate distance between latitude and longitude
        $theta    = $longitudeFrom - $longitudeTo;
        $dist    = sin(deg2rad($latitudeFrom)) * sin(deg2rad($latitudeTo)) +  cos(deg2rad($latitudeFrom)) * cos(deg2rad($latitudeTo)) * cos(deg2rad($theta));
        $dist    = acos($dist);
        $dist    = rad2deg($dist);
        $miles    = $dist * 60 * 1.1515;

        // Convert unit and return distance
        $unit = strtoupper($unit);
        return round($miles * 1609.344, 2);
    }
