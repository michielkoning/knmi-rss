<?php

header("Content-type: text/xml");

$rss = new DOMDocument();
$rss->load('https://cdn.knmi.nl/knmi/xml/rss/rss_KNMIwaarschuwingen.xml');

function getItemByTag($node, $tag)
{
  $value = $node->getElementsByTagName($tag)->item(0)->nodeValue;
  if ($tag === 'description') {
    $value = str_replace("&nbsp;", " ", $value);
    $value = strip_tags($value);

    $doc = new DOMDocument();
    $doc->loadHTML($value);
    foreach ($doc->getElementsByTagName('a') as $link) {
      $linkText = $link->nodeValue;
      $value = str_replace($linkText, "", $value);
    }
  }
  return '<' . $tag .  '>' . $value . '</' . $tag . '>';
}

$tags = ['title', 'description', 'link', 'guid', 'pubDate', 'category', 'author'];
?>

<rss version="2.0">
  <channel>
    <title>KNMI: Waarschuwingen</title>
    <description>Koninklijk Nederlands Meteorologisch Instituut</description>
    <link>https://www.knmi.nl</link>
    <language>nl-nl</language>
    <copyright>Copyright: KNMI, https://www.knmi.nl/</copyright>
    <image>
      <title>KNMI: Waarschuwingen</title>
      <url>https://cdn.knmi.nl/knmi/xml/RSSread/knmi-rsslogo.gif</url>
      <link>https://www.knmi.nl/nederland-nu/weer/waarschuwingen</link>
    </image>'

    <?php
    foreach ($rss->getElementsByTagName('item') as $node) {
      echo '<item>';
      foreach ($tags as $tag) {
        echo getItemByTag($node, $tag);
      }
      echo '</item>';
    }
    ?>
  </channel>
</rss>
