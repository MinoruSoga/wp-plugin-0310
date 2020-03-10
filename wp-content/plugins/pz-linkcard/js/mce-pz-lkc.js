(function() {
    // 画面のどこかをクリックしたらモーダルを閉じる
    $("#pz-lkc-overlay,#pz-lkc-close").unbind().click(function(){
        $("#pz-lkc-overlay").css("display", "none");
        $("#pz-lkc-modal").css("display"," none");
        $("#pz-lkc-serif").val("");
		$("#pz-lkc-check").prop("checked", false);
    });

	// [ESC]キーが押されたらCLOSEをクリック
	$(document).keydown(function(e) {
		if (e.keyCode == 27) {
			$("#pz-lkc-close").click();
		}
	});

	$("#pz-lkc-url").bind('paste', function(e){
		if ($("#pz-lkc-url").val() == "") {
			var cb = undefined;
			if (window.clipboardData && window.clipboardData.getData) {
				cb = window.clipboardData.getData('Text');
			} else if (e.originalEvent.clipboardData && e.originalEvent.clipboardData.getData) {
				cb = e.originalEvent.clipboardData.getData('text/plain');
			}
	        var ur = cb.match(/(https?:\/\/[^\"\':\]]*)/);
			if (ur != null) {
				ur = ur[1];
				$("#pz-lkc-url").val(ur);
				$("#pz-lkc-url").select();
			}
			return false;
		}
	});

    // 挿入ボタン
    $("#pz-lkc-insert").unbind().click(function(){
        $("#pz-lkc-overlay").css("display","none");
        $("#pz-lkc-modal").css("display","none");
		if ($("#pz-lkc-url").val() != "") {
	    	var sc = "<p>[" + $("#pz-lkc-code").val() + " url=\"" + $("#pz-lkc-url").val() + "\"]</p>";
        	tinymce.activeEditor.selection.setContent(sc);
        }
        tinymce.activeEditor.focus()
        $("#pz-lkc-serif").val("");
		$("#pz-lkc-check").prop("checked", false);
    });


    // ウィンドウのリサイズ
    $(window).resize(centermodal);
    function centermodal() {
        var w = $(window).width();
        var h = $(window).height();
        var mw = $("#pz-lkc-modal").outerWidth();
        var mh = $("#pz-lkc-modal").outerHeight();
        $("#pz-lkc-modal").css( {"left": ((w - mw)/2) + "px","top": ((h - mh)/2) + "px"} );
    }

	tinymce.create('tinymce.plugins.pzlinkcard', {
		init: function(ed, url){
			ed.addButton('pz_linkcard',{
				title: 'Insert Linkcard',
				image: url + '/button.png',
				cmd: 'insert_pz_linkcard'
			});
			ed.addCommand('insert_pz_linkcard', function() {
                $("#pz-lkc-overlay").css("display", "block");
                $("#pz-lkc-modal").css("display", "block");
				$("#pz-lkc-url").val("");
                var st = tinymce.activeEditor.selection.getContent();
                var ur = st.match(/(https?:\/\/[^\"\':\]]*)/);
				if (ur != null) {
					ur = ur[1];
				} else {
					var cb = undefined;
					if (window.clipboardData && window.clipboardData.getData) {
						cb = window.clipboardData.getData('Text');
				        ur = cb.match(/(https?:\/\/[^\"\':\]]*)/);
						if (ur != null) {
							ur = ur[1];
						}
					}
				}
				$("#pz-lkc-url").val(ur);
				centermodal();
                $("#pz-lkc-url").focus();
				$("#pz-lkc-url").select();
			});
		},
		createControl: function(n, cm) {
			return null;
		}
	});
	tinymce.PluginManager.add('pz_linkcard',tinymce.plugins.pzlinkcard);
	tinymce.PluginManager.requireLangPack('pz_linkcard');
})();
