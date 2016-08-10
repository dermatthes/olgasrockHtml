<?php
/**
 * Created by PhpStorm.
 * User: matthes
 * Date: 29.07.14
 * Time: 17:54
 */
ini_set ("xdebug.default_enable", 0 );
ini_set('xdebug.default_enable', false);
ini_set('html_errors', false);

ini_set ("display_errors", true);




$db = new SQLite3("/tmp/olga.sqlite");


if (@$_GET["a"] == "create") {
    unlink ("/tmp/olga.sqlite");
    $db = new SQLite3("/tmp/olga.sqlite");
    $sql = [
        "CREATE TABLE event (id VARCHAR(255) NOT NULL PRIMARY KEY, name VARCHAR(255), ofDay int, ofStage int, slot int, timeStart time, timeEnd time, isFavorite INT)"
    ];

    $simpleXml = new SimpleXMLElement(file_get_contents(__DIR__ . "/media/event/event.xml"));
    foreach ($simpleXml->events->event as $event) {
        $sql[] = "INSERT INTO event (id, name, ofDay, ofStage, slot, timeStart, timeEnd, isFavorite) VALUES ('{$event->attributes()->id}', '{$event->attributes()->name}', '{$event->attributes()->ofDay}', '{$event->attributes()->ofStage}', '{$event->attributes()->slot}', '{$event->attributes()->timeStart}', '{$event->attributes()->timeEnd}', 0)";
    }
    foreach ($sql as $cur) {
        echo "\n<br>" . highlight_string($cur);
        if ( ! $stmt = $db->prepare($cur)) {
            throw new Exception("Sqlite::prepare($query): " . $db->lastErrorMsg());
        }
        $result = $stmt->execute();
    }
    echo "DONE!";
    exit;
}




$ex = NULL;
try {
    $query = $_GET["query"];
    $params = @$_GET["arg"];
    if ( ! is_array ($params))
        $params = [];

    if ( ! $stmt = $db->prepare($query)) {
        throw new Exception("Sqlite::prepare($query): " . $db->lastErrorMsg());
    }

    foreach ($params as $index => $val) {
        $stmt->bindValue($index+1, $val);
    }

    $result = $stmt->execute();

    $ret = [];
    while ($tmp = $result->fetchArray()) {
        $ret[] = $tmp;
    }
} catch (Exception $ex) {

}

if ($ex !== NULL) {
    echo json_encode(["success" => false, "exception"=>$ex->getMessage()]);
} else {
    echo json_encode(["success" => true, "data" => $ret]);
}
