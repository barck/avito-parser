<html>
<head>
  <style>
    .item{
      display: block;
      width: 100%;
      clear: both;
      margin-bottom: 10px;
      height: 60px;
      text-decoration: none;
    }
    .item img{
      float: left;
      height: 60px;
    }
    .item h2{
      display: inline-block;
    }
    .item .count{
      color: #000;
      font-size: 28px;
    }
  </style>
</head>
<body>
    
<?php

ini_set('display_errors', 1);

  $mas = [];
  //$mas = ['пездализ'];
  //$mas = ['мияби'];
  $dirtyLinks = ['виктория кушнаревайцу','мияби'];
  foreach ($dirtyLinks as $dirtyOne) {
    $file_headers = @get_headers('https://www.avito.ru/rossiya?q=' . $dirtyOne);
    var_dump($file_headers);
    echo "<br>";
    echo "<br>";
    echo "<br>";
    if ($file_headers[0] === "HTTP/1.1 404 Not found") {
        echo "404 НЕ РАБОТАЕТ ЗОВИТЕ АРТЕМОНА";
    }
    else {
        array_push($mas, $dirtyOne);
    }
  }

  var_dump($mas);

//   foreach ($mas as $oneQuery) {

//     $file_headers = @get_headers('https://www.avito.ru/rossiya?q=' . $oneQuery);
//     var_dump($file_headers[0]);

//     if($file_headers[0] === "HTTP/1.1 404 Not found") {
//         echo "НЕ РАБОТАЕТ 404";
//     }
//     else {
//         echo "РАБОТАЕТ ПОЧЕУМ ТО";
//         $xpath = new DOMXPath(DOMDocument :: loadHTMLFile('https://www.avito.ru/rossiya?q=' . $oneQuery));
//         var_dump($xpath);
//     }

//     //$xpath = new DOMXPath(DOMDocument :: loadHTMLFile(mb_convert_encoding('https://www.avito.ru/rossiya?q=' . $oneQuery, 'HTML-ENTITIES', 'UTF-8')));
//     // $xpath = new DOMXPath(DOMDocument :: loadHTMLFile('https://www.avito.ru/rossiya?q=' . $oneQuery));
//     // var_dump($xpath);
   
    
// } ?>



</body>
</html>