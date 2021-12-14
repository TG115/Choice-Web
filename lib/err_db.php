<?

echo '<script>';
if ($GLOBALS['mysqli'])
	echo 'console.warn(`Database error: '. str_replace('`','\`', mysqli_error($GLOBALS['mysqli'])) .'`);';
else
	echo 'console.warn("Could not connect");';
echo 'console.log(`'. str_replace('`','\`', $sql) .'`);';
echo 'console.log(`'. str_replace('`','\`', $types) .'`);';
echo 'console.log(`'. str_replace('`','\`', print_r($params, true)) .'`);';
echo '</script>';


exit;

?>