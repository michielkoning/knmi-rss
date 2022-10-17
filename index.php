<?php

header("Content-type: text/xml");

echo '<rss version="2.0">
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
</image>';

$rss = new DOMDocument();
$rss->load('https://cdn.knmi.nl/knmi/xml/rss/rss_KNMIwaarschuwingen.xml');

function getItemByTag($node, $tag)
{
  if ($tag === 'description') {
    return '<' . $tag .  '><![CDATA[ ' . $node->getElementsByTagName($tag)->item(0)->nodeValue . ']]></' . $tag .  '>';
  }
  return '<' . $tag .  '>' . $node->getElementsByTagName($tag)->item(0)->nodeValue . '</' . $tag .  '>';
}

$tags = ['title', 'description', 'link', 'guid', 'pubDate', 'category', 'category', 'author'];

foreach ($rss->getElementsByTagName('item') as $node) {

  echo '<item>';
  foreach ($tags as $tag) {
    echo getItemByTag($node, $tag);
  }
  echo '</item>';
}
echo "</channel></rss>";
