<hgroup class="where"><div class="wrap">
	<h2>Content</h2>
	<h3>Overview</h3>
</div></hgroup>
<!-- !/.where -->

<div id="main" role="main">
	<div class="actions">
		<h5>Actions: </h5>
		<a href="<?php echo site_url('backend/content/add'); ?>" class="btn"><em>+</em> Add Entry</a>
		
		<?php if ( ! $this->uri->segment(4)) : ?>
			<a href="<?php echo site_url('backend/content/add_dir'); ?>" class="btn"><em>+</em> Add Directory</a>
		<?php endif; ?>
	</div>
	<!-- !/.actions -->
	
	<h6>Browsing: <em>"./<?php echo $path; ?>"</em></h6>
	
	<?php if (isset($directories) and ! empty($directories)) : ?>
		<section id="data-dir">
			<?php foreach ($directories as $key=>$dir) : ?>
				<article class="dir">
					<a href="<?php echo site_url('backend/content/browse/'.$dir); ?>"><?php echo $dir; ?></a>
					<a href="<?php echo site_url('backend/content/delete/directory/'.$dir); ?>" class="remove"><em>X</em> delete</a>
				</article>
			<?php endforeach; ?>
		</section>
	<?php endif; ?>
	
	<?php if (isset($entries) and ! empty($entries)) : ?>
		<section id="data-entries">
			<?php foreach ($entries as $key=>$entry) : ?>
				<article class="entry">
					<a href="<?php echo site_url('backend/content/edit/'.$path.'/'.$entry); ?>"><?php echo $entry; ?></a>
					<a href="<?php echo site_url('backend/content/delete/entry/'.$path.'/'.$entry); ?>" class="remove"><em>X</em> delete</a>
				</article>
			<?php endforeach; ?>
		</section>
	<?php endif; ?>
</div>
<!-- !/#main -->
