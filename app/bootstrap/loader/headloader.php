<?php

namespace App\Bootstrap\Loader;

trait HEADLoader
{

    public static function meta($obj, $device, $metaTags)
    {
        $head = [
            "meta" => [
                [
                    "name" => "apple-mobile-web-app-status-bar-style",
                    "content" => "black"
                ],
                [
                    "name" => "msapplication-TileImage",
                    "content" => "/public/assets/placeholder.webp"
                ],
                [
                    "name" => "msapplication-TileColor",
                    "content" => "#2b5797"
                ],
                [
                    "name" => "theme-color",
                    "content" => "#ffffff"
                ],
                [
                    "charset" => "UTF-8"
                ],
                [
                    "http-equiv" => "Content-Type",
                    "content" => "text/html; charset=utf-8"
                ],
                [
                    "name" => "viewport",
                    "content" => "width=device-width, initial-scale=1.0"
                ],
                [
                    "name" => "robots",
                    "content" => "index, home"
                ],
                [
                    "name" => "description",
                    "content" => $metaTags->description
                ],
                [
                    "name" => "keywords",
                    "content" => $metaTags->keywords
                ],
                [
                    "name" => "author",
                    "content" => $metaTags->author_name
                ],
                [
                    "name" => "msapplication-TileImage",
                    "content" => $metaTags->domain_source . $metaTags->thumbnail
                ],
                [
                    "name" => "twitter:description",
                    "content" => $metaTags->description
                ],
                [
                    "name" => "twitter:image",
                    "content" => $metaTags->domain_source . $metaTags->thumbnail
                ],
                [
                    "name" => "twitter:title",
                    "content" => $metaTags->title
                ],
                [
                    "name" => "twitter:card",
                    "content" => $metaTags->description
                ],
                [
                    "property" => "og:title",
                    "content" => $metaTags->title
                ],
                [
                    "property" => "og:description",
                    "content" => $metaTags->description
                ],
                [
                    "property" => "og:site_name",
                    "content" => $metaTags->project_name
                ],
                [
                    "property" => "og:type",
                    "content" => $metaTags->domain_source
                ],
                [
                    "property" => "og:image",
                    "content" => $metaTags->domain_source . $metaTags->thumbnail
                ],
                [
                    "property" => "og:image:type",
                    "content" => "image/jpeg"
                ],
                [
                    "property" => "og:image:width",
                    "content" => "300"
                ],
                [
                    "property" => "og:image:height",
                    "content" => "300"
                ],
                [
                    "property" => "og:url",
                    "content" => $metaTags->domain_source
                ],
                [
                    "name" => "application-name",
                    "content" => $metaTags->project_name
                ],
                [
                    "name" => "language",
                    "content" => "en-US"
                ],
                [
                    "name" => "copyright",
                    "content" => $metaTags->project_name
                ],
                [
                    "name" => "revised",
                    "content" => 'TODO: date("Y-m-d", strtotime($metaTags->last_modified))'
                ],
                [
                    "name" => "distribution",
                    "content" => "global"
                ],
                [
                    "name" => "classification",
                    "content" => "Business"
                ]
            ],
            "link" => [
                [
                    "rel" => "icon",
                    "href" => $metaTags->domain_source . $metaTags->thumbnail
                ],
                [
                    "rel" => "alternate",
                    "type" => "application/rss+xml",
                    "title" => "RSS Feed",
                    "href" => "URL to your RSS feed"
                ],
                [
                    "rel" => "shortcut-icon",
                    "href" => "/public/assets/placeholder.webp"
                ],
                [
                    "rel" => "canonical",
                    "href" => DOMAIN_SOURCE
                ],
                [
                    "name" => "msapplication-TileColor",
                    "content" => "#ffffff"
                ],
                [
                    "name" => "msapplication-TileImage",
                    "content" => "/public/assets/placeholder.webp"
                ],
                [
                    "name" => "theme-color",
                    "content" => "#ffffff"
                ],
                [
                    "name" => "apple-mobile-web-app-capable",
                    "content" => "yes"
                ]
            ]
        ];

        $html = '';

        foreach ($head as $element => $attributes) {
            foreach ($attributes as $i => $y) {
                $html .= "<{$element} ";
                foreach ($y as $attribute => $value) {
                    $html .= "{$attribute}='{$value}' ";
                }
                $html .= " />";
            }
        }

        return $html;
    }

    /**
     * Handle Styles
     *
     * This static method processes styles based on the provided data, device, and theme.
     *
     * @param object  $data   The data object.
     * @param string $device The device information.
     * @param string $theme  The theme being used.
     *
     * @return string
     */
    public static function styles(object $data, string $device): string
    {

        $data->styles[] = '/public/static/css/main.css';

        $loaded = '';

        foreach (array_reverse($data->styles) as $key => $style) :
            if (is_array($style)) :
                $loaded .= "<link nonce='" . NONCE . "'";
                foreach ($style as $att => $value) :
                    $loaded .= " $att='{$value}' ";
                endforeach;
                $loaded .= ">";
            else :
                $loaded .= "<link nonce='" . NONCE . "' href='{$style}' rel='stylesheet'>";
            endif;
        endforeach;

        return $loaded;
    }

    /**
     * Handle Scripts
     *
     * This static method processes scripts based on the provided data, device, and theme.
     *
     * @param object  $data   The data object.
     * @param string $device The device information.
     * @param string $theme  The theme being used.
     *
     * @return string
     */
    public static function scripts(object $data, string $device): string
    {
        $scripts = '';

        if (isset($data->tscripts)) :
            foreach (array_reverse($data->tscripts) as $key => $script) :

                if (is_array($script)) :
                    $scripts .= "<script nonce='" . NONCE . "'";
                    foreach ($script as $att => $value) :
                        $scripts .= " $att='{$value}' ";
                    endforeach;
                    $scripts .= "></script>";
                else :
                    $scripts .= "<script nonce='" . NONCE . "' src='{$script}'></script>";
                endif;

            endforeach;
        endif;

        return $scripts;
    }


    /**
     * Handle End of Body Content
     *
     * This static method processes content to be placed at the end of the HTML body
     * based on the provided data, device, and theme.
     *
     * @param object  $data   The data object.
     * @param string $device The device information.
     * @param string $theme  The theme being used.
     *
     * @return string
     */
    public static function endbody(object $data, string $device): string
    {

        $data->bscripts[] = [
            'src' => "/public/static/js/main.js",
            'type' => 'module'
        ];

        $scripts = "";

        foreach (array_reverse($data->bscripts) as $key => $script) :

            if (is_array($script)) :
                $scripts .= "<script nonce='" . NONCE . "'";
                foreach ($script as $att => $value) :
                    $scripts .= " $att='{$value}' ";
                endforeach;
                $scripts .= "></script>";
            else :
                $scripts .= "<script nonce='" . NONCE . "' src='{$script}'></script>";
            endif;

        endforeach;

        return $scripts;
    }
}
