<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    //
    public function store(Request $request){
        
        // $validated = $request->validate(
        //     [
        //         'name'=>'required',
        //         'email'=>'required',
        //         'number'=>'required|integer|max:10',
        //         'address'=>'required',
        //     ]
        //     );
        
        $transaction = new Transaction;
        $transaction->order_id = $request->order_id;
        $transaction->name = $request->name;
        $transaction->address = $request->address;
        $transaction->phone_number = $request->number;
        $transaction->payment_type = "cash";
        $transaction->save();

        $order = Order::find($request->order_id);
        $order->order_status = "checkout";
        $order->payment_method = "cash";
        $order->save();
        $items = $order->items;
        foreach($items as $item){
            OrderItem::destroy($item->id);
        }
        return redirect('/user/home');
    }

    public function khaltiPay(Request $request){
        
        $args = array('token' => $request->trans_token, 'amount' => $request->amount);

        $url = "https://khalti.com/api/v2/payment/verify/";

        # Make the call using API.
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $args);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $headers = ['Authorization: Key test_secret_key_15eb057a7a704c0f8c8cfdda6ab51573'];

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($ch);

        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        $res = json_decode($response, true);

        return response()->json(['responsedArray'=>$res]);
    }
    public function destroy($id){
        OrderItem::destroy($id);
        return back();
    }
}
