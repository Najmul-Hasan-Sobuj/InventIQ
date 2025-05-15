<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Gemini API Key
    |--------------------------------------------------------------------------
    |
    | This is your Gemini API key. You can get it from the Google Cloud Console.
    |
    */
    'api_key' => env('GEMINI_API_KEY'),

    /*
    |--------------------------------------------------------------------------
    | Default Model
    |--------------------------------------------------------------------------
    |
    | This is the default model to use when generating text.
    |
    */
    'default_model' => 'gemini-1.0-pro',

    /*
    |--------------------------------------------------------------------------
    | Default Parameters
    |--------------------------------------------------------------------------
    |
    | These are the default parameters to use when generating text.
    |
    */
    'default_parameters' => [
        'temperature' => 0.7,
        'top_p' => 0.8,
        'top_k' => 40,
        'max_output_tokens' => 2048,
    ],
]; 