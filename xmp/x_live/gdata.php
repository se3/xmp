<?php
$key = $_GET[key];
// http://gdata.youtube.com/feeds/api/videos?vq=%s&amp;orderby=relevance&amp;format=5&amp;start-index=1&amp;max-results=20";
 // <search url="http://gdata.youtube.com/feeds/api/videos?vq=$key&orderby=relevance&format=5&start-index=1&max-results=20"
 // http://gdata.youtube.com/feeds/api/videos?vq=HD&orderby=relevance&format=5&start-index=1&max-results=20
$rss = "http://gdata.youtube.com/feeds/api/videos?vq=$key&orderby=relevance&format=5&start-index=1&max-results=20";
$rss_content = file_get_contents( $rss );

$search = "f=videos";
$replace = "f=videos&amp;hd=1";
$new_rss_content = str_replace( $search, $replace, $rss_content );

echo $new_rss_content ;

?>