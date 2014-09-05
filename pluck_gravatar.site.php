<?php
defined('IN_PLUCK') or exit('Access denied!');

function pluck_gravatar_theme_main() {
    global $lang;
    $email = EMAIL;
    $profile = pluck_getGravatar($email);
    if($profile===false) 
        echo 'Gravatar profile not found';
        
    elseif( is_array( $profile ) ) {
        if (isset( $profile['entry'][0]['thumbnailUrl'] ))
            echo "<img style='float:left;padding:4px' src='" 
                    . $profile['entry'][0]['thumbnailUrl'] . "'/>";
        if (isset($profile['entry'][0]['name']['formatted']))
            echo "<h2>" 
                    . $profile['entry'][0]['name']['formatted'] . "</h2>";
        if (isset($profile['entry'][0]['currentLocation']))
            echo "location: " . $profile['entry'][0]['currentLocation']; 
        if (isset( $profile['entry'][0]['aboutMe'])) {
            echo "<h3 style='clear:both'>About Me</h3>";
            echo "<p>" . $profile['entry'][0]['aboutMe'] . "</p>";
        }
        if (isset($profile['entry'][0]['accounts']))  {   
            echo "<h3>Internet Litter</h3><ul>";   
            foreach($profile['entry'][0]['accounts'] as $a) {
                echo "<li><label> "
                        .$a["shortname"] ." </label><a href='" 
                        . $a['url']  . "'>" 
                        . $a["url"]  . "</a></li>";
            }
            echo "</ul>";
        }   
        if (isset($profile['entry'][0]['urls'])) {   
            
            echo "<h3>Internet Props</h3>
                    <ul>";   
            
            foreach($profile['entry'][0]['urls'] as $a) 
                echo "<li><a href='" . $a['value'] . "'>" . $a["title"]. "</a></li>";
            echo "</ul>";
        }
   }
}
function pluck_getGravatar($email) {
    $profile = false;
    $emailhash = md5( strtolower( trim( $email ) ) );
    $url = "http://www.gravatar.com/" . $emailhash . ".php"; 
    try{
        $str = @file_get_contents($url);
        $profile = unserialize( $str );
    } catch (Exception $e) {
    
    }
    return $profile;
}

/**
 *  [profileUrl] => http://gravatar.com/
 *  [preferredUsername] => l 
 *  [thumbnailUrl] => 
 *  [photos] => Array ( 
 *      [0] => Array ( 
 *          [value] => 
 *          [type] => thumbnail ) ) 
 *  [currency] => Array ( ) 
 *  [name] => Array ( 
 *      [givenName] => 
 *      [familyName] => 
 *      [formatted] =>  ) 
 *  [displayName] => 
 *  [aboutMe] =>  
 *  [currentLocation] => n 
 *  [accounts] => Array ( 
 *      [0] => Array ( 
 *          [domain] => profiles.google.com 
 *          [display] => profiles.google.com 
 *          [url] => 
 *          [userid] => 
 *          [verified] => true 
 *          [shortname] => blogger ) 
 *          [1] => Array ( 
 *      [domain] => plus.google.com 
 *      [display] => plus.google.com 
 *      [url] => 
 *      [userid] => 
 *      [verified] => true 
 *      [shortname] => google ) 
 *   [urls] => Array ( 
 *      [0] => Array ( [value] =>  [title] => ) ) ) ) ) 
 */
