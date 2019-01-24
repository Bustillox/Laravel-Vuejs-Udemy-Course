<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Item;

class ItemController extends Controller
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
            $items = Item::join('categories', 'items.id_category', '=', 'categories.id')
            ->select('items.id', 'items.id_category', 'items.code', 'items.name', 'categories.name as category_name', 'items.sale_price', 'items.stock', 'items.description',
             'items.condition')->orderBy('items.id', 'desc')->paginate(3);
        }else {

            $items = Item::join('categories', 'items.id_category', '=', 'categories.id')
            ->select('items.id', 'items.id_category', 'items.code', 'items.name', 'items.sale_price', 'items.stock', 'items.description',
             'items.condition', 'categories.name as category_name')
            ->where('items.'.$criteria,  'like', '%'. $search . '%')
            ->orderBy('items.id', 'desc')->paginate(3);
        }
        
        return [
            'pagination' => [
                'total' => $items->total(),
                'current_page' => $items->currentPage(),
                'per_page' => $items->perPage(),
                'last_page' => $items->lastPage(),
                'from' => $items->firstItem(),
                'to' => $items->lastItem(),
            ],
            'items' => $items
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
        $item = new Item();

        $item->id_category = $request->id_category;
        $item->code = $request->code;
        $item->name = $request->name;
        $item->sale_price = $request->sale_price;
        $item->stock = $request->stock;
        $item->description = $request->description;
        $item->condition = '1';
        
        $item->save();
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
        $item = Item::findOrFail($request->id);

        $item->id_category = $request->id_category;
        $item->code = $request->code;
        $item->name = $request->name;
        $item->sale_price = $request->sale_price;
        $item->stock = $request->stock;
        $item->description = $request->description;
        $item->condition = '1';
        
        $item->save();
    }

    /**
     * Logic recovery of an Item.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function activate(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $item = Item::findOrFail($request->id);
        $item->condition = '1';      
        $item->save();
    }

    /**
     * Logic Deletion of an Item.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function deactivate(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $item = Item::findOrFail($request->id);
        $item->condition = '0';      
        $item->save();
    }

}
