<?php

namespace App\Utility;

use App\Mail\InvoiceEmailManager;
use App\Models\User;
use App\SmsTemplate;
use App\Http\Controllers\OTPVerificationController;
use Exception;
use Mail;
use Illuminate\Support\Facades\Notification;
use App\Notifications\OrderNotification;

class NotificationUtility
{
    public static function sendOrderPlacedNotification($order, $request = null)
    {        

        //sends Notifications to user
        self::sendNotification($order, 'placed');
        if ($request !==null &&
            $order->user->device_token !== null &&
            (int)get_setting('google_firebase') === 1 ) {
            $request->device_token = $order->user->device_token;
            $request->title = "Order placed !";
            $request->text = "An order {$order->code} has been placed";

            $request->type = "order";
            $request->id = $order->id;
            $request->user_id = $order->user->id;
        }

        //sends email to customer with the invoice pdf attached
        if (env('MAIL_USERNAME') !== null) {
            $array['view'] = 'emails.invoice';
            $array['subject'] = translate('A new order has been placed') . ' - ' . $order->code;
            $array['from'] = env('MAIL_FROM_ADDRESS');
            $array['order'] = $order;
            try {
                Mail::to($order->user->email)->queue(new InvoiceEmailManager($array));
                Mail::to($order->orderDetails->first()->product->user->email)->queue(new InvoiceEmailManager($array));
            } catch (Exception $e) {

            }
        }
    }

    public static function sendNotification($order, $order_status)
    {        
        if ((int)$order->seller_id === User::where('user_type', 'admin')->first()->id) {
            $users = User::findMany([$order->user->id, $order->seller_id]);
        } else {
            $users = User::findMany([$order->user->id, $order->seller_id,
                User::where('user_type', 'admin')->first()->id]);
        }

        $order_notification = array();
        $order_notification['order_id'] = $order->id;
        $order_notification['order_code'] = $order->code;
        $order_notification['user_id'] = $order->user_id;
        $order_notification['seller_id'] = $order->seller_id;
        $order_notification['status'] = $order_status;

        Notification::send($users, new OrderNotification($order_notification));
    }
}
