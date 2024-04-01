<?php
namespace App\Http\Controllers;

use App\Models\SubscriptionPlan;
use Illuminate\Http\Request;
use App\Http\Requests\StoreSubscriptionPlanRequest;
use App\Http\Requests\UpdateSubscriptionPlanRequest;
use Illuminate\Support\Str;


class SubscriptionPlanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
    	$subscription_plans = SubscriptionPlan::where('id', '>', -1)
        ->orderBy('created_at', 'desc');

        if ($request->input('page') == null ||
            $request->input('page') == '') {
            $subscription_plans = $subscription_plans->get();
        } else {
            $subscription_plans = $subscription_plans->paginate();
        }

        $data = [
            'success' => true,
            'subscription_plans' => $subscription_plans
        ];

        return response()->json($data);
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
    public function store(StoreSubscriptionPlanRequest $request)
    {
        $validated = $request->validated();

        $subscription_plan = new SubscriptionPlan;

        $subscription_plan->name = $validated['name'] ?? null;
		$subscription_plan->slug = $validated['slug'] ?? null;
		$subscription_plan->price = $validated['price'] ?? null;
		$subscription_plan->description = $validated['description'] ?? null;
		$subscription_plan->num_product = $validated['num_product'] ?? null;
		$subscription_plan->num_account = $validated['num_account'] ?? null;

        $subscription_plan->save();

        $data = [
            'success'       => true,
            'subscription_plan'   => $subscription_plan
        ];

        return response()->json($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SubscriptionPlan  $subscription_plan
     * @return \Illuminate\Http\Response
     */
    public function show(SubscriptionPlan $subscription_plan)
    {
        $data = [
            'success' => true,
            'subscription_plan' => $subscription_plan
        ];

        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SubscriptionPlan  $subscription_plan
     * @return \Illuminate\Http\Response
     */
    public function edit(SubscriptionPlan $subscription_plan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SubscriptionPlan  $subscription_plan
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSubscriptionPlanRequest $request, SubscriptionPlan $subscription_plan)
    {
        $validated = $request->validated();

        $subscription_plan->name = $validated['name'] ?? null;
		$subscription_plan->slug = $validated['slug'] ?? null;
		$subscription_plan->price = $validated['price'] ?? null;
		$subscription_plan->description = $validated['description'] ?? null;
		$subscription_plan->num_product = $validated['num_product'] ?? null;
		$subscription_plan->num_account = $validated['num_account'] ?? null;

        $subscription_plan->save();

        $data = [
            'success'       => true,
            'subscription_plan'   => $subscription_plan
        ];

        return response()->json($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SubscriptionPlan  $subscription_plan
     * @return \Illuminate\Http\Response
     */
    public function destroy(SubscriptionPlan $subscription_plan)
    {
        $subscription_plan->delete();

        $data = [
            'success' => true,
            'subscription_plan' => $subscription_plan
        ];

        return response()->json($data);
    }
}
