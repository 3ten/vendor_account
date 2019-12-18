<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FBController extends Controller
{
    private $database = 'C:\Users\nesst\Downloads\MY_BASE.FDB';
    private $user = 'SYSDBA';
    private $password = 'masterkey';

    public function getCards()
    {
        //$database = 'C:\Users\nesst\OneDrive\Рабочий стол\web\MY_BASE.FDB';
        //$user = 'SYSDBA';
        //$password = 'masterkey';
        $db = ibase_connect($this->database, $this->user, $this->password);

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
        // $user = 'SYSDBA';
        // $password = 'masterkey';
        $db = ibase_connect($this->database, $this->user, $this->password);


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
        // $user = 'SYSDBA';
        // $password = 'masterkey';
        $db = ibase_connect($this->database, $this->user, $this->password);


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

    public function getOst(Request $request)
    {
        $db = ibase_connect($this->database, $this->user, $this->password);
        $articul = $request->id;
        $ost = array();
        $date = array();
        $data = array();
        $sql = "SELECT first 30 * FROM OSTDAILY where articul = $articul";
        @$getOst_SQL = ibase_query($sql, $db);
        while (@$getOst = ibase_fetch_assoc($getOst_SQL)) {
            array_push($ost, $getOst['QUANTITY']);
            array_push($date, $getOst['OST_DATE']);
        }
        $data = [
            'ost' => $ost,
            'date' => $date,
        ];
        return $data;
    }

    public function getPrix(Request $request)
    {
        $db = ibase_connect($this->database, $this->user, $this->password);
        $articul = $request->id;
        $quant = array();
        $date = array();
        $data = array();
        $sql = "select * from docspec ds left join dochead dh on dh.id_dochead = ds.id_dochead where dh.doctype = 0 and ds.articul = $articul";
        @$getOst_SQL = ibase_query($sql, $db);
        while (@$getOst = ibase_fetch_assoc($getOst_SQL)) {
            array_push( $quant, $getOst['QUANTITY']);
            array_push($date, $getOst['DOC_DATE']);
        }
        $data = [
            'quant' => $quant,
            'date' => $date,
        ];
        return $data;
    }

    public function getClients(Request $request)
    {
        $db = ibase_connect($this->database, $this->user, $this->password);
        $sql = "SELECT CL.ID_CLIENTS, CL.INN_CLIENTS, CL.KPP, CL.NAME_CLIENTS, CL.TEL_CLIENTS, CL.CITY_CLIENTS, CL.ADDRES_CLIENTS, CL.COMMENT_CLIENTS, CL.IS_ACCEPT_CLIENTS, OK.NAME, CL.LEGAL_NAME FROM CLIENTS CL LEFT JOIN OWNKIND OK ON CL.OWNKIND=OK.ID WHERE CL.CLIENT_TYPE = 0";
        @$getClients_sql = ibase_query($sql, $db);
        $clients = array();
        while (@$getClients = ibase_fetch_assoc($getClients_sql)) {
            $client = [
                'id' => $getClients['ID_CLIENTS'],
                'inn' => $getClients['INN_CLIENTS'],     
                'kpp' => $getClients['KPP'],
                'name' => mb_convert_encoding($getClients['NAME_CLIENTS'], 'UTF-8', 'windows-1251'), 
                'tel' => $getClients['TEL_CLINETS'],
                'city' => mb_convert_encoding($getClients['CITY_CLIENTS'], 'UTF-8', 'windows-1251'),
                'address' => mb_convert_encoding($getClients['ADDRES_CLIENTS'], 'UTF-8', 'windows-1251'),
                'comment' => mb_convert_encoding($getClients['COMMENT_CLIENTS'], 'UTF-8', 'windows-1251'),
                'isAccept' => $getClients['IS_ACCEPT_CLIENTS'],
                'ownkind' => mb_convert_encoding($getClients['NAME'], 'UTF-8', 'windows-1251'),
                'fullName' => mb_convert_encoding($getClients['LEGAL_NAME'], 'UTF-8', 'windows-1251'),    
            ];
            array_push($clients, $client);
        }
        return $clients;
    }
//
}
