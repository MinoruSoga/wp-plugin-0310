=== Pz-LinkCard ===
Contributors: poporon
Tags: post, internal link, external link, blogcard, linkcard
Requires at least: 4.3
Tested up to: 5.3
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Donate link: https://www.amazon.co.jp/gp/registry/wishlist/2KIBQLC1VLA9X

This plugin is intended to display a link in a blog card format. The goodbye to the text-only link.

== Description ==

This plugin is intended to display a link in a blog card format.

Easy to use. Just to write a short code.

You can change the appearance in the `settings` screen .

You can edit or delete the cache on the `manage` screen .

The goodbye to the text-only link.

* It will access to WebAPI for the thumbnail image acquisition and site icon of acquisition. In addition , it will save the title and excerpt statement to the database. For more information you want to read the item of "arbitrary section" about this.


このプラグインはショートコードでURLを指定することで、リンクをブログカード形式で表示させるものです。

外部リンクと内部リンクで、カードの色や新しくウィンドウを開くかなど、設定を変更することができます。

リンク先の情報はキャッシュされるため、ソーシャルカウント等も表示されるカード形式のリンクとしては高速に表示されます。

キャッシュ管理画面から、キャッシュされた情報の再取得や直接編集、削除が行えます。

テキストにリンク設定しただけでは物足りないと感じていたら、ぜひお試しください。

（ショートコード内にURLを記述した場合、ピンバックは飛びません。ピンバックを使用したい方は記事中にテキストリンクを張るなどで対応してください。）

※このプラグインはサムネイルの取得やサイトアイコンの取得のためにリンク先のURLをWebAPIに送信します。また、タイトル・抜粋文をDBへ保存します。詳細は「Arbitrary section」をお読みください。


== Installation ==

WordPressダッシュボードからのインストール

(From your WordPress dashboard)


1. 「プラグイン」→「新規追加」を選びます

   (Plugins menu > Add New)

2. 「Pz-LinkCard」を検索します

   (Search for Pz-HatenaBlogCard)

3. プラグイン名と作者を確認していただき、「今すぐインストール」を押します

   (Install)

4. 「有効化する」を選び、有効化します

   (Activate)


WordPress.org からのダウンロードおよびインストール

(From WordPress.org)

1. WordPress.orgのプラグイン一覧から「Pz-LinkCard」を検索します

   (Search "pz-linkcard" plugin from wordpress.org)

2. プラグイン名と作者を確認していただき、ダウンロードします

   (Download ZIP file)

3. WordPressをインストールしているディレクトリ配下の、「/wp-content/plugins」ディレクトリ配下に「pz-linkcard」ディレクトリを作成します

   (Upload pz-linkcard directory to the /wp-content/plugins/ directory)

4. ダウンロードしたZIPファイルを展開します

5. プラグイン一覧から「有効化」を選んで、有効化します

   (Activate the plugin through the 'Plugins' menu in WordPress)


新しいバージョンを有効化したら動作しなくなった場合

1. Pz-LinkCard がインストールされているディレクトリ名を変更もしくは削除します

2. WordPressダッシュボードに入ると、プラグインが無効化されたというメッセージが表示されます

3. 先ほど変更したディレクトリ名を戻します（戻してもプラグインは勝手に有効化されません）

4. 当サイトから古い安定版をダウンロードします

5. 上書きコピーを行ったあと、有効化を選んで、有効化します

6. 不具合が起きた状態や状況、テストサイトであれば、アクセスするためのURLを教えていただけると早急に修正できる場合があります


== Frequently asked questions ==

Q1. 
データベースの容量を圧迫しませんか？

A1.
リンク先サイトのURL、タイトル、抜粋文を取得してデータベースに格納します。
URLごとに保存されるため、複数の記事に同一のURLを指定してもデータは増えません。
結果として記事内にタイトルや抜粋文を記述してリンクを設定するのと大きな差は無いと思います。
記事からショートコードを消してもデータベースからキャッシュ情報は削除されないので「Pz カード管理」画面から個別で消してください。
また、アンインストール時にプラグインと設定内容、キャッシュ用のデータベースを削除します。

Q2.
自サイト内への記事でも新しいウィンドウで開きたいのですが？

A2.
「Pz カード設定」の画面から、外部リンク、内部リンク、それぞれ「新しいウィンドウで開く」のチェックボックスが用意されています。
外部サイト同一をウィンドウで開くこともできます。
普段は外部サイトは新しいウィンドウで開き、モバイルで閲覧時のみ同一ウィンドウで開くこともできます。

Q3.
WordPressピンバックが飛びません。

A3.
WordPressピンバックは記事中にリンクを直接記述しないと飛びません。
当プラグインはショートコードをカードの書式とリンクを展開するのでピンバックは飛びません。

Q4.
SSLサイトの内容が取得できません。

A4.
ブログサイトのcURLでアクセスを行った際にサーバー側にSSL証明書が更新されていないためにSSL検証が失敗されるためと思われます。SSL検証を行わない設定を有効にしてみてください。

Q5.
nofollowの設定は重要ですか？

A5.
Googleではnofollowを指定したリンク先はリンク元のサイトの評価に使用しないとしています。
通常のサイトでは指定しないことをお勧めします。

Q6.
直接取得にしたサムネイルの画像が粗い。

A6.
外部サイトのサムネイル直接取得は引用の範囲を超えることのないように低解像度としています。

Q7.
「続きを読む」ボタンが表示されない。

A7.
カードの「高さ」を空欄にして記事内容が全て表示されるように指定しないと表示されないことがあります。

== Screenshots ==

1. "Options screen"
2. "Cache manager screen"
3. "Edit cache data"
4. "The appearance of the 'LinkCard'"
5. "Write shortcode and url"

== Changelog ==
Ver2.3.1
* WordPress 5.3 での動作確認。
  Compatible with WordPress 5.3.
* ビジュアル エディタのボタンが表示されない不具合の修正をしました。
  Fixed a bug that the button of the visual editor is not displayed.

Ver2.3.0
* プラグインなどのインストール状況によって設定画面のタブが動作しない不具合の修正をしました。
  Fixed: Fixed a bug that the tab of the setting screen does not respond.

Ver2.2.9
* WordPress 5.2.3 での動作確認。
  Compatible with WordPress 5.2.3.
* 「かんたん書式設定」に「コンパクト」を追加しました。
  Added: Tiny format 'Compact'.
* 「Pz カード管理」の画面にヘルプアイコンを設置しました。
  Added: A help icon has been added to the "Pz Card Manager" screen.
* 「Pz カード設定」の画面にヘルプアイコンを設置しました。
  Added: A help icon has been added to the "Pz Card Settings" screen.
* 「Pz カード設定」の画面をタブ方式に変更しました。
  Modified: Changed the "Pz card setting" screen to tab method.
* 外部リンク、内部リンク、同ページでそれぞれ枠線の色を選択できるように修正しました。
  Modified: Modified to be able to select the border color for the external link, internal link, and the same page respectively.

Ver2.2.8
* WordPressテーマ「Cocoon」を使用しているとき、外部リンクのアイコンが表示されないように修正しました。
  Fixed: When using the WordPress theme "Cocoon", the external link icon was not displayed.
* WordPressテーマ「JIN」を使用しているとき、余分な空行が表示されないように修正しました。
  Fixed: When using the WordPress theme "JIN", it has been corrected so that extra blank lines are not displayed.
* 「付加情報」をSPAN要素からDIV要素に変更しました。（Thanks @metro_eight）
  Modified: "Additional information" changed from SPAN element to DIV element.
* 「シェア数」をSPAN要素からDIV要素に変更しました。
  Modified: "Share information" changed from SPAN element to DIV element.
* 「続きを読む」ボタンをSPAN要素からDIV要素に変更しました。
  Modified: "Read more button" changed from SPAN element to DIV element.

Ver2.2.7
* サイトアイコンの垂直位置（vertical-align）をテキスト下（text-bottom）から中央（middle）へ変更。
  Modified: Changed the vertical position of the site icon (vertical-align) from the bottom of the text (text-bottom) to the middle (middle).
* サイト追加情報をSPANからDIVへ変更。
  Modified: Changed site addition information from SPAN to DIV.
* タイトルを折り返さない設定を追加。
  Added: Added a setting that does not wrap the title.
* URLを折り返さない設定を追加。
  Added: Added a setting that does not wrap the URL.
* 設定画面の「文字の設定」のレイアウトを変更。
  Modified: Changed the layout of "Text Settings" on the setting screen.
* 「かんたん書式設定」に「囲み」を追加。
  Modified: Added tiny format "Enclose".
* 「かんたん書式設定」に「反射」を追加。
  Modified: Added tiny format "Reflection".
* 「かんたん書式設定」に「セロハンテープ（斜め）」を追加。
  Modified: Added tiny format "Cellophane tape (digonal)".
* 「かんたん書式設定」に「Windows 95」を追加。
  Modified: Added tiny format "Windows 95".
* 「かんたん書式設定」に「Windows XP」を追加。
  Modified: Added tiny format "Windows XP".
* 内部リンクがキャッシュされない不具合を修正。（Thanks @Masa_s_Record）
  Fixed: Fixed a bug that internal links are not cached.
* サイトアイコンが取得できないときに警告エラーが発生していたのを修正しました。
  Fixed: Fixed a bug.

Ver2.2.6.2
* バグ修正。
  Fixed: Fixed a bug.

Ver2.2.6.1
* バグ修正。
  Fixed: Fixed a bug.

Ver2.2.6
* 「余白」の値に「40px」を追加。
  Added: Added "40px" to "Margin" value.
* ドメイン名（サイト名称）にマウスカーソルを重ねたときにアンダーラインが表示されないように変更。
  Modified: Changed so that the underline is not displayed when the mouse cursor is moved over the domain name (site name).
* 挿入ボタンを押したとき、モーダルウィンドウが開くように変更。
  Modified: Changed to open a modal window when the insert button is pressed.

Ver2.2.5
* 内部リンクでもnofollow指定できるように修正。
  Modified: Fixed to be able to specify nofollow even for internal links.
* 押しピンの画像がクリック無効になるように修正。
  Modified: Fixed push pin image to be click invalid.

Ver2.2.4
* WordPress 5.2.2 での動作確認。
  Compatible with WordPress 5.2.2.
* ショートコードごとにnofollowを追加できる機能を追加。
  Added: Added the function to add nofollow per short code.
* スタイルシートの取得方法を変更。
  Modified: Changed style sheet acquisition method.
* 内部リンクのサムネイルのURLからスキームを省略するように変更。
  Modified: Changed to omit scheme from URL of internal link thumbnail.

Ver2.2.3
* ショートコードを強制的に展開する機能を設定に追加。
  Added: Added the function to forcibly expand the short code to the setting.
* WordPress 5.2 での動作確認。
  Compatible with WordPress 5.2.
* WordPress 5.2.1 での動作確認。
  Compatible with WordPress 5.2.1.

Ver2.2.2.1
* ビジュアル エディタでエラーが表示されてしまうことがあるのを修正しました。
  Fixed: Fixed a bug.

Ver2.2.2
* ビジュアルエディタの挿入ボタンの仕組みを見直しました。
  Modified: Review the mechanism of the insert button in the visual editor.

Ver2.2.1
* WordPress 5.0.1 での動作確認。
  Compatible with WordPress 5.0.1.
* WordPress 5.0.2 での動作確認。
  Compatible with WordPress 5.0.2.
* WordPress 5.0.3 での動作確認。
  Compatible with WordPress 5.0.3.
* WordPress 5.1 での動作確認。
  Compatible with WordPress 5.1.
* URLエラーの解除方法のメッセージを追加しました。
  Modified: Added a message on how to cancel the URL error.
* 編集画面で警告が出ていたのを修正しました。
  Fixed: Fix warning on edit screen.

Ver2.2.0
* WordPress 5.0 での動作確認。
  Compatible with WordPress 5.0.
* 存在しないURLを指定したときに警告エラーが発生していたのを修正しました。
  Fixed: Fixed a bug.
* カード管理画面で警告エラーが発生していたのを修正しました。
  Fixed: Fixed a bug.

Ver2.1.9.1
* カード管理画面で警告エラーが発生していたのを修正しました。
  Fixed: Fixed a bug.

Ver2.1.9
* 相対URLを指定したときにサイトURLを補完する機能を追加しました。
  Added: Added a function to supplement site URL when relative URL is specified.

Ver2.1.8.4
* サイト情報が「なし」の場合、「続きを読む」ボタンが表示されなかったのを修正しました。（Thanks Andrew）
  Fixed: Fixed a bug that the `Read more` button is not displayed.

Ver2.1.8.3
* カード管理画面で警告エラーが発生していたのを修正しました。（Thanks @sayataro98）
  Fixed: Fixed a bug.
* 「続きを読む」ボタンが表示されなかったのを修正しました。（Thanks Andrew）
  Fixed: Fixed a bug that the `Read more` button is not displayed.

Ver2.1.8.2
* 警告エラーが発生していたのを修正しました。
  Fixed: Fixed a bug.

Ver 2.1.8.1
* フィルターの優先度を指定するように修正しました。
  Modified: Fix to specify filter priority.
* リンク切れチェックの周期が長くなるように修正しました。
  Modified: Correction was made so that the link break check cycle becomes longer.
* 編集画面に次回のリンク切れチェック日時を表示しました。
  Modified: The next link break check date and time was displayed on the edit screen.

Ver 2.1.8
* 「かんたん書式設定」の「Pzカード 標準書式」を「Pzカード オリジナル」に名称変更しました。
  Modified: Minor fixes.
* 「かんたん書式設定」の「Pzカード 標準書式」を微調整しました。
  Modified: Fine adjustment tiny format "Pz LinkCard Default".
* 「かんたん書式設定」の「見出し」を微調整しました。
  Modified: Fine adjustment tiny format "Header".
* 「かんたん書式設定」の「シンプル」を「ノーマル（はてなブログカード風）」に名称変更しました。
  Modified: Modified tiny format "Simple" to "Normal".
* 「かんたん書式設定」に「シンプル」を追加しました。
  Added: Added tiny format "Simple".
* 「かんたん書式設定」の「押しピン」を微調整しました。
  Modified: Added tiny format "Pushpin".
* 設定画面のサイト情報の位置に「タイトルの上側」を追加しました。
  Added: Added setting to set Above the title.
* 設定画面の「サイト情報」を「付加情報」に修正しました。
  Fixed: Modified "Site information" to "Added information".
* カード管理画面の並び順の表示が昇順になっていたのを修正しました。
  Fixed: Fixed a bug.
* ソーシャルカウントに「Pocket」を追加しました。
  Added: Added Pocket social count.
* アンカーテキストの装飾を無効にする設定を追加しました。
  Added: Added setting to disable anchor text decoration.

Ver2.1.7.1
* 「かんたん書式設定」に「見出し」を追加しました。
  Added: Tiny format 'Headline'.
* スタイルシートを整理しました。
  Modified: Minor fixes.

Ver2.1.7
* 外部サイト・内部サイト・同ページの判断方法を修正しました。
  Modified: Change judgment method.
* 外部リンクのみ変換する設定を追加しました。（Thanks @mocochat）
  Added: Added 'Convert only external link'.
* 文字コードを自動判断したときの結果を修正しました。
  Modified: Minor fixes.

Ver2.1.6.2
* アンカーテキストのアンダーラインが表示されてしまうのを修正しました。
  Fixed: Fixed a bug.

Ver2.1.6.1
* サイト情報を表示しないとき、ワーニングが出ていたのを修正しました。
  Fixed: Fixed a bug.（Thanks @ryuji120912）

Ver2.1.6
* 設定画面にTwitterアカウントを表示しました。
  Added: Added 'When in trouble'.
* タイトル取得（正規表現）を修正しました。
  Modified: Fixed title acquisition method.
* アンカーテキストのアンダーラインを無しにしました。
  Modified: Changed the text-decoration to "none".

Ver2.1.5
* 文字装飾を無しにしました。
  Modified: Changed the text-decoration to "none".
* 初期設定では「影を付けない」設定に変更しました。
  Modified: Changed the initial setting to "Do not add shadows".
* 初期設定では「角を丸めない」設定に変更しました。
  Modified: Changed the initial setting to "Do not round".
* 初期設定では外部サイトのサムネイルを「直接取得できない場合、WebAPIを利用する」に変更しました。
  Modified: Changed the initial setting to "Use WebAPI ,If can not direct".
* 角をまるめる設定にサイズを追加しました。
  Modified： Square rounding has added some sizes.
* カードの余白に「24px」を追加しました。
  Modified: 24px was added to the card margin.
* サムネイル取得WebAPIのHeartRail社の例をhttpsに変更しました。
  Modified: More secure.
* Facebookのシェア数取得APIをhttpsに変更しました。
  Modified: More secure.
* Twitterのツイート数取得APIをhttpsに変更しました。
  Modified: More secure.
* Tweet(s)をクリックしたときの動作をツイート検索に変更しました。
  Modified: From registration to search at Twitter.
* User(s)をクリックしたときの動作をはてなブックマーク数表示に変更しました。
  Modified: From registration to search at Hatena.
* サイト情報からサイト名称と付加情報を分けました。
  Added: Add additional information.
* 付加情報の文字設定を追加しました。
  Added: Add character setting of additional information.
* 付加情報を見出し表示にする設定を追加しました。（Thanks @hituji_1234）
  Added: Added setting to set additional information as heading.

Ver2.1.4.2
* WordPress 4.9.8 での動作確認。
  Compatible with WordPress 4.9.8.

Ver2.1.4.1
* URLの記述ミスに対応しました。
  Modified: Corresponded to URL mistake.

Ver2.1.4
* CHARSETを判断できないパターンがあったため修正しました。（Thanks サイノア）
  Fixed: There was a pattern which can not judge CHARSET, so I fixed it.
* カード管理で「すべて」を選んだときに内部リンクが表示されていたのを修正しました。
  Fixed: Fixed a bug in card management.

Ver2.1.3.1
* WordPress 4.9.6 での動作確認。
  Compatible with WordPress 4.9.6.

Ver2.1.3
* サブメニューの横にリンク切れの件数を表示する設定を追加しました。（Thanks @Oncle1316）
  Added: Added setting to display the number of broken links next to the submenu.

Ver2.1.2.2
* 定義されていない変数を使用していたためNoriceエラーが出てしまうのを修正しました。
  Fixed: Fixed a bug.

Ver2.1.2.1
* プラグインの新規インストールもしくは停止から有効化した際にエラーが出てしまうのを修正しました。
  Fixed: Fixed a bug.

Ver2.1.2
* 直接取得サムネイルのサイズを100pxから200pxへ変更しました。
  Fixed: Directly acquired thumbnail size was changed from 100px to 200px.
* 横幅に合わせて縮小表示させるときのフォントサイズと行の高さを調整しました。
  Fixed: Adjusted the font size and line height when reducing the display to fit the width.
* URLを表示できる場所を「タイトルの下」の他に「サイト情報の後ろ」が選べるように変更しました。
  Added: "Behind site-info" has been added as the display location of the URL.
* カード管理画面に文字列検索を追加しました。
  Added: A character string search was added to the card management screen.
* カード管理画面の一括メニューに「サムネイルの再取得」を追加しました。
  Added: "Renew thumbnail" was added to the batch menu of the card management screen.

Ver2.1.1.1
* WordPress 4.9.5 での動作確認。
  Compatible with WordPress 4.9.5

Ver2.1.1
* 設定画面に「続きを読む」ボタンの文字の色とサイズを追加しました。
  Added: Added setting of color and size of "Read more".

Ver2.1.0.1
* カード管理に「リンク切れ」の項目を追加しました。
  Added: Added "Link broken" item to card management.
* スタイルシートを読み込まないときに簡易表示するように修正しました。（Google AMP対応）
  Modified: If CSS is not loaded, display simple.
* テキストエディタのクイックタグを表示するかを選択できるように変更しました。
  Modified: Changed so that you can choose whether to display the quick tag of the text editor.
* ビジュアルエディタの挿入ボタンを表示するかを選択できるように変更しました。
  Modified: Changed so that you can choose whether to display the insert button of the visual editor.
* 続きを読むボタンを追加できるように修正しました。（Thanks @R18otomegame）
  Added: Added so that you can set the Read more button
* 設定画面の誤記を修正しました。
  Fixed: The mistyping was corrected.
* 設定画面の設定項目を再配置しました。
  Modified: The setting items on the setting screen have been relocated.
* 設定画面にバージョンを表記しました。
  Modified: Version was written on setting screen.

Ver2.0.8
* WordPress 4.9.4 での動作確認。
  Compatible with WordPress 4.9.4
* 設定画面のショートコードの表示を修正しました。
  Fixed: Fixed so that the short code is displayed immediately on the setting screen.
* スタイルシートを追加できるように修正しました。
  Fixed: Fix to be able to add stylesheet.
* 管理画面でワーニングが出ていたのを修正しました。
  Fixed: Fixed a bug.

Ver2.0.7.2
* WordPress 4.9.2 での動作確認。
  Compatible with WordPress 4.9.2
* 設定画面の一部が日本語表記になっていなかったのを修正しました。
  Fixed: A part of the setting screen was not written in Japanese was fixed.

Ver2.0.7.1
* バグ修正。
  Fixed: Fixed a bug.

Ver2.0.7
* WordPress 4.9 での動作確認。
  Compatible with WordPress 4.9
* URLパラメーターが無効な場合にエラー表示する機能から一部のURLを除外しました。
  Modified: Exclude some URLs from errors
* サブディレクトリ型のマルチサイトのとき、メインサイトからサブサイトを外部リンクと判定する設定を追加しました。
  Added: In the case of the multi-site of the subdirectory type, the site under the subdirectory is judged as an external site.

Ver2.0.6
* URLパラメーターが無効な場合にエラー表示する機能を追加しました。
  Added the function to display URL parameter.

Ver2.0.5
* 内部リンクの記事ID取得が失敗した場合に外部アクセスする機能を追加しました。（サイト表示が遅くなる可能性があります）
  Added: If the PostID can not be acquired, the URL of the redirect destination is acquired.

Ver2.0.4.1
* アクセスされたURLの末尾が「/?amp=1」だった場合に簡易表示する設定を追加。（Google AMP暫定対応）
  Added: Simple display if the end of URL is `/?amp=1`.
* ドキュメント修正。
  Fixed: Fixed typographical errors in `readme.txt`.

Ver2.0.4
* WordPress 4.8.2 での動作確認。
  Compatible with WordPress 4.8.2
* 「はてなブログカード」を使用した際のURLを変更しました。
  Modified: Hatena URL changed.
* URLの記述ミスに対応しました。
  Modified: Corresponded to URL mistake.
* 「押しピン」の画像を変更しました。
  Modified: Changed the image of "push pin".
* 「かんたん書式設定」にWordPress標準ブログカード風の「スクエア」を追加しました。
  Added: Tiny format 'Square'.
* サムネイルの位置に「上側」を追加しました。
  Added: "Upper" has been added to the position of the thumbnail.

Ver2.0.3
* 404エラーのときでもリンクを有効にする設定を追加しました。（Thanks @toru1231）
  Added: Added setting to enable link even on 404 error.
* 内部リンクの抜粋が取得できていなかったのを修正しました。
  Fixed: Fixed an excerpt of the internal link could not be acquired.
* 外部リンクのサムネイル取得が出来なくなる不具合を修正しました。
  Fixed: Fixed a bug that you can not acquire thumbnails of external links.

Ver2.0.2
* サイトアイコンのURLを取得するように修正しました。
  Fixed: Fix to get URL of site icon.
* サムネイル画像、サイトアイコンが相対指定の場合に対応しました。
  Modified: Corresponds to relative specified URL.
* パラメータが誤っているときにエラーが表示されない場合があったのを修正しました。
  Fixed: Fix to display error when parameter is wrong.

Ver2.0.1.1
* 警告エラーが発生していたのを修正しました。
  Fixed: Fixed a bug.

Ver2.0.1
* 内部リンクのカテゴリーページ／タグページに対応しました。
  Added: Supported display of category page.

Ver2.0.0.3
* Ver2.0.0.2で発生した内部リンクが取得できない不具合を修正しました。
  Fixed: Fixed a bug.

Ver2.0.0.2
* 未実装のJavaScriptの呼び出しがあったので修正しました。
  Fixed: Fixed a bug.

Ver2.0.0.1
* idn_to_utf8()が実装されていない環境でエラーが出ていたので対応しました。
  Fixed: Fixed a bug.

Ver2.0.0
* URL指定に「href」も使用できるように変更しました。（Thanks @weblearninglog）
  Modified: "href" was added to the parameter that specifies the URL.
* テキストエディタにクイックタグを追加しました。（Thanks @kumasan_kenkou）
  Added: A quick tag was added to the text editor.
* ビジュアルエディタにリンクカード作成ボタンを追加しました。
  Added: A card insertion button was added to the visual editor.
* テキストリンクだけが記載されている行をリンクカードに変更する機能を追加しました。
  Added: Added the function to convert text link to card.
* URLだけが記載されている行をリンクカードに変更する機能を追加しました。（Thanks @hina01011）
  Added: Added the function to convert URL to card.
* カード管理画面のタイトルと抜粋文を変更されている場合に太文字で表示するようにしました。
  Modified: Changed so that changed parts are displayed in bold letters on the card management screen.
* 日本語ドメイン（IDNA ASCIIドメイン）の表示に対応しました。（Thanks @ichinosecom）
  Added: It supports display of IDNA ASCII domain.

Ver1.8.2
* スタイルシートのURLからスキームを削除しました。（Thanks @mataku_hair）
  Modified: The style sheet URL was corrected.
* InstantWPで使用した場合にカード管理画面が文字化けするのを修正しました。（Thanks aya）
  Fixed: Fixed garbled characters on the management screen.
* 外部サイトのサムネイルの保存ディレクトリを変更しました。
  Modified: Changed directory to save thumbnails.
* カード管理画面を狭い画面で見ると表示が崩れるのを修正しました。
  Fixed: Fixed display collapse of the management screen.
* カード管理画面の文字セットの列を非表示にしました。
  Modified: The character set column of the management screen was deleted.
* カード管理画面のソーシャルカウントの列をまとめました。
  Modified: Changed the social count column of the management screen.
* カード管理画面に外部サイトのサムネイル画像の表示を追加しました。
  Modified: The thumbnail display was added to the management screen.

Ver1.8.1
* WordPress 4.8 での動作確認。
  Compatible with WordPress 4.8
* サムネイルの取得時、フルサイズの画像を取得していたのを修正。(Thanks @cstudyupdate)
  Fixed: Fixed a bug. Corrected the size of thumbnail to be acquired.
* 外部サイトのサムネイルの直接取得に対応。
  Added: Added setting the direct acquisition of the thumbnail of the external site.
* 「かんたん書式設定」にはてなブログカード風の「シンプル」を追加。
  Added: Tiny format 'Simple'.

Ver1.8.0
* 設定画面のカラーコード入力にチェックを追加。
  Added: Added color code check.
* アクセスされたURLの末尾が「/amp」「/amp/」だった場合に簡易表示する設定を追加。（Google AMP暫定対応）（Thanks @misoji_13）
  Added: Simple display if the end of URL is `/amp`.
* 「かんたん書式設定」に「押しピン」を追加。（Thanks @kautakku ）
  Added: Tiny format 'Pushpin'.

Ver1.7.9.1
* 抜粋文の文字フォントサイズが枠線のものになってしまう不具合を修正。（Thanks @cgrio0822）
  Fixed: Fixed a bug. Incorrect font size of excerpt.


Ver1.7.9
* Fixed: Fixed a bug that table is not created.

* METAタグの名前が大文字が混ざっていると取得できなかったのを修正。（Thanks @J_kindan）
* 内部リンクが取得できない時に外部アクセスしていたのが高負荷に繋がっていたため、外部アクセスしないように修正。（Thanks @J_kindan）

Ver1.7.8
* Fixed: Fixed a bug that table is not created.

* キャッシュ用DBが作成されない不具合を修正。（Thanks @J_kindan）

Ver1.7.7
* アイキャッチ画像が設定されていないテーマの場合にエラーが発生してしまうのを修正。（Thanks enomoto、sato）
  Fixed: Fixed a bug

Ver1.7.6
* Pzカード設定画面に用例などを追加。
  Added: Add tips at settings screen
* 「かんたん書式設定」に「縫い目」を追加。（Thanks @i_tsu_tsu）
  Added: Tiny format 'Stitch'.
* サムネイルのサイズを指定できるように変更。（Thanks @misoji_13）
  Modified: Able to change the size of the thumbnail.

Ver1.7.5
* WordPress 4.7.1 での動作確認。
  Compatible with WordPress 4.7.1.
* アクティベート／バージョンアップ時に重複データを削除。
  Cleaning up garbage from the database at activation.
* Pzカード設定画面の項目追加と整理。
  Modified: Cleaned up the settings screen
* Pzカード設定画面に用例などを追加。
  Added: Add tips at settings screen
* サイト情報、タイトル、URL、抜粋文部分の行の高さを追加。（Thanks @keitaihoo、@ud_fibonacci）
  Added: Added setting. `Height` in letter.
* 末尾のスラッシュを無視する設定を追加。
  Added: Added setting. Trailing slash.
* フェイスブックのシェア数取得方法の修正。（Thanks @i_tsu_tsu）
  Fixed: facebook API.
* Pzカード管理画面での内部リンクの判定方法を変更。
* 内部リンクのキャッシュが正常に作成されない場合があったのを修正。（Thanks @i_tsu_tsu）
* 内部リンクをキャッシュから取得した場合に画像が表示されなかったのを修正。（Thanks @i_tsu_tsu）
* リンク先がリダイレクトされているときの追尾を選択できる設定を追加。（Thanks @fumieblog）
* リンク先がリンク切れになっていないかチェックする設定を追加。（Thanks @misoji_13）
* リンク先がリンク切れの場合、Aタグを無効にする設定を追加。
* WebAPIに使用しているURLのデフォルトをSSL対応のものに変更。（Thanks @fumieblog、@hareannie01）

Ver1.7.4
* キャッシュ用DBが作成されない不具合を修正。
  Fixed: Fixed a bug that table is not created.

Ver1.7.3
* ドメイン名が取得できていない不具合を修正。
  Fixed: Fixed a bug that domain-name disappears.

Ver1.7.2
* WordPress 4.6 での動作確認。
  Compatible with WordPress 4.6.
* 幅に合わせて縮小を有効にしたとき、サムネイルと合わせて文字サイズも小さくするように修正。（Thanks @fumieblog）
  Modified: Modified so as also to small character size to fit the size of screen.
* 管理画面で再取得時にソーシャルカウントが消えてしまう不具合を修正。（1.7.1で発生）（Thanks @i_tsu_tsu）
  Fixed: Fixed a bug that social count disappears.
* 内部リンクの画像が取得できない不具合を修正。（1.7.1で発生）（Thanks @i_tsu_tsu）
  Fixed: Fixed a bug that thumbnail can not display.
* Fixed: When the multi-site, fixes a bug that setting is not properly reflected.
  マルチサイトへの対応方法が誤っていたため修正。（1.7.1で発生）（Thanks @kyutechnabe）

Ver1.7.1
* 記事内容がキャッシュされない不具合を修正。（Thanks @i_tsu_tsu）
  Fixed: Fixed a bug that article content can not be acquired.
* 取得時エラーのもののサムネイル表示をしないように修正。（Thanks @misoji_13）
  Modified: Time of the error, modified so that it does not display the thumbnail.
* マルチサイトへの仮対応。（Thanks @kyutechnabe）
  Modified: Modification of the order to respond to multi-site.

Ver1.7.0
* ドメイン名のみのときに最後のスラッシュを削除する機能を追加。（Thanks @toru1231）
  Added: Added setting. `In the case of domain names, to ignore the trailing-slash`.
* 定型書式に「小麦色」を追加。（Thanks @fumieblog）
  Added: Added border `Wheat'.

Ver1.6.9
* WordPress 4.5.3 での動作確認。
  Compatible with WordPress 4.5.3.
* 表示幅によってサムネイルを調整する「幅に合わせて縮小」を初期選択するように変更。
  Modified: Scaled down to fit the screen size in setting. Default change `disabled` to `enabled`.
* Twitter代替API count.jsoon を使用するように変更。
  Modified: Use an alternative API to get the Twitter count.
* 内部リンクのときでWordPress標準のサイトアイコンが設定されていない場合、内部取得を選べないように修正。（Thanks @meiko2285）
  Fixed: Fix the method of acquiring the site icon in the internal site.
* 内部リンクのときでサムネイル（アイキャッチ）が設定されていない場合、WebAPIを利用する設定を追加。（Thanks @fumieblog）
  Added: Added thumbnail acquisition method at the internal links.
* SSL証明書の検証を無効にする機能を設定に追加。
  Added: Added the ability to disable the verification of SSL certificate.
* リンク切れチェック（準備中）(Thanks @misoji_13)

Ver1.6.8
* WordPress 4.5.2 での動作確認。
  Compatible with WordPress 4.5.2.
* 警告エラーを修正しました。(@junya_0606)
  Fixed: Fixed a notice.
* 指定したリンク先によってはMETAタグを内部テーブルに展開するのに失敗してFatalエラーが出るのを修正。(Thanks @misoji_13 , @ryu-blacknd)
  Fixed: Fixed an error. In had failed Perth META tags.
* カード管理画面のPHPショートタグを使用しないように修正しました。(Thanks @toru1231)
  Fixed: Fixed so as not to use PHP-short-tags.

Ver1.6.7
* 内部リンクの記事抜粋方法を選択する機能を設定に追加。（Thanks @okamurajun）
  Added: Added a method of article excerpt internal link in setting.

Ver1.6.6
* 画面の幅によってサムネイルを小さくする機能を設定に追加。（Thanks 弁保社長）
  Added: Scaled down to fit the screen size in setting.

Ver1.6.5
* WordPress 4.4 での動作確認。
  Compatible with WordPress 4.4.
* 設定画面に文字のふちどり指定を追加。(Thanks @okaerinasainet)
  Added: Add a border of letters in setting.
* facebookのシェアURLの指定が誤っていたため修正。
  Fixed: Fixed an error in the URL of facebook.

Ver1.6.4
* フェイスブックのシェア数が2以上でも1と表示されていたのを修正。（Thanks 弁保社長）
  Fixed: Shares of facebook has not been able to properly get.
* 設定画面にリンクカードのDIV要素に任意のクラス名を設定できるように追加。（Thanks @misoji_13)
  Added: Grant function of any class name

Ver1.6.3
* ツイッターのツイート数取得API終了に伴い、ツイート数取得処理を削除。設定画面に更新されない旨のメッセージを追加。
  Modified: Correspondence associated with the end Tweets number acquiring API.
* ツイッターのシェア数表示の初期選択を「表示しない」に変更。
* カード管理画面からソーシャルカウントの再取得を行ったとき、処理を二度行っていたので修正。（1.6.0で発生した不具合）
  Bugfix

Ver1.6.2
* サンフランシスコ時間で11月20日になりましたが、ツイート数が取得できているので制限を一時的に解除。
  Modified: Deadline of Tweets number get me grew day.

Ver1.6.1
* 標準時間で11月20日になりましたが、ツイート数が取得できているので制限を一日延長。
  Modified: Deadline of Tweets number get me grew day.

Ver1.6.0
* リンク先の取得に wp_remote_get() を使用していたのを、cURL に変更。
  Modified: Acquired without the wp_remote_get, modified to use a cURL.
* charset の取得方法を変更。
  Modified: Fixed character set acquisition method.
* ソーシャルカウントの取得をスケジュール方式に変更。
  Modified: Fixed social count set acquisition method.
* 「カード内側の余白」の設定を追加と、それに伴うCSS修正。（Thanks yunosuke）
  Added: Add the margins of the inner card.

Ver1.1.1
* METAタグの取得方法を修正しました。
  Fixed: Fixed to had failed parsing of meta tags.

Ver1.1.0
* 2015年11月20日までのTwitter非公式API廃止に伴い、同日以降取得しないように修正。
  Modified: Since November 20, 2015 , it does not use the Twitter API.
* 「新しいウィンドウで開く」をチェックボックスからリストに変更し、「モバイル以外（のみ新しいウィンドウで開く）」を追加。（Thanks @misoji_13）
  Added: It can be selected "Other than mobile" and "All client" in the setting of "Open new window/tab".

Ver1.0.3
* キャッシュ保存時にキーが正しく設定されないことがあったのを修正。
* 「カード管理」画面で内部ID（連番）を表示するように修正。
* 定型書式「紙がめくれる効果」を修正。（テーマによってはレイアウトが崩れる可能性があります）
* 定型書式「テープと紙めくれ」を追加。（テーマによってはレイアウトが崩れる可能性があります）

Ver1.0.2
* 「カード管理」でキャッシュを編集したとき、一部の文字をエスケープしていなかったのを修正。
* バージョンアップの度に一部のパラメータがデフォルトに戻らないように修正。
* プログラム内でのキャッシュの読み書き方法の改善。

Ver1.0.1
* 「カード管理」でキャッシュを編集したとき、内部IDがクリアされてしまう不具合を修正。

Ver1.0.0
* 全体的なプログラムの見直し。
  * URLが空欄などの場合の対応。
  * 文字エンコードまわりを修正。
  * DBキャッシュまわりを修正。
* ショートコードの囲い文字の扱いの仕様変更。
  * ショートコード1にのみ適用されるように修正。
  * タイトルがURLになってしまう不具合修正。
* ショートコード3を解放。
* キャッシュ管理画面を修正。
  * リンク先単体の「編集」「再取得」「削除」が行えるように修正。
  * 一括処理に「再取得」を追加。
  * 内部リンクのURLにリンクを設定。
  * ドメインで抽出できるように修正。
  * ページング機能を追加。

Ver0.1.4
* <head>にprefixなどがあるときに、metaタグの解析に失敗していたのを修正。
* パラメータに閉じの「半角角かっこ（大かっこ）」がある場合に、URLに余分なコードが入ってしまったのを改善。

Ver0.1.3
* content=''になっているOGP情報は無視するように修正。
* サムネイル取得APIをWordPress.comのものを初期値に変更。
* metaタグ表記にシングルクォートが使われている場合、取得できていなかったため対応。
* タイトルや抜粋文をパラメータ等で設定した場合にもHTML等を除去するように変更。
* 「カード管理」の画面のセキュリティを強化。
* サイト情報を下側にしているときに定型書式「Pzカード標準書式」を使用したときサイト名が見えなくなる現象に対応。
* 設定画面の「サイト情報」の位置を変更。
* 設定画面にサイト情報と記事内容の間を区切るための「区切り線」を変更。

Ver0.1.2
* 「新しいウィンドウで開く」の設定を追加。
* カード管理画面のソート順を修正。
* フェイスブックの表記を「f」から「fb」へ変更。

Ver0.1.1
* 公開後発見されたバグを修正。

Ver0.1.0
* 公式プラグインディレクトリでの最初の公開バージョン。

Ver0.0.1
* 当サイトでの最初の公開バージョン。

Ver0.0.0
* 途中まで作成していたバージョンを破棄。Pz-HatenaBlogCard ver1.2.5 を元に、DBアクセス部分を移植して、Pz-LinkCardを作成。
* テストサイトでの動作検証。
* 当サイトでの本番環境での動作検証。


== Upgrade notice ==

== Arbitrary section ==

= Display and DB cache =

This plug-in one create a DB table when you have activated. ( Prefix + "pz_linkcard")

Open the pages of the article when the "For the first time it appears " , and caches by obtaining the title excerpt from the linked site to the DB.

Therefore , the display for the first time is slow , the second and subsequent display is fast.


= Create files =

CSS file are stored in a custom folder under `/wp-content/Uploads` .


= Use API =

Number of SNS share have been acquired by the JSON request.

* Twitter ... http://urls.api.twitter.com/1/urls/count.json?url=[URL]

* Facebook ... http://graph.facebook.com/?id=[URL]

* Hatena ... http://api.b.st-hatena.com/entry.count?url=[URL]


Displays using the `Google-favicon API` to get the favicon. This can be changed.


Displays using the `WordPress.org mshots API` to get the thumbnail. This can be changed.


= 表示とキャッシュ =

このプラグインは、有効化したときにDBテーブルを一つ作成します。（プレフィックス＋「pz_linkcard」）

外部リンクを設定した場合、記事のページを開いて「初めて表示された」ときに、リンク先のサイトからタイトル・抜粋文を取得してDBへキャッシュします。


カードの枚数分、外部サイトへのアクセスが発生するため多量のリンクを作成すると表示に時間がかかります。

次回の表示はDBキャッシュから行うので高速に表示を行います。

（内部でのDBアクセスが発生しますが、通常は軽微なものです。カード1枚表示のたびに、取得のために1クエリ発行します。更新が発生した場合には挿入・更新のためのクエリが1回発生します。）


= ソーシャルカウントの取得 = 

ソーシャルカウントについては、「ツイッターのツイート数」「フェイスブックのシェア数」「はてなブックマークのブックマーク数」の3種類に対応しています。

それぞれAPIへのJSONリクエストにより値を取得します。

これらのアクセスも遅い場合がありますが、取得した値はタイトルや抜粋文と同様、DBへキャッシュを行うため、直近の表示にはAPIアクセスが発生しません。

ソーシャルカウントの再取得は、最後の取得から4時間～36時間程度のランダムな時間で行います。

この間隔については、改善の余地があります。

また、各APIについては、仕様変更やサービス終了に伴い、正常に取得できなくなる場合があります。


= 画像取得APIの利用 =

サムネイルの取得については、「取得しない」を標準での設定としています。

画像取得APIのURLを指定した上で、「WebAPIを利用する」にすることで、画像も取得できます。

画像取得APIの設定については、下記のページを参照ください。

https://popozure.info/20151004/9317


サイトアイコン（ファビコン）についても、同様にWebAPIを使用して取得しています。

こちらは標準設定で「WebAPIで取得する」になっており、Googleのファビコン取得APIのアドレスを設定しています。

これは、リンク先のURLを入力することによって、サイトアイコンの画像を取得できるものです。

公式なサービスでは無いため、仕様変更やサービス終了に伴い、正常に取得できなくなく場合があります。


= その他 =

Pz-HatenaBlogCard からの設定引き継ぎ機能はありません。この機会に触ったことのなかった設定項目にも触れていただければ幸いです。

ショートコードを変えることで、Pz-HatenaBlogCard と併用利用することができますが、通常はリソース消費が増えるだけなので、推奨はしません。


ショートコード内にURLを記述した場合、WordPressピンバックは飛びません。


設定項目については、WordPress標準の options に設定内容を保存します。キーは「Pz-LinkCard_options」の1レコードです。


なお、アンインストールを行う際には、キャッシュを保管するDBテーブルと、options内の設定ファイルは削除されます。

アンインストール時の削除に関してはプラグインディレクトリ内の uninstall.php で行っています。