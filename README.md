![SuperTheme Logo](https://raw.github.com/comolo/contao-supertheme/master/docs/logo-supertheme.png)


## What is SuperTheme?
SuperTheme is a Contao module to add SCSS, JS, CoffeeScript to a page layout easily. **SuperTheme automatically compiles your assets, combines them and adds them to the HTML markup.**


## Installation

**Step 1:**
```bash
cd contao_4; # Your Contao 4 root directory 
composer.phar require comolo/contao-supertheme
```

**Step 2:**
Register the SuperTheme bundle in the AppKernel.

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

**Step 3:**
Clear your internal cache and update your database with the InstallTool.



## Release notes
* To make SuperTheme incredibly fast, scss-files won´t get checked for changes anymore, if Contao runs in productive mode (entry point web/app.php). I recommend to run Contao in dev mode while programming the layout of a new website.