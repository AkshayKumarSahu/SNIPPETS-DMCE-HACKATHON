<?php 

$conn = mysqli_connect('localhost', 'root','','dmce');

if(isset($_POST['abcd'])){
    $j='';
   $res =  mysqli_query($conn,'SELECT * FROM `files`');
   $i=0;
    if(mysqli_num_rows($res)>0){
        while($row=mysqli_fetch_array($res)){
            $j.='
            <div class="m-2">
            <div class="card-body p-3 border bg-light ">
            <button onclick="deldrive(\''.$row['fid'].'\')" class="float-right text-danger btn btn-lg"> x </button>
            <div onclick="showimg(\'imagebox'.$i.'\')" style="cursor:pointer;" >
            <i class="las la-file-image h3 text-primary"></i>'.$row['filename'].'</div>
            <div style="display:none;" class="mt-3" id="imagebox'.$i.'">
                <img src="./files/'.$row['filename'].'" class="img-thumbnail w-25" alt="Image">
            </div>
            </div>
                
            </div>';$i++;
        }
    }else{
        $j='<p class="alert alert-danger">No Image Found</p>';
    }
    echo $j;
}

if(isset($_POST['t'])){
    $j='';
   $res =  mysqli_query($conn,'SELECT * FROM `allowed_sites` ORDER BY id DESC');
   $i=0;$r=array();
    if(mysqli_num_rows($res)>0){
        while($row=mysqli_fetch_array($res)){
            $j.='<div class="m-2 " ><div class="card-body p-3 border bg-light ">
            <button class="float-right  btn btn-outline-info" onclick="showimg(\'infobox'.$i.'\')"> View Granted Permission. </button>
            <div>
            <i class="las la-globe h3 text-success"></i>
            '.$row['allowed'].'</div>
            <div style="display:none;" class="mt-3" id="infobox'.$i.'">
            <p class="alert alert-info"><b>Granted Permission:</b><br>';
            $r=explode('-',$row['info']);
            foreach($r as $a){
                $j.=$a.'<br>';                
            }
                $j.='</p>
            </div>
            </div>
            </div>';$i++;
        }
    }else{
        $j='<p class="alert alert-danger">No Websites Found</p>';
    }
    echo $j;
}
if(isset($_POST['access'])){
    $j='';
   $res =  mysqli_query($conn,'SELECT * FROM `notifications`');
   $i=0;
    if(mysqli_num_rows($res)>0){
        while($row=mysqli_fetch_array($res)){
            $j.='
            <div class="m-2 " >
            <div class="card-body p-3 border bg-light ">
            <div class="text-danger " onclick="showimg(\'access'.$i.'\')" style="cursor:pointer;" >
            <i class="las la-exclamation h3 text-dark"></i>
            Website <b>"'.$row['websiteName'].'"</b> wants to access your data.<br> The request was made at <b>"'.$row['time'].'"</b>  from IP '.$row['ipaddr'].'. <br> Do not allow if it wasnt you.</div><br>
                <div style="display:none;" class="m-2 text-dark" id="access'.$i.'">
                <hr>
                    <input type="checkbox" class="get_value" name="chec[]" value="adharcard" id="chec1"><label for="chec1">Aadhar</label><br>
                    <input type="checkbox" class="get_value" name="chec[]" value="pancard" id="chec2"><label for="chec2">Pan Card</label><br>
                    <input type="checkbox" class="get_value" name="chec[]" value="email" id="chec3"><label for="chec3">Email Id</label><br>
                    <input type="checkbox" class="get_value" name="chec[]" value="marks" id="chec4"><label for="chec4">Marksheet</label><br>
                    <hr>
                    <button class="btn btn-info" onclick="sendadd(\''.$row['uid'].'\')">Add Website</button>
                    <button onclick="hide(\'access'.$i.'\')" class="mx-3 btn btn-dark">Cancel</button>
                </div>
            </div>
            </div>';$i++;
        }
    }else{
        $j='<p class="alert alert-danger">No Websites Found</p>';
    }
    echo $j;
}
if(isset($_POST['update'])){
    $uid= $_POST['id'];
    $list= explode(',',$_POST['languages']);
    $docs="";
    foreach($list as $y){
        $docs .=$y."-"; 
    }
    $reasu = mysqli_query($conn,"SELECT `websiteName`,`ipaddr` FROM `notifications` WHERE `uid` = '$uid'");
    if($reasu){
        $row = mysqli_fetch_assoc($reasu);
        $to = $row['websiteName'];
        $ipaddr = $row['ipaddr'];
        if(mysqli_query($conn,"INSERT INTO `allowed_sites`( `allowed`,`info`,`ipaddr`,`uid`) VALUES ('$to','$docs','$ipaddr','$uid')")){
            if(mysqli_query($conn,"DELETE FROM `notifications` WHERE `uid`= '$uid' AND `websiteName` = '$to'")){
                echo 'alldone';
            }
        }
}
}
if(isset($_POST['delid'])){
    $delid= $_POST['delid'];
    $reasu = mysqli_query($conn,"SELECT `filename` FROM `files` WHERE `fid` = '$delid'");
    $r = mysqli_fetch_assoc($reasu);

    if (unlink('./files/'.$r['filename'])) {
        if(mysqli_query($conn,"DELETE FROM `files` WHERE `fid`= '$delid'")){

            echo ("Deleted $file");
        }
        } else {
            echo ("Error deleting $file");
      }
}

?>