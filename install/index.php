<?
use Bitrix\Main\Application;
use Bitrix\Main\Loader;
use Bitrix\Main\Config\Option;
use Bitrix\Main\Localization\Loc;

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

Loc::loadMessages(__FILE__);

class vbcherepanov_soato extends CModule
{
    const MODULE_ID = 'vbcherepanov.soato';
    const PARTNER_NAME = 'VBCHEREPANOV';
    const PARTNER_URI = 'https://vbcherepanov.info';

    var $MODULE_ID = 'vbcherepanov.soato';
    var $PARTNER_NAME = 'VBCHEREPANOV';
    var $PARTNER_URI = 'https://vbcherepanov.info';

    public $MY_DIR = "bitrix";
    /**
     * @var bool
     */
    private $errors;

    /**
     * Returns module name.
     *
     * @return string
     */
    public static function getModuleId()
    {
        return basename(dirname(__DIR__));
    }

    public function __construct()
    {
        $arModuleVersion = array();
        include(dirname(__FILE__) . '/version.php');
        $this->MODULE_ID = self::getModuleId();
        $this->MODULE_VERSION = $arModuleVersion['VERSION'];
        $this->MODULE_VERSION_DATE = $arModuleVersion['VERSION_DATE'];
        $this->MODULE_NAME = Loc::getMessage(self::getModuleId() . '.MODULE_NAME');
        $this->MODULE_DESCRIPTION = Loc::getMessage(self::getModuleId() . '.MODULE_DESC');

        $this->PARTNER_NAME = 'VBCHEREPANOV';
        $this->PARTNER_URI = 'https://vbcherepanov.info';

        $path = str_replace('\\', '/', __FILE__);
        $dir = substr($path, 0, strlen($path) - strlen('/index.php'));
        include($dir.'/version.php');

        $check_last = "/local/modules/".$this->MODULE_ID."/install/index.php";
        $check_last_len = strlen($check_last);

        if ( substr($path, -$check_last_len) == $check_last )
        {
            $this->MY_DIR = "local";
        }


    }

    public function DoInstall()
    {
        $this->InstallDB();
        $this->InstallFiles();
        $this->InstallEvents();
        RegisterModule(self::getModuleId());
    }

    public function DoUninstall()
    {
        UnRegisterModule(self::getModuleId());
        $this->UnInstallEvents();
        $this->UnInstallFiles();
        $this->UnInstallDB();
    }

    public function InstallDB()
    {
        global $DB, $DBType, $APPLICATION;
        $this->errors = false;
        $this->errors = $DB->RunSQLBatch($_SERVER["DOCUMENT_ROOT"]."/".$this->MY_DIR."/modules/".$this->MODULE_ID."/install/db/mysql/install.sql");
        if($this->errors !== false)
        {
            $APPLICATION->ThrowException(implode("", $this->errors));
            return false;
        }
        return true;
    }

    public function UnInstallDB($arParams = array())
    {
        global $DB, $DBType, $APPLICATION;
        $this->errors = $DB->RunSQLBatch($_SERVER["DOCUMENT_ROOT"]."/".$this->MY_DIR."/modules/".$this->MODULE_ID."/install/db/mysql/uninstall.sql");
        if($this->errors !== false)
        {
            $APPLICATION->ThrowException(implode("", $this->errors));
            return false;
        }
        return true;
    }

    public function InstallFiles($arParams = array())
    {
        return true;
    }

    public function UnInstallFiles()
    {
        return true;
    }

    public function InstallEvents()
    {
       return true;
    }

    public function UnInstallEvents()
    {
        return true;
    }
}