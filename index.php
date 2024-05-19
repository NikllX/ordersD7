<?php require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");?>

<?php
use Bitrix\Sale\Order;
use Bitrix\Main\Page\Asset;

global $USER;
\Bitrix\Main\Loader::includeModule('iblock');
\Bitrix\Main\Loader::includeModule('sale');

Asset::getInstance()->addJs("/nik_test/js/main.js");
Asset::getInstance()->addCss("/nik_test/css/main.css");

$user = \Bitrix\Main\Engine\CurrentUser::get();
if(!$user->isAdmin()){
    Bitrix\Iblock\Component\Tools::process404(
        'Не найден', //Сообщение
        true, // Нужно ли определять 404-ю константу
        true, // Устанавливать ли статус
        true, // Показывать ли 404-ю страницу
        false // Ссылка на отличную от стандартной 404-ю
    );
}
?>

<div class="container">
    <div class="row">
        <div class="col-12">
            <form class="align-items-baseline d-flex filterForm justify-content-start">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                    <label class="form-check-label" for="flexCheckDefault">
                        Оплачен/Не оплачен
                    </label>
                </div>
                <input name="applyFilter" class="btn btn-primary m-2" type="submit" value="Применить">
                <button id="cleanFilter" class="btn">Сбросить фильтр</button>
            </form>

        </div>
    </div>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Номер заказа</th>
            <th>Сумма заказа</th>
            <th>Статус оплаты</th>
        </tr>
        </thead>
        <tbody class="table-order">
        </tbody>
    </table>
    <div class="error-block">

    </div>
</div>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
