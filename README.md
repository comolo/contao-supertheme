![SuperTheme Logo](https://raw.github.com/comolo/contao-supertheme/relaunch/docs/logo-supertheme.png)
for Contao 3


## What is SuperTheme?
...

## Installation & Configuration
...

## How does it work?

### 1.) Assign assets to a layout
Open the Contao backend and go to "Themes" and click the pagelayout icon. 
Then edit your existing layout or create a new one. 

At the stylesheets section you can now add SCSS Files.
![SCSS Selector](https://raw.github.com/comolo/contao-supertheme/relaunch/docs/step1-1.png)

At the bottom of the page you now can select Javascript and Coffeescript files. 
![JS Selector](https://raw.github.com/comolo/contao-supertheme/relaunch/docs/step1-2.png)

***Hint:*** *By dragging the items, you can change the order they get later included in the page.*


### 2.) Optional: Assign assets to a page
You can assign assets to a single page as well. Just edit a page and go to the Expert section.
Now you should the External Coffee-/Javascript select-field.

### That´s it.
Refresh your frontend page and have a look at the html markup.

HTML Head:
![Markup CSS](https://raw.github.com/comolo/contao-supertheme/relaunch/docs/step3-1.png)

HTML Body (at the bottom):
![Markup JS](https://raw.github.com/comolo/contao-supertheme/relaunch/docs/step3-2.png)

**SuperTheme automatically compiles your assets, combines them and adds them to your webpage.**