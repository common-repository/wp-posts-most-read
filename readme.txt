=== Plugin Name ===
Name: 	WP Posts Most Read 
Contributors: iziwebavenir
Donate link: http://www.iziwebavenir.com 
Tags: Widget, Settings, Images
Requires at least: 3.0.1
Tested up to: 3.5.1 
Stable tag: 1.2
License: GPL2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Count the number of posts views and display a list in a widget. Possibility to display thumbnails.


== Description ==
	
= Resume =

Count the number of posts views and display a list in a widget. Possibility to display thumbnails.

= Translations =

* English
* French
* Spanish


== Installation ==

This section describes how to install the plugin and get it working.

= Install and activate =

1. Upload and unzip wp-posts-most-read.zip and download the directory in to the '/wp-content/plugins/' directory of your website

2. Activate the plugin through the 'Plugins' menu in WordPress

= Display The List =

1. Two way to to display the list - number 2 or 3

2. Use the Widget Page

3. Insert this code anywhere in your template : 

global $PMRposts; if(method_exists('PMRposts','PMR_displaypostsmostread')) $PMRposts->PMR_displaypostsmostread();
	

== Frequently Asked Questions ==

= No Question Yet =

	
== Screenshots ==

1. screenshot-1.jpg 

2. screenshot-2.jpg 


== Changelog ==

= 1.2 =
Small code changes and optimisations 

= 1.1 =
Problem with Directory Name which was different in wordpress repository and on author website. Read the installation guide.

= 1.0 =
First Stable Public Version


== Upgrade Notice == 

= Update From v1.1 to later - Classic Update

Overwrite the complete directory or use the automatic update process
 
= Update From v1.0 to v1.1

Verify that the directory name of your plugin is : wp-posts-most-read

IF YES : Classic Update

IF NO

1. Desactivate the plugin (will delete settings but not the numbers of views) 

2. Delete the version 1.0

2. Install the last version