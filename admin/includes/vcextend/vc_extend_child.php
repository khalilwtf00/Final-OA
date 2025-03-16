<?php
/**********************************************************************************************************************************
*
* VC Extend Settings
* 
* Author: Webbu Design
*
* $debug_data = $PFVEXFields_ItemGrid;
* echo str_replace(array('&lt;?php&nbsp;','?&gt;'), '', highlight_string( '<?php ' .     var_export($debug_data, true) . ' ?>', true ) );
***********************************************************************************************************************************/
	// Custom Elements --------------------------------------------------------------------------------------------------
	function PFVC_Add_custompf_fields_child(){
		$setup3_pt14 = PFSAIssetControl('setup3_pt14','','Conditions');
    $PFVEX_GetTaxValues5 = PFVEX_GetTaxValues('pointfinderconditions','setup3_pt14','Conditions');

		/** 
		*Start : Conditions List ---------------------------------------------------------------------------------------------------- 
		**/
			vc_map( array(
				"name" => esc_html__("PF Condition List", 'pointfindert2d'),
				"base" => "pf_salist_widget",
				"icon" => "pfaicon-chat-empty",
				"category" => esc_html__("Point Finder", "pointfindert2d"),
				"description" => esc_html__("Condition List Element", 'pointfindert2d'),
				"params" => array(
						array(
						  "type" => "pf_info_line_vc_field",
						  "heading" => esc_html__("If want to change main category colors please visit Conditions > Category edit. You will find color options.", "pointfindert2d"),
						  "param_name" => "informationfield",
						),
						array(
							"type" => "pf_info_line_field",
							"param_name" => "pf_info_field5",
						 ),
						array(
						  "type" => "dropdown",
						  "heading" => esc_html__("Default Listing Columns", "pointfindert2d"),
						  "param_name" => "cols",
						  "value" => array('4 Columns'=>'4','3 Columns'=>'3','2 Columns'=>'2','1 Column'=>'1'),
						  "edit_field_class" => 'vc_col-sm-4 vc_column'		  
						),
						array(
						  "type" => "dropdown",
						  "heading" => esc_html__("Order By", "pointfindert2d"),
						  "param_name" => "orderby",
						  "value" => array(esc_html__("Title Order", "pointfindert2d")=>'name',esc_html__("ID Order", "pointfindert2d")=>'ID',esc_html__("Count Order", "pointfindert2d")=>'count'),
						  "edit_field_class" => 'vc_col-sm-4 vc_column'
						),
						array(
						  "type" => "dropdown",
						  "heading" => esc_html__("Order", "pointfindert2d"),
						  "param_name" => "order",
						  "value" => array('ASC'=>'ASC','DESC'=>'DESC'),
						  "edit_field_class" => 'vc_col-sm-4 vc_column'
						),
						array(
							"type" => "pf_info_line_field",
							"param_name" => "pf_info_field1",
						 ),
						array(
						  "type" => "pfa_select2",
						  "heading" => esc_html__("Excluding Conditions", "pointfindert2d"),
						  "param_name" => "excludingcats",
						  "value" => $PFVEX_GetTaxValues5,
						  "description"=>esc_html__('These will be hidden. (optional)','pointfindert2d')
						),
						array(
							"type" => "pf_info_line_field",
							"param_name" => "pf_info_field2",
						 ),
						array(
							'type' => 'checkbox',
							'heading' => esc_html__( 'Hide Empty Conditions for Main Conditions', 'pointfindert2d' ),
							'param_name' => 'hideemptyformain',
							'description' => esc_html__( 'If "YES", empty Conditions will be hidden.', 'pointfindert2d' ),
							'value' => array( esc_html__( 'Yes, please', 'pointfindert2d' ) => 'yes' ),
							"edit_field_class" => 'vc_col-sm-6 vc_column'
						),
						array(
							'type' => 'checkbox',
							'heading' => esc_html__( 'Hide Empty Conditions for Sub Conditions', 'pointfindert2d' ),
							'param_name' => 'hideemptyforsub',
							'description' => esc_html__( 'If "YES", empty conditions will be hidden.', 'pointfindert2d' ),
							'value' => array( esc_html__( 'Yes, please', 'pointfindert2d' ) => 'yes' ),
							"edit_field_class" => 'vc_col-sm-6 vc_column'
						),
						array(
							"type" => "pf_info_line_field",
							"param_name" => "pf_info_field3",
						 ),
						array(
							'type' => 'checkbox',
							'heading' => esc_html__( 'Show counts for Main Conditions', 'pointfindert2d' ),
							'param_name' => 'showcountmain',
							'description' => esc_html__( 'If "YES", condition count will be visible.', 'pointfindert2d' ),
							'value' => array( esc_html__( 'Yes, please', 'pointfindert2d' ) => 'yes' ),
							"edit_field_class" => 'vc_col-sm-6 vc_column'
						),
						array(
							'type' => 'checkbox',
							'heading' => esc_html__( 'Show counts for Sub Conditions', 'pointfindert2d' ),
							'param_name' => 'showcountsub',
							'description' => esc_html__( 'If "YES", condition count will be visible.', 'pointfindert2d' ),
							'value' => array( esc_html__( 'Yes, please', 'pointfindert2d' ) => 'yes' ),
							"edit_field_class" => 'vc_col-sm-6 vc_column'
						),
						array(
							"type" => "pf_info_line_field",
							"param_name" => "pf_info_field4",
						 ),
						array(
							"type" => "colorpicker",
							"heading" => esc_html__('Sub Cat. BG Color', 'pointfindert2d'),
							"param_name" => "subcatbgcolor",
							"description" => esc_html__("Leave empty for use default color. (Optional)", "pointfindert2d"),
							"edit_field_class" => 'vc_col-sm-4 vc_column'
						  ),
						array(
							"type" => "colorpicker",
							"heading" => esc_html__('Sub Cat. Text Color', 'pointfindert2d'),
							"param_name" => "subcattextcolor",
							"description" => esc_html__("Leave empty for use default color. (Optional)", "pointfindert2d"),
							"edit_field_class" => 'vc_col-sm-4 vc_column'
						  ),
						array(
							"type" => "colorpicker",
							"heading" => esc_html__('Sub Cat. Text Hover Color', 'pointfindert2d'),
							"param_name" => "subcattextcolor2",
							"description" => esc_html__("Leave empty for use default color. (Optional)", "pointfindert2d"),
							"edit_field_class" => 'vc_col-sm-4 vc_column'
						  ),
						array(
							"type" => "pf_info_line_field",
							"param_name" => "pf_info_field6",
						 ),
						
						array(
						  "type" => "dropdown",
						  "heading" => esc_html__("Sub Condition Limit", "pointfindert2d"),
						  "param_name" => "subcatlimit",
						  "description"=>esc_html__('How many sub categories will be visible.','pointfindert2d'),
						  "value" => array('0'=>'0','1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5','6'=>'6','7'=>'7','8'=>'8','9'=>'9','10'=>'10','11'=>'11','12'=>'12','13'=>'13','14'=>'14','15'=>'15','16'=>'16','17'=>'17','18'=>'18','19'=>'19','20'=>'20','25'=>'25','30'=>'30','40'=>'40','50'=>'50'),
						  "edit_field_class" => 'vc_col-sm-4 vc_column'		  
						),
						array(
							"type" => "checkbox",
							"heading" => esc_html__('View All Link', 'pointfindert2d'),
							"param_name" => "viewalllink",
							"description" => esc_html__("Do you want to see View All link?", "pointfindert2d"),
							"edit_field_class" => 'vc_col-sm-4 vc_column',
							'value' => array( esc_html__( 'Yes, please', 'pointfindert2d' ) => 'yes' )
						  ),
						array(
							"type" => "checkbox",
							"heading" => esc_html__("Title Uppercase", 'pointfindert2d'),
							"param_name" => "titleuppercase",
							"description" => esc_html__("Do you want to see uppercase titles?", "pointfindert2d"),
							"edit_field_class" => 'vc_col-sm-4 vc_column',
							'value' => array( esc_html__( 'Yes, please', 'pointfindert2d' ) => 'yes' )
						  ),
					)
				)
			);
		/** 
		*End : Condition List ---------------------------------------------------------------------------------------------------- 
		**/
    /** 
		*Start : Agent Type List ---------------------------------------------------------------------------------------------------- 
		**/
			vc_map( array(
				"name" => esc_html__("FP Agent Type List", 'pointfindert2d'),
				"base" => "fp_agenttypelist_widget",
				"icon" => "pfaicon-chat-empty",
				"category" => esc_html__("Point Finder", "pointfindert2d"),
				"description" => esc_html__("Agent Type List Element", 'pointfindert2d'),
				"params" => array(
						array(
						  "type" => "pf_info_line_vc_field",
						  "heading" => esc_html__("If want to change main category colors please visit Conditions > Category edit. You will find color options.", "pointfindert2d"),
						  "param_name" => "informationfield",
						),
						array(
							"type" => "pf_info_line_field",
							"param_name" => "pf_info_field5",
						 ),
						array(
						  "type" => "dropdown",
						  "heading" => esc_html__("Default Listing Columns", "pointfindert2d"),
						  "param_name" => "cols",
						  "value" => array('4 Columns'=>'4','3 Columns'=>'3','2 Columns'=>'2','1 Column'=>'1'),
						  "edit_field_class" => 'vc_col-sm-4 vc_column'		  
						),
						array(
						  "type" => "dropdown",
						  "heading" => esc_html__("Order By", "pointfindert2d"),
						  "param_name" => "orderby",
						  "value" => array(esc_html__("Title Order", "pointfindert2d")=>'name',esc_html__("ID Order", "pointfindert2d")=>'ID',esc_html__("Count Order", "pointfindert2d")=>'count'),
						  "edit_field_class" => 'vc_col-sm-4 vc_column'
						),
						array(
						  "type" => "dropdown",
						  "heading" => esc_html__("Order", "pointfindert2d"),
						  "param_name" => "order",
						  "value" => array('ASC'=>'ASC','DESC'=>'DESC'),
						  "edit_field_class" => 'vc_col-sm-4 vc_column'
						),
						array(
							"type" => "pf_info_line_field",
							"param_name" => "pf_info_field1",
						 ),
						array(
						  "type" => "pfa_select2",
						  "heading" => esc_html__("Excluding Agent Types", "pointfindert2d"),
						  "param_name" => "excludingcats",
						  "value" => $PFVEX_GetTaxValues5,
						  "description"=>esc_html__('These will be hidden. (optional)','pointfindert2d')
						),
						array(
							"type" => "pf_info_line_field",
							"param_name" => "pf_info_field2",
						 ),
						array(
							'type' => 'checkbox',
							'heading' => esc_html__( 'Hide Empty Agent Types for Main Agent Types', 'pointfindert2d' ),
							'param_name' => 'hideemptyformain',
							'description' => esc_html__( 'If "YES", empty Agent Types will be hidden.', 'pointfindert2d' ),
							'value' => array( esc_html__( 'Yes, please', 'pointfindert2d' ) => 'yes' ),
							"edit_field_class" => 'vc_col-sm-6 vc_column'
						),
						array(
							'type' => 'checkbox',
							'heading' => esc_html__( 'Hide Empty Agent Types for Sub Agent Types', 'pointfindert2d' ),
							'param_name' => 'hideemptyforsub',
							'description' => esc_html__( 'If "YES", empty conditions will be hidden.', 'pointfindert2d' ),
							'value' => array( esc_html__( 'Yes, please', 'pointfindert2d' ) => 'yes' ),
							"edit_field_class" => 'vc_col-sm-6 vc_column'
						),
						array(
							"type" => "pf_info_line_field",
							"param_name" => "pf_info_field3",
						 ),
						array(
							'type' => 'checkbox',
							'heading' => esc_html__( 'Show counts for Main Agent Types', 'pointfindert2d' ),
							'param_name' => 'showcountmain',
							'description' => esc_html__( 'If "YES", condition count will be visible.', 'pointfindert2d' ),
							'value' => array( esc_html__( 'Yes, please', 'pointfindert2d' ) => 'yes' ),
							"edit_field_class" => 'vc_col-sm-6 vc_column'
						),
						array(
							'type' => 'checkbox',
							'heading' => esc_html__( 'Show counts for Sub Agent Types', 'pointfindert2d' ),
							'param_name' => 'showcountsub',
							'description' => esc_html__( 'If "YES", condition count will be visible.', 'pointfindert2d' ),
							'value' => array( esc_html__( 'Yes, please', 'pointfindert2d' ) => 'yes' ),
							"edit_field_class" => 'vc_col-sm-6 vc_column'
						),
						array(
							"type" => "pf_info_line_field",
							"param_name" => "pf_info_field4",
						 ),
						array(
							"type" => "colorpicker",
							"heading" => esc_html__('Sub Cat. BG Color', 'pointfindert2d'),
							"param_name" => "subcatbgcolor",
							"description" => esc_html__("Leave empty for use default color. (Optional)", "pointfindert2d"),
							"edit_field_class" => 'vc_col-sm-4 vc_column'
						  ),
						array(
							"type" => "colorpicker",
							"heading" => esc_html__('Sub Cat. Text Color', 'pointfindert2d'),
							"param_name" => "subcattextcolor",
							"description" => esc_html__("Leave empty for use default color. (Optional)", "pointfindert2d"),
							"edit_field_class" => 'vc_col-sm-4 vc_column'
						  ),
						array(
							"type" => "colorpicker",
							"heading" => esc_html__('Sub Cat. Text Hover Color', 'pointfindert2d'),
							"param_name" => "subcattextcolor2",
							"description" => esc_html__("Leave empty for use default color. (Optional)", "pointfindert2d"),
							"edit_field_class" => 'vc_col-sm-4 vc_column'
						  ),
						array(
							"type" => "pf_info_line_field",
							"param_name" => "pf_info_field6",
						 ),
						
						array(
						  "type" => "dropdown",
						  "heading" => esc_html__("Sub Condition Limit", "pointfindert2d"),
						  "param_name" => "subcatlimit",
						  "description"=>esc_html__('How many sub categories will be visible.','pointfindert2d'),
						  "value" => array('0'=>'0','1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5','6'=>'6','7'=>'7','8'=>'8','9'=>'9','10'=>'10','11'=>'11','12'=>'12','13'=>'13','14'=>'14','15'=>'15','16'=>'16','17'=>'17','18'=>'18','19'=>'19','20'=>'20','25'=>'25','30'=>'30','40'=>'40','50'=>'50'),
						  "edit_field_class" => 'vc_col-sm-4 vc_column'		  
						),
						array(
							"type" => "checkbox",
							"heading" => esc_html__('View All Link', 'pointfindert2d'),
							"param_name" => "viewalllink",
							"description" => esc_html__("Do you want to see View All link?", "pointfindert2d"),
							"edit_field_class" => 'vc_col-sm-4 vc_column',
							'value' => array( esc_html__( 'Yes, please', 'pointfindert2d' ) => 'yes' )
						  ),
						array(
							"type" => "checkbox",
							"heading" => esc_html__("Title Uppercase", 'pointfindert2d'),
							"param_name" => "titleuppercase",
							"description" => esc_html__("Do you want to see uppercase titles?", "pointfindert2d"),
							"edit_field_class" => 'vc_col-sm-4 vc_column',
							'value' => array( esc_html__( 'Yes, please', 'pointfindert2d' ) => 'yes' )
						  ),
					)
				)
			);
		/** 
		*End : Agent Type List ---------------------------------------------------------------------------------------------------- 
		**/
	}
	add_action('admin_init','PFVC_Add_custompf_fields_child');