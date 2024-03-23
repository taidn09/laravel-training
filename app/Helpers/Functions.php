<?php
function toJSON($status, $message, $data)
{
    return json_encode([
        'status' => $status,
        'message' => $message,
        'data' => $data
    ]);
}
