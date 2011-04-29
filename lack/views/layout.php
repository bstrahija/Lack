<?php $this->load->view('header'); ?>

<div id="main">
	<?php echo (isset($content)) ? $content : 'No content found.'; ?>
</div>

<?php $this->load->view('footer'); ?>