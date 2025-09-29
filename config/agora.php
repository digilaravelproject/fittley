<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Agora.io Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for Agora.io video streaming service
    |
    */

    'app_id' => env('AGORA_APP_ID', ''),
    'app_certificate' => env('AGORA_APP_CERTIFICATE', ''),
    'api_key' => env('AGORA_API_KEY', ''),
    'api_secret' => env('AGORA_API_SECRET', ''),
    
    // Token expiration time in seconds (24 hours)
    'token_expiration' => env('AGORA_TOKEN_EXPIRATION', 86400),
    
    // Default channel settings
    'channel_prefix' => env('AGORA_CHANNEL_PREFIX', 'fitlive_'),
    
    // Recording settings
    'enable_recording' => env('AGORA_ENABLE_RECORDING', true),
    'recording_bucket' => env('AGORA_RECORDING_BUCKET', 'fitlley-recordings'),
    'recording_region' => env('AGORA_RECORDING_REGION', 'us-east-1'),
    'recording_access_key' => env('AGORA_RECORDING_ACCESS_KEY', ''),
    'recording_secret_key' => env('AGORA_RECORDING_SECRET_KEY', ''),
    'recording_format' => env('AGORA_RECORDING_FORMAT', 'mp4'),
    'recording_mode' => env('AGORA_RECORDING_MODE', 'mix'), // 'mix' or 'individual'
    
    // CDN settings for streaming
    'rtmp_url' => env('AGORA_RTMP_URL', ''),
    'hls_url' => env('AGORA_HLS_URL', ''),
    
    // Video quality settings
    'video_profile' => env('AGORA_VIDEO_PROFILE', '720p_6'), // 720p at 30fps
    
    // Audio settings
    'audio_profile' => env('AGORA_AUDIO_PROFILE', 'speech_standard'),
    
    // Region settings
    'region' => env('AGORA_REGION', 'GLOBAL'),
]; 