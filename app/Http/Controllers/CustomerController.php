<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;

class CustomerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }



    public function createCustomer()
    {
        $data['page_title'] = 'Create New Customer';
        return view('customer.customer-create',$data);
    }

    public function storeCustomer(Request $request)
    {
        //return $request->add_balance;
        $data = $request->validate([
           'name' => 'required',
           'email' => 'nullable|email|unique:customers',
           'phone' => 'required|numeric|unique:customers',
           'phone2' => 'nullable|numeric|unique:customers',
           'address' => 'required',
           'password' => 'required',
           'balance'  => 'required',
        ]);

        //$in = Input::except('_method','_token');

        $data['password'] = Hash::make($data['password']);

        Customer::create($data);

        session()->flash('message','Customer Created Successfully.');
        session()->flash('type','success');
        return redirect()->back();
    }

    

    public function historyCustomer()
    {
        $data['page_title'] = 'Customer History';
        $data['customer'] = Customer::latest()->get();
        return view('customer.customer-history',$data);
    }

    public function editCustomer($id)
    {
        $data['page_title'] = 'Edit Customer';
        $data['customer'] = Customer::findOrFail($id);
        return view('customer.customer-edit',$data);
    }

    public function updateCustomer(Request $request, $id)
    {
        $customer = Customer::findOrFail($id);

        $data = $request->validate([
            'name' => 'required',
            'balance' => 'required',
            'email' => 'nullable|email|unique:customers,email,'.$id,
            'phone' => 'required|numeric|unique:customers,phone,'.$id,
            'phone2' => 'nullable|numeric|unique:customers,phone,'.$id,
            //'address' => 'required'.$id,
            'password' => '',
        ]);

       // $in = Input::except('_method','_token');

       if($request->password ==""){

        $data['password'] = $customer->password;

       }else {

        $data['password'] = Hash::make($request->password);

       }


       if($request->add_balance){
            
            if ($request->add_balance > 0) {
                
                $customer->balance = ($customer->balance) + ($request->add_balance);
                
            }
            
            if ($request->add_balance < 0) {
                
               
                
                if(($customer->balance) - abs($request->add_balance) > 0){

                    $customer->balance = ($customer->balance) - abs($request->add_balance);
                    session()->flash('message','Error.');
                    session()->flash('type','success');
                    return redirect()->back();
                }
                
            }


            $customer->save();

        }

        $customer->fill($data)->save();

        session()->flash('message','Customer Updated Successfully.');
        session()->flash('type','success');
        return redirect()->back();

    }

    public function viewCustomer($id)
    {
        $data['page_title'] = 'Customer Details';
        $data['order'] = Order::whereCustomer_id($id)->latest()->get();
        return view('customer.customer-view',$data);
    }


}
