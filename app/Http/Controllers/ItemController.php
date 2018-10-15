<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Item;
use DB;

class ItemController extends Controller
{
    public function store(Request $request)
    {
        $item = new Item([
          'name' => $request->get('name'),
          'price' => $request->get('price')
        ]);
        $item->save();
        return response()->json('Successfully added');
    }


    public function get_all_items(){
        try {
            //$menu = DB::table('m_menus')->join('m_menu_types', 'm_menus.id', '=', 'm_menu_types.menu_item_id')->select('m_menus.*', 'm_menu_types.type_name')->get();
            //$res['success'] = true;
            //$res['data'] = $menu;
            //$res['count'] = $menu->count();
            $users = DB::select('SELECT * FROM items');
            return response($users, 200);

        } 
        catch(\Illuminate\Database\QueryException $ex)
        {
             $res['success'] = false;
             $res['message'] = $ex->getMessage();
             return response($res, 500);

        }
    }
    public function get_single_items($id){
        try {
            
            $users = DB::table('items')->where('id','=',$id)->get();
            return response($users, 200);

        } 
        catch(\Illuminate\Database\QueryException $ex)
        {
             $res['success'] = false;
             $res['message'] = $ex->getMessage();
             return response($res, 500);

        }
    }




    
}
