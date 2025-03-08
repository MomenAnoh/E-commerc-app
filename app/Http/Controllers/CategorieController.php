<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoreRequest;
use App\Http\Resources\CategorieResource;
use App\Models\Categorie;
use Illuminate\Http\Request;

class CategorieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       $categories = Categorie::all();
        return response()->json([
                'message'   => 'success',
                'status'   => 200,
                'data'=>  CategorieResource::collection($categories)
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
    public function store(CategoreRequest $request)
    {
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('image', 'public');
        } else {
            return response()->json(['error' => 'Image upload failed'], 500);
        }
         $categorie = new Categorie();
         $categorie->name=$request->name;
         $categorie->image=$imagePath;
         $categorie->save();
         return response()->json([
         'message'   => 'success',
         'status'   => 200,
         'data'=>new CategorieResource($categorie)
          ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {

        $one_categore=Categorie::find($id);
        if(!$one_categore){
            return response()->json([
                'message'   => 'category not found',
            ]);
        }
        return response()->json([
            'message'   => 'success',
            'status'   => 200,
            'data'=> new CategorieResource($one_categore)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Categorie $categorie)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Categorie $categorie)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Categorie $categorie)
    {
        //
    }
    public function productOFcategore(request $request)
    {

    }
}
