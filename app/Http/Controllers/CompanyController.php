<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class CompanyController extends Controller
{
    public function index()
    {
        dd("Hello");
    }


    public function create()
    {
        return Inertia::render('Companies/Create',[]);
    }

    public function store(StoreCompanyRequest $request)
    {
        $validated = $request->validated();
        //dd($validated);
        $company=Company::create($validated);

        $company->owner()->update(['company_id'=> $company->id]);

        return Redirect::route('customers.index')->with('success', "Fiche entreprise mis à jour");
    }

    public function my_company(){
        if(!auth()->user()->company->id){
            abort(404);
        }

        $company= Company::findorFail(auth()->user()->company->id);
        return Inertia::render('Companies/Edit',[
            'companies' => $company,
        ]);

    }

    public function update(UpdateCompanyRequest $request, $company)
    {
        $company= Company::findOrFail($company);
        if($company->id != auth()->user()->company->id){ abort(403);}

        $validated = $request->validated();
        $company->update($validated);

        return Redirect::back()->with('success', "Fiche entreprise mis à jour");
    }
}
