<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class PathaoController extends Controller
{
    public function pathao_list(){
        return  view('admin.courier.pathao_list');
    }
    public function city_lists() {
        $headers = [
            'Authorization: Bearer ' . getSetting('pathao_access_token'),
            'Content-Type: application/json',
            'Accept: application/json',
        ];
        $ch = curl_init();
        // Set cURL options
        curl_setopt($ch, CURLOPT_URL, env('PATHAO_BASE_URL') . '/aladdin/api/v1/countries/1/city-list');
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // Execute the cURL request and get the response
        $response = curl_exec($ch);
        // Check for cURL errors
        if (curl_errno($ch)) {
            // Handle cURL error
            if (!issuePathaoToken()) {
                // Handle token issue failure
                return [];
            }

            // Retry the API call with the new token
            return $this->city_lists();
        }
        // Close cURL session
        curl_close($ch);
        // Decode the JSON response
        $citys = json_decode($response, true);
        $options = ['' => 'Select City']; // Initial default option

        foreach ($citys['data']['data'] as $city) {
            $options[$city['city_id']] = $city['city_name'];
        }

        return $options;
    }
    public function zone_lists($id){
        if (!getSetting('pathao_status')){
            issuePathaoToken();
        }
        $headers = [
            'Authorization: Bearer ' . getSetting('pathao_access_token'),
            'Content-Type: application/json',
            'Accept: application/json',
        ];

        // Initialize cURL session
        $ch = curl_init();

        // Set cURL options
        curl_setopt($ch, CURLOPT_URL, env('PATHAO_BASE_URL') . '/aladdin/api/v1/cities/'.$id.'/zone-list');
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Execute the cURL request and get the response
        $response = curl_exec($ch);

        // Check for cURL errors
        if (curl_errno($ch)) {
            // Handle cURL error
            issuePathaoToken();
            $this->city_lists();
        }

        // Close cURL session
        curl_close($ch);

        // Decode the JSON response
        $citys = json_decode($response, true);
        $options = ['' => 'Select Zone']; // Initial default option


        foreach ($citys['data']['data'] as $city){
            $options[$city['zone_id']] = $city['zone_name'];
        }
        return $options;

    }
    public function area_lists($id){
        if (!getSetting('pathao_status')){
            issuePathaoToken();
        }
        $headers = [
            'Authorization: Bearer ' . getSetting('pathao_access_token'),
            'Content-Type: application/json',
            'Accept: application/json',
        ];

        // Initialize cURL session
        $ch = curl_init();

        // Set cURL options
        curl_setopt($ch, CURLOPT_URL, env('PATHAO_BASE_URL') . '/aladdin/api/v1/zones/'.$id.'/area-list');
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Execute the cURL request and get the response
        $response = curl_exec($ch);

        // Check for cURL errors
        if (curl_errno($ch)) {
            // Handle cURL error
            issuePathaoToken();
            $this->city_lists();
        }

        // Close cURL session
        curl_close($ch);

        // Decode the JSON response
        $citys = json_decode($response, true);
        $options = ['' => 'Select Area']; // Initial default option


        foreach ($citys['data']['data'] as $city){
            $options[$city['area_id']] = $city['area_name'];
        }
        return $options;

    }
    public function price(Request $request){
        $data = [
            'store_id' => $request->store_id,
            'item_type' => $request->item_type,
            'delivery_type' => $request->delivery_type??48,
            'item_weight' => $request->item_weight??0.5,
            'recipient_city' => $request->recipient_city,
            'recipient_zone' => $request->recipient_zone,
        ];
        issuePathaoToken();
        $url = env('PATHAO_BASE_URL'). '/aladdin/api/v1/merchant/price-plan';
        $options = [
            'http' => [
                'method' => 'POST',
                'header' => [
                    'Authorization: Bearer ' . getSetting('pathao_access_token'),
                    'Content-Type: application/json',
                    'Accept: application/json',
                ],
                'content' => json_encode($data),
            ],
        ];
        $context = stream_context_create($options);
        $response = file_get_contents($url, false, $context);

        if ($response === false) {
            toastr()->warning('Please Fix the Pathao Information');
            return redirect()->back();
        }
        $responseData = json_decode($response, true);

        // Return a JSON response with the calculated data
        return response()->json($responseData['data']);

    }

    public function delivery_request(Request $request,$id){
        $request->validate([
            'store_id' => 'required|integer',
            'item_type' => 'required|integer',
            'delivery_type' => 'required|integer',
            'item_weight' => 'required|numeric',
            'city_id' => 'required|integer',
            'zone_id' => 'required|integer',
            'area_id' => 'required|integer',
        ]);
        $baseUrl = env('PATHAO_BASE_URL');
        $accessToken = getSetting('pathao_access_token');
        $requestUrl = $baseUrl . "/aladdin/api/v1/orders";
        $requestHeaders = [
            "Authorization: Bearer $accessToken",
            "Content-Type: application/json",
            "Accept: application/json",
        ];
        $order = Order::find($id);
        $discount  = ($order->discount_percent/100)*$order->subtotal;
        if ($discount>$order->max_discount){
            $discount = $order->max_discount;
        }
        $productQty = 0;
        foreach($order->products as $product){
            $productQty += $product['pivot']['quantity'];
        }

        $requestData = [
            "store_id" => $request->store_id,
            "merchant_order_id" => $order->order_id,
            "sender_name" => env('PATHAO_SENDER_NAME'),
            "sender_phone" => env('PATHAO_SENDER_PHONE'),
            "recipient_name" => $order->name,
            "recipient_phone" => $order->phone,
            "recipient_address" => $order->address,
            "recipient_city" => $request->city_id,
            "recipient_zone" => $request->zone_id,
            "recipient_area" => $request->area_id,
            "delivery_type" => $request->delivery_type,
            "item_type" => $request->item_type,
            "special_instruction" => $order->note,
            "item_quantity" => $productQty,
            "item_weight" => $request->item_weight,
            "amount_to_collect" => ($order->delivery_charge + $order->subtotal) -($discount - $order->paid_amount) ,
            "item_description" => null,
        ];


        $dataString = json_encode($requestData);

        $ch = curl_init($requestUrl);

        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $requestHeaders);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        if (curl_errno($ch)) {
            echo "cURL Error: " . curl_error($ch);
        } else {
            $data = json_decode($response, true);
            if ($data['code'] === 200) {
                $responseData = $data['data'];
                $consignment_id = $responseData['consignment_id'];
                $delivery_fee = $responseData['delivery_fee'];
                $delivery_status = $responseData['order_status'];

                $order->delivery_method = 'pathao';
                $order->delivery_id = $consignment_id;
                $order->delivery_fee = $delivery_fee;
                $order->delivery_status = $delivery_status;
                $order->status = 'delivered';
                $order->update();
                toastr()->success($data['message']);
                // Now you can work with $message and $responseData as needed
            } else {
                toastr()->error('Something went wrong');
            }

        }

        curl_close($ch);
        return redirect()->back();
    }
    public function pathao_status(Request $request){

        // Verify the X-PATHAO-Signature header
        $webhookSecret = '123456789abcdefg'; // Replace with your webhook secret
        $signature = $request->header('X-PATHAO-Signature');
        $payload = $request->getContent();
        if ($signature !== $webhookSecret) {
            return response()->json(['error' => 'Invalid signature'], 401);
        }
        $data = json_decode($payload, true);

        if ($data){
            $allowedStatuses = [
                "Pickup_Requested",
                "Assigned_for_Pickup",
                "Picked",
                "Pickup_Failed",
                "Pickup_Cancelled",
                "At_the_Sorting_HUB",
                "In_Transit",
                "Received_at_Last_Mile_HUB",
                "Assigned_for_Delivery",
                "Delivered",
                "Partial_Delivery",
                "Return",
                "Delivery_Failed",
                "On_Hold",
                "Payment_Invoice",

            ];
            if (in_array($data['order_status'], $allowedStatuses)) {
                // Handle the order status update here
                $order = Order::where('order_id', $data['merchant_order_id'])->first();
                if ($order) {
                    $order->delivery_status = $data['order_status'];
                    if ($data['order_status_slug'] === 'Payment_Invoice'){
                        $order->status = 'completed';
                    }
                    else if ($data['order_status_slug'] === 'Partial_Delivery'){
                        $order->status = 'completed';
                        $order->paid_amount = $order->paid_amount + $data['collected_amount'];

                    }
                    $order->save();
                }

            }
        }

        return response()->json(['message' => 'Webhook received']);

    }
}
