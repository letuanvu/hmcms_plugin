<?php
header("Content-type: text/xml");
$hmdb = new MySQL(true, DB_NAME, DB_HOST, DB_USER, DB_PASSWORD, DB_CHARSET);

$sitemap = '';
$sitemap.= '<?xml version="1.0" encoding="UTF-8"?>'."\r\n";
$sitemap.= '<?xml-stylesheet type="text/xsl" href="'.PLUGIN_URI.'hm_seo/asset/sitemap.xsl"?>'."\r\n";
$sitemap.= '<!-- generator="hoamaicms/1.0" -->'."\r\n";
$sitemap.= '<!-- sitemap-generator-url="hoamaisoft.com" sitemap-generator-version="1.0" -->'."\r\n";
$sitemap.= '<!-- generated-on="26.09.2015 12:11" -->'."\r\n";
$sitemap.= '<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd" xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'."\r\n";

//loop
$tableName=DB_PREFIX."request_uri";
$hmdb->SelectRows($tableName,NULL,NULL,'object_type',FALSE);
while( $row = $hmdb->Row() ){
	$object_id = $row->object_id;
	$object_type = $row->object_type;
	$uri = $row->uri;
	switch ($object_type) {
		case 'content':
		$include_to_sitemap = get_con_val("name=include_to_sitemap&id=$object_id");
		if($include_to_sitemap!='no'){$include_to_sitemap='yes';}
		$status = get_con_val("name=status&id=$object_id");
		if($status!='public'){$include_to_sitemap = 'no';}
		$sitemap_change_frequency = get_con_val("name=sitemap_change_frequency&id=$object_id");
		$sitemap_priority = get_con_val("name=sitemap_priority&id=$object_id");
		$time = get_con_val("name=public_time&id=$object_id");
		$lastmod = '<lastmod>'.date('Y-m-d\TH:i:s+00:00',$time).'</lastmod>';
		$content_thumbnail = get_con_val("name=content_thumbnail&id=$object_id");
		$img = get_file_url($content_thumbnail);

		if($sitemap_change_frequency == 'auto' OR !$sitemap_change_frequency){
			$sitemap_change_frequency = get_option( array('section'=>'hm_seo','key'=>'content_sitemap_change_frequency','default_value'=>'daily') );
		}
		if($sitemap_priority == 'auto' OR !$sitemap_priority){
			$sitemap_priority = get_option( array('section'=>'hm_seo','key'=>'content_sitemap_priority','default_value'=>'0.6') );
		}

		break;
		case 'taxonomy':
		$include_to_sitemap = get_tax_val("name=include_to_sitemap&id=$object_id");
		if($include_to_sitemap!='no'){$include_to_sitemap='yes';}
		$sitemap_change_frequency = get_tax_val("name=sitemap_change_frequency&id=$object_id");
		$sitemap_priority = get_tax_val("name=sitemap_priority&id=$object_id");
		$lastmod = NULL;
		$taxonomy_thumbnail = get_con_val("name=taxonomy_thumbnail&id=$object_id");
		$img = get_file_url($taxonomy_thumbnail);

		if($sitemap_change_frequency == 'auto' OR !$sitemap_change_frequency){
			$sitemap_change_frequency = get_option( array('section'=>'hm_seo','key'=>'taxonomy_sitemap_change_frequency','default_value'=>'daily') );
		}
		if($sitemap_priority == 'auto' OR !$sitemap_priority){
			$sitemap_priority = get_option( array('section'=>'hm_seo','key'=>'taxonomy_sitemap_priority','default_value'=>'0.8') );
		}
		break;
	}
	if($include_to_sitemap == 'yes' AND $time < time()){

		$sitemap.= '<url>'."\r\n";
		$sitemap.= '	<loc>'.SITE_URL.'/'.$uri.'</loc>'."\r\n";
		if($lastmod!=''){
			$sitemap.= '	'.$lastmod."\r\n";
		}
		$sitemap.= '	<changefreq>'.$sitemap_change_frequency.'</changefreq>'."\r\n";
		$sitemap.= '	<priority>'.$sitemap_priority.'</priority>'."\r\n";
		if($img!=''){
			$sitemap.= '	<image:image>'."\r\n";
			$sitemap.= '		<image:loc>'.$img.'</image:loc>'."\r\n";
			$sitemap.= '	</image:image>'."\r\n";
		}
		$sitemap.= '</url>'."\r\n";

	}
}


$sitemap.= '</urlset>';
echo $sitemap;
?>
