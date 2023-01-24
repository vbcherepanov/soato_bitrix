<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
use Bitrix\Main\Localization\Loc;
$arComponentDescription = array(
    "NAME" => Loc::getMessage("VBCH_CITY_COMPONENT_NAME"), //component name lang
    "DESCRIPTION" => Loc::getMessage("VBCH_CITY_COMPONENT_DESCRIPTION"), //component description lang
    "ICON" => "", // component image path like "/images/cat_detail.gif"
    "CACHE_PATH" => "Y", // button for clear cache
    "SORT" => 10,
    "PATH" => array(
        "ID" => "vbcherepanov", //main group name
        "NAME" => 'VBCHEREPANOV', //main group name
    ),
);

?>