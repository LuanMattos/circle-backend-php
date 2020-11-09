<?php


function route_url($segments, $slash = true)
{
    $CI =& get_instance();

    $routes = $CI->router->routes;

    $toReturn = false;

    foreach ($routes as $route => $arch) {
        $arch = str_replace('/', '\/', $arch);
        $arch = str_replace(array('$1', '$2', '$3', '$4'), '([a-zA-Z0-9\-_]+)', $arch);

        if (preg_match('/^' . $arch . '$/', $segments, $matches)) {
            $toReturn = $route;

            if (is_array($matches)) {
                foreach($matches as $i=>$row){
                    $toReturn = preg_replace('/(\(:any\))/', $matches[$i], $toReturn, 1);
                }
            }
            break;
        }
    }

    if ($toReturn) {
        return ($slash ? '/' : '') . $toReturn;
    }

    return ($slash ? '/' : '') . $segments;
}