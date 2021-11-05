<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;

use App\Models\Orders;

use App\Helper;

class OrdersController extends Controller
{
    public function addOrder(Request $request) {
        if (request()->isMethod('post')) {
            $validator = Validator::make($request->all(),[
                'origin' => 'required|array|min:2|max:2',
                'destination' => 'required|array|min:2|max:2'
            ]);

            if($validator->fails()) {
                return response()->json(['status' => 'failed', 'message' => $validator->errors()], 400);
            }

            $start_lat = $request->origin[0];
            $start_long = $request->origin[1];
            $end_lat = $request->destination[0];
            $end_long = $request->destination[1];

            //calculate distance
            $distance = Helper::calculateDistance($start_lat, $start_long, $end_lat, $end_long);

            if($distance) {
                $order = Orders::create([
                    'start_latitude' => $start_lat,
                    'start_longitude' => $start_long,
                    'end_latitude' => $end_lat,
                    'end_longitude' => $end_long,
                    'distance' => $distance
                ]);

                $order_id = $order->id;

                $order_details = Orders::find($order_id);

                $order_status = $order_details->status;

                return response()->json([
                    'id' => $order_id,
                    'distance' => $distance,
                    'status' => $order_status
                ], 201);
            }
            else {
                return response()->json([
                    'error' => 'An Error Occured in calculating distance'
                ], 400);
            }
        }

        if (request()->isMethod('get')) {
            $orders = $this->getAllOrders($request);

            return $orders;
        }
    }

    public function takeOrder(Request $request, $id) {
        if(Orders::where('id', $id)->exists()) {
            $validator = Validator::make($request->all(),[
                'status' => 'required|string',
            ]);
    
            if($validator->fails()) {
                return response()->json(['status' => 'failed', 'message' => $validator->errors()], 400);
            }

            $order = Orders::find($id);

            if($order->status == "UNASSIGNED") {
                $order->status = "TAKEN";

                $order->save();

                return response()->json([
                    'status' => "SUCCESS"
                ], 200);
            }
            return response()->json([
                'error' => "ORDER TAKEN. YOU CANNOT PLACE THE ORDER ANYMORE"
            ], 401);
        }
        return response()->json([
            'status' => 'failed',
            'message' => 'Order Not Found'
        ], 404);
    }

    public function getAllOrders(Request $request) {

        $page = $request->has('page') ? $request->get('page') : 1;
        $limit = $request->has('limit') ? $request->get('limit') : 10;

        $orders = Orders::limit($limit)->offset(($page - 1) * $limit)->get(['id','distance','status']);

        return $orders;

        return response()->json([
            $orders
        ],200);
    }
}
