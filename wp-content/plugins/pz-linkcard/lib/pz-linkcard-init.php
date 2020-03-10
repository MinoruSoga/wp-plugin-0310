<?php if (!function_exists("get_option")) die; ?>
<?php
		$this->options = get_option( 'Pz_LinkCard_options', $this->defaults );
		foreach( $this->defaults as $key => $value ) {
			if ( !isset( $this->options[$key] ) ) {
				$this->options[$key] = null;
			}
		}
		
		// サムネイルのキャッシュディレクトリの用意
		$wp_upload_dir	=	wp_upload_dir();
		$thumbnail_dir	=	$wp_upload_dir['basedir'].'/'.$this->slug.'/cache/';
		$thumbnail_url	=	$wp_upload_dir['baseurl'].'/'.$this->slug.'/cache/';
		if (!is_dir($thumbnail_dir)) {
			if (!wp_mkdir_p($thumbnail_dir)) {
				$thumbnail_dir			=	$this->plugin_dir_path.'cache/';
				$thumbnail_url			=	$this->plugin_dir_url .'cache/';
				if (!wp_mkdir_p($file_dir)) {
					$thumbnail_dir		=	null;
					$thumbnail_url		=	null;
				}
			}
		}
		$this->options['thumbnail-dir']	=	$thumbnail_dir;
		$this->options['thumbnail-url']	=	$thumbnail_url;
		
		// 暫定措置
		if ($this->options['plugin-version'] < '2.1.1') {
			$this->options['flg-edit-insert']	=	'1';
			$this->options['flg-edit-qtag']		=	'1';
		}
		if ($this->options['plugin-version'] < '2.1.7') {
			$this->options['flg-anker']		=	'1';
		}
		if ($this->options['plugin-version'] < '2.1.8') {
			if ($this->options['sns-tw'] && $this->options['sns-fb'] && $this->options['sns-hb']) {
				$this->options['sns-po']	=	'1';
			}
		}
		if ($this->options['plugin-version'] < '2.2.7') {
			$this->options['trim-url']		=	'400';
			$this->options['nowrap-url']	=	'1';
			$this->options['hover']			=	$this->options['opacity'];
		}
		if ($this->options['plugin-version'] < '2.2.9') {
			$this->options['ex-border-color']	=	$this->options['border-color'];
			$this->options['in-border-color']	=	$this->options['border-color'];
			$this->options['th-border-color']	=	$this->options['border-color'];
		}
		
		// 現バージョン
		$this->options['plugin-version'] = $this->defaults['plugin-version'];
		
		// オプションの更新
		update_option('Pz_LinkCard_options', $this->options);
		
		$this->pz_SetStyle();		// スタイルシート生成
		
		global $wpdb;
		$wpdb->hide_errors();
		
		require_once (ABSPATH.'wp-admin/includes/upgrade.php');
		$sql = "CREATE TABLE ".$this->db_name." (
					id				BIGINT			UNSIGNED	NOT NULL	AUTO_INCREMENT,
					url				VARCHAR(2048)	DEFAULT '',
					url_key			VARBINARY(255)	NOT NULL,
					scheme			VARCHAR(16)		DEFAULT '',
					domain			VARCHAR(253)	DEFAULT '',
					location		VARCHAR(2048)	DEFAULT '',
					address			VARCHAR(2048)	DEFAULT '',
					site_name		VARCHAR(100)	DEFAULT '',
					title			VARCHAR(200)	DEFAULT '',
					excerpt			VARCHAR(500)	DEFAULT '',
					thumbnail		VARCHAR(2048)	DEFAULT '',
					favicon			VARCHAR(2048)	DEFAULT '',
					means			VARCHAR(32)		DEFAULT '',
					charset			VARCHAR(32)		DEFAULT '',
					sns_time		BIGINT			UNSIGNED	NOT NULL	DEFAULT 0,
					sns_nexttime	BIGINT			UNSIGNED	NOT NULL	DEFAULT 0,
					sns_twitter		INT				DEFAULT -1,
					sns_facebook	INT				DEFAULT -1,
					sns_hatena		INT				DEFAULT -1,
					sns_pocket		INT				DEFAULT -1,
					post_id			INT				UNSIGNED	DEFAULT 0,
					post_date		DATETIME		NOT NULL	DEFAULT '0000-00-00 00:00:00',
					use_post_id1	INT				UNSIGNED,
					use_post_id2	INT				UNSIGNED,
					use_post_id3	INT				UNSIGNED,
					use_post_id4	INT				UNSIGNED,
					use_post_id5	INT				UNSIGNED,
					use_post_id6	INT				UNSIGNED,
					regist_title	VARCHAR(200)	DEFAULT '',
					regist_excerpt	VARCHAR(500)	DEFAULT '',
					regist_charset	VARCHAR(32)		DEFAULT '',
					regist_time		BIGINT			UNSIGNED	NOT NULL	DEFAULT 0,
					regist_result 	INT				DEFAULT -1,
					update_time		BIGINT			UNSIGNED	NOT NULL	DEFAULT 0,
					update_result 	INT				DEFAULT -1,
					mod_title		INT				UNSIGNED	NOT NULL	DEFAULT 0,
					mod_excerpt		INT				UNSIGNED	NOT NULL	DEFAULT 0,
					alive_time		BIGINT			UNSIGNED	NOT NULL	DEFAULT 0,
					alive_nexttime	BIGINT			UNSIGNED	NOT NULL	DEFAULT 0,
					alive_result	INT				DEFAULT -1,
					uptime			BIGINT			UNSIGNED	NOT NULL	DEFAULT 0,
					nexttime		BIGINT			UNSIGNED	NOT NULL	DEFAULT 0,
					link_type		INT				UNSIGNED,
					result_code		INT				DEFAULT -1,
					regist			DATETIME		NOT NULL	DEFAULT '0000-00-00 00:00:00',
					PRIMARY KEY		( id ),
					UNIQUE KEY		( url_key )
				) ".$wpdb->get_charset_collate()." ;";
		dbDelta($sql);
		
		// バグデータのメンテナンス（重複URLの削除）
		$result	= (array) $wpdb->get_results("SELECT url,id FROM $this->db_name ORDER BY url,id");
		$last_url	= null;
		$last_id	= null;
		if (isset($result) && is_array($result) && count($result) > 0) {
			foreach($result as $data) {
				if ($data->url == $last_url && $data->id <> $last_id) {
					$after		= $wpdb->delete($this->db_name, array('id' => $data->id), array('%d') );
				}
				$last_url		= $data->url;
				$last_id		= $data->id;
			}
		}
		
		// バグデータのメンテナンス（ハッシュURLの再生成）
		$result	= (array) $wpdb->get_results("SELECT id,url,url_key FROM $this->db_name ORDER BY id");
		if (isset($result) && is_array($result) && count($result) > 0) {
			foreach($result as $data) {
				$new_url_key	= hash( 'sha256', esc_url( $data->url ), true);
				if ($data->url_key <> $new_url_key) {
					$wpdb->update($this->db_name, array('url_key' => $new_url_key ) , array('id' => $data->id ) );
				}
			}
		}
		
		// 記事IDの再取得
		$result		=	$wpdb->get_results("UPDATE $this->db_name SET use_post_id1 = post_id , post_id = 0 WHERE (use_post_id1 IS NULL OR result_code = 0) AND post_id > 0");

//		// 記事IDの再取得（時間がかかるので未実行）
//		$result	= (array) $wpdb->get_results("SELECT id,url,use_post_id1,use_post_id2,use_post_id3,use_post_id4,use_post_id5,use_post_id6 FROM $this->db_name ORDER BY id");
//		if (isset($result) && is_array($result) && count($result) > 0) {
//			foreach($result as $data) {
//				$use_post_id_t			=	array();
//				if		($data->use_post_id1 > 0) {
//					$use_post_id_t[]	=	$data->use_post_id1;
//				}
//				if		($data->use_post_id2 > 0) {
//					$use_post_id_t[]	=	$data->use_post_id2;
//				}
//				if		($data->use_post_id3 > 0) {
//					$use_post_id_t[]	=	$data->use_post_id3;
//				}
//				if		($data->use_post_id4 > 0) {
//					$use_post_id_t[]	=	$data->use_post_id4;
//				}
//				if		($data->use_post_id5 > 0) {
//					$use_post_id_t[]	=	$data->use_post_id5;
//				}
//				if		($data->use_post_id6 > 0) {
//					$use_post_id_t[]	=	$data->use_post_id6;
//				}
//				$use_post_id_m			=	$wpdb->get_results($wpdb->prepare("SELECT id FROM $wpdb->prefix"."posts WHERE post_type = 'post' AND post_content LIKE '%%\"%s\"%%' ORDER BY id ASC", '"'.$data->url.'"'	));
//				foreach($use_post_id_m	as $use_post_id) {
//					$use_post_id_t[]		=	$use_post_id->id;
//				}
//				$use_post_id_t	=	array_unique($use_post_id_t);
//				$use_post_id_t	=	array_values($use_post_id_t);
//				$wpdb->update($this->db_name, array('use_post_id1' => $use_post_id_m[0]->id, 'use_post_id2' => $use_post_id_m[1]->id, 'use_post_id3' => $use_post_id_m[2]->id, 'use_post_id4' => $use_post_id_m[3]->id, 'use_post_id5' => $use_post_id_m[4]->id, 'use_post_id6' => $use_post_id_m[5]->id ) , array('id' => $data->id ) );
//			}
//		}
		
		// 過去バージョンからのコンバート（生存確認用のデータ作成）
		$result		=	$wpdb->get_results("UPDATE $this->db_name SET result_code = 200 WHERE result_code IS NULL OR result_code = 0");
		$result		=	$wpdb->get_results("UPDATE $this->db_name SET alive_result = result_code , alive_time = uptime WHERE alive_result IS NULL OR alive_result = 0 OR alive_time = 0");
		$result		=	$wpdb->get_results("UPDATE $this->db_name SET alive_nexttime = alive_time  WHERE alive_nexttime IS NULL OR alive_nexttime = 0");
		
		// 過去バージョンからのコンバート（取得時テキストの作成）
		$result		=	$wpdb->get_results("UPDATE $this->db_name SET regist_title = title , regist_excerpt = excerpt , regist_time = uptime , regist_result = result_code , regist_charset = charset WHERE (regist_title = '' AND regist_excerpt = '' ) AND (title <> '' OR excerpt <> '')");
		
		// 過去バージョンからのコンバート（次回SNS取得日時）
		$result		=	$wpdb->get_results("UPDATE $this->db_name SET sns_time = uptime , sns_nexttime = nexttime WHERE sns_nexttime = 0");
		
		// WP-CRONのフック
		wp_clear_scheduled_hook('pz_linkcard_check');
		wp_clear_scheduled_hook('pz_linkcard_alive');
