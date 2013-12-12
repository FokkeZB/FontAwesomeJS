<?

try {

	if (!file_exists('fa.js') || time() - filemtime('fa.js') > 3 * 60 * 60) {
		$contents = @file_get_contents('https://raw.github.com/FortAwesome/Font-Awesome/master/less/variables.less');

		if (!$contents) {
			throw new Exception('Could not read LESS variables from GitHub.');
		}

		if (!preg_match_all('/var-([a-z-]+): "\\\(f[a-z0-9]+)"/', $contents, $matches)) {
			throw new Exception('Could not parse LESS variables from GitHub.');
		}

		$icons = array_combine($matches[1], $matches[2]);

		$ln = count($icons);

		$fa = "module.exports = {" . PHP_EOL;

		foreach (array_keys($icons) as $i => $icon) {
			if (strpos($icon, '-') !== false) {
				$fa .= '    "' . substr($icon, 0, 1) . substr(str_replace(' ', '', ucwords(str_replace('-', ' ', $icon))), 1) . '": String.fromCharCode(0x' . $icons[$icon] . '),' . PHP_EOL;				
			}

			$fa .= '    "' . $icon . '": String.fromCharCode(0x' . $icons[$icon] . ')' . ($i < $ln - 1 ? ',' : '') . PHP_EOL;
		}

		$fa .= "};";
		
		file_put_contents('fa.js', $fa);
	
	} else {
		$fa = @file_get_contents('fa.js');
	}

	header('Content-Description: File Transfer');
	header('Content-Type: text/javascript');
	header('Content-Disposition: attachment; filename="fa.js"');
	header('Content-Transfer-Encoding: binary');
	header('Connection: Keep-Alive');
	header('Expires: 0');
	header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
	header('Pragma: public');

	echo $fa;

} catch (Exception $e) {
	echo '<h1>Exception</h1>';
	echo '<p>' . $e->getMessage() . '</p>';
	exit;
}