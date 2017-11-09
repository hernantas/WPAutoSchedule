=== Auto Schedule ===
Contributors: hernantas
Donate link: http://www.hernantas.com/
Tags: automatic, schedule, custom, date, default, future
Requires at least: 4.4
Tested up to: 4.8.3
Stable tag: 1.0
License: GPLv3
License URI: https://www.gnu.org/licenses/gpl-3.0.en.html

Wordpress plugin to automatically set your post schedule.

== Description ==

The purpose of this plugin is for automatically set the scheduled date just with one click. This is useful since it not that convenient to set schedule in WordPress. The plugin can set the date (including the month and the year) & time (hour & minutes) automatically and can be changed from the settings page.
This plugin works by adding a button in the post editor page, but this button only shows for the drafted post to avoid cluttering the editor page. When the button is clicked, the plugin will find the date that is available (have a less scheduled post than the limit). If there is some date that available, the plugin will assign the nearest available future date.
However, to automatically set the schedule set for you, this plugin will add single javascript only when you are in the editor. What this javascript do is:
1. Find the date that are available based on data generated in PHP.
2. Set the schedule in the page.
This javascript do not have any data communication with the server (since I don't know how anyway). This javascript only set the schedule from the element in the editor page such as edit button, publish button, etc. This is really simple plugin after all.

== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/auto-schedule` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress
3. Use the Settings->Auto Schedule screen to configure the plugin (or skip this one if want to use the default)
4. Start creating a new post or edit the draft.
5. Click the schedule button
6. Profit

== Screenshots ==

1. https://ps.w.org/auto-scheduling/assets/screenshot-1.png
2. https://ps.w.org/auto-scheduling/assets/screenshot-2.png
3. https://ps.w.org/auto-scheduling/assets/screenshot-3.png

== Changelog ==

= 1.0 =
* Initial Release

== Upgrade Notice ==

= 1.0 =
Install just like normal plugin