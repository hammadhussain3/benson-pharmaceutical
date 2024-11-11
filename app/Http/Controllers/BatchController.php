<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\BatchRequest;
use App\Models\Product;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class BatchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $batches = Batch::paginate();

        return view('admin.batch.index', compact('batches'))
            ->with('i', ($request->input('page', 1) - 1) * $batches->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $batch = new Batch();
        $products = Product::orderBy('name', 'asc')->get();
        return view('admin.batch.create', compact('batch','products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BatchRequest $request): RedirectResponse
    {
        Batch::create($request->validated());

        return Redirect::route('batches.index')
            ->with('success', 'Batch created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $batch = Batch::find($id);

        return view('admin.batch.show', compact('batch'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $batch = Batch::find($id);
        $products = Product::orderBy('name', 'asc')->get();
        return view('admin.batch.edit', compact('batch','products'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BatchRequest $request, Batch $batch): RedirectResponse
    {
        $batch->update($request->validated());

        return Redirect::route('batches.index')
            ->with('success', 'Batch updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        Batch::find($id)->delete();

        return Redirect::route('batches.index')
            ->with('success', 'Batch deleted successfully');
    }
}
