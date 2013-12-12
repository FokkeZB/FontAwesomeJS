# FontAwesomeJS
Generates a CommonJS module exposing the UniCode strings for all [Font Awesome](http://fontawesome.io) [icons](http://fontawesome.io/cheatsheet/).

## Get it online
An online automagically up-to-date version of the script runs at:

* [http://fa.fokkezb.nl](http://fa.fokkezb.nl)

## Use it in a Titanium app
The module is a standard CommonJS module, but if you want to use it in [Titanium](http://www.appcelerator.com/titanium) apps like I do, this is how to do it:

1. Save [FontAwesome.otf](https://github.com/FortAwesome/Font-Awesome/blob/master/fonts/FontAwesome.otf?raw=true) to `app/assets/fonts` for [Alloy](http://www.appcelerator.com/alloy) or `Resources/fonts` for classic apps.
1. Save [http://fa.fokkezb.nl](http://fa.fokkezb.nl) to `app/lib/fa.js` or `Resources`.
2. Require it where you need it:
    ```javascript
    var fa = require('fa');
    ```
    Or store it as a global, which in Alloy you would do in `app/alloy.js` as:
    ```javascript
    Alloy.Globals.fa = require('fa');
    ```
3. Use the properties together with `FontAwesome` as `fontFamily`, e.g.:
    ```javascript
    '.myLabel': {
        font: {
            fontFamily: 'FontAwesome'
        },
        text: Alloy.Globals.fa.volumeUp
    }
    ```
    
**Note:** This only works on `Ti.UI.Label`, not on `Ti.UI.Button` for some reason.

## How it works
The scripts reads and parses the [variables.less](https://raw.github.com/FortAwesome/Font-Awesome/master/less/variables.less) file straight from the Font Awesome GitHub repository. It does the necessary conversion of the unicode and makes sure icon names like `volume-up` also have a second object-property-friendly version, which for this one would be `volumeUp`. The script caches the resulting file for 3 hours, so whenever Font Awesome adds more fonts, you'll have an up-to-date file shortly after.

## License

<pre>
Copyright 2013 Fokke Zandbergen

Licensed under the Apache License, Version 2.0 (the "License");
you may not use this file except in compliance with the License.
You may obtain a copy of the License at

   http://www.apache.org/licenses/LICENSE-2.0

Unless required by applicable law or agreed to in writing, software
distributed under the License is distributed on an "AS IS" BASIS,
WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
See the License for the specific language governing permissions and
limitations under the License.
</pre>
