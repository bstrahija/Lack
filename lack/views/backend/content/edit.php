<hgroup class="where"><div class="wrap">
	<h2>Content</h2>
	<h3>Edit</h3>
</div></hgroup>
<!-- !/.where -->

<?php if (isset($notice) or $notice = $this->input->get('notice')) : ?>
	<div class="notice"><p><?php echo $notice; ?></p></div>
<?php endif; ?>

<?php if (isset($error) or $error = $this->input->get('error')) : ?>
	<div class="error"><p><?php echo $error; ?></p></div>
<?php endif; ?>


<div id="main" role="main">
	<h4>Editing <em>"<?php echo $file; ?>"</em></h4>
	
	<?php echo form_open(); ?>
		<fieldset>
			<legend>Edit</legend>
			
			<p>
				<textarea name="content" id="content" rows="20" cols="100"><?php echo $content; ?></textarea>
			</p>
			
			<p class="btns">
				<button type="submit" class="btn">Save</button>
			</p>
		</fieldset>
	<?php echo form_close(); ?>
</div>
<!-- !/#main -->
