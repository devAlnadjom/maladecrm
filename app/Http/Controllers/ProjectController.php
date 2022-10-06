<?php

namespace App\Http\Controllers;

use App\Http\Requests\Project\StoreActivityRequest;
use App\Http\Requests\Project\StoreTaskRequest;
use App\Http\Requests\StoreProjectRequest;
use App\Models\Activity;
use Inertia\Inertia;
use App\Models\Project;
use App\Models\Customer;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class ProjectController extends Controller
{

    public function index()
    {

        return Inertia::render('Projects/Index', [
            'projects' => Project::Select(['id', 'project_name', 'project_theme', 'project_category','project_end_date','customer_id'])
                        ->with(['customer:id,name'])
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
        $project = Project::findOrFail($project)
                    ->with('tasks')
                    ->withCount('activities')->get();

        //dd($project);
        //$company = $project->company()->withoutGlobalScopes()->first();
        //$tasks = $project->load('tasks');


        return Inertia::render('Projects/Show', [
            'project' => $project[0],
            //'comments' => $comments,
        ]);
    }


    public function edit(Project $project)
    {
        //
    }


    public function update(Request $request, Project $project)
    {
        //
    }


    public function destroy(Project $project)
    {
        //
    }


    public function storeTask(StoreTaskRequest $request)
    {
        $validated = $request->validated();
        //dd($validated);
        Task::create($validated);

        return Redirect::back()->with('success', "Projet Ajoutee");
    }

    public function storeActivity(StoreActivityRequest $request)
    {
        $validated = $request->validated();
        //dd($validated);
        Activity::create($validated);

        return Redirect::back()->with('success', "Projet Ajoutee");
    }


    public function showTask(int $project, int $task, Request $request)
    {
        $project = Project::findOrFail($project);
        $task = Task::findOrFail($task)->with('activites');
        $company = $project->company()->withoutGlobalScopes()->first();

        //$tasks = $project->load('tasks');

        /*if ($request->wantsJson()) {
            if ($request->has('view') && $request->get('view') == "invoices") {
                $data = [
                    "invoices" => $project->orders()->latest()->where('order_status', '<>', '6')->take(30)->get(),
                    "count_invoices" => $project->orders()->count(),
                    "validated_orders" => $project->orders()->whereIn('order_status', [2, 3])->count(),
                    "validated_sum" => $project->orders()->whereIn('order_status', [2, 3])->sum('ttc_total_order'),
                ];
                return response()->json($data);
            }
        }*/

        return Inertia::render('Projects/Show', [
            'project' => $project,
            'task' => $task,
            //'comments' => $comments,
        ]);
    }
}
