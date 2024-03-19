<?php

namespace App\Bootstrap;

class Security
{
    /**
     * Check if the request is considered spam.
     *
     * @return bool True if the request is spam, false otherwise.
     */
    public static function isSpam()
    {

        $clientIp = $_SERVER['REMOTE_ADDR'];

        // Check if a session variable exists indicating recent activity
        if (isset($_SESSION['last_request_time'])) {
            $lastRequestTime = $_SESSION['last_request_time'];
            $currentTime = time();

            // Calculate the time difference
            $timeDifference = $currentTime - $lastRequestTime;

            // If the time difference is within the threshold, increment the request count
            if ($timeDifference <= TIMETHRESHOLD || (isset($_SESSION['blocked_ips']) &&
                key_exists($clientIp, $_SESSION['blocked_ips']))) {
                $_SESSION['request_count'] = isset($_SESSION['request_count']) ? $_SESSION['request_count'] + 1 : 1;

                // If the request count exceeds the threshold, consider it spam
                if ($_SESSION['request_count'] > REQUESTTHRESHOLD) {
                    // Log the attempt or take appropriate action (e.g., block the IP)

                    // Store the blocked IP in the session
                    $_SESSION['blocked_ips'][$clientIp] = $currentTime;


                    // Log the IP address and timestamp in your database or file
                    $meesgae = "Spam attempt from IP: $clientIp at " . date('Y-m-d H:i:s', $currentTime);

                    // For demonstration purposes, just returning true here
                    return (object) [
                        "message" => $meesgae
                    ];
                }
            } else {
                // Reset the session variables
                $_SESSION['request_count'] = 1;
                $_SESSION['last_request_time'] = $currentTime;
                if (isset($_SESSION['blocked_ips']) && key_exists($clientIp, $_SESSION['blocked_ips'])) :
                    unset($_SESSION['blocked_ips'][$clientIp]);
                endif;
            }
        } else {
            // Initialize session variables
            $_SESSION['request_count'] = 1;
            $_SESSION['last_request_time'] = time();
            if (isset($_SESSION['blocked_ips']) && key_exists($clientIp, $_SESSION['blocked_ips'])) :
                unset($_SESSION['blocked_ips'][$clientIp]);
            endif;
        }


        return false; // Not spam
    }

    /**
     * Unblock old IP attempts.
     *
     * This method is responsible for unblocking IPs after a certain period.
     */
    public static function unblockOldAttempts()
    {
        // Define the time limit for blocking (30 minutes)
        $blockTimeLimit = BLOCKTIMELIMIT; // in seconds

        // Check and unblock IPs that have been blocked for more than the time limit
        if (isset($_SESSION['blocked_ips'])) {
            $currentTime = time();
            foreach ($_SESSION['blocked_ips'] as $ip => $timestamp) {
                if ($currentTime - $timestamp >= $blockTimeLimit) {
                    // Remove the entry from the blocked IPs list
                    unset($_SESSION['blocked_ips'][$ip]);
                }
            }
        }
    }
}
