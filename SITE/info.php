<?php
$output = '英国欲借助中国留学生缓解住房危机：投资换居留权 两名澳洲男子装高尔夫球手混进朝鲜参赛 全身而退';
if($title_length == -1){
	echo $output.'参数没传到';
}
$len = strlen($output);
echo $len.'<br>';
$output = substr($output, 0, $title_length);
if($len>$title_length) $output.='...';
echo $output.$title_length.' '.$len;
?>
