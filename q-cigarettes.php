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
    /////////////////////////////////////////
    
    //service ID=1
    //sample url http://localhost:8888/q-cigarettes.php?service=1&id=0&date=2015-05-28&time=20:01:00
    //return all message for id=0 received before date=2015-05-28&time=20:01:00
    if($_GET['service']==1){
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

        $sql_query ="SELECT `sender_id`, `message`, `time` FROM `CustomMessage` WHERE receiver_id=".$_GET['id']." and time>'".$_GET['date']." ".$_GET['time']."'";
        $result = mysqli_query($link, $sql_query);
        
        $row = $result->fetch_assoc();
        $arr = array($row['sender_id'], $row['message'], $row['time']);
        while ($row = $result->fetch_assoc()) {
            array_push($arr, $row['sender_id'], $row['message'], $row['time']);
        }
        
        //$date = new DateTime($_GET['date'].$_GET['time']);
        //echo $date->format('Y-m-d H:i:s');
        $resultJSON=json_encode($arr);
        echo $resultJSON;
        exit;
    }
    /////////////////////////////////////////
    
    //service ID=2
    //sample url http://localhost:8888/q-cigarettes.php?service=2&sid=2&rid=0&date=2018-05-29&time=10:01:00&message=testmessage
    if($_GET['service']==2){
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
        //INSERT INTO `CustomMessage`(`sender_id`, `receiver_id`, `message`, `time`) VALUES (2,0,"testmessage",'2015-05-29 20:01:00')
        $sql_query ="INSERT INTO `CustomMessage`(`sender_id`, `receiver_id`, `message`, `time`) VALUES (".$_GET['sid'].",".$_GET['rid'].",'".$_GET['message']."','".$_GET['date']." ".$_GET['time']."')";
        $result = mysqli_query($link, $sql_query);
        if($result==True){
            $arr = array('success' => '1');
            $resultJSON=json_encode($arr);
            echo $resultJSON;
        }else{
            $arr = array('success' => '0');
            $resultJSON=json_encode($arr);
            echo $resultJSON;
        }
        exit;
    }
    /////////////////////////////////////////
    
?>




















