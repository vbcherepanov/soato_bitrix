<?php
use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

$moduleId = 'vbcherepanov.soato';
Loader::includeModule($moduleId);

if (!$USER->IsAdmin()) {
    $APPLICATION->AuthForm(Loc::getMessage('VBCHEREPANOV_SOATO_OPTION_DENIED'));
}
$arTabs = array(
    array(
        'DIV' => 'tab_options',
        'TAB' => Loc::getMessage('VBCHEREPANOV_SOATO_OPTION_TITLE'),
        'OPTIONS' => array(
            Loc::getMessage('VBCHEREPANOV_SOATO_OPTION_TITLE_BASE'),
            array(
                "onoff", Loc::getMessage('VBCHEREPANOV_SOATO_OPTION_ON_OFF'),
                '', array('checkbox', '')
            ),
        ),
    ),
);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && strlen($_REQUEST['save']) > 0 && check_bitrix_sessid())
{
    foreach ($arTabs as $arTab)
    {
        __AdmSettingsSaveOptions($moduleId, $arTab['OPTIONS']);
    }
    if (array_key_exists("csvfile",$_POST) && $_POST['csvfile']!='') {
        $fileCsv = $_SERVER['DOCUMENT_ROOT'].htmlspecialchars($_POST['csvfile']);
        Vbcherepanov\Soato\loadRecords($fileCsv);
    }
    LocalRedirect($APPLICATION->GetCurPage() . '?lang=' . LANGUAGE_ID . '&mid=' . urlencode($moduleId));
}

$obTabControl = new CAdminTabControl('tabControl', $arTabs);

?>
<form method='post' action='' name='<?=$moduleId?>'>
    <?=bitrix_sessid_post()?>
    <?
    $obTabControl->Begin();
    foreach ($arTabs as $arTab) {
        $obTabControl->BeginNextTab();
        __AdmSettingsDrawList($moduleId, $arTab['OPTIONS']);
    }
    ?>
    <tr>
        <td width="50%" class="adm-detail-content-cell-l">
            <label for="csvfile">Файл СОАТО</label>
        </td>
        <td width="50%" class="adm-detail-content-cell-r">
            <?
            $opt="csvfile";
            $arOptParams = [
                'FIELD_SIZE'=>'',
                'FIELD_READONLY'=>'Y',
                'BUTTON_TEXT'=>'открыть csv SOATO',
            ];
            CAdminFileDialog::ShowScript(Array(
                            'event' => 'BX_FD_'.$opt,
                            'arResultDest' => Array('FUNCTION_NAME' => 'BX_FD_ONRESULT_'.$opt),
                            'arPath' => Array(),
                            'select' => 'F',
                            'operation' => 'O',
                            'showUploadTab' => true,
                            'showAddToMenuTab' => false,
                            'fileFilter' => '',
                            'allowAllFiles' => true,
                            'SaveConfig' => true
                        ));
                        $input =     '<input id="__FD_PARAM_'.$opt.'" name="'.$opt.'" size="'.$arOptParams['FIELD_SIZE'].'" value="'.htmlspecialchars('').'" type="text" style="float: left;" '.($arOptParams['FIELD_READONLY'] == 'Y' ? 'readonly' : '').' />
                                    <input value="'.$arOptParams['BUTTON_TEXT'].'" type="button" onclick="window.BX_FD_'.$opt.'();" />
                                    <script>
                                        setTimeout(function(){
                                            if (BX("bx_fd_input_'.strtolower($opt).'"))
                                                BX("bx_fd_input_'.strtolower($opt).'").onclick = window.BX_FD_'.$opt.';
                                        }, 200);
                                        window.BX_FD_ONRESULT_'.$opt.' = function(filename, filepath)
                                        {
                                            var oInput = BX("__FD_PARAM_'.$opt.'");
                                            if (typeof filename == "object")
                                                oInput.value = filename.src;
                                            else
                                                oInput.value = (filepath + "/" + filename).replace(/\/\//ig, \'/\');
                                        }
                                    </script>';
                        echo $input;
                        ?>

        </td>
    </tr>
    <?
    $obTabControl->Buttons(array('btnApply' => false, 'btnCancel' => false, 'btnSaveAndAdd' => false));
    $obTabControl->End();
    ?>
</form>