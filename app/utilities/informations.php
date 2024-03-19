<?php

namespace App\Utilities;

trait Informations
{
    protected function getUserAgent(): string
    {
        return strtolower($_SERVER['HTTP_USER_AGENT']);
    }

    protected function detectVisitor(): string
    {
        $userAgent = $this->getUserAgent();

        $visit = 'client';
        if (preg_match('/bot|googlebot|bingbot|slurp|duckduckbot/i', $userAgent)) :
            $visit = "bot";
        endif;

        return $visit;
    }

    protected function detectDevice(): string
    {
        $userAgent = $this->getUserAgent();
        $device = 'desktop';

        if (strpos($userAgent, 'mobile') !== false) :
            $device = 'mobile';
        elseif (strpos($userAgent, 'tablet') !== false || preg_match('/android/i', $userAgent)) :
            $device = 'tablet';
        endif;

        if ($device !== 'desktop') :
            if (preg_match('/ipad/i', $userAgent)) :
                $device = 'tablet';
            endif;
        endif;

        return $device;
    }

    protected function detectOS(): string
    {
        $userAgent = $this->getUserAgent();

        // Using a regular expression to extract the operating system information
        $os = '';

        if (preg_match('/windows/i', $userAgent)) {
            $os = 'windows';

            if (preg_match('/10/i', $userAgent)) {
                $os .= " 10";
            } elseif (preg_match('/6.3/i', $userAgent)) {
                $os .= " 8.1";
            } elseif (preg_match('/6.2/i', $userAgent)) {
                $os .= " 8";
            } elseif (preg_match('/6.1/i', $userAgent)) {
                $os .= " 7";
            } elseif (preg_match('/6.0/i', $userAgent)) {
                $os .= " Vista";
            } elseif (preg_match('/5.1/i', $userAgent)) {
                $os .= " XP";
            }
        } elseif (preg_match('/iphone|ipad|ipod/i', $userAgent)) {
            $os = 'iOS';
        } elseif (preg_match('/macintosh|mac os/i', $userAgent)) {

            $os = 'mac os';

            if (preg_match('/10_15/i', $userAgent)) {
                $os .= " catalina";
            } elseif (preg_match('/10_14/i', $userAgent)) {
                $os .= " mojave";
            } elseif (preg_match('/10_13/i', $userAgent)) {
                $os .= " high sierra";
            } elseif (preg_match('/11_6/i', $userAgent)) {
                $os .= " 11.6.3";
            }
        } elseif (preg_match('/android/i', $userAgent)) {
            $os = 'android';
        } elseif (preg_match('/linux/i', $userAgent)) {
            $os = 'linux';
        } elseif (preg_match('/unix/i', $userAgent)) {
            $os = 'unix';
        } elseif (preg_match('/bsd/i', $userAgent)) {
            $os = 'bsd';
        }

        return $os;
    }

    protected function detectBrowser(): string
    {
        $userAgent = $this->getUserAgent();

        // Using a regular expression to extract the browser information
        $browser = '';

        if (preg_match('/msie/i', $userAgent) || preg_match('/trident/i', $userAgent)) {
            $browser = 'internet explorer';
        } elseif (preg_match('/firefox/i', $userAgent)) {
            $browser = 'firefox';
        } elseif (preg_match('/chrome/i', $userAgent)) {
            $browser = 'chrome';
        } elseif (preg_match('/safari/i', $userAgent)) {
            $browser = 'safari';
        } elseif (preg_match('/opera|opr/i', $userAgent)) {
            $browser = 'opera';
        } elseif (preg_match('/edge/i', $userAgent)) {
            $browser = 'edge';
        }

        return $browser;
    }

    protected function detectLanguage(): string
    {
        $userLanguages = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
        return $userLanguages;
    }
}
