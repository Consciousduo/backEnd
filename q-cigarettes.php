
<?php
    //connect to the database
    $user = 'root';
    $password = 'root';
    $db = 'Q-cigarettes';
    $host = 'localhost';
    $port = 3306;
    
    $link = mysqli_init();
    $success = mysqli_real_connect($link,$host,$user,$password,$db,$port);
    
    
    
    //http://localhost:8888/q-cigarettes.php
    //service ID=0
    //username password match
    //sample url http://localhost:8888/q-cigarettes.php?service=0&username=winky&password=abcdef
    //return {"success":"1","ID":"1"} or {"success":"0"}
    if($_POST['service']==0){
    
    $sql_query = "SELECT password FROM Registration WHERE email='".$_POST['email']."'";
    $result = mysqli_query($link, $sql_query);
    $array = $result->fetch_assoc();
    
    if($array['password'] == $_POST['password']){
        //password match login
        $sql_query ="SELECT ID FROM Registration WHERE email='".$_POST['email']."'";
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

    
    
    //service ID=1
    //sample url http://localhost:8888/q-cigarettes.php?service=1&id=0&date=2015-05-28&time=20:01:00
    //return all message for id=0 received before date=2015-05-28&time=20:01:00
    if($_POST['service']==1){

        $sql_query = "SELECT `sender_id`, `message`, `type`, `time` FROM `CustomMessage` WHERE receiver_id=".$_POST['id']." and time>'".$_POST['date']." ".$_POST['time']."'";
        $result = mysqli_query($link, $sql_query);
        
        $row = $result->fetch_assoc();
        $arr = array($row['sender_id'], $row['message'], $row['type'], $row['time']);
        while ($row = $result->fetch_assoc()) {
            array_push($arr, $row['sender_id'], $row['message'], $row['type'], $row['time']);
        }
        
        //$date = new DateTime($_POST['date'].$_POST['time']);
        //echo $date->format('Y-m-d H:i:s');
        $resultJSON=json_encode($arr);
        echo $resultJSON;
        exit;
    }

    
    
    //service ID=2
    //sample url http://localhost:8888/q-cigarettes.php?service=2&sid=2&rid=0&date=2018-05-29&time=10:01:00&message=testmessage
    //send a message from sid to rid with time
    if($_POST['service']==2){
        
        //INSERT INTO `CustomMessage`(`sender_id`, `receiver_id`, `message`, `time`) VALUES (2,0,"testmessage",'2015-05-29 20:01:00')
        $sql_query = "INSERT INTO `CustomMessage`(`sender_id`, `receiver_id`, `message`, `type`, `time`) VALUES (".$_POST['sid'].",".$_POST['rid'].",'".$_POST['message']."',".$_POST['type'].",'".$_POST['date']." ".$_POST['time']."')";
        $result = mysqli_query($link, $sql_query);
        if($result==TRUE){
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

    
    
    
    //service ID=3
    //change password
    //input id, newpassword
    //output success or fail
    if($_POST['service']==3){
        //SELECT `id` FROM `Registration` WHERE `id`=1
        $sql_query = "SELECT `id` FROM `Registration` WHERE `id`=".$_POST['id'];
        $result = mysqli_query($link, $sql_query);
        if($result->fetch_assoc()){
        //UPDATE `Registration` SET `password`='abcd' WHERE `id`=1
        $sql_query = "UPDATE `Registration` SET `password`='".$_POST['newpassword']."' WHERE `id`=".$_POST['id'];
        $result = mysqli_query($link, $sql_query);
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

    
    
    //service ID=4
    //add new user
    //input email password phone first last age date time
    //everything need to be checked before using this service as a tool to put everything into the table
    //output success or fail
    //SELECT `id` FROM `Registration` order by ID desc limit 1
    /*INSERT INTO `Registration`(`id`, `password`, `email`, `phone`, `first`, `last`, `age`, `modify`, `created`) VALUES (5, '12345', '123@usc.edu', '765-775-6412', 'duo', 'zhao', 20, '2015-06-06 20:20:20','2015-06-06 20:20:20')*/

    
    if($_POST['service']==4){
        
        
        $sql_query = "SELECT `id` FROM `Registration` order by id desc limit 1";
        $result = mysqli_query($link, $sql_query);
        $row = $result->fetch_assoc();
        $user_id = (intval($row['id'])+1);
        
        $sql_query = "INSERT INTO `Registration`(`id`, `password`, `email`, `phone`, `first`, `last`, `age`, `modify`, `created`) VALUES (".$user_id.",'".$_POST['password']."','".$_POST['email']."','".$_POST['phone']."','".$_POST['first']."','".$_POST['last']."',".$_POST['age'].",'".$_POST['date_time']."','".$_POST['date_time']."')";
        $result = mysqli_query($link, $sql_query);
        if($result==TRUE){
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
    
    
    
?>



















