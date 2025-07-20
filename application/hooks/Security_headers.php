<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Security_headers {
    
    public function add_security_headers() {
        // Add security headers
        header('X-Content-Type-Options: nosniff');
        header('X-Frame-Options: SAMEORIGIN');
        header('X-XSS-Protection: 1; mode=block');
        header('Referrer-Policy: strict-origin-when-cross-origin');
        header('Permissions-Policy: geolocation=(), microphone=(), camera=()');
        
        // Add CSP header for better security
        $csp = "default-src 'self'; ";
        $csp .= "script-src 'self' 'unsafe-inline' https://code.jquery.com https://cdn.jsdelivr.net https://cdnjs.cloudflare.com; ";
        $csp .= "style-src 'self' 'unsafe-inline' https://cdn.jsdelivr.net https://cdnjs.cloudflare.com; ";
        $csp .= "img-src 'self' data: https:; ";
        $csp .= "font-src 'self' https://cdnjs.cloudflare.com; ";
        $csp .= "connect-src 'self'; ";
        $csp .= "frame-src 'none'; ";
        $csp .= "object-src 'none';";
        
        header("Content-Security-Policy: " . $csp);
    }
} 