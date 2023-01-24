<?php
namespace Vbcherepanov\Soato;

use Bitrix\Main\Application;
function openCsv($fileName): ?\Generator
{
    $file = fopen($fileName, 'r');
    try {
        while ($line = fgetcsv($file)) {
            yield $line;
        }
    } finally {
        fclose($file);
    }
}

function loadRecords($fileName): void
{
    foreach (openCsv($fileName) as $row) {
        $arField = [
            'ELEMENT_TYPE' => replaceValue($row[0]),
            'ADRESS_CODE' => replaceValue($row[1]),
            'DISTRICT_CODE' => replaceValue($row[2]),
            'CITY_CODE' => replaceValue($row[3]),
            'LOCALITY_CODE' => replaceValue($row[4]),
            'STREET_CODE' => replaceValue($row[5]),
            'SOATO' => replaceValue($row[6]),
            'CODE' => replaceValue($row[7]),
            'NAME' => $row[8],
            'REDUCTION' => replaceValue($row[9]),
            'ZIP' => replaceValue($row[10]),
            'ALT_NAME' => replaceValue($row[11]),
        ];
            Application::getConnection()->startTransaction();
            $res = SoatoTable::add($arField);
            if ($res->isSuccess()) {
                Application::getConnection()->commitTransaction();
            } else {
                Application::getConnection()->rollbackTransaction();
            }
            unset($res);
    }
}

function replaceValue(string $value): string {
    return trim(str_replace(" ","",$value));
}

