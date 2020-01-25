<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
<style>

input[type=file]::-webkit-file-upload-button {
  border: 1px solid rgb(255, 255, 255);
  padding: 12px 12px;
  color: white;
  border-radius: 3px;
  background-color: #b66dff;
  border-color: #b66dff;
  -webkit-transition: opacity 0.3s ease;
  transition: opacity 0.3s ease;
  cursor: pointer;
}
input[type=file]::-webkit-file-upload-button:hover{
  background: -webkit-gradient(linear, left top, right top, from(#d89ff3), to(#b184f5));
  background: linear-gradient(to right, #d89ff3, #b184f5);
}
</style>    
</head>
<script>
    function uploadFile(){
        var filename = $('#filename').val();
        var file_data = $('.fileToUpload').prop('files')[0];
        var form_data = new FormData();
        form_data.append("file",file_data);
        form_data.append("filename", filename);

        $.ajax({
            url: "fileUpload.inc.php",
            type: "POST",
            dataType: 'script',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            success:function(dat2){
                console.log(dat2);
                if(dat2 == 1) alert("successful");
                else alert(dat2); 
                $('#filename').val('');
                $('#abcds').val('');
                setTimeout(() => {
                    window.location.href="index.php";
                }, 200);
            }

        });
    }
</script>
<body>

        <hr>
        <center>

            <div class="container mt-5">
                <input type="file" class="fileToUpload m-3" id="abcds"></input><br>
                <input type="text" placeholder="File Name" id="filename" name="file" class="w-50 form-control"><br>
                <button class="btn w-25 btn-outline-success" onclick="uploadFile()">Upload</button>
                <a class="btn w-25 btn-outline-danger" href="./index.php" >Cancel</a>
            </div>
        </center>
            <br>        
</body>
</html>