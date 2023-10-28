<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PathaoController extends Controller
{
    public function pathao_setting(Request $request){
        setSetting('pathao_access_token','null');
        if ($request->pathao_grant_type){ setSetting('pathao_status',$request->pathao_grant_type); }
        if ($request->pathao_status){ setSetting('pathao_status',$request->pathao_status); }
        if ($request->pathao_base_url){ setSetting('pathao_base_url',$request->pathao_base_url); }
        if ($request->pathao_client_id){ setSetting('pathao_client_id',$request->pathao_client_id); }
        if ($request->pathao_client_secret){ setSetting('pathao_client_secret',$request->pathao_client_secret); }
        if ($request->pathao_client_email){ setSetting('pathao_client_email',$request->pathao_client_email); }
        if ($request->pathao_client_password){ setSetting('pathao_client_password',$request->pathao_client_password); }
        if ($request->pathao_sender_name){ setSetting('pathao_sender_name',$request->pathao_sender_name); }
        if ($request->pathao_sender_phone){ setSetting('pathao_sender_phone',$request->pathao_sender_phone); }
        if ($request->pathao_webhook_secret){ setSetting('pathao_webhook_secret',$request->pathao_webhook_secret); }
        issuePathaoToken();
        toastr()->success('Setting Updated');
        return redirect()->back();
    }
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
        curl_setopt($ch, CURLOPT_URL, getSetting('pathao_base_url') . '/aladdin/api/v1/countries/1/city-list');
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
        curl_setopt($ch, CURLOPT_URL, getSetting('pathao_base_url') . '/aladdin/api/v1/cities/'.$id.'/zone-list');
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
        curl_setopt($ch, CURLOPT_URL, getSetting('pathao_base_url') . '/aladdin/api/v1/zones/'.$id.'/area-list');
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
        $url = getSetting('pathao_base_url'). '/aladdin/api/v1/merchant/price-plan';
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
        $baseUrl = getSetting('pathao_base_url');
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
            "sender_name" => getSetting('pathao_sender_name'),
            "sender_phone" => getSetting('pathao_sender_phone'),
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
        $webhookSecret = getSetting('pathao_webhook_secret'); // Replace with your webhook secret
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
    public function steadfast_setting(Request $request){
        if ($request->steadfast_api_key){ setSetting('steadfast_api_key',$request->steadfast_api_key); }
        if ($request->steadfast_secret_key){ setSetting('steadfast_secret_key',$request->steadfast_secret_key); }
        toastr()->success('Setting Updated');
        return redirect()->back();
    }
    public function steadfast(){
        return view('admin.courier.steadfast');
    }
    public function steadfast_delivery_request($id){
        $order = Order::find($id);

        // Check if the order exists
        if (!$order) {
            toastr()->error('Order not found', 'Order Not Found');
            return redirect()->back();
        }

        $apiUrl = 'https://portal.steadfast.com.bd/api/v1/create_order';
        $apiKey = getSetting('steadfast_api_key');
        $secretKey = getSetting('steadfast_secret_key');

        $discount = ($order->discount_percent / 100) * $order->subtotal;
        if ($discount > $order->max_discount) {
            $discount = $order->max_discount;
        }

        $invoice = $order->order_id;
        $recipientName = $order->name;
        $recipientPhone = $order->phone;
        $recipientAddress = $order->address;
        $codAmount = ($order->delivery_charge + $order->subtotal) - ($discount - $order->paid_amount);
        $note = $order->order_note;

        $requestData = [
            'invoice' => $invoice,
            'recipient_name' => $recipientName,
            'recipient_phone' => $recipientPhone,
            'recipient_address' => $recipientAddress,
            'cod_amount' => $codAmount,
            'note' => $note,
        ];

        // Send the request to the Steadfast API using Laravel's HTTP client
        $response = Http::withHeaders([
            'Api-Key' => $apiKey,
            'Secret-Key' => $secretKey,
            'Content-Type' => 'application/json',
        ])->post($apiUrl, $requestData);

        // Handle the API response
        if ($response->successful()) {
            $responseData = $response->json();
            if (isset($responseData['status']) && $responseData['status'] == 200) {
                $trackingCode = $responseData['consignment']['tracking_code'];

                $order->delivery_id = $trackingCode;
                $order->delivery_method = 'steadfast';
                $order->delivery_status = 'delivered';
                $order->update();

                toastr()->success('Order placement success', 'Request Success');
            } else {
                toastr()->error('Order placement failed', 'Request Failed');
            }
        } else {
            toastr()->error('Failed to communicate with the API', 'Communicate Failed');
        }

        return redirect()->back();
    }
}
