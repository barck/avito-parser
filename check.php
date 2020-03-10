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
    a {
      font-size: 24px;
      margin-right: 20px;
    }
  </style>
</head>
<body>

<a href="/">На главную</a>
<a href="#" class="btn-copy">Скопировать все ссылки и нагнуть барыгу</a>
<?php

  $dirtyLinks = explode(',', @$_COOKIE['author']);
  $mas = [];
  $count = 1;
  $linksArray = [];

  foreach ($dirtyLinks as $dirtyOne) {
    $file_headers = @get_headers('https://www.avito.ru/rossiya?q=' . $dirtyOne);
    if ($file_headers[0] === "HTTP/1.1 404 Not found") {
      echo "<h2>По запросу " . $dirtyOne . " объявлений нет</h2>";
    }
    else {
      array_push($mas, $dirtyOne);
    }
  }

  foreach ($mas as $oneQuery) {
    $file_headers = @get_headers('https://www.avito.ru/rossiya?q=' . $oneQuery);
    $xpath = new DOMXPath(DOMDocument :: loadHTMLFile('https://www.avito.ru/rossiya?q=' . $oneQuery));
    $query = "//a[contains(@class,'js-photo-wrapper')]";

    foreach ($xpath->query($query) as $node) {
      $strCutStart = str_replace('Объявление «','',$node->getAttribute("title"));
      $strCutEnd = str_replace('» с фотографией','',$strCutStart);  
      $imgs = $node->getElementsByTagName('img');
      foreach($imgs as $a) {
        $firstImg = $a->getAttribute('src');
        $linksArray[$node->getAttribute("href")] = [$imgs[0]->getAttribute('src'), $strCutEnd];
      }   
    }
  }  


  foreach ($mas as $oneQuery) {
    $xpath = new DOMXPath(DOMDocument :: loadHTMLFile('https://www.avito.ru/rossiya?q=' . $oneQuery));
    $query = "//a[contains(@class,'js-item-slider')]";

    foreach ($xpath->query($query) as $node) {
      $imgs = $node->getElementsByTagName('img');
      $linksArray[$node->getAttribute("href")] = [$imgs[0]->getAttribute('src'), $imgs[0]->getAttribute('alt')];
    }
  }

  //КОНЕЦ ПАРСИНГА

  function super_unique($array) {
    $result = array_map("unserialize", array_unique(array_map("serialize", $array)));
    foreach ($result as $key => $value) {
      if ( is_array($value) ) {
        $result[$key] = super_unique($value);
      }
    }
    return $result;
  }

  $finishArray = super_unique($linksArray);
  foreach ($finishArray as $arrayItem => $key) { ?>
    <div class="item">
      <span class="count"><?= $count ?></span>
      <h2><a href="https://avito.ru<?= $arrayItem ?>"><?= $key[1] ?></a></h2>
      <?php $count++ ?>
      <img src="<?= $key[0] ?>">
      <button class="btn-delete">УДОЛИТЬ</button>
    </div>
  <?php } ?>

<textarea id="temp" cols="30" rows="10"></textarea>

<script>

  let deleteButtons = document.querySelectorAll('.btn-delete'),
      copyBtn = document.querySelector('.btn-copy'),
      tempArea = document.querySelector('#temp'),
      finalLinks = null;

  for(var i = 0; i < deleteButtons.length; i++){
    deleteButtons[i].addEventListener("click", function(e){
      e.target.parentNode.remove();
    }); 
  }

  copyBtn.addEventListener("click", function(){
    event.preventDefault();
    finalLinks = document.querySelectorAll('.item');
    for(var i = 0; i < finalLinks.length; i++){
      tempArea.value += finalLinks[i].querySelector('a').href + '\n';
    }
    navigator.clipboard.writeText(tempArea.value.slice(0, -1));
  }); 

</script>

</body>
</html>