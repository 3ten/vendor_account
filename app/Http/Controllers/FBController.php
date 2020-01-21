<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;

class FBController extends Controller
{
    private $database = 'D:\Datakrat\Database\MY_BASE.FDB';
    private $user = 'SYSDBA';
    private $password = 'masterkey';


    public function getCards(Request $request)
    {
        $fdb_login = $request->fdb_login;

        $db = ibase_connect($this->database, $fdb_login, $this->password);

        $Cards = array();
        @$getCards_SQL = ibase_query("select * FROM CARDSCLA cl left join disccard dc on dc.articul= cl.articul left join ostdaily od on cl.articul = od.articul where dc.price_kind ='568' and cl.client_index = 427 and od.place_index ='13' and od.ost_date = '02.10.2018 00:00'", $db);
        while (@$getCards = ibase_fetch_assoc($getCards_SQL)) {
            $card = [
                'articul' => $getCards['ARTICUL'],
                'name' => mb_convert_encoding($getCards['NAME'], 'UTF-8', 'windows-1251'),
                'ost' => mb_convert_encoding($getCards['QUANTITY'], 'UTF-8', 'windows-1251'),
                'price' => mb_convert_encoding($getCards['PRICE_RUB'], 'UTF-8', 'windows-1251'),
            ];


            array_push($Cards, $card);

        }

        return $Cards;
    }

    public function getCardAnalysis(Request $request)
    {
        $fdb_path = $request->fdb_path;
        $fdb_login = $request->fdb_login;
        $fdb_password = $request->fdb_password;
        $client_id = $request->client_id;
        $client_inn = $request->client_inn;
        $client_kpp = $request->client_kpp;
        $begin_date = $request->begin_date;
        $end_date = $request->end_date;


        $db = ibase_connect($fdb_path, $fdb_login, $fdb_password);

        $Cards = array();
        @$getCards_SQL = ibase_query("SELECT * FROM VENDOR_ACCOUNT_GET_CARDS($client_id ,'$client_inn', '$client_kpp','$begin_date','$end_date')", $db);
        while (@$getCards = ibase_fetch_assoc($getCards_SQL)) {
            $card = [
                'articul' => $getCards['OUT_ARTICUL'],
                'name' => mb_convert_encoding($getCards['OUT_NAME'], 'UTF-8', 'windows-1251'),
                'ost' => (double)mb_convert_encoding($getCards['OUT_OST'], 'UTF-8', 'windows-1251'),
                'markup' => (double)number_format($getCards['OUT_MARKUP'], 2),
                'markup_per' => (double)number_format($getCards['OUT_MARKUP_PER'], 2),
                'retail_price' => (double)number_format($getCards['OUT_RETAIL_PRICE'], 2),
                'retail_sum' => (double)number_format($getCards['OUT_RETAIL_SUM'], 2),
                'client_price' => (double)number_format($getCards['OUT_CLIENT_PRICE'], 2),
                'sales' => (double)mb_convert_encoding($getCards['OUT_SALES'], 'UTF-8', 'windows-1251'),
            ];


            array_push($Cards, $card);

        }

        return $Cards;
    }

    public function getSalesAnalysis(Request $request)
    {
        $fdb_path = $request->fdb_path;
        $fdb_login = $request->fdb_login;
        $fdb_password = $request->fdb_password;
        $client_id = $request->client_id;
        $client_inn = $request->client_inn;
        $client_kpp = $request->client_kpp;
        $begin_date = $request->begin_date;
        $end_date = $request->end_date;


        $db = ibase_connect($fdb_path, $fdb_login, $fdb_password);

        $Cards = array();
        @$getCards_SQL = ibase_query("SELECT * FROM VENDOR_ACCOUNT_GET_SALES($client_id ,'$client_inn', '$client_kpp','$begin_date','$end_date') order by OUT_DATE", $db);
        while (@$getCards = ibase_fetch_assoc($getCards_SQL)) {
            $card = [
                'sales_quant' => number_format($getCards['OUT_SALES_QUANT'], 2),
                'sales_client_sum' => number_format($getCards['OUT_SALES_CLIENT_SUM'], 2),
                'sales_retail_sum' => number_format($getCards['OUT_SALES_RETAIL_SUM'], 2),
                'supply_quant' => number_format($getCards['OUT_SUPPLY_QUANT'], 2),
                'sales_delta' => number_format($getCards['OUT_SALES_DELTA'], 2),
                'date' => str_replace('00:00:00', '', mb_convert_encoding($getCards['OUT_DATE'], 'UTF-8', 'windows-1251')),
            ];
            $isExist = 0;
            for ($i = 0; $i < count($Cards); $i++) {
                if ($Cards[$i]['date'] == $card['date']) {
                    $Cards[$i]['sales_client_sum'] += (double)$card['sales_client_sum'];
                    $Cards[$i]['sales_quant'] += (double)$card['sales_quant'];
                    $Cards[$i]['sales_retail_sum'] += (double)$card['sales_retail_sum'];
                    // $Cards[$i]['supply_quant'] += $card['supply_quant'];
                    // $Cards[$i]['sales_delta'] += $card['sales_delta'];
                    $isExist = 1;
                }
            }
            if ($isExist == 0) {
                array_push($Cards, $card);
            }


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

    public function getCardSales(Request $request)
    {
        $db = ibase_connect($this->database, $this->user, $this->password);
        $articul = $request->articul;
        $begin_date = $request->begin_date;
        $end_date = $request->end_date;
        $data = array();
        $sales = array();
        $sql = "SELECT * FROM SALES_CALC_ART_FETCH('$articul','$begin_date','$end_date','1','0')";
        @$getSales_SQL = ibase_query($sql, $db);
        while (@$getSales = ibase_fetch_assoc($getSales_SQL)) {
            $data = [
                'date' => $getSales['ON_DATE'],
                'ost' => $getSales['QUANTITY'],
                'sales' => $getSales['SALE0QUANTITY'],

            ];
            array_push($sales, $data);
        }

        return $sales;
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
            $currentClient = User::where([ ['inn', $getClients['INN_CLIENTS'] ], ['kpp', $getClients['KPP']] ])->get()->first();

            $currentClientId = NULL;
            $currentClientIsActive = false;
            $status = 0;
            $hasAccess = false;
            $canMessage = false;
            $canSeePrices = false;

            if ($currentClient) {
                $status = 1;
                $currentClientId = $currentClient->id;
                $currentClientIsActive = $currentClient->is_active;
                $relation = DB::table('users_relations')->where([ ['vendor_id', $currentClientId], ['shop_id', $request->shop_id] ])->get()->first();
                $hasAccess = $relation->has_access;
                $canMessage = $relation->can_message;
                $canSeePrices = $relation->can_see_prices;
            }

            $client = [
                'id' => $currentClientId,
                'code' => $getClients['ID_CLIENTS'],
                'status' => $status,
                'inn' => $getClients['INN_CLIENTS'],
                'kpp' => $getClients['KPP'],
                'name' => mb_convert_encoding($getClients['NAME_CLIENTS'], 'UTF-8', 'windows-1251'),
                'tel' => $getClients['TEL_CLIENTS'],
                'city' => mb_convert_encoding($getClients['CITY_CLIENTS'], 'UTF-8', 'windows-1251'),
                'address' => mb_convert_encoding($getClients['ADDRES_CLIENTS'], 'UTF-8', 'windows-1251'),
                'comment' => mb_convert_encoding($getClients['COMMENT_CLIENTS'], 'UTF-8', 'windows-1251'),
                'isAccept' => $getClients['IS_ACCEPT_CLIENTS'],
                'ownkind' => mb_convert_encoding($getClients['NAME'], 'UTF-8', 'windows-1251'),
                'fullName' => mb_convert_encoding($getClients['LEGAL_NAME'], 'UTF-8', 'windows-1251'),
                'isActive' => $currentClientIsActive,
                'hasAccess' => $hasAccess,
                'canMessage' => $canMessage,
                'canSeePrices' => $canSeePrices,
            ];
            array_push($clients, $client);
        }
        return $clients;
    }

    public function saveOptions(Request $request)
    {
        foreach($request->data as $key => $vendorOptions) {
            DB::table('users_relations')->updateOrInsert(
                ['vendor_id' => $vendorOptions['vendor_id'], 'shop_id' => $vendorOptions['shop_id']],
                ['has_access' => $vendorOptions['hasAccess'], 'can_message' => $vendorOptions['canMessage'], 'can_see_prices' => $vendorOptions['canSeePrices'] ]
            );
        }

        return response()->json([
            'status' => 'success',
        ], 200);
    }

}
