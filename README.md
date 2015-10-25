# angular-press

![build status](https://travis-ci.org/nomve/angular-press.svg)

A Wordpress Plugin that builds on the [WP REST API](http://v2.wp-api.org/) Plugin
in order to make it easier for Wordpress shortcodes to work with an Angular style SPA.

The work was intended for something that never came to be, so it isn't completely finished.
It can be viewed as more of an idea on how it could work. It was not sufficiently tested either.

Tested with WP REST API v2.0-beta4.

## The Issue
By default, WP REST API will parse the saved shortcode such as `[gallery ids=3]` into the standard
HTML block that would be used in a normal Wordpress theme, e.g. `<div id='gallery-1' class='gallery
galleryid-1 gallery-columns-3 gallery-size-thumbnail'>...`. However, this defeats the purpose of 
having a single page application with templates being rendered in the frontend because the HTML is
already defined, and all adjustements need to be done in the backend.

This plugin tries to solve this by adding a second field to the post object called angular. When
visiting `wp-json/wp/v2/posts/1`, next to `content.rendered`, there will be a second field `content.angular`.
By default, a shortcode, e.g. gallery will not be parsed to HTML, instead you get an angular directive
`<gallery images='...'></gallery>`.

This can then be parsed as an angular directive, e.g. using `$compile` after fetching the post data from the API.

## Instructions
* Install and activate WP REST API (only tested with 2.0-beta4)
* Install and activate Angular-Press
* visit `wp-json/wp/v2/posts/1` or `wp-json/wp/v2/posts/ID`

## Limitations
As already said, the work is not finished. The only shortcode that works is the gallery shortcode.
