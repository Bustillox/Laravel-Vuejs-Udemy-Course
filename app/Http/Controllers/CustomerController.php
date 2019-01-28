<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer;

class CustomerController extends Controller
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
            $customers = Customer::orderBy('id', 'desc')->paginate(3);
        }else {
            $customers = Customer::where($criteria,  'like', '%'. $search . '%')->orderBy('id', 'desc')->paginate(3);
        }
        
        return [
            'pagination' => [
                'total' => $customers->total(),
                'current_page' => $customers->currentPage(),
                'per_page' => $customers->perPage(),
                'last_page' => $customers->lastPage(),
                'from' => $customers->firstItem(),
                'to' => $customers->lastItem(),
            ],
            'customers' => $customers
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
        $customer = new Customer();

        $customer->name = $request->name;
        $customer->document_type = $request->document_type;
        $customer->document_number = $request->document_number;
        $customer->address = $request->address;
        $customer->phone = $request->phone;
        $customer->email = $request->email;
        
        $customer->save();
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
        $customer = Customer::findOrFail($request->id);

        $customer->name = $request->name;
        $customer->document_type = $request->document_type;
        $customer->document_number = $request->document_number;
        $customer->address = $request->address;
        $customer->phone = $request->phone;
        $customer->email = $request->email;
        
        $customer->save();
    }
}
