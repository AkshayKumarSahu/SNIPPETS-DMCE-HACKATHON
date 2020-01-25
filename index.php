<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <title>Drive</title>
  </head>
  <body>
<style>
#fixedbutton {
    position: fixed;
    bottom: 10%;
    right: 5%; 
    z-index:1;
    border-radius: 50%;
    color:white;
    padding:8px 15px;
    outline:none;
    border:none;
}
 #chartdiv {
        width: 100%;
        height: 500px;
    }
</style>
<?php
  session_start();
  if(!isset($_SESSION['uid'])){
		header("location:login.php");
  }
  $conn = mysqli_connect('localhost', 'root', '', 'dmce');
$sql = "SELECT allowed, request_count FROM allowed_sites";
$result = mysqli_query($conn, $sql);
$name = array();
while ($row = mysqli_fetch_array($result)) {
    array_push($name, array('country' => $row[0], 'visits' => intval($row[1])));
}
?>
<!-- Resources -->
<script src="https://www.amcharts.com/lib/4/core.js"></script>
<script src="https://www.amcharts.com/lib/4/charts.js"></script>
<script src="https://www.amcharts.com/lib/4/themes/material.js"></script>
<script src="https://www.amcharts.com/lib/4/themes/animated.js"></script>

<script>
am4core.ready(function() {

// Themes begin
am4core.useTheme(am4themes_animated);
am4core.useTheme(am4themes_material);
// Themes end

// Create chart instance
var chart = am4core.create("chartdiv", am4charts.XYChart);
// chart.scrollbarX = new am4core.Scrollbar();

// Add data
// Add data
chart.data = <?php echo json_encode($name); ?>;
console.log('<?php echo json_encode($name); ?>');

// Create axes
var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
categoryAxis.dataFields.category = "country";
categoryAxis.renderer.grid.template.location = 0;
categoryAxis.renderer.minGridDistance = 30;
categoryAxis.renderer.labels.template.horizontalCenter = "right";
categoryAxis.renderer.labels.template.verticalCenter = "middle";
categoryAxis.renderer.labels.template.rotation = 270;
categoryAxis.tooltip.disabled = true;
categoryAxis.renderer.minHeight = 110;

var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
valueAxis.renderer.minWidth = 50;

// Create series
var series = chart.series.push(new am4charts.ColumnSeries());
series.sequencedInterpolation = true;
series.dataFields.valueY = "visits";
series.dataFields.categoryX = "country";
series.tooltipText = "[{categoryX}: bold]{valueY}[/]";
series.columns.template.strokeWidth = 0;

series.tooltip.pointerOrientation = "vertical";

series.columns.template.column.cornerRadiusTopLeft = 10;
series.columns.template.column.cornerRadiusTopRight = 10;
series.columns.template.column.fillOpacity = 0.8;

// on hover, make corner radiuses bigger
var hoverState = series.columns.template.column.states.create("hover");
hoverState.properties.cornerRadiusTopLeft = 0;
hoverState.properties.cornerRadiusTopRight = 0;
hoverState.properties.fillOpacity = 1;

series.columns.template.adapter.add("fill", function(fill, target) {
  return chart.colors.getIndex(target.dataItem.index);
});

// Cursor
chart.cursor = new am4charts.XYCursor();

}); // end am4core.ready()
</script>
<div>
<nav class="navbar navbar-dark bg-dark">
    <a class="navbar-brand" href="#"><i class="las la-shekel-sign h3"></i> &nbsp;Secure Drive</a>
    
      <ul class="navbar-nav float-right">
        <li class="nav-item m-2 rounded bg-secondary active">
          <a class="nav-link p-2" href="logout.php">Sign Out <span class="sr-only">(current)</span></a>
        </li>
      </ul>
  </nav>

    <main role="main" class="">
        <h1 class="h2 py-3 px-5"></h1>
      <div class="row container-fluid">
        <div class="col-lg-3 border-right">
          <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
            <a class="nav-link active" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true">My Drive</a>
            <a class="nav-link" id="v-pills-messages-tab" data-toggle="pill" href="#v-pills-messages" role="tab" aria-controls="v-pills-messages" aria-selected="false">Approved Websites</a>
            <a class="nav-link" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="false">Alerts</a>
            <a class="nav-link" id="v-pills-graph-tab" data-toggle="pill" href="#v-pills-graph" role="tab" aria-controls="v-pills-graph" aria-selected="false">Activity Tracking</a>
          </div>
        </div>
        <div class="col-lg-9 col-12 ">
          <div class="tab-content" id="v-pills-tabContent">
            <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                <a href="fileUpload.php" id="fixedbutton" class="shadow-lg bg-info" ><i class="h3 pt-2 las la-plus"></i></a>
                <h3 class="py-3">Your Drive</h3>
                
                <div id="images"></div>
            </div>  
            <div class="tab-pane fade" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab">
                <h3>Your Approved Websites</h3>
                <div id="allowed"></div>
            </div>
            <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                <h3>Websites trying to access your data</h3>
                <div id="alerts"></div>
            </div>
            <div class="tab-pane fade" id="v-pills-graph" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                <h3>Activity Tracking</h3>
                <div id="chartdiv"></div>
            </div>
          </div>
        </div>
      </div>
    </main>
  </div>
    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script>
    $(document).ready(function(){
      getimagelist();
      getallowed();
      getaccess();
    });
    function getimagelist(){
      var abcd= 'abcd';
      $.ajax({
        type: "post",
        url: "main.php",
        data:{abcd:abcd},
        success: function (response) {
        $('#images').html(response);
        }
      });
    }
    function getallowed(){
      $.ajax({
        type: "post",
        url: "main.php",
        data: {t:'name'},
        success: function (response) {
          $('#allowed').html(response);
        }
      });
    }
    function deldrive(id){
      var conf = confirm('Do you want to delete ?');
      if(conf){

      $.ajax({
        type: "post",
        url: "main.php",
        data: {delid:id},
        success: function (response) {
          getimagelist();
        }
      });
      }
    }
    function getaccess(){
      $.ajax({
        type: "post",
        url: "main.php",
        data: {access:'name'},
        success: function (response) {
          $('#alerts').html(response);
        }
      });
    }
    function showimg(name){
      $('#'+name).toggle();          

    }
    function sendadd(i){
      alert(i);
      var languages = [];  
           $('.get_value').each(function(){  
                if($(this).is(":checked"))  
                {  
                     languages.push($(this).val());  
                }  
           });  
           languages = languages.toString();  
           alert(languages); 
           $.ajax({  
                url:"main.php",  
                method:"POST",  
                data:{languages:languages,id:i,update:'newweb'},  
                success:function(data){  
                  if(data == 'alldone'){
                    getaccess();
                    getallowed();
                  }
                }  
           });  
    }
    function checks(i) { 
            $('#div'+i).slideDown('fast');          
        }
    function hide(i) { 
            $('#div'+i).slideUp('fast');          
        }
    </script>
</body>
</html>