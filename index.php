<?php 
include("fusioncharts/fusioncharts.php");

$hostdb = "localhost";  // MySQl host
$userdb = "brohit4";  // MySQL username
$passdb = "";  // MySQL password
$namedb = "FC_SampleDB";  // MySQL database name


$dbhandle = new mysqli($hostdb, $userdb, $passdb, $namedb);


if ($dbhandle->connect_error) {
  exit("There was an error with your connection: ".$dbhandle->connect_error);
}
?>
<html>
   <head>
      <title>Creating Interactive Charts using PHP and MySQL</title>
      <script src="/path/to/fusioncharts.js"></script>
   </head>
   <body>

<?php
  

  $strQuery = "SELECT DISTINCT search_engine, search_percentage FROM pyramid_data; ";

     	$result = $dbhandle->query($strQuery) or exit("Error code ({$dbhandle->errno}): {$dbhandle->error}");

  if ($result) {
        	
	$arrData = array(
        "chart" => array(
        "theme"=> "fint",
        "caption"=> "Top 5 Search Engines (By Percentage)",
        "paletteColors"=> "#0075c2,#1aaf5d,#f2c500,#f45b00,#8e0000",
                "bgColor"=> "#ffffff",
                "showBorder"=> "0",
                "use3DLighting"=> "0",
                "showShadow"=> "0",
                "enableSmartLabels"=> "0",
                "startingAngle"=> "0",
                "showPercentValues"=> "1",
                "showPercentInTooltip"=> "0",
                "decimals"=> "1",
                "captionFontSize"=> "14",
                "subcaptionFontSize"=> "14",
                "subcaptionFontBold"=> "0",
                "toolTipColor"=> "#ffffff",
                "toolTipBorderThickness"=> "0",
                "toolTipBgColor"=> "#000000",
                "toolTipBgAlpha"=> "80",
                "toolTipBorderRadius"=> "2",
                "toolTipPadding"=> "5",
                "showHoverEffect"=> "1",
                "showLegend"=> "1",
                "legendBgColor"=> "#ffffff",
                "legendBorderAlpha"=> '0',
                "legendShadow"=> '0',
                "legendItemFontSize"=> '10',
                "pieRadius"=> "139",
                "legendItemFontColor"=> '#666666'
              	)
           	);

        	$arrData["data"] = array();

	
        	while($row = mysqli_fetch_array($result)) {
				array_push($arrData["data"], array(
					"label" => $row["search_engine"],
					"value" => $row["search_percentage"]
					)
				);
        	}	
	
            $jsonEncodedData = json_encode($arrData);
			
			 $pieChart = new FusionCharts("pie3d", "myFirstChart" , 500, 350, "chart-container", "json", $jsonEncodedData);
             $pieChart->render();
			 
             $dbhandle->close();
           
         }

 
?>
    <center>
 <div id="chart-container">Awesome Chart on its way!</div></center>
   </body>
</html>