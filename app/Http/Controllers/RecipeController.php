<?php

namespace App\Http\Controllers;

use App\Http\Resources\RecipeDetailResource;
use App\Http\Resources\RecipeResource;
use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class RecipeController extends Controller
{
    public function index()
    {
        $recipes = Recipe::all();
        // return response()->json($recipes);
        return RecipeDetailResource::collection($recipes->loadMissing(['writer:id,name', 'comments:id,recipe_id,user_id,comment_content']));
    }

    public function show($id)
    {
        $recipes = Recipe::with(['writer:id,name', 'comments:id,recipe_id,user_id,comment_content'])->findOrFail($id);
        return new RecipeDetailResource($recipes);
    }

    public function search($query)
    {
        $results = Recipe::where('title', 'like', "%$query%")->get();

        return response()->json($results);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'recipe_content' => 'required',
        ]);

        $image = null;

        if ($request->file) {
            $fileName = $this->generateRandomString();
            $extension = $request->file->extension();

            $image = $fileName . '.' . $extension;

            Storage::putFileAs('image', $request->file, $image);
        }

        $request['image'] = $image;
        $request['author'] = Auth::user()->id;

        $recipe = Recipe::create($request->all());
        return new RecipeDetailResource($recipe->loadMissing('writer:id,name'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|max:255',
            'recipe_content' => 'required',
        ]);

        $image = null;

        if ($request->file) {
            $fileName = $this->generateRandomString();
            $extension = $request->file->extension();

            $image = $fileName . '.' . $extension;

            Storage::putFileAs('image', $request->file, $image);
        }

        $request['image'] = $image;

        $recipe = Recipe::findOrfail($id);
        $recipe->update($request->all());

        return new RecipeDetailResource($recipe->loadMissing('writer:id,name'));
    }

    public function delete($id)
    {
        $recipe = Recipe::findOrFail($id);
        $recipe->delete();

        return response()->json([
            'message' => 'Data successfully deleted.'
        ]);
    }

    function generateRandomString($length = 20)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
