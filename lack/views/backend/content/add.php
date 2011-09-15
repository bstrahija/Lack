<hgroup class="where"><div class="wrap">
	<h2>Content</h2>
	<h3>Add</h3>
</div></hgroup>
<!-- !/.where -->

<?php if (isset($error)) : ?>
	<div class="error"><p><?php echo $error; ?></p></div>
<?php endif; ?>


<div id="main" role="main">
	<h4>Add New Content</h4>
	
	<?php echo form_open(); ?>
		<fieldset>
			<legend>Add</legend>
			
			<p>
				<label for="filename">Filename</label>
				<input type="text" name="filename">
			</p>
			<p>
				<textarea name="content" id="content" rows="20" cols="100"></textarea>
			</p>
			
			<p class="btns">
				<button type="submit" class="btn">Save</button>
			</p>
		</fieldset>
	<?php echo form_close(); ?>
</div>
<!-- !/#main -->
