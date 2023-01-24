<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use \Bitrix\Main\Localization\Loc as Loc;
CJSCore::Init(['phone_auth']);
Loc::loadMessages(__FILE__);

?>
<input type="text" name="streetq" id="<?=$arResult['INPUT_ID']?>" value=""/>
<input type="hidden" name="streetCode" id="streetcode_<?=$arResult['INPUT_ID']?>" value=""/>
<input type="hidden" name="streetSOATO" id="streetsoato_<?=$arResult['INPUT_ID']?>" value=""/>
<div id="streetlist_<?=$arResult['INPUT_ID']?>">

</div>
<?

$params = [
    'input' => $arResult['INPUT_ID'],
    'streetList' => "streetlist_".$arResult['INPUT_ID'],
    'streetCode' => "streetcode_".$arResult['INPUT_ID'],
    'StreetSoato' => "streetsoato_".$arResult['INPUT_ID'],
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
    BX.Soato.StreetComponent.init(<?=CUtil::PhpToJSObject($params, false, true); ?>, params);
</script>

