<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use \Bitrix\Main\Localization\Loc as Loc;
CJSCore::Init(['phone_auth']);
Loc::loadMessages(__FILE__);

?>
<input type="text" name="cityq" id="<?=$arResult['INPUT_ID']?>" value="<?=$arResult['DEFAULT_CITY']['CITY_NAME']?>"/>
<input type="hidden" name="cityCode" id="code_<?=$arResult['INPUT_ID']?>" value="<?=$arResult['DEFAULT_CITY']['CITY_CODE']?>"/>
<input type="hidden" name="SOATO" id="soato_<?=$arResult['INPUT_ID']?>" value=""/>
<div id="citylist_<?=$arResult['INPUT_ID']?>">

</div>
<?

$params = [
    'input' => $arResult['INPUT_ID'],
    'cityList' => "citylist_".$arResult['INPUT_ID'],
    'cityCode' => "code_".$arResult['INPUT_ID'],
    'Soato' => "soato_".$arResult['INPUT_ID'],
    'MESSAGE'=>[
            'NONE'=>'извините ничего не найдено'
    ]
];
?>
<script>
    var params =<?=\Bitrix\Main\Web\Json::encode(['signedParameters' => $this->getComponent()->getSignedParameters()])?>;
    BX.message({
        SITE_ID: '<?=CUtil::JSEscape($component->getSiteId())?>'
    });
    BX.Soato.CityComponent.init(<?=CUtil::PhpToJSObject($params, false, true); ?>, params);
</script>

