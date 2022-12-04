<?php

namespace App\Http\Controllers\api\adminDashboard;

use App\Models\Service;
use Illuminate\Http\Request;
use App\Http\Resources\ServiceResource;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\api\BaseController as BaseController;

class ServiceController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $success['Services']=ServiceResource::collection(Service::where('is_deleted',0)->get());
        $success['status']= 200;

         return $this->sendResponse($success,'تم ارجاع الخدمات بنجاح','Services return successfully');
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
            'name'=>'required|string|max:255',
            'description'=>'required|string',
            'file'=>'required',
             'price'=>'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/'
        ]);
        if ($validator->fails())
        {
            return $this->sendError(null,$validator->errors());
        }
        $service = Service::create([
            'name' => $request->name,
            'description'=>$request->description,
            'file' =>$request->file,
            'price' => $request->price,
          ]);


         $success['services']=New ServiceResource( $service);
        $success['status']= 200;

         return $this->sendResponse($success,'تم إضافة الخدمة بنجاح',' service Added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function show($service)
    {
        $service = Service::query()->find($service);
        if ($service->is_deleted==1){
        return $this->sendError("الخدمة غير موجودة","service is't exists");
        }


       $success['services']=New ServiceResource($service);
       $success['status']= 200;

        return $this->sendResponse($success,'تم عرض الخدمة  بنجاح','service showed successfully');
    }
    public function changeStatus($id)
    {
        $service = Service::query()->find($id);
         if ($service->is_deleted==1){
         return $this->sendError(" الخدمة غير موجودة","service is't exists");
         }

        if($service->status === 'active'){
            $service->update(['status' => 'not_active']);
        }
        else{
            $service->update(['status' => 'active']);
        }
        $success['services']=New ServiceResource($service);
        $success['status']= 200;

         return $this->sendResponse($success,'تم تعديل حالة الخدمة بنجاح','service updated successfully');

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function edit(Service $service)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Service $service)
    {
        if ($service->is_deleted==1){
            return $this->sendError("الخدمة غير موجودة","service is't exists");
       }
            $input = $request->all();
           $validator =  Validator::make($input ,[
            'name'=>'required|string|max:255',
            'description'=>'required|string',
            'file'=>'required',
             'price'=>'required|numeric|gt:0',
           ]);
           if ($validator->fails())
           {
               # code...
               return $this->sendError(null,$validator->errors());
           }
           $service->update([
               'name' => $request->input('name'),
               'description' => $request->input('description'),
               'file' => $request->input('file'),
               'price' => $request->input('price')
           ]);

           $success['services']=New ServiceResource($service);
           $success['status']= 200;

            return $this->sendResponse($success,'تم التعديل بنجاح','service updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function destroy($service)
    {
        $service = Service::query()->find($service);
        if ($service->is_deleted==1){
            return $this->sendError("االخدمة غير موجودة","service is't exists");
            }
           $service->update(['is_deleted' => 1]);

           $success['cities']=New ServiceResource($service);
           $success['status']= 200;

            return $this->sendResponse($success,'تم حذف الخدمة بنجاح','service deleted successfully');
    }
}

