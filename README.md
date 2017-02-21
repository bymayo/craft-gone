<img src="https://raw.githubusercontent.com/madebyshape/gone/master/screenshots/icon.png" width="50">

# Gone

Gone is a Craft CMS plugin that returns a 410 error for elements (Entries, Categories etc) that have been deleted from the CMS instead of a 404 error.

A 410 error means the page is "gone" and that it existed at some point. Comparing this to a 404 error which says the page never existed / can't be found. IN SEO terms, it's better to deliver this type of error when you can, over a 404. 

Showing a 410 error page also gives you more control over what you say to the user if they hit that page. E.g. "The *Product* no longer exists, here are some recommendations...".


## Features

- Keeps a log of all deleted elements
- Output information on deleted elements to show related elements
- Craft 2.5 compatible

## Install

- Add the `gone` directory into your `craft/plugins` directory.
- Navigate to Settings -> Plugins and click the "Install" button.

## Useage

The only thing you need to do is ensure you have a '410.twig' template in your 'craft/templates' folder. 

If you've changed the errorTemplatePrefix setting in your config file, ensure the 410.twig file is placed in this folder inside templates.

## Templating

The plugin does all the work itself in the background, but if you want to output details about the element that has been deleted you can do so with the following twig tag -

	{{ craft.gone.getByUri() }}
	
This will return an array, which then allows you to use the following options -


<table>
	<tr><td>id</td></tr>
	<tr><td>elementId</td></tr>
	<tr><td>title</td></tr>
	<tr><td>slug</td></tr>
	<tr><td>uri</td></tr>
	<tr><td>type</td></tr>
	<tr><td>dateCreated</td></tr>
</table>

E.g.

	{% set element = craft.gone.getByUri() %}
	
	Sorry, but {{ element.title }} no longer exists.

## Roadmap

- Log Assets, Categories & Users Support
- Support Multilingual builds
- Support Craft Commerce

## Credits

- Book Ghost [Edited] by Thomas Helbig from the Noun Project (https://thenounproject.com/dergraph/)