<?php

use Illuminate\Support\Facades\Log;

function logInfo($content, $title = "No Title")
{
    Log::info("<<<<<<<<<<<<<");
    Log::info($title);
    Log::info(">>>>>>>>>>>>>>>>>>>>>>");
    Log::info($content);
}