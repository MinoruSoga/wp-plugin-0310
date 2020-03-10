<?php if (!function_exists("get_option")) die; ?>
<?php
if (!is_user_logged_in()) die;

echo '<div class="wrap">';
echo '<h1>'.__('LinkCard cache manager', $this->text_domain).'<a href="https://popozure.info/pz-linkcard-manager" target="_blank"><img src="'.$this->plugin_dir_url.'img/help.png" width="16" height="16" title="'.__('Help', $this->text_domain).'" alt="help"></a></h1>';

//	echo '<pre>';
//	print_r($_REQUEST);
//	echo '</pre>';

$update			= isset($_REQUEST['update']			) ? $_REQUEST['update'] : null;
$cancel			= isset($_REQUEST['cancel']			) ? $_REQUEST['cancel'] : null;
$data			= null;
if ($update || $cancel) {
	if ($update) {
		$action	= 'update';
		if (isset($_REQUEST['data']) && is_array($_REQUEST['data'])) {
			$data	= $_REQUEST['data'];
		}
	} else {
		$action	= null;
	}
//	$refine		= null;
	$bulk_id	= null;
} else {
	$action		= isset($_REQUEST['action']			) ? $_REQUEST['action'] : null;
//	$refine		= isset($_REQUEST['refine']			) ? $_REQUEST['refine'] : null;
	$bulk_id	= isset($_REQUEST['id']				) ? $_REQUEST['id'] : null;
}
$refine			= isset($_REQUEST['refine']			) ? $_REQUEST['refine'] : null;
$keyword		= isset($_REQUEST['keyword']		) ? $_REQUEST['keyword'] : null;
$orderby		= isset($_REQUEST['orderby']		) ? $_REQUEST['orderby'] : null;
$order			= isset($_REQUEST['order']			) ? $_REQUEST['order'] : null;
$orderby_now	= isset($_REQUEST['orderby_now']	) ? $_REQUEST['orderby_now'] : null;
$order_now		= isset($_REQUEST['order_now']		) ? $_REQUEST['order_now'] : null;
$link_type		= isset($_REQUEST['link_type']		) ? $_REQUEST['link_type'] : null;
$cache_id		= isset($_REQUEST['cache_id']		) ? $_REQUEST['cache_id'] : null;
$confirm		= isset($_REQUEST['confirm']		) ? $_REQUEST['confirm'] : null;
$result_code	= isset($_REQUEST['result_code']	) ? $_REQUEST['result_code'] : null;
$alive_result	= isset($_REQUEST['alive_result']	) ? $_REQUEST['alive_result'] : null;
$paged			= intval(isset($_REQUEST['paged']	) ? $_REQUEST['paged'] : 1) - 0;

$mydomain			= null;
if (preg_match('{https?://(.*)/}i', home_url().'/',$m)) {
	$mydomain_url	= $m[0];
	$mydomain		= $m[1];
}

global $wpdb;

if (isset($action)) {
	check_admin_referer('pz_cacheman');

	switch ($action) {
	case 'edit':
		if (isset($bulk_id) && is_array($bulk_id)) {
			$data		= $this->pz_GetCache(array('id' => $bulk_id[0]));
			if (isset($data) && is_array($data)) {
				require_once ('pz-linkcard-cacheman-edit.php');
			}
		}
		break;
	case 'update':
		if (isset($data) && is_array($data) && isset($data['id'])) {
			$data['title']		= stripslashes($data['title']);
			$data['excerpt']	= stripslashes($data['excerpt']);
			$data['site_name']	= stripslashes($data['site_name']);
			if		($data['title']		==	$data['regist_title']) {
				$data['mod_title']		=	0;
			} else {
				$data['mod_title']		=	1;
			}
			if		($data['excerpt']		==	$data['regist_excerpt']) {
				$data['mod_excerpt']		=	0;
			} else {
				$data['mod_excerpt']		=	1;
			}
			$data	= $this->pz_SetCache($data);
			if (isset($data) && is_array($data) && isset($data['id'])) {
				echo '<div class="updated fade"><p><strong>'.__('Updated cache', $this->text_domain).'</strong></p></div>';
			} else {
				echo '<div class="error fade"><p><strong>'.__('Update failed', $this->text_domain).'</strong></p></div>';
			}
		} else {
			echo '<div class="error fade"><p><strong>'.__('Update failed', $this->text_domain).'</strong></p></div>';
		}
		break;
	case 'renew_sns':
		if (isset($bulk_id) && is_array($bulk_id)) {
			echo '<div class="updated fade"><p><strong>'.__('Social count renew', $this->text_domain).'...';
			foreach ($bulk_id as $data_id) {
				$data		= $this->pz_GetCache(array('id' => $data_id));
				if (isset($data) && is_array($data)) {
					$data['sns_nexttime']	= 0;
					$data = $this->pz_SetCache($data);
					$data = $this->pz_RenewSNSCount($data);
				}
				echo '..';
			}
			echo __('completed', $this->text_domain).'</strong></p></div>';
		}
		break;
	case 'renew_thumbnail':
		if (isset($bulk_id) && is_array($bulk_id)) {
			echo '<div class="updated fade"><p><strong>'.__('Thumbnail renew', $this->text_domain).'...';
			foreach ($bulk_id as $data_id) {
				$data		= $this->pz_GetCache(array('id' => $data_id));
				if (isset($data) && is_array($data)) {
					$data = $this->pz_GetThumbnail($data['thumbnail'] , true);
				}
				echo '..';
			}
			echo __('completed', $this->text_domain).'</strong></p></div>';
		}
		break;
	case 'alive':
		if (isset($bulk_id) && is_array($bulk_id)) {
			echo '<div class="updated fade"><p><strong>'.__('Alive check', $this->text_domain).'...';
			foreach ($bulk_id as $data_id) {
				$data		= $this->pz_GetCache(array('id' => $data_id));
				if (isset($data) && is_array($data)) {
					$data					=	$this->pz_GetCache($data);
					$after					=	$this->pz_GetCURL($data);
					$data['alive_result']	=	$after['result_code'];
					$data['alive_time']		=	$this->now;
					$data['alive_nexttime']	=	$this->now + WEEK_IN_SECONDS * 4;
					if	($data['title']		==	$after['title']) {
						$data['mod_title']	=	0;
					} else {
						$data['mod_title']	=	1;
					}
					if	($data['excerpt']		==	$after['excerpt']) {
						$data['mod_excerpt']	=	0;
					} else {
						$data['mod_excerpt']	=	1;
					}
					$data					=	$this->pz_SetCache($data);
				}
				echo '..';
			}
			echo __('completed', $this->text_domain).'</strong></p></div>';
		}
		break;
	case 'renew':
		if (isset($bulk_id) && is_array($bulk_id)) {
			echo '<div class="updated fade"><p><strong>'.__('Cache renew', $this->text_domain).'..';
			foreach ($bulk_id as $data_id) {
				echo '.('.$data_id.').';
				$data		= $this->pz_GetCache(array('id' => $data_id));
				if (isset($data) && is_array($data)) {
					$data		= $this->pz_GetHTML( array('url' => $data['url'], 'force' => true ) );
					$data		= $this->pz_SetCache( $data );
				}
			}
			echo '..';
			echo __('completed', $this->text_domain).'</strong></p></div>';
		}
		break;
	case 'delete':
		if (isset($bulk_id) && is_array($bulk_id)) {
			foreach ($bulk_id as $data_id) {
 				$this->pz_DelCache(array('id' => $data_id) );
			}
			echo '<div class="updated fade"><p><strong>'.__('Cache deleted', $this->text_domain).'</strong></p></div>';
		}
		break;
	case 'filemenu':
		// エクスポートファイルの準備
		$item			=	'id,url,site_name,domain,title,excerpt,thumbnail,favicon,sns_twitter,sns_facebook,sns_hatena,result_code,regist';
		$data_all		=	$wpdb->get_results("SELECT ".$item." FROM $this->db_name");
		$handle1		=	fopen($this->plugin_dir_path.'pz-linkcard-export-utf8.csv', 'w');
		$handle2		=	fopen($this->plugin_dir_path.'pz-linkcard-export-utf8-bom.csv', 'w');
		if ($handle1 != false && $handle2 != false) {
			fputs($handle1, $item."\n");
			$bom		=	pack('C*',0xEF,0xBB,0xBF);
			fputs($handle2, $bom.$item."\n");
			foreach($data_all as $data) {
				$rec = (array) $data;
				fputcsv($handle1, $rec);
				fputcsv($handle2, $rec);
			}
			fclose($handle1);
			fclose($handle2);
			echo '<form id="export" action="" method="post"><input type="button" id="export" class="button button-primary" value="'.__('Download Export File').'" onclick="window.open('."'".$this->plugin_dir_url.'pz-linkcard-export-utf8-bom.csv'."'".');" /></form>';

		}
		break;
	default:
		break;
	}
}

	require_once ('pz-linkcard-cacheman-list.php');
