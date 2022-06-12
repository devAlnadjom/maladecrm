<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCompanyRequest;
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

        return Redirect::route('customers.index')->with('success', "You added successfully your company");
    }
}
