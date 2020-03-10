<?php if (!function_exists("get_option")) die; ?>
<?php

$orderby = strtolower($orderby); // 気持ち程度のインジェクション対策
switch ($orderby) {
case 'id':
case 'url':
case 'url_key':
case 'link_type':
case 'site_name':
case 'domain':
case 'charset':
case 'title':
case 'excerpt':
case 'result_code':
case 'alive_result':
case 'use_post_id1':
case 'use_post_id2':
case 'use_post_id3':
case 'use_post_id4':
case 'use_post_id5':
case 'use_post_id6':
case 'sns_twitter':
case 'sns_facebook':
case 'sns_hatena':
case 'sns_pocket':
case 'regist':
case 'sns_nexttime':
	break;
default:
	$orderby	= 'regist';
	$order		= 'desc';
}

$order = strtolower($order);
if ($order != 'asc' && $orderby == $orderby_now) {
	$order = 'desc';
}

// 抽出条件
$where = null;
$link_type = strtolower($link_type);
switch ($link_type) {
case 'all':
	$where		=	"";
	break;
case 'internal':
	$where		=	"url LIKE '".get_bloginfo('url')."%'";
	break;
case 'external':
	$where		=	"url NOT LIKE '".get_bloginfo('url')."%'";
	break;
case 'modify':
	$where		=	"alive_result <> result_code";
	break;
case 'unlink':
	$where		=	"alive_result = '404'";
	break;
default:
	if ($this->options['flg-alive'] && $this->options['flg-alive-count']) {
		$link_type	=	'unlink';
		$where		=	"alive_result = '404'";
	} else {
		$link_type	=	'all';
		$where		=	"";
	}
}	

// キーワード
$key1		=	'';
$key2		=	'';
$key3		=	'';
if (isset($keyword) && $keyword) {
	$key1	=	$keyword;
	$key2	=	$keyword;
	if ($where) {
		$where .= " AND (title LIKE '%%%s%%' OR excerpt LIKE '%%%s%%')";
	} else {
		$where .= " (title LIKE '%%%s%%' OR excerpt LIKE '%%%s%%')";
	}
}

// ドメイン指定
if (isset($refine) && $refine) {
	if (isset($keyword) && $keyword) {
		$key3	=	$refine;
	} else {
		$key1	=	$refine;
	}
	if ($where) {
		$where .= " AND domain=%s";
	} else {
		$where .= " domain=%s";
	}
}

// 検索SQL作成
$sql			= "SELECT * FROM $this->db_name";
if (isset($where) && $where) {
	$sql		.= " WHERE $where";
}
if (isset($orderby) && $orderby) {
	$sql		.= " ORDER BY $orderby $order";
}
if ( strpos($sql, 'UPDATE') || strpos($sql, 'UNION') ) { // 気持ち程度のインジェクション対策
		$sql	=	'';
}

// データ抽出
if ($key3) {
	$data_all		= $wpdb->get_results($wpdb->prepare($sql, $key1, $key2, $key3));
} elseif ($key2) {
	$data_all		= $wpdb->get_results($wpdb->prepare($sql, $key1, $key2));
} elseif ($key1) {
	$data_all		= $wpdb->get_results($wpdb->prepare($sql, $key1));
} else {
	$data_all		= $wpdb->get_results($sql);
}
$count_now		= count($data_all);

// ページ数
$page_min		= ($count_now > 0) ? 1 : 0;
$page_max		= ceil($count_now / 10);
$page_now		= ($paged < $page_min) ? $page_min : (($paged > $page_max) ? $page_max : $paged);
$page_prev		= ($page_now > 1) ? $page_now - 1 : null;
$page_next		= ($page_now < $page_max) ? $page_now + 1 : null;

$page_top		= ($page_now < 1) ? 0 : (($page_now - 1) * 10); // 0 origin
$page_limit		= isset($page_limit) ? intval($page_limit) : 10 ;

// 表示用データ
if (isset($page_limit)) {
	$page_top	= intval($page_top);
	$page_limit	= intval($page_limit);
	$sql		.= ' LIMIT '.$page_top.' , '.$page_limit;
}
// データ抽出
//$data_all		= $wpdb->get_results($wpdb->prepare($sql, $key1, $key2, $key3));

// ドメイン一覧作成
$sql			= "SELECT domain, site_name, count(*) as count FROM $this->db_name GROUP BY domain ASC";
if (strpos($sql, '--') || strpos($sql, 'UPDATE') || strpos($sql, 'UNION') ) { // 気持ち程度のインジェクション対策
	die;
}
$domain_list	= $wpdb->get_results($sql);		// テーブルデータ

// SUB(CASE WHEN ... END) で一気に取れないぽい？
$count_all			= 0;
$count_internal		= 0;
$count_external		= 0;
$count_modify		= 0;
$result				= $wpdb->get_row("SELECT COUNT(*) AS count FROM $this->db_name");
if (isset($result) && isset($result->count)) {
	$count_all		= $result->count;
}
$result			= $wpdb->get_row("SELECT COUNT(*) AS count FROM $this->db_name WHERE url LIKE '".get_bloginfo('url')."%'");
if (isset($result) && isset($result->count)) {
	$count_internal	= $result->count;
}
$result			= $wpdb->get_row("SELECT COUNT(*) AS count FROM $this->db_name WHERE url NOT LIKE '".get_bloginfo('url')."%'");
if (isset($result) && isset($result->count)) {
	$count_external	= $result->count;
}
$result			= $wpdb->get_row("SELECT COUNT(*) AS count FROM $this->db_name WHERE alive_result <> result_code");
if (isset($result) && isset($result->count)) {
	$count_modify	= $result->count;
}
$result			= $wpdb->get_row("SELECT COUNT(*) AS count FROM $this->db_name WHERE alive_result = '404'");
if (isset($result) && isset($result->count)) {
	$count_unlink	= $result->count;
}
?>

<form id="posts-filter" action="" method="post">
	<ul class='subsubsub'>
		<li class="all"><a href="?page=pz-linkcard-cache&link_type=all&orderby=regist&order=desc"		<?php if ($link_type == 'all')		echo 'class="current"'; ?>><?php _e('All', $this->text_domain); ?> <span class="count">(<?php echo $count_all; ?>)</span></a> |</li>
		<li class="all"><a href="?page=pz-linkcard-cache&link_type=internal&orderby=regist&order=desc"	<?php if ($link_type == 'internal')	echo 'class="current"'; ?>><?php _e('Internal', $this->text_domain); ?> <span class="count">(<?php echo $count_internal; ?>)</span></a> |</li>
		<li class="all"><a href="?page=pz-linkcard-cache&link_type=external&orderby=regist&order=desc"	<?php if ($link_type == 'external')	echo 'class="current"'; ?>><?php _e('External', $this->text_domain); ?> <span class="count">(<?php echo $count_external; ?>)</span></a> |</li>
		<li class="all"><a href="?page=pz-linkcard-cache&link_type=modify&orderby=regist&order=desc"	<?php if ($link_type == 'modify')	echo 'class="current"'; ?>><?php _e('Modify', $this->text_domain); ?> <span class="count">(<?php echo $count_modify; ?>)</span></a> |</li>
		<li class="all"><a href="?page=pz-linkcard-cache&link_type=unlink&orderby=regist&order=desc"	<?php if ($link_type == 'unlink')	echo 'class="current"'; ?>><?php _e('Unlink', $this->text_domain); ?> <span class="count">(<?php echo $count_unlink; ?>)</span></a></li>
	</ul>

	<p class="search-box">
		<label class="screen-reader-text"><?php _e('Search keyword', $this->text_domain); ?></label>
		<input type="search" id="post-search-input" name="keyword" value="<?php echo $keyword; ?>">
		<input type="submit" id="search-submit" class="button action" value="<?php _e('Search', $this->text_domain); ?>">
	</p>

	<?php wp_nonce_field('pz_cacheman'); ?>
	<input type="hidden" name="page" value="pz-linkcard-cache">
	<input type="hidden" name="paged" value="<?php echo $page_now; ?>">

	<div class="tablenav top">
		<div class="alignleft bulkactions">
			<label for="bulk-action-selector-top" class="screen-reader-text"><?php _e('Select batch', $this->text_domain); ?></label>
			<select name="action" id="bulk-action-selector-top">
				<option value="-1" selected="selected"><?php _e('Select', $this->text_domain); ?></option>
				<option value="renew"><?php _e('Renew cache', $this->text_domain); ?></option>
				<option value="renew_thumbnail"><?php _e('Renew Thumbnail', $this->text_domain); ?></option>
				<option value="renew_sns"><?php _e('Renew SNS count', $this->text_domain); ?></option>
				<option value="alive"><?php _e('Check status', $this->text_domain); ?></option>
				<option value="delete"><?php _e('Delete from cache', $this->text_domain); ?></option>
			</select>
			<input type="submit" id="doaction" class="button action" value="<?php _e('Submit', $this->text_domain); ?>" onclick="return confirm(\''.__('Are you sure?', $this->text_domain).'\');" />
		</div>

		<div class="alignleft bulkactions">
			<label for="bulk-action-selector-top" class="screen-reader-text"><?php _e('Select domain', $this->text_domain); ?></label>
			<select name="refine" id="bulk-action-selector-top">
				<option value="" selected="selected"><?php _e('All domain', $this->text_domain); ?></option>
<?php
$i		= 0;
foreach ($domain_list as $rec) {
	$i++;
	echo '<option value="'.$rec->domain.'"';
	if ($rec->domain == $refine) {
		echo 'selected="selecter"';
	}
	echo '>'.$rec->domain.' ('.$rec->count.')</option>';
}
?>
				</select>
			<input type="submit" id="doaction" class="button action" value="<?php _e('Refine search', $this->text_domain); ?>" />
		</div>

<?php // ページング
echo '<div class="tablenav-pages">';
echo '	<span class="displaying-num">'.$count_now.__('items').'</span>';
echo '	<span class="pagination-links">';
echo_PageButton($page_min, $paged, '&laquo;', 'first-page');
echo_PageButton($page_prev, $paged, '&lsaquo;', 'prev-page');
echo '		<span class="paging-input"><label for="current-page-selector" class="screen-reader-text"></label><input class="current-page" id="current-page-selector" type="text" name="paged" value="'.$page_now.'" size="2" aria-describedby="table-paging" /> / <span class="total-pages">'.$page_max.'</span></span>';
echo_PageButton($page_next, $paged, '&rsaquo;', 'first-page');
echo_PageButton($page_max, $paged, '&raquo;', 'last-page');
echo '	</span>';
echo '</div>';
?>
		<br class="clear">
	</div>

	<div id="settings" style="clear:both;">
		<table name="cachelist" class="widefat striped">
			<thead>
				<tr>
					<td id="cb" class="manage-column column-cb check-column"><label class="screen-reader-text" for="cb-select-all-1"><?php _e('Select all', $this->text_domain); ?></label><input id="cb-select-all-1" type="checkbox" /></td>
					<th scope="col" class="id"		style="width: 3em;">				<?php echo_THC('id', __('ID', $this->text_domain) ); ?></th>
					<th scope="col" class="url_key"	style="width: 9em; display: none;">	<?php echo_THC('url_key', __('URL key', $this->text_domain) ); ?></th>
					<th scope="col" class="url"		style="min-width: 10em;">			<?php echo_THC('url', __('URL', $this->text_domain) ); ?></th>
					<th scope="col" class="title"	style="min-width: 10em;">			<?php echo_THC('title', __('Title', $this->text_domain) ); ?></th>
					<th scope="col" class="excerpt"	style="min-width: 20em;">			<?php echo_THC('excerpt', __('Excerpt', $this->text_domain) ); ?></th>
					<th scope="col" class="charset"	style="width: 4em; display: none;">	<?php echo_THC('charset', __('Charset', $this->text_domain) ); ?></th>
					<th scope="col" class="domain"	style="min-width: 6em;">			<?php echo_THC('domain', __('Domain', $this->text_domain) ); ?></th>
					<th scope="col" class="sns"		style="width: 2.5em;">				<?php echo_THC('sns_twitter', __('Tw', $this->text_domain)); echo '<br>'; echo_THC('sns_facebook', __('fb', $this->text_domain)); echo '<br>'; echo_THC('sns_hatena', __('B!', $this->text_domain)); echo '<br>'; echo_THC('sns_pocket', __('Po', $this->text_domain)); ?></th>
					<th scope="col" class="regist"	style="width: 5em;">				<?php echo_THC('regist', __('Regist', $this->text_domain) ); ?></th>
					<th scope="col" class="postid"	style="width: 3em;">				<?php echo_THC('use_post_id1', __('Post ID', $this->text_domain) ); ?></th>
					<th scope="col" class="result"	style="width: 2.5em;">				<?php echo_THC('result_code', __('Result code', $this->text_domain) ); ?><br><?php echo_THC('alive_result', __('(last)', $this->text_domain) ); ?></th>
				</tr> 
			</thead>
			<tbody>
<?php
foreach ($data_all as $data) {
	echo '<tr>';
//	echo '<td colspan=12">'.Pz_LinkCard::pz_getHTML(array('url' => $data->url)).'</td>';
	
	$data_id	= $data->id;
	echo '	<th scope="row" class="check-column">';
	echo '		<label class="screen-reader-text" for="cb-select-'.$data_id.'">'.__('Select', $this->text_domain).'</label>';
	echo '		<input id="cb-select-'.$data_id.'" type="checkbox" name="id[]" value="'.$data_id.'" />';
	echo '		<div class="locked-indicator"></div>';
	echo '	</th>';

	echo '	<td>'.$data_id;
	if ( $data->domain == $mydomain ) {
		$post_id			= url_to_postid( $data->url );										// 記事IDを取得
		$thumbnail_id		= get_post_thumbnail_id( $post_id );								// サムネイルIDを取得
		$attach				= wp_get_attachment_image_src( $thumbnail_id, 'thumbnail', true );	// サムネイルを取得
		if (isset($attach) && count($attach) > 3 && isset($attach[0])) {
				echo '<div><img src="'.$attach[0].'" style="max-height: 48px; max-width: 48px;" alt=""></div>';
		}
	} else {
		if ($data->thumbnail) {
			$thumbnail_key		= bin2hex(hash( 'sha256', $data->thumbnail, true));
			$file_path	= $this->options['thumbnail-dir'].$thumbnail_key;
			$file_url	= $this->options['thumbnail-url'].$thumbnail_key;
			if (file_exists($file_path )) {
				echo '<div><img src="'.$file_url.'" style="max-height: 48px; max-width: 48px;" alt=""></div>';
			}
		}
	}
	echo '</td>';

	echo '	<td style="display: none;">'.bin2hex($data->url_key).'</td>';

	$url		=	esc_url($data->url);
	$disp_url	=	$url;
	$domain		=	$data->domain;
	// 日本語ドメイン対応
	if (isset($this->options['flg-idn']) ? true : false) {
		if (function_exists('idn_to_utf8')) {
			if ( substr( $domain, 0, 4 ) == 'xn--') {
				$domain			=	idn_to_utf8( $domain );
				$url_m			=	parse_url( $url );
				$url_m['host']	=	idn_to_utf8( $url_m[host] );
				$disp_url		=	$url_m['scheme'].'://'.$url_m['host'].$url_m['path'].$url_m['query'].$url_m['fragment'];
			}
		}
	}
	$title	= htmlspecialchars($data->title);
	if		($data->mod_title) {
		$title	= '<b>'.$title.'</b>';
	}
	echo '	<td colspan="2">';
	echo '		<div style="word-break: break-all; font-size: 60%;">';
	if ( $data->domain == $mydomain ) {
		echo '<a href="'.$url.'">'.$disp_url.'</a>';
	} else {
		echo $disp_url;
	}
	echo		'</div><div>'.$title.'</div>';
	echo '		<div id="inline_'.$data_id.'"style="font-size: 90%;">';
	echo 		'<a href="'.wp_nonce_url('?page=pz-linkcard-cache&link_type='.$link_type.'&orderby='.$orderby.'&order='.$order.'&paged='.$page_now.'&refine='.$refine.'&action=edit&id[0]='.$data_id, 'pz_cacheman').'">'.__('edit',$this->text_domain).'</a> | ';
	echo 		'<a href="'.wp_nonce_url('?page=pz-linkcard-cache&link_type='.$link_type.'&orderby='.$orderby.'&order='.$order.'&paged='.$page_now.'&refine='.$refine.'&action=renew&id[0]='.$data_id, 'pz_cacheman').'" onclick="return confirm(\''.__('Are you sure?', $this->text_domain).'\');">'.__('renew',$this->text_domain).'</a> | ';
	echo 		'<a href="'.wp_nonce_url('?page=pz-linkcard-cache&link_type='.$link_type.'&orderby='.$orderby.'&order='.$order.'&paged='.$page_now.'&refine='.$refine.'&action=delete&id[0]='.$data_id, 'pz_cacheman').'" onclick="return confirm(\''.__('Are you sure?', $this->text_domain).'\');">'.__('delete',$this->text_domain).'</a>';
	echo 		'</div>';
	echo '	</td>';

	$excerpt= htmlspecialchars(mb_strimwidth(html_entity_decode($data->excerpt), 0, 100, '...'));
	if		($data->mod_excerpt) {
		$excerpt	= '<b>'.$excerpt.'</b>';
	}
	echo '	<td>'.$excerpt.'</td>';
	echo '	<td style="display: none;">'.$data->charset.'</td>';

	echo '	<td><div title="'.$domain.'">'.$domain.'</div><div><span style="background-color: #888; color: #fff; font-size: 9px;">'.$data->site_name.'</span></div></td>';
//	echo '	<td><img src="'.$data->thumbnail.'" style="max-height: 100px; max-width: 100px;"></td>';
//	echo '	<td style="word-break: break-all;">'.$data->thumbnail.'</td>';
//	echo '	<td></td>';
//	echo '	<td><img src="'.$data->favicon.'" style="max-height: 100px; max-width: 100px;"></td>';
//	echo '	<td style="word-break: break-all;">'.$data->favicon.'</td>';
//	echo '	<td></td>';
	echo '	<td style="font-size: 60%; text-align: right;">';
	$sns_count = $data->sns_twitter;
	echo (($sns_count >= 0) ? numKM($sns_count) : '-').'<br>';
	$sns_count = $data->sns_facebook;
	echo (($sns_count >= 0) ? numKM($sns_count) : '-').'<br>';
	$sns_count = $data->sns_hatena;
	echo (($sns_count >= 0) ? numKM($sns_count) : '-').'<br>';
	$sns_count = $data->sns_pocket;
	echo (($sns_count >= 0) ? numKM($sns_count) : '-').'<br>';
	echo '</td>';

	echo '	<td>'.$data->regist.'</td>';
	echo '	<td style="word-break: break-all;">';
	if			($data->use_post_id1 > 0 ) {
		echo	'<a href="'.get_permalink($data->use_post_id1).'" target="_blank" title="'.get_the_title($data->use_post_id1).'">'.$data->use_post_id1;
	}
	if			($data->use_post_id2 > 0 ) {
		echo	'<br><a href="'.get_permalink($data->use_post_id2).'" target="_blank" title="'.get_the_title($data->use_post_id2).'">'.$data->use_post_id2;
	}
	if			($data->use_post_id3 > 0 ) {
		echo	'<br><a href="'.get_permalink($data->use_post_id3).'" target="_blank" title="'.get_the_title($data->use_post_id3).'">'.$data->use_post_id3;
	}
	echo '</td>';
	echo '	<td>'.$data->result_code.($data->result_code <> $data->alive_result ? '<br><span style="color:#f00;">('.$data->alive_result.')</span>' : '').'</td>';
	echo '</tr>';
}

?>
			</tbody>
		</table>
	</div>
</form>
<!--
<div class="filemenu">
	<form id="export" action="" method="post">
		<?php wp_nonce_field('pz_cacheman'); ?>
		<input type="hidden" name="page" value="pz-linkcard-cache">
		<input type="hidden" name="action" value="filemenu">
		<p class="submit">
			<input type="submit" id="doaction" class="button" value="<?php echo __('Export'); ?>" />
		</p>
	</form>
</div>
-->
<?php
function echo_PageButton($page_link, $page_now, $text, $class_name) {
	$orderby		= isset($_REQUEST['orderby']		) ? $_REQUEST['orderby'] : null;
	$order			= isset($_REQUEST['order']			) ? $_REQUEST['order'] : null;
	$refine			= isset($_REQUEST['refine']			) ? $_REQUEST['refine'] : null;
	$keyword		= isset($_REQUEST['keyword']		) ? $_REQUEST['keyword'] : null;
	$link_type		= isset($_REQUEST['link_type']		) ? $_REQUEST['link_type'] : null;

	if ($page_link != $page_now && !is_null($page_link)) {
		echo	'<a class="'.$class_name.'" href="?page=pz-linkcard-cache&link_type='.$link_type.'&orderby='.$orderby.'&order='.$order.'&refine='.$refine.'&keyword='.$keyword.'&paged='.$page_link.'">'.$text.'</a>';
	} else {
		echo '<span class="tablenav-pages-navspan">'.$text.'</span>';
	}
}

function echo_THC($item, $text) {
	$orderby		= isset($_REQUEST['orderby']		) ? $_REQUEST['orderby'] : null;
	$order			= isset($_REQUEST['order']			) ? $_REQUEST['order'] : null;
	$refine			= isset($_REQUEST['refine']			) ? $_REQUEST['refine'] : null;
	$keyword		= isset($_REQUEST['keyword']		) ? $_REQUEST['keyword'] : null;
	$link_type		= isset($_REQUEST['link_type']		) ? $_REQUEST['link_type'] : null;

	if ($item == $orderby) {
		if ($order == 'desc') {
			$mark	= '▼';
			$order	= 'asc';
		} else {
			$mark	= '▲';
			$order	= 'desc';
		}
	} else {
		$mark = '';
		$order		= 'desc';
	}
	echo '<a href="?page=pz-linkcard-cache&link_type='.$link_type.'&orderby='.$item.'&order='.$order.'&refine='.$refine.'&keyword='.$keyword.'">'.$text.$mark.'</a>';
}

function numKM($count_str) {
	$count		=	intval($count_str);
	if				($count >= 10000000) {
		return		number_format($count / 1000000).'&nbsp;m';
	} elseif		($count >= 1000) {
		return		number_format($count / 1000).'&nbsp;k';
	} else {
		return		number_format($count);
	}
}