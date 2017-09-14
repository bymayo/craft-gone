<img src="https://github.com/madebyshape/gone/raw/master/screenshots/icon.png" width="50">

# Gone

Gone is a Craft CMS plugin that keeps track of updated and removed elements (E.g. Entries) and then returns the correct error template to the user.

For example, if an element slug has been manually changed, then it will automatically create a 302 redirect.

<img src="https://github.com/madebyshape/gone/raw/master/screenshots/screenshot.png" style="width: 100%">

## Features

- Works with Entries, Categories and Craft Commerce Products
- Tracks if an element slug has been updated
- Tracks if an element has been deleted
- Automatically removes rules if a new element is created with a matching slug
- Output information on updated / deleted elements
- Craft 2.5 compatible

## Install

- Add the `gone` directory into your `craft/plugins` directory.
- Navigate to Settings -> Plugins and click the "Install" button.

## Templating

The plugin does all the work itself in the background, but if you want to output details about the element that has been deleted you can do so with the following twig tag -

	{{ craft.gone.check() }}
	
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

	{% set element = craft.gone.check() %}
	
	Sorry, but {{ element.title }} no longer exists.
	
## Custom Error Templates

The above technique is useful if you want to use it on custom erorr templates. E.g. if you wanted to say "We're sorry but, *Product X* no longer exists. We've recommended some related products below".

To do this, just create the correct template in your `craft/templates` folder. E.g. `410.twig` or `404.twig`.

If you've changed the `errorTemplatePrefix` setting (https://craftcms.com/docs/config-settings#errorTemplatePrefix) in your config file, ensure the error template files are placed in this folder inside templates.

## Roadmap

- Support multilingual / locale based projects
- Support section / category setting changes (E.g. if a section URL is changed from 'blog/entry' to 'news/entry')

## Credits

- Book Ghost [Edited] by Thomas Helbig from the Noun Project (https://thenounproject.com/dergraph/)