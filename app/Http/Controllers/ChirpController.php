<?php

namespace App\Http\Controllers;

use App\Models\Chirp;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;
use Inertia\Response;

class ChirpController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        return Inertia::render('Chirps/Index', [
            // display chirps in reverse order
            'chirps' => Chirp::with('user:id,name')->latest()->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        // validate the data and create a new chirp
        $validated = $request->validate([
            'message' => 'required|string|max:255',
        ]);

        // Create a new chirp associated with the authenticated user
        $request->user()->chirps()->create($validated);

        // Redirect to the chirps index page after successful creation
        return redirect(route('chirps.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Chirp $chirp)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Chirp $chirp)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Chirp $chirp): RedirectResponse
    {
        // Authorize the user's update action on the chirp
        Gate::authorize('update', $chirp);

        // Validate the request data for updating the chirp
        $validated = $request->validate([
            'message' => 'required|string|max:255',
        ]);

        // Update the chirp with the validated data
        $chirp->update($validated);

        // Redirect to the chirps index page after successful update
        return redirect(route('chirps.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Chirp $chirp): RedirectResponse
    {
        // Authorize the user's delete action on the chirp
        Gate::authorize('delete', $chirp);

        // Delete the chirp
        $chirp->delete();

        // Redirect to the chirps index page after successful delete
        return redirect(route('chirps.index'));
    }
}
