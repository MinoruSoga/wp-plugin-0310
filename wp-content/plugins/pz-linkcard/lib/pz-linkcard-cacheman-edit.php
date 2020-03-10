<?php if (!function_exists("get_option")) die; ?>
<!-- 編集用フォーム -->
<form action="" method="post">
	<?php wp_nonce_field('pz_cacheman'); ?>
	<input type="hidden" name="page" value="pz-linkcard-cache">
	<input type="hidden" name="paged" value="<?php echo $page_now; ?>">
	<input type="hidden" name="refine" value="<?php echo $refine; ?>">
	<input type="hidden" name="link_type" value="<?php echo $link_type; ?>">
	<input type="hidden" name="orderby" value="<?php echo $orderby; ?>">
	<input type="hidden" name="order" value="<?php echo $order; ?>">
	<div>
		<table name="cachelist" class="wp-list-table widefat fixed">
			<tr>
				<th style="width: 12em;"><?php _e('ID', $this->text_domain) ?></th>
				<td><input name="data[id]" type="text" id="inputtext" value="<?php echo $data['id']; ?>" size="5" readonly="readonly" /></td>
			</tr>
			<tr style="display: none;">
				<th><?php _e('URL key', $this->text_domain) ?></th>
				<td><input name="key_text" type="text" id="inputtext" value="<?php echo bin2hex($data['url_key']); ?>" size="71" readonly="readonly" /></td>
			</tr>
			<tr>
				<th><?php _e('URL', $this->text_domain) ?></th>
				<td><input name="data[url]" type="text" id="inputtext" value="<?php echo $data['url']; ?>" size="71" readonly="readonly" /></td>
			</tr>
			<tr>
				<th><?php _e('Site name', $this->text_domain) ?></th>
				<td><input name="data[site_name]" type="text" id="inputtext" value="<?php echo esc_attr($data['site_name']); ?>" size="71" /></td>
			</tr>
			<tr>
				<th><?php _e('Domain', $this->text_domain) ?></th>
				<td><input name="data[domain]" type="text" id="inputtext" value="<?php echo $data['domain']; ?>" size="71" readonly="readonly" /></td>
			</tr>
			<tr>
				<th><?php _e('Title', $this->text_domain) ?></th>
				<td><input name="data[title]" type="text" id="inputtext" value="<?php echo esc_attr($data['title']); ?>" size="71" /></td>
			</tr>
			<tr>
				<th><?php _e('Excerpt', $this->text_domain) ?></th>
				<td><input name="data[excerpt]" type="text" id="inputtext" value="<?php echo esc_attr($data['excerpt']); ?>" size="71" /></td>
			</tr>
			<tr>
				<th><?php _e('Charset', $this->text_domain) ?></th>
				<td><?php echo $data['charset'].'&nbsp;'.__('->', $this->text_domain); ?>&nbsp;<input name="data[charset]" type="text" id="inputtext" value="edit" size="8" readonly="readonly" /></td>
			</tr>
			<tr>
				<th><?php _e('Thumbnail URL', $this->text_domain) ?></th>
				<td><input name="data[thumbnail]" type="text" id="inputtext" value="<?php echo $data['thumbnail']; ?>" size="71" readonly="readonly" ondblclick="this.readOnly=false;" /></td>
			</tr>
			<tr>
				<th><?php _e('Favicon URL', $this->text_domain) ?></th>
				<td><input name="data[favicon]" type="text" id="inputtext" value="<?php echo $data['favicon']; ?>" size="71" readonly="readonly" ondblclick="this.readOnly=false;" /></td>
			</tr>
			<tr>
				<th><?php _e('Result code', $this->text_domain) ?></th>
				<td><input name="data[result_code]" type="text" id="inputtext" value="<?php echo $data['result_code']; ?>" size="5" readonly="readonly" ondblclick="this.readOnly=false;" /></td>
			</tr>
<?php
			// 記事IDの再取得（時間がかかるので未実行）
			$use_post_id_t			=	array();
			if		($data['use_post_id1'] > 0) {
				$use_post_id_t[]	=	$data['use_post_id1'];
			}
			if		($data['use_post_id2'] > 0) {
				$use_post_id_t[]	=	$data['use_post_id2'];
			}
			if		($data['use_post_id3'] > 0) {
				$use_post_id_t[]	=	$data['use_post_id3'];
			}
			if		($data['use_post_id4'] > 0) {
				$use_post_id_t[]	=	$data['use_post_id4'];
			}
			if		($data['use_post_id5'] > 0) {
				$use_post_id_t[]	=	$data['use_post_id5'];
			}
			if		($data['use_post_id6'] > 0) {
				$use_post_id_t[]	=	$data['use_post_id6'];
			}
			$use_post_id_m			=	$wpdb->get_results($wpdb->prepare("SELECT id FROM $wpdb->prefix"."posts WHERE post_type = 'post' AND post_content LIKE '%%\"%s\"%%' ORDER BY id ASC", '"'.$data['url'].'"'	));
			foreach($use_post_id_m	as $use_post_id) {
				$use_post_id_t[]		=	$use_post_id->id;
			}
			$use_post_id_t	=	array_unique($use_post_id_t);
			$use_post_id_t	=	array_values($use_post_id_t);
			$data['use_post_id1']	=	isset($use_post_id_t[0]) ? $use_post_id_t[0] : '' ;
			$data['use_post_id2']	=	isset($use_post_id_t[1]) ? $use_post_id_t[1] : '' ;
			$data['use_post_id3']	=	isset($use_post_id_t[2]) ? $use_post_id_t[2] : '' ;
			$data['use_post_id4']	=	isset($use_post_id_t[3]) ? $use_post_id_t[3] : '' ;
			$data['use_post_id5']	=	isset($use_post_id_t[4]) ? $use_post_id_t[4] : '' ;
			$data['use_post_id6']	=	isset($use_post_id_t[5]) ? $use_post_id_t[5] : '' ;
?>
			<tr>
				<th><?php _e('Post ID', $this->text_domain) ?></th>
				<td><input name="data[use_post_id1]" type="text" id="inputtext" value="<?php echo $data['use_post_id1']; ?>" size="5" readonly="readonly" ondblclick="this.readOnly=false;" />
				<input name="data[use_post_id2]" type="text" id="inputtext" value="<?php echo $data['use_post_id2']; ?>" size="5" readonly="readonly" ondblclick="this.readOnly=false;" />
				<input name="data[use_post_id3]" type="text" id="inputtext" value="<?php echo $data['use_post_id3']; ?>" size="5" readonly="readonly" ondblclick="this.readOnly=false;" />
				<input name="data[use_post_id4]" type="text" id="inputtext" value="<?php echo $data['use_post_id4']; ?>" size="5" readonly="readonly" ondblclick="this.readOnly=false;" />
				<input name="data[use_post_id5]" type="text" id="inputtext" value="<?php echo $data['use_post_id5']; ?>" size="5" readonly="readonly" ondblclick="this.readOnly=false;" />
				<input name="data[use_post_id6]" type="text" id="inputtext" value="<?php echo $data['use_post_id6']; ?>" size="5" readonly="readonly" ondblclick="this.readOnly=false;" /></td>
			</tr>
			<tr>
				<th><?php _e('SNS', $this->text_domain) ?></th>
				<td>
					<?php _e('Tw', $this->text_domain) ?>:<input name="data[sns_twitter]" type="text" id="inputtext" value="<?php echo $data['sns_twitter']; ?>" size="5" readonly="readonly" />
					<?php _e('fb', $this->text_domain) ?>:<input name="data[sns_facebook]" type="text" id="inputtext" value="<?php echo $data['sns_facebook']; ?>" size="5" readonly="readonly" />
					<?php _e('B!', $this->text_domain) ?>:<input name="data[sns_hatena]" type="text" id="inputtext" value="<?php echo $data['sns_hatena']; ?>" size="5" readonly="readonly" />
					<?php _e('Po', $this->text_domain) ?>:<input name="data[sns_pocket]" type="text" id="inputtext" value="<?php echo $data['sns_pocket']; ?>" size="5" readonly="readonly" />
				</td>
			</tr>
			<tr>
				<th><?php _e('Uptime', $this->text_domain) ?></th>
				<td><input name="data[uptime]" type="text" id="inputtext" value="<?php echo $data['uptime']; ?>" size="10" readonly="readonly" /><?php echo date('Y-m-d H:i:s', $data['uptime']); ?></td>
			</tr>
			<tr>
				<th><?php _e('Next SNS', $this->text_domain) ?></th>
				<td><input name="data[sns_nexttime]" type="text" id="inputtext" value="<?php echo $data['sns_nexttime']; ?>" size="10" readonly="readonly" /><?php echo date('Y-m-d H:i:s', $data['sns_nexttime']); ?></td>
			</tr>
			<tr>
				<th><?php _e('Next alive', $this->text_domain) ?></th>
				<td><input name="data[alive_nexttime]" type="text" id="inputtext" value="<?php echo $data['alive_nexttime']; ?>" size="10" readonly="readonly" /><?php echo date('Y-m-d H:i:s', $data['alive_nexttime']); ?></td>
			</tr>
			<tr>
				<th><?php _e('Regist', $this->text_domain) ?></th>
				<td><input name="data[regist]" type="text" id="inputtext" value="<?php echo $data['regist']; ?>" size="17" readonly="readonly" /></td>
			</tr>
			<tr>
				<th></th>
				<td><input name="update"   type="submit" class="button button-primary button-large" id="publish" value="<?php _e('Update', $this->text_domain) ?>" /> <input name="cancel" type="submit" class="button button-large" id="publish" value="<?php _e('Cancel', $this->text_domain) ?>" /></td>
			</tr>
		</table>
	</div>
</form>
