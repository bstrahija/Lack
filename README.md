# What is Lack&deg;

Lack&deg; is a very simple, file based, CMS. It runs on the CodeIgniter framework.

For now only markdown formatting is supported, but you can also use pure html in your data files.



## Single entry usage

All the data files are inside the **/data** directory. The name of the file (without the extension) coresponds to the URI segment.

Example URI for the file **/data/about.md**

	http://yoursite.com/about



## Entry list usage

If you want a list of entries (something like a blog), just create a subfolder in the **/data** directory.

A blog would then look something like this:

	/data
		blog
			first_entry
			second_entry
			third_entry

And the URL's:

	http://yoursite.com/blog/first_entry
	http://yoursite.com/blog/second_entry
	http://yoursite.com/blog/third_entry

A list of those entries is created automaticaly in the following URL:
	
	http://yoursite.com/blog

You can add meta data to your entries by simply adding some JSON data in your data files. The simples example is adding a title that is displayed in the list:

	{ "title": "One" }

	##One

	Lorem ipsum dolor...



## Assets

All the site assets (CSS, JavaScript, Images, etc.) are located in the directory **/data/assets**.



## Templates

The templates are located in the directory **/data/assets/templates**.

The default template used to display the data files is **layout.php**. And the template used to display a list of entries is **layout_list.php**.

There's also a possibility to use partials. The template directory has 2 subfolders **core** and **partials**. 
You can place your partials in any of them, but best practice is to put the **header**, **footer**, **aside** and **navigation** partials in the **core** folder.

Then you can simply include the partials in the temaplates. An example would be something like this:

	{header}
	
	{navigation}
	
	<article>{content}</article>
	
	{aside}
	
	{footer}

Simple, right?

The template for the entry list would then look like this:

	{header}
	
	{navigation}
	
	<ul>
		{entries}
			<li>
				<h2><a href="{permalink}">{title}</a></h2>
				<h3>{when}</h3>
				<p>{summary}</p>
			</li>
		{/entries}
	</ul>
	
	{aside}
	
	{footer}

