<?php
/*
Plugin Name: Reseptit
Description: Add post types for custom articles
Author: Jenni 
*/
// Hook <strong>lc_custom_post_custom_article()</strong> to the init action hook

/*************Jennin custom post************/
add_action( 'init', 'custom_post_recipe' );

function custom_post_recipe() {
$labels = array(
'name'               => __( 'Reseptit' ),
'singular_name'      => __( 'Resepti' ),
'add_new'            => __( 'Lisää uusi resepti' ),
'add_new_item'       => __( 'Lisää uusi resepti' ),
'edit_item'          => __( 'Muokkaa reseptiä' ),
'new_item'           => __( 'Uusi resepti' ),
'all_items'          => __( 'Kaikki reseptit' ),
'view_item'          => __( 'Katsele reseptiä' ),
'search_items'       => __( 'Etsi reseptejä' ),
'featured_image'     => 'Kuva',
'set_featured_image' => 'Lisää kuva'
);

$args = array(
'labels'                => $labels,
'description'           => 'Täältä löydät kaikki sivustollamme olevat reseptit.',
'public'                => true,
'menu_position'         => 5,
'supports'              => array( 'title', 'thumbnail', 'comments' ),
'taxonomies'            => array( 'category', 'post_tag' ),
'has_archive'           => true,
'show_in_admin_bar'     => true,
'show_in_nav_menus'     => true,
'query_var'             => true,
'exclude_from_search'   => false,
);

register_post_type( 'resepti', $args);
}


/*******Jennin ainesosa metabox *******
 * katsottu mallia:
 * https://www.smashingmagazine.com/2011/10/create-custom-post-meta-boxes-wordpress/
 * //https://www.pradipdebnath.com/2016/10/29/dynamically-addremove-input-fields-in-wordpress-metabox-using-jquery/
*/
/* Fire our meta box setup function on the post editor screen. */
add_action( 'load-post.php', 'ainesosa_meta_boxes_setup' );
add_action( 'load-post-new.php', 'ainesosa_meta_boxes_setup' );

function ainesosa_meta_boxes_setup() {
    add_action( 'add_meta_boxes', 'add_ainesosa_meta_boxes', 1 );
    add_action( 'save_post', 'save_aineosa_class_meta', 10, 2 );
  }

function add_ainesosa_meta_boxes() {

    add_meta_box(
      'resepti-ainesosa-meta-box',      // Unique ID
      esc_html__( 'Ainekset', 'example' ),    // Title
      'display_ainesosa_meta_box',   // Callback function
      'resepti',         // Admin page (or post type)
      'normal',         // Context
      'high'         // Priority
    );
  }

  // Näytä meta box
function display_ainesosa_meta_box( $post ) { 

  $resepti_maara =   get_post_meta($post->ID, 'resepti-maara', true);
  $resepti_mitta =   get_post_meta($post->ID, 'resepti-mitta', true);
  $resepti_aines =   get_post_meta($post->ID, 'resepti-aines', true);
    wp_nonce_field( basename( __FILE__ ), 'ainesosa_nonce' ); ?>
      <div class="resepti-ainesosa">
      <button class="resepti-lisaa button">Lisää</button>
      <div class="resepti-input-wrap rwmb-meta-box">
      <label class="ainekset-label">Määrä</label>
      <label class="ainekset-label">Mitta</label>
      <label  class="ainekset-label">Aines</label>
      <label></label>
      </div>
      <?php
      $mitta_options = array('mm','tl','rkl','dl','l','g','kg','kpl');
      $output = '';
      if((isset($resepti_maara) && is_array($resepti_maara)) || (isset($resepti_mitta) && is_array($resepti_mitta)) || (isset($resepti_aines) && is_array($resepti_aines))) {
        echo "<script>console.log($resepti_aines)</script>";
        echo "<script>console.log($resepti_maara)</script>";
          for($i=0; $i < count($resepti_aines); $i++) {
            $count = count($resepti_aines);
            echo "<script>console.log($count)</script>";
            echo "<script>console.log($i)</script>";
            $output = '<div class="resepti-input-wrap">
            <input type="number" name="resepti-maara[]" value="' . $resepti_maara[$i] . '"/>
            <select name="resepti-mitta[]">'; 
            $selected_mitta = $resepti_mitta[$i];
            for ($ii=0; $ii < count($mitta_options); $ii++) { 
              if ($mitta_options[$ii] == $selected_mitta) {
                $output .= '<option value="' . $mitta_options[$ii] . '" selected>' . $mitta_options[$ii] . '</option>';
              }
              else {
              $output .= '<option value="' . $mitta_options[$ii] . '">' . $mitta_options[$ii] . '</option>';
              }
            }
            $output .= '</select>
            <input type="text" name="resepti-aines[]" value="' . $resepti_aines[$i] . '"/>
            <a href="#" class="resepti-poista">Poista</a></div>';
            
            echo $output;
        }
    } else {
      echo "<script>console.log('ei aineksia')</script>";
      $output = '<div class="resepti-input-wrap">
      <input type="number" name="resepti-maara[]"/><select name="resepti-mitta[]">';
      for ($ii=0; $ii < count($mitta_options); $ii++) {
        $output .= '<option value="' . $mitta_options[$ii] . '">' . $mitta_options[$ii] . '</option>';
      }
      $output .= '</select>
      <input type="text" name="resepti-aines[]"/>
      <a href="#" class="resepti-poista">Poista</a></div>';
      echo $output;
    }
    ?>
    </div>
  <?php }
//tallennus
function save_aineosa_class_meta( $post_id, $post ) {

    if ( !isset( $_POST['ainesosa_nonce'] ) || !wp_verify_nonce( $_POST['ainesosa_nonce'], basename( __FILE__ ) ) )
      return $post_id;
  
    $post_type = get_post_type_object( $post->post_type );
 
    if ( !current_user_can( $post_type->cap->edit_post, $post_id ) )
      return $post_id;

      
    if(isset($_POST['resepti-maara'])) {
      update_post_meta( $post_id, 'resepti-maara', $_POST['resepti-maara'] );
    }

    if(isset($_POST['resepti-mitta'])) {
      update_post_meta( $post_id, 'resepti-mitta', $_POST['resepti-mitta'] );
    }

    if(isset($_POST['resepti-aines'])) {
      update_post_meta( $post_id, 'resepti-aines', $_POST['resepti-aines'] );
    }
    
  }