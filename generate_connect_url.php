<?php

require 'vendor/autoload.php';

use Illuminate\Support\Str;

$codeVerifier = Str::random(128);
$codeChallenge = strtr(rtrim(base64_encode(hash('sha256', $codeVerifier, true)), '='), '+/', '-_');

$query = http_build_query([
    'client_id' => '019b7cd3-c242-71b6-be12-2268a2237c4b',
    'redirect_uri' => 'http://localhost:3311/callback',
    'response_type' => 'code',
    'scope' => '',
    'code_challenge' => $codeChallenge,
    'code_challenge_method' => 'S256',
]);

// Note: Using port 3311 to target the Docker environment where the redirect is configured
$url = 'http://localhost:3311/connect/authorize?' . $query;

echo "Verifier: " . $codeVerifier . "\n";
echo "URL: " . $url . "\n";
