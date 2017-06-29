![SuperTheme Logo](https://raw.github.com/comolo/contao-supertheme/master/docs/logo-supertheme.png)


## What is SuperTheme?
SuperTheme is a Contao module to add SCSS, JS, CoffeeScript to a page layout easily.
**SuperTheme automatically compiles your assets, combines them and adds them to the HTML markup.**


## Installation

### 1. Install with composer
```bash
composer require comolo/contao-supertheme
```

### 2. Activation (only Contao <= 4.3)
Register the SuperTheme bundle in the AppKernel.
If you are using Contao 4.4 or above the plugin will automatically registered by the Contao Manager Plugin.

```php
// app/AppKernel.php

// ...
$bundles = [
    new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
    new Symfony\Bundle\SecurityBundle\SecurityBundle(),
    new Symfony\Bundle\TwigBundle\TwigBundle(),
    // ... and some more

    // add this line
    new Comolo\SuperThemeBundle\ComoloSuperThemeBundle(),
];
// ...
```

### 3. Clear your cache
Clear your internal cache and update your database with the InstallTool.



## Release notes
* SuperTheme now supports Contao 4.4 and the Contao Manager Plugin. Installing SuperTheme is now super easy ;)
* To make SuperTheme incredibly fast, scss-files won´t get checked for changes anymore, if Contao runs in productive mode (entry point web/app.php). I recommend to run Contao in dev mode while programming the layout of a new website.
