<?php
$conn = mysqli_connect('localhost', 'root', '', 'dmce');
$sql = "SELECT allowed, request_count FROM allowed_sites";
$result = mysqli_query($conn, $sql);
$name = array();
while ($row = mysqli_fetch_array($result)) {
    array_push($name, array('country' => $row[0], 'visits' => intval($row[1])));
}
?>

<!-- Styles -->
<style>
    #chartdiv {
        width: 100%;
        height: 500px;
    }
</style>

<!-- Resources -->
<script src="https://www.amcharts.com/lib/4/core.js"></script>
<script src="https://www.amcharts.com/lib/4/charts.js"></script>
<script src="https://www.amcharts.com/lib/4/themes/material.js"></script>
<script src="https://www.amcharts.com/lib/4/themes/animated.js"></script>

<!-- Chart code -->
<!-- <script>
    // am4core.ready(function() {

    //     // Themes begin
    //     am4core.useTheme(am4themes_material);
    //     am4core.useTheme(am4themes_animated);
    //     // Themes end

    //     var chart = am4core.create("chartdiv", am4charts.XYChart);

    //     var data = [];
    //     var value = 120;

    //     var pausecontent = new Array();
    //     pausecontent = < ?php echo json_encode($name); ?>;
    //     // console.log(pausecontent);
    //     var names = new Array();
    //     var count = new Array();
    //     pausecontent.forEach(function(arrayItem){
    //         for(x in arrayItem){
    //             names.push(x);
    //             count.push(arrayItem[x]);
    //             // console.log(arrayItem[x]);
    //         }
    //     });

    //     for (var i = 0; i < names.length; i++) {
    //         data.push({
    //             category: names[i],
    //             value: count[i]
    //         });
    //     }

    //     chart.data = data;
    //     var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
    //     categoryAxis.renderer.grid.template.location = 0;
    //     categoryAxis.dataFields.category = "category";
    //     categoryAxis.renderer.minGridDistance = 15;
    //     categoryAxis.renderer.grid.template.location = 0.5;
    //     categoryAxis.renderer.grid.template.strokeDasharray = "1,3";
    //     categoryAxis.renderer.labels.template.rotation = -90;
    //     categoryAxis.renderer.labels.template.horizontalCenter = "left";
    //     categoryAxis.renderer.labels.template.location = 0.5;

    //     categoryAxis.renderer.labels.template.adapter.add("dx", function(dx, target) {
    //         return -target.maxRight / 2;
    //     })

    //     var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
    //     valueAxis.tooltip.disabled = true;
    //     valueAxis.renderer.ticks.template.disabled = true;
    //     valueAxis.renderer.axisFills.template.disabled = true;

    //     var series = chart.series.push(new am4charts.ColumnSeries());
    //     series.dataFields.categoryX = "category";
    //     series.dataFields.valueY = "value";
    //     series.tooltipText = "{valueY.value}";
    //     series.sequencedInterpolation = true;
    //     series.fillOpacity = 0;
    //     series.strokeOpacity = 1;
    //     series.strokeDashArray = "1,3";
    //     series.columns.template.width = 0.01;
    //     series.tooltip.pointerOrientation = "horizontal";

    //     var bullet = series.bullets.create(am4charts.CircleBullet);

    //     chart.cursor = new am4charts.XYCursor();

    //     // chart.scrollbarX = new am4core.Scrollbar();
    //     // chart.scrollbarY = new am4core.Scrollbar();


    // }); // end am4core.ready()

    am4core.ready(function () {

        // Themes begin
        am4core.useTheme(am4themes_animated);
        // Themes end

        var chart = am4core.create("chartdiv", am4plugins_wordCloud.WordCloud);
        chart.fontFamily = "Courier New";
        var series = chart.series.push(new am4plugins_wordCloud.WordCloudSeries());
        series.randomness = 0.1;
        series.rotationThreshold = 0.5;

        series.data = '<?php echo json_encode($name); ?>';
        console.log('<?php echo json_encode($name); ?>');
        // Create axes
        series.dataFields.word = "tag";
        series.dataFields.value = "count";

        series.heatRules.push({
            "target": series.labels.template,
            "property": "fill",
            "min": am4core.color("#0000CC"),
            "max": am4core.color("#CC00CC"),
            "dataField": "value"
        });

        series.labels.template.url = "https://stackoverflow.com/questions/tagged/{word}";
        series.labels.template.urlTarget = "_blank";
        series.labels.template.tooltipText = "{word}: {value}";

        var hoverState = series.labels.template.states.create("hover");
        hoverState.properties.fill = am4core.color("#FF0000");

        var subtitle = chart.titles.create();
        subtitle.text = "(click to open)";

        var title = chart.titles.create();
        title.text = "Most Popular Tags @ StackOverflow";
        title.fontSize = 20;
        title.fontWeight = "800";

    });
</script> -->
<script>
am4core.ready(function() {

// Themes begin
am4core.useTheme(am4themes_animated);
am4core.useTheme(am4themes_material);
// Themes end

// Create chart instance
var chart = am4core.create("chartdiv", am4charts.XYChart);
chart.scrollbarX = new am4core.Scrollbar();

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

<!-- HTML -->
<div id="chartdiv"></div>


</body>

</html>