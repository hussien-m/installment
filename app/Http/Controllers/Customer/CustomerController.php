<?php

namespace App\Http\Controllers\Customer;

use App\Customer;
use App\Http\Controllers\Controller;
use App\InstalmentTime;
use App\Messages;
use App\Order;
use App\OrderInstalment;
use App\OrderItem;
use App\Replay;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Validator;

class CustomerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:customer');
    }


    public function getDashboard()
    {
        $data['sell'] = Order::where('customer_id',Auth::user()->id)->latest()->get();
        return view('customer.dashboard',$data);
    }

    public function editProfile()
    {
        $customer = Customer::findOrFail(Auth::user()->id);
        return view('customer.edit-profile', compact('customer'));
    }

    public function updateProfile(Request $request)
    {
        $customer = Customer::findOrFail(Auth::user()->id);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'phone2' => $request->phone2,
            'address' => $request->address,
        ];



        $customer->fill($data)->save();

        session()->flash('message', 'Customer Updated Profile Successfully.');
        session()->flash('type', 'success');
        return redirect()->back();
    }

    public function editPassword()
    {
        $customer = Customer::findOrFail(Auth::user()->id);
        return view('customer.edit-password', compact('customer'));
    }

    public function updatePassword(Request $request)
    {
        $this->validate($request, [
            'current_password' => 'required',
            'password' => 'required|min:5|confirmed'
        ]);
        try {
            $c_password = Auth::guard('customer')->user()->password;
            $c_id = Auth::guard('customer')->user()->id;

            $user = Customer::findOrFail($c_id);

            if (Hash::check($request->current_password, $c_password)) {

                $password = Hash::make($request->password);
                $user->password = $password;
                $user->save();
                session()->flash('message', 'Password Changes Successfully.');
                session()->flash('type', 'success');
                return redirect()->back();
            } else {
                session()->flash('message', 'Current Password Not Match');
                session()->flash('type', 'warning');
                return redirect()->back();
            }
        } catch (\PDOException $e) {
            session()->flash('message', $e->getMessage());
            session()->flash('type', 'warning');
            return redirect()->back();
        }
    }


    public function myOrder()
    {
        $data['page_title'] = 'Sell History';
        $data['sell'] = Order::where('customer_id',Auth::user()->id)->latest()->get();
        return view('customer.orders',$data);
    }

    public function chart()
    {
        $data['page_title'] = 'Sell Chart';
        
        $data['sell'] = Order::where('customer_id',Auth::user()->id)->get();
        return view('customer.chart',$data);
    }

    public function myProduct(Request $request)
    {
        //#SL-220728195827
        /*
        $data['sell'] = Order::whereCustom($invoice)->firstOrFail();
        $data['sellItem'] = OrderItem::whereCustom($invoice)->get();

        if ($data['sell']->payment_type == 2 ){
            $orderInstalment = OrderInstalment::whereOrder_id($data['sell']->id)->first()->id;
            $data['instalmentList'] = InstalmentTime::whereOrder_instalment_id($orderInstalment)->get();
        }
        */


        $invoice = $request->invoice;

        if (isset($request->search)) {

            $data['sell'] = Order::where([['custom', $invoice], ['customer_id', Auth::user()->id]])->first();
            if ($data['sell']) {

                $data['sellItem'] = OrderItem::whereCustom($invoice)->get();

                if ($data['sell']->payment_type == 2) {
                    $orderInstalment = OrderInstalment::whereOrder_id($data['sell']->id)->first()->id;
                    $data['instalmentList'] = InstalmentTime::whereOrder_instalment_id($orderInstalment)->get();
                }

                $data['messages'] = Messages::with('replay')->where('customer_id',Auth::user()->id)->get();

                return view('customer.products', $data);
                
            }else{
                session()->flash('message', 'Wrong invoice number');
                session()->flash('type', 'warning');
                return redirect()->back();
            }
        }

        return view('customer.products');
    }

    public function addCommentToProduct()
    {
        return view('customer.products', compact('orderItem'));
    }

    public function sendMessage(Request $request)
    {
       $data = $this->validate($request, [
            'message' => 'required',
        ]);

        if($data){

            try{
                $create = Messages::create([
                
                    'customer_id' => Auth::user()->id,
                    'message' => $request->message,
                    'product_name' => $request->product_name,
                    'total_amount' => $request->total_amount,
                    'pay_amount' => $request->pay_amount,
                    'due_amount' => $request->due_amount,
                    'status' => 'pending',
                ]);
             
                    session()->flash('message', 'Ok');
                    session()->flash('type', 'success');
                    return redirect()->back();

            } catch(Exception $ex){
                session()->flash('message', 'Cant send more message for this product');
                session()->flash('type', 'warning');
                return redirect()->back();
            }

            


        } else {
            session()->flash('message', 'Error Message Required');
            session()->flash('type', 'warning');
            return redirect()->back();
        }
    }
}
