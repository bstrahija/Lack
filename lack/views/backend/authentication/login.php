<?php echo form_open(); ?>
	<fieldset>
		<legend>Login</legend>
		
		<?php if (isset($error)) : ?>
			<p class="error"><?php echo $error; ?></p>
		<?php endif; ?>
		
		<p>
			<label for="password">Password</label>
			<input type="password" id="password" name="password" placeholder="Please enter your password...">
		</p>
		<p class="btns">
			<button type="submit" class="btn btn-light">Login</button>
		</p>
	</fieldset>

<?php echo form_close(); ?>