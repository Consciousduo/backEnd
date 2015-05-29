<?php
    //service ID=0
    //username password match
    //sample url http://localhost:8888/q-cigarettes.php?service=0&username=winky&password=abcdef
    //return {"success":"1","ID":"1"} or {"success":"0"}
    if($_GET['service']==0){
    $user = 'root';
    $password = 'root';
    $db = 'Q-cigarettes';
    $host = 'localhost';
    $port = 3306;
    
    $link = mysqli_init();
    $success = mysqli_real_connect(
                                   $link,
                                   $host, 
                                   $user, 
                                   $password, 
                                   $db,
                                   $port
                                   );
    
    $sql_query ="SELECT password FROM Registration WHERE username='".$_GET['username']."'";
    $result = mysqli_query($link, $sql_query);
    $array = $result->fetch_assoc();
    
    if($array['password'] == $_GET['password']){
        //password match login
        $sql_query ="SELECT ID FROM Registration WHERE username='".$_GET['username']."'";
        $result = mysqli_query($link, $sql_query);
        $array = $result->fetch_assoc();
        $arr = array('success' => '1', 'ID' => $array['ID']);
        $resultJSON=json_encode($arr);
        echo $resultJSON;
    
    }else{
        //password not match
        $arr = array('success' => '0');
        $resultJSON=json_encode($arr);
        echo $resultJSON;
    }
        //exit program
        exit;
    }
    //service ID=0//
    
    //service ID=1
    //sample url http://localhost:8888/q-cigarettes.php?service=1&id=0&date=2015-05-28&time=20:01:00
    //return all message received before that date
    if($_GET['service']==1){
        $date = new DateTime($_GET['date'].$_GET['time']);
        echo $date->format('Y-m-d H:i:s');
        exit;
    }
    //service ID=1//
    
    //service ID=2
    if($_GET['service']==2){
        
        echo "222";
        exit;
    }
    //service ID=2//
    
?>



