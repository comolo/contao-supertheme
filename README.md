![SuperTheme Logo](https://raw.github.com/comolo/contao-supertheme/master/docs/logo-supertheme.png)


## What is SuperTheme?
SuperTheme is a Contao module to add SCSS, JS, CoffeeScript to a page layout easily.
**SuperTheme automatically compiles your assets, combines them and adds them to the HTML markup.**


## Installation

### 1. Install with composer

```bash
composer require comolo/contao-supertheme
```


### 2. Run the InstallTool
Clear your internal cache and update your database with the InstallTool.


## Release notes
* Added Contao 4.5 Support
* SuperTheme now supports Contao 4.4 and the Contao Manager Plugin. Installing SuperTheme is now super easy ;)
* To make SuperTheme incredibly fast, scss-files won´t get checked for changes anymore, if Contao runs in productive mode (entry point web/app.php). I recommend to run Contao in dev mode while programming the layout of a new website.
