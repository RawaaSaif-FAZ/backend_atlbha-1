<?php

namespace App\Http\Controllers\api\adminDashboard;

use App\Models\Contact;
use Illuminate\Http\Request;
use App\Http\Resources\ContactResource;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\api\BaseController as BaseController;

class ContactController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $success['Contacts']=ContactResource::collection(Contact::where('is_deleted',0)->get());
        $success['status']= 200;

         return $this->sendResponse($success,'تم ارجاع جميع بيانات التواصل بنجاح','Contacts return successfully');
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
            'subject'=>'required|string|max:255',
            'message'=>'required|string',
            'store_id'=>'required|exists:stores,id'
        ]);
        if ($validator->fails())
        {
            return $this->sendError(null,$validator->errors());
        }
        $contact = Contact::create([
            'subject' => $request->subject,
            'message' => $request->message,
            'store_id' => $request->store_id,
          ]);


         $success['contacts']=New ContactResource($contact);
        $success['status']= 200;

         return $this->sendResponse($success,'تم إضافة بيانات التواصل بنجاح','Contact Added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function show($contact)
    {
        $contact= Contact::query()->find($contact);
        if ($contact->is_deleted==1){
               return $this->sendError("بيانات التواصل غير موجودة","contact is't exists");
               }
              $success['contacts']=New ContactResource($contact);
              $success['status']= 200;

               return $this->sendResponse($success,'تم عرض بيانات التواصل بنجاح','contact showed successfully');
    }
    public function changeStatus($id)
    {
        $contact = contact::query()->find($id);
        if ($contact->is_deleted==1){
         return $this->sendError("بيانات التواصل غير موجودة","contact is't exists");
         }
        if($contact->status === 'active'){
            $contact->update(['status' => 'not_active']);
     }
    else{
        $contact->update(['status' => 'active']);
    }
        $success['contacts']=New ContactResource($contact);
        $success['status']= 200;
         return $this->sendResponse($success,'تم تعدبل حالة بيانات التواصل بنجاح',' contact status updared successfully');

    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function edit(Contact $contact)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Contact $contact)
    {
        if ($contact->is_deleted==1){
            return $this->sendError("بيانات التواصل غير موجودة"," contact is't exists");
       }
            $input = $request->all();
           $validator =  Validator::make($input ,[
            'subject'=>'required|string|max:255',
            'message'=>'required|string',
            'store_id'=>'required|exists:stores,id'

           ]);
           if ($validator->fails())
           {
               # code...
               return $this->sendError(null,$validator->errors());
           }
           $contact->update([
               'subject' => $request->input('subject'),
               'message' => $request->input('message'),
               'store_id' => $request->input('store_id'),

           ]);

           $success['contacts']=New contactResource($contact);
           $success['status']= 200;

            return $this->sendResponse($success,'تم التعديل بنجاح','contact updated successfully');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function destroy($contact)
    {
        $contact =contact::query()->find($contact);
        if ($contact->is_deleted==1){
            return $this->sendError("بيانات التواصل غير موجودة","contact is't exists");
            }
           $contact->update(['is_deleted' => 1]);

           $success['contacts']=New contactResource($contact);
           $success['status']= 200;

            return $this->sendResponse($success,'تم حذف بيانات التواصل بنجاح','contact deleted successfully');
    }
}
