<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function ipCIDRCheck ($IP, $CIDR) {
    list ($net, $mask) = preg_split ("/\//", $CIDR);
    $ip_net = ip2long ($net);
    $ip_mask = ~((1 << (32 - $mask)) - 1);
    $ip_ip = ip2long ($IP);
    $ip_ip_net = $ip_ip & $ip_mask;
    return ($ip_ip_net == $ip_net);
}
