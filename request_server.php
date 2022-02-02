<?php
    $consonants = array('B','C','D','F','G','H','J','K','L','M','N','P','Q','R','S','T','V','W','X','Y','Z');
    
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if(isset($_REQUEST["name"], $_REQUEST["surname"], $_REQUEST["email"]))
        $name = strtoupper($_REQUEST["name"]);
        $surname = strtoupper($_REQUEST["surname"]);
        $email = strtoupper($_REQUEST["email"]);
        // $email_domain = explode('@', $email);
        $json = json_encode(
            array(
                'Nome' => getConsonants($name),
                'Cognome' => getConsonants($surname),
                // 'Domain' => getDomain($email)
                // 'Domain' => $email_domain[1]
                'Domain' => substr($email, strpos($email, "@")+1)
            )
        );
        var_dump(json_decode($json, true, 4));
        /*$myArray = array(
                'Nome' => getConsonants($name),
                'Cognome' => getConsonants($surname),
                'Domain' => getDomain($email)
                );
        
        echo json_encode(json_decode($myArray), JSON_PRETTY_PRINT);*/

    }else{
        http_response_code(200);
        /*$error -> info = "unico metodo consentito POST";
        echo $error;*/
    }

    function getConsonants($myString){
        $returnString = "";
        for($i = 0; $i < strlen($myString); $i++){
            if(ifConsonants($myString[$i])){
                $returnString = $returnString . $myString[$i];
            }
        }
        return $returnString;
    }

    function ifConsonants($myChar){
        global $consonants;
        if(in_array($myChar, $consonants)){return true;}
        else{
        return false;
        }
    }

    function getDomain($myString){
        $domain;
        for($i = 0; $i < strlen($myString); $i++){
            if($myString[$i] == '@'){
                $domain = substr($myString, $i+1);
            }
        }
        return $domain;
    }
?>