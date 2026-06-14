<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Illuminate\Http\Request;
use App\Http\Requests\StorePlanRequest;
use App\Http\Requests\UpdatePlanRequest;
class PlanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $plans = Plan::all();
        return successResponse($plans, 'Plans retrieved successfully');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePlanRequest $request)
    {
        $plan = Plan::create($request->validated());
        return createdResponse($plan, 'Plan created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Plan $plan)
    {
        return successResponse($plan, 'Plan retrieved successfully');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Plan $plan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePlanRequest $request, Plan $plan)
    {
        $plan->update($request->validated());
        return successResponse($plan, 'Plan updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Plan $plan)
    {
        $plan->delete();
        return successResponse(null, 'Plan deleted successfully');
    }
}
