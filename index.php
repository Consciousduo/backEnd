<?php
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST');

    date_default_timezone_set('America/Los_Angeles');
    $url = "http://www.zillow.com/webservice/GetDeepSearchResults.htm?zws-id=X1-ZWz1dxtdtevpjf_3wguv&address=";
    $stArray = explode(" ",trim($_GET["streetInput"]));
    $length=count($stArray);
    
    $url.=$stArray[0];
    for($x=1; $x<$length; $x++){
        $url.="+";
        $url.=$stArray[$x];
    }
    $url=$url."&citystatezip=";
    
    
    $stArray = explode(' ',trim($_GET["cityInput"]));
    $length=count($stArray);
    
    $url=$url.$stArray[0];
    for($x=1; $x<$length; $x++){
        $url=$url."+".$stArray[$x];
    }
    $url=$url."%2C+".$_GET["stateInput"]."&rentzestimate=true";
    
    global $returnedXML;
    $returnedXML = simplexml_load_file ($url);
    $resultJSON;
    $valueChangeSign;
    
    if(floatval($returnedXML->response->results->result->zestimate->valueChange)< 0){
        $valueChangeSign='-';
    }else{
        $valueChangeSign='+';
    }
    
    $restimateValueChangeSign;
    if(floatval($returnedXML->response->results->result->rentzestimate->valueChange)< 0){
        $restimateValueChangeSign='-';
    }else{
        $restimateValueChangeSign='+';
    }

    
    
    
    $estimateValueChange;
    if(floatval($returnedXML->response->results->result->zestimate->valueChange)< 0){
        $estimateValueChange = "$".number_format(-floatval($returnedXML->response->results->result->zestimate->valueChange),2);
    }else{
        $estimateValueChange = "$".number_format(floatval($returnedXML->response->results->result->zestimate->valueChange),2);
    }
    
    $restimateValueChange;
    
    if(floatval($returnedXML->response->results->result->rentzestimate->valueChange)< 0){
        $restimateValueChange = "$".number_format(-floatval($returnedXML->response->results->result->rentzestimate->valueChange),2);
    }else{
        $restimateValueChange = "$".number_format(floatval($returnedXML->response->results->result->rentzestimate->valueChange),2);
    }
    
    
    $chartOneUrl="http://www.zillow.com/webservice/GetChart.htm?zws-id=X1-ZWz1dxtdtevpjf_3wguv&unit-type=percent&zpid=".$returnedXML->response->results->result->zpid."&width=600&height=300&chartDuration=1year";
    $chartFiveUrl="http://www.zillow.com/webservice/GetChart.htm?zws-id=X1-ZWz1dxtdtevpjf_3wguv&unit-type=percent&zpid=".$returnedXML->response->results->result->zpid."&width=600&height=300&chartDuration=5years";
    $chartTenUrl="http://www.zillow.com/webservice/GetChart.htm?zws-id=X1-ZWz1dxtdtevpjf_3wguv&unit-type=percent&zpid=".$returnedXML->response->results->result->zpid."&width=600&height=300&chartDuration=10years";
    
    $returnedChartOne = simplexml_load_file ($chartOneUrl);
    $returnedChartFive = simplexml_load_file ($chartFiveUrl);
    $returnedChartTen = simplexml_load_file ($chartTenUrl);
    
    $urlOne = $returnedChartOne->response->url;
    $urlFive = $returnedChartFive->response->url;
    $urlTen = $returnedChartTen->response->url;



    
    $arr = array('success' => (string)$returnedXML->message->code,
                 'homedetails' => (string)$returnedXML->response->results->result->links->homedetails,
                 'street' => (string)$returnedXML->response->results->result->address->street,
                 'city' => (string)$returnedXML->response->results->result->address->city,
                 'state' => (string)$returnedXML->response->results->result->address->state,
                 'zipcode' => (string)$returnedXML->response->results->result->address->zipcode,
                 'useCode' => (string)$returnedXML->response->results->result->useCode,
                 'lastSoldPrice'=> "$".number_format(floatval($returnedXML->response->results->result->lastSoldPrice),2),
                 'yearBuilt'=> (string)$returnedXML->response->results->result->yearBuilt,
                 'lastSoldDate' => date("d-M-Y", strtotime($returnedXML->response->results->result->lastSoldDate)),
                 'lotSizeSqFt' => $returnedXML->response->results->result->lotSizeSqFt." sq.ft.",
                 'estimateLastUpdate' =>date("d-M-Y", strtotime($returnedXML->response->results->result->zestimate->{'last-updated'})),
                 'estimateAmount' => "$".number_format(floatval($returnedXML->response->results->result->zestimate->amount),2),
                 'finishedSqFt' => $returnedXML->response->results->result->finishedSqFt." sq.ft.",
                 'estimateValueChangeSign' => $valueChangeSign,
                 'imgn' => "http://cs-server.usc.edu:45678/hw/hw6/down_r.gif",
                 'imgp' => "http://cs-server.usc.edu:45678/hw/hw6/up_g.gif",
                 'estimateValueChange' => $estimateValueChange,
                 'bathrooms' => (string)$returnedXML->response->results->result->bathrooms,
                 'estimateValuationRangeLow' => "$".number_format(floatval($returnedXML->response->results->result->zestimate->valuationRange->low),2),
                 'estimateValuationRangeHigh' => "$".number_format(floatval($returnedXML->response->results->result->zestimate->valuationRange->high),2),
                 'bedrooms' => (string)$returnedXML->response->results->result->bedrooms,
                 'restimateLastUpdate' => date("d-M-Y", strtotime($returnedXML->response->results->result->rentzestimate->{'last-updated'})),
                 'restimateAmount' => "$".number_format(floatval($returnedXML->response->results->result->rentzestimate->amount),2),
                 'taxAssessmentYear' => (string)$returnedXML->response->results->result->taxAssessmentYear,
                 'restimateValueChangeSign' => $restimateValueChangeSign,
                 'restimateValueChange' => $restimateValueChange,
                 'taxAssessment' => "$".number_format(floatval($returnedXML->response->results->result->taxAssessment),2),
                 'restimateValuationRangeLow' => "$".number_format(floatval($returnedXML->response->results->result->rentzestimate->valuationRange->low),2),
                 'restimateValuationRangeHigh'=> "$".number_format(floatval($returnedXML->response->results->result->rentzestimate->valuationRange->high),2),
                 'chartOne' => (string)$urlOne,
                 'chartFive' => (string)$urlFive,
                 'chartTen' => (string)$urlTen
            
                 );
    
    $resultJSON=json_encode($arr);
    
    
    

    echo $resultJSON;
    
?>



