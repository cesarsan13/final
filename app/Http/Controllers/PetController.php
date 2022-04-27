<?php

namespace App\Http\Controllers;

use App\Models\Pet;
use Illuminate\Http\Request;

/**
 * Class PetController
 * @package App\Http\Controllers
 */
class PetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pets = Pet::paginate();

        return view('pet.index', compact('pets'))
            ->with('i', (request()->input('page', 1) - 1) * $pets->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pet = new Pet();
        return view('pet.create', compact('pet'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(Pet::$rules);

        $pet = Pet::create($request->all());

        return redirect()->route('pets.index')
            ->with('success', 'Pet created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pet = Pet::find($id);

        return view('pet.show', compact('pet'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pet = Pet::find($id);

        return view('pet.edit', compact('pet'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Pet $pet
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pet $pet)
    {
        request()->validate(Pet::$rules);

        $pet->update($request->all());

        return redirect()->route('pets.index')
            ->with('success', 'Pet updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $pet = Pet::find($id)->delete();

        return redirect()->route('pets.index')
            ->with('success', 'Pet deleted successfully');
    }
}
