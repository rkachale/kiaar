<?php 
	if(isset($data) && count($data)!=0)
	{ 
        foreach($data["body"] as $item)
        { 
?>
        <div>
            <?=$item['description']?>
        </div>
<?php 
		} 
	} 
?>