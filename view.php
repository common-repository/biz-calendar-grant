<?php $biz_calendar_grant = get_option( 'biz_calendar_grant' ); ?>
<?php if ( ! is_array( $biz_calendar_grant ) ): ?>
	<?php $biz_calendar_grant = array(); ?>
<?php endif; ?>

<form action="options.php" method="post">
	<?php settings_fields( 'biz_calendar_grant' ); ?>
	<p><?php _e( 'Biz Calendarの設定が出来る権限グループにチェックを入れてください。', 'biz_calendar_grant' ); ?></p>

	<ul>
	<?php foreach ( $roles as $name => $value ): ?>
		<?php if ( $name == 'administrator' ): ?>
			<?php continue; ?>
		<?php endif; ?>
		<li>
			<input type="checkbox" name="biz_calendar_grant[<?php echo $name; ?>]" value="<?php echo $name; ?>" <?php if ( array_key_exists( $name, $biz_calendar_grant ) && $biz_calendar_grant[ $name ] == $name ): ?>checked="checked"<?php endif; ?>>
			<?php _e( $name, 'biz_calendar_grant' ); ?>
		</li>
	<?php endforeach; ?>
	</ul>

	<?php
		submit_button(
			__( '保存', 'biz_calendar_grant' ),
			'primary',
			'save',
			false
		);
	?>
</form>
