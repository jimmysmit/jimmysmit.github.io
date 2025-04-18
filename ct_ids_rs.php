<?php

function ctSetCookies($rawData,  $logEnabled)
{
    $log = [];
    if (!empty($rawData)) {
        $data = @json_decode($rawData, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            if ($logEnabled) {
                $log[] = 'Invalid JSON: ' . json_last_error_msg();
            }
        } else {
            foreach ($data as $name => $value) {
                $setCookieResult = setcookie($name, $value, time() + 60 * 60 * 24 * 365 * 5, '/');
                if ($logEnabled) {
                    $log[] = ['name' => $name, 'value' => $value, 'setCookieResult' => $setCookieResult];
                }
            }
        }
    } else {
        if ($logEnabled) {
            $log[] = 'Empty raw data';
        }
    }

    if ($logEnabled) {
        echo '<pre>' . json_encode($log, JSON_PRETTY_PRINT) . '</pre>';
    }
}

ctSetCookies(file_get_contents('php://input'), !empty($_GET['_ct_rs_log']));
