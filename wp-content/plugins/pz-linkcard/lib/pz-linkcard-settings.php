<?php if (!function_exists("get_option")) die; ?>
<div class="wrap">
	<div id="icon-options-general" class="icon32"></div>
	<h2><?php echo __('LinkCard Settings', $this->text_domain).' ver.'.$this->options['plugin-version'];?></h2>
	<div id="settings" style="clear:both;">
<?php
		if ( isset($_POST['properties'])) {
			check_admin_referer('pz_options');
			$this->options = $_POST['properties'];
			
			// セットされていないオプション項目をnullでセットする
			foreach ($this->defaults as $key => $value) {
				if (!isset($this->options[$key])) {
					$this->options[$key] = null;
				}
			}
			
			if (isset($this->options['initialize']) && $this->options['initialize'] == '1') {
				delete_option('Pz_LinkCard_options');
				$this->options	=	$this->defaults;
			}
			
			$this->options['ex-image'] = stripslashes($this->options['ex-image']);
			$this->options['in-image'] = stripslashes($this->options['in-image']);
			$this->options['th-image'] = stripslashes($this->options['th-image']);
			
			$this->options['ex-info'] = stripslashes($this->options['ex-info']);
			$this->options['in-info'] = stripslashes($this->options['in-info']);
			$this->options['th-info'] = stripslashes($this->options['th-info']);
			$this->options['saved-date'] = time();
			
			$result = true;
			if ($this->options['code1'] == '') {
				echo '<div class="error fade"><p><strong>'.__('Short code is not set.', $this->text_domain).'</strong></p></div>';
				$result = false;
			}
			
			$width			=	$this->options['width'];
			if ($width) {
				if (substr($width, -1 ) == '%') {
					$width		=	pz_TrimNum($width, 0);
					if ($width	<	1	||	$width	>	100) {
						$this->options['width']		=	$this->defaults['width'];
					} else {
						$this->options['width']		=	$width.'%';
					}
				} else {
					$this->options['width'] = pz_TrimNum($width, $this->defaults['width']).'px';
				}
			}
			
			if	($this->options['content-height']) {
				$this->options['content-height']	=	pz_TrimNum($this->options['content-height'],	$this->defaults['content-height'] ).'px';
			}
			$this->options['trim-title']		=	pz_TrimNum($this->options['trim-title'],		$this->defaults['trim-title']);
			$this->options['trim-url']			=	pz_TrimNum($this->options['trim-url'],			$this->defaults['trim-url']);
			$this->options['trim-count']		=	pz_TrimNum($this->options['trim-count'],		$this->defaults['trim-count']);
			$this->options['trim-sitename']		=	pz_TrimNum($this->options['trim-sitename'],		$this->defaults['trim-sitename']);
			$this->options['size-title']		=	pz_TrimNum($this->options['size-title'],		$this->defaults['size-title']).'px';
			$this->options['height-title']		=	pz_TrimNum($this->options['height-title'],		$this->defaults['height-title']).'px';
			$this->options['size-url']			=	pz_TrimNum($this->options['size-url'],			$this->defaults['size-url']).'px';
			$this->options['height-url']		=	pz_TrimNum($this->options['height-url'],		$this->defaults['height-url']).'px';
			$this->options['size-excerpt']		=	pz_TrimNum($this->options['size-excerpt'],		$this->defaults['size-excerpt']).'px';
			$this->options['height-excerpt']	=	pz_TrimNum($this->options['height-excerpt'],	$this->defaults['height-excerpt']).'px';
			$this->options['size-info']			=	pz_TrimNum($this->options['size-info'],			$this->defaults['size-info']).'px';
			$this->options['height-info']		=	pz_TrimNum($this->options['height-info'],		$this->defaults['height-info']).'px';
			$this->options['size-added']		=	pz_TrimNum($this->options['size-added'],		$this->defaults['size-added']).'px';
			$this->options['height-added']		=	pz_TrimNum($this->options['height-added'],		$this->defaults['height-added']).'px';
			$this->options['size-more']			=	pz_TrimNum($this->options['size-more'],			$this->defaults['size-more']).'px';
			$this->options['height-more']		=	pz_TrimNum($this->options['height-more'],		$this->defaults['height-more']).'px';
			$this->options['thumbnail-width']	=	pz_TrimNum($this->options['thumbnail-width'],	$this->defaults['thumbnail-width']).'px';
			$this->options['thumbnail-height']	=	pz_TrimNum($this->options['thumbnail-height'],	$this->defaults['thumbnail-height']).'px';
			$this->options['border-width']		=	pz_TrimNum($this->options['border-width'],		$this->defaults['border-width']).'px';
			
			$color_code = preg_replace('/[^0-9a-f]/i', '', $this->options['ex-border-color']);
			$this->options['ex-border-color']	= '#'.$color_code;
			
			$color_code = preg_replace('/[^0-9a-f]/i', '', $this->options['in-border-color']);
			$this->options['in-border-color']	= '#'.$color_code;
			
			$color_code = preg_replace('/[^0-9a-f]/i', '', $this->options['th-border-color']);
			$this->options['th-border-color']	= '#'.$color_code;
			
			$color_code = preg_replace('/[^0-9a-f]/i', '', $this->options['color-info']);
			$this->options['color-info']	= '#'.$color_code;
			
			$color_code = preg_replace('/[^0-9a-f]/i', '', $this->options['color-added']);
			$this->options['color-added']	= '#'.$color_code;
			
			$color_code = preg_replace('/[^0-9a-f]/i', '', $this->options['color-title']);
			$this->options['color-title']	= '#'.$color_code;
			
			$color_code = preg_replace('/[^0-9a-f]/i', '', $this->options['color-url']);
			$this->options['color-url']	= '#'.$color_code;
			
			$color_code = preg_replace('/[^0-9a-f]/i', '', $this->options['color-excerpt']);
			$this->options['color-excerpt']	= '#'.$color_code;
			
			// サムネイルのキャッシュディレクトリの用意
			$thumbnail_dir			=	$this->upload_dir_path.'cache/';
			$thumbnail_url			=	$this->upload_dir_url .'cache/';
			if		(!is_dir($thumbnail_dir) && !wp_mkdir_p($thumbnail_dir)) {
				$thumbnail_dir		=	$this->plugin_dir_path.'cache/';
				$thumbnail_url		=	$this->plugin_dir_url .'cache/';
				if	(!is_dir($thumbnail_dir)) {
					$thumbnail_dir	=	null;
					$thumbnail_url	=	null;
				}
			}
			$this->options['thumbnail-dir']	= $thumbnail_dir;
			$this->options['thumbnail-url']	= $thumbnail_url;
			
			// オプションの更新
			if ($result == true) {
				$result = update_option('Pz_LinkCard_options', $this->options);
				if ($result == true) {
					echo '<div class="updated fade"><p><strong>'.__('Changes saved.', $this->text_domain).'</strong></p></div>';
				} else {
					echo '<div class="error fade"><p><strong>'.__('Not changed.', $this->text_domain).'</strong></p></div>';
				}
				$this->pz_SetStyle();
			}
		}
?>
		<form action="" method="post">
			<?php wp_nonce_field('pz_options'); ?>

			<div class="pz-lkc-tabs">
				<a class="pz-lkc-tab<?php if ($this->options['flg-invalid']) { echo ' pz-lkc-tab-active'; } ?>" href="#pz-lkc-error"<?php if (!$this->options['flg-invalid']) { echo ' style="display: none;"'; } ?>><?php _e('Error', $this->text_domain); ?></a>
				<a class="pz-lkc-tab<?php if (!$this->options['flg-invalid']) { echo ' pz-lkc-tab-active'; } ?>" href="#pz-lkc-basic"><?php _e('Basic', $this->text_domain); ?></a>
				<a class="pz-lkc-tab" href="#pz-lkc-position"><?php _e('Position', $this->text_domain); ?></a>
				<a class="pz-lkc-tab" href="#pz-lkc-display"><?php _e('Display', $this->text_domain); ?></a>
				<a class="pz-lkc-tab" href="#pz-lkc-letter"><?php _e('Letter', $this->text_domain); ?></a>
				<a class="pz-lkc-tab" href="#pz-lkc-external"><?php _e('External link', $this->text_domain); ?></a>
				<a class="pz-lkc-tab" href="#pz-lkc-internal"><?php _e('Internal link', $this->text_domain); ?></a>
				<a class="pz-lkc-tab" href="#pz-lkc-samepage"><?php _e('Same page link', $this->text_domain); ?></a>
				<a class="pz-lkc-tab" href="#pz-lkc-editor"><?php _e('Editor', $this->text_domain); ?></a>
				<a class="pz-lkc-tab" href="#pz-lkc-initialize"><?php _e('Initialize', $this->text_domain); ?></a>
			</div>
				
			<div class="pz-lkc-item<?php if ($this->options['flg-invalid']) { echo ' pz-lkc-item-active'; } ?>" id="pz-lkc-error">
				<div<?php if (!$this->options['flg-invalid']) { echo ' style="display: none;"'; } ?>>
					<h3><?php echo __('Error settings', $this->text_domain).'<a href="https://popozure.info/pz-linkcard-settings-error" target="_blank"><img src="'.$this->plugin_dir_url.'img/help.png" width="16" height="16" title="'.__('Help', $this->text_domain).'" alt="help"></a>'; ?></h3>
					<table class="form-table">
						<tr valign="top">
							<th scope="row"><?php _e('Invalid URL', $this->text_domain); ?></th>
							<td><label><input name="properties[flg-invalid]" type="checkbox" id="check" value="1" <?php checked(isset($this->options['flg-invalid']) ? $this->options['flg-invalid'] : null, 1); ?> /><?php _e('Uncheck to cancel the error condition.', $this->text_domain); ?></label></td>
						</tr>
						<tr valign="top" style="display: none;">
							<th scope="row"><?php _e('Error URL', $this->text_domain); ?></th>
							<td><input name="properties[invalid-url]" type="text" id="inputtext" value="<?php echo esc_attr($this->options['invalid-url']); ?>" size="80" /></td>
						</tr>
						<tr valign="top" style="display: none;">
							<th scope="row"><?php _e('Error Time', $this->text_domain); ?></th>
							<td><input name="properties[invalid-time]" type="text" id="inputtext" value="<?php echo esc_attr($this->options['invalid-time']); ?>" size="10" /></td>
						</tr>
					</table>
				</div>
			</div>

			<div class="pz-lkc-item<?php if (!$this->options['flg-invalid']) { echo ' pz-lkc-item-active'; } ?>" id="pz-lkc-basic">
				<h3><?php echo __('Basic settings', $this->text_domain).'<a href="https://popozure.info/pz-linkcard-settings-basic" target="_blank"><img src="'.$this->plugin_dir_url.'img/help.png" width="16" height="16" title="'.__('Help', $this->text_domain).'" alt="help"></a>'; ?></h3>
				<table class="form-table">
					<tr valign="top">
						<th scope="row"><?php _e('Easy format', $this->text_domain); ?></th>
						<td>
							<select name="properties[special-format]">
								<option value=""	<?php if($this->options['special-format'] == '')	echo 'selected="selected"'; ?>><?php _e('None', $this->text_domain); ?></option>
								<option value="LkC"	<?php if($this->options['special-format'] == 'LkC')	echo 'selected="selected"'; ?>><?php _e('Pz-LkC Default', $this->text_domain); ?></option>
								<option value="hbc"	<?php if($this->options['special-format'] == 'hbc')	echo 'selected="selected"'; ?>><?php _e('Normal', $this->text_domain); ?></option>
								<option value="ecl"	<?php if($this->options['special-format'] == 'ecl')	echo 'selected="selected"'; ?>><?php _e('Enclose', $this->text_domain); ?></option>
								<option value="cmp"	<?php if($this->options['special-format'] == 'cmp')	echo 'selected="selected"'; ?>><?php _e('Compact', $this->text_domain); ?></option>
								<option value="ref"	<?php if($this->options['special-format'] == 'ref')	echo 'selected="selected"'; ?>><?php _e('Reflection', $this->text_domain); ?></option>
								<option value="smp"	<?php if($this->options['special-format'] == 'smp')	echo 'selected="selected"'; ?>><?php _e('Simple', $this->text_domain); ?></option>
								<option value="JIN"	<?php if($this->options['special-format'] == 'JIN')	echo 'selected="selected"'; ?>><?php _e('Headline', $this->text_domain); ?></option>
								<option value="ct1"	<?php if($this->options['special-format'] == 'ct1')	echo 'selected="selected"'; ?>><?php _e('Cellophane tape "center"', $this->text_domain); ?></option>
								<option value="ct2"	<?php if($this->options['special-format'] == 'ct2')	echo 'selected="selected"'; ?>><?php _e('Cellophane tape "Top corner"', $this->text_domain); ?></option>
								<option value="ct3"	<?php if($this->options['special-format'] == 'ct3')	echo 'selected="selected"'; ?>><?php _e('Cellophane tape "long"', $this->text_domain); ?></option>
								<option value="ct4"	<?php if($this->options['special-format'] == 'ct4')	echo 'selected="selected"'; ?>><?php _e('Cellophane tape "digonal"', $this->text_domain); ?></option>
								<option value="ppc"	<?php if($this->options['special-format'] == 'ppc')	echo 'selected="selected"'; ?>><?php _e('Curling paper', $this->text_domain); ?></option>
								<option value="tac"	<?php if($this->options['special-format'] == 'tac')	echo 'selected="selected"'; ?>><?php _e('Cellophane tape and curling', $this->text_domain); ?></option>
								<option value="sBR"	<?php if($this->options['special-format'] == 'sBR')	echo 'selected="selected"'; ?>><?php _e('Stitch blue & red', $this->text_domain); ?></option>
								<option value="sGY"	<?php if($this->options['special-format'] == 'sGY')	echo 'selected="selected"'; ?>><?php _e('Stitch green & yellow', $this->text_domain); ?></option>
								<option value="sqr"	<?php if($this->options['special-format'] == 'sqr')	echo 'selected="selected"'; ?>><?php _e('Square', $this->text_domain); ?></option>
								<option value="inI"	<?php if($this->options['special-format'] == 'inI')	echo 'selected="selected"'; ?>><?php _e('Infomation orange', $this->text_domain); ?></option>
								<option value="inN"	<?php if($this->options['special-format'] == 'inN')	echo 'selected="selected"'; ?>><?php _e('Neutral bluegreen', $this->text_domain); ?></option>
								<option value="inE"	<?php if($this->options['special-format'] == 'inE')	echo 'selected="selected"'; ?>><?php _e('Enlightened green', $this->text_domain); ?></option>
								<option value="inR"	<?php if($this->options['special-format'] == 'inR')	echo 'selected="selected"'; ?>><?php _e('Resistance blue', $this->text_domain); ?></option>
								<option value="wxp"	<?php if($this->options['special-format'] == 'wxp')	echo 'selected="selected"'; ?>><?php _e('Windows XP', $this->text_domain); ?></option>
								<option value="w95"	<?php if($this->options['special-format'] == 'w95')	echo 'selected="selected"'; ?>><?php _e('Windows 95', $this->text_domain); ?></option>
								<option value="slt"	<?php if($this->options['special-format'] == 'slt')	echo 'selected="selected"'; ?>><?php _e('Slanting', $this->text_domain); ?></option>
								<option value="3Dr"	<?php if($this->options['special-format'] == '3Dr')	echo 'selected="selected"'; ?>><?php _e('3D Rotate', $this->text_domain); ?></option>
								<option value="pin"	<?php if($this->options['special-format'] == 'pin')	echo 'selected="selected"'; ?>><?php _e('Pushpin', $this->text_domain); ?></option>
							</select>
							<br><span style="color: #ff8844;"><?php echo __('*', $this->text_domain).' '.__('It applies over other formatting settings.', $this->text_domain); ?></span>
						</td>
					</tr>

					<tr valign="top">
						<th scope="row"><?php _e("How to (Japanese only)", $this->text_domain); ?></th>
						<td><A href="https://popozure.info/pz-linkcard" target="_blank">https://popozure.info/pz-linkcard</A></td>
					</tr>

					<tr valign="top" style="display: none;">
						<th scope="row"><?php _e("Donation", $this->text_domain); ?></th>
						<td>https://www.amazon.co.jp/gp/registry/wishlist/2KIBQLC1VLA9X</td>
					</tr>

				</table>
			</div>
			
			<div class="pz-lkc-item" id="pz-lkc-position">
				<h3><?php echo __('Position settings', $this->text_domain).'<a href="https://popozure.info/pz-linkcard-settings-position" target="_blank"><img src="'.$this->plugin_dir_url.'img/help.png" width="16" height="16" title="'.__('Help', $this->text_domain).'" alt="help"></a>'; ?></h3>
				<table class="form-table">
					<tr valign="top">
						<th scope="row"><?php _e('Use blockquote tag', $this->text_domain); ?></th>
						<td><label><input name="properties[blockquote]" type="checkbox" id="check" value="1" <?php checked(isset($this->options['blockquote']) ? $this->options['blockquote'] : null, 1); ?> /><?php _e('without using DIV tag, and use BLOCKQUOTE tag', $this->text_domain); ?></label></td>
					</tr>

					<tr valign="top">
						<th scope="row"><?php _e('Link the whole', $this->text_domain); ?></th>
						<td>
							<label>
								<input name="properties[link-all]" type="checkbox" id="check" value="1" <?php checked(isset($this->options['link-all']) ? $this->options['link-all'] : null, 1); ?> />
								<?php _e('Enclose the entire card at anchor', $this->text_domain); ?>
							</label>
						</td>
					</tr>

					<tr valign="top">
						<th scope="row"><?php _e('Margin', $this->text_domain); ?></th>
						<td>
							<table style="border: 1px dashed #000; background-color: #eee; width: 600px;">
								<tr>
									<td>
									</td>
									<td align="center">
										<?php _e('Margin top', $this->text_domain); ?><br>
										<select name="properties[margin-top]">
											<option value="" <?php if($this->options['margin-top'] == '') echo 'selected="selected"'; ?>><?php _e('Not defined', $this->text_domain); ?></option>
											<option value="0" <?php if($this->options['margin-top'] == '0') echo 'selected="selected"'; ?>><?php _e('0', $this->text_domain); ?></option>
											<option value="4px" <?php if($this->options['margin-top'] == '4px') echo 'selected="selected"'; ?>><?php _e('4px', $this->text_domain); ?></option>
											<option value="8px" <?php if($this->options['margin-top'] == '8px') echo 'selected="selected"'; ?>><?php _e('8px', $this->text_domain); ?></option>
											<option value="16px" <?php if($this->options['margin-top'] == '16px') echo 'selected="selected"'; ?>><?php _e('16px', $this->text_domain); ?></option>
											<option value="32px" <?php if($this->options['margin-top'] == '32px') echo 'selected="selected"'; ?>><?php _e('32px', $this->text_domain); ?></option>
											<option value="40px" <?php if($this->options['margin-top'] == '40px') echo 'selected="selected"'; ?>><?php _e('40px', $this->text_domain); ?></option>
											<option value="64px" <?php if($this->options['margin-top'] == '64px') echo 'selected="selected"'; ?>><?php _e('64px', $this->text_domain); ?></option>
										</select>
									</td>
									<td></td>
								</tr>
								<tr>
									<td align="center">
										<?php _e('Margin left', $this->text_domain); ?><br>
										<select name="properties[margin-left]">
											<option value="" <?php if($this->options['margin-left'] == '') echo 'selected="selected"'; ?>><?php _e('Not defined', $this->text_domain); ?></option>
											<option value="0" <?php if($this->options['margin-left'] == '0') echo 'selected="selected"'; ?>><?php _e('0', $this->text_domain); ?></option>
											<option value="4px" <?php if($this->options['margin-left'] == '4px') echo 'selected="selected"'; ?>><?php _e('4px', $this->text_domain); ?></option>
											<option value="8px" <?php if($this->options['margin-left'] == '8px') echo 'selected="selected"'; ?>><?php _e('8px', $this->text_domain); ?></option>
											<option value="16px" <?php if($this->options['margin-left'] == '16px') echo 'selected="selected"'; ?>><?php _e('16px', $this->text_domain); ?></option>
											<option value="32px" <?php if($this->options['margin-left'] == '32px') echo 'selected="selected"'; ?>><?php _e('32px', $this->text_domain); ?></option>
											<option value="40px" <?php if($this->options['margin-left'] == '40px') echo 'selected="selected"'; ?>><?php _e('40px', $this->text_domain); ?></option>
											<option value="64px" <?php if($this->options['margin-left'] == '64px') echo 'selected="selected"'; ?>><?php _e('64px', $this->text_domain); ?></option>
										</select>
									</td>
									<td align="center" style="border: 1px solid #000; background-color: #fff;">

										<table class="form-table">
											<tr>
												<td colspan="2" align="center">
													<?php _e('Margin top', $this->text_domain); ?><br>
													<select name="properties[card-top]">
														<option value="" <?php if($this->options['card-top'] == '') echo 'selected="selected"'; ?>><?php _e('Not defined', $this->text_domain); ?></option>
														<option value="4px" <?php if($this->options['card-top'] == '4px') echo 'selected="selected"'; ?>><?php _e('4px', $this->text_domain); ?></option>
														<option value="8px" <?php if($this->options['card-top'] == '8px') echo 'selected="selected"'; ?>><?php _e('8px', $this->text_domain); ?></option>
														<option value="16px" <?php if($this->options['card-top'] == '16px') echo 'selected="selected"'; ?>><?php _e('16px', $this->text_domain); ?></option>
														<option value="24px" <?php if($this->options['card-top'] == '24px') echo 'selected="selected"'; ?>><?php _e('24px', $this->text_domain); ?></option>
														<option value="32px" <?php if($this->options['card-top'] == '32px') echo 'selected="selected"'; ?>><?php _e('32px', $this->text_domain); ?></option>
														<option value="40px" <?php if($this->options['card-top'] == '40px') echo 'selected="selected"'; ?>><?php _e('40px', $this->text_domain); ?></option>
														<option value="64px" <?php if($this->options['card-top'] == '64px') echo 'selected="selected"'; ?>><?php _e('64px', $this->text_domain); ?></option>
														<option value="0" <?php if($this->options['card-top'] == '0') echo 'selected="selected"'; ?>><?php _e('0', $this->text_domain); ?></option>
													</select>
												</td>
											</tr>
											<tr>
												<td align="center">
													<?php _e('Margin left', $this->text_domain); ?><br>
													<select name="properties[card-left]">
														<option value="" <?php if($this->options['card-left'] == '') echo 'selected="selected"'; ?>><?php _e('Not defined', $this->text_domain); ?></option>
														<option value="4px" <?php if($this->options['card-left'] == '4px') echo 'selected="selected"'; ?>><?php _e('4px', $this->text_domain); ?></option>
														<option value="8px" <?php if($this->options['card-left'] == '8px') echo 'selected="selected"'; ?>><?php _e('8px', $this->text_domain); ?></option>
														<option value="16px" <?php if($this->options['card-left'] == '16px') echo 'selected="selected"'; ?>><?php _e('16px', $this->text_domain); ?></option>
														<option value="24px" <?php if($this->options['card-left'] == '24px') echo 'selected="selected"'; ?>><?php _e('24px', $this->text_domain); ?></option>
														<option value="32px" <?php if($this->options['card-left'] == '32px') echo 'selected="selected"'; ?>><?php _e('32px', $this->text_domain); ?></option>
														<option value="40px" <?php if($this->options['card-left'] == '40px') echo 'selected="selected"'; ?>><?php _e('40px', $this->text_domain); ?></option>
														<option value="64px" <?php if($this->options['card-left'] == '64px') echo 'selected="selected"'; ?>><?php _e('64px', $this->text_domain); ?></option>
														<option value="0" <?php if($this->options['card-left'] == '0') echo 'selected="selected"'; ?>><?php _e('0', $this->text_domain); ?></option>
													</select>
												</td>
												<td align="center">
													<?php _e('Margin right', $this->text_domain); ?><br>
													<select name="properties[card-right]">
														<option value="" <?php if($this->options['card-right'] == '') echo 'selected="selected"'; ?>><?php _e('Not defined', $this->text_domain); ?></option>
														<option value="4px" <?php if($this->options['card-right'] == '4px') echo 'selected="selected"'; ?>><?php _e('4px', $this->text_domain); ?></option>
														<option value="8px" <?php if($this->options['card-right'] == '8px') echo 'selected="selected"'; ?>><?php _e('8px', $this->text_domain); ?></option>
														<option value="16px" <?php if($this->options['card-right'] == '16px') echo 'selected="selected"'; ?>><?php _e('16px', $this->text_domain); ?></option>
														<option value="24px" <?php if($this->options['card-right'] == '24px') echo 'selected="selected"'; ?>><?php _e('24px', $this->text_domain); ?></option>
														<option value="32px" <?php if($this->options['card-right'] == '32px') echo 'selected="selected"'; ?>><?php _e('32px', $this->text_domain); ?></option>
														<option value="40px" <?php if($this->options['card-right'] == '40px') echo 'selected="selected"'; ?>><?php _e('40px', $this->text_domain); ?></option>
														<option value="64px" <?php if($this->options['card-right'] == '64px') echo 'selected="selected"'; ?>><?php _e('64px', $this->text_domain); ?></option>
														<option value="0" <?php if($this->options['card-right'] == '0') echo 'selected="selected"'; ?>><?php _e('0', $this->text_domain); ?></option>
													</select>
												</td>
											</tr>
											<tr>
												<td colspan="2" align="center">
													<?php _e('Width', $this->text_domain); ?><input name="properties[width]" type="text" id="inputtext" value="<?php echo esc_attr($this->options['width']); ?>" style="width: 80px;" /><br>
													<?php _e('Height', $this->text_domain); ?><input name="properties[content-height]" type="text" id="inputtext" value="<?php echo esc_attr($this->options['content-height']); ?>" style="width: 80px;" /><br>
												</td>
											</tr>
											<tr>
												<td colspan="2" align="center">
													<?php _e('Margin bottom', $this->text_domain); ?><br>
													<select name="properties[card-bottom]">
														<option value="" <?php if($this->options['card-bottom'] == '') echo 'selected="selected"'; ?>><?php _e('Not defined', $this->text_domain); ?></option>
														<option value="4px" <?php if($this->options['card-bottom'] == '4px') echo 'selected="selected"'; ?>><?php _e('4px', $this->text_domain); ?></option>
														<option value="8px" <?php if($this->options['card-bottom'] == '8px') echo 'selected="selected"'; ?>><?php _e('8px', $this->text_domain); ?></option>
														<option value="16px" <?php if($this->options['card-bottom'] == '16px') echo 'selected="selected"'; ?>><?php _e('16px', $this->text_domain); ?></option>
														<option value="24px" <?php if($this->options['card-bottom'] == '24px') echo 'selected="selected"'; ?>><?php _e('24px', $this->text_domain); ?></option>
														<option value="32px" <?php if($this->options['card-bottom'] == '32px') echo 'selected="selected"'; ?>><?php _e('32px', $this->text_domain); ?></option>
														<option value="40px" <?php if($this->options['card-bottom'] == '40px') echo 'selected="selected"'; ?>><?php _e('40px', $this->text_domain); ?></option>
														<option value="64px" <?php if($this->options['card-bottom'] == '64px') echo 'selected="selected"'; ?>><?php _e('64px', $this->text_domain); ?></option>
														<option value="0" <?php if($this->options['card-bottom'] == '0') echo 'selected="selected"'; ?>><?php _e('0', $this->text_domain); ?></option>
													</select>
												</td>
											</tr>
										</table>

									</td>
									<td align="center">
										<?php _e('Margin right', $this->text_domain); ?><br>
										<select name="properties[margin-right]">
											<option value="" <?php if($this->options['margin-right'] == '') echo 'selected="selected"'; ?>><?php _e('Not defined', $this->text_domain); ?></option>
											<option value="0" <?php if($this->options['margin-right'] == '0') echo 'selected="selected"'; ?>><?php _e('0', $this->text_domain); ?></option>
											<option value="4px" <?php if($this->options['margin-right'] == '4px') echo 'selected="selected"'; ?>><?php _e('4px', $this->text_domain); ?></option>
											<option value="8px" <?php if($this->options['margin-right'] == '8px') echo 'selected="selected"'; ?>><?php _e('8px', $this->text_domain); ?></option>
											<option value="16px" <?php if($this->options['margin-right'] == '16px') echo 'selected="selected"'; ?>><?php _e('16px', $this->text_domain); ?></option>
											<option value="32px" <?php if($this->options['margin-right'] == '32px') echo 'selected="selected"'; ?>><?php _e('32px', $this->text_domain); ?></option>
											<option value="40px" <?php if($this->options['margin-right'] == '40px') echo 'selected="selected"'; ?>><?php _e('40px', $this->text_domain); ?></option>
											<option value="64px" <?php if($this->options['margin-right'] == '64px') echo 'selected="selected"'; ?>><?php _e('64px', $this->text_domain); ?></option>
										</select>
									</td>
								</tr>
								<tr>
									<td>
										<input name="properties[centering]" type="checkbox" id="check" value="1" <?php checked(isset($this->options['centering']) ? $this->options['centering'] : null, 1); ?> /><?php _e('Centering', $this->text_domain); ?>
									</td>
									<td align="center">
										<?php _e('Margin bottom', $this->text_domain); ?><br>
										<select name="properties[margin-bottom]">
											<option value="" <?php if($this->options['margin-bottom'] == '') echo 'selected="selected"'; ?>><?php _e('Not defined', $this->text_domain); ?></option>
											<option value="0" <?php if($this->options['margin-bottom'] == '0') echo 'selected="selected"'; ?>><?php _e('0', $this->text_domain); ?></option>
											<option value="4px" <?php if($this->options['margin-bottom'] == '4px') echo 'selected="selected"'; ?>><?php _e('4px', $this->text_domain); ?></option>
											<option value="8px" <?php if($this->options['margin-bottom'] == '8px') echo 'selected="selected"'; ?>><?php _e('8px', $this->text_domain); ?></option>
											<option value="16px" <?php if($this->options['margin-bottom'] == '16px') echo 'selected="selected"'; ?>><?php _e('16px', $this->text_domain); ?></option>
											<option value="32px" <?php if($this->options['margin-bottom'] == '32px') echo 'selected="selected"'; ?>><?php _e('32px', $this->text_domain); ?></option>
											<option value="40px" <?php if($this->options['margin-bottom'] == '40px') echo 'selected="selected"'; ?>><?php _e('40px', $this->text_domain); ?></option>
											<option value="64px" <?php if($this->options['margin-bottom'] == '64px') echo 'selected="selected"'; ?>><?php _e('64px', $this->text_domain); ?></option>
										</select>
									</td>
									<td>
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</div>
			
			<div class="pz-lkc-item" id="pz-lkc-display">
				<h3><?php echo __('Display settings', $this->text_domain).'<a href="https://popozure.info/pz-linkcard-settings-display" target="_blank"><img src="'.$this->plugin_dir_url.'img/help.png" width="16" height="16" title="'.__('Help', $this->text_domain).'" alt="help"></a>'; ?></h3>
				<table class="form-table">
					<tr>
						<th scope="row"><?php _e('Layout', $this->text_domain); ?></th>
						<td>
							
							<table style="border: 1px solid #000; background-color: #fff; width: 500px;">
								<tr>
									<td colspan="2">
										<?php _e('Site information', $this->text_domain); ?>
										<select name="properties[info-position]">
											<option value=""  <?php if($this->options['info-position'] == '')  echo 'selected="selected"'; ?>><?php _e('None',				$this->text_domain); ?></option>
											<option value="1" <?php if($this->options['info-position'] == '1') echo 'selected="selected"'; ?>><?php _e('Top',				$this->text_domain); ?></option>
											<option value="3" <?php if($this->options['info-position'] == '3') echo 'selected="selected"'; ?>><?php _e('Above the title',	$this->text_domain); ?></option>
											<option value="2" <?php if($this->options['info-position'] == '2') echo 'selected="selected"'; ?>><?php _e('Bottom',			$this->text_domain); ?></option>
										</select>
										<label><input name="properties[use-sitename]" type="checkbox" id="check" value="1" <?php checked(isset($this->options['use-sitename']) ? $this->options['use-sitename'] : null, 1); ?> /><?php _e('Use SiteName', $this->text_domain); ?></label>
									</td>
								</tr>
								<tr>
									<td>
										<label><input name="properties[display-date]" type="checkbox" id="check" value="1" <?php checked(isset($this->options['display-date']) ? $this->options['display-date'] : null, 1); ?> /><?php _e('For internal links, display the posting date', $this->text_domain); ?></label>
									</td>
									<td>
									</td>
								</tr>
								<tr>
									<td>
										<label><input name="properties[heading]" type="checkbox" id="check" value="1" <?php checked(isset($this->options['heading']) ? $this->options['heading'] : null, 1); ?> /><?php _e('Make additional information heading display', $this->text_domain); ?></label>
									</td>
									<td>
									</td>
								</tr>
								<tr>
									<td>
										<label><input name="properties[flg-anker]" type="checkbox" id="check" value="1" <?php checked(isset($this->options['flg-anker']) ? $this->options['flg-anker'] : null, 1); ?> /><?php _e('Turn off the anchor text underlining', $this->text_domain); ?></label>
									</td>
									<td>
									</td>
								</tr>
								<tr>
									<td>
										<label><input name="properties[separator]" type="checkbox" id="check" value="1" <?php checked(isset($this->options['separator']) ? $this->options['separator'] : null, 1); ?> /><?php _e('Separator line', $this->text_domain); ?></label>
									</td>
									<td>
									</td>
								</tr>
								<tr>
									<td>
										<label>
											<?php _e('Display URL', $this->text_domain); ?>
											<select name="properties[display-url]">
												<option value=""  <?php if($this->options['display-url'] == '')  echo 'selected="selected"'; ?>><?php _e('None',		$this->text_domain); ?></option>
												<option value="1" <?php if($this->options['display-url'] == '1') echo 'selected="selected"'; ?>><?php _e('Under title',		$this->text_domain); ?></option>
												<option value="2" <?php if($this->options['display-url'] == '2') echo 'selected="selected"'; ?>><?php _e('Bihind site-info',		$this->text_domain); ?></option>
											</select>
										</label>
									</td>
									<td rowspan="3" style="border: 1px solid #000;">
										<?php _e('Thumbnail', $this->text_domain); ?>
										<select name="properties[thumbnail-position]">
											<option value="0" <?php if($this->options['thumbnail-position'] == '0') echo 'selected="selected"'; ?>><?php _e('None',		$this->text_domain); ?></option>
											<option value="1" <?php if($this->options['thumbnail-position'] == '1') echo 'selected="selected"'; ?>><?php _e('Right',	$this->text_domain); ?></option>
											<option value="2" <?php if($this->options['thumbnail-position'] == '2') echo 'selected="selected"'; ?>><?php _e('Left',		$this->text_domain); ?></option>
											<option value="3" <?php if($this->options['thumbnail-position'] == '3') echo 'selected="selected"'; ?>><?php _e('Upper',	$this->text_domain); ?></option>
										</select>
										<br>
										<?php _e('Width', $this->text_domain); ?><input name="properties[thumbnail-width]"		type="text" id="inputtext" value="<?php echo (isset($this->options['thumbnail-width']) ? $this->options['thumbnail-width'] : $this->defaults['thumbnail-width']); ?>" style="width: 4em;" />
										<br>
										<?php _e('Height', $this->text_domain); ?><input name="properties[thumbnail-height]"	type="text" id="inputtext" value="<?php echo (isset($this->options['thumbnail-height']) ? $this->options['thumbnail-height'] : $this->defaults['thumbnail-height']); ?>" style="width: 4em;" />
										<br>
										<label><input name="properties[thumbnail-shadow]" type="checkbox" id="check" value="1" <?php checked(isset($this->options['thumbnail-shadow']) ? $this->options['thumbnail-shadow'] : null, 1); ?> /><?php _e('Shadow', $this->text_domain); ?></label>
									</td>
								</tr>
								<tr>
									<td>
										<label><input name="properties[content-inset]" type="checkbox" id="check" value="1" <?php checked(isset($this->options['content-inset']) ? $this->options['content-inset'] : null, 1); ?> /><?php _e('Hollow content area', $this->text_domain); ?></label>
									</td>
								</tr>
								<tr>
									<td>
										<label><input name="properties[display-excerpt]" type="checkbox" id="check" value="1" <?php checked(isset($this->options['display-excerpt']) ? $this->options['display-excerpt'] : null, 1); ?> /><?php _e('Display excerpt', $this->text_domain); ?></label>
									</td>
								</tr>
								<tr>
									<td>
										<label><input name="properties[shadow-inset]" type="checkbox" id="check" value="1" <?php checked(isset($this->options['shadow-inset']) ? $this->options['shadow-inset'] : null, 1); ?> /><?php _e('Hollow', $this->text_domain); ?></label>
									</td>
									<td>
									</td>
								</tr>
								<tr>
									<td>
										<label><input name="properties[shadow]" type="checkbox" id="check" value="1" <?php checked(isset($this->options['shadow']) ? $this->options['shadow'] : null, 1); ?> /><?php _e('Shadow', $this->text_domain); ?></label></td>
									</td>
								</tr>
								<tr>
									<td>
										<?php _e('Round a square', $this->text_domain); ?>
										<select name="properties[radius]">
											<option value=""  <?php if($this->options['radius'] == '')  echo 'selected="selected"'; ?>><?php _e('None',		$this->text_domain); ?></option>
											<option value="2" <?php if($this->options['radius'] == '2') echo 'selected="selected"'; ?>><?php _e('4px',		$this->text_domain); ?></option>
											<option value="1" <?php if($this->options['radius'] == '1') echo 'selected="selected"'; ?>><?php _e('8px',		$this->text_domain); ?></option>
											<option value="3" <?php if($this->options['radius'] == '3') echo 'selected="selected"'; ?>><?php _e('16px',		$this->text_domain); ?></option>
											<option value="4" <?php if($this->options['radius'] == '4') echo 'selected="selected"'; ?>><?php _e('32px',		$this->text_domain); ?></option>
											<option value="5" <?php if($this->options['radius'] == '5') echo 'selected="selected"'; ?>><?php _e('64px',		$this->text_domain); ?></option>
										</select>
									</td>
								</tr>
								<tr>
									<td>
										<label>
											<?php _e('When the mouse is on', $this->text_domain); ?>
											<select name="properties[hover]">
												<option value=""  <?php if($this->options['hover'] == '')  echo 'selected="selected"'; ?>><?php _e('None',			$this->text_domain); ?></option>
												<option value="1" <?php if($this->options['hover'] == '1') echo 'selected="selected"'; ?>><?php _e('Lighten',		$this->text_domain); ?></option>
												<option value="2" <?php if($this->options['hover'] == '2') echo 'selected="selected"'; ?>><?php _e('Hover (light)',	$this->text_domain); ?></option>
												<option value="3" <?php if($this->options['hover'] == '3') echo 'selected="selected"'; ?>><?php _e('Hover (dark)',	$this->text_domain); ?></option>
												<option value="7" <?php if($this->options['hover'] == '7') echo 'selected="selected"'; ?>><?php _e('Radius',		$this->text_domain); ?></option>
											</select>
										</label>
									</td>
								</tr>
							</table>
						</td>
					</tr>

					<tr>
						<th scope="row"><?php _e('Border', $this->text_domain); ?></th>
						<td>
							<select name="properties[border-style]">
								<option value="none"	<?php if ($this->options['border-style'] == 'none')		echo 'selected="selected"'; ?>><?php _e('none',		$this->text_domain); ?></option>
								<option value="solid"	<?php if ($this->options['border-style'] == 'solid')	echo 'selected="selected"'; ?>><?php _e('solid',	$this->text_domain); ?></option>
								<option value="dotted"	<?php if ($this->options['border-style'] == 'dotted')	echo 'selected="selected"'; ?>><?php _e('dotted',	$this->text_domain); ?></option>
								<option value="dashed"	<?php if ($this->options['border-style'] == 'dashed')	echo 'selected="selected"'; ?>><?php _e('dashed',	$this->text_domain); ?></option>
								<option value="double"	<?php if ($this->options['border-style'] == 'double')	echo 'selected="selected"'; ?>><?php _e('double',	$this->text_domain); ?></option>
								<option value="groove"	<?php if ($this->options['border-style'] == 'groove')	echo 'selected="selected"'; ?>><?php _e('groove',	$this->text_domain); ?></option>
								<option value="ridge"	<?php if ($this->options['border-style'] == 'ridge')	echo 'selected="selected"'; ?>><?php _e('ridge',	$this->text_domain); ?></option>
								<option value="inset"	<?php if ($this->options['border-style'] == 'inset')	echo 'selected="selected"'; ?>><?php _e('inset',	$this->text_domain); ?></option>
								<option value="outset"	<?php if ($this->options['border-style'] == 'outset')	echo 'selected="selected"'; ?>><?php _e('outset',	$this->text_domain); ?></option>
							</select>
							&nbsp;<?php _e('Width', $this->text_domain); ?><input name="properties[border-width]"		type="text" id="inputtext" value="<?php echo $this->options['border-width']; ?>" style="width: 4em;" />
						</td>
					</tr>

					<tr valign="top">
						<th scope="row"><?php _e('Reset img style', $this->text_domain); ?></th>
						<td><label><input name="properties[style-reset-img]" type="checkbox" id="check" value="1" <?php checked(isset($this->options['style-reset-img']) ? $this->options['style-reset-img'] : null, 1); ?> /><?php _e('When unnecessary frame is displayed on the image, you can improve it by case', $this->text_domain); ?></label></td>
					</tr>

					<tr valign="top">
						<th scope="row"><?php _e('More button', $this->text_domain); ?></th>
						<td>
							<select name="properties[flg-more]">
								<option value=""  <?php if($this->options['flg-more'] == '')  echo 'selected="selected"'; ?>><?php _e('None', $this->text_domain); ?></option>
								<option value="1" <?php if($this->options['flg-more'] == '1') echo 'selected="selected"'; ?>><?php _e('Text link', $this->text_domain); ?></option>
								<option value="2" <?php if($this->options['flg-more'] == '2') echo 'selected="selected"'; ?>><?php _e('Simple button', $this->text_domain); ?></option>
								<option value="3" <?php if($this->options['flg-more'] == '3') echo 'selected="selected"'; ?>><?php _e('Blue', $this->text_domain); ?></option>
								<option value="4" <?php if($this->options['flg-more'] == '4') echo 'selected="selected"'; ?>><?php _e('Dark', $this->text_domain); ?></option>
							</select>
							<p><?php _e('*', $this->text_domain); ?> <?php _e('It is recommended that you leave the card height blank when using this setting.', $this->text_domain); ?></p>
						</td>
					</tr>
				</table>
			</div>
			
			<div class="pz-lkc-item" id="pz-lkc-letter">
				<h3><?php echo __('Letter settings', $this->text_domain).'<a href="https://popozure.info/pz-linkcard-settings-letter" target="_blank"><img src="'.$this->plugin_dir_url.'img/help.png" width="16" height="16" title="'.__('Help', $this->text_domain).'" alt="help"></a>'; ?></h3>
				<table class="form-table" style="max-width: 900px;">

					<tr valign="top">
						<th scope="row"><?php _e('Title', $this->text_domain); ?></th>
						<td>
							<?php _e('Color', $this->text_domain); ?><input name="properties[color-title]" type="text" class="color-picker" id="pickedcolor" value="<?php		echo esc_attr($this->options['color-title']); ?>" />
							<label><input name="properties[outline-title]" type="checkbox" id="check" value="1" <?php checked(isset($this->options['outline-title']) ? $this->options['outline-title'] : null, 1); ?> /><?php _e('Outline', $this->text_domain); ?></label>
							<input name="properties[outline-color-title]" type="text" class="color-picker" id="pickedcolor" value="<?php	echo esc_attr((isset($this->options['outline-color-title']) ? $this->options['outline-color-title'] : $this->defaults['outline-color-title'])); ?>" />
						</td>
						<td>
							<?php _e('Size',		$this->text_domain); ?><input name="properties[size-title]"		type="text" id="inputtext" value="<?php echo (isset($this->options['size-title']) ? $this->options['size-title'] : $this->defaults['size-title']); ?>" style="width: 4em;" />
						</td>
						<td>
							<?php _e('Height',	$this->text_domain); ?><input name="properties[height-title]"	type="text" id="inputtext" value="<?php echo (isset($this->options['height-title']) ? $this->options['height-title'] : $this->defaults['height-title']); ?>" style="width: 4em;" />
						</td>
						<td>
							<?php _e('Length', $this->text_domain); ?><input name="properties[trim-title]" type="text" id="inputtext" value="<?php echo (isset($this->options['trim-title']) ? $this->options['trim-title'] : $this->defaults['trim-title']); ?>" style="width: 3em;" />
							<br><label><input name="properties[nowrap-title]" type="checkbox" id="check" value="1" <?php checked(isset($this->options['nowrap-title']) ? $this->options['nowrap-title'] : null, 1); ?> /><?php _e('No wrap', $this->text_domain); ?></label>
						</td>
					</tr>

					<tr valign="top">
						<th scope="row"><?php _e('URL', $this->text_domain); ?></th>
						<td>
							<?php _e('Color', $this->text_domain); ?><input name="properties[color-url]" type="text" class="color-picker" id="pickedcolor" value="<?php		echo esc_attr($this->options['color-url']); ?>" />
							<label><input name="properties[outline-url]" type="checkbox" id="check" value="1" <?php checked(isset($this->options['outline-url']) ? $this->options['outline-url'] : null, 1); ?> /><?php _e('Outline', $this->text_domain); ?></label>
							<input name="properties[outline-color-url]" type="text" class="color-picker" id="pickedcolor" value="<?php	echo esc_attr((isset($this->options['outline-color-url']) ? $this->options['outline-color-url'] : $this->defaults['outline-color-url'])); ?>" />
						</td>
						<td>
							<?php _e('Size',		$this->text_domain); ?><input name="properties[size-url]"		type="text" id="inputtext" value="<?php echo (isset($this->options['size-url']) ? $this->options['size-url'] : $this->defaults['size-url']); ?>" style="width: 4em;" />
						</td>
						<td>
							<?php _e('Height',	$this->text_domain); ?><input name="properties[height-url]"	type="text" id="inputtext" value="<?php echo (isset($this->options['height-url']) ? $this->options['height-url'] : $this->defaults['height-url']); ?>" style="width: 4em;" />
						</td>
						<td>
							<?php _e('Length', $this->text_domain); ?><input name="properties[trim-url]" type="text" id="inputtext" value="<?php echo (isset($this->options['trim-url']) ? $this->options['trim-url'] : $this->defaults['trim-url']); ?>" style="width: 3em;" />
							<br><label><input name="properties[nowrap-url]" type="checkbox" id="check" value="1" <?php checked(isset($this->options['nowrap-url']) ? $this->options['nowrap-url'] : null, 1); ?> /><?php _e('No wrap', $this->text_domain); ?></label>
						</td>
					</tr>

					<tr valign="top">
						<th scope="row"><?php _e('Excerpt', $this->text_domain); ?></th>
						<td>
							<?php _e('Color', $this->text_domain); ?><input name="properties[color-excerpt]" type="text" class="color-picker" id="pickedcolor" value="<?php	echo esc_attr($this->options['color-excerpt']); ?>" />
							<label><input name="properties[outline-excerpt]" type="checkbox" id="check" value="1" <?php checked(isset($this->options['outline-excerpt']) ? $this->options['outline-excerpt'] : null, 1); ?> /><?php _e('Outline', $this->text_domain); ?></label>
							<input name="properties[outline-color-excerpt]" type="text" class="color-picker" id="pickedcolor" value="<?php	echo esc_attr((isset($this->options['outline-color-excerpt']) ? $this->options['outline-color-excerpt'] : $this->defaults['outline-color-excerpt'])); ?>" />
						</td>
						<td>
							<?php _e('Size',		$this->text_domain); ?><input name="properties[size-excerpt]"		type="text" id="inputtext" value="<?php echo (isset($this->options['size-excerpt']) ? $this->options['size-excerpt'] : $this->defaults['size-excerpt']); ?>" style="width: 4em;" />
						</td>
						<td>
							<?php _e('Height',	$this->text_domain); ?><input name="properties[height-excerpt]"	type="text" id="inputtext" value="<?php echo (isset($this->options['height-excerpt']) ? $this->options['height-excerpt'] : $this->defaults['height-excerpt']); ?>" style="width: 4em;" />
						</td>
						<td>
							&nbsp;<?php _e('Length', $this->text_domain); ?><input name="properties[trim-count]" type="text" id="inputtext" value="<?php echo (isset($this->options['trim-count']) ? $this->options['trim-count'] : $this->defaults['trim-sount']); ?>" style="width: 3em;" />
						</td>
					</tr>

					<tr valign="top">
						<th scope="row"><?php _e('More button', $this->text_domain); ?></th>
						<td>
							<?php _e('Color', $this->text_domain); ?><input name="properties[color-more]" type="text" class="color-picker" id="pickedcolor" value="<?php		echo esc_attr($this->options['color-more']); ?>" />
							<label><input name="properties[outline-more]" type="checkbox" id="check" value="1" <?php checked(isset($this->options['outline-more']) ? $this->options['outline-more'] : null, 1); ?> /><?php _e('Outline', $this->text_domain); ?></label>
							<input name="properties[outline-color-more]" type="text" class="color-picker" id="pickedcolor" value="<?php	echo esc_attr((isset($this->options['outline-color-more']) ? $this->options['outline-color-more'] : $this->defaults['outline-color-more'])); ?>" />
						</td>
						<td>
							<?php _e('Size',		$this->text_domain); ?><input name="properties[size-more]"		type="text" id="inputtext" value="<?php echo (isset($this->options['size-more']) ? $this->options['size-more'] : $this->defaults['size-more']); ?>" style="width: 4em;" />
						</td>
						<td>
							<?php _e('Height',	$this->text_domain); ?><input name="properties[height-more]"	type="text" id="inputtext" value="<?php echo (isset($this->options['height-more']) ? $this->options['height-more'] : $this->defaults['height-more']); ?>" style="width: 4em;" />
						</td>
						<td>
						</td>
					</tr>

					<tr valign="top">
						<th scope="row"><?php _e('Site information', $this->text_domain); ?></th>
						<td>
							<?php _e('Color', $this->text_domain); ?><input name="properties[color-info]" type="text" class="color-picker" id="pickedcolor" value="<?php		echo esc_attr($this->options['color-info']); ?>" />
							<label><input name="properties[outline-info]" type="checkbox" id="check" value="1" <?php checked(isset($this->options['outline-info']) ? $this->options['outline-info'] : null, 1); ?> /><?php _e('Outline', $this->text_domain); ?></label>
							<input name="properties[outline-color-info]" type="text" class="color-picker" id="pickedcolor" value="<?php	echo esc_attr((isset($this->options['outline-color-info']) ? $this->options['outline-color-info'] : $this->defaults['outline-color-info'])); ?>" />
						</td>
						<td>
							<?php _e('Size',		$this->text_domain); ?><input name="properties[size-info]"		type="text" id="inputtext" value="<?php echo (isset($this->options['size-info']) ? $this->options['size-info'] : $this->defaults['size-info']); ?>" style="width: 4em;" />
						</td>
						<td>
							<?php _e('Height',	$this->text_domain); ?><input name="properties[height-info]"	type="text" id="inputtext" value="<?php echo (isset($this->options['height-info']) ? $this->options['height-info'] : $this->defaults['height-info']); ?>" style="width: 4em;" />
						</td>
						<td>
							<?php _e('Length', $this->text_domain); ?><input name="properties[trim-sitename]" type="text" id="inputtext" value="<?php echo (isset($this->options['trim-sitename']) ? $this->options['trim-sitename'] : $this->defaults['trim-sitename']); ?>" style="width: 3em;" />
						</td>
					</tr>

					<tr valign="top">
						<th scope="row"><?php _e('Added information', $this->text_domain); ?></th>
						<td>
							<?php _e('Color', $this->text_domain); ?><input name="properties[color-added]" type="text" class="color-picker" id="pickedcolor" value="<?php		echo esc_attr($this->options['color-added']); ?>" />
							<label><input name="properties[outline-added]" type="checkbox" id="check" value="1" <?php checked(isset($this->options['outline-added']) ? $this->options['outline-added'] : null, 1); ?> /><?php _e('Outline', $this->text_domain); ?></label>
							<input name="properties[outline-color-added]" type="text" class="color-picker" id="pickedcolor" value="<?php	echo esc_attr((isset($this->options['outline-color-added']) ? $this->options['outline-color-added'] : $this->defaults['outline-color-added'])); ?>" />
						</td>
						<td>
							<?php _e('Size',	$this->text_domain); ?><input name="properties[size-added]"		type="text" id="inputtext" value="<?php echo (isset($this->options['size-added']) ? $this->options['size-added'] : $this->defaults['size-added']); ?>" style="width: 4em;" />
						</td>
						<td>
							<?php _e('Height',	$this->text_domain); ?><input name="properties[height-added]"	type="text" id="inputtext" value="<?php echo (isset($this->options['height-added']) ? $this->options['height-added'] : $this->defaults['height-added']); ?>" style="width: 4em;" />
						</td>
					</tr>

					<tr valign="top">
						<th scope="row"><?php _e('Resize', $this->text_domain); ?></th>
						<td colspan="4"><label><input name="properties[thumbnail-resize]" type="checkbox" id="check" value="1" <?php checked(isset($this->options['thumbnail-resize']) ? $this->options['thumbnail-resize'] : null, 1); ?> /><?php _e('Adjust thumbnail and letter size according to width', $this->text_domain); ?></label></td>
					</tr>

				</table>
			</div>
			
			<div class="pz-lkc-item" id="pz-lkc-external">
				<h3><?php echo __('External link settings', $this->text_domain).'<a href="https://popozure.info/pz-linkcard-settings-external-link" target="_blank"><img src="'.$this->plugin_dir_url.'img/help.png" width="16" height="16" title="'.__('Help', $this->text_domain).'" alt="help"></a>'; ?></h3>
				<table class="form-table">

					<tr valign="top">
						<th scope="row"><?php _e('Border Color', $this->text_domain); ?></th>
						<td><input name="properties[ex-border-color]" type="text" class="color-picker" id="pickedcolor" value="<?php echo esc_attr($this->options['ex-border-color']); ?>" /></td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php _e('Background Color', $this->text_domain); ?></th>
						<td><input name="properties[ex-bgcolor]" type="text" class="color-picker" id="pickedcolor" value="<?php echo esc_attr($this->options['ex-bgcolor']); ?>" /></td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php _e('Background image', $this->text_domain); ?></th>
						<td><input name="properties[ex-image]" type="text" id="inputtext" value="<?php echo esc_attr($this->options['ex-image']); ?>" size="80" /></td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php _e('Thumbnail', $this->text_domain); ?></th>
						<td>
							<select name="properties[ex-thumbnail]">
								<option value="" <?php if($this->options['ex-thumbnail'] == '') echo 'selected="selected"'; ?>><?php _e('None', $this->text_domain); ?></option>
								<option value="1" <?php if($this->options['ex-thumbnail'] == '1') echo 'selected="selected"'; ?>><?php _e('Direct', $this->text_domain); ?></option>
							</select>

						</td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php _e('Added information', $this->text_domain); ?></th>
						<td><input name="properties[ex-info]" type="text" id="inputtext" value="<?php echo esc_attr($this->options['ex-info']); ?>" class="regular-text" /></td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php _e('Text of more button', $this->text_domain); ?></th>
						<td><input name="properties[ex-more-text]" type="text" id="inputtext" value="<?php echo esc_attr($this->options['ex-more-text']); ?>" class="regular-text" /></td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php _e('Open new window/tab', $this->text_domain); ?></th>
						<td>
							<select name="properties[ex-target]">
								<option value=""  <?php if($this->options['ex-target'] == '')  echo 'selected="selected"'; ?>><?php _e('None', $this->text_domain); ?></option>
								<option value="1" <?php if($this->options['ex-target'] == '1') echo 'selected="selected"'; ?>><?php _e('All client', $this->text_domain); ?></option>
								<option value="2" <?php if($this->options['ex-target'] == '2') echo 'selected="selected"'; ?>><?php _e('Other than mobile', $this->text_domain); ?></option>
							</select>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php _e('Get contents', $this->text_domain); ?></th>
						<td>
							<?php _e('Initially acquired only from the content', $this->text_domain); ?>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php _e('Set nofollow', $this->text_domain); ?></th>
						<td><label><input name="properties[nofollow]" type="checkbox" id="check" value="1" <?php checked(isset($this->options['nofollow']) ? $this->options['nofollow'] : null, 1); ?> /><?php _e('In the case of an external site, it puts the "nofollow"', $this->text_domain); ?></label></td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php _e('Use HatenaBlogCard', $this->text_domain); ?></th>
						<td><label><input name="properties[use-hatena]" type="checkbox" id="check" value="1" <?php checked(isset($this->options['use-hatena']) ? $this->options['use-hatena'] : null, 1); ?> /><?php _e('External links will use Always HatenaBlogCard.', $this->text_domain); _e('(Not recommended)', $this->text_domain); ?></label></td>
					</tr>
				</table>
			</div>
			
			<div class="pz-lkc-item" id="pz-lkc-internal">
				<h3><?php echo __('Internal link settings', $this->text_domain).'<a href="https://popozure.info/pz-linkcard-settings-internal-link" target="_blank"><img src="'.$this->plugin_dir_url.'img/help.png" width="16" height="16" title="'.__('Help', $this->text_domain).'" alt="help"></a>'; ?></h3>
				<table class="form-table">
					<tr valign="top">
						<th scope="row"><?php _e('Border Color', $this->text_domain); ?></th>
						<td><input name="properties[in-border-color]" type="text" class="color-picker" id="pickedcolor" value="<?php echo esc_attr($this->options['in-border-color']); ?>" /></td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php _e('Background Color', $this->text_domain); ?></th>
						<td><input name="properties[in-bgcolor]" type="text" class="color-picker" id="pickedcolor" value="<?php echo esc_attr($this->options['in-bgcolor']); ?>" /></td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php _e('Background Image', $this->text_domain); ?></th>
						<td><input name="properties[in-image]" type="text" id="inputtext" value="<?php echo esc_attr($this->options['in-image']); ?>" size="80" /></td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php _e('Thumbnail', $this->text_domain); ?></th>
						<td>
							<select name="properties[in-thumbnail]">
								<option value=""  <?php if($this->options['in-thumbnail'] == '') echo 'selected="selected"'; ?>><?php _e('None', $this->text_domain); ?></option>
								<option value="1" <?php if($this->options['in-thumbnail'] == '1') echo 'selected="selected"'; ?>><?php _e('Direct', $this->text_domain); ?></option>
							</select>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php _e('Added information', $this->text_domain); ?></th>
						<td><input name="properties[in-info]" type="text" id="inputtext" value="<?php echo esc_attr($this->options['in-info']); ?>" class="regular-text" /><br></td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php _e('Text of more button', $this->text_domain); ?></th>
						<td><input name="properties[in-more-text]" type="text" id="inputtext" value="<?php echo esc_attr($this->options['in-more-text']); ?>" class="regular-text" /></td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php _e('Open new window/tab', $this->text_domain); ?></th>
						<td>
							<select name="properties[in-target]">
								<option value=""  <?php if($this->options['in-target'] == '')  echo 'selected="selected"'; ?>><?php _e('None', $this->text_domain); ?></option>
								<option value="1" <?php if($this->options['in-target'] == '1') echo 'selected="selected"'; ?>><?php _e('All client', $this->text_domain); ?></option>
								<option value="2" <?php if($this->options['in-target'] == '2') echo 'selected="selected"'; ?>><?php _e('Other than mobile', $this->text_domain); ?></option>
							</select>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php _e('Get contents', $this->text_domain); ?></th>
						<td>
							<select name="properties[in-get]">
								<?php $in_data	= (isset($this->options['in-get']) ? $this->options['in-get'] : ''); ?>
								<option value=""  <?php if($in_data == '')  echo 'selected="selected"'; ?>><?php _e('Always get the latest from the content', $this->text_domain); ?></option>
								<option value="1" <?php if($in_data == '1') echo 'selected="selected"'; ?>><?php _e('Always get the latest from the excerpt', $this->text_domain); ?></option>
								<option value="2" <?php if($in_data == '2') echo 'selected="selected"'; ?>><?php _e('Initially acquired only from the content', $this->text_domain); ?></option>
							</select>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php _e('Retry get PID', $this->text_domain); ?></th>
						<td><label><input name="properties[flg-get-pid]" type="checkbox" id="check" value="1" <?php checked(isset($this->options['flg-get-pid']) ? $this->options['flg-get-pid'] : null, 1); ?> /><?php _e('When the `Post ID` can not be acquired, it is acquired again.', $this->text_domain); ?></label></td>
					</tr>
				</table>
			</div>
			
			<div class="pz-lkc-item" id="pz-lkc-samepage">
				<h3><?php echo __('Same-page link settings', $this->text_domain).'<a href="https://popozure.info/pz-linkcard-settings-same-page-link" target="_blank"><img src="'.$this->plugin_dir_url.'img/help.png" width="16" height="16" title="'.__('Help', $this->text_domain).'" alt="help"></a>'; ?></h3>
				<table class="form-table">
					<tr valign="top">
						<th scope="row"><?php _e('Border Color', $this->text_domain); ?></th>
						<td><input name="properties[th-border-color]" type="text" class="color-picker" id="pickedcolor" value="<?php echo esc_attr($this->options['th-border-color']); ?>" /></td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php _e('Background Color', $this->text_domain); ?></th>
						<td><input name="properties[th-bgcolor]" type="text" class="color-picker" id="pickedcolor" value="<?php echo esc_attr($this->options['th-bgcolor']); ?>" /></td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php _e('Background Image', $this->text_domain); ?></th>
						<td><input name="properties[th-image]" type="text" id="inputtext" value="<?php echo esc_attr($this->options['th-image']); ?>" size="80" /></td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php _e('Thumbnail', $this->text_domain); ?></th>
						<td><?php _e('It is common with setting Internal-link', $this->text_domain); ?></td>
					</re>
					<tr valign="top">
						<th scope="row"><?php _e('Favicon', $this->text_domain); ?></th>
						<td><?php _e('It is common with setting Internal-link', $this->text_domain); ?></td>
					</re>
					<tr valign="top">
						<th scope="row"><?php _e('Added information', $this->text_domain); ?></th>
						<td><input name="properties[th-info]" type="text" id="inputtext" value="<?php echo esc_attr($this->options['th-info']); ?>" class="regular-text" /></td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php _e('Text of more button', $this->text_domain); ?></th>
						<td><?php _e('Cannot set', $this->text_domain); ?></td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php _e('Open new window/tab', $this->text_domain); ?></th>
						<td><?php _e('It is common with setting Internal-link', $this->text_domain); ?></td>
					</re>
					<tr valign="top">
						<th scope="row"><?php _e('Get contents', $this->text_domain); ?></th>
						<td><?php _e('It is common with setting Internal-link', $this->text_domain); ?></td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php _e('Retry get PID', $this->text_domain); ?></th>
						<td><?php _e('It is common with setting Internal-link', $this->text_domain); ?></td>
					</tr>
				</table>
			</div>
			
			<div class="pz-lkc-item" id="pz-lkc-editor">
				<h3><?php echo __('Editor settings', $this->text_domain).'<a href="https://popozure.info/pz-linkcard-settings-editor" target="_blank"><img src="'.$this->plugin_dir_url.'img/help.png" width="16" height="16" title="'.__('Help', $this->text_domain).'" alt="help"></a>'; ?></h3>
				<table class="form-table">
					<tr valign="top">
						<th scope="row"><?php _e('ShortCode 1', $this->text_domain); ?></th>
						<td>[<input name="properties[code1]" type="text" id="code1" value="<?php echo esc_attr($this->options['code1']); ?>" class="regular-text" style="width: 8em;" onKeyUp="document.getElementById('open1').innerText = document.getElementById('code1').value; document.getElementById('close1').innerText = document.getElementById('code1').value; document.getElementById('open2').innerText = document.getElementById('code1').value;" /> url="http://xxx" <span style="color: #aabbff; font-weight: bold;">title=</span><span style="color: #aabbff;">"xxxxxx"</span> <span style="color: #bbaaff; font-weight: bold;">content=</span><span style="color: #bbaaff;">"xxxxxx"</span>]
							<p><?php _e('Case-sensitive', $this->text_domain); ?></p></td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php _e('Use inlinetext', $this->text_domain); ?></th>
						<td>
							[<span style="color: #888888;" id="open1"><?php echo esc_attr($this->options['code1']); ?></span> url="http://xxx"]
							<select name="properties[use-inline]">
								<option value=""	<?php if($this->options['use-inline'] == '')  echo 'selected="selected"'; ?>><?php _e('No use', $this->text_domain); ?></option>
								<option value="1"	<?php if($this->options['use-inline'] == '1') echo 'selected="selected"'; ?>><?php _e('Use to excerpt', $this->text_domain); ?></option>
								<option value="2"	<?php if($this->options['use-inline'] == '2') echo 'selected="selected"'; ?>><?php _e('Use to title', $this->text_domain); ?></option>
							</select>
							[/<span style="color: #888888;" id="close1"><?php echo esc_attr($this->options['code1']); ?></span>]
							<p><?php _e('This setting applies only to the Shortcode1', $this->text_domain); ?></p></td>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php _e('ShortCode 2', $this->text_domain); ?></th>
						<td>[<input name="properties[code2]" type="text" id="inputtext" value="<?php echo esc_attr($this->options['code2']); ?>" class="regular-text" style="width: 8em;" /> url="http://xxx" <span style="color: #aabbff; font-weight: bold;">title=</span><span style="color: #aabbff;">"xxxxxx"</span> <span style="color: #bbaaff; font-weight: bold;">content=</span><span style="color: #bbaaff;">"xxxxxx"</span>]
							<p><?php _e('Case-sensitive', $this->text_domain); ?></p></td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php _e('ShortCode 3', $this->text_domain); ?></th>
						<td>[<input name="properties[code3]" type="text" id="inputtext" value="<?php echo esc_attr($this->options['code3']); ?>"class="regular-text" style="width: 8em;" /> url="http://xxx" <span style="color: #aabbff; font-weight: bold;">title=</span><span style="color: #aabbff;">"xxxxxx"</span> <span style="color: #bbaaff; font-weight: bold;">content=</span><span style="color: #bbaaff;">"xxxxxx"</span>]
							<p><?php _e('Case-sensitive', $this->text_domain); ?></p></td>
					</tr>
					<tr valign="top" style="display: none;">
						<th scope="row"><?php _e('ShortCode 4', $this->text_domain); ?></th>
						<td>[<input name="properties[code4]" type="text" id="inputtext" value="<?php echo esc_attr($this->options['code4']); ?>" class="regular-text" style="width: 8em;" /> url="http://xxx" <span style="color: #aabbff; font-weight: bold;">title=</span><span style="color: #aabbff;">"xxxxxx"</span> <span style="color: #bbaaff; font-weight: bold;">content=</span><span style="color: #bbaaff;">"xxxxxx"</span>]
							<p><?php _e('Case-sensitive', $this->text_domain); ?></p></td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php _e('Parameters', $this->text_domain); ?></th>
						<td>
							[<span style="color: #888888;" id="open2"><?php echo esc_attr($this->options['code1']); ?></span> url="http://xxx" <span style="color: #4488ff; font-weight: bold;">title=</span>"xxxxxx" <span style="color: #8844ff; font-weight: bold;">content=</span>"xxxxxx"]<br>
							<?php _e('For any shortcode you can change the title and excerpt with `title` parameter and `content` parameter', $this->text_domain); ?>
						</ts>
					</tr>

					<tr valign="top">
						<th scope="row"><?php _e('Convert text link', $this->text_domain); ?></th>
						<td><label><input name="properties[auto-atag]" type="checkbox" id="check" value="1" <?php checked(isset($this->options['auto-atag']) ? $this->options['auto-atag'] : null, 1); ?> /><?php _e('Convert lines with text link only to Linkcard.', $this->text_domain); ?></label></td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php _e('Convert URL', $this->text_domain); ?></th>
						<td><label><input name="properties[auto-url]" type="checkbox" id="check" value="1" <?php checked(isset($this->options['auto-url']) ? $this->options['auto-url'] : null, 1); ?> /><?php _e('Convert lines with URL only to Linkcard.', $this->text_domain); ?></label></td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php _e('External link only', $this->text_domain); ?></th>
						<td><label><input name="properties[auto-external]" type="checkbox" id="check" value="1" <?php checked(isset($this->options['auto-external']) ? $this->options['auto-external'] : null, 1); ?> /><?php _e('Convert only external links.', $this->text_domain); ?></label></td>
					</tr>

					<tr valign="top">
						<th scope="row"><?php _e('Do shortcode', $this->text_domain); ?></th>
						<td><label><input name="properties[flg-do-shortcode]" type="checkbox" id="check" value="1" <?php checked(isset($this->options['flg-do-shortcode']) ? $this->options['flg-do-shortcode'] : null, 1); ?> /><?php _e('Force shortcode development.', $this->text_domain); ?></label></td>
					</tr>

					<tr valign="top">
						<th scope="row"><?php _e('Add insert button', $this->text_domain); ?></th>
						<td><label><input name="properties[flg-edit-insert]" type="checkbox" id="check" value="1" <?php checked(isset($this->options['flg-edit-insert']) ? $this->options['flg-edit-insert'] : null, 1); ?> /><?php _e('Add insert button to visual editor.', $this->text_domain); ?></label></td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php _e('Add quick tag', $this->text_domain); ?></th>
						<td><label><input name="properties[flg-edit-qtag]" type="checkbox" id="check" value="1" <?php checked(isset($this->options['flg-edit-qtag']) ? $this->options['flg-edit-qtag'] : null, 1); ?> /><?php _e('Add quick tag button to text editor.', $this->text_domain); ?></label></td>
					</tr>

				</table>
			</div>
			
			<div class="pz-lkc-item" id="pz-lkc-initialize">
				<h3><?php echo __('Initialize', $this->text_domain).'<a href="https://popozure.info/pz-linkcard-settings-initialize" target="_blank"><img src="'.$this->plugin_dir_url.'img/help.png" width="16" height="16" title="'.__('Help', $this->text_domain).'" alt="help"></a>'; ?></h3>
				<table class="form-table">
					<tr valign="top">
						<th scope="row"><?php _e('Return to the initial setting', $this->text_domain); ?></th>
						<td><label><input name="properties[initialize]" type="checkbox" id="check" value="1" <?php checked(isset($this->options['initialize']) ? $this->options['initialize'] : null, 1); ?> /></label></td>
					</tr>
				</table>
			</div>

			<?php submit_button(); ?>

		</form>
	</div>
</div>
<?php
	function pz_TrimNum($val, $zero = 0 ) {
		$val		=	intval(preg_replace('/[^0-9]/', '', $val));
		if ($val	==	0) {
			$val	=	$zero;
			$val	=	intval(preg_replace('/[^0-9]/', '', $val));
		}
		return	$val;
	}
