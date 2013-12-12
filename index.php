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

		$fa = '';

		$fa .= "/*******************************************************************************************" . PHP_EOL;
		$fa .= " * ABOUT" . PHP_EOL;
		$fa .= " * This is a CommonJS module to use FontAwesome's icons in a Titanium app." . PHP_EOL;
		$fa .= " * This file at http://fa.fokkezb.nl will automatically be up-to-date with FA." . PHP_EOL;
		$fa .= " *" . PHP_EOL;
		$fa .= " * QUICKSTART" . PHP_EOL;
		$fa .= " * 1. Save the FontAwesome OTF to 'app/assets/fonts' or 'Resources/fonts':" . PHP_EOL;
		$fa .= " *    https://github.com/FortAwesome/Font-Awesome/blob/master/fonts/FontAwesome.otf?raw=true" . PHP_EOL;
		$fa .= " * 2. Save this file to your app's 'app/lib' or 'Resources' folder." . PHP_EOL;
		$fa .= " * 2. Require it where you need it: var fa = require('fa');" . PHP_EOL;
		$fa .= " *    Or store it as a global: Alloy.Globals.fa = require('fa');" . PHP_EOL;
		$fa .= " * 3. Use it with 'fontFamily' on a label (won't work on buttons):" . PHP_EOL;
		$fa .= " *    '.myLabel': {" . PHP_EOL;
		$fa .= " *        font: {" . PHP_EOL;
		$fa .= " *            fontFamily: 'FontAwesome'" . PHP_EOL;
		$fa .= " *        }," . PHP_EOL;
		$fa .= " *        text: Alloy.Globals.fa.volumeUp" . PHP_EOL;
		$fa .= " *    }" . PHP_EOL;
		$fa .= " ******************************************************************************************/" . PHP_EOL;
		$fa .= PHP_EOL;
		$fa .= "module.exports = {" . PHP_EOL;

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

	header('Content-Type: text/javascript');
	echo $fa;

} catch (Exception $e) {
	echo '<h1>Exception</h1>';
	echo '<p>' . $e->getMessage() . '</p>';
	exit;
}