<?php
/**
 * Created by PhpStorm.
 * User: reynard.j
 * Date: 8/24/2018
 * Time: 11:47 PM
 */

namespace App\Http\Helpers;


class HtmlHelper
{
    public static function filter_html_tag_attributes($html_string) {
//        $dom = new \DOMDocument();
//        $dom->loadHTML($html_string);
//        $xpath = new \DOMXPath($dom);
//        $nodes = $xpath->query('//@*');
//        foreach ($nodes as $node) {
//            if($node->nodeName != "src" && $node->nodeName != "href") {
//                $node->parentNode->removeAttribute($node->nodeName);
//            }
//        }
//
//        return $dom->saveHTML();
        return preg_replace("/<([a-z][a-z0-9]*)[^>]*?(\/?)>/i",'<$1$2>', $html_string);
    }
}