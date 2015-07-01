<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class ZController extends Controller
{
    /**
     * @Route("/{url}", requirements={"url": ".*"}, name="z")
     */
    public function indexAction($url) {
        // var_dump($_SERVER); exit;
        // echo 'zcontroller'; exit;
        $path = preg_replace('/\?.*/', '', '/' . $url);
        $file = $_SERVER['DOCUMENT_ROOT'] . $path;

        $bootstrapFile = $_SERVER['DOCUMENT_ROOT'] . '/843697-witteler-automobile-de-wGlobal/wGlobal/scripts/pre.php';

        if(strpos($url, 'weblication') === 0) {
            $bootstrapFile = $_SERVER['DOCUMENT_ROOT'] . '/weblication/index.php';
        }

        if(is_dir($file)) {
            $url .= '/index.php';
            $path .= '/index.php';
            $file .= '/index.php';
        }

        if(file_exists($file)) {
            $bak = $_SERVER;

            $_SERVER['SCRIPT_FILENAME'] = $file;
            $_SERVER['REQUEST_URI'] = $url;
            $_SERVER['SCRIPT_NAME'] = $path;
            $_SERVER['PHP_SELF']    = $path;

            ob_start();
            include_once $bootstrapFile;

            $headers = headers_list();
            $code = http_response_code();
            $content = ob_get_clean();

            $_SERVER = $bak;

            return new Response($content, $code, $headers);
        }
    }
}
