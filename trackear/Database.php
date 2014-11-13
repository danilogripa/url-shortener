<?php
/**
 * Created by PhpStorm.
 * User: danilo
 * Date: 11/11/14
 * Time: 15:19
 */

class Database {

    public $conn;

    public function __construct(){
        $servername = "localhost";
        $username = "root";
        $password = "12345678";
        $db = "url_shortener";

        $this->conn = new mysqli($servername, $username, $password, $db);
    }

    public function __destruct(){
        $this->conn->close();
    }

    public function add ($short, $link){
        $sql = "INSERT INTO links (short, link, criacao) VALUES ('". $short ."' , '". $link ."', '" . date('Y-m-d H:i:s') . "')";
        if($this->conn->query($sql) === true){
            return ["short" => $short, "link" => $link];
        }else{
            return false;
        }
    }

    public function checkByLink ($link){
        $sql = 'SELECT * FROM  `links` WHERE  `link` ="' . $link . '"';
        $result = $this->conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                return [ "short" => $row["short"], "link" => $row["link"]];
            }
        }
        return false;
    }

    public function getLink ($short){
        $sql = "SELECT * FROM links WHERE short ='" . $short . "'";
        $result = $this->conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $clicks = $row["clicks"] + 1;
                //$update = "UPDATE `url_shortener`.`clicks` SET `id_link` = '".$clicks."' WHERE `links`.`id` =" . $row["id"];
                $insert = "INSERT INTO clicks (id_link, data_click) VALUES ('". $row['id'] ."' ,'" . date('Y-m-d H:i:s') . "')";
                $this->conn->query($insert);
                return [ "short" => $row["short"], "link" => $row["link"]];
            }
        }
        return false;
    }
    public function getShortLink ($short){
        $sql = "SELECT * FROM links WHERE short ='" . $short . "'";
        $result = $this->conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                return [ "short" => $row["short"], "link" => $row["link"]];
            }
        }
        return false;
    }

    public function create($short, $url_normal){
        if($this->getShortLink($short)){
            return false;
        }
        if($url = $this->checkByLink($url_normal)){
            return $url;
        }
        return $this->add($short, $url_normal);
    }

} 