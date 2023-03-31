<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use DB;
use App\Models\Comment;
use App\Models\Post;

class CommentController extends Controller
{

    public function index()
    {
        $comment = Comment::select('id','post_id','message')->get();

        $response = [
            'status' => true,
            'message' => 'Comment info list',
            'data' => $comment,
            'code' => 200
        ];

        return $response;
    }


    public function store( $post_id , Request $req)
    {
        DB::beginTransaction();

        try{

            $validator = Validator::make($req->all(), [
                'message'      => 'required',
        
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
            
            $post = Post::where('id', $post_id)->first();

            $comment = new Comment();
            $comment->post_id = $post->id;
            $comment->message = $req->message;
            $comment->save();
            $response = [
                    'status' => true,
                    'message' => 'comment created successfully.',
                    'data' => $comment,
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

   
}
