<?php

namespace App\Http\Controllers\api\adminDashboard;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\CommentResource;
use App\Http\Controllers\api\BaseController as BaseController;

class CommentController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $success['comment']=CommentResource::collection(Comment::where('is_deleted',0)->get());
        $success['status']= 200;

         return $this->sendResponse($success,'تم ارجاع التعليقات بنجاح','comments return successfully');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $input = $request->all();
        $validator =  Validator::make($input ,[
            'comment_text'=>'required|string|max:255',
            'rateing'=>'required|numeric',
            'product_id'=>'required|exists:products,id',
            'user_id'=>'required|exists:users,id'


        ]);
        if ($validator->fails())
        {
            return $this->sendError(null,$validator->errors());
        }
        $comment = Comment::create([
            'comment_text' => $request->comment_text,
            'rateing' => $request->rateing,
            'product_id' => $request->product_id,
            'user_id' => $request->user_id,

          ]);


         $success['comments']=New CommentResource($comment);
        $success['status']= 200;

         return $this->sendResponse($success,'تم إضافة تعليق بنجاح','comment Added successfully');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show($comment)
   {
        $comment = Comment::query()->find($comment);
        if ($comment->is_deleted==1){
        return $this->sendError("'طريقة الدفع غير موجودة","comment type is't exists");
        }


       $success['comments']=New CommentResource($comment);
       $success['status']= 200;

        return $this->sendResponse($success,'تم عرض التعليق بنجاح','comment showed successfully');
     }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $comment)
      {
         if ($comment->is_deleted==1){
         return $this->sendError(" التعليق غير موجود","comment is't exists");
          }
         $input = $request->all();
         $validator =  Validator::make($input ,[
           'comment_text'=>'required|string|max:255',
            'rateing'=>'required|numeric',
            'product_id'=>'required|exists:products,id',
            'user_id'=>'required|exists:users,id'
         ]);
         if ($validator->fails())
         {
            # code...
            return $this->sendError(null,$validator->errors());
         }
         $comment->update([
            'comment_text' => $request->input('comment_text'),
            'rateing' => $request->input('rateing'),
            'product_id' => $request->input('product_id'),
           'user_id' => $request->input('user_id'),
         ]);
         //$country->fill($request->post())->update();
            $success['comments']=New commentResource($comment);
            $success['status']= 200;

            return $this->sendResponse($success,'تم التعديل بنجاح','comment updated successfully');
    }

    public function changeStatus($id)
    {
        $comment = Comment::query()->find($id);
         if ($comment->is_deleted==1){
         return $this->sendError("التعليق غير موجود","comment is't exists");
         }

        if($comment->status === 'active'){
        $comment->update(['status' => 'not_active']);
        }
        else{
        $comment->update(['status' => 'active']);
        }
        $success['comments']=New CommentResource($comment);
        $success['status']= 200;

         return $this->sendResponse($success,'تم تعديل حالة التعليق بنجاح','comment updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy($comment)
      {
       $comment = Comment::query()->find($comment);
         if ($comment->is_deleted==1){
         return $this->sendError("التعليق غير موجود","comment is't exists");
         }
        $comment->update(['is_deleted' => 1]);

        $success['comments']=New CommentResource($comment);
        $success['status']= 200;

         return $this->sendResponse($success,'تم حذف التعليق بنجاح',' comment deleted successfully');
    }
}
