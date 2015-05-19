<div class="wrap">
<div id="icon-edit" class="icon32"></div>
<h2>Lists</h2>
<form method="get" action="<?php echo remove_query_arg(array('s'))?>">
<?php
		
		require_once MYMAIL_DIR . 'classes/lists.table.class.php';
		$table = new MyMail_Lists_Table();
		
		$table->prepare_items(); 
		$table->search_box( __('Search', 'mymail'), 'sa' );
		$table->display();
		
?>
</form>
</div>
<?php ?>