<?php
/*
Plugin Name: Pz-LinkCard
Plugin URI: http://poporon.poponet.jp/pz-linkcard
Description: リンクをカード形式で表示します。
Version: 2.3.1
Author: poporon
Author URI: http://poporon.poponet.jp
License: GPLv2 or later
*/

defined('ABSPATH') || die;

class Pz_LinkCard {
	public	$slug;					// スラッグ
	public	$text_domain;			// テキスト ドメイン（スラッグと同じ内容）

	public	$charset;				// 文字セット

	public	$amp;					// Google AMP

	public	$now;					// 現在日時（ローカル時間）
	public	$now_mysql;				// 現在日時（SQL形式）

	public	$plugin_basename;		// プラグイン ディレクトリの名前
	public	$plugin_dir_path;		// プラグイン ディレクトリのパス
	public	$plugin_dir_url;		// プラグイン ディレクトリのURL
	public	$plugin_link;			// プラグインページのURL

	public	$upload_dir_path;		// アップロード ディレクトリのパス
	public	$upload_dir_url;		// アップロード ディレクトリのURL

	private	$db_name;				// DB名

	public $options;
	protected	$defaults = array(
			'code1'				=>	'blogcard',
			'code2'				=>	null,
			'code3'				=>	null,
			'code4'				=>	null,
			'auto-atag'			=>	null,
			'auto-url'			=>	null,
			'auto-external'		=>	null,
			'trail-slash'		=>	'1',
			'border-width'		=>	'1px',
			'border-style'		=>	'solid',
			'border-color'		=>	'#888888',
			'width'				=>	'500px',
			'content-height'	=>	'108px',
			'margin-top'		=>	'4px',
			'margin-right'		=>	'16px',
			'margin-bottom'		=>	'16px',
			'margin-left'		=>	'4px',
			'card-top'			=>	null,
			'card-right'		=>	null,
			'card-bottom'		=>	null,
			'card-left'			=>	null,
			'centering'			=>	null,
			'radius'			=>	null,
			'shadow'			=>	null,
			'shadow-inset'		=>	null,
			'opacity'			=>	null,
			'hover'				=>	null,
			'special-format'	=>	null,
			'use-inline'		=>	null,
			'use-sitename'		=>	'1',
			'use-hatena'		=>	null,
			'display-url'		=>	'1',
			'display-excerpt'	=>	'1',
			'display-date'		=>	'1',
			'trim-title'		=>	80,
			'trim-url'			=>	250,
			'trim-count'		=>	250,
			'trim-sitename'		=>	45,
			'info-position'		=>	'1',
			'separator'			=>	null,
			'size-title'		=>	'16px',
			'size-url'			=>	'10px',
			'size-excerpt'		=>	'11px',
			'size-info'			=>	'12px',
			'size-added'		=>	'12px',
			'size-more'			=>	'12px',
			'size-plugin'		=>	'10px',
			'height-title'		=>	'24px',
			'height-url'		=>	'10px',
			'height-excerpt'	=>	'17px',
			'height-info'		=>	'12px',
			'height-added'		=>	'12px',
			'height-more'		=>	'40px',
			'height-plugin'		=>	'10px',
			'color-title'			=>	'#111111',
			'color-url'				=>	'#4466ff',
			'color-excerpt'			=>	'#333333',
			'color-info'			=>	'#222222',
			'color-added'			=>	'#222222',
			'color-more'			=>	'#444444',
			'color-plugin'			=>	'#888888',
			'outline-color-title'	=>	'#ffffff',
			'outline-color-url'		=>	'#ffffff',
			'outline-color-excerpt'	=>	'#ffffff',
			'outline-color-info'	=>	'#ffffff',
			'outline-color-added'	=>	'#ffffff',
			'outline-color-more'	=>	'#ffffff',
			'outline-color-plugin'	=>	'#ffffff',
			'nowrap-title'			=>	null,
			'nowrap-url'			=>	'1',
			'ex-bgcolor'			=>	'#ffffff',
			'in-bgcolor'			=>	'#f8f8f8',
			'th-bgcolor'			=>	'#eeeeee',
			'ex-border-color'		=>	'#888888',
			'in-border-color'		=>	'#888888',
			'th-border-color'		=>	'#888888',
			'in-get'			=>	null,
			'ex-image'			=>	null,
			'in-image'			=>	null,
			'th-image'			=>	null,
			'ex-info'			=>	null,
			'in-more-text'		=>	null,
			'th-more-text'		=>	null,
			'ex-more-text'		=>	null,
			'in-info'			=>	null,
			'th-info'			=>	null,
			'in-target'			=>	null,
			'ex-target'			=>	'2',
			'ex-thumbnail'		=>	'13',
			'in-thumbnail'		=>	'1',
			'ex-favicon'		=>	'3',
			'in-favicon'		=>	'3',
			'favicon-api'		=>	'https://www.google.com/s2/favicons?domain=%DOMAIN%',
			'thumbnail-api'		=>	'https://s.wordpress.com/mshots/v1/%URL%?w=100',
			'thumbnail-position'=>	'2',
			'thumbnail-width'	=>	'100px',
			'thumbnail-height'	=>	'108px',
			'thumbnail-shadow'	=>	null,
			'thumbnail-resize'	=>	'1',
			'cache-time'		=>	31536000,
			'user-agent'		=>	null,
			'flg-more'			=>	null,
			'flg-referer'		=>	'1',
			'flg-agent'			=>	'1',
			'flg-redir'			=>	'1',
			'flg-alive'			=>	'1',
			'flg-alive-count'	=>	null,
			'flg-ssl'			=>	'1',
			'flg-amp-url'		=>	null,
			'flg-relative-url'	=>	null,
			'flg-idn'			=>	'1',
			'flg-anker'			=>	'1',
			'flg-unlink'		=>	'1',
			'flg-get-pid'		=>	null,
			'flg-subdir'		=>	'1',
			'flg-invalid'		=>	null,
			'flg-edit-insert'	=>	'1',
			'flg-edit-qtag'		=>	'1',
			'flg-do-shortcode'	=>	null,
			'style-reset-img'	=>	'1',
			'style'				=>	null,
			'css-add'			=>	null,
			'css-sp'			=>	null,
			'css-file'			=>	null,
			'css-path'			=>	null,
			'css-url'			=>	null,
			'class-pc'			=>	null,
			'class-mobile'		=>	null,
			'sns-position'		=>	'2',
			'sns-tw'			=>	'1',
			'sns-fb'			=>	'1',
			'sns-hb'			=>	'1',
			'sns-po'			=>	'1',
			'link-all'			=>	'1',
			'blockquote'		=>	null,
			'nofollow'			=>	null,
			'presence'			=>	null,
			'thumbnail-dir'		=>	null,
			'thumbnail-url'		=>	null,
			'invalid-url'		=>	null,
			'invalid-time'		=>	null,
			'plugin-link'		=>	null,
			'plugin-name'		=>	'Pz-LinkCard',
			'plugin-version'	=>	'2.3.1',
			'plugin-url'		=>	'https://popozure.info/pz-linkcard',
			'pz-hbc-options'	=>	null,
			'debug-time'		=>	null
		);

	public function __construct() {
		$this->slug				=	basename(dirname(__FILE__));
		$this->text_domain		=	$this->slug;
		
		$this->charset			=	get_bloginfo('charset');
		
		$this->amp				=	'1';
		
		$this->now				=	current_time('timestamp', false);
		$this->now_mysql		=	current_time('mysql');
		
		$this->plugin_basename	=	plugin_basename(__FILE__);
		$this->plugin_dir_path	=	plugin_dir_path(__FILE__);
		$this->plugin_dir_url	=	plugin_dir_url (__FILE__);
		
		$wp_upload_dir	= wp_upload_dir();
		$this->upload_dir_path	=	$wp_upload_dir['basedir'].'/'.$this->slug.'/';
		$this->upload_dir_url	=	$wp_upload_dir['baseurl'].'/'.$this->slug.'/';
		
		$this->options = get_option('Pz_LinkCard_options', $this->defaults );
		foreach ($this->defaults as $key => $value) {
			if (!isset($this->options[$key])) {
				$this->options[$key] = null;
			}
		}
		
		// DB
		global $wpdb;
		$this->db_name			= $wpdb->prefix.'pz_linkcard';
		
		// バージョンが違っていたら、DBとオプションを更新する
		if ($this->options['plugin-version'] <> $this->defaults['plugin-version']) {
			$this->activate();
		}
		
		// ショートコードの設定
		if ($this->options['auto-atag'] || $this->options['auto-url']) {
			add_filter		('the_content',					array($this, 'auto_replace') );		// 自動置き換え
			add_shortcode	('pz-linkcard-auto-replace',	array($this, 'shortcode') );		// 自動置き換え専用ショートコード
		}
		if ($this->options['code1']) {
			add_shortcode($this->options['code1'], array($this, 'shortcode'));
		}
		if ($this->options['code2']) {
			add_shortcode($this->options['code2'], array($this, 'shortcode'));
		}
		if ($this->options['code3']) {
			add_shortcode($this->options['code3'], array($this, 'shortcode'));
		}
		if ($this->options['code4']) {
			add_shortcode($this->options['code4'], array($this, 'shortcode'));
		}
		
		// 日本語化
		load_plugin_textdomain		($this->text_domain, false, $this->slug.'/languages');
		
		// 管理画面のとき
		if (is_admin()) {
			register_activation_hook	(__FILE__,							array($this, 'activate') );			// 有効化したときの処理
			register_deactivation_hook	(__FILE__,							array($this, 'deactivate') );		// 無効化したときの処理
			add_action		('admin_menu',									array($this, 'add_menu') );			// 設定メニュー
			add_action		('admin_enqueue_scripts',						array($this, 'enqueue_admin') );	// 設定メニュー用スクリプト
			add_action		('admin_print_footer_scripts',					array($this, 'add_footer') );		// テキストエディタ用クイックタグ
			add_action		('admin_notices',								array($this, 'add_notices'));		// 注意書き
			add_filter		('mce_buttons',									array($this, 'add_mce_button') );	// ビジュアルエディタ用ボタン
			add_filter		('mce_external_plugins',						array($this, 'add_mce_plugin') );	// ビジュアルエディタ用ボタン
			add_filter		('plugin_action_links_'.$this->plugin_basename,	array($this, 'action_links') );		// プラグイン画面
		} else {
			add_action('wp_enqueue_scripts', array($this, 'enqueue'));
		}
		
		add_action( 'pz_linkcard_check', array( $this, 'schedule_hook_check' ) );
		add_action( 'pz_linkcard_alive', array( $this, 'schedule_hook_alive' ) );
		
		if (!wp_next_scheduled('pz_linkcard_check')) {
			wp_schedule_event		( time() + 10	, 'hourly',	'pz_linkcard_check');
		}
		if (!wp_next_scheduled('pz_linkcard_alive')) {
			wp_schedule_event		( time() + 1800	, 'daily',	'pz_linkcard_alive');
		}
	}

	// テキストリンクの行とURLのみの行をリンクカードへ置き換える処理（直接HTMLタグにするのでは無くショートコードに変換する。）
	public function auto_replace($content) {
		if (!$this->options['auto-external']) {
			if ($this->options['auto-atag']) {
				$content	=	preg_replace( '/(^|<br ?\/?>)(<p.*>)?<a .*href=[\'"](https?:\/\/[-_\.!~*()a-zA-Z0-9;\/?:\@&=+\$,%#]+)[\'"]((?!<IMG).)*<\/a>(<\/p>)?$/im', '[pz-linkcard-auto-replace url="$3"]', $content);
			}
			if ($this->options['auto-url']) {
				$content	=	preg_replace( '/(^|<br ?\/?>)(<p.*>)?(https?:\/\/[-_\.!~*()a-zA-Z0-9;\/?:\@&=+\$,%#]+)(<\/p>|<br ?\/?>)?$/im', '[pz-linkcard-auto-replace url="$3"]', $content);
			}
			if ($this->options['flg-do-shortcode']) {
				$content	=	do_shortcode($content);
			}
			return $content;
		} else {
			if ($this->options['auto-atag']) {
				preg_match_all('/(^|<br ?\/?>)(<p.*>)?(<a .*href=[\'"](https?:\/\/[-_\.!~*()a-zA-Z0-9;\/?:\@&=+\$,%#]+)[\'"]((?!<IMG).)*<\/a>)(<\/p>)?$/im', $content, $m );
				for ($i=0; $i<count($m[0]); $i++) {
					$url = $m[4][$i];
					if ($this->Pz_LinkType($url ) == 0) {
						$tag = '[pz-linkcard-auto-replace url="'.$url.'"]';
						$content = preg_replace('{'.$m[0][$i].'}', $tag, $content, 1);
					}
				}
			}
			if ($this->options['auto-url']) {
				preg_match_all('/(^|<br ?\/?>)(<p.*>)?(https?:\/\/[-_\.!~*()a-zA-Z0-9;\/?:\@&=+\$,%#]+)(<\/p>|<br ?\/?>)?$/im', $content, $m );
				for ($i=0; $i<count($m[0]); $i++) {
					$url = $m[3][$i];
					if ($this->Pz_LinkType($url ) == 0) {
						$tag = '[pz-linkcard-auto-replace url="'.$url.'"]';
						$content = preg_replace('{'.$m[0][$i].'}', $tag, $content, 1);
					}
				}
			}
			if ($this->options['flg-do-shortcode']) {
				$content	=	do_shortcode($content);
			}
			return $content;
		}
	}

	// ショートコード処理
	public function shortcode($atts, $content = null, $shortcode) {
		// 実行時間
		if ($this->options['debug-time']) {
			$start_time = microtime(true);
			echo	PHP_EOL.'<!-- Pz-LkC [Debug mode: On] /-->'.PHP_EOL;
			echo	'<!-- Pz-LkC [Shortcode] /-->'.PHP_EOL;
		}
		
		// URL
		$url			=	'';
		if				(isset( $atts['url'] ) ) {
			$url		=	$atts['url'];
		} elseif		(isset( $atts['href'] ) ) {			// Aタグのようにhrefパラメータも有効にする
			$url		=	$atts['href'];
		} elseif		(isset( $atts['uri'] ) ) {			// 密かに記述ミス対応（uriやurIでもurlとして判定する）
			$url		=	$atts['uri'];
		} elseif		(isset( $atts['ur1'] ) ) {			// 密かに記述ミス対応（ur1でもurlとして判定する）
			$url		=	$atts['ur1'];
		} elseif 		(isset( $atts[0] ) ) {				// 謎の記述ミスに対応
			if			(preg_match('/url=[\s　\'\"‘’“”″]*(.*?)[\s　\'\"‘’“”″]*$/u', $atts[0], $m)) {
				$url	=	$m[1];
			} elseif 		(isset( $atts[1] ) ) {			// 謎の記述ミスに対応
				if			(preg_match('/url=[\s　\'\"‘’“”″]*(.*?)[\s　\'\"‘’“”″]*$/u', $atts[1], $m)) {
					$url	=	$m[1];
				}
			}
		}
		$url_org		=	$url;							// 指定されたurlパラメータ
		if ($this->options['flg-relative-url']) {
			if (substr($url, 0, 1) == '/') {
				$url	=	home_url() . $url;
			}
		}
		$url			=	$this->pz_TrimURL( $url );		// URLエンティティ化など（無害化？）
		if			( !$url ) {
			if ($this->options['debug-time']) {
				echo	'<!-- Pz-LkC ['.html_entity_decode(print_r($atts, true)).'] /-->'.PHP_EOL;
			}
			if (!$this->options['flg-invalid']) {
				if (!preg_match('/\/wp-admin\/admin-ajax.php/i', $_SERVER["REQUEST_URI"])) {
					$this->options['flg-invalid']		=	'1';
					$this->options['invalid-url']		=	(!$_SERVER["HTTPS"] ? "http://" : "https://").$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"];
					$this->options['invalid-time']		=	$this->now;
					$result = update_option('Pz_LinkCard_options', $this->options);
				}
			}
			return '<a name="pz-lkc-error"></a><div class="lkc-error"><div class="lkc-card"><div class="lkc-this-wrap"><div class="lkc-excerpt">'.$this->slug.': '.__('Incorrect URL specification.', $this->text_domain).'(url='.html_entity_decode($url_org).')'.PHP_EOL.'<!-- '.html_entity_decode(print_r($atts, true)).' /-->'.PHP_EOL.'</div></div></div></div>';
		}
		$atts['url']	=	$url;
		
		// titleパラメータ
		$s_title		=	isset($atts['title'] ) ? $atts['title'] : null;
		
		// contentパラメータ
		if				(isset($atts['content'] ) ) {
			$s_excerpt	=	$atts['content'];
		} elseif		(isset($atts['contents'] ) ) {
			$s_excerpt	=	$atts['contents'];
		} elseif		(isset($atts['description'] ) ) {
			$s_excerpt	=	$atts['description'];
		} else {
			$s_excerpt	=	null;
		}
		
		// 囲まれ文字（ショートコード1のみ有効）
		if ($shortcode == $this->options['code1']) {
			switch (isset($this->options['use-inline']) ? $this->options['use-inline'] : null) {
			case '1':
				$s_excerpt	= isset($content) ? $content : '';
				break;
			case '2':
				$s_title	= isset($content) ? $content : '';
				break;
			}
		}
		
		// 記事内容取得
		$data	= $this->pz_GetHTML ( $atts );
		
		// 実行時間
		if ($this->options['debug-time']) {
			$end_time		= microtime(true);
			$elasped_time	= number_format($end_time - $start_time, 8, '.', ',');
			echo	'<!-- Pz-LkC [ElaspedTime='.$elasped_time.'sec] /-->'.PHP_EOL;
		}
		
		return	$data;
	}

	// キャッシュやリンク先からリンクカードのHTMLを生成
	function pz_GetHTML( $atts, $content = null ) {
		if ($this->options['debug-time']) {
			echo	'<!-- Pz-LkC [GetHTML] /-->'.PHP_EOL;
		}
		
		// モバイルチェック
		if (function_exists('wp_is_mobile') && wp_is_mobile()) {
			$is_mobile		= true;
		} else {
			$is_mobile		= false;
		}
		if ($this->options['debug-time']) {
			echo	'<!-- Pz-LkC [MOBILE='.$is_mobile.'] /-->'.PHP_EOL;
		}
		
		$url			= $atts['url'];
		if (!isset($url) || $url == '' ) {
			return null;
		}
		if ($this->options['debug-time']) {
			echo	'<!-- Pz-LkC [URL='.$url.'] /-->'.PHP_EOL;
		}
		
		// URLパース（ドメイン名などを抽出）
		$url_m			=	parse_url( $url );
		$scheme			=	$url_m['scheme'];						// スキーム
		$domain			=	$url_m['host'];							// ドメイン名
		$domain_url		=	$scheme.'://'.$url_m['host'];			// ドメインURL
		$location		=	substr($url, mb_strlen($domain_url));	// ドメイン名以降
		
		// 自サイトチェック
		$link_type		=	$this->Pz_LinkType($url);
		
		// モバイルかPCかのクラス名を追加
		$class_id		= 'linkcard';
		if ($is_mobile && $this->options['class-mobile']) {
			$class_id .= ' '.$this->options['class-mobile'];
		} elseif ($this->options['class-pc']) {
			$class_id .= ' '.$this->options['class-pc'];
		}
		
		// キャッシュから取得
		$data_id		= null;
		$data			= array();
		$data['url']	= $url;
		$result			= $this->pz_GetCache( $data );
		if (isset($result) && is_array($result) && isset($result['url'])) {
			$data		= $result;
			$data_id	= $data['id'];
			$url		= $data['url'];
		}
		if ($this->options['debug-time']) {
			echo	'<!-- Pz-LkC [CACHE='.$data_id.'] /-->'.PHP_EOL;
		}
		
		// 内部リンクの処理
		if ( $link_type ) {
			// リンクターゲットの設定
			$target			=	'';					// 同ページに開く
			if (isset($this->options['in-target'])) {
				if ($this->options['in-target'] == '1' || ($this->options['in-target'] == '2' && !$is_mobile)) {
					$target	=	' target="_blank"';	// 新しいページで開く
				}
			}
			
			// followパラメータ
			if	( (isset($atts['follow'] ) && mb_strtolower($atts['follow']) == 'no') || (isset($atts['nofollow'] ) && mb_strtolower($atts['nofollow']) == 'true') ) {
				$nofollow	=	' rel="nofollow"';		// nofollow指定。趣味の問題？
			} else {
				$nofollow	=	'';
			}
			
			// キャッシュが無い、もしくは強制取得
			if ( is_null($data_id) || ( isset($atts['force']) && $atts['force'] == true ) ) {
				if ($this->options['debug-time']) {
					echo	'<!-- Pz-LkC [IN-POST] /-->'.PHP_EOL;
				}
				$data				=	$this->pz_GetPost( $data );		// 最新記事内容を取得
				$data['link_type']	=	1;
				if ($this->options['debug-time']) {
					echo	'<!-- Pz-LkC [IN-SET] /-->'.PHP_EOL;
				}
				$result				=	$this->pz_SetCache( $data );	// 保存
			} elseif ($this->options['in-get'] <> 2) {
				if ($this->options['debug-time']) {
					echo	'<!-- Pz-LkC [IN-POST] /-->'.PHP_EOL;
				}
				$data				=	$this->pz_GetPost( $data );		// 最新記事内容を取得
				$data['link_type']	=	1;
			}
		}
		
		// 外部リンクの処理
		if ( !$link_type ) {
			// リンクターゲットの設定
			$target			=	'';					// 同ページに開く
			if	(isset($this->options['ex-target'] ) ) {
				if	($this->options['ex-target'] == '1' || ($this->options['ex-target'] == '2' && !$is_mobile ) ) {
					$target	= ' target="_blank"';	// 新しいページで開く
				}
			}
			
			// followパラメータ
			if	(isset($this->options['nofollow'] ) || (isset($atts['follow'] ) && mb_strtolower($atts['follow']) == 'no') || (isset($atts['nofollow'] ) && mb_strtolower($atts['nofollow']) == 'true') ) {
				$nofollow	=	' rel="nofollow"';		// nofollow指定。趣味の問題？
			} else {
				$nofollow	=	'';
			}
			
			// キャッシュが無い、もしくは強制取得
			if ( is_null($data_id) || ( isset($atts['force']) && $atts['force'] == true ) ) {
				if ($this->options['debug-time']) {
					echo	'<!-- Pz-LkC [OUT-CURL] /-->'.PHP_EOL;
				}
				$result			= $this->pz_GetCURL( $data );		// cURLで記事内容を取得
				if ( isset($result) && is_array($result) && isset($result['url']) ) {
					$data		= $result;
					$data['link_type']	= 0;
					$result		= $this->pz_SetCache( $data );
				}
			}
		}
		
		// 念のため初期化
		$data_id		= (isset($data['id'])			? $data['id'] : null);
		$site_name		= (isset($data['site_name'])	? $data['site_name'] : null);
		$title			= (isset($data['title'])		? $data['title'] : null);
		$excerpt		= (isset($data['excerpt'])		? $data['excerpt'] : null);
		$post_date		= (isset($data['post_date'])	? $data['post_date'] : null);
		$thumbnail_url	= (isset($data['thumbnail'])	? $data['thumbnail'] : null);
		$favicon_url	= (isset($data['favicon'])		? $data['favicon'] : null);
		$result_code	= (isset($data['result_code'])	? $data['result_code'] : null);
		$sns_tw			= (isset($data['sns_twitter'])	? $data['sns_twitter'] : null);
		$sns_fb			= (isset($data['sns_facebook'])	? $data['sns_facebook'] : null);
		$sns_hb			= (isset($data['sns_hatena'])	? $data['sns_hatena'] : null);
		$sns_po			= (isset($data['sns_pocket'])	? $data['sns_pocket'] : null);
		$alive_result	= (isset($data['alive_result'])	? $data['alive_result'] : null);
		
		$thumbnail		= null;
		$favicon		= null;
		
		// ラッピング
		switch ($link_type) {
		case '1':
			$wrap_op		=	'<div class="lkc-this-wrap">';
			$wrap_cl		=	'</div>';
			$added_op		=	'<div class="lkc-this-added">';
			$added_cl		=	'</div>';
			$more			=	null;
			$more_text		=	null;
			$info			=	isset($this->options['th-info'])		? $this->options['th-info']			: null ;
			$sw_thumbnail	=	isset($this->options['in-thumbnail'])	? $this->options['in-thumbnail']	: '0' ;
			$sw_favicon		=	isset($this->options['in-favicon'])	? $this->options['in-favicon']		: '0' ;
			break;
		case '2':
			$wrap_op		=	'<div class="lkc-internal-wrap">';
			$wrap_cl		=	'</div>';
			$added_op		=	'<div class="lkc-internal-added">';
			$added_cl		=	'</div>';
			$more			=	isset($this->options['flg-more'])		? $this->options['flg-more']		: null ;
			$more_text		=	isset($this->options['in-more-text'])	? $this->options['in-more-text']	: null ;
			$info			=	isset($this->options['in-info'])		? $this->options['in-info']			: null ;
			$sw_thumbnail	=	isset($this->options['in-thumbnail'])	? $this->options['in-thumbnail']	: '0' ;
			$sw_favicon		=	isset($this->options['in-favicon'])	? $this->options['in-favicon']		: '0' ;
			break;
		default:
			$wrap_op		=	'<div class="lkc-external-wrap">';
			$wrap_cl		=	'</div>';
			$added_op		=	'<div class="lkc-external-added">';
			$added_cl		=	'</div>';
			$more			=	isset($this->options['flg-more'])		? $this->options['flg-more']		: null ;
			$more_text		=	isset($this->options['ex-more-text'])	? $this->options['ex-more-text']	: null ;
			$info			=	isset($this->options['ex-info'])		? $this->options['ex-info']			: ''  ;
			$sw_thumbnail	=	isset($this->options['ex-thumbnail'])	? $this->options['ex-thumbnail']	: '0' ;
			$sw_favicon		=	isset($this->options['ex-favicon'])	? $this->options['ex-favicon']		: '0' ;
			break;
		}
		
		// 外部リンクの処理
		if ( !$link_type && isset($this->options['use-hatena']) && !is_null($this->options['use-hatena'] ) ) {
			// 「はてなブログカード」をそのまま利用する
			$tag = '<div class="lkc-iframe-wrap"><iframe src="https://hatenablog-parts.com/embed?url=' .$url.'" class="lkc-iframe" scrolling="no" frameborder="0"></iframe></div>';
			if (isset($this->options['blockquote']) ? $this->options['blockquote'] : null == '1') {
				$tag = '<div class="'.$class_id.'"><blockquote class="lkc-quote">'.$tag.'</blockquote></div>';
			} else {
				$tag = '<div class="'.$class_id.'">'.$tag.'</div>';
			}
			return $tag;		// タグを出力してさっさと終了
		}
		
		// サムネイル取得
		if ( !$this->options['thumbnail-position'] || ( $result_code <> 0 && $result_code <> 200 ) ) {
			$thumbnail = null;
		} else {
			if ($sw_thumbnail == '1' || $sw_thumbnail == '13') {				// 直接取得
				if ( !$link_type ) {
					$thumbnail_url = $this->pz_GetThumbnail($thumbnail_url);	// 外部サイトのサムネイルをキャッシュ
				}
				if ( isset($thumbnail_url) && $thumbnail_url <> '' ) {
					$thumbnail = '<img class="lkc-thumbnail-img" src="'.$thumbnail_url.'" alt="" />';
				} elseif ($sw_thumbnail == '13') {								// 直接取得に失敗
					$sw_thumbnail = '3';
				}
			}
			if ($sw_thumbnail == '3') {											// WebAPIを利用
				// 画像取得（WebAPI）
				if (isset($this->options['thumbnail-api'])) {
					$thumbnail = preg_replace('/%DOMAIN_URL%/', $domain_url, $this->options['thumbnail-api'] );
					$thumbnail = preg_replace('/%DOMAIN%/', $domain, $thumbnail);
					$thumbnail = preg_replace('/%URL%/', rawurlencode($url), $thumbnail);
					$thumbnail = '<img class="lkc-thumbnail-img" src="'.$thumbnail.'" alt="" />';
				}
			}
		}
		
		// ファビコン取得
		if (!isset($this->options['info-position'])) {
			$favicon = null;
		} else{
			if ($sw_favicon == '1' || $sw_favicon == '13') {					// 直接取得
				if ( !is_null($favicon_url ) ) {
					$favicon = '<img class="lkc-favicon" src="'.$favicon_url.'" alt="" width=16 height=16 />';
				} elseif ($sw_favicon == '13') {								// 直接取得に失敗
					$sw_favicon == '3';
				}
			}
			if ($sw_favicon == '3') {											// WebAPIを利用
				// サイトアイコン取得（WebAPI）
				if (isset($this->options['favicon-api'])) {
					$favicon = preg_replace('/%DOMAIN_URL%/', $domain_url, $this->options['favicon-api'] );
					$favicon = preg_replace('/%DOMAIN%/', $domain, $favicon);
					$favicon = preg_replace('/%URL%/', rawurlencode($url), $favicon);
					$favicon = '<img class="lkc-favicon" src="'.$favicon.'" alt="" width=16 height=16 />';
				}
			}
		}
		
		// タイトル
		if (!isset($title) || $title == '') {
			$title		= esc_html($url);					// タイトル取得できていなかったらURLをセットする
		}
		
		// パラメータ取得（タイトル・抜粋文）
		if (isset($atts['title'])) {						// titleパラメータ
			$title			=	$atts['title'];
			$excerpt		=	'';
		}
		if ($excerpt		==	'') {
			if			(isset($atts['content'])) {			// contrentパラメータ
				$excerpt	=	$atts['content'];
			} elseif	(isset($atts['contents'])) {		// contentsパラメータ
				$excerpt	=	$atts['contents'];
			} elseif	(isset($atts['description'])) {		// descriptionパラメータ
				$excerpt	=	$atts['description'];
			}
		}
		
		// タイトル整形
		if (isset($title)) {
			$str	= $title;
			$str	= strip_tags($str);									// タグの除去
			$str	= str_replace(array("\r", "\n"),	'', $str);		// 改行削除
			$str	= esc_html($str);									// 念のためエスケープ
			$str	= mb_strimwidth($str, 0, (isset($this->options['trim-title']) ? $this->options['trim-title'] : $this->defaults['trim-title'] ) , '...');
			$title	= $str;
		}
		
		// 抜粋文整形（抜粋文非表示の場合、空欄にする）
		if (!isset($this->options['display-excerpt']) || is_null($this->options['display-excerpt'])) {
			$excerpt = '';
		} else {
			if (isset($excerpt)) {
				$str	= $excerpt;
				$str	= strip_tags($str);									// タグの除去
				$str	= preg_replace('/<!--more-->.+/is',	'', $str);		// moreタグ以降削除
				$str	= preg_replace('/\[[^]]*\]/',		'', $str);		// ショートコードすべて除去
				$str	= str_replace(array("\r", "\n"),	'', $str);		// 改行削除
				$str	= esc_html($str);									// 念のためエスケープ
				$str	= mb_strimwidth($str, 0, (isset($this->options['trim-count']) ? $this->options['trim-count'] : $this->defaults['trim-count'] ) , '...');
				$excerpt	= $str;
			}
		}
		
		// サイト名称を使わない場合、ドメイン名で上書き
		$site_title = '';
		if ((isset($this->options['use-sitename']) ? $this->options['use-sitename'] : null) && $site_name) {
			$c_site_name = $site_name;
			$site_name = mb_strimwidth($site_name, 0, (isset($this->options['trim-sitename']) ? $this->options['trim-sitename'] : $this->defaults['trim-sitename'] ) , '...');
			if ($site_name <> $c_site_name) {
				$site_title = ' title="'.$c_site_name.'"';
			}
		} else {
			$site_name = $domain;
			// 日本語ドメイン対応
			if (isset($this->options['flg-idn']) ? true : false) {
				if (function_exists('idn_to_utf8')) {
					if (substr( $domain, 0, 4 ) == 'xn--') {
						$site_name	=	idn_to_utf8( $domain );
					}
				}
			}
		}
		
		// リンク先URL
		if ( (isset($this->options['flg-unlink']) ? true : false) && (array_search($alive_result, array('403','404','410'))) ) {
			// Not found の時は見え消ししてリンクしない
			$a_op_all	= '<div style="cursor: not-allowed;" title="">';
			$a_cl_all	= '</div>';
			$a_op		= '';
			$a_cl		= '';
			$st_op		= '<strike>';
			$st_cl		= '</strike>';
		} elseif ((isset($this->options['link-all']) ? $this->options['link-all'] : null) == '1') {
			// カード全体をリンク（どこをクリックしても良いのが分かり易い）
			$a_op_all	= '<a class="lkc-link no_icon" href="'.$url.'"'.$target.$nofollow.'>';
			$a_cl_all	= '</a>';
			$a_op		= '';
			$a_cl		= '';
			$st_op		= '';
			$st_cl		= '';
		} else {
			// タイトルとかURLとかを個別でリンク（タイトルや抜粋文などの文字を範囲指定をしてコピー等がし易い）
			$a_op_all	= '';
			$a_cl_all	= '';
			$a_op		= '<a class="lkc-link no_icon" href="'.$url.'"'.$target.$nofollow.'>';
			$a_cl		= '</a>';
			$st_op		= '';
			$st_cl		= '';
		}
		
		// ソーシャルカウントの表示
		$sns		= null;
		$sns_info	= null;
		$sns_title	= null;
		if ( isset($this->options['sns-position']) ? $this->options['sns-position'] : null ) {
			$sns	=	'';
			// カード全体をリンクにするときは表示のみ
			if ((isset($this->options['link-all']) ? $this->options['link-all'] : null) == '1') {
				if (isset($this->options['sns-tw']) && !is_null($this->options['sns-tw']) && $sns_tw > 0) {
					$sns .= ' <div class="lkc-sns-tw">'.$sns_tw.'&nbsp;tweet'.(($sns_tw > 1) ? 's' : '').'</div>';
				}
				if (isset($this->options['sns-fb']) && !is_null($this->options['sns-fb']) && $sns_fb > 0) {
					$sns .= ' <div class="lkc-sns-fb">'.$sns_fb.'&nbsp;share'.(($sns_fb > 1) ? 's' : '').'</div>';
				}
				if (isset($this->options['sns-hb']) && !is_null($this->options['sns-hb']) && $sns_hb > 0) {
					$sns .= ' <div class="lkc-sns-hb">'.$sns_hb.'&nbsp;user'.(($sns_hb > 1) ? 's' : '').'</div>';
				}
				if (isset($this->options['sns-po']) && !is_null($this->options['sns-po']) && $sns_po > 0) {
					$sns .= ' <div class="lkc-sns-po">'.$sns_po.'&nbsp;pocket'.(($sns_po > 1) ? 's' : '').'</div>';
				}
			} else {
				// 外部リンクアイコンを表示させるプラグイン対応のため no_icon を付与
				if (isset($this->options['sns-tw']) && !is_null($this->options['sns-tw']) && $sns_tw > 0) {
					$sns .= ' <a class="lkc-sns-tw no_icon" href="https://twitter.com/search?q=' .preg_replace('/.*\/\/(.*)/', '$1', $url).'&text='.esc_html($title).'" target="_blank">'.$sns_tw.'&nbsp;tweet'.(($sns_tw > 1) ? 's' : '').'</a>';
				}
				if (isset($this->options['sns-fb']) && !is_null($this->options['sns-fb']) && $sns_fb > 0) {
					$sns .= ' <a class="lkc-sns-fb no_icon" href="https://www.facebook.com/" target="_blank">'.$sns_fb.'&nbsp;share'.(($sns_fb > 1) ? 's' : '').'</a>';
				}
				if (isset($this->options['sns-hb']) && !is_null($this->options['sns-hb']) && $sns_hb > 0) {
					$sns .= ' <a class="lkc-sns-hb no_icon" href="https://b.hatena.ne.jp/entry/s/' .preg_replace('/.*\/\/(.*)/', '$1', $url).'" target="_blank">'.$sns_hb.'&nbsp;user'.(($sns_hb > 1) ? 's' : '').'</a>';
				}
				if (isset($this->options['sns-po']) && !is_null($this->options['sns-po']) && $sns_po > 0) {
					$sns .= ' <a class="lkc-sns-po no_icon" href="https://getpocket.com/" target="_blank">'.$sns_po.'&nbsp;pocket'.(($sns_po > 1) ? 's' : '').'</a>';
				}
			}
			if ($sns) {
				if ($this->options['sns-position'] == '1') {
					$sns_title	= '<div class="lkc-share">'.$sns.'</div>';
				} else {
					$sns_info	= '&nbsp;'.'<div class="lkc-share">'.$sns.'</div>';
				}
			}
		}
		
		// サムネイル
		if ($thumbnail) {
			$thumbnail = '<figure class="lkc-thumbnail">'.$thumbnail.'</figure>';
		}
		
		// 日本語ドメイン対応
		if (isset($this->options['flg-idn']) ? true : false) {
			if (function_exists('idn_to_utf8')) {
				if (substr( $domain, 0, 4 ) == 'xn--') {
					$url		=	$scheme.'://'.idn_to_utf8( $domain ).$location;
				}
			}
		}
		
		// 続きを読むボタン
		if ( $more && $more_text ) {
			$moretag	=	'<div class="lkc-more">'.$a_op.'<div class="lkc-more-text">'.$more_text.'</div>'.$a_cl.'</div>';
		} else {
			$moretag	=	'';
		}
		
		// リンク先URL
		$url1			=	'';
		$url2			=	'';
		if ($this->options['display-url']) {
			if ($this->options['display-url'] == '2') {
				$url2	=	'&nbsp;<div class="lkc-url-info"><cite>'.$st_op.$a_op.$url.$st_cl.$a_cl.'</cite></div>';
			} else {
				$url1	=	'<div class="lkc-url"><cite>'.$st_op.$a_op.$url.$st_cl.$a_cl.'</cite></div>';
			}
		}
		
		// サイト情報
		if ($info) {
			$added_info	=	$added_op.$info.$added_cl;
		} else {
			$added_info	=	'';
		}
		if ($this->options['display-date'] && $link_type) {
			$post_date = '<div class="lkc-date">'.date('Y.m.d', strtotime($post_date)).'</div>';
		} else {
			$post_date = '';
		}
		$domain_info	=	'<div class="lkc-info">'.$a_op.$favicon.'<div class="lkc-domain"'.$site_title.'>'.$site_name.'</div>'.$added_info.$a_cl.$sns_info.$url2.$post_date.'</div>';
		
		// 記事内容
		//$content = '<div class="lkc-content">'.$a_op.$thumbnail.'<div class="lkc-title"><div class="lkc-title-text">'.$title.'</div>'.$a_cl.$sns_title.'</div>'.$url1.'<div class="lkc-excerpt">'.$excerpt.'</div>'.$moretag.'</div>';
		
		// Google AMPに対応
		if ( (function_exists('is_amp_endpoint') && is_amp_endpoint()) || isset($this->amp) || ( isset($this->options['flg-amp-url']) && ( preg_match('/\/amp\/?$/i', $_SERVER["REQUEST_URI"]) || preg_match('/\?amp=1$/i', $_SERVER["REQUEST_URI"]) ) ) ) {
			// 簡易タグ作成
			$tag = '<table border="1" cellspacing="0" cellpadding="4"><tbody></tr><tr><td>'.$excerpt.'<br>'.$a_op_all.$a_op.$title.$a_cl.$a_cl_all.' - '.$site_name.'</td></tr></tbody></table>';
		} else {
			// HTMLタグ作成
			switch (isset($this->options['info-position']) ? $this->options['info-position'] : null) {
			case '1':
				$tag = $wrap_op.$a_op_all.'<div class="lkc-card">'.$domain_info.'<div class="lkc-content">'.$a_op.$thumbnail.'<div class="lkc-title"><div class="lkc-title-text">'.$title.'</div>'.$a_cl.$sns_title.'</div>'.$url1.'<div class="lkc-excerpt">'.$excerpt.'</div>'.$moretag.'</div><div class="clear"></div></div>'.$a_cl_all.$wrap_cl;
				break;
			case '2':
				$tag = $wrap_op.$a_op_all.'<div class="lkc-card"><div class="lkc-content">'.$a_op.$thumbnail.'<div class="lkc-title"><div class="lkc-title-text">'.$title.'</div>'.$a_cl.$sns_title.'</div>'.$url1.'<div class="lkc-excerpt">'.$excerpt.'</div>'.$moretag.'</div>'.$domain_info.'<div class="clear"></div></div>'.$a_cl_all.$wrap_cl;
				break;
			case '3':
				$tag = $wrap_op.$a_op_all.'<div class="lkc-card"><div class="lkc-content">'.$a_op.$thumbnail.$domain_info.'<div class="lkc-title"><div class="lkc-title-text">'.$title.'</div>'.$a_cl.$sns_title.$url1.'</div><div class="lkc-excerpt">'.$excerpt.'</div>'.$moretag.'</div><div class="clear"></div></div>'.$a_cl_all.$wrap_cl;
				break;
			default:
				$tag = $wrap_op.$a_op_all.'<div class="lkc-card"><div class="lkc-content">'.$a_op.$thumbnail.'<div class="lkc-title"><div class="lkc-title-text">'.$title.'</div>'.$a_cl.$sns_title.'</div>'.$url1.'<div class="lkc-excerpt">'.$excerpt.'</div>'.$moretag.'</div><div class="clear"></div></div>'.$a_cl_all.$wrap_cl;
			}
		}
		
		// 引用文扱い
		if (isset($this->options['blockquote']) ? $this->options['blockquote'] : null == '1') {
			$tag = '<div class="'.$class_id.'"><blockquote class="lkc-quote">'.$tag.'</blockquote></div>';
		} else {
			$tag = '<div class="'.$class_id.'">'.$tag.'</div>';
		}
		
		return $tag;
	}

	// URLのエンティティ化など（無害化？）
	function pz_TrimURL($url = null) {
		if (!isset($url) || $url == '') {
			$url = null;
			return $url;
		}
		
		$url	= html_entity_decode($url);
		if ($this->options['debug-time']) {
			echo	'<!-- Pz-LkC [URL1='.$url.'] /-->'.PHP_EOL;
		}
		$url	= preg_replace('/^[\s　\'\"‘’“”″]*(.*?)[\s　\'\"‘’“”″]*$/u', '\1', $url);		// 色んな打ち間違え対応
		if ($this->options['debug-time']) {
			echo	'<!-- Pz-LkC [URL2='.$url.'] /-->'.PHP_EOL;
		}
		$url	= esc_url($url);																		// プロトコル除外など
		if ($this->options['debug-time']) {
			echo	'<!-- Pz-LkC [URL3='.$url.'] /-->'.PHP_EOL;
		}
		switch (isset($this->options['trail-slash']) ? $this->options['trail-slash'] : null) {
		case '1':							// URLがドメイン名だけの場合、最後のスラッシュを除外する
			$array_url = parse_url($url);
			if (!isset($array_url['path']) || $array_url['path'] == '/') {
				$url = rtrim($url, '/');
			}
			break;
		case '2':							// 常に最後のスラッシュを除外する
			$url = rtrim($url, '/');
			break;
		}
		if ($this->options['debug-time']) {
			echo	'<!-- Pz-LkC [URL4='.$url.'] /-->'.PHP_EOL;
		}
		
		return	$url;
	}

	// 内部サイト・外部サイトの判断
	function pz_LinkType($url = null) {
		if (substr($url, 0, mb_strlen(home_url() ) ) == home_url() ) {
			if (get_permalink() == $url) {
				$link_type	= 1;					// 自ページ
			} else {
				$link_type	= 2;					// 自サイト内
			}
		} else {
			$link_type		= 0;					// 外部サイト
		}
		// サブディレクトリ型マルチサイト対応
		if ($this->options['flg-subdir'] && is_multisite() && !is_subdomain_install() && is_main_site) {
			$this_blog_id = get_current_blog_id();
			$blog_id = 0;
			do {
				$blog_id++;
				$blog_url = get_site_url($blog_id);
				if ($blog_url && $blog_id <> $this_blog_id && substr($url, 0, mb_strlen($blog_url) ) == $blog_url ) {
					// ドメイン名
					if (preg_match('/https?:\/\/(.*)\//i', $blog_url.'/',$m)) {
						$domain_url	= $m[0];
						$domain		= $m[1];
					} else {
						$domain_url	= null;
						$domain		= null;
					}
					$link_type		=	0;	// 外部サイト
				}
			} while ($blog_url);
		}
		if ($this->options['debug-time']) {
			echo	'<!-- Pz-LkC [TYPE='.$link_type.'] /-->'.PHP_EOL;
		}
		return		$link_type;
	}

	// 相対パスをURLにする
	public function pz_RelToURL( $base_url = '', $rel_path = '' ) {
		if (preg_match('/^https?\:\/\//', $rel_path ) ) {	// 絶対パスだった場合
			return	$rel_path;
		} elseif (substr($rel_path, 0, 2) == '//' ) {			// 絶対パスだった場合（スキーム省略）
			return	$rel_path;
		}
		$parse		=	parse_url($base_url );
		if (substr($rel_path, 0, 1) == '/' ) {					// ドキュメントルート指定
			return	$parse['scheme'].'://'.$parse ['host'].$rel_path;
		}
		return		$parse['scheme'].'://'.$parse['host'].dirname($parse['path'] ).'/'.$rel_path;
	}

	// ソーシャルカウント取得
	public function pz_RenewSNSCount( $data ) {
		if (!isset($this->options['sns-position']) || $this->options['sns-position'] == '') {
			return null;
		}
		if (!isset($data) || !is_array($data)) {
			return null;
		}
		
		$data = $this->pz_GetCache($data);
		if (!isset($data) || !is_array($data)) {
			return null;
		}
		
		// ソーシャルカウント
		$sns_renew	= false;
		$update_cnt	= false;
		
		// タイムオーバー
		$opt = array( 'timeout' => 30 );
		
		// 保存期間満了でソーシャルカウントをリセット
		if ($this->now > $data['sns_nexttime'] && $data['result_code'] <= 200 ) {
			$sns_renew		= true;
		}
		
		// Twitter count.json 2015/11/21 非公式サービス終了に伴い停止→代替APIへ変更
		if (isset($this->options['sns-tw']) && !is_null($this->options['sns-tw'])) {
			$count_before = isset($data['sns_twitter']) ? $data['sns_twitter'] : -1;
			if ($sns_renew || $count_before < 0) {
//				$result = wp_remote_get( 'http://urls.api.twitter.com/1/urls/count.json?url=' .rawurlencode($data['url']), $opt );
				$result = wp_remote_get( 'https://jsoon.digitiminimi.com/twitter/count.json?url=' .rawurlencode($data['url']), $opt );
				if (isset($result) && !is_wp_error($result) && $result['response']['code'] == 200) {
					$count = intval(json_decode($result['body'])->count);
					if ($count > $count_before) {
						$data['sns_twitter'] = $count;
						$update_cnt = true;
					}
				}
			}
		}
		
		if (isset($this->options['sns-fb']) && !is_null($this->options['sns-fb'])) {
			$count_before = intval(isset($data['sns_facebook']) ? $data['sns_facebook'] : -1);
			if ($sns_renew || $count_before < 0) {
				$result = wp_remote_get( 'https://graph.facebook.com/?id=' .rawurlencode($data['url']), $opt );
				if (isset($result) && !is_wp_error($result) && $result['response']['code'] == 200) {
					$json = json_decode($result['body']);
					$count = intval(isset($json->share->share_count) ? $json->share->share_count : 0);
					if ($count > $count_before) {
						$data['sns_facebook'] = $count;
						$update_cnt = true;
					}
				}
			}
		}
		
		if (isset($this->options['sns-hb']) && !is_null($this->options['sns-hb'])) {
			$count_before = isset($data['sns_hatena']) ? $data['sns_hatena'] : -1;
			if ($sns_renew || $count_before < 0) {
				$result = wp_remote_get( 'http://api.b.st-hatena.com/entry.count?url=' .rawurlencode($data['url']), $opt );
				if (isset($result) && !is_wp_error($result) && $result['response']['code'] == 200) {
					$count = intval($result['body']);
					if ($count > $count_before) {
						$data['sns_hatena'] = $count;
						$update_cnt = true;
					}
				}
			}
		}
		
		if (isset($this->options['sns-po']) && !is_null($this->options['sns-po'])) {
			$count_before = isset($data['sns_pocket']) ? $data['sns_pocket'] : -1;
			if ($sns_renew || $count_before < 0) {
				$result = wp_remote_get( 'https://widgets.getpocket.com/v1/button?label=pocket&count=vertical&align=left&v=1&src=https&url=' .rawurlencode($data['url']), $opt );
				if (isset($result) && !is_wp_error($result) && $result['response']['code'] == 200) {
					preg_match('/<em id="cnt">([0-9]*)<\/em>/', $result['body'], $m);
					$count = intval($m[1] ? $m[1] : 0);
					if ($count > $count_before) {
						$data['sns_pocket'] = $count;
						$update_cnt = true;
					}
				}
			}
		}
		
		// 登録してから一週間までは毎日、それ以降は週一回更新（取得が固まらないようにランダム時間付与）
		if ($update_cnt || ($this->now - strtotime($data['regist']) < WEEK_IN_SECONDS)) {
			$sns_nexttime = $this->now + DAY_IN_SECONDS + rand(0, DAY_IN_SECONDS);	// 1day + 0-24h
		} else {
			$sns_nexttime = $this->now + WEEK_IN_SECONDS + rand(0, DAY_IN_SECONDS);	// 7days + 0-24h
		}
		// MINUTE_IN_SECONDS	= 60
		// HOUR_IN_SECONDS		= 60	*	MINUTE_IN_SECONDS	= 3600
		// DAY_IN_SECONDS		= 24	*	HOUR_IN_SECONDS		= 86400
		// WEEK_IN_SECONDS		= 7		*	DAY_IN_SECONDS		= 604800
		// YEAR_IN_SECONDS		= 365	*	DAY_IN_SECONDS		

		global	$wpdb;
		$wpdb->update(
			$this->db_name,
			array(
				'sns_twitter'	=> $data['sns_twitter'],
				'sns_facebook'	=> $data['sns_facebook'],
				'sns_hatena'	=> $data['sns_hatena'],
				'sns_pocket'	=> $data['sns_pocket'],
				'sns_time'		=> $this->now,
				'sns_nexttime'	=> $sns_nexttime,
				'uptime'		=> $this->now
			),
			array(
					'id' => $data['id']
			)
		);
		return $data;
	}

	// キャッシュデータを取得
	public function pz_GetCache( $data ) {
		if (!isset($data) || !is_array($data)) {
			return null;
		}
		global $wpdb;
		if (!empty($data['url'])) {
			$url		= $data['url'];
			$data		= $wpdb->get_row($wpdb->prepare("SELECT * FROM $this->db_name WHERE url=%s", $url));
		} elseif (isset($data['id']) && !is_null($data['id'])) {
			$data_id	= intval($data['id']);
			$data		= $wpdb->get_row($wpdb->prepare("SELECT * FROM $this->db_name WHERE id=%d", $data_id));
		} else {
			return null;
		}
		if ($wpdb->last_error <> '') {		// DBエラーのとき、初期化する
			$this->activate();
		}
		if (is_wp_error($data)) {
			return null;
		}
		return (array) $data;				// Arrayに直して返す
	}

	// キャッシュデータを保存
	public function pz_SetCache($data) {
		global $wpdb;
		if (!isset($data) || !is_array($data)) {
			return null;
		}
		if (!isset($data['url']) || is_null($data['url']) || $data['result_code'] < 100) {
			return null;
		}
		$url					= $this->pz_TrimURL($data['url']);
		$data['url']			= $url;
		if (!isset($data['url_key']) || is_null($data['url_key']) || $data['url_key'] == '' ) {
			$data['url_key']	= hash( 'sha256', esc_url( $url ), true);
		}
		
		if (!isset($data['regist_result']) || !$data['regist_result']) {					// 最初登録時情報
			$data['regist_title']	=	$data['title'];
			$data['regist_excerpt']	=	$data['excerpt'];
			$data['regist_charset']	=	$data['charset'];
			$data['regist_result']	=	$data['result_code'];
			$data['regist_time']	=	$this->now;
		}
		$data['uptime']				=	$this->now;		// 最終更新日時
		
		// 更新してみる
		if ( isset($data['id']) ) {
			$result = $wpdb->update(
				$this->db_name,
				$data,
				array(
					'id' => $data['id']
				)
			);
		} else {
			$result = $wpdb->update(
				$this->db_name,
				$data,
				array(
					'url_key' => $data['url_key']
				)
			);
		}
		if (!$result) {
			$data['regist']		= $this->now_mysql;	// 登録日
			// 更新できなかったら挿入
			unset($data['id']);
			$result = $wpdb->insert(
				$this->db_name,
				$data
			);
			if (!$result) {
				// 挿入できなかったら日本語項目を落としてなるべく登録する
				unset($data['site_name']);
				$result =	$wpdb->insert(
					$this->db_name,
					$data
				);
				if (!$result) {
					unset($data['excerpt']);
					$result =	$wpdb->insert(
						$this->db_name,
						$data
					);
					if (!$result) {
						unset($data['title']);
						$result =	$wpdb->insert(
							$this->db_name,
							$data
						);
						if (!$result) {
							return $data;
						}
					}
				}
			}
		}
		return $this->pz_GetCache($data);
	}

	// キャッシュデータを削除
	public function pz_DelCache($data) {
		global $wpdb;
		if (!isset($data) || !is_array($data)) {
			return null;
		}
		if (isset($data['id']) && !is_null($data['id'])) {
			$data_id	= intval($data['id']);
			$result		= $wpdb->delete($this->db_name, array('id' => $data_id), array('%d') );
			return $result;
		} elseif (isset($data['url']) && !is_null($data['url'])) {
			$url		= $this->pz_TrimURL($data['url']);
			$result		= $wpdb->delete($this->db_name, array('url' => $url), array('%s') );
			return $result;
		}
		return null;
	}

	// サイト内取得
	public function pz_GetPost( $data ) {
		// サイト名取得
		$site_name				= get_bloginfo('name');
		
		// ドメイン名
		if (preg_match('/https?:\/\/(.*)\//i', home_url().'/',$m)) {
			$domain_url	= $m[0];
			$domain		= $m[1];
		} else {
			$domain_url	= null;
			$domain		= null;
		}
		
		// サイトアイコン
		if (function_exists('has_site_icon') && has_site_icon()) {
			$favicon		=	get_site_icon_url(16, '', 0);
		} else {
			$favicon		=	null;
		}
		
		$title					=	null;
		$excerpt				=	null;
		$thumbnail				=	null;
		
		// 記事内容
		$url					=	$data['url'];
		$post_id				=	url_to_postid($url );				// 記事IDを取得
		if ($this->options['debug-time']) {
			echo	'<!-- Pz-LkC [PID='.$post_id.'] /-->'.PHP_EOL;
		}
		
		if ( !$post_id && isset($this->options['flg-get-pid']) ? true : false) {
			$url				=	$this->Pz_GetRedirURL( $data );		// 本当の記事URLを取得
			$post_id			=	url_to_postid($url );				// 記事IDを取得
			if ($this->options['debug-time']) {
				echo	'<!-- Pz-LkC [PID='.$post_id.'(REDIR)] /-->'.PHP_EOL;
			}
		}
		
		if	( $post_id ) {
			$result_code		=	200;						// 外部取得と同じコードをセット
			$post				=	get_post($post_id);			// 記事情報
			if ( $this->options['in-get'] == '1') {
				$title			=	$post->post_title;			// 記事タイトル
				$excerpt		=	$post->post_excerpt;		// 抜粋文優先
				if ($excerpt == '') {
					$excerpt	=	$post->post_content;		// 抜粋文が無かったら記事
				}
			} else {
				$title			=	$post->post_title;			// 記事タイトル
				$excerpt		=	$post->post_content;		// 記事内容から抜粋
			}
			$post_date			=	$post->post_date;
			$thumbnail_id		=	get_post_thumbnail_id( $post_id );		// サムネイル
			if ($this->options['debug-time']) {
				echo	'<!-- Pz-LkC [TID='.$thumbnail_id.'] /-->'.PHP_EOL;
			}
			$attach = wp_get_attachment_image_src( $thumbnail_id, 'thumbnail', true );
			if (isset($attach) && count($attach) > 3 && isset($attach[0])) {
				$thumbnail		= $attach[0];
				if (preg_match('/.*(\/\/.*)/', $thumbnail, $m)) {		// スキームを外す
					$thumbnail = $m[1];
				}
			}
		} else {
			$title				= get_bloginfo('name');
			$excerpt			= get_bloginfo('description');
			$site_name			= get_bloginfo('name');
			$thumbnail			= '';
			$result_code		= '404';
			
			// カテゴリ ページの処理
			$cat_dir			=	get_option('category_base');
			$cat_url			=	home_url().'/'.($cat_dir ? $cat_dir : 'category').'/';
			$cat_len			=	mb_strlen($cat_url );
			if (substr($url, 0, $cat_len ) == $cat_url ) {
				$cat_slug		=	substr($url, $cat_len );
				$cat_data		=	get_category_by_slug($cat_slug );
				$cat_count		=	($cat_data->count - 0);
				$title			=	__('Category', $this->text_domain ).' '.__('‘', $this->text_domain ).$cat_data->name.__('’', $this->text_domain );
				$excerpt		=	__('(', $this->text_domain ).__('Count', $this->text_domain ).':'.($cat_data->count - 0).__(')', $this->text_domain ).' '.$cat_data->description;
				if (isset($cat_data->slug)) {
					$result_code	= '200';
				}
			} else {
				// タグ ページの処理
				$cat_dir			=	get_option('tag_base');
				$cat_url			=	home_url().'/'.($cat_dir ? $cat_dir : 'tag').'/';
				$cat_len			=	mb_strlen($cat_url );
				if (substr($url, 0, $cat_len ) == $cat_url ) {
					$cat_slug		=	substr($url, $cat_len );
					$cat_data		=	get_tags( array( 'slug' => $cat_slug ) );
					$title			=	__('Tag', $this->text_domain ).' '.__('‘', $this->text_domain ).$cat_data[0]->name.__('’', $this->text_domain );
					$excerpt		=	__('(', $this->text_domain ).__('Count', $this->text_domain ).':'.($cat_data[0]->count - 0).__(')', $this->text_domain ).' '.$cat_data[0]->description;
					if (isset($cat_data[0]->slug)) {
						$result_code	= '200';
					}
				} else {
					if ( !$post_id && isset($this->options['flg-get-pid']) ? true : false) {
						$data		=	$this->Pz_GetCURL($data );		// 外部サイトとして読み込み
						return			$data;
					}
				}
			}
		}
		
		// タイトル整形
		if (isset($title)) {
			$str	= $title;
			$str	= strip_tags($str);									// タグの除去
			$str	= str_replace(array("\r", "\n"),	'', $str);		// 改行削除
			$str	= esc_html($str);									// 念のためエスケープ
			$str	= mb_strimwidth($str, 0, 200, '...');				// 保管用のタイトルは200文字で切る
			$title	= $str;
		}
		
		// 抜粋文整形
		if (isset($excerpt)) {
			$str	= $excerpt;
			$str	= strip_tags($str);									// タグの除去
			$str	= preg_replace('/<!--more-->.+/is',	'', $str);		// moreタグ以降削除
			$str	= preg_replace('/\[[^]]*\]/',		'', $str);		// ショートコードすべて除去
			$str	= str_replace(array("\r", "\n"),	'', $str);		// 改行削除
			$str	= esc_html($str);									// 念のためエスケープ
			$str	= mb_strimwidth($str, 0, 500, '...');				// 保管用の記事内容は500文字で切る
			$excerpt	= $str;
		}
		
		// URLパース（ドメイン名などを抽出）
		$url_m			=	parse_url( $url );
		$scheme			=	$url_m['scheme'];							// スキーム
		//$domain			=	$url_m['host'];								// ドメイン名
		//$domain_url		=	$scheme.'://'.$url_m['host'];				// ドメインURL
		$location		=	substr($url, mb_strlen($domain_url));		// ドメイン名以降
		
		// データセット
		if		(isset($data['title']) && $data['title'] == $title ) {
			$before['mod_title']	=	0;
		} else {
			$before['mod_title']	=	1;
		}
		if		(isset($data['excerpt']) && $data['excerpt'] == $excerpt ) {
			$before['mod_excerpt']	=	0;
		} else {
			$before['mod_excerpt']	=	1;
		}
		if		(!isset($data['use_post_id1'])) {
			$data['use_post_id1']	=	get_the_ID();
		}
		$data['scheme']				=	$scheme;
		$data['domain']				=	$domain;
		$data['location']			=	$location;
		$data['site_name']			=	$site_name;
		$data['title']				=	$title;
		$data['excerpt']			=	$excerpt;
		$data['post_date']				=	$post_date;
		$data['thumbnail']			=	$thumbnail;
		$data['favicon']			=	$favicon;
		$data['charset']			=	'UTF-8';
		$data['result_code']		=	$result_code;
		$data['alive_result']		=	$result_code;
		$data['favicon']			=	$favicon;
		
		return $data;
	}

	// リダイレクト先URL取得
	public function pz_GetRedirURL( $data ) {
		$url				=	$data['url'];
		if ( function_exists( 'curl_init' ) ) {							// cURLを使用する
			$result_code	= 0;
			$ch				= curl_init($url);
			curl_setopt( $ch, CURLOPT_RETURNTRANSFER,	true );			// データで取得
			curl_setopt( $ch, CURLOPT_NOBODY,			true );			// ヘッダのみ取得
			curl_setopt( $ch, CURLOPT_TIMEOUT,			120 );			// タイムアウト
			curl_setopt( $ch, CURLOPT_FOLLOWLOCATION,	true );			// リダイレクトを処理する
			curl_setopt( $ch, CURLOPT_MAXREDIRS,		5 );			// リダイレクトを処理する階層
			$html			= curl_exec($ch);
			$errno			= intval( curl_errno( $ch ) );				// cURL実行
			if ( $errno ) {
				$result_code	=	$errno;
				$error			=	true;
			} else {
				$header			=	curl_getinfo($ch);
				$result_code	=	$header['http_code'];				// HTTPステータス
				$error			=	false;
				$url			=	$header['url'];
			}
			curl_close($ch);
		}
		return $url;
	}

	// 外部サイト取得
	public function pz_GetCURL( $data ) {
		$url		= $this->pz_TrimURL( $data['url'] );
		if (!isset( $url ) || $url == '') {
			return null;
		}
		
		// リンク先サイト取得
		$html					= null;
		$error					= true;
		
		$domain					= null;
		$site_name				= null;
		$title					= null;
		$excerpt				= null;
		$charset				= null;
		$result_code			= null;
		
		// URLパース（ドメイン名などを抽出）
		$url_m			=	parse_url( $url );
		$scheme			=	$url_m['scheme'];							// スキーム
		$domain			=	$url_m['host'];								// ドメイン名
		$domain_url		=	$scheme.'://'.$url_m['host'];				// ドメインURL
		$location		=	substr($url, mb_strlen($domain_url));		// ドメイン名以降
		
		if ( function_exists( 'curl_init' ) ) {							// cURLを使用する
			$result_code	= 0;
			$ch				= curl_init($url);
			curl_setopt( $ch, CURLOPT_RETURNTRANSFER,	true );			// データで取得
			curl_setopt( $ch, CURLOPT_TIMEOUT,			8 );			// タイムアウト
			if (isset($this->options['flg-referer']) ? true : false) {
				curl_setopt( $ch, CURLOPT_REFERER, get_permalink() );	// リファラ
			}
			if (isset($this->options['flg-agent']) ? true : false) {
				curl_setopt( $ch, CURLOPT_USERAGENT,		$this->options['user-agent'] );				// ユーザーエージェントにPz-LinkCard-Crawlerを使う
			} else {
				curl_setopt( $ch, CURLOPT_USERAGENT,		esc_html( $_SERVER['HTTP_USER_AGENT'] ) );	// アクセス者のユーザーエージェントを使う
			}
			if (isset($this->options['flg-redir']) ? true : false) {
				curl_setopt( $ch, CURLOPT_FOLLOWLOCATION,	true );		// リダイレクトを処理する
				curl_setopt( $ch, CURLOPT_MAXREDIRS,		8 );		// リダイレクトを処理する階層
				curl_setopt( $ch, CURLOPT_AUTOREFERER,		true );		// リダイレクト用リファラを自動セット
			} else {
				curl_setopt( $ch, CURLOPT_FOLLOWLOCATION,	false );	// リダイレクトを処理しない
			}
			curl_setopt( $ch, CURLOPT_COOKIESESSION,		true );		// セッションCOOKIEを使用する
			curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER,		(isset($this->options['flg-ssl']) ? false : true) );	// SSL検証
			$html			= curl_exec($ch);
			$errno			= intval( curl_errno( $ch ) );				// cURL実行
			if ( $errno ) {
				$html			=	'';									// cURLエラー
				$result_code	=	$errno;
				$error			=	true;
			} else {
				$header			=	curl_getinfo($ch);
				$result_code	=	$header['http_code'];				// HTTPステータス
				$error			=	false;
			}
			curl_close($ch);
		} else {														// cURLが使用できない場合
			$result = wp_remote_get( $url );							//wp_remote_get実行
			if ( is_wp_error( $result ) ) {
				$html			=	'';
				$result_code	=	-1;									// wp_remote_getエラー
				$error			=	true;
			} else {
				$html			=	$result['body'];
				$result_code	=	$result['response']['code'];		// HTTPステータス
				$error			=	false;
			}
		}
		
		// 文字コード判定
		$charset	= null;
		if ($html <> '') {
			if (preg_match('/charset\s*=\s*"*([^>\/\s"]*).*<\/head/si', $html, $m)) {
				$m[1] = trim(trim($m[1]), '\'\"');
				$charset = $m[1];
			} else {
				foreach(array('UTF-8','SJIS','EUC-JP','eucJP-win','ASCII','JIS','SJIS-win') as $c_charset) {
					// 文字コード変換してみて内容が変わらないものを文字セットと判断する
					if (mb_convert_encoding($html, $this->charset, $c_charset) == $html) {
						$charset	= $c_charset;
						break;
					}
				}
			}
			if (is_null($charset)) {
				$charset = mb_detect_encoding($html, 'ASCII,JIS,UTF-7,EUC-JP,SJIS,UTF-8');
				$html = mb_convert_encoding($html, $this->charset, 'ASCII,JIS,UTF-7,EUC-JP,SJIS,UTF-8');
			} elseif ($this->charset <> $charset) {
				$html = mb_convert_encoding($html, $this->charset, $charset);
			}
			
			// HEADタグ（METAタグ解析）
			$head		= null;
			$tags		= null;
			if (preg_match('/<\s*head[^>]*>(.*)<\s*\/head\s*>/si', $html, $m)) {
				$head	= $m[1];
				$tags	= $this->pz_GetMeta($head);
			}
			
			// タイトル
			if			(isset(	$tags['og:title']				)	&&	$tags['og:title']		) {
				$title		=	$tags['og:title']				;
			} elseif	(isset(	$tags['twitter:title']			)	&&	$tags['twitter:title']	) {
				$title		=	$tags['twitter:title']			;
			} elseif	(isset(	$tags['title']					)	&&	$tags['title']			) {
				$title		=	$tags['title']					;
			}
			
			// 抜粋文・概要文
			if			(isset(	$tags['og:description']			)	&& $tags['og:description']	) {
				$excerpt	=	$tags['og:description']			;
			} elseif	(isset(	$tags['twitter:description']	)	&& $tags['twitter:description']	) {
				$excerpt	=	$tags['twitter:description']	;
			} elseif	(isset(	$tags['description']			)	&& $tags['description']		) {
				$excerpt	=	$tags['description']			;
			}
			
			// OGPから画像URL取得
			if			(isset(	$tags['og:image']				)	&& $tags['og:image']		) {
				$thumbnail_url = $tags['og:image']				;
			} elseif	(isset(	$tags['twitter:image']			)	&& $tags['twitter:image']	) {
				$thumbnail_url = $tags['twitter:image']			;
			} else {
				$thumbnail_url = '';
			}
			if			($thumbnail_url	&& !preg_match('/^https*:\/\//', $thumbnail_url, $m) ) {
				$thumbnail_url	=	$this->pz_RelToURL($url, $thumbnail_url);
			}
			
			// OGPからサイトアイコンURL取得
			if			(isset(	$tags['icon']					)	&& $tags['icon']			) {
				$favicon_url = $tags['icon']					;
			} elseif	(isset(	$tags['shortcut icon']			)	&& $tags['shortcut icon']	) {
				$favicon_url = $tags['shortcut icon']			;
			} elseif	(isset(	$tags['apple-touch-icon']		)	&& $tags['apple-touch-icon']) {
				$favicon_url = $tags['apple-touch-icon']		;
			} else {
				$favicon_url = '';
			}
			if			($favicon_url	&& !preg_match('/^https*:\/\//', $favicon_url, $m) ) {
				$favicon_url	=	$this->pz_RelToURL($url, $favicon_url);
			}
			
			// サイト名
			if			(isset(	$tags['og:site_name']	)	&& $tags['og:site_name']	) {
				$site_name	=	$tags['og:site_name']	;
			}
			
			// タイトル整形
			if (isset($title)) {
				$str	= $title;
				$str	= strip_tags($str);									// タグの除去
				$str	= str_replace(array("\r", "\n"),	'', $str);		// 改行削除
				$str	= esc_html($str);									// 念のためエスケープ
				$str	= mb_strimwidth($str, 0, 200, '...');				// 保管用のタイトルは200文字で切る
				$title	= $str;
			}
			
			// 抜粋文整形
			if (isset($excerpt)) {
				$str	= $excerpt;
				$str	= strip_tags($str);									// タグの除去
				$str	= str_replace(array("\r", "\n"),	'', $str);		// 改行削除
				$str	= esc_html($str);									// 念のためエスケープ
				$str	= mb_strimwidth($str, 0, 500, '...');				// 保管用の記事内容は500文字で切る
				$excerpt	= $str;
			}
			
			// データセット
			if (isset($data_id) && !is_null($data_id)) {
				$data['id']			= $data_id;
			}
			if (isset($url_key) && !is_null($url_key)) {
				$data['url_key']	= $url_key;
			}
			$data['site_name']		=	$site_name;
			$data['title']			=	$title;
			$data['excerpt']		=	$excerpt;
			$data['mod_title']		=	0;
			$data['mod_excerpt']	=	0;
			$data['charset']		=	$charset;
			// if (isset($atts['force'])	&& $atts['force'] == true) {
			// 	$data['regist']		=	$this->now_mysql;		// 登録日
			// }
		}
		$data['url']				=	$url;
		$data['thumbnail']			=	( isset($thumbnail_url) ? $thumbnail_url : null );
		$data['result_code']		=	$result_code;
		$data['alive_result']		=	$result_code;
		$data['scheme']				=	$scheme;
		$data['domain']				=	$domain;
		$data['location']			=	$location;
		$data['favicon']			=	( isset($favicon_url) ? $favicon_url : null );
		if		(!isset($data['use_post_id1']) || !$data['use_post_id1']) {
			$data['use_post_id1']	=	get_the_ID();
		}
		$data['sns_twitter']		=	(isset( $data['sns_twitter']	) ? $data['sns_twitter']	: -1	);
		$data['sns_facebook']		=	(isset( $data['sns_facebook']	) ? $data['sns_facebook']	: -1	);
		$data['sns_hatena']			=	(isset( $data['sns_hatena']		) ? $data['sns_hatena']		: -1	);
		$data['sns_nexttime']		=	(isset( $data['sns_nexttime']	) ? $data['sns_nexttime']	: 0		);
		$data['uptime']				=	$this->now;
		$data['alive_time']			=	$this->now;
		$data['alive_result']		=	$result_code;
		return $data;
	}

	// TITLEとMETAタグを分解
	function pz_GetMeta( $html, $tags = null, $clear = false ) {
		if ($clear == true || !isset($tags)) {
			$tags = null;
			$tags = array('none' => 'none');
		}
		
		// TITLEタグ
		if (preg_match('/<\s*title\s*[^>]*>\s*([^<]*)\s*<\s*\/title\s*[^>]*>/si', $html, $m)) {
			$tags['title'] = esc_html($m[1]);
		}
		
		// metaタグ パース
		$match = null;
		preg_match_all('/<\s*meta\s(?=[^>]*?\b(?:name|property)\s*=\s*(?|"\s*([^"]*?)\s*"|\'\s*([^\']*?)\s*\'|([^"\'>]*?)(?=\s*\/?\s*>|\s\w+\s*=)))[^>]*?\bcontent\s*=\s*(?|"\s*([^"]*?)\s*"|\'\s*([^\']*?)\s*\'|([^"\'>]*?)(?=\s*\/?\s*>|\s\w+\s*=))[^>]*>/is', $html, $match);
		if (isset($match) && is_array($match) && count($match) == 3 && count($match[1]) > 0) {
			foreach ($match[1] as &$m) {
				$m	= strtolower($m);
			}
			unset($m);
			$tags += array_combine($match[1], $match[2]);
		}
		
		// linkタグ パース
		$match = null;
		preg_match_all('/<\s*link\s(?=[^>]*?\brel\s*=\s*(?|"\s*([^"]*?)\s*"|\'\s*([^\']*?)\s*\'|([^"\'>]*?)(?=\s*\/?\s*>|\s\w+\s*=)))[^>]*?\bhref\s*=\s*(?|"\s*([^"]*?)\s*"|\'\s*([^\']*?)\s*\'|([^"\'>]*?)(?=\s*\/?\s*>|\s\w+\s*=))[^>]*>/is', $html, $match);
		if (isset($match) && is_array($match) && count($match) == 3 && count($match[1]) > 0) {
			foreach ($match[1] as &$m) {
				$m	= strtolower($m);
			}
			unset($m);
			$tags += array_combine($match[1], $match[2]);
		}
		
		return $tags;
	}

	// サムネイル取得（外部リンクOGP画像取得）
	public function pz_GetThumbnail( $url, $force = false ) {
		if (!isset($url) || $url == '' || $url == 'https://s0.wp.com/i/blank.jpg') {
			return null;
		}
		
		$file_dir	= $this->options['thumbnail-dir'];						// サムネイルのディレクトリ
		if (!is_dir($file_dir)) {
			return null;
		}
		
		$file_name	= bin2hex(hash('sha256', esc_url( $url ), true));		// URLをハッシュしてファイル名を生成する
		$file_path	= $file_dir.$file_name;									// ファイルのフルパス
		$file_url	= $this->options['thumbnail-url'].$file_name;			// 画像URL
		
		if (!$force && file_exists($file_path )) {							// 既にあれば画像URLを返す
			return $file_url;
		}
		
		list($width, $height) = @getimagesize($url);						// サイズを取得
		if (!isset($width) || !isset($height) || $width < 8 || $height < 8) {	// 8x8未満は画像ではないと見なす
			return null;
		}
		$image = imagecreatefromstring( file_get_contents($url) );			// 画像読み込み
		
		$new_width  = 200;													// 幅200px
		$new_height = 200;													// 高さ200px
		if ($width <> $height) {											// 正方形でない
			if ($width > $height) {											// 幅の方が大きい
				$new_height = $height * ( $new_width  / $width  );			// 幅に合わせる
			} else {														// 高さの方が大きい
				$new_width  = $width  * ( $new_height / $height );			// 高さに合わせる
			}
		}
		$image_p = imagecreatetruecolor($new_width, $new_height);			// パレットを用意
		imagecopyresampled($image_p, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);	// サイズ変更してコピー
		imagejpeg($image_p, $file_path);									// JPEGで保存
		return $file_url;													// 画像URLを返す
	}

	// 管理画面時のスタイルシート、スクリプト設定
	public function enqueue_admin($hook) {
		wp_enqueue_script	('pz-lkc-admin',		plugins_url('js/admin.js', __FILE__),			array('jquery'),			false,	true);
		wp_enqueue_style	('wp-color-picker');
		wp_enqueue_script	('colorpicker-script',	plugins_url('js/color-picker.js', __FILE__),	array('wp-color-picker'),	false,	true);
		// wp_enqueue_media();
		// wp_enqueue_script	('media-uploader',		plugins_url("media-uploader.js", __FILE__),	array('jquery'),			false,	false);
		wp_enqueue_style('pz-lkc-admin', plugin_dir_url (__FILE__).'css/admin.css');
	}

	// 管理画面時のスタイルシート、スクリプト設定
	public function add_footer() {
		if ($this->options['flg-edit-qtag']) {
			if (wp_script_is('quicktags') ) {
				echo '<script>QTags.addButton(\'pz-lkc\',\''.__('Linkcard', $this->text_domain ).'\',\'['.$this->options['code1'].' url="\',\'"]\',\'\',\''.__('Make Linkcard', $this->text_domain ).'\');</script>';
			}
		}
		require_once ('lib/pz-linkcard-modal.php');
	}

	// 管理画面時の注意書き設定
	public function add_notices() {
		if ($this->options['flg-invalid']) {
			echo '<div class="error fade is-dismissible"><p><strong>'.$this->slug.': '.__('Invalid URL parameter in ', $this->text_domain).'<a href="'.$this->options['invalid-url'].'" target="_blank">'.$this->options['invalid-url'].'</a></strong><br>'.__('*', $this->text_domain).' '.__('You can cancel this message from <a href="./options-general.php?page=pz-linkcard-settings">the setting screen</a>.', $this->text_domain).'</p></div>';
		}
	}

	// 管理画面時のスタイルシート、スクリプト設定
	public function add_mce_button($buttons) {
		if ($this->options['flg-edit-insert']) {
			$buttons[]		=	'pz_linkcard';
		}
		return	$buttons;
	}
	public function add_mce_plugin($plugins) {
		if ($this->options['flg-edit-insert']) {
			$plugins['pz_linkcard']		=	$this->plugin_dir_url.'js/mce.js';
		}
		return	$plugins;
	}

	// 通常時のスタイルシート
	public function enqueue($hook) {
		$this->amp				=	null;
		
		$css_path	=	$this->upload_dir_path.'style.css';
		$css_url	=	$this->upload_dir_url .'style.css';
		if (!file_exists($css_path )) {
			$css_url	=	$this->plugin_dir_url .'style.css';
		}
		if (preg_match('/.*(\/\/.*)/', $css_url, $m)) {		// スキームを外す
			$css_url = $m[1];
		}
		wp_enqueue_style	('pz-linkcard', $css_url);
		//if (!isset($this->options['style'])) {
		//	wp_enqueue_style	('pz-linkcard', $this->options['css-url']);
		//} else {
		//	if (isset($this->options['css-file'])) {
		//		wp_enqueue_style('pz-linkcard', $this->options['css-file']);
		//	}
		//}
	}

	// 管理画面のサブメニュー追加
	public function add_menu() {
		$menu_manager	=	__('Pz LkC Cache',	$this->text_domain);
		$menu_settings	=	__('Pz LinkCard',	$this->text_domain);
		if ($this->options['flg-alive'] && $this->options['flg-alive-count']) {
			global $wpdb;
			$result		=	$wpdb->get_row("SELECT COUNT(*) AS count FROM $this->db_name WHERE alive_result = '404'");
			if (isset($result) && isset($result->count)) {
				$menu_manager	.=	'&nbsp;<span class="update-plugins"><span class="update-count lkc-menu-count">'.$result->count.'</span></span>';
			}
		}
		add_management_page	(__('LinkCard cache manager',	$this->text_domain), $menu_manager,		'manage_options', 'pz-linkcard-cache',		array($this, 'page_cacheman') );
		add_options_page	(__('LinkCard Settings',		$this->text_domain), $menu_settings,	'manage_options', 'pz-linkcard-settings',	array($this, 'page_settings') );
	}

	// WP-CRONスケジュール（SNSカウント取得）
	public function schedule_hook_check() {
		if (!isset($this->options['sns-position']) || $this->options['sns-position'] == '') {
			return null;
		}
		
		global $wpdb;
		$result	= (array) $wpdb->get_results($wpdb->prepare("SELECT url,sns_nexttime FROM $this->db_name WHERE sns_nexttime<%d ORDER BY sns_nexttime ASC", $this->now));
		$i		= 0;
		if (isset($result) && is_array($result) && count($result) > 0) {
			foreach($result as $data) {
				$i++;
				if ($i > 10) {
					wp_schedule_single_event(time() + 30, 'pz_linkcard_check');
					break;
				}
				if (isset($data) && isset($data->url)) {
					$data = $this->pz_RenewSNSCount(array('url' => $data->url) );
				}
			}
		}
	}

	// WP-CRONスケジュール（存在チェック）
	public function schedule_hook_alive() {
		if (!isset($this->options['flg-alive']) || $this->options['flg-alive'] == '') {
			return null;
		}
		
		global $wpdb;
		$result	= (array) $wpdb->get_results($wpdb->prepare("SELECT url,alive_time FROM $this->db_name WHERE alive_nexttime<%d ORDER BY alive_time ASC, id ASC", $this->now - WEEK_IN_SECONDS ));
		$i		= 0;
		if (isset($result) && is_array($result) && count($result) > 0) {
			foreach($result as $data) {
				$i++;
				if ($i > 5) {
					wp_schedule_single_event(time() + 3600, 'pz_linkcard_alive');
					break;
				}
				if (isset($data) && isset($data->url)) {
					$before		= $this->pz_GetCache( array( 'url' => $data->url ) );
					$after		= $this->pz_GetCURL( $before );
					if		($before['title']	==	$after['title'] ) {
						$before['mod_title']	=	0;
					} else {
						$before['mod_title']	=	1;
					}
					if		($before['excerpt']	==	$after['excerpt'] ) {
						$before['mod_excerpt']	=	0;
					} else {
						$before['mod_excerpt']	=	1;
					}
					$before['alive_result']		=	$after['result_code'];
					$before['alive_time']		=	$this->now;
					$before['alive_nexttime']	=	$this->now + WEEK_IN_SECONDS * 4 + rand(0, DAY_IN_SECONDS);
					$before['thumbnail']		=	$after['thumbnail'];
					$before['favicon']			=	$after['favicon'];
					$before		= $this->pz_SetCache( $before );
				}
			}
		}
	}

	// スタイルシート生成
	public function pz_SetStyle() {
		require_once ('lib/pz-linkcard-style.php');
	}

	// Pz カード管理 キャッシュ・マネージャ
	public function page_cacheman() {
		require_once ('lib/pz-linkcard-cacheman.php');
	}
	
	// Pz カード 設定画面
	public function page_settings() {
		require_once ('lib/pz-linkcard-settings.php');
	}

	// プラグイン一覧のクイックメニュー
	public function action_links($links) {
		$links = array('<a href="options-general.php?page=pz-linkcard-settings">'.__('Settings', $this->text_domain).'</a>' , '<a href="tools.php?page=pz-linkcard-cache">'.__('Manage', $this->text_domain).'</a>' ) + $links;
		return $links;
	}

	// プラグイン有効化
	public function activate() {
		require_once ('lib/pz-linkcard-init.php');
	}

	// プラグイン停止
	public function deactivate() {
		wp_clear_scheduled_hook('pz_linkcard_check');
		wp_clear_scheduled_hook('pz_linkcard_alive');
	}

}
$Class_Pz_LinkCard = new Pz_LinkCard;
