<?php

require __DIR__ . '/autoload.php'; // Adjust the path based on your project structure

use Twilio\Rest\Client;

function sendSmsNotification($to, $message) {
    $accountSid = 'AC177e758f2d7d149984e761bfee04f7a2';
    $authToken = '951f1b4e4e40f2063ddb521192eb2ac6';
    $twilioNumber = '+14157022788';

    // Create a Twilio client
    $twilio = new Client($accountSid, $authToken);

    try {
        // Send SMS message
        $message = $twilio->messages
            ->create($to, [
                'from' => $twilioNumber,
                'body' => $message,
            ]);

        // Output success message
        echo "SMS sent successfully. SID: " . $message->sid;
    } catch (Exception $e) {
        // Handle exceptions
        echo "Error sending SMS: " . $e->getMessage();
    }
}

// Example usage
$phoneNumber = '+254799442397'; 
$notificationMessage = 'Restock alert: Quantity needed for product XYZ.';

sendSmsNotification($phoneNumber, $notificationMessage);
