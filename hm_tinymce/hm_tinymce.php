<?php
/*
Plugin Name: Tiny MCE;
Description: Thay thế bộ soạn thảo thành Tiny MCE (Tiếng Việt);
Version: 1.0;
Version Number: 1;
*/

/** dùng hook filter thay class của tinymce vào textarea */

register_filter('input_editor_input','change_tinymce_class');

function change_tinymce_class($field_array){
	
	$field_array['addClass'] = 'tinymce';
	return $field_array;
	
}

/** dùng hook action thêm js vào đầu trang admin cp */

register_action('hm_admin_head','add_tinymce_js');

function add_tinymce_js(){

?>
	<!-- Tiny MCE Plugin -->
	<script type="text/javascript" src="<?php echo PLUGIN_URI; ?>hm_tinymce/tinymce/tinymce.min.js"></script>
	<script>
	tinymce.init({
		convert_urls : false,
		selector: "textarea.tinymce",
		theme: "modern",
		height: 500,
		plugins: [
			"advlist autolink lists link image charmap print preview hr anchor pagebreak",
			"searchreplace wordcount visualblocks visualchars code fullscreen",
			"insertdatetime media nonbreaking save table contextmenu directionality",
			"emoticons template textcolor colorpicker textpattern"
		],
		
		toolbar1:"bold,italic,blockquote,bullist,numlist,alignleft,aligncenter,alignjustify,alignright,link,unlink,underline,table,undo,redo,fullscreen",
		toolbar2:"formatselect,styleselect,fontsizeselect,fontselect,strikethrough,outdent,indent,pastetext",
		toolbar3:"cut,copy,subscript,superscript,image,anchor,code,rtl,media,ltr,backcolor,forecolor,removeformat,charmap,emoticons",
		image_advtab: true,
		templates: [
			{title: 'Test template 1', content: 'Test 1'},
			{title: 'Test template 2', content: 'Test 2'}
		],
		setup: function (editor) {
			editor.on('change', function () {
				tinymce.triggerSave();
			});
		}
	}); 
	
	tinymce.addI18n( 'vi', {"New document":"V\u0103n b\u1ea3n m\u1edbi","Formats":"\u0110\u1ecbnh d\u1ea1ng","Headings":"Ti\u00eau \u0111\u1ec1","Heading 1":"Ti\u00eau \u0111\u1ec1 1","Heading 2":"Ti\u00eau \u0111\u1ec1 2","Heading 3":"Ti\u00eau \u0111\u1ec1 3","Heading 4":"Ti\u00eau \u0111\u1ec1 4","Heading 5":"Ti\u00eau \u0111\u1ec1 5","Heading 6":"Ti\u00eau \u0111\u1ec1 6","Blocks":"Kh\u1ed1i","Paragraph":"\u0110o\u1ea1n","Blockquote":"Tr\u00edch d\u1eabn","Pre":"Tr\u01b0\u1edbc","Address":"\u0110\u1ecba ch\u1ec9","Inline":"Thu\u1ed9c c\u00f9ng m\u1ed9t d\u00f2ng","Underline":"G\u1ea1ch ch\u00e2n","Strikethrough":"G\u1ea1ch gi\u1eefa t\u1eeb","Subscript":"Ch\u1eef nh\u1ecf \u1edf d\u01b0\u1edbi","Superscript":"Ch\u1eef nh\u1ecf \u1edf tr\u00ean","Clear formatting":"X\u00f3a \u0111\u1ecbnh d\u1ea1ng","Bold":"\u0110\u1eadm","Italic":"Nghi\u00eang","Code":"M\u00e3","Source code":"M\u00e3 ngu\u1ed3n","Font Family":"Ph\u00f4ng ch\u1eef","Font Sizes":"K\u00edch c\u1ee1 ch\u1eef","Align center":"C\u0103n gi\u1eefa","Align right":"C\u0103n l\u1ec1 ph\u1ea3i","Align left":"C\u0103n l\u1ec1 tr\u00e1i","Justify":"C\u0103n 2 l\u1ec1","Increase indent":"T\u0103ng kho\u1ea3ng c\u00e1ch th\u1ee5t \u0111\u1ea7u d\u00f2ng","Decrease indent":"Gia\u0309m kho\u1ea3ng c\u00e1ch th\u1ee5t \u0111\u1ea7u d\u00f2ng","Cut":"C\u1eaft","Copy":"Sao ch\u00e9p","Paste":"D\u00e1n","Select all":"Ch\u1ecdn t\u1ea5t c\u1ea3","Undo":"L\u00f9i l\u1ea1i","Redo":"L\u00e0m l\u1ea1i b\u01b0\u1edbc v\u1eeba r\u1ed3i","Cancel":"H\u1ee7y","Close":"\u0110\u00f3ng","Visual aids":"Hi\u0300nh minh ho\u0323a","Bullet list":"Danh s\u00e1ch li\u1ec7t k\u00ea \u0111\u01b0\u1ee3c \u0111\u00e1nh s\u1ed1","Numbered list":"Danh s\u00e1ch \u0111\u01b0\u1ee3c \u0111\u00e1nh s\u1ed1","Square":"Vu\u00f4ng","Default":"M\u1eb7c \u0111\u1ecbnh","Circle":"V\u00f2ng tr\u00f2n","Disc":"\u0110\u0129a","Lower Greek":"Ki\u1ec3u ch\u1eef Greek th\u01b0\u1eddng","Lower Alpha":"Ki\u1ec3u ch\u1eef Alpha th\u01b0\u1eddng","Upper Alpha":"Ki\u1ec3u ch\u1eef Alpha hoa","Upper Roman":"Roman in hoa","Lower Roman":"Roman th\u01b0\u1eddng","Name":"T\u00ean","Anchor":"Neo li\u00ean k\u1ebft","Anchors":"Neo li\u00ean k\u1ebft","Document properties":"T\u00f9y ch\u1ecdn v\u1ec1 h\u00ecnh \u1ea3nh","Title":"Ti\u00eau \u0111\u1ec1","Keywords":"T\u1eeb kh\u00f3a","Encoding":"M\u00e3 h\u00f3a","Description":"M\u00f4 t\u1ea3","Author":"T\u00e1c gi\u1ea3","Insert\/edit image":"Th\u00eam\/S\u1eeda \u1ea3nh","General":"T\u1ed5ng quan","Advanced":"N\u00e2ng cao","Source":"Ngu\u1ed3n","Border":"Vi\u1ec1n","Constrain proportions":"Gi\u1eef t\u1ec9 l\u1ec7 g\u1ed1c","Vertical space":"Kho\u1ea3ng tr\u1ed1ng chi\u1ec1u d\u1ecdc","Image description":"M\u00f4 t\u1ea3 v\u1ec1 \u1ea3nh","Dimensions":"K\u00edch th\u01b0\u1edbc","Insert image":"Ch\u00e8n \u1ea3nh","Insert date\/time":"Th\u00eam ng\u00e0y\/gi\u1edd","Insert\/edit video":"Ch\u00e8n\/ch\u1ec9nh s\u1eeda video","Poster":"\u00c1p ph\u00edch","Alternative source":"Ngu\u1ed3n thay th\u1ebf","Paste your embed code below:":"D\u00e1n m\u00e3 nh\u00fang c\u1ee7a b\u1ea1n d\u01b0\u1edbi \u0111\u00e2y:","Insert video":"Ch\u00e8n video","Embed":"Nh\u00fang","Special character":"K\u00fd t\u1ef1 \u0111\u1eb7c bi\u1ec7t","Right to left":"Ph\u1ea3i sang tr\u00e1i","Left to right":"Tr\u00e1i sang ph\u1ea3i","Emoticons":"Bi\u1ec3u t\u01b0\u1ee3ng c\u1ea3m x\u00fac","Nonbreaking space":"Kh\u00f4ng gi\u00e3n d\u00f2ng","Page break":"Ng\u1eaft trang","Paste as text":"D\u00e1n nh\u01b0 v\u0103n b\u1ea3n","Preview":"Xem th\u1eed","Print":"In","Save":"L\u01b0u thay \u0111\u1ed5i","Fullscreen":"To\u00e0n m\u00e0n h\u00ecnh","Horizontal line":"\u0110\u01b0\u1eddng ngang","Horizontal space":"Kho\u1ea3ng tr\u1ed1ng chi\u1ec1u ngang","Restore last draft":"Kh\u00f4i ph\u1ee5c l\u1ea1i b\u1ea3n nh\u00e1p cu\u1ed1i","Insert\/edit link":"Th\u00eam\/S\u1eeda \u0111\u01b0\u1eddng d\u1eabn","Remove link":"X\u00f3a \u0111\u01b0\u1eddng d\u1eabn","Could not find the specified string.":"Kh\u00f4ng th\u1ec3 t\u00ecm th\u1ea5y chu\u1ed7i quy \u0111\u1ecbnh.","Replace":"Thay th\u1ebf","Next":"Ti\u1ebfp theo","Prev":"Tr\u01b0\u1edbc","Whole words":"To\u00e0n b\u1ed9 t\u1eeb","Find and replace":"T\u00ecm v\u00e0 thay th\u1ebf","Replace with":"Thay th\u1ebf b\u1eb1ng","Find":"T\u00ecm","Replace all":"Thay th\u1ebf t\u1ea5t c\u1ea3","Match case":"Tu\u0300y cho\u0323n t\u01b0\u01a1ng \u01b0\u0301ng","Spellcheck":"Ki\u1ec3m tra ch\u00ednh t\u1ea3","Finish":"K\u1ebft th\u00fac","Ignore all":"B\u1ecf qua t\u1ea5t c\u1ea3","Ignore":"B\u1ecf qua","Insert table":"Ch\u00e8n b\u1ea3ng","Delete table":"X\u00f3a b\u1ea3ng","Table properties":"T\u00f9y ch\u1ecdn v\u1ec1 h\u00ecnh \u1ea3nh","Row properties":"Sao ch\u00e9p d\u00f2ng","Cell properties":"Sao ch\u00e9p d\u00f2ng","Row":"D\u00f2ng","Rows":"D\u00f2ng","Column":"C\u1ed9t","Cols":"C\u00e1c c\u1ed9t","Cell":"\u00d4 ph\u1ea7n t\u1eed","Header cell":"\u00d4 ti\u00eau \u0111\u00ea\u0300","Header":"Ti\u00eau \u0111\u1ec1","Body":"Ph\u1ea7n th\u00e2n","Footer":"Ph\u1ea7n cu\u1ed1i","Insert row before":"Th\u00eam d\u00f2ng \u1edf tr\u01b0\u1edbc","Insert row after":"Th\u00eam d\u00f2ng \u1edf sau","Insert column before":"Th\u00eam c\u1ed9t \u1edf tr\u01b0\u1edbc","Insert column after":"Th\u00eam c\u1ed9t \u1edf sau","Paste row before":"D\u00e1n d\u00f2ng \u1edf tr\u01b0\u1edbc","Paste row after":"D\u00e1n d\u00f2ng \u1edf sau","Delete row":"X\u00f3a d\u00f2ng","Delete column":"X\u00f3a c\u1ed9t","Cut row":"C\u1eaft d\u00f2ng","Copy row":"Sao ch\u00e9p d\u00f2ng","Merge cells":"G\u1ed9p c\u1ed9t","Split cell":"Chia \u00f4 trong b\u1ea3ng","Height":"Cao","Width":"R\u1ed9ng","Caption":"Ch\u00fa th\u00edch","Alignment":"L\u1ec1","Left":"Tr\u00e1i","Center":"Ch\u00ednh gi\u1eefa","Right":"Ph\u1ea3i","None":"Kh\u00f4ng c\u0103n","Top":"Tr\u00ean","Middle":"Gi\u1eefa","Bottom":"D\u01b0\u1edbi","Row group":"Nho\u0301m do\u0300ng","Column group":"Nh\u00f3m c\u1ed9t","Row type":"Ki\u00ea\u0309u do\u0300ng","Cell type":"Ki\u00ea\u0309u \u00f4","Cell padding":"Khoa\u0309ng ca\u0301ch trong \u00f4","Cell spacing":"Khoa\u0309ng ca\u0301ch vi\u00ea\u0300n \u00f4","Scope":"Pha\u0323m vi","Insert template":"Ch\u00e8n m\u1eabu","Templates":"C\u00e1c m\u1eabu","Background color":"M\u00e0u n\u1ec1n","Text color":"M\u00e0u ch\u1eef v\u0103n b\u1ea3n","Show blocks":"Hi\u1ec3n th\u1ecb c\u00e1c kh\u1ed1i","Show invisible characters":"Hi\u1ec3n th\u1ecb c\u00e1c k\u00fd t\u1ef1 \u1ea9n","Words: {0}":"C\u00e1c t\u1eeb: {0}","Paste is now in plain text mode. Contents will now be pasted as plain text until you toggle this option off.":"D\u00e1n n\u00f4\u0323i dung hi\u00ea\u0323n ta\u0323i \u0111ang trong ch\u1ebf \u0111\u1ed9 v\u0103n b\u1ea3n \u0111\u01a1n gi\u1ea3n. N\u1ed9i dung s\u1ebd \u0111\u01b0\u1ee3c d\u00e1n nh\u01b0 v\u0103n b\u1ea3n tr\u01a1n cho \u0111\u1ebfn khi b\u1ea1n thay \u0111\u1ed5i t\u00f9y ch\u1ecdn n\u00e0y.\n\nN\u1ebfu b\u1ea1n \u0111ang mu\u1ed1n d\u00e1n n\u1ed9i dung t\u1eeb Microsoft Word, h\u00e3y t\u1eaft l\u1ef1a ch\u1ecdn n\u00e0y \u0111i. Tr\u00ecnh ch\u1ec9nh s\u1eeda s\u1ebd t\u1ef1 \u0111\u1ed9ng x\u00f3a v\u0103n b\u1ea3n \u0111\u01b0\u1ee3c d\u00e1n t\u1eeb Word.","Rich Text Area. Press ALT-F9 for menu. Press ALT-F10 for toolbar. Press ALT-0 for help":"Rich Text Area. Press Alt-Shift-H for help","You have unsaved changes are you sure you want to navigate away?":"C\u00e1c thay \u0111\u1ed5i b\u1ea1n v\u1eeba th\u1ef1c hi\u1ec7n s\u1ebd b\u1ecb m\u1ea5t n\u1ebfu b\u1ea1n \u0111i kh\u1ecfi trang n\u00e0y khi ch\u01b0a l\u01b0u b\u00e0i.","Your browser doesn't support direct access to the clipboard. Please use the Ctrl+X\/C\/V keyboard shortcuts instead.":"Your browser does not support direct access to the clipboard. Please use keyboard shortcuts or your browser\u2019s edit menu instead.","Insert":"Ch\u00e8n","File":"T\u1ec7p tin","Edit":"Ch\u1ec9nh s\u1eeda","Tools":"C\u00e1c c\u00f4ng c\u1ee5","View":"Xem","Table":"B\u1ea3ng","Format":"\u0110\u1ecbnh d\u1ea1ng","Keyboard Shortcuts":"Ph\u00edm t\u1eaft","Toolbar Toggle":"Hi\u1ec7n ho\u1eb7c \u1ea9n thanh c\u00f4ng c\u1ee5","Insert Read More tag":"Ch\u00e8n th\u1ebb \u0110\u1ecdc Th\u00eam","Remove":"G\u1edf b\u1ecf","Edit ":"Ch\u1ec9nh s\u1eeda"});
	
	
	$(document).ready(function(){
		$(document).on('click', '.use_media_file_insert', function(){
			var file_id = $('#file_id').val();
			var file_src = $('#file_src').val();
			var use_media_file = $(this).attr('use_media_file');
			var img = '';
			img = '<img src="'+file_src+'" />';
			tinymce.get(use_media_file).execCommand('mceInsertContent', false, img);
		});
	});
	</script>
	<!-- END Tiny MCE Plugin -->
<?php
	
}

?>