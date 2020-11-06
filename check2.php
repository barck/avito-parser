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
<a href="#" class="btn-copy" target="_blank">Скопировать все ссылки и нагнуть барыгу</a>
<?php

  $mas = explode(',', @$_COOKIE['author']);
  $linksArray = [];

  foreach ($mas as $oneQuery) {
    $file_headers = @get_headers('https://www.avito.ru/rossiya?q=' . $oneQuery);
    if ($file_headers[0] === "HTTP/1.1 404 Not found") {
        echo "<h2>По запросу " . $oneQuery . " объявлений нет</h2>";
    } else {
        $xpath = new DOMXPath(DOMDocument :: loadHTMLFile('https://www.avito.ru/rossiya?q=' . $oneQuery));
        $query = "//a[contains(@class,'js-photo-wrapper')]";
        $query2 = "//a[contains(@class,'js-item-slider')]";

        foreach ($xpath->query($query) as $node) {
        $strCutStart = str_replace('Объявление «','',$node->getAttribute("title"));
        $strCutEnd = str_replace('» с фотографией','',$strCutStart);  
        $imgs = $node->getElementsByTagName('img');
        foreach($imgs as $a) {
            $firstImg = $a->getAttribute('src');
            $linksArray[$node->getAttribute("href")] = [$imgs[0]->getAttribute('src'), $strCutEnd];
        }   
        }
        foreach ($xpath->query($query2) as $node) {
            $imgs = $node->getElementsByTagName('img');
            $linksArray[$node->getAttribute("href")] = [$imgs[0]->getAttribute('src'), $imgs[0]->getAttribute('alt')];
        }
    }
    $randTime = rand(1, 4);
    sleep($randTime);
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
      <h2><a href="https://avito.ru<?= $arrayItem ?>"><?= $key[1] ?></a></h2>
      <img src="<?= $key[0] ?>">
      <button class="btn-delete">УДОЛИТЬ</button>
    </div>
  <?php } ?>

<textarea id="temp" cols="30" rows="10"></textarea>

<script>

  let deleteButtons = document.querySelectorAll('.btn-delete'),
      copyBtn = document.querySelector('.btn-copy'),
      tempArea = document.querySelector('#temp'),
      dirtyLinks = document.querySelectorAll('.item'),
      finalLinks = null;

  for(var i = 0; i < dirtyLinks.length; i++){ //удаление всякой дичи типа книг
    let oneLink = dirtyLinks[i].querySelector('h2 a'),
        pos = oneLink.textContent.toLowerCase().indexOf('духи') + 1;
        pos2 = oneLink.textContent.toLowerCase().indexOf('хакама') + 1;
        pos3 = oneLink.textContent.toLowerCase().indexOf('роза') + 1;
        pos4 = oneLink.textContent.toLowerCase().indexOf('coat') + 1;
        pos5 = oneLink.textContent.toLowerCase().indexOf('банки') + 1;
        pos6 = oneLink.textContent.toLowerCase().indexOf('банка') + 1;
        pos7 = oneLink.textContent.toLowerCase().indexOf('книг') + 1;
        pos8 = oneLink.textContent.toLowerCase().indexOf('стих') + 1;
        pos9 = oneLink.textContent.toLowerCase().indexOf('платье') + 1;
        pos10 = oneLink.textContent.toLowerCase().indexOf('визажист') + 1;
        pos11 = oneLink.textContent.toLowerCase().indexOf('детектив') + 1;
        pos12 = oneLink.textContent.toLowerCase().indexOf('сочинени') + 1;
        pos13 = oneLink.textContent.toLowerCase().indexOf('стрижк') + 1;
        pos14 = oneLink.textContent.toLowerCase().indexOf('открытка') + 1;
        pos15 = oneLink.textContent.toLowerCase().indexOf('открыток') + 1;
    if ( pos || pos2 || pos3 || pos4 || pos5 || pos6 || pos7 || pos8 || pos9 || pos10 || pos11 || pos12 || pos13 || pos14 || pos15 ) {
      dirtyLinks[i].remove();
    }
  };

  for(var i = 0; i < deleteButtons.length; i++){ //удаление элементов
    deleteButtons[i].addEventListener("click", function(e){
      e.target.parentNode.remove();
    }); 
  }

  copyBtn.addEventListener("click", function(){ //получение ссылок и копирование их в буфер
    event.preventDefault();
    finalLinks = document.querySelectorAll('.item');
    for(var i = 0; i < finalLinks.length; i++){
      tempArea.value += finalLinks[i].querySelector('a').href + '\n';
    }
    navigator.clipboard.writeText(tempArea.value.slice(0, -1));
    location.href = 'https://www.avito.ru/safety/sobstvennost/brand?<?= @$_COOKIE['author-avito'] ?>';
  }); 

</script>

</body>
</html>