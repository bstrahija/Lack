{header}

<div id="main" role="main">
	<h1>Blog</h1>
	
	<ul>
		{entries}
			<li>
				<h2><a href="{permalink}">{title}</a></h2>
				<h3>{subtitle}</h3>
				<h4>{when}</h4>
				<p>{summary}</p>
				<p><small>{my_custom_meta}</small></p>
			</li>
		{/entries}
	</ul>
</div>

{footer}