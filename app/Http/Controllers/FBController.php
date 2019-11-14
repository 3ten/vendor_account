<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FBController extends Controller
{
    protected $database = 'C:\Users\nesst\Downloads\MY_BASE.FDB';
 
    public function getCards()
    {
        //$database = 'C:\Users\nesst\OneDrive\Рабочий стол\web\MY_BASE.FDB';
        $user = 'SYSDBA';
        $password = 'masterkey';
        $db = ibase_connect($this->database, $user, $password);

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
        //$database = 'D:\Datakrat\Database\MY_BASE.FDB';
        $user = 'SYSDBA';
        $password = 'masterkey';
        $db = ibase_connect($this->database, $user, $password);


        $Cards = array();
        @$getOrder_SQL = ibase_query("SELECT * FROM dochead where client_index = 483 and DOCKIND = 6 and DOCHEAD_FILIALINDEX= 48", $db);
        while (@$getOrder = ibase_fetch_assoc($getOrder_SQL)) {
            $card = [
                'dochead' => $getOrder['ID_DOCHEAD'],
                'date' => mb_convert_encoding($getOrder['DOC_DATE'], 'UTF-8', 'windows-1251'),
                'ext_docindex' => mb_convert_encoding($getOrder['EXT_DOCINDEX'], 'UTF-8', 'windows-1251'),
                'rub' => mb_convert_encoding($getOrder['TOTALRUB'], 'UTF-8', 'windows-1251'),
            ];


            array_push($Cards, $card);

        }
        return $Cards;

    }

    public function getOrderList(Request $request)
    {
        //$database = 'D:\Datakrat\Database\MY_BASE.FDB';
        $user = 'SYSDBA';
        $password = 'masterkey';
        $db = ibase_connect($this->database, $user, $password);


        $Cards = array();
        $id_dochead = $request->id;
        $sql = "SELECT * FROM docspec ds left join cardscla cs on cs.articul = ds.articul left join MESURIMENT ms on ms.id_mesuriment = cs.mesuriment where ds.id_dochead = $id_dochead";
        @$getOrder_SQL = ibase_query($sql, $db);
        while (@$getOrder = ibase_fetch_assoc($getOrder_SQL)) {
            $card = [
                'articul' => $getOrder['ARTICUL'],
                'name' => mb_convert_encoding($getOrder['NAME'], 'UTF-8', 'windows-1251'),
                'quantity' => mb_convert_encoding($getOrder['QUANTITY'], 'UTF-8', 'windows-1251'),
                'meas' => mb_convert_encoding($getOrder['NAME_MESURIMENT'], 'UTF-8', 'windows-1251'),
                'rub' => mb_convert_encoding($getOrder['PRICERUB'], 'UTF-8', 'windows-1251'),
                'query' => $sql,
            ];


            array_push($Cards, $card);

        }
        return $Cards;
    }
//
}
