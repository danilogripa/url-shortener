<?php
/**
 * Created by PhpStorm.
 * User: danilo
 * Date: 10/11/14
 * Time: 17:09
 */
$links = '../url-shortener/links.ini';
$short = $_POST["linkname"];
$url_normal = $_POST["urlname"];

require "Database.php";

$db = new Database();
$result = $db->create($short, $url_normal);

$linkshort = "http://short.local/";
echo "<div id='content'>";
echo "<br><br>";
echo "<a href=" . $linkshort . $result['short'] . ">" . $linkshort . $result['short'] . "</a>";
echo "<br><br>";
echo "<a href=" . $result['link'] . ">" . $result['link'] . "</a>";
echo "</div>";
