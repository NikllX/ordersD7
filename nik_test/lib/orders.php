<?php

namespace nik_test;

use Bitrix\Main\Loader;
class MySaleTable{
    protected $errors = [];
    protected $isAdmin;
    function __construct()
    {
        if(!Loader::includeModule('sale')){
            $this->errors[] = 'No module sale';
        };

        $user = \Bitrix\Main\Engine\CurrentUser::get();
        $this->isAdmin = $user->isAdmin();
        if(!$this->isAdmin){
            $this->errors[] = 'No admin';
        }
    }

    function GetList($useFilter = null, $payed = null)
    {
        if(!$this->isAdmin){
            $http_response_code = "400";
            return ["http_response_code" => $http_response_code, "res" => $this->errors];
        }
        $filterPayed = [];
        if($useFilter ==  true && !is_null($payed)){
            $filterPayed = [
                'LOGIC' => 'AND',
                'PAYED' => ($payed == true) ? "Y": "N"
            ];
        }

        $dbOrders = \Bitrix\Sale\OrderTable::getList([
            'select' => ['ID', 'PRICE', 'STATUS_ID', 'PAYED', 'CANCELED'],
            'filter' => [
                '>=DATE_INSERT' => \Bitrix\Main\Type\DateTime::createFromTimestamp(strtotime("-7 day")),
                [
                    'LOGIC' => 'AND',
                    '<=DATE_INSERT' => \Bitrix\Main\Type\DateTime::createFromTimestamp(strtotime("-3 day")),
                    [
                        'LOGIC' => 'AND',
                        'CANCELED' => "N",
                        $filterPayed
                    ]
                ]
            ],
            'count_total' => 1,
        ]);

        $arOrders = [];
        while ($arOrder = $dbOrders->fetch()) {
            $arOrders[] = $arOrder;
        }

        if(count($arOrders) == 0){
            $this->errors[] = 'Таких заказов нет';
            $http_response_code = "400";
            return ["http_response_code" => $http_response_code,"res"=>$this->errors];
        }

        $http_response_code = "200";
        return ["http_response_code" => $http_response_code,"res"=>$arOrders];
    }
}
?>