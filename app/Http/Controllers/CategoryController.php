<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\HttpResponse;
use App\Models\Categories;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends Controller
{
    use HttpResponse;
    /**
     * Display a listing of the resource.
     */
    public function index() :JsonResource
    {
        return CategoryResource::collection(Categories::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {
        $validated = $request->validated();
        try{
          $category =   Categories::create($validated);
          return new CategoryResource($category);
        }
        catch (\Exception $e)
        {
            return $this->error('Error Creating Resource', Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try{
            $category = Categories::findOrFail($id);
            return new CategoryResource($category);
        }
        catch(ModelNotFoundException $e)
        {
          return $this->error('Category Not Found', Response::HTTP_NOT_FOUND);
        }
        catch(\Exception $e){
            return $this->error('Error', Response::HTTP_NOT_FOUND);
        }

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, string $id)
    {
        $validated = $request->validated();

        try{
            $category = Categories::findOrFail($id);
            $category->update($validated);
            return $this->success('Category Updated', Response::HTTP_OK);
        }
        catch(ModelNotFoundException $e)
        {
          return $this->error('Category Not Found', Response::HTTP_NOT_FOUND);
        }
        catch(\Exception $e){
            return $this->error('Error', Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try
        {
            $category = Categories::findOrFail($id);
            $category->delete();
            return $this->success('Category Deleted', Response::HTTP_OK);
        }
        catch(ModelNotFoundException $e)
        {
          return $this->error('Category Not Found', Response::HTTP_NOT_FOUND);
        }
        catch(\Exception $e){
            return $this->error('Error', Response::HTTP_NOT_FOUND);
        }
    }
}
