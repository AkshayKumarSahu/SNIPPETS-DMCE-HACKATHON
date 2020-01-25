<?php
    $conn = mysqli_connect('localhost', 'root','','dmce');

    $filename = $_POST['filename'];

        
    $target_directory = "files/";

    $target_file = $target_directory.basename($_FILES['file']['name']);

    $filetype = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    $filename .= ".".$filetype;
    $query="INSERT INTO files(filename) VALUES('$filename')";

        if(mysqli_query($conn,$query)){
            $newfilename = $target_directory.$filename;
            
            if(move_uploaded_file($_FILES["file"]["tmp_name"],$newfilename)) echo 1;
            else echo filesize($filename);
    };


    
?>