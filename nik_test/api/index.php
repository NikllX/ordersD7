<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

require_once($_SERVER["DOCUMENT_ROOT"]."/nik_test/lib/orders.php");

$body = json_decode(file_get_contents('php://input') , true);

$rest = new nik_test\MySaleTable();
$arRes = $rest->GetList($body["useFilter"],$body["payed"]);

http_response_code($arRes["http_response_code"]);
echo json_encode($arRes["res"]);

require_once($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/epilog_after.php');

?>