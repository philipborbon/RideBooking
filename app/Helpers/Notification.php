<?php

namespace RideBooking\Helpers;

use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use FCM;

use RideBooking\User;

class Notification
{
    const ACTION_BOOKING = "OPEN_ACTIVITY_BOOKING";
    const ACTION_TOPUP = "OPEN_ACTIVITY_TOPUP";
    const ACTION_PAID_BOOKING = "OPEN_ACTIVITY_PAID_BOOKING";
    const ACTION_REDEEM = "OPEN_ACTIVITY_REDEEM";

    var $title = NULL;
    var $message = NULL;
    var $clickAction = NULL;

    var $pushToken = NULL;

    // @param $data - instance of Notification
    public static function sendPushNotification($data, $counter = 0){
        // prevent infinite loop for fail retry after 3 tries
        if ($counter == 3) {
            return;
        } else {
            $counter++;
        }

        $optionBuilder = new OptionsBuilder();
        $optionBuilder->setTimeToLive(60*20);

        $notificationBuilder = new PayloadNotificationBuilder($data->title);
        $notificationBuilder->setBody($data->message)
                            ->setClickAction($data->clickAction)
                            ->setSound('default');

        // $dataBuilder = new PayloadDataBuilder();
        // $dataBuilder->addData(['a_data' => 'my_data']);

        $option = $optionBuilder->build();
        $notification = $notificationBuilder->build();
        // $data = $dataBuilder->build();

        $downstreamResponse = FCM::sendTo($data->pushToken, $option, $notification);

        $downstreamResponse->numberSuccess();
        $downstreamResponse->numberFailure();
        $downstreamResponse->numberModification();

        //return Array - you must remove all this tokens in your database
        $toDelete = $downstreamResponse->tokensToDelete();

        foreach ($toDelete as $value) {
            $user = User::where('push_token', $value)->first();
            if ($user) {
                $user->push_token = NULL;
                $user->save();
            }
        }

        //return Array (key : oldToken, value : new token - you must change the token in your database )
        $toModify = $downstreamResponse->tokensToModify();

        foreach ($toModify as $key => $value) {
            $user = User::where('push_token', $key)->first();
            if ($user) {
                $user->push_token = $value;
                $user->save();
            }
        }

        //return Array - you should try to resend the message to the tokens in the array
        $toRetry = $downstreamResponse->tokensToRetry();

        foreach ($toRetry as $value) {
            $data->pushToken = $value;
            self::sendPushNotification($data, $counter);
        }
    }
}