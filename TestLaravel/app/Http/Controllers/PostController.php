<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use DB;
use App\Models\Post;
use App\Models\Comment;

class PostController extends Controller
{
    //

    public function index()
    {
        $post = Post::with('comments')->get();

        $response = [
            'status' => true,
            'message' => 'Post info list',
            'data' => $post,
            'code' => 200
        ];

        return $response;
    }

    public function store(Request $req)
    {
        DB::beginTransaction();

        try{

            $validator = Validator::make($req->all(), [
                'title'            => 'required',
                'description'      => 'required',
        
            ]);
    
            if($validator->fails())
            {
               $response = [
                'status' => false,
                'message' => 'Validation error.',
                'data' => $validator->errors(),
                'code'  => 400
            ];
            return $response;
            }

            else{

            $post = new Post();
            $post->title = $req->title;
            $post->description = $req->description;
            $post->save();
            $response = [
                    'status' => true,
                    'message' => 'Post created successfully.',
                    'data' => $post,
                    'code'  => 200
                ];

                DB::commit();

            }
            
        }

        catch(\Exception $e){

            $response = [
                'status' => false,
                'message' => 'Exception error.',
                'data' => $e,
                'code' => 400
            ];

            DB::rollback();  
        }
        return $response;
       
    }

    public function view($id)
    {
        $post = Post::select('id', 'title', 'description')->find($id);

        if($post)
        {
            $response = [
                'status' => true,
                'message' => 'Post info details',
                'data' => $post,
                'code' => 200
            ];
        }
        else
        {
            $response = [
                'status' => false,
                'message' => 'Post info details not found',
                'data' => '',
                'code' => 404
            ];
        }

        return $response;

    }
}
