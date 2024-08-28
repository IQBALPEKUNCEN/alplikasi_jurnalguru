<?php

// mapping object if not found url triggered
Flight::map('notFound', function () {
    return Flight::json(["message" => "Could not find what you were looking for."], 404);
});

// enable log
Flight::set('flight.log_errors', true);

// log function
Flight::map('log', function ($message) {
    // Tentukan lokasi file log
    $logFile = 'app/storage/logs/log ' . date('Y-m-d') . '.log';
    
    // print_r(scandir('app/storage/logs'));
    // die;

    // Tambahkan timestamp ke pesan
    $message = date('Y-m-d H:i:s') . ' - ' . $message;

    // Tulis pesan ke file log
    file_put_contents($logFile, $message . "\n", FILE_APPEND);
});

Flight::map('convertMessages', function ($messages) {
    $convertedMessages = [];

    foreach ($messages as $field => $errors) {
        $errorMessage = '';
        $errorCount = count($errors);

        foreach ($errors as $index => $error) {
            // Menghilangkan titik di akhir pesan
            $error = rtrim($error, '.');

            // Menambahkan pesan ke dalam format yang diinginkan
            if ($index === 0) {
                $errorMessage .= $error;
            } elseif ($index === $errorCount - 1) {
                $errorMessage .= ($errorCount === 2 ? ' and ' : ', and ') . $error;
            } else {
                $errorMessage .= ', ' . $error;
            }
        }

        // Menyimpan pesan dalam array konversi
        $convertedMessages[$field] = $errorMessage;
    }

    return $convertedMessages;
});

// Log request
Flight::before('start', function () {
    $request = Flight::request();
    $log = "Request method: {$request->method}\n";
    $log .= "Request URL: {$request->url}\n";
    $log .= "Request headers: " . print_r($request->getHeaders(), true) . "\n";
    if (!empty($request->data)) {
        $log .= "Request data: " . print_r($request->data->getData(), true) . "\n";
    } else {
        $log .= "Request data: null\n";
    }
    Flight::log($log);
});

// Log response
Flight::after('start', function () {
    $response = Flight::response();
    $log = "Response status: {$response->status()}\n";
    $log .= "Response headers: " . print_r($response->getHeaders(), true) . "\n";
    if (!empty($response->getBody())) {
        $log .= "Response body: {$response->getBody()}\n";
    } else {
        $log .= "Response body: null\n";
    }
    Flight::log($log);
});
