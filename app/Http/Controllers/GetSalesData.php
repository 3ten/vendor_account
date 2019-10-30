<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GetSalesData extends Controller
{
    public function getFBData()
    {
        $database = 'D:\Datakrat\Database\MY_BASE.FDB';
        $user = 'SYSDBA';
        $password = 'masterkey';
        $db = ibase_connect($database, $user, $password);

        @$getCards_SQL = ibase_query("select  first 100 * from ostdaily order by OST_DATE", $db);

        $Cards = array();
        while (@$getCards = ibase_fetch_assoc($getCards_SQL)) {
            array_push($Cards, $getCards);
        }

        $labels = array();
        $data = array();
        $dataSet = array();
        $dateNow = $Cards[0]["OST_DATE"];

        foreach ($Cards as $el) {
            array_push($labels, $el['ARTICUL']);
        }

        foreach ($Cards as $el) {
            if ($dateNow == $el['OST_DATE']) {
                array_push($data, $el['QUANTITY']);
            } else {
                $datasetEl = [
                    'label' => '$dateNow',
                    'backgroundColor' => 'F#26202',
                    'data' => $data,
                ];
                array_push($dataSet, $datasetEl);
                $dateNow = $el['OST_DATE'];
                $data = array();
                array_push($data, $el['QUANTITY']);
            }

            //  array_push($date, $el['OST_DATE']);
        }
        $datasetEl = ([
            'label' => $dateNow,
            'backgroundColor' => 'F#26202',
            'data' => [1],
        ]);
        array_push($dataSet, $datasetEl);


        return [
            'labels' => $labels,
            'datasets' => $dataSet,
        ];
    }
}
