<?php
namespace Vbcherepanov\Soato;

use Bitrix\Main\Localization\Loc,
    Bitrix\Main\ORM\Data\DataManager,
    Bitrix\Main\ORM\Fields\IntegerField,
    Bitrix\Main\ORM\Fields\StringField,
    Bitrix\Main\ORM\Fields\Validators\LengthValidator;

Loc::loadMessages(__FILE__);

/**
 * Class SoatoTable
 *
 * Fields:
 * <ul>
 * <li> ELEMENT_TYPE int optional
 * <li> ADRESS_CODE int optional
 * <li> DISTRICT_CODE int optional
 * <li> CITY_CODE int optional
 * <li> LOCALITY_CODE int optional
 * <li> STREET_CODE int optional
 * <li> SOATO int mandatory
 * <li> CODE string(20) optional
 * <li> NAME string(255) optional
 * <li> REDUCTION string(5) optional
 * <li> ZIP int optional
 * <li> ALT_NAME string(255) optional
 * </ul>
 *
 * @package Bitrix\Soato
 **/

class SoatoTable extends DataManager
{
    /**
     * Returns DB table name for entity.
     *
     * @return string
     */
    public static function getTableName()
    {
        return 'vbch_soato';
    }

    /**
     * Returns entity map definition.
     *
     * @return array
     */
    public static function getMap()
    {
        return [
            new IntegerField(
                'ELEMENT_TYPE',
                [
                    'title' => Loc::getMessage('SOATO_ENTITY_ELEMENT_TYPE_FIELD')
                ]
            ),
            new IntegerField(
                'ADRESS_CODE',
                [
                    'title' => Loc::getMessage('SOATO_ENTITY_ADRESS_CODE_FIELD')
                ]
            ),
            new IntegerField(
                'DISTRICT_CODE',
                [
                    'title' => Loc::getMessage('SOATO_ENTITY_DISTRICT_CODE_FIELD')
                ]
            ),
            new IntegerField(
                'CITY_CODE',
                [
                    'title' => Loc::getMessage('SOATO_ENTITY_CITY_CODE_FIELD')
                ]
            ),
            new IntegerField(
                'LOCALITY_CODE',
                [
                    'title' => Loc::getMessage('SOATO_ENTITY_LOCALITY_CODE_FIELD')
                ]
            ),
            new IntegerField(
                'STREET_CODE',
                [
                    'title' => Loc::getMessage('SOATO_ENTITY_STREET_CODE_FIELD')
                ]
            ),
            new IntegerField(
                'SOATO',
                [
                    'primary' => true,
                    'title' => Loc::getMessage('SOATO_ENTITY_SOATO_FIELD')
                ]
            ),
            new StringField(
                'CODE',
                [
                    'validation' => [__CLASS__, 'validateCode'],
                    'title' => Loc::getMessage('SOATO_ENTITY_CODE_FIELD')
                ]
            ),
            new StringField(
                'NAME',
                [
                    'validation' => [__CLASS__, 'validateName'],
                    'title' => Loc::getMessage('SOATO_ENTITY_NAME_FIELD')
                ]
            ),
            new StringField(
                'REDUCTION',
                [
                    'validation' => [__CLASS__, 'validateReduction'],
                    'title' => Loc::getMessage('SOATO_ENTITY_REDUCTION_FIELD')
                ]
            ),
            new IntegerField(
                'ZIP',
                [
                    'title' => Loc::getMessage('SOATO_ENTITY_ZIP_FIELD')
                ]
            ),
            new StringField(
                'ALT_NAME',
                [
                    'validation' => [__CLASS__, 'validateAltName'],
                    'title' => Loc::getMessage('SOATO_ENTITY_ALT_NAME_FIELD')
                ]
            ),
        ];
    }

    /**
     * Returns validators for CODE field.
     *
     * @return array
     */
    public static function validateCode()
    {
        return [
            new LengthValidator(null, 25),
        ];
    }

    /**
     * Returns validators for NAME field.
     *
     * @return array
     */
    public static function validateName()
    {
        return [
            new LengthValidator(null, 255),
        ];
    }

    /**
     * Returns validators for REDUCTION field.
     *
     * @return array
     */
    public static function validateReduction()
    {
        return [
            new LengthValidator(null, 15),
        ];
    }

    /**
     * Returns validators for ALT_NAME field.
     *
     * @return array
     */
    public static function validateAltName()
    {
        return [
            new LengthValidator(null, 255),
        ];
    }
}