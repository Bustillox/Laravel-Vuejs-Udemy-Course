<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use Illuminate\Support\Facades\DB;
use App\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        
        $search = $request->search;
        $criteria = $request->criteria;

        if ($search=='') {
            $categories = Category::orderBy('id', 'desc')->paginate(3);
        }else {
            $categories = Category::where($criteria,  'like', '%'. $search . '%')->orderBy('id', 'desc')->paginate(3);
        }
        
        return [
            'pagination' => [
                'total' => $categories->total(),
                'current_page' => $categories->currentPage(),
                'per_page' => $categories->perPage(),
                'last_page' => $categories->lastPage(),
                'from' => $categories->firstItem(),
                'to' => $categories->lastItem(),
            ],
            'categories' => $categories
        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!$request->ajax()) return redirect('/');

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
        if(!$request->ajax()) return redirect('/');
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
        if(!$request->ajax()) return redirect('/');
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
        if(!$request->ajax()) return redirect('/');
        $category = Category::findOrFail($request->id);
        $category->condition = '0';      
        $category->save();
    }
}
