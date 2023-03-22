<?php

namespace App\Http\Controllers;

use App\Http\Resources\RecipeDetailResource;
use App\Http\Resources\RecipeResource;
use App\Models\Recipe;
use Illuminate\Http\Request;

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
}
