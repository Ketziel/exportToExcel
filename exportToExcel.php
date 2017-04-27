<?php

/* Required Functions */
function replaceSpecial($str){
	$chunked = str_split($str,1);
	$str = ""; 
	foreach($chunked as $chunk){
	    $num = ord($chunk);
	    // Remove non-ascii & non html characters
	    if ($num >= 32 && $num <= 123){
	            $str.=$chunk;
	    }
	}   
	return $str;
} 


/* Plugin Settings */
$fields = explode(',',(string)$modx->getOption('fields', $scriptProperties, 'id[Resource id],pagetitle[Title],longtitle[Longtitle],description[Description]'));
$sort = $modx->getOption('sort', $scriptProperties, '{"pagetitle":"ASC","menuindex":"DESC"}');
$parent = $modx->getOption('parent', $scriptProperties, 0);
$unpublished = $modx->getOption('includeUnpublished', $scriptProperties, 0);
$filename = $modx->getOption('filename', $scriptProperties, 'Exported Data');


/* Plugin Output Flags */
$output = '';
$sep = "\t";
$cr = "\n";

/* Get Resources */
$query = array('parent' => $parent);
if ($unpublished == 0){
    $query['published'] = true;
}
$resources = $modx->getIterator('modResource',$query);

/* Build Headers */
foreach($fields as $idx => $field){
    $output.= ($idx != 0 ? $sep : '');
    preg_match("/\[[^\]]*\]/", $field, $title);
    if(count($title) > 0){
        $output.=substr($title[0],1,-1);
        $fields[$idx] = str_replace($title[0],'',$field);
    } else {
        $output.=$field;
    }
}
$output.=$cr;

/* Build Data */
foreach($resources as $idx => $resource){
    foreach($fields as $idx => $field){
        $output.= ($idx != 0 ? $sep : '');
        if (strpos($field, ':') !== false) {
    	   $temp = explode(':',$field);
    	   $field = $temp[0];
    	   $outputFilter = $temp[1];
    	} else {
    	    $outputFilter = '';
    	}
        if(substr($field, 0, 3) == 'TV.'){
            $val = replaceSpecial(strip_tags($resource->getTVValue(substr($field, 3))));
        } else {
            $val = replaceSpecial(strip_tags((string)$resource->get($field)));
        }
        
        if ($outputFilter != ''){
			$val = $modx->runSnippet($outputFilter,array(
			   'input' => $val
			));
		}
        
        $output.=$val;
    }
    $output.=$cr;
}
		

header("Content-type: application/vnd.ms-excel");
header("Content-disposition: attachment; filename=".$filename." (".date("d-m-Y H_i_s").").xls");
header("Pragma: no-cache");
header("Expires: 0");

return $output;