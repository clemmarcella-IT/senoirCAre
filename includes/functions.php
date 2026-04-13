<?php
function sendOTP($number, $code) {
    // --- OPTION A: REAL SMS (Semaphore.co - Popular in PH) ---
    /*
    $ch = curl_init();
    $parameters = array(
        'apikey' => 'YOUR_API_KEY_HERE', 
        'number' => $number,
        'message' => "Your SENIOR-CARE Admin Recovery Code is: " . $code . ". Valid for 5 mins.",
        'sendername' => 'SEMAPHORE'
    );
    curl_setopt($ch, CURLOPT_URL, 'https://semaphore.co/api/v4/messages');
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($parameters));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $output = curl_exec($ch);
    curl_close($ch);
    */

    // --- OPTION B: LOG FILE (For Debugging/Development) ---
    // This creates a file named 'otp_log.txt' so you can "read" the SMS there
    $log = "To: $number | Message: Your OTP is $code | Time: " . date("Y-m-d H:i:s") . PHP_EOL;
    file_put_contents(__DIR__ . "/../otp_log.txt", $log, FILE_APPEND);
}
?>