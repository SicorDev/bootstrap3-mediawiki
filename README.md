# Bootstrap3-Mediawiki

This is a MediaWiki skin that uses Bootstrap 3 from Twitter.
The skin is an adaption of the [Bootstrap Mediawiki](http://github.com/borkweb/bootstrap-mediawiki) skin by Matthew Batchelder (http://borkweb.com).

The framework gives a boatload of features that play really nicely with a MediaWiki installation.  To get up and rolling, there's a few things that should be done.

## Changes to the original version

* Adapted skin to [Bootstrap 3.1.1](http://getbootstrap.com)
* Added Bootstrap themes from http://bootswatch.com
* Removed Google Code Prettify (use [Extension:GoogeCodePrettify](http://www.mediawiki.org/wiki/Extension:GoogleCodePrettify) instead)
* Removed [FontAwesome](http://fortawesome.github.io/Font-Awesome/) (use [Bootstrap Glyphicons](http://getbootstrap.com/components/#glyphicons) instead)
	* Fix for Glyphicons in MediaWiki
* Added [Behave.js](http://jakiestfu.github.io/Behave.js/) support

## Installation
First, clone the repository into your `skins/` directory.

````
git clone https://github.com/jneug/bootstrap3-mediawiki.git
````

Next, in `LocalSettings.php` set:

````php
$wgDefaultSkin = 'bootstrap3mediawiki';
````

Then add at the bottom:

````php
require_once( "$IP/skins/bootstrap3-mediawiki/bootstrap3-mediawiki.php" );
````

## Setup
Once you've enabled the skin, you'll want to create a few pages.

### Skin options
You can customize the skin by setting any of these options in your
`LocalSettings.php`.

* **$wgTOCLocation**

	Use `$wgTOCLocation = 'sidebar';` to move the table of contents to the sidebar. On pages wothout a toc the contant will take the complete area.

* **$wgBsTheme**

	Use `$wgBsTheme = 'themename'` to use one of the included Bootstrap themes from http://bootswatch.com. Set this to the theme you would like to use. Note that you have to set this option *before* you require the `bootstrap3-mediawiki.php`.

### Create: Bootstrap:Footer
This MediaWiki page will contain what appears in your footer. You can use whatever bootstrap styles you would like. See the [official documentation](http://www.getbootstrap.com) for more details.

Here is an example for a footer with two columns of equal with, using the Bootstrap grid sytem:

	<div class="row">
		<div class="col-md-6">
			=== Stuff ===
			* [[Link to some place]]
			* [[Another link]]
		</div>
		<div class="col-md-6">
			=== More Stuff ===
			* [http://external.resource.org Go here]
		</div>
	</div>


### Create: Bootstrap:TitleBar
This MediaWiki page will control the links that appear in the Bootstrap navbar after the logo/site title. You can add as many additional menu items and dropdowns as you'd like.  The format that this page is expecting is as follows:

	* Menu Item Title
	** [[Page 1]] (icon:user)
	** [[Page 2]]
	** ----
	** Some subheader
	** [[Page 3]]
	** [[Page 4]]
	* Another Menu (icon:search)
	** [[Whee]]
	** [[OMG hai]]
	* [[A Link]] (icon:cog)

Every list item on the first level will be displayed as a menu item in the navbar. List items on the second level will be displayed in a dropdown under their parent element.
Aside from links you can add dividers to the dropdowns by adding `** ----` and subheading as normal text items, e.g. `** Some text`.
Additionally each menu item may have a [glyphicon](http://getbootstrap.com/components/#glyphicons) by adding `(icon:name)` to the end of the line. (The icon names are the last part in the class names: *.glyphicon-**name***)

### Create: Template:Alert
This template is used to leverage Bootstrap's alert box:

	<div class="alert {{{2}}}">{{{1}}}</div>

Usage:

	{{alert|Message you want to say|alert-danger}}

### Create: Template:Tip
This template is used to do Bootstrap tooltips!

	<span title="{{{2}}}" class="tip" rel="tooltip">{{{1}}}</span>

Usage:

	{{tip|Something|This is the tooltip!}}

	or

	{{tip|[[Bacon]]|Delicious snack}}

### Create: Template:Pop
This template is used to do Bootstrap popovers!

	<span data-original-title="{{{2}}}" data-content="{{{3}}}" class="pop">{{{1}}}</span>

Usage:

	{{pop|Whatever triggers the popover|Popover Title|Popover Content}}

### Short Title
If you want a shorter title to appear in your navbar, you can add <code>$wgSitenameshort = 'Short Name';</code> to your LocalSettings.php file.

### Custom CSS
If you want a custom CSS file for overrides or site-specific features,
you can declare <code>$wgSiteCSS = 'bootstrap-mediawiki/custom.css'</code>

### Custom JS
If you want a custom JS file for overrides or site-specific features,
you can declare <code>$wgSiteJS = 'bootstrap-mediawiki/custom.js'</code>

## Notes for further adaption

* Glyphicons and relative paths
