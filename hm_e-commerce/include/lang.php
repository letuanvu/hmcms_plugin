<?php
function hme_lang($name){
	if(file_exists(BASEPATH.'/'.HM_PLUGIN_DIR.'/hm_e-commerce/language/'.LANG.'.php')){
		include(BASEPATH.'/'.HM_PLUGIN_DIR.'/hm_e-commerce/language/'.LANG.'.php');
	}else{
		include(BASEPATH.'/'.HM_PLUGIN_DIR.'/hm_e-commerce/language/vi_VN.php');
	}
	if(isset($hme_lang[$name])){
		return $hme_lang[$name];
	}else{
		return $name;
	}
}
?>