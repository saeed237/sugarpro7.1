<?php
/*********************************************************************************
 * By installing or using this file, you are confirming on behalf of the entity
 * subscribed to the SugarCRM Inc. product ("Company") that Company is bound by
 * the SugarCRM Inc. Master Subscription Agreement (“MSA”), which is viewable at:
 * http://www.sugarcrm.com/master-subscription-agreement
 *
 * If Company is not bound by the MSA, then by installing or using this file
 * you are agreeing unconditionally that Company will be bound by the MSA and
 * certifying that you have authority to bind Company accordingly.
 *
 * Copyright (C) 2004-2013 SugarCRM Inc.  All rights reserved.
 ********************************************************************************/



if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

function progress_bar_flush()
{
	if(ob_get_level()) {
	    @ob_flush();
	} else {
        @flush();
	}
}

function display_flow_bar($name,$delay, $size=200)
{
	$chunk = $size/5;
	echo "<div id='{$name}_flow_bar'><table  class='list view' cellpading=0 cellspacing=0><tr><td id='{$name}_flow_bar0' width='{$chunk}px' bgcolor='#cccccc' align='center'>&nbsp;</td><td id='{$name}_flow_bar1' width='{$chunk}px' bgcolor='#ffffff' align='center'>&nbsp;</td><td id='{$name}_flow_bar2' width='{$chunk}px' bgcolor='#ffffff' align='center'>&nbsp;</td><td id='{$name}_flow_bar3' width='{$chunk}px' bgcolor='#ffffff' align='center'>&nbsp;</td><td id='{$name}_flow_bar4' width='{$chunk}px' bgcolor='#ffffff' align='center'>&nbsp;</td></tr></table></div><br>";

	echo str_repeat(' ',256);

	progress_bar_flush();
	start_flow_bar($name, $delay);
}

function start_flow_bar($name, $delay)
{
	$delay *= 1000;
	$timer_id = $name . '_id';
	echo "<script>
		function update_flow_bar(name, count){
			var last = (count - 1) % 5;
			var cur = count % 5;
			var next = cur + 1;
			eval(\"document.getElementById('\" + name+\"_flow_bar\" + last+\"').style.backgroundColor='#ffffff';\");
			eval(\"document.getElementById('\" + name+\"_flow_bar\" + cur+\"').style.backgroundColor='#cccccc';\");
			$timer_id = setTimeout(\"update_flow_bar('$name', \" + next + \")\", $delay);
		}
		 var $timer_id = setTimeout(\"update_flow_bar('$name', 1)\", $delay);

	</script>
";
	echo str_repeat(' ',256);

	progress_bar_flush();
}

function destroy_flow_bar($name)
{
	$timer_id = $name . '_id';
	echo "<script>clearTimeout($timer_id);document.getElementById('{$name}_flow_bar').innerHTML = '';</script>";
	echo str_repeat(' ',256);

	progress_bar_flush();
}

function display_progress_bar($name,$current, $total)
{
	$percent = $current/$total * 100;
	$remain = 100 - $percent;
	$status = floor($percent);
	//scale to a larger size
	$percent *= 2;
	$remain *= 2;
	if($remain == 0){
		$remain = 1;
	}
	if($percent == 0){
		$percent = 1;
	}
	echo "<div id='{$name}_progress_bar' style='width: 50%;'><table class='list view' cellpading=0 cellspacing=0><tr><td id='{$name}_complete_bar' width='{$percent}px' bgcolor='#cccccc' align='center'>$status% </td><td id='{$name}_remain_bar' width={$remain}px' bgcolor='#ffffff'>&nbsp;</td></tr></table></div><br>";
	if($status == 0){
		echo "<script>document.getElementById('{$name}_complete_bar').style.backgroundColor='#ffffff';</script>";
	}
	echo str_repeat(' ',256);

	progress_bar_flush();
}

function update_progress_bar($name,$current, $total)
{
	$percent = $current/$total * 100;
	$remain = 100 - $percent;
	$status = floor($percent);
	//scale to a larger size
	$percent *= 2;
	$remain *= 2;
	if($remain == 0){
		$remain = 1;
	}
	if($status == 100){
		echo "<script>document.getElementById('{$name}_remain_bar').style.backgroundColor='#cccccc';</script>";
	}
	if($status == 0){
		echo "<script>document.getElementById('{$name}_remain_bar').style.backgroundColor='#ffffff';</script>";
		echo "<script>document.getElementById('{$name}_complete_bar').style.backgroundColor='#ffffff';</script>";
	}
	if($status > 0){
		echo "<script>document.getElementById('{$name}_complete_bar').style.backgroundColor='#cccccc';</script>";
	}


	if($percent == 0){
		$percent = 1;
	}

	echo "<script>
		document.getElementById('{$name}_complete_bar').width='{$percent}px';
		document.getElementById('{$name}_complete_bar').innerHTML = '$status%';
		document.getElementById('{$name}_remain_bar').width='{$remain}px';
		</script>";
	progress_bar_flush();
}
