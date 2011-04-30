{header}

<div id="main" role="main">
	<h1>Blog</h1>
	
	<ul>
		{entries}
			<li>
				<h2><a href="{permalink}">{title}</a></h2>
				<h3>{when}</h3>
				<p>{summary}</p>
			</li>
		{/entries}
	</ul>
</div>

{footer}