<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Responses\ApiJsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

// TODO: implement notification channels for user
final class NotificationChannelController extends Controller
{
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'channels'                               => ['required', 'array', 'in_array_keys:email_notifications,sms_alerts,push_messages'],
            'channels.email_notifications'           => ['nullable', 'array'],
            'channels.email_notifications.address'   => ['required_with:channels.email_notifications', 'email'],
            'channels.email_notifications.frequency' => ['required_with:channels.email_notifications', 'in:immediate,daily,weekly'],
            'channels.sms_alerts'                    => ['nullable', 'array'],
            'channels.sms_alerts.phone'              => ['required_with:channels.sms_alerts', 'regex:/^\+[1-9]\d{1,14}$/'],
            'channels.sms_alerts.carrier'            => ['required_with:channels.sms_alerts', 'string'],
            'channels.push_messages'                 => ['nullable', 'array'],
            'channels.push_messages.device_token'    => ['required_with:channels.push_messages', 'string', 'min:64'],
        ]);

        if ($validator->fails())
        {
            return ApiJsonResponse::error(422, ['errors' => $validator->errors()]);
        }

        $user     = $request->user();
        $channels = $request->input('channels');

        foreach ($channels as $channelType => $config)
        {
            $this->configureNotificationChannel($user, $channelType, $config);
        }

        return ApiJsonResponse::success(message: 'Notification channels updated successfully');
    }

    private function configureNotificationChannel($user, $type, $config): void
    {
        $user->notificationChannels()->updateOrCreate(
            ['channel_type' => $type],
            ['configuration' => $config, 'is_active' => true]
        );
    }
}
