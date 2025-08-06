<?php
// if($_SERVER['HTTP_HOST'] == $this->config->item('host_simsr'))
if(strstr($_SERVER['HTTP_HOST'], $this->config->item('host_simsr')))
{
	$institute_folder = 'simsrbeta';
}
else if(strstr($_SERVER['HTTP_HOST'], $this->config->item('host_research')))
{
	$institute_folder = 'research';
}
else
{
	$institute_folder = 'kiaar_general';
}

include($institute_folder.'/header.php');
echo isset($content)?$content:"";
include($institute_folder.'/footer.php');