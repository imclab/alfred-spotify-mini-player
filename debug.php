<?php

// Turn off all error reporting
error_reporting(0);

require_once('workflows.php');

$w = new Workflows();


exec("mkdir -p ~/Downloads/spot_mini_debug");

$output = "DEBUG: ";

//
// check for library update in progress
if (file_exists($w->data() . "/update_library_in_progress"))
{
	$w->result( '', '', "Library update in progress", "", 'fileicon:'.$w->data() . '/update_library_in_progress', 'no', '' );
	$output = $output . "Library update in progress: " . "the file" . $w->data() . "/update_library_in_progress is present\n";
}

if (!file_exists($w->home() . "/Spotify/spotify-app-miniplayer"))
{		
	$output = $output . "The directory" . $w->home() . "/Spotify/spotify-app-miniplayer is not present\n";
}
else
{
	copy_directory($w->home() . "/Spotify/spotify-app-miniplayer",$w->home() . "/Downloads/spot_mini_debug/spotify-app-miniplayer");
}


if(!file_exists($w->data() . "/settings.db"))
{
	$output = $output .  "The directory" . $w->data() . "/settings.db is not present\n";
}
else
{
	copy($w->data() . "/settings.db",$w->home() . "/Downloads/spot_mini_debug/settings.db");
}


if(!file_exists($w->data() . "/library.db"))
{
	$output = $output .  "The directory" . $w->data() . "/library.db is not present\n";
}
else
{
	copy($w->data() . "/library.db",$w->home() . "/Downloads/spot_mini_debug/library.db");
}

if(!file_exists( "./output.log"))
{
	$output = $output .  "The file output.log is not present\n";
}
else
{
	copy( "./output.log",$w->home() . "/Downloads/spot_mini_debug/output.log");
}

if(!file_exists( "./output_action.log"))
{
	$output = $output .  "The file output_action.log is not present\n";
}
else
{
	copy( "./output_action.log",$w->home() . "/Downloads/spot_mini_debug/output_action.log");
}


$output = $output . exec("uname -a");

file_put_contents($w->home() . "/Downloads/spot_mini_debug/debug.log",$output);

exec("cd ~/Downloads;tar cfz spot_mini_debug.tgz spot_mini_debug");

$val=$w->home() . '/Downloads/spot_mini_debug.tgz';

$w->result( uniqid(), $val, 'Browse to generated tgz file', $val, 'fileicon:'.$val, 'yes', 'file' );

$val=$w->data();

$w->result( uniqid(), $val, 'Browse to App Support Folder', $val, 'fileicon:'.$val, 'yes', 'file' );

$val=$w->path();

$w->result( uniqid(), $val, 'Browse to Alfred workflow folder', $val, 'fileicon:'.$val, 'yes', 'file' );

echo $w->toxml();
function copy_directory( $source, $destination ) {
        if ( is_dir( $source ) ) {
        @mkdir( $destination ); 
        $directory = dir( $source );
        while ( FALSE !== ( $readdirectory = $directory->read() ) ) {
            if ( $readdirectory == '.' || $readdirectory == '..' ) {
                continue;
            }
            $PathDir = $source . '/' . $readdirectory; 
            if ( is_dir( $PathDir ) ) {
                copy_directory( $PathDir, $destination . '/' . $readdirectory );
                continue;
            }
            copy( $PathDir, $destination . '/' . $readdirectory );
        }

        $directory->close();
        }else {
        copy( $source, $destination );
        }
    }
    

?>