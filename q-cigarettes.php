<?php
    //service ID=0
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
    
    //service ID=1
    if($_GET['service']==1){
        
        echo "111";
        exit;
    }
    
    //service ID=2
    if($_GET['service']==2){
        
        echo "222";
        exit;
    }
    
?>



