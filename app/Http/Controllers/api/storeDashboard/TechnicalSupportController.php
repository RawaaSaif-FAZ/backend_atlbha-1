<?php

namespace App\Http\Controllers\api\storeDashboard;

use App\Http\Controllers\api\BaseController as BaseController;
use App\Http\Resources\TechnicalsupportResource;
use App\Models\TechnicalSupport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TechnicalSupportController extends BaseController
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $success['Technicalsupports'] = TechnicalsupportResource::collection(TechnicalSupport::where('is_deleted', 0)->where('store_id', auth()->user()->store_id)->get());
        $success['status'] = 200;

        return $this->sendResponse($success, 'تم ارجاع الدعم الفني بنجاح', 'Technical Support return successfully');
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
    // public function store(Request $request)
    // {
    //   $input = $request->all();
    //     $validator =  Validator::make($input ,[
    //         'title'=>'required|string|max:255',
    //         'phonenumber' =>['required','numeric','regex:/^(009665|9665|\+9665)(5|0|3|6|4|9|1|8|7)([0-9]{7})$/'],
    //         'content'=>'required|max:1000',
    //         'type'=>'required|in:complaint,enquiry,suggestion',
    //         'supportstatus'=>'required|in:finished,not_finished,pending',
    //         'user_id' =>'required|exists:users,id'

    //     ]);
    //     if ($validator->fails())
    //     {
    //         return $this->sendError(null,$validator->errors());
    //     }
    //     $technicalsupport = TechnicalSupport::create([
    //         'title' => $request->title,
    //         'phonenumber'=>$request->phonenumber,
    //         'content'=>$request->content,
    //          'type' => $request->type,
    //         'supportstatus'=>$request->supportstatus,
    //         // 'store_id'=>$request->store_id,

    //       ]);

    //      // return new CountryResource($country);
    //      $success['Technicalsupports']=New TechnicalsupportResource($technicalsupport);
    //     $success['status']= 200;

    //      return $this->sendResponse($success,'تم إضافة طلب دعم فني بنجاح','Technical Support Added successfully');

    // }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TechnicalSupport  $technicalSupport
     * @return \Illuminate\Http\Response
     */
    public function show($technicalSupport)
    {
        $technicalSupport = TechnicalSupport::where('id', $technicalSupport)->where('store_id', auth()->user()->store_id)->first();
        if (is_null($technicalSupport) || $technicalSupport->is_deleted == 1) {
            return $this->sendError("طلب الدعم الفني غير موجود", "Technical Support is't exists");
        }

        $success['technicalSupports'] = new TechnicalSupportResource($technicalSupport);
        $success['status'] = 200;

        return $this->sendResponse($success, 'تم عرض بنجاح', 'Technical Support showed successfully');
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
    // public function update(Request $request, TechnicalSupport $technicalSupport)
    // {
    //      if (is_null($technicalSupport) || $technicalSupport->is_deleted==1){
    //      return $this->sendError("طلب الدعم غير موجود","technicalSupport is't exists");
    //       }
    //      $input = $request->all();
    //      $validator =  Validator::make($input ,[
    //       'title'=>'required|string|max:255',
    //         'phonenumber' =>['required','numeric','regex:/^(009665|9665|\+9665)(5|0|3|6|4|9|1|8|7)([0-9]{7})$/'],
    //         'content'=>'required|max:1000',
    //         'type'=>'required|in:complaint,enquiry,suggestion',
    //         'supportstatus'=>'required|in:finished,not_finished,pending',
    //         'user_id' =>'required|exists:users,id'
    //      ]);
    //      if ($validator->fails())
    //      {
    //         # code...
    //         return $this->sendError(null,$validator->errors());
    //      }
    //      $technicalSupport->update([
    //         'title' => $request->input('title'),
    //         'phonenumber' => $request->input('phonenumber'),
    //         'content' => $request->input('content'),
    //         'type' => $request->input('type'),
    //         'supportstatus' => $request->input('supportstatus'),
    //         'uder_id' => $request->input('uder_id'),
    //      ]);
    //         $success['technicalSupports']=New TechnicalSupportResource($technicalSupport);
    //         $success['status']= 200;

    //         return $this->sendResponse($success,'تم التعديل بنجاح','technical Support updated successfully');
    //     }

    //      public function changeStatus($id)
    // {
    //     $technicalSupport = TechnicalSupport::query()->find($id);
    //      if (is_null($technicalSupport) || $technicalSupport->is_deleted==1){
    //      return $this->sendError("طلب الدعم غير موجود","technical Support is't exists");
    //      }

    //     if($technicalSupport->status === 'active'){
    //     $technicalSupport->update(['status' => 'not_active']);
    //     }
    //     else{
    //     $technicalSupport->update(['status' => 'active']);
    //     }
    //     $success['technicalSupports']=New TechnicalSupportResource($technicalSupport);
    //     $success['status']= 200;

    //      return $this->sendResponse($success,'تم تعديل حالة طلب الدعم بنجاح','technical Support updated successfully');

    // }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TechnicalSupport  $technicalSupport
     * @return \Illuminate\Http\Response
     */
    public function destroy($technicalSupport)
    {
        $technicalSupport = TechnicalSupport::where('id', $technicalSupport)->where('store_id', auth()->user()->store_id)->first();

        if (is_null($technicalSupport) || $technicalSupport->is_deleted == 1) {
            return $this->sendError("الصف غير موجودة", "technicalSupport is't exists");
        }
        $technicalSupport->update(['is_deleted' => 1]);

        $success['technicalSupport'] = new TechnicalSupportResource($technicalSupport);
        $success['status'] = 200;

        return $this->sendResponse($success, 'تم حذف طلب الدعم بنجاح', 'technical Support deleted successfully');
    }

    public function deleteall(Request $request)
    {

        $technicalSupports = technicalSupport::whereIn('id', $request->id)->where('is_deleted', 0)->where('store_id', auth()->user()->store_id)->get();
        // dd($technicalSupports);
        if (count($technicalSupports) > 0) {
            foreach ($technicalSupports as $technicalSupport) {

                $technicalSupport->update(['is_deleted' => 1]);
                $success['technicalSupports'] = new TechnicalSupportResource($technicalSupport);

            }

            $success['status'] = 200;

            return $this->sendResponse($success, 'تم حذف المنتج بنجاح', 'technicalSupport deleted successfully');
        } else {
            $success['status'] = 200;
            return $this->sendError("الصف غير موجودة", "technicalSupport is't exists");
        }

    }
}
