<?php
 $mas = ['melannet', 'melanett', 'melannet'];

  foreach ($mas as $oneQuery)
  {
    $xpath = new DOMXPath(DOMDocument :: loadHTMLFile('https://www.avito.ru/rossiya?q=' . $oneQuery));

    $query = "//a[contains(@class,'js-photo-wrapper')]";

    foreach ($xpath->query($query) as $node) { ?>
      <?php 
        $strCutStart = str_replace('Объявление «','',$node->getAttribute("title"));
        $strCutEnd = str_replace('» с фотографией','',$strCutStart);
      ?>
      <a class="item" href="https://avito.ru<?= $node->getAttribute("href") ?>">
        <span><?= $strCutEnd ?></span>
        <?php 
          $imgs = $node->getElementsByTagName('img');
          foreach($imgs as $a) { ?>
            <img src="<?= $a->getAttribute('src'); ?>">
          <?php } ?>
      </a>
    
      

      
    <?php } ?>
    
  <?php } ?>


<script>

  let items = document.querySelectorAll('.item');
  console.log(items[0].innerHTML);


</script>
