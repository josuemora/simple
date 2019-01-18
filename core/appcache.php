<?php
ob_start();
ob_end_clean();
header( 'Expires: Mon, 26 Jul 1997 05:00:00 GMT' );
header( 'Last-Modified: ' . gmdate( 'D, d M Y H:i:s' ) . ' GMT' );
header( 'Cache-Control: no-store, no-cache, must-revalidate' );
header( 'Cache-Control: post-check=0, pre-check=0', false );
header( 'Pragma: no-cache' );
header('Content-type: text/cache-manifest');
echo "CACHE MANIFEST
# ".date("Y-m-d H:i:s").substr((string)microtime(), 1, 8).":v4

# Explicitly cached 'master entries'.

# Resources that require the user to be online.
NETWORK:
*
http://*
https://*

";
?>