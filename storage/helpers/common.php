<?php
if (!function_exists('debug')) {
    function debug()
    {
        echo '<pre style="border:1px  solid red;padding: 15px">';

        $c = func_get_args();//obtem um array da funcao
        $len = count($c);
        for ($i = 0; $i < $len; $i++) {
            print_r($c[$i]);
        }

        echo '</pre>';
        exit;
    }
}

if (!function_exists('getDataJwt')) {
    function getDataJwt($index)
    {
        function jsonToArray($json, $user = false)
        {
            $explode = explode('.', $json);
            $data = [];
            foreach ($explode as $key => $row) {
                $newRow = str_replace(['+', '/', '='], ['-', '_', ''], base64_decode($row));
                array_push($data, json_decode($newRow));
            }
            return !$user ? $data : $data[1];
        }

        $data = apache_request_headers();
        return jsonToArray($data[$index], true);
    }
}