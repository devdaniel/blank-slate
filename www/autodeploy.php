<?php
function cidr_match($ip, $range) {
    list ($subnet, $bits) = explode('/', $range);
    $ip = ip2long($ip);
    $subnet = ip2long($subnet);
    $mask = -1 << (32 - $bits);
    $subnet &= $mask; # nb: in case the supplied subnet wasn't correctly aligned
    return ($ip & $mask) == $subnet;
}

$autodeploy_secret = '9af57bc6898b211f4186dde1129778b9';

// Only allow autodeploy triggers from GitHub's hook servers
// Defined: https://help.github.com/articles/what-ip-addresses-does-github-use-that-i-should-whitelist
if(!cidr_match($_SERVER['REMOTE_ADDR'], '192.30.252.0/22')) { die('no.'); }

//print_r($_REQUEST);
//print_r($_SERVER);

/**
 * GIT DEPLOYMENT SCRIPT
 *
 * Used for automatically deploying websites via github or bitbucket, more deets here:
 *
 * https://gist.github.com/1809044
 */

// The commands
$commands = array(
    'echo $PWD',
    'whoami',
    'git fetch --all',
    'git reset --hard origin/master',
    //'git submodule sync',
    //'git submodule update',
    //'git submodule status',
);

// Run the commands for output
$pwd = trim(shell_exec('echo $PWD'));
$user = trim(shell_exec('whoami'));
$git_stash = trim(shell_exec('git stash'));
$git_fetch = trim(shell_exec('git fetch --all'));
$git_reset = trim(shell_exec('git reset --hard origin/master'));
$git_stash_pop = trim(shell_exec('git stash pop'));
$git_status = trim(shell_exec('git status'));

// Make it pretty for manual user access (and why not?)
echo json_encode(array(
    'dir' => $pwd,
    'user' => $user,
    'stash' => $git_stash,
    'fetch' => $git_fetch,
    'reset' => $git_reset,
    'stash_pop' => $git_stash_pop,
    'status' => $git_status,
    'time' => date()
));
