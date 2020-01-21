<?php

namespace App\Http\Controllers;
use App\UsersRelations;
use App\User;
use Illuminate\Http\Request;

class UsersRelationsController extends Controller
{
    public function getRelations(Request $request)
    {
        $users = array();
        $relations = array();
        $relationsId = array();

        if($request->user['role'] === 0) {
            $relations = UsersRelations::select('vendor_id')->where('shop_id', $request->user['id'])->get();
            foreach($relations as $relation) {
                array_push($relationsId, $relation['vendor_id']);
            }
        }
        else {
            $relations = UsersRelations::select('shop_id')->where([
                ['vendor_id', $request->user['id'] ],
                ['can_message', true],
            ])->get();
            foreach($relations as $relation) {
                array_push($relationsId, $relation['shop_id']);
            }
        }

        foreach($relationsId as $relation) {
            $currentUser = User::findOrFail($relation);
            $user = [
                'id' => $currentUser->id,
                'name' => $currentUser->name,
            ];
            array_push($users, $user);
        }

        return response()->json([
            'status' => 'success',
            'users' => $users,
        ], 200);
    }

    public function createRelation(Request $request)
    {
        $relation = new UsersRelations();

        $relation->vendor_id = $request->vendor_id;
        $relation->shop_id = $request->shop_id;
        $relation->save();

        return response()->json([
            'status' => 'success',
        ], 200);
    }

}
