<?php
namespace Vbcherepanov\Soato;

class soatostreet
{
    public const LIMIT = 10;
    public static function loadStreet($q,$city,$limit=0): array
    {
        if ($limit==0) $limit = self::LIMIT;
        $q=htmlspecialchars($q);
        $filter = [
            'NAME'=>'%'.trim($q).'%',
            'ELEMENT_TYPE'=>5,
            'LOCALITY_CODE'=>$city,
        ];
        return self::loadFromBase($filter,$limit);

    }

    protected static function loadFromBase($filter,$limit): array
    {
        $result = [];
        $res = SoatoTable::getList(
            [
                'filter'=>$filter,
                'limit'=>$limit,
            ]
        );
        while($street = $res->fetch()){
            $street['STREET_CODE']=str_replace(" ","",$street['STREET_CODE']);
            $result[]=[
                'NAME'=>$street['REDUCTION'].' '.$street['NAME'],
                'CODE'=>$street['STREET_CODE'] ?: $street['LOCALITY_CODE'],
                'SOATO'=>$street['CODE']
            ];
        }
        unset($res,$street);
        return $result;
    }

}