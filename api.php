<?php
    extract($_POST);
    // $getData=1;
    // echo '5e2b25d2170b2';
    // $list=array("email");
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Credentials: true ");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Allow-Headers: Content-Type, Depth, User-Agent, X-File-  Size, X-Requested-With, If-Modified-Since, X-File-Name, Cache-Control");
    if(isset($getData)){
        if($_SERVER['HTTP_REFERER']!=''){
           
        if(array_search("password",$list)>-1 || array_search("uid",$list)>-1){
            $response['error']="Wrong api format";
            echo json_encode($response);
            exit();
        }
        // var_dump($_SERVER);
        $conn = new mysqli('localhost','root','','dmce') or die(mysqli_error($conn));
        $headers=getallheaders();
        $allowed_sites=array();
        
        $response=array();
        $host = $_SERVER['HTTP_REFERER'];
        $sql="SELECT allowed from allowed_sites where uid=?";
        $uid=mysqli_real_escape_string($conn,$uid);
        $stmt=$conn->prepare($sql);
        $stmt->bind_param("s",$uid);
        $stmt->execute();
        $result = $stmt-> get_result();
        $flag=False;

        $head=array();
        $sql2 = "SHOW COLUMNS FROM data";
        $result2 = mysqli_query($conn,$sql2);
        
        // var_dump($row);
        while($row2=mysqli_fetch_array($result2,MYSQLI_NUM)){
            array_push($head,$row2[0]);
        }

        while($row = $result->fetch_assoc()){
            if($row['allowed']==$host){
                $flag=True;
                break;
        }
        }

        if($flag){
            $sql="SELECT * FROM data WHERE uid=?";
            $stmt=$conn->prepare($sql);
            $stmt->bind_param("s",$uid);
            $stmt->execute();
            $result = $stmt-> get_result();
            $row = $result->fetch_assoc();
            
            $infoquery="SELECT info FROM allowed_sites WHERE uid=? AND allowed=?";
            $stmt=$conn->prepare($infoquery);
            $stmt->bind_param("ss",$uid,$host);
            $stmt->execute();
            $result1 = $stmt-> get_result();
            $row1 = $result1->fetch_assoc();
            $info=explode('-',$row1['info']);

            $n=count($list); 
            for($i=0; $i<$n; $i++){
                if(array_search($list[$i],$info)>-1 && array_search($list[$i],$head)>-1){
                    $response[$list[$i]]=$row[$list[$i]];
                }
            }
            
            $sql3="UPDATE allowed_sites SET request_count=request_count+1 WHERE uid=? AND allowed=?";
            $stmt=$conn->prepare($sql3);
            $stmt->bind_param("ss",$uid,$host);
            $stmt->execute();
            echo json_encode($response);
            exit();
        }
        else{
            $info='';
            for($i=0; $i<count($list); $i++){
                
                $info.=$list[$i];
                if($i==count($list)-1)
                    break;
                else
                    $info.='-';
            }
            // var_dump($info);
            echo $_SERVER['REMOTE_ADDR'];
            $webname = $host;
            $ipaddr = $_SERVER['REMOTE_ADDR'];
            $time= date('d-m-Y h:i:s');

            // $webname=$headers['Host'];
            // $sql="SELECT * FROM notifications WHERE uid=? AND ";
            // $stmt=$conn->prepare($sql);
            // $stmt->bind_param("ss",$uid,$message);
            // $stmt->execute();
            // $result = $stmt-> get_result();
            // if(mysqli_num_rows($result)>0){
            //     $sql="UPDATE notifications SET request_count=request_count+1 WHERE uid=? AND message=?";
            //     $stmt=$conn->prepare($sql);
            //     $stmt->bind_param("ss",$uid,$message);
            //     $stmt->execute();
            // }
            // else{
                $sql="INSERT INTO notifications (`uid`,`websiteName`,`ipaddr`,`time`, `info`) VALUES ('$uid', '$webname','$ipaddr','$time','$info')";
                mysqli_query($conn, $sql);
            // }
            exit();
        }
    }   
}
else{
    echo 'invalid Request';
}  

?>