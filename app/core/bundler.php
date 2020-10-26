<?php

namespace App\Core;

class Bundler {

    public static function bundle_app_css($css) {
        if (!empty($css)) {
            $controller = isset($_REQUEST["controller"]) ? $_REQUEST["controller"] : "dashboard";

            if (SITE_STATUS == "Debug") {
                if (is_array($css)) {
                    foreach ($css as $fcss) {
                        echo("<link rel='stylesheet' href='/resources/styles/app/$fcss.css' type='text/css'>\n");
                    }
                } else {
                    if ($css != "") {
                        echo("<link rel='stylesheet' href='/resources/styles/app/$css.css' type='text/css'>\n");
                    }
                }
            } else {
                $absolute_path = "/resources/styles/app/min/$controller.css";
                $absolute_path_min = "/resources/styles/app/min/$controller.min.css";
                $filename = ROOT_DIR . $absolute_path;
                $filename_min = ROOT_DIR . $absolute_path_min;

                if (SITE_LOCATION == "Local") {
                    if (!file_exists($filename_min)) {
                        $handle = fopen($filename, 'w') or die('Cannot open file:  ' . $filename);
                        if (is_array($css)) {
                            foreach ($css as $fcss) {
                                $css_path = ROOT_DIR . "/resources/styles/app/" . $fcss . ".css";
                                if (file_exists($css_path)) {
                                    $js_handle = fopen($css_path, 'r');
                                    $data = fread($js_handle, filesize($css_path));
                                    fwrite($handle, $data . "\n");
                                    fclose($js_handle);
                                }
                            }
                        } else {
                            if ($css != "") {
                                $css_path = ROOT_DIR . "/resources/styles/app/" . $css . ".css";
                                if (file_exists($css_path)) {
                                    $js_handle = fopen($css_path, 'r');
                                    $data = fread($js_handle, filesize($css_path));
                                    fwrite($handle, $data . "\n");
                                    fclose($js_handle);
                                }
                            }
                        }
                        fclose($handle);
                        self::minify_css($filename, $filename_min);
                    }
                }
                echo("<link rel='stylesheet' href='$absolute_path_min?v=" . SITE_VERSION . "' type='text/css'>");
            }
        }
    }

    public static function bundle_css($css, $filename = "") {
        if (is_array($css)) {
            if (SITE_STATUS == "Debug") {
                foreach ($css as $fcss) {
                    echo("<link rel='stylesheet' href='/resources/styles/$fcss' type='text/css'>\n");
                }
            } else {
                $absolute_path = "";
                $absolute_path_min = "";
                $filename_min = "";

                if ($filename == "") {
                    $absolute_path = "/resources/styles/bundle.css";
                    $absolute_path_min = "/resources/styles/bundle.min.css";
                    $filename = ROOT_DIR . $absolute_path;
                    $filename_min = ROOT_DIR . $absolute_path_min;
                } else {
                    $absolute_path = "/resources/styles/$filename.css";
                    $absolute_path_min = "/resources/styles/$filename.min.css";
                    $filename = ROOT_DIR . $absolute_path;
                    $filename_min = ROOT_DIR . $absolute_path_min;
                }

                if (SITE_LOCATION == "Local") {
                    if (!file_exists($filename_min)) {
                        $handle = fopen($filename, 'w') or die('Cannot open file:  ' . $filename);
                        foreach ($css as $fcss) {
                            $css_path = ROOT_DIR . "/resources/styles/" . $fcss;
                            if (file_exists($css_path)) {
                                $css_handle = fopen($css_path, 'r');
                                $data = fread($css_handle, filesize($css_path));
                                fwrite($handle, $data . "\n");
                                fclose($css_handle);
                            }
                        }
                        fclose($handle);
                        self::minify_css($filename, $filename_min);
                    }
                }

                echo("<link rel='stylesheet' href='$absolute_path_min?v=" . SITE_VERSION . "' type='text/css'>");
            }
        }
    }

    public static function bundle_app_js($protons, $vendors, $apps) {
        $controller = isset($_REQUEST["controller"]) ? $_REQUEST["controller"] : "dashboard";
        if (!file_exists(ROOT_DIR . '/scripts/bundles')) {
            mkdir(ROOT_DIR . '/scripts/bundles', 0777, true);
        }
        if (SITE_STATUS == "Debug") {
            if (is_array($protons)) {
                foreach ($protons as $proton) {
                    echo("<script src='/scripts/proton/$proton.js'></script>\n");
                }
            } else {
                if ($protons != "") {
                    echo("<script src='/scripts/proton/$protons.js'></script>\n");
                }
            }

            if (is_array($vendors)) {
                foreach ($vendors as $vendor) {
                    echo("<script src='/scripts/vendor/$vendor.js'></script>\n");
                }
            } else {
                if ($vendors != "") {
                    echo("<script src='/scripts/vendor/$vendors.js'></script>\n");
                }
            }

            if (is_array($apps)) {
                foreach ($apps as $app) {
                    echo("<script src='/scripts/app/$app'></script>\n");
                }
            } else {
                if ($apps != "") {
                    echo("<script src='/scripts/app/$apps.js'></script>\n");
                }
            }
        } else {
            $absolute_path = "/scripts/bundles/$controller.js";
            $absolute_path_min = "/scripts/bundles/$controller.min.js";
            $filename = ROOT_DIR . $absolute_path;
            $filename_min = ROOT_DIR . $absolute_path_min;

            if (SITE_LOCATION == "Local") {
                if (!file_exists($filename_min)) {
                    $handle = fopen($filename, 'w') or die('Cannot open file:  ' . $filename);
                    if (is_array($protons)) {
                        foreach ($protons as $proton) {
                            $js_path = ROOT_DIR . "/scripts/proton/" . $proton . ".js";
                            if (file_exists($js_path)) {
                                $js_handle = fopen($js_path, 'r');
                                $data = fread($js_handle, filesize($js_path));
                                fwrite($handle, $data . "\n");
                                fclose($js_handle);
                            }
                        }
                    } else {
                        if ($protons != "") {
                            $js_path = ROOT_DIR . "/scripts/proton/" . $protons . ".js";
                            if (file_exists($js_path)) {
                                $js_handle = fopen($js_path, 'r');
                                $data = fread($js_handle, filesize($js_path));
                                fwrite($handle, $data . "\n");
                                fclose($js_handle);
                            }
                        }
                    }

                    if (is_array($vendors)) {
                        foreach ($vendors as $vendor) {
                            $js_path = ROOT_DIR . "/scripts/vendor/" . $vendor . ".js";
                            if (file_exists($js_path)) {
                                $js_handle = fopen($js_path, 'r');
                                $data = fread($js_handle, filesize($js_path));
                                fwrite($handle, $data . "\n");
                                fclose($js_handle);
                            }
                        }
                    } else {
                        if ($vendors != "") {
                            $js_path = ROOT_DIR . "/scripts/vendor/" . $vendors . ".js";
                            if (file_exists($js_path)) {
                                $js_handle = fopen($js_path, 'r');
                                $data = fread($js_handle, filesize($js_path));
                                fwrite($handle, $data . "\n");
                                fclose($js_handle);
                            }
                        }
                    }

                    if (is_array($apps)) {
                        foreach ($apps as $app) {
                            $js_path = ROOT_DIR . "/scripts/app/" . $app . ".js";
                            if (file_exists($js_path)) {
                                $js_handle = fopen($js_path, 'r');
                                $data = fread($js_handle, filesize($js_path));
                                fwrite($handle, $data . "\n");
                                fclose($js_handle);
                            }
                        }
                    } else {
                        if ($apps != "") {
                            $js_path = ROOT_DIR . "/scripts/app/" . $apps . ".js";
                            if (file_exists($js_path)) {
                                $js_handle = fopen($js_path, 'r');
                                $data = fread($js_handle, filesize($js_path));
                                fwrite($handle, $data . "\n");
                                fclose($js_handle);
                            }
                        }
                    }

                    fclose($handle);
                    self::minify_js($filename, $filename_min);
                }
            }
            echo("<script src='$absolute_path_min?v=" . SITE_VERSION . "'></script>");
        }
    }

    public static function bundle_js($js, $filename = "") {
        if (is_array($js)) {
            if (SITE_STATUS == "Debug") {
                foreach ($js as $fjs) {
                    echo("<script src='/scripts/$fjs'></script>\n");
                }
            } else {
                $absolute_path = "";
                $absolute_path_min = "";
                $filename_min = "";
                if ($filename == "") {
                    $absolute_path = "/scripts/bundle.js";
                    $absolute_path_min = "/scripts/bundle.min.js";
                    $filename = ROOT_DIR . $absolute_path;
                    $filename_min = ROOT_DIR . $absolute_path_min;
                } else {
                    $absolute_path = "/scripts/bundle/$filename.js";
                    $absolute_path_min = "/scripts/bundle/$filename.min.js";
                    $filename = ROOT_DIR . $absolute_path;
                    $filename_min = ROOT_DIR . $absolute_path_min;
                }

                if (SITE_LOCATION == "Local") {
                    if (!file_exists($filename_min)) {
                        $handle = fopen($filename, 'w') or die('Cannot open file:  ' . $filename);
                        foreach ($js as $fjs) {
                            $js_path = ROOT_DIR . "/scripts/" . $fjs;
                            if (file_exists($js_path)) {
                                $js_handle = fopen($js_path, 'r');
                                $data = fread($js_handle, filesize($js_path));
                                fwrite($handle, $data . "\n");
                                fclose($js_handle);
                            }
                        }
                        fclose($handle);
                        self::minify_js($filename, $filename_min);
                    }
                }

                echo("<script src='$absolute_path_min?v=" . SITE_VERSION . "'></script>");
            }
        }
    }

    private static function minify_css($raw_path, $new_location) {
        $url = 'https://cssminifier.com/raw';
        self::minify($url, $raw_path, $new_location);
    }

    private static function minify_js($raw_path, $new_location) {
        $url = 'https://javascript-minifier.com/raw';
        self::minify($url, $raw_path, $new_location);
    }

    private static function minify($url, $raw, $new_location) {
        $data = file_get_contents($raw);
        if (MINIFY_BUNDLE === true) {
            $postdata = array('http' => array(
                    'method' => 'POST',
                    'header' => 'Content-type: application/x-www-form-urlencoded',
                    'content' => http_build_query(array('input' => $data))));

            $minified_data = file_get_contents($url, false, stream_context_create($postdata));
        } else {
            $minified_data = $data;
        }
        $handle = fopen($new_location, 'w') or die('Cannot open file:  ' . $new_location);
        fwrite($handle, !empty($minified_data) ? $minified_data : $data);
        fclose($handle);
        unlink($raw);
    }

}

?>