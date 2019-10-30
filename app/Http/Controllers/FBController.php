<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FBController extends Controller
{

    public function getCards()
    {
        $database = 'C:\Users\nesst\Downloads\OSPanel\domains\shop\MY_BASE.FDB';
        $user = 'SYSDBA';
        $password = 'masterkey';
        $db = ibase_connect($database, $user, $password);

        $Cards = array();
        @$getCards_SQL = ibase_query("select first 50 * FROM CARDSCLA cl left join ostdaily od on cl.articul = od.articul where od.place_index ='13' and od.ost_date = '02.10.2018 00:00'", $db);
        while (@$getCards = ibase_fetch_assoc($getCards_SQL)) {
            $card = [
                'articul' => $getCards['ARTICUL'],
                'name' => mb_convert_encoding($getCards['NAME'], 'UTF-8', 'windows-1251'),
                'ost' => mb_convert_encoding($getCards['QUANTITY'], 'UTF-8', 'windows-1251'),
            ];


            array_push($Cards, $card);

        }

        return $Cards;
    }


    public function getOrder()
    {
        $database = 'C:\Users\nesst\Downloads\OSPanel\domains\shop\MY_BASE.FDB';
        $user = 'SYSDBA';
        $password = 'masterkey';
        $db = ibase_connect($database, $user, $password);


        $Cards = array();
        @$getOrder_SQL = ibase_query("SELECT * FROM order_plan where place_index =13 and manufacturer = 844", $db);
        while (@$getOrder = ibase_fetch_assoc($getOrder_SQL)) {
            $card = [
                'articul' => $getOrder['ARTICUL'],
                'name' => mb_convert_encoding($getOrder['NAME'], 'UTF-8', 'windows-1251'),
                'ost' => mb_convert_encoding($getOrder['QUANTITY'], 'UTF-8', 'windows-1251'),
            ];


            array_push($Cards, $card);

        }
        return $Cards;

    }
    //
}
