# PHPCRAssets

[![Build Status](https://scrutinizer-ci.com/g/nvbooster/PHPCRAssets/badges/build.png?b=master)](https://scrutinizer-ci.com/g/nvbooster/PHPCRAssets/build-status/master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/nvbooster/PHPCRAssets/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/nvbooster/PHPCRAssets/?branch=master)

Bundle for storing and serving js, css assets with PHPCR Storage.

## Install

Include this to you composer.json file

``` js
"nvbooster/phpcr-assets-bundle": "dev-master"
```

or run 

```sh
composer require nvbooster/phpcr-assets-bundle-master
```

Ensure CmfRoutingAutoBundle is installed and configured according to https://github.com/symfony-cmf/RoutingAutoBundle

Then add PHPCRAssetsBundle to your AppKernel:

```php
	public function registerBundles()
    {
        $bundles = array(
			...        
            new NVBooster\PHPCRAssetsBundle\NVBoosterPHPCRAssetsBundle(),
        );
    }
```

# Configure

No configuration required for base functionality;

## SonataAdmin integration

To manage assets using SonataAdmin add admin services to sonata config

```yml
sonata_admin:
    dashboard:
        groups:
        	...
            assets:
                label: Assets
                items:
                    - nvbooster_assets.js_asset_admin
                    - nvbooster_assets.css_asset_admin
sonata_doctrine_phpcr_admin:
    document_tree:
		...
        NVBooster\PHPCRAssetsBundle\Asset\JsAsset:
            valid_children: []
        NVBooster\PHPCRAssetsBundle\Asset\CssAsset:
            valid_children: []
```

## CodeMirror integration

To use CodeMirror library for editing assets in SonataAdmin, add codemirror section to config:

```yml
nvbooster_assets:
	codemirror: ~
```	

If you want for bundle to automatically include js and css files of CodeMirror when needed, then you should provide paths (see Full config).


## Full configuration
```yml
nvbooster_assets:
    phpcr:        
        root_path: '/cms/assets'	#Defines path in PHPCR tree for assets to store in    
    filters:
        css: []						#Default assetics filters for css assets
        js: []						#Default assetics filters for js assets
    routing:        
        base_uri: assets 			#Defines base uri for routes generated    
    codemirror:						
        paths:
            js: ~        			#Path for codemirror.js in web folder            	
            css: ~                  #Path for codemirror.css  in web folder
            modes_dir: ~            #Path for codemirror modes directory in web folder
            themes_dir: ~           #Path for codemirror theme styles  in web folder
        options:                	#Codemirror widget defaults
			mode: xml				#Default mode
			theme: eclipse			#Default theme
```
	
# Using

After configuring run repository initializers to create all required paths in PHPCR storage:

```sh
php app/console doctrine:phpcr:repository:init
```

Include assets in your templates:

```twig
<link rel="stylesheet" href="{{ url(css_asset) }}"/>
<script type="text/javascript" src="{{ url(js_asset) }}"></script>
```

or any other way.


