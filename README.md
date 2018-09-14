# Cuckoo Nav plugin for Craft CMS

Simple nav variable to limit SQL queries

![Screenshot](resources/screenshots/plugin_logo.png)

## Installation

To install Cuckoo Nav, follow these steps:

1. Download & unzip the file and place the `cuckoonav` directory into your `craft/plugins` directory
2.  -OR- do a `git clone https://github.com/ournameismud/cuckoonav.git` directly into your `craft/plugins` folder.  You can then update it with `git pull`
3.  -OR- install with Composer via `composer require ournameismud/cuckoonav`
4. Install plugin in the Craft Control Panel under Settings > Plugins
5. The plugin folder should be named `cuckoonav` for Craft to see it.  GitHub recently started appending `-master` (the branch name) to the name of the folder for zip file downloads.

Cuckoo Nav works on Craft 2.4.x and Craft 2.5.x.


## Using Cuckoo Nav

Cuckoo Nav provides a variable to query a Structure section, eg `{% set primaryNav = craft.cuckooNav.getNav('site') %}`.
This provides an object that can be iterated through with each item providing an element for the current entry in the iteration and an array of children (if present).

The entry element provides the following attributes: `id`, `url` and `title`.

For example taking the above example we can loop through the results as follows:

```
	<ul>
	{% for entry in primaryNav %}
		{% set item = entry.element %}
		<li>
			<a href="{{ url(item.url) }}">{{ item.title }}</a>
			{% if entry.children is defined and entry.children|length %}
			<ul>
			{% for entry_child in item.children if entry_child.element is defined %}
				{% set item_child = entry_child.element %}
				<li>
					<a href="{{ url(item_child.url) }}">{{ item_child.title }}</a>
					…
				</li>
			{% endfor %}
			</ul>
			{% endif %}
		</li>
	</ul>
```		

For larger or deeper structures the loop can easily be placed in a `macro`.

## Cuckoo Nav Roadmap

Some things to do, and ideas for potential features:

* more exhaustive documentation
* simplify variables and conditional logic required in querying
* abstract variable into server

Brought to you by [cole007](http://ournameismud.co.uk/)
Cuckoo Clock by Andrejs Kirma from the Noun Project