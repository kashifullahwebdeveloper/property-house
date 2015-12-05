<?php 

class javo_post_meta_box{
	
	public function __construct() {
		
		add_action( 'add_meta_boxes', array( $this, 'javo_post_meta_box_init') );
		add_action( 'save_post', Array( $this, 'javo_post_meta_box_save' ) );
		
		
	}
	
	public function javo_post_meta_box_init() {
		
		add_meta_box( "javo_property_options", "Property meta", array($this, "javo_property_option_box"), "property" );
		
		
	}
	
	public function javo_pt_add($meta_key, $post_id=NULL){
		if($post_id == NULL) return;
		return sprintf( "<input name='javo_pt[%s]' value='%s'>", $meta_key, get_post_meta( $post_id, $meta_key, true ) );
	}
	
	public function javo_property_option_box( $post ) {
		$javo_theme_option = @unserialize(get_option("javo_themes_settings"));
	?>	
		<table class="form-table">
			<tr>
				<th><?php _e('Property ID', 'property-house');?></th>
				<td><?php echo $this->javo_pt_add("property_id", $post->ID);?></td>
			</tr>
			<tr>
				<th><?php _e('Bedrooms', 'property-house');?></th>
				<td><?php echo $this->javo_pt_add("bedrooms", $post->ID);?></td>
			</tr>
			<tr>
				<th><?php _e('Bathrooms', 'property-house');?></th>
				<td><?php echo $this->javo_pt_add("bathrooms", $post->ID);?></td>
			</tr>
		</table>
	<?php	
	}
	
	public function javo_post_meta_box_save($post_id) {
		
		// In case of auto save
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
			return $post_id;
		
		$javo_query = new javo_array($_POST);
		
		switch (get_post_type($post_id) ) {
			
			case 'property': 
				if(isset($_POST['javo_pt'])){
						
						$ppt_meta = $_POST['javo_pt'];
						$javo_pt_query = new javo_array($ppt_meta);
						
						update_post_meta($post_id, 'property_id', $javo_pt_query->get('property_id'));
						update_post_meta($post_id, 'bedrooms', $javo_pt_query->get('bedrooms'));
						update_post_meta($post_id, 'bathrooms', $javo_pt_query->get('bathrooms'));
					
				}			
			break; 
			
		}
		
		
		
		
	}
	
}

new javo_post_meta_box();

?>