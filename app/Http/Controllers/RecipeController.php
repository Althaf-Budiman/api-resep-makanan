<?php

namespace App\Http\Controllers;

use App\Http\Resources\RecipeDetailResource;
use App\Http\Resources\RecipeResource;
use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RecipeController extends Controller
{
    public function index()
    {
        $recipes = Recipe::all();
        // return response()->json($recipes);
        return RecipeResource::collection($recipes);
    }

    public function show($id)
    {
        $recipes = Recipe::with('writer:id,name')->findOrFail($id);
        return new RecipeDetailResource($recipes);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'recipe_content' => 'required'
        ]);

        $request['author'] = Auth::user()->id;

        $recipe = Recipe::create($request->all());
        return new RecipeDetailResource($recipe->loadMissing('writer:id,name'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|max:255',
            'news_content' => 'required'
        ]);
    }
}
