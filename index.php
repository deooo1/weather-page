<?php


error_reporting(E_ALL);
ini_set('display_errors', 1);

$baseUrl = 'https://query.yahooapis.com/v1/public/yql?q=%%sql%%&format=json&env=store%3A%2F%2Fdatatables.org%2Falltableswithkeys';
$yql = 'select * from weather.forecast where woeid in (select woeid from geo.places(1) where text="sofia") and u="c"';

$url = str_replace('%%sql%%', rawurlencode($yql), $baseUrl);
$result = file_get_contents($url);
$data = json_decode($result, true);

$intersection = ['title', 'wind', 'atmosphere', 'astronomy', 'item'];
$forecast = array_intersect_key($data['query']['results']['channel'], array_flip($intersection));
?>


<p>
  <?php echo $forecast['title']; ?>
</p>
<p>
  Sunrise: <?php echo $forecast['astronomy']['sunrise']; ?>
  Sunset: <?php echo $forecast['astronomy']['sunset']; ?>
</p>
<p>
  Date: <?php echo $forecast['item']['condition']['date']; ?>
</p>
<p>
  Temperature: <?php echo $forecast['item']['condition']['temp']; ?>&deg;
  Codition: <?php echo $forecast['item']['condition']['text']; ?>
</p>
<p>
  Next Days:
</p>
<?php foreach ($forecast['item']['forecast'] as $daylyData): ?>
  <p>
    Day: <?php echo $daylyData['date'] ?>
    Temp: <?php echo $daylyData['low'] ?>&deg; / <?php echo $daylyData['high'] ?>&deg;
    Condition: <?php echo $daylyData['text'] ?>
  </p>
<?php endforeach; ?>


<?php
echo '<pre>';
var_dump(array_keys($forecast))  . "\n";
var_dump($forecast)  . "\n";
// echo http_build_query(['q' => $yql]) . "\n";
// echo urlencode($yql) . "\n";
// echo 'select%20*%20from%20weather.forecast%20where%20woeid%20in%20(select%20woeid%20from%20geo.places(1)%20where%20text%3D%22nome%2C%20ak%22)&format=json&env=store%3A%2F%2Fdatatables.org%2Falltableswithkeys' ."\n";
// echo rawurlencode($yql) . "\n";

// echo var_dump(file_get_contents('https://query.yahooapis.com/v1/public/yql?q=select%20*%20from%20weather.forecast%20where%20woeid%20in%20(select%20woeid%20from%20geo.places(1)%20where%20text%3D%22nome%2C%20ak%22)&format=json&env=store%3A%2F%2Fdatatables.org%2Falltableswithkeys'));
