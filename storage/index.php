<?php

$helpers = scandir('helpers');

foreach ( $helpers as $file )
{
    if ( !in_array( $file, array(".","..") ) )
    {

        require_once( 'helpers/' . $file );

    }
}
$config = scandir('config');

foreach ( $config as $file )
{
    if ( !in_array( $file, array(".","..") ) )
    {
        require_once( 'config/' . $file );

    }
}

require_once 'core/FileStackCore.php';
new FileStackCore();
