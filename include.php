<?php
/* 
*	Front End Edit Snippet
*
*	@version	2.7.1
*	@date		2008-09-18
*	@author		Dietrich Roland Pehlke - and others: read the "info.php" for details!
*	@state		RC1
*	@license	GNU - GPL
*
*	@notice		Call this snippet with: 
*
*				frontend_edit ();
*
*
*/

if (!function_exists('frontend_edit')) {
	function frontend_edit() {
		global $wb, $page_id, $HEADING, $database, $admin;
		
		if (FRONTEND_LOGIN == 'enabled' AND is_numeric($wb->get_session('USER_ID'))) {
			/**
			*	Get permissons
			*/
			if ($page_id) 
				$this_page = $page_id;
			else
				$this_page = $wb->default_page_id;
			
			$results = $database->query("SELECT * FROM ".TABLE_PREFIX."pages WHERE page_id = '$this_page'");
			$results_array = $results->fetchRow();
			$old_admin_groups = explode(',', $results_array['admin_groups']);
			$old_admin_users = explode(',', $results_array['admin_users']);
			$this_user = $wb->get_session('GROUP_ID');
	
			$query = "SELECT * FROM ".TABLE_PREFIX."pages WHERE page_id = '".$page_id."'";
			$get_pages = $database->query($query);
			
			$page = $get_pages->fetchRow();
			$admin_groups = explode(',', str_replace('_', '', $page['admin_groups']));
			$admin_users = explode(',', str_replace('_', '', $page['admin_users']));
			$in_group = FALSE;
			
			foreach($admin->get_groups_id() as $cur_gid)
				if (in_array($cur_gid, $admin_groups)) $in_group = TRUE;
			
			if (($in_group) OR is_numeric(array_search($this_user, $old_admin_groups)) ) {
				$str  = '<a href="' . ADMIN_URL . '/pages/modify.php?page_id='.$this_page;
				$str .= '" target="_blank"><img align="left" border="0" src="';
				$str .= (true === defined('THEME_URL') ? THEME_URL : ADMIN_URL) . '/images/modify_16.png" alt="' . $HEADING['MODIFY_PAGE'] . '" />&nbsp;Edit Page</a>';
				
				echo $str;
				
			}     
		}
	}
}
?>
