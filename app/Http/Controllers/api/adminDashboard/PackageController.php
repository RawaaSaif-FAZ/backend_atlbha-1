<?php

namespace App\Http\Controllers\api\adminDashboard;

use App\Http\Controllers\api\BaseController as BaseController;
use App\Http\Resources\PackageResource;
use App\Models\Package;
use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PackageController extends BaseController
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
        $success['packages'] = PackageResource::collection(Package::where('is_deleted', 0)->orderByDesc('created_at')->get());
        $success['status'] = 200;

        return $this->sendResponse($success, 'تم ارجاع الباقات بنجاح', 'packages return successfully');
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
        $validator = Validator::make($input, [
            'name' => 'required|string|max:255',
            'monthly_price' => 'required|numeric|gt:0',
            'yearly_price' => 'required|numeric|gt:0',
            'discount' => 'nullable|numeric|gt:0',
            'plan' => 'required|array',
            'template' => 'required|array',

        ]);
        if ($validator->fails()) {
            return $this->sendError(null, $validator->errors());
        }
        $package = Package::create([
            'name' => $request->name,
            'monthly_price' => $request->monthly_price,
            'yearly_price' => $request->yearly_price,
            'discount' => $request->discount,

        ]);
        $package->plans()->attach($request->plan);
        $package->templates()->attach($request->template);

        $success['packages'] = new PackageResource($package);
        $success['status'] = 200;

        return $this->sendResponse($success, 'تم إضافة باقة بنجاح', 'package Added successfully');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function show($package)
    {

        $package = Package::query()->find($package);
        if (is_null($package) || $package->is_deleted != 0) {
            return $this->sendError(" الباقة غير موجودة", "package is't exists");
        }

        $success['packages'] = new PackageResource($package);
        $success['status'] = 200;

        return $this->sendResponse($success, 'تم عرض الباقة بنجاح', 'package showed successfully');

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function edit(Package $package)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $package)
    {
        $package = Package::query()->find($package);

        if (is_null($package) || $package->is_deleted != 0) {
            return $this->sendError(" الياقة غير موجود", "package is't exists");
        }
        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required|string|max:255',
            'monthly_price' => 'required|numeric|gt:0',
            'yearly_price' => 'required|numeric|gt:0',
            'discount' => 'nullable|numeric|gt:0',
            'plan' => 'required|array',
            'template' => 'required|array',

        ]);
        if ($validator->fails()) {
            # code...
            return $this->sendError(null, $validator->errors());
        }
        $package->update([
            'name' => $request->input('name'),
            'monthly_price' => $request->input('monthly_price'),
            'yearly_price' => $request->input('yearly_price'),
            'discount' => $request->input('discount'),

        ]);

        if ($request->plan != null) {
            $package->plans()->sync($request->plan);
        }
        if ($request->template != null) {
            $package->templates()->sync($request->template);
        }

        $success['packages'] = new PackageResource($package);
        $success['status'] = 200;

        return $this->sendResponse($success, 'تم التعديل بنجاح', 'package updated successfully');
    }

    public function changeStatus($id)
    {
        $package = Package::query()->find($id);
        if (is_null($package) || $package->is_deleted != 0) {
            return $this->sendError(" الباقة غير موجود", "Package is't exists");
        }

        if ($package->status === 'active') {
            $package->update(['status' => 'not_active']);
        } else {
            $package->update(['status' => 'active']);
        }
        $success['packages'] = new PackageResource($package);
        $success['status'] = 200;

        return $this->sendResponse($success, 'تم تعديل حالة الباقة بنجاح', 'package updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function destroy($package)
    {
        $package = Package::query()->find($package);
        if (is_null($package) || $package->is_deleted != 0) {
            return $this->sendError("الباقة غير موجودة", "package is't exists");
        }
        $package->update(['is_deleted' => $package->id]);

        $success['packages'] = new PackageResource($package);
        $success['status'] = 200;

        return $this->sendResponse($success, 'تم حذف الباقة بنجاح', 'package deleted successfully');
    }

    public function deleteAll(Request $request)
    {

        $packages = Package::whereIn('id', $request->id)->get();
        foreach ($packages as $package) {
            if (is_null($package) || $package->is_deleted != 0) {
                return $this->sendError("الباقة غير موجودة", "package is't exists");
            }
            $package->update(['is_deleted' => $package->id]);
            $success['packages'] = new PackageResource($package);

        }

        $success['status'] = 200;

        return $this->sendResponse($success, 'تم حذف الباقة بنجاح', 'package deleted successfully');
    }
    public function changeSatusAll(Request $request)
    {

        $packages = Package::whereIn('id', $request->id)->where('is_deleted', 0)->get();
        if (count($packages) > 0) {
            foreach ($packages as $package) {
                if ($package->status === 'active') {
                    $package->update(['status' => 'not_active']);
                } else {
                    $package->update(['status' => 'active']);
                }
                $success['packages'] = new PackageResource($package);

            }
            $success['status'] = 200;

            return $this->sendResponse($success, 'تم تعديل حالة الباقة بنجاح', 'package updated successfully');
        } else {
            $success['status'] = 200;
            return $this->sendResponse($success, 'المدخلات غيرموجودة', 'id is not exit');
        }
    }

    public function planOfPackage($package_id)
    {
        $arrayplan = array();
        $plans = Plan::where('is_deleted', 0)->get()->toArray();
        $package = Package::query()->find($package_id);
        $packageplans = $package->plans->pluck("id")->toArray();

        foreach ($plans as $plan) {

            if (in_array($plan["id"], $packageplans)) {
                $arrayplan[$plan["name"]] = "on";
            } else {
                $arrayplan[$plan["name"]] = "off";
            }

        }
        $success['plans_of_package'] = $arrayplan;
        $success['status'] = 200;

        return $this->sendResponse($success, 'تم عرض الباقة بنجاح', 'package showed successfully');
    }

}
