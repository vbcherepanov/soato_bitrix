<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use \Bitrix\Main;
use \Bitrix\Main\Engine\Contract;
use \Bitrix\Main\Localization\Loc as Loc;
use \Vbcherepanov\Core\Favorite\Fav;

class VbcherepanovSoatoStreet extends \CBitrixComponent implements Contract\Controllerable
{
    /**
     * cache keys in arResult
     * @var array()
     */
    protected $cacheKeys = array();

    /**
     * add parameters from cache dependence
     * @var array
     */
    protected $cacheAddon = array();

    /**
     * pager navigation params
     * @var array
     */
    protected $navParams = array();

    /**
     * include lang files
     * @param $val
     * @return
     */

    public function getListenerStreetAction($val)
    {
        Main\Loader::includeModule("vbcherepanov.soato");
        $query = $val['query'];
        $city = $val['city'];
        $data = [];
        $data['DATA'] = 1;
        $data['ERROR'] = '';
        $data['STREET'] = \Vbcherepanov\Soato\soatostreet::loadStreet($query,$city,20);
        if(count($data['STREET'])==0){
            $data['ERROR'] = '1';
        }
        return $data;
    }


    protected function listKeysSignedParameters()
    {
        return [

        ];
    }

    public function configureActions()
    {
        return [
            'getListenerStreet' => [
                'prefilters' => [],
            ],
        ];
    }

    public function onIncludeComponentLang()
    {
        $this->includeComponentLang(basename(__FILE__));
        Loc::loadMessages(__FILE__);
    }

    /**
     * prepare input params
     * @param array $arParams
     * @return array
     */
    public function onPrepareComponentParams($params)
    {
        return $params;
    }

    /**
     * read data from cache or not
     * @return bool
     */
    protected function readDataFromCache()
    {
        if ($this->arParams['CACHE_TYPE'] == 'N') // no cache
            return false;

        return !($this->StartResultCache(false, $this->cacheAddon));
    }

    /**
     * cache arResult keys
     */
    protected function putDataToCache()
    {
        if (is_array($this->cacheKeys) && sizeof($this->cacheKeys) > 0) {
            $this->SetResultCacheKeys($this->cacheKeys);
        }
    }

    /**
     * abort cache process
     */
    protected function abortDataCache()
    {
        $this->AbortResultCache();
    }

    /**
     * check needed modules
     * @throws LoaderException
     */
    protected function checkModules()
    {
        Main\Loader::includeModule("vbcherepanov.soato");
    }

    /**
     * check required input params
     * @throws SystemException
     */
    protected function checkParams()
    {

    }

    /**
     * some actions before cache
     */
    protected function executeProlog()
    {

    }



    /**
     * get component results
     */
    protected function getResult()
    {
        $this->getUserId();
        $this->arResult['INPUT_ID'] = $this->randString(10);
        $this->arResult['DEFAULT']['CITY_NAME'] = 'Минск';
        $this->arResult['DEFAULT']['CITY_CODE'] = '';
    }

    private function getUserId()
    {
        global $USER;
        $this->arResult['USER_ID'] = false;
        if ($USER->isAuthorized())
            $this->arResult['USER_ID'] = $USER->GetId();
    }

    /**
     * some actions after component work
     */
    protected function executeEpilog()
    {

    }

    /**
     * component logic
     */
    public function executeComponent()
    {
        try {
            $this->checkModules();
            $this->checkParams();
            $this->executeProlog();
            if (!$this->readDataFromCache()) {
                $this->getResult();
                $this->putDataToCache();
                $this->includeComponentTemplate();
            }
            $this->executeEpilog();
        } catch (Exception $e) {
            $this->abortDataCache();
            ShowError($e->getMessage());
        }
    }
}