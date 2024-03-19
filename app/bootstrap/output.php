<?php

namespace App\Bootstrap;

use App\Utilities\Informations;
use App\Bootstrap\Loader\AutoLoader;

class Output
{
    use Informations;

    public $resource;

    private $currentURL;
    private $label;
    private $data;
    private $loader;
    private $device;

    public function __construct()
    {
        $this->currentURL = urlencode($_SERVER['REQUEST_URI']);
        $this->loader = new AutoLoader();
        if (LOADINGPROCESS) debug("AutoLoader");
    }

    public function view($obj)
    {

        if (!isset($obj->theme)) $obj->theme = 'default';

        // Autoload components
        $this->loader->autoloadComponents($obj);

        $this->device = $this->detectDevice();

        $viewFile = $this->resource . $obj->view . '.blade.php';

        if (file_exists($viewFile)) {

            // Extract the data to variables
            $this->data = (object) $obj->data;

            // Start output buffering
            ob_start();

            // Generate HTML
            $this->generateHtmlHead($obj);
            $this->generateHtmlBody($viewFile, $obj);

            // Get the content of the buffer and clean it
            $content = ob_get_clean();

            if (LOADINGPROCESS) debug("loaded file {$viewFile}");

            // Return the rendered content
            return new Response($content);
        } else {
            return "View '$obj->view' not found";
        }
    }

    private function minifyHTML($html)
    {
        $hash = substr(md5(uniqid()), 0, 6); // Generate a 6-character hash

        $search = [
            '/<!--(.|\s)*?-->/', // Comments
            '/\>[^\S ]+/s',  // strip whitespaces after tags
            '/[^\S ]+\</s',  // strip whitespaces before tags
            '/(\s)+/s',      // shorten multiple whitespace sequences
            '/<div(.*?)>/'       // shorten multiple whitespace sequences
        ];

        $replace = ['', '>', '<', '\\1', '<div$1 jd="' . $hash . '">'];

        $minified = preg_replace($search, $replace, $html);

        return !DEBUGMODE ? $html : $minified;
    }

    private function generateHtmlHead($obj)
    {
        $defaultMetaTags = [
            'description'   => DESCRIPTION,
            'keywords'      => KEYWORDS,
            'author_name'   => AUTHOR_NAME,
            'title'         => TITLE_PAGE,
            'domain_source' => DOMAIN_SOURCE,
            'logo'          => LOGO,
            'thumbnail'     => THUMBNAIL,
            'project_name'  => PROJECT_NAME,
        ];

        $metaTags = (object) array_merge(
            $defaultMetaTags,
            array_intersect_key($obj->meta ?? [], $defaultMetaTags)
        );

?>
        <!DOCTYPE html>
        <html dir='ltr' lang='en'>
        <html>

        <head>
            <title><?= $metaTags->title ?></title>
            <?= $this->loader->meta($obj, $this->device, $metaTags); ?>
            <?= $this->loader->styles($obj, $this->device); ?>
            <?= $this->loader->scripts($obj, $this->device); ?>
        </head>
    <?php
        if (LOADINGPROCESS) debug("loaded generateHtmlHead");
    }

    private function generateHtmlBody($viewFile, $obj)
    {
    ?>

        <body>
            <div id="app">
                <?php
                if (LOADINGPROCESS) :
                    debug("loaded generateHtmlBody");
                else :
                    if ($obj->theme != false) :
                        $topFile = USETHEME . "top.inc";
                        if (file_exists($topFile)) :
                            require_once($topFile);
                        endif;
                    endif;

                    require_once $viewFile;

                    if ($obj->theme != false) :
                        $bottomFile = USETHEME . "bottom.inc";
                        if (file_exists($topFile)) :
                            require_once($bottomFile);
                        endif;
                    endif;

                endif;
                ?>
            </div>

            <?= $this->loader->endbody($obj, $this->device); ?>
        </body>

        </html>
<?php

    }
}
