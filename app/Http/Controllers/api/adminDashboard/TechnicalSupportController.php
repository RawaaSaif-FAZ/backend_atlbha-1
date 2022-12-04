<?php

namespace App\Http\Controllers\api\adminDashboard;

use App\Models\TechnicalSupport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\TechnicalsupportResource;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\api\BaseController as BaseController;

class TechnicalSupportController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
     {
       $success['Technicalsupports']=TechnicalsupportResource::collection(TechnicalSupport::where('is_deleted',0)->get());
        $success['status']= 200;

         return $this->sendResponse($success,'تم ارجاع الدعم الفني بنجاح','Technical Support return successfully');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

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
            'title'=>'required|string|max:255',
            'phoneNumber'=>'required|numeric',
            'content'=>'required|max:1000',
            'type'=>'required',
            'supportstatus'=>'required',
            'store_id' =>'required|exists:stores,id'


        ]);
        if ($validator->fails())
        {
            return $this->sendError(null,$validator->errors());
        }
        $technicalsupport = TechnicalSupport::create([
            'title' => $request->title,
            'phoneNumber'=>$request->phoneNumber,
            'content'=>$request->content,
             'type' => $request->type,
            'supportstatus'=>$request->supportstatus,
            'store_id'=>$request->store_id,

          ]);

         // return new CountryResource($country);
         $success['Technicalsupports']=New TechnicalsupportResource($technicalsupport);
        $success['status']= 200;

         return $this->sendResponse($success,'تم إضافة طلب دعم فني بنجاح','Technical Support Added successfully');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TechnicalSupport  $technicalSupport
     * @return \Illuminate\Http\Response
     */
    public function show($technicalSupport)
 {
          $technicalSupport = TechnicalSupport::query()->find($technicalSupport);
         if ($technicalSupport->is_deleted == 1){
         return $this->sendError("طلب الدعم الفني غير موجود","Technical Support is't exists");
         }


        $success['technicalSupports']=New TechnicalSupportResource($technicalSupport);
        $success['status']= 200;

         return $this->sendResponse($success,'تم عرض بنجاح','Technical Support showed successfully');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TechnicalSupport  $technicalSupport
     * @return \Illuminate\Http\Response
     */
    public function edit(TechnicalSupport $technicalSupport)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TechnicalSupport  $technicalSupport
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TechnicalSupport $technicalSupport)
    {
         if ($technicalSupport->is_deleted==1){
         return $this->sendError("طلب الدعم غير موجود","technicalSupport is't exists");
          }
         $input = $request->all();
         $validator =  Validator::make($input ,[
          'title'=>'required|string|max:255',
            'phoneNumber'=>'required|numeric',
            'content'=>'required|max:1000',
            'type'=>'required',
            'supportstatus'=>'required',
            'store_id' =>'required|exists:stores,id'
         ]);
         if ($validator->fails())
         {
            # code...
            return $this->sendError(null,$validator->errors());
         }
         $technicalSupport->update([
            'title' => $request->input('title'),
            'phoneNumber' => $request->input('phoneNumber'),
            'content' => $request->input('content'),
            'type' => $request->input('type'),
            'supportstatus' => $request->input('supportstatus'),
            'store_id' => $request->input('store_id'),
         ]);
         //$country->fill($request->post())->update();
            $success['technicalSupports']=New TechnicalSupportResource($technicalSupport);
            $success['status']= 200;

            return $this->sendResponse($success,'تم التعديل بنجاح','technical Support updated successfully');
        }

         public function changeStatus($id)
    {
        $technicalSupport = TechnicalSupport::query()->find($id);
         if ($technicalSupport->is_deleted==1){
         return $this->sendError("طلب الدعم غير موجود","technical Support is't exists");
         }

        if($technicalSupport->status === 'active'){
        $technicalSupport->update(['status' => 'not_active']);
        }
        else{
        $technicalSupport->update(['status' => 'active']);
        }
        $success['technicalSupports']=New TechnicalSupportResource($technicalSupport);
        $success['status']= 200;

         return $this->sendResponse($success,'تم تعديل حالة طلب الدعم بنجاح','technical Support updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TechnicalSupport  $technicalSupport
     * @return \Illuminate\Http\Response
     */
    public function destroy($technicalSupport)
   {
       $technicalSupport = TechnicalSupport::query()->find($technicalSupport);
         if ($technicalSupport->is_deleted==1){
         return $this->sendError("الوحدة غير موجودة","technicalSupport is't exists");
         }
        $technicalSupport->update(['is_deleted' => 1]);

        $success['technicalSupport']=New TechnicalSupportResource($technicalSupport);
        $success['status']= 200;

         return $this->sendResponse($success,'تم حذف طلب الدعم بنجاح','technical Support deleted successfully');
    }
}
