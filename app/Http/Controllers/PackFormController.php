<?php

namespace App\Http\Controllers;

use App\Models\PackForm;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\PackFormRequest;
use App\Models\Company;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class PackFormController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $packForms = PackForm::paginate();

        return view('admin.pack-form.index', compact('packForms'))
            ->with('i', ($request->input('page', 1) - 1) * $packForms->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $packForm = new PackForm();
        $companies = Company::orderBy('name', 'asc')->get();
        return view('admin.pack-form.create', compact('packForm','companies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PackFormRequest $request): RedirectResponse
    {
        PackForm::create($request->validated());

        return Redirect::route('pack-forms.index')
            ->with('success', 'PackForm created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $packForm = PackForm::find($id);

        return view('admin.pack-form.show', compact('packForm'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $packForm = PackForm::find($id);
        $companies = Company::orderBy('name', 'asc')->get();
        return view('admin.pack-form.edit', compact('packForm','companies'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PackFormRequest $request, PackForm $packForm): RedirectResponse
    {
        $packForm->update($request->validated());

        return Redirect::route('pack-forms.index')
            ->with('success', 'PackForm updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        PackForm::find($id)->delete();

        return Redirect::route('pack-forms.index')
            ->with('success', 'PackForm deleted successfully');
    }
}
