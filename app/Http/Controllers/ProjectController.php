<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProjectRequest;
use Inertia\Inertia;
use App\Models\Project;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class ProjectController extends Controller
{

    public function index()
    {

        return Inertia::render('Projects/Index', [
            'projects' => Project::Select(['id', 'project_name', 'project_theme', 'project_category','project_end_date','customer_id'])
                        ->with('customer:id,name')
                        ->withCount('Tasks')
                        ->paginate(9),
        ]);
    }


    public function create(Request $request)
    {
        if ($request->has('customer_id')) {
            $customer_id=$request->query('customer_id');
        }
        $customers= Customer::Select(['id','name','contact','solde'])
                    ->get();
            //dd($customers);
        return Inertia::render('Projects/Create',[
            'customers'=> $customers,
            'company'=> auth()->user()->company->name,
            'customer_id' => isset($customer_id)?$customer_id:null
        ]);
    }


    public function store(StoreProjectRequest $request)
    {
        $validated = $request->validated();
        //dd($validated);
        $project = Project::create($validated);

        return Redirect::route('projects.index')->with('success', "Fiche Client mis à jour");
    }


    public function show(int $project, Request $request)
    {
        $project = Project::findOrFail($project);

        $company = $project->company()->withoutGlobalScopes()->first();


        // dd($project);
        if ($request->wantsJson()) {
            if ($request->has('view') && $request->get('view') == "invoices") {
                $data = [
                    "invoices" => $project->orders()->latest()->where('order_status', '<>', '6')->take(30)->get(),
                    "count_invoices" => $project->orders()->count(),
                    "validated_orders" => $project->orders()->whereIn('order_status', [2, 3])->count(),
                    "validated_sum" => $project->orders()->whereIn('order_status', [2, 3])->sum('ttc_total_order'),
                ];
                return response()->json($data);
            }
        }

       //$comments = $project->customerLogs()->latest()->take(10)->get();

        return Inertia::render('Projects/Show', [
            'project' => $project,
            //'comments' => $comments,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        //
    }
}
