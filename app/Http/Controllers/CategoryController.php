<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $categories = Category::all();
        return $categories;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Model Instance
        $category = new Category();

        $category->name = $request->name;
        $category->description = $request->description;
        $category->condition = '1';
        
        $category->save();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //Model Instance
        $category = Category::findOrFail($request->id);

        $category->name = $request->name;
        $category->description = $request->description;
        $category->condition = '1';
        
        $category->save();
    }

    /**
     * Logic recovery of a Category.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function activate(Request $request)
    {
        //
        $category = Category::findOrFail($request->id);
        $category->condition = '1';      
        $category->save();
    }

    /**
     * Logic Deletion of a Category.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function deactivate(Request $request)
    {
        //
        $category = Category::findOrFail($request->id);
        $category->condition = '0';      
        $category->save();
    }
}
