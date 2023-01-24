<?php
namespace Vbcherepanov\Soato;

class soatocity
{
    public const LIMIT = 10;

    public static function loadCity($q,$limit=0,$exclude=[])
    {
        if ($limit==0) $limit = self::LIMIT;
        if(count($exclude)==0) $exclude = [2,5];
        $q=htmlspecialchars($q);
        $filter = [
            'NAME'=>'%'.trim($q).'%',
            '!ELEMENT_TYPE'=>$exclude
        ];
        $data=self::loadFromBase($filter,$limit);
        return self::loadFullPathCity($data);
    }

    protected static function loadFromBase($filter,$limit)
    {
        return SoatoTable::getList(
            [
                'filter'=>$filter,
                'limit'=>$limit
            ]
        );
    }

    protected static function loadFullPathCity($data): array
    {
        $result=[];
        $tmp=[];
        $code = 0;
        while($res = $data->fetch()) {
            $tmp[]= $res['REDUCTION'].' '.$res['NAME'];
            $l=[];
            if($res['ELEMENT_TYPE']!=1 && $res['ADRESS_CODE']) {
                $code = $res['ADRESS_CODE'];
                $l[] = ['ADRESS_CODE' => $res['ADRESS_CODE'], 'ELEMENT_TYPE' => 1];
            }

            if($res['ELEMENT_TYPE']!=2 && $res['DISTRICT_CODE']) {
                $code = $res['DISTRICT_CODE'];
                $l[] = ['DISTRICT_CODE' => $res['DISTRICT_CODE'], 'ELEMENT_TYPE' => 2];
            }

            if($res['ELEMENT_TYPE']!=3 && $res['CITY_CODE']) {
                $code = $res['CITY_CODE'];
                $l[] = ['CITY_CODE' => $res['CITY_CODE'], 'ELEMENT_TYPE' => 3];
            }

            if($res['ELEMENT_TYPE']!=4 && $res['LOCALITY_CODE']) {
                $code = $res['LOCALITY_CODE'];
                $l[] = ['LOCALITY_CODE' => $res['LOCALITY_CODE'], 'ELEMENT_TYPE' => 4];
            }

            if($res['ELEMENT_TYPE']!=5 && $res['STREET_CODE'])
                $l[]=['STREET_CODE'=>$res['STREET_CODE'],'ELEMENT_TYPE'=>5];

            $tmp[] = self::getName($l);
            $result[]=[
                'NAME'=>implode(", ",$tmp),
                'CODE'=>$res['LOCALITY_CODE'] ?: $res['CITY_CODE'],
                'SOATO'=>$res['CODE']
            ];
            unset($tmp);
        }
        return $result;
    }

    private static function getName($arr): string
    {
        $str=[];
        foreach($arr as $key=>$val) {
            $res = SoatoTable::getList(
                [
                    'filter' => $val,
                    'select' => ['NAME', 'REDUCTION']
                ]
            )->fetch();
            $str[]=$res['NAME'] .' '.$res['REDUCTION'];
        }
        return implode(", ",$str);
    }
}