![SuperTheme Logo](https://raw.github.com/comolo/contao-supertheme/master/docs/logo-supertheme.png)


## What is SuperTheme?
SuperTheme (formerly known as theme_external_js) is a Contao 3 module to add assets to a page layout easily. **SuperTheme automatically compiles your assets, combines them and adds them to the HTML markup.** Currently SCSS, CoffeeScript and Javascript are supported.


## Installation
*  **Contao Composer Module**: You can install this package by searching for "comolo/contao-supertheme". Don´t forget to update the database and to rebuilt the internal cache!


## Configuration
At the moment there are no configuration options available.


## How does it work?

### 1.) Assign assets to a layout
Open the Contao backend and go to "Themes" and click on the page layout icon. 
Then edit your existing layout or create a new one. 

At the stylesheets section you can now add SCSS Files.
![SCSS Selector](https://raw.github.com/comolo/contao-supertheme/master/docs/step1-1.png)

At the bottom of the page you now can select Javascript and Coffeescript files. 
![JS Selector](https://raw.github.com/comolo/contao-supertheme/master/docs/step1-2.png)

***Hint:*** *By dragging the items, you can change the order they get later combined.*


### 2.) Optional: Assign assets to a page
You can assign assets to just a single page as well. Just edit a page and go to the "Expert" section.
Now you should the External Coffee-/Javascript select-field.

### 3.) That´s it
Refresh your frontend page and have a look at the html markup.

**Inside the head-tag:**

![Markup CSS](https://raw.github.com/comolo/contao-supertheme/master/docs/step3-1.png)


.....

**At the end of the body-tag** 


![Markup JS](https://raw.github.com/comolo/contao-supertheme/master/docs/step3-2.png)
