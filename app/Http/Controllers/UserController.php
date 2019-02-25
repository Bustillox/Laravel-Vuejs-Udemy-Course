<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Customer;

class UserController extends Controller
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
            $customers = User::join('customers', 'users.id', '=', 'customers.id')
            ->join('roles', 'users.id_role', '=', 'roles.id')
            ->select('customers.id', 'customers.name', 'customers.document_type', 'customers.document_number', 'customers.address',
            'customers.phone', 'customers.email', 'users.username', 'users.password', 'users.condition', 'users.id_role', 'roles.name as role')
            ->orderBy('customers.id', 'desc')->paginate(3);
        }else {
            $customers = User::join('customers', 'users.id', '=', 'customers.id')
            ->join('roles', 'users.id_role', '=', 'roles.id')
            ->select('customers.id', 'customers.name', 'customers.document_type', 'customers.document_number', 'customers.address',
            'customers.phone', 'customers.email', 'users.username', 'users.password', 'users.condition', 'users.id_role', 'roles.name as role')
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

            $user = new User();
            $user->username = $request->username;
            $user->password = bycrypt($request->password);
            $user->condition = '1';
            $user->id_role = $request->id_role;

            $user->id = $customer->id;
            $user->save();

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
            //Search the user who's about to get modified
            $user = User::findOrFail($request->id);

            $customer = Customer::findOrFail($user->id);

            $customer->name = $request->name;
            $customer->document_type = $request->document_type;
            $customer->document_number = $request->document_number;
            $customer->address = $request->address;
            $customer->phone = $request->phone;
            $customer->email = $request->email;
            $customer->save();


            $user->username = $request->username;
            $user->password = bycrypt($request->password);
            $user->condition = '1';
            $user->id_role = $request->id_role;
            $user->save();

            DB::commit();

        } catch (Exception $e) {
            DB::rollBack();
        }
    }

    /**
     * Logic recovery of a User.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function activate(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $user = User::findOrFail($request->id);
        $user->condition = '1';      
        $user->save();
    }

    /**
     * Logic Deletion of a User.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function deactivate(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $user = User::findOrFail($request->id);
        $user->condition = '0';      
        $user->save();
    }
}
