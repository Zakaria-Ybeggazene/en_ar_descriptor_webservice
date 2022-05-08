<?php
ini_set('soap.wsdl_cache_enabled', 0);

//implémenter l'opération
function describeArabic( $word ){
    $db = new SQLite3('data.db');

    $statement = $db->prepare('SELECT ar FROM words_list WHERE en = :word COLLATE NOCASE;');
    $statement->bindValue(':word', $word);

    $result = $statement->execute();
    if($row = $result->fetchArray()) {
        return $row["ar"];
    } else {
        return new SoapFault("Error", "english word not found", null, null, "wordNotFound");
    }
}

//créer un serveur
$server = new SoapServer("en_ar_descriptor.wsdl");

//ajouter une opération au serveur
$server->addFunction("describeArabic");

//démarrer le serveur
$server->handle();
?>