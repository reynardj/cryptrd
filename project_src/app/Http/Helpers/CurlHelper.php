<?php

namespace App\Http\Helpers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
use Symfony\Component\Console\Helper\Helper;

class CurlHelper extends Helper
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    private static function append_headers(&$header, $additional_headers) {
        if (!empty($additional_headers)) {
            foreach ($additional_headers as $additional_header) {
                array_push($header, $additional_header);
            }
        }
    }

    public static function get($url, array $query_parameters = array(), $result_data_type = 'json') {
        $header = array();

        $ch = curl_init();

        $url = $url."?".http_build_query($query_parameters) ;
        // Set the url, number of GET vars, GET data
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );

        if (App::environment('local')) {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        }

        curl_setopt($ch, CURLOPT_TIMEOUT, 10000);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10000);
        curl_setopt($ch, CURLOPT_DNS_CACHE_TIMEOUT, 10000);

        $response = curl_exec($ch);

        $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($result_data_type == 'json') {
            return json_decode($response);
        } else {
            return $response;
        }
    }

    public static function post_json(array $additional_headers, $url, $parameter, &$http_status = 0, $result_data_type = 'json') {
        $header = array(
            'Content-Type: application/json;'
        );

        self::append_headers($header, $additional_headers);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($parameter));

        if (App::environment('local')) {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        }

        curl_setopt($ch, CURLOPT_TIMEOUT, 10000);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10000);
        curl_setopt($ch, CURLOPT_DNS_CACHE_TIMEOUT, 10000);

        $response = curl_exec($ch);
        $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($result_data_type == 'json') {
            return json_decode($response);
        } else {
            return $response;
        }
    }

    public static function delete(array $additional_headers, $url, $parameter = array(), &$http_status = 0, $result_data_type = 'json') {
        $header = array(
            'Content-Type: application/javascript;'
        );

        self::append_headers($header, $additional_headers);

        $curl = curl_init($url);

        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'DELETE');
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($parameter));

        if (App::environment('local')) {
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        }

        curl_setopt($curl, CURLOPT_TIMEOUT, 10000);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 10000);
        curl_setopt($curl, CURLOPT_DNS_CACHE_TIMEOUT, 10000);

        $response = curl_exec($curl);
        $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        if ($result_data_type == 'json') {
            return json_decode($response);
        } else {
            return $response;
        }
    }

    public static function upload_image($file_index, $category, $base64_data = NULL){
        if (!empty($_FILES[$file_index]) && $_FILES[$file_index]['size'] != 0 && $_FILES[$file_index]['error'] == 0)
        {
            $cfile = new \CURLFile($_FILES[$file_index]['tmp_name'], $_FILES[$file_index]['type'],
                $_FILES[$file_index]['name']);
            $data = array(
                'images[]' => $cfile,
                'category' => $category
            );

            $curl = CurlHelper::post($data);

            if (!empty($curl['status']) && $curl['status'] == 200) {
                return $curl['data'][0];
            } else {
                return '';
            }
        } else {
            $datauri = !empty($base64_data) ? $base64_data : $_POST[$file_index] ;
            if ($datauri != "") {
                $ext = "png";
                if(strpos($datauri, "data:image/png;base64,") !== FALSE)
                {
                    $ext = "png";
                }
                else if(strpos($datauri, "data:image/jpeg;base64,") !== FALSE)
                {
                    $ext = "jpeg";
                }
                else if(strpos($datauri, "data:image/jpg;base64,") !== FALSE)
                {
                    $ext = "jpg";
                }

                $filename = $file_index.time().rand(1, 1000);
                $filename = GeneralHelper::slugify($filename).'.'.$ext;

                $datauri = preg_replace('#^data:image/\w+;base64,#i', '', $datauri);

                $datauri = str_replace(' ', '+', $datauri);

                $url = Controller::IMAGE_URL_ROOT . $filename;
                $valid = (bool) file_put_contents($url, base64_decode($datauri));
                while($valid == FALSE)
                {
                    $valid = (bool) file_put_contents($url, base64_decode($datauri));
                }

                $cfile = new \CURLFile($url, 'image/' . $ext, $filename);
                $data = array(
                    'images[]' => $cfile,
                    'category' => $category
                );

                $curl = CurlHelper::post($data);

                if (file_exists($url)) unlink($url);

                if (!empty($curl['status']) && $curl['status'] == 200) {
                    return $curl['data'][0];
                } else {
                    return '';
                }
            }
        }
    }

    public static function post($parameter = array()){
        $url = 'https://file.getdiskon.com/api/image';
        $header = array(
            'Authorization: 7f6KK3e2Jt2uqbYHJKJPQeqjQHRxYs',
            'Content-Type: multipart/form-data'
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $parameter);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($ch);
        $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        $result = json_decode($response);
         if (isset($result)) {
             return array("status" => $http_status, "data" => $result);
         } else {
             return FALSE;
         }
    }

    public static function delete_image($parameter = array()){

        $parameter['filepath'] = str_replace(Controller::IMAGE_URL, '', $parameter['filepath']);

        $url = 'https://file.getdiskon.com/api/image';
        $header = array(
            'Authorization: 7f6KK3e2Jt2uqbYHJKJPQeqjQHRxYs',
            'Content-Type: application/x-www-form-urlencoded'
        );

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($parameter));
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($curl);
        $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        $result = json_decode($response);
        if (isset($result)) {
            return array("status" => $http_status, "data" => $result);
        } else {
            return FALSE;
        }
    }

    public static function does_file_exist($filepath = '') {

        $filepath = str_replace('https://file.getdiskon.com/', '', $filepath);

        $url = 'https://file.getdiskon.com/api/image';
        $header = array(
            'Authorization: 7f6KK3e2Jt2uqbYHJKJPQeqjQHRxYs',
            'Content-Type: application/json'
        );

        // Open connection
        $ch = curl_init();

        $parameter = array(
            'filepath' => $filepath
        );

        $url = $filepath == "" ? $url : $url."?".http_build_query($parameter) ;
        // Set the url, number of GET vars, GET data
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );

        // this is controversial
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        // Execute request
        $response = curl_exec($ch);

        $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        // Close connection
        curl_close($ch);

        // get the result and parse to JSON
        $result = json_decode($response);
        if (isset($result)) {
            return $result;
        } else {
            return FALSE;
        }
    }

    /**
     * Returns the canonical name of this helper.
     *
     * @return string The canonical name
     */
    public function getName() {
        // TODO: Implement getName() method.
        return "CurlHelper";
    }
}
