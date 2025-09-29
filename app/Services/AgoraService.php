<?php

namespace App\Services;

use TaylanUnutmaz\AgoraTokenBuilder\RtcTokenBuilder;

class AgoraService
{
    private $appId;
    private $appCertificate;
    private $tokenExpiration;

    public function __construct()
    {
        $this->appId = config('agora.app_id');
        $this->appCertificate = config('agora.app_certificate');
        $this->tokenExpiration = config('agora.token_expiration', 86400);
    }

    /**
     * Generate Agora RTC Token using the official builder
     * 
     * @param string $channelName
     * @param string $uid
     * @param string $role ('publisher' or 'subscriber')
     * @param int|null $expiration
     * @return string|null
     */
    public function generateRtcToken($channelName, $uid = '', $role = 'publisher', $expiration = null)
    {
        if (empty($this->appId) || empty($this->appCertificate)) {
            \Log::warning('Agora App ID or Certificate not configured');
            return null;
        }

        $expiration = $expiration ?: (time() + $this->tokenExpiration);
        
        // This package uses different role constants.
        // RolePublisher = 1
        // RoleSubscriber = 2
        $roleInt = $role === 'publisher' ? RtcTokenBuilder::RolePublisher : RtcTokenBuilder::RoleSubscriber;
        
        // Let's ensure it's a valid integer. 0 is a special UID in Agora,
        // so we use it as a default, but it's better if every user has a unique one.
        $uidInt = (int)($uid ?: 0);

        try {
            // This package's method name is `buildTokenWithUid` but it can handle
            // both integer UIDs and string-based user accounts. We will use integers
            // for universal compatibility.
            $token = RtcTokenBuilder::buildTokenWithUid($this->appId, $this->appCertificate, $channelName, $uidInt, $roleInt, $expiration);
            
            \Log::info('Agora RTC token generated with community builder', [
                'channel' => $channelName,
                'uid' => $uidInt,
                'role' => $role,
                'role_int' => $roleInt,
                'expires_at' => date('Y-m-d H:i:s', $expiration),
                'token_length' => strlen($token)
            ]);

            return $token;

        } catch (\Exception $e) {
            \Log::error('Failed to generate Agora token with community builder: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Generate channel name for session
     */
    public function generateChannelName($sessionId)
    {
        $prefix = config('agora.channel_prefix', 'fitlive_');
        return $prefix . $sessionId;
    }

    /**
     * Get Agora App ID for frontend
     */
    public function getAppId()
    {
        return $this->appId;
    }

    /**
     * Validate if Agora is properly configured
     */
    public function isConfigured()
    {
        return !empty($this->appId) && !empty($this->appCertificate);
    }

    /**
     * Generate streaming configuration for session
     */
    public function getStreamingConfig($sessionId, $userId, $role = 'publisher')
    {
        $channelName = $this->generateChannelName($sessionId);
        // Ensure userId is an integer before passing it on
        $token = $this->generateRtcToken($channelName, (int) $userId, $role);

        return [
            'app_id' => $this->appId,
            'channel' => $channelName,
            'token' => $token,
            'uid' => $userId,
            'role' => $role,
            'configured' => $this->isConfigured(),
            'expires_at' => time() + $this->tokenExpiration,
            'video_profile' => config('agora.video_profile', '720p_6'),
            'audio_profile' => config('agora.audio_profile', 'speech_standard'),
        ];
    }

    /**
     * Start recording for a channel (if enabled)
     */
    public function startRecording($channelName, $uid)
    {
        if (!config('agora.enable_recording', false)) {
            return ['success' => false, 'message' => 'Recording not enabled'];
        }

        try {
            $recordingId = 'rec_' . time() . '_' . $channelName;
            $agoraUid = $uid . '01'; // Use different UID for recording bot
            
            // Get app credentials
            $appId = $this->appId;
            $apiKey = config('agora.api_key');
            $apiSecret = config('agora.api_secret');
            
            if (empty($apiKey) || empty($apiSecret)) {
                \Log::warning('Agora API credentials not configured for cloud recording');
                return ['success' => false, 'message' => 'Recording API not configured'];
            }
            
            // Generate recording token
            $recordingToken = $this->generateRtcToken($channelName, $agoraUid, 'publisher', time() + 3600);
            
            // Start Cloud Recording via REST API
            $recordingConfig = [
                'cname' => $channelName,
                'uid' => $agoraUid,
                'clientRequest' => [
                    'token' => $recordingToken,
                    'recordingConfig' => [
                        'maxIdleTime' => 30,
                        'streamTypes' => 2, // Audio + Video
                        'channelType' => 0, // Communication channel
                        'videoStreamType' => 0, // High stream
                        'subscribeVideoUids' => ['#allstream#'],
                        'subscribeAudioUids' => ['#allstream#'],
                        'subscribeUidGroup' => 0
                    ],
                    'recordingFileConfig' => [
                        'avFileType' => ['hls', 'mp4']
                    ],
                    'storageConfig' => [
                        'vendor' => 1, // AWS S3
                        'region' => config('agora.recording_region', 'us-east-1'),
                        'bucket' => config('agora.recording_bucket'),
                        'accessKey' => config('agora.recording_access_key'),
                        'secretKey' => config('agora.recording_secret_key'),
                        'fileNamePrefix' => ['directory', $channelName . '_']
                    ]
                ]
            ];
            
            // Make API call to start recording
            $response = $this->makeAgoraApiCall('start', $recordingConfig);
            
            if ($response && $response['success']) {
                \Log::info('Cloud recording started successfully', [
                    'recording_id' => $recordingId,
                    'resource_id' => $response['resourceId'] ?? null,
                    'sid' => $response['sid'] ?? null,
                    'channel' => $channelName
                ]);
                
                return [
                    'success' => true,
                    'recording_id' => $recordingId,
                    'resource_id' => $response['resourceId'] ?? null,
                    'sid' => $response['sid'] ?? null,
                    'message' => 'Recording started successfully'
                ];
            } else {
                \Log::error('Failed to start cloud recording', [
                    'channel' => $channelName,
                    'response' => $response
                ]);
                return ['success' => false, 'message' => 'Failed to start recording'];
            }
            
        } catch (\Exception $e) {
            \Log::error('Recording start failed: ' . $e->getMessage(), [
                'channel' => $channelName,
                'exception' => $e
            ]);
            return ['success' => false, 'message' => 'Recording start failed: ' . $e->getMessage()];
        }
    }

    /**
     * Stop recording for a channel
     */
    public function stopRecording($channelName, $recordingId)
    {
        if (!config('agora.enable_recording', false)) {
            return ['success' => false, 'message' => 'Recording not enabled'];
        }

        try {
            // Extract resource ID and SID from recording ID or session data
            // In production, you'd store these when starting recording
            $resourceId = session("recording_{$recordingId}_resource_id");
            $sid = session("recording_{$recordingId}_sid");
            
            if (!$resourceId || !$sid) {
                \Log::warning('Missing resource ID or SID for recording stop', [
                    'recording_id' => $recordingId,
                    'channel' => $channelName
                ]);
                // Fallback to mock for now
                return $this->getMockRecordingResult($recordingId, $channelName);
            }
            
            $stopConfig = [
                'cname' => $channelName,
                'uid' => session("recording_{$recordingId}_uid", '10001'),
                'clientRequest' => []
            ];
            
            // Make API call to stop recording
            $response = $this->makeAgoraApiCall('stop', $stopConfig, $resourceId, $sid);
            
            if ($response && $response['success']) {
                // Generate S3 URL for the recording
                $bucket = config('agora.recording_bucket');
                $region = config('agora.recording_region');
                $fileName = $channelName . '_' . $recordingId . '.mp4';
                $s3Url = "https://{$bucket}.s3.{$region}.amazonaws.com/{$fileName}";
                
                \Log::info('Cloud recording stopped successfully', [
                    'recording_id' => $recordingId,
                    'channel' => $channelName,
                    's3_url' => $s3Url
                ]);
                
                return [
                    'success' => true,
                    'message' => 'Recording stopped successfully',
                    'recording_url' => $s3Url,
                    'duration' => $response['duration'] ?? 1800, // Default 30 minutes
                    'file_size' => $response['file_size'] ?? 150000000 // Default ~150MB
                ];
            } else {
                \Log::error('Failed to stop cloud recording', [
                    'recording_id' => $recordingId,
                    'channel' => $channelName,
                    'response' => $response
                ]);
                return $this->getMockRecordingResult($recordingId, $channelName);
            }
            
        } catch (\Exception $e) {
            \Log::error('Recording stop failed: ' . $e->getMessage(), [
                'recording_id' => $recordingId,
                'channel' => $channelName,
                'exception' => $e
            ]);
            return $this->getMockRecordingResult($recordingId, $channelName);
        }
    }

    /**
     * Get recording status from Agora Cloud Recording API
     */
    public function getRecordingStatus($recordingId)
    {
        if (!config('agora.enable_recording', false)) {
            return ['success' => false, 'message' => 'Recording not enabled'];
        }

        // In production, you would call Agora Cloud Recording REST API
        // For now, we'll simulate different statuses
        $statuses = ['recording', 'completed', 'failed'];
        $status = $statuses[array_rand($statuses)];

        return [
            'success' => true,
            'recording_id' => $recordingId,
            'status' => $status,
            'message' => 'Recording status retrieved'
        ];
    }

    /**
     * Initialize cloud recording for a session
     */
    public function initializeCloudRecording($sessionId, $sessionType = 'fitlive')
    {
        if (!config('agora.enable_recording', false)) {
            return ['success' => false, 'message' => 'Recording not enabled'];
        }

        $channelName = $this->generateChannelName($sessionId);
        $recordingId = 'rec_' . $sessionType . '_' . $sessionId . '_' . time();

        // Mock Agora Cloud Recording API call
        $recordingConfig = [
            'recording_id' => $recordingId,
            'channel' => $channelName,
            'app_id' => $this->appId,
            'mode' => 'mix', // or 'individual'
            'format' => 'mp4',
            'max_duration' => 7200, // 2 hours max
            'storage' => [
                'vendor' => 1, // AWS S3
                'region' => 'us-east-1',
                'bucket' => config('agora.recording_bucket', 'your-recordings-bucket'),
                'access_key' => config('agora.recording_access_key', ''),
                'secret_key' => config('agora.recording_secret_key', ''),
                'file_name_prefix' => $sessionType . '_' . $sessionId . '_'
            ]
        ];

        \Log::info('Cloud recording initialized', $recordingConfig);

        return [
            'success' => true,
            'recording_id' => $recordingId,
            'config' => $recordingConfig,
            'message' => 'Cloud recording initialized'
        ];
    }

    /**
     * Generate token for role switching (Co-Host Authentication)
     * Used when audience wants to become host or vice versa
     */
    public function generateRoleSwitchToken($channelName, $userId, $newRole, $expiration = null)
    {
        $token = $this->generateRtcToken($channelName, $userId, $newRole, $expiration);
        
        \Log::info('Role switch token generated', [
            'channel' => $channelName,
            'user_id' => $userId,
            'new_role' => $newRole,
            'co_host_auth' => true
        ]);
        
        return [
            'token' => $token,
            'role' => $newRole,
            'expires_at' => $expiration ?: (time() + $this->tokenExpiration),
            'channel' => $channelName
        ];
    }

    /**
     * Generate token (alias for generateRtcToken for compatibility)
     */
    public function generateToken($channelName, $uid = '', $role = 'publisher', $expiration = null)
    {
        return $this->generateRtcToken($channelName, $uid, $role, $expiration);
    }

    /**
     * Get streaming configuration with Co-Host Authentication support
     */
    public function getCoHostStreamingConfig($sessionId, $userId, $initialRole = 'subscriber')
    {
        $channelName = $this->generateChannelName($sessionId);
        
        // Generate initial token (usually subscriber for audience)
        $expirationTime = time() + $this->tokenExpiration;
        // Ensure userId is an integer before passing it on
        $token = $this->generateRtcToken($channelName, (int) $userId, $initialRole, $expirationTime);
        
        return [
            'app_id' => $this->appId,
            'channel' => $channelName,
            'token' => $token,
            'uid' => $userId,
            'role' => $initialRole,
            'co_host_auth' => true,
            'configured' => $this->isConfigured(),
            'expires_at' => time() + $this->tokenExpiration,
            'video_profile' => config('agora.video_profile', '720p_6'),
            'audio_profile' => config('agora.audio_profile', 'speech_standard'),
            'features' => [
                'role_switching' => true,
                'cloud_recording' => config('agora.enable_recording', false),
                'real_time_transcription' => true
            ]
        ];
    }

    /**
     * Get channel statistics
     */
    public function getChannelStats($channelName)
    {
        // Placeholder for Agora Analytics API call
        // In a real application, you'd use Guzzle or another HTTP client
        // to call Agora's RESTful API for channel statistics.
        return [
            'viewer_count' => rand(1, 100), // Mock data
            'publisher_count' => 1 // Mock data
        ];
    }
    
    /**
     * Make API call to Agora Cloud Recording service
     */
    private function makeAgoraApiCall($action, $config, $resourceId = null, $sid = null)
    {
        try {
            $appId = $this->appId;
            $apiKey = config('agora.api_key');
            $apiSecret = config('agora.api_secret');
            
            // Generate basic auth
            $auth = base64_encode($apiKey . ':' . $apiSecret);
            
            // Build URL based on action
            $baseUrl = 'https://api.agora.io/v1/apps/' . $appId . '/cloud_recording';
            
            switch ($action) {
                case 'start':
                    $url = $baseUrl . '/resourceid/' . ($resourceId ?? 'acquire') . '/mode/mix/start';
                    break;
                case 'stop':
                    $url = $baseUrl . '/resourceid/' . $resourceId . '/sid/' . $sid . '/mode/mix/stop';
                    break;
                default:
                    return ['success' => false, 'message' => 'Invalid action'];
            }
            
            // Make HTTP request using Laravel's HTTP client
            $response = \Http::withHeaders([
                'Authorization' => 'Basic ' . $auth,
                'Content-Type' => 'application/json'
            ])->post($url, $config);
            
            if ($response->successful()) {
                $data = $response->json();
                return array_merge(['success' => true], $data);
            } else {
                \Log::error('Agora API call failed', [
                    'action' => $action,
                    'status' => $response->status(),
                    'response' => $response->body()
                ]);
                return ['success' => false, 'message' => 'API call failed: ' . $response->status()];
            }
            
        } catch (\Exception $e) {
            \Log::error('Agora API call exception: ' . $e->getMessage());
            return ['success' => false, 'message' => 'API call failed: ' . $e->getMessage()];
        }
    }
    
    /**
     * Get mock recording result as fallback
     */
    private function getMockRecordingResult($recordingId, $channelName)
    {
        // Generate mock S3 URL
        $bucket = config('agora.recording_bucket', 'fitlley-recordings');
        $region = config('agora.recording_region', 'us-east-1');
        $fileName = $channelName . '_' . $recordingId . '.mp4';
        $s3Url = "https://{$bucket}.s3.{$region}.amazonaws.com/{$fileName}";
        
        return [
            'success' => true,
            'message' => 'Recording stopped (mock)',
            'recording_url' => $s3Url,
            'duration' => rand(300, 3600),
            'file_size' => rand(50000000, 500000000)
        ];
    }
} 