<html>
<head>
  <style>
    .item{
      display: block;
      width: 100%;
      clear: both;
      margin-bottom: 10px;
      height: 160px;
      text-decoration: none;
    }
    .item img{
      float: left;
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
 $mas = ['виктория+кушнарева', 'мияби'];
 $count = 1;
 $linksArray = [];

  foreach ($mas as $oneQuery)
  {
    $xpath = new DOMXPath(DOMDocument :: loadHTMLFile('https://www.avito.ru/rossiya?q=' . $oneQuery));

    $query = "//a[contains(@class,'js-photo-wrapper')]";

    foreach ($xpath->query($query) as $node) { ?>
      <?php 
        $strCutStart = str_replace('Объявление «','',$node->getAttribute("title"));
        $strCutEnd = str_replace('» с фотографией','',$strCutStart);
        
      ?>
        <?php 
          $imgs = $node->getElementsByTagName('img');
          foreach($imgs as $a) { ?>
          <?php $firstImg = $a->getAttribute('src'); ?>
          <?php $linksArray[$node->getAttribute("href")] = [$imgs[0]->getAttribute('src'), $strCutEnd]; ?>
          <?php } ?>
      </a>
      

      
    <?php } ?>
    
  <?php } ?>

<?php

foreach ($mas as $oneQuery)
  {
    $xpath = new DOMXPath(DOMDocument :: loadHTMLFile('https://www.avito.ru/rossiya?q=' . $oneQuery));

    $query = "//a[contains(@class,'js-item-slider')]";

    foreach ($xpath->query($query) as $node) {
      $imgs = $node->getElementsByTagName('img');
      $linksArray[$node->getAttribute("href")] = [$imgs[0]->getAttribute('src'), $imgs[0]->getAttribute('alt')];
    ?>
    <?php } ?>
    
  <?php } ?>

  
  <?php
    function super_unique($array)
    {
      $result = array_map("unserialize", array_unique(array_map("serialize", $array)));

      foreach ($result as $key => $value)
      {
        if ( is_array($value) )
        {
          $result[$key] = super_unique($value);
        }
      }

      return $result;
    }

    $finishArray = super_unique($linksArray);
    foreach ($finishArray as $arrayItem => $key) { ?>
      <a class="item" href="https://avito.ru<?= $arrayItem ?>">
        <span class="count"><?= $count ?></span>
        <h2><?= $key[1] ?></h2>
        <?php $count++ ?>
        <img src="<?= $key[0] ?>">
      </a>

    <?php }
  ?>


</body>
</html>