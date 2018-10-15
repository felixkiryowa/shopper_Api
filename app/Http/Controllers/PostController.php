<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use APP\Post;
use DB;

class PostController extends Controller
{

    public function store(Request $request)
    {
        DB::table('posts')->insert(
            ['user_id' => $request->get('user_id'),'title' => $request->get('title'),
            'body' => $request->get('body')]
        );
    
        return response()->json('Successfully added');
    }
 
    public function get_all_posts(){
        try {
           
            $posts = DB::select('SELECT * FROM posts');
            return response($posts, 200);

        } 
        catch(\Illuminate\Database\QueryException $ex)
        {
             $res['success'] = false;
             $res['message'] = $ex->getMessage();
             return response($res, 500);

        }
    }

     public function get_single_post($id){
        try {
            
            $post = DB::table('posts')->where('id','=',$id)->get();
            return response($post, 200);

        } 
        catch(\Illuminate\Database\QueryException $ex)
        {
             $res['success'] = false;
             $res['message'] = $ex->getMessage();
             return response($res, 500);

        }
    }

}
