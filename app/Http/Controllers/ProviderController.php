<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Customer;
use App\Provider;

class ProviderController extends Controller
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
            $customers = Provider::join('customers', 'providers.id', '=', 'customers.id')
            ->select('customers.id', 'customers.name', 'customers.document_type', 'customers.document_number', 'customers.address',
            'customers.phone', 'customers.email', 'providers.contact', 'providers.contact_phone')
            ->orderBy('customers.id', 'desc')->paginate(3);
        }else {
            $customers = Provider::join('customers', 'providers.id', '=', 'customers.id')
            ->select('customers.id', 'customers.name', 'customers.document_type', 'customers.document_number', 'customers.address',
            'customers.phone', 'customers.email', 'providers.contact', 'providers.contact_phone')
            ->where('customers.'.$criteria, 'like', '%'. $search . '%')
            ->orderBy('customers.id', 'desc')->paginate(3);
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


        try {
            DB::beginTransaction();
            //Model Instance
            $customer = new Customer();

            $customer->name = $request->name;
            $customer->document_type = $request->document_type;
            $customer->document_number = $request->document_number;
            $customer->address = $request->address;
            $customer->phone = $request->phone;
            $customer->email = $request->email;
            $customer->save();

            $provider = new Provider();
            $provider->contact = $request->contact;
            $provider->contact_phone = $request->contact_phone;
            $provider->id = $customer->id;
            $provider->save();

            DB::commit();

        } catch (Exception $e) {
            DB::rollBack();
        }

        
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


        try {
            DB::beginTransaction();
            //Search the provider who's about to get modified
            $provider = Provider::findOrFail($request->id);
            $customer = Customer::findOrFail($provider->id);

            $customer->name = $request->name;
            $customer->document_type = $request->document_type;
            $customer->document_number = $request->document_number;
            $customer->address = $request->address;
            $customer->phone = $request->phone;
            $customer->email = $request->email;
            $customer->save();

            $provider->contact = $request->contact;
            $provider->contact_phone = $request->contact_phone;
            $provider->save();

            DB::commit();

        } catch (Exception $e) {
            DB::rollBack();
        }
    }
}
