<?php
  $MM_db1_HOSTNAME = "205.178.146.25";
  $MM_db1_DATABASE = "mysql:antiques_atf";
  $MM_db1_DBTYPE   = preg_replace("/:.*$/", "", $MM_db1_DATABASE);
  $MM_db1_DATABASE = preg_replace("/^.*?:/", "", $MM_db1_DATABASE);
  $MM_db1_USERNAME = "antiques_atf";
  $MM_db1_PASSWORD = "future";
  $MM_db1_LOCALE = "Us";
  $MM_db1_MSGLOCALE = "En";
  $MM_db1_CTYPE = "";
  $KT_locale = $MM_db1_MSGLOCALE;
  $KT_dlocale = $MM_db1_LOCALE;
  $KT_serverFormat = "%Y-%m-%d %H:%M:%S";
  $QUB_Caching = "false";



$link = mysql_connect($MM_db1_HOSTNAME, $MM_db1_USERNAME, $MM_db1_PASSWORD);
if (!$link) {
    die('Could not connect: ' . mysql_error());
}

$selected = mysql_select_db("antiques_atf",$link) 
  or die("Could not select examples");
echo 'Connected successfully';
echo "<br>";
echo "<br>";

function grabDesigners(){
  $postContent='';
  $postTitle='';
  $postTags='';

  $result = mysql_query("SELECT * FROM designers");
  //fetch tha data from the database
  $counter=0;

  while ($row = mysql_fetch_assoc ($result)) {
    // print_r($row);
    $postContent='';
    $postTitle='';
    $postTags='';
    $imgSrc = '';
    $imgName = '';
    $postType = 'Designer';
    $cf = array();

    foreach ($row as $key => $value){
      

      if( $key != 'D_ID' && $key != "addedDT"){
      
        if($key == "tb_designer"){
          $postTitle = $value;
        }
        else if($key == "blurb"){
          $postContent = $value;
        }
        else if($key == 'portrait' && $value != ""){
          $imgSrc = '/mdl/wp-content/uploads/2014/06/pics/'.$value.'.jpg';
          $imgName = $value;
          // echo "<img src='".$imgSrc."'>";
        }
        else if($value != NULL){
          $cfEl = array();
          $cfEl[$key] = $value;
          $cf[] = $cfEl;
        }

        if($key == "nationality" || $key == 'occupation'){
          $postTags = $postTags. ", " . $value;
        }
      }

    }


      // if($counter < 2){
        echo $counter;
        $postId = createPost($postTitle, $postContent, $postType, $postTags);
        echo $postId;
        addImage($imgSrc, $postId, $imgName);
        foreach($cf as $cfEl){
          $cfElPair = each($cfEl);
          add_post_meta($postId, $cfElPair['key'], $cfElPair['value']);
          echo $cfElPair['key'] . "";
          echo $cfElPair['value'] . "";
        }
      // }
      $counter++; 
          echo "<br>";
      echo "<br>";


  }
  
}



function grabManufacturers(){
  $postContent='';
  $postTitle='';
  $postTags='';

  $result = mysql_query("SELECT * FROM manufacturers");
  //fetch tha data from the database
  $counter=0;

  while ($row = mysql_fetch_assoc ($result)) {
    // print_r($row);
    $postContent='';
    $postTitle='';
    $postTags='';
    $imgSrc = '';
    $imgName = '';
    $postType = 'Manufacturer';
    $cf = array();

    foreach ($row as $key => $value){
      

      if( $key != 'M_ID' && $key != "addedDT"){
      
        if($key == "Manufacturer"){
          $postTitle = $value;
        }
        else if($key == "about"){
          $postContent = $value;
        }
        else if($key == 'logo' && $value != ""){
          $imgSrc = '/mdl/wp-content/uploads/2014/06/pics/'.$value.'.jpg';
          $imgName = $value;
          // echo "<img src='".$imgSrc."'>";
        }
        else if($value != NULL){
          $cfEl = array();
          $cfEl[$key] = $value;
          $cf[] = $cfEl;
        }

        if($key == "title" || $key == 'City' || $key=="country"){
          $postTags = $postTags. ", " . $value;
        }
      }

    }
      // if($counter < 2){
        echo $counter;
        $postId = createPost($postTitle, $postContent, $postType, $postTags);
        echo $postId;
        addImage($imgSrc, $postId, $imgName);
        foreach($cf as $cfEl){
          $cfElPair = each($cfEl);
          add_post_meta($postId, $cfElPair['key'], $cfElPair['value']);
          echo $cfElPair['key'] . "";
          echo $cfElPair['value'] . "";
        }
      // }
      $counter++; 
          echo "<br>";
      echo "<br>";
  }
}



function grabObjects(){
  $postContent='';
  $postTitle='';
  $postTags='';

  $result = mysql_query("SELECT * FROM atf");
  //fetch tha data from the database
  $counter=0;

  while ($row = mysql_fetch_assoc ($result)) {
    // print_r($row);
    $postContent='';
    $postTitle='';
    $postTags='';
    $imgSrc = '';
    $imgName = '';
    $postType = 'Objects';
    $cf = array();
    $manufacturerId="";
    $designerId="";

    foreach ($row as $key => $value){
      

      if( $key != 'ATF_ID' && $key != "addedDT" && $key != "smallPhoto"){
      
        if($key == "ProductName"){
          $postTitle = $value;
        }
        else if($key == "Description"){
          $postContent = $value;
        }
        else if($key == 'largePhoto' && $value != ""){
          $imgSrc = '/mdl/wp-content/uploads/2014/06/pics/'.$value.'.jpg';
          $imgName = $value;
          // echo "<img src='".$imgSrc."'>";
        }
        else if($value != NULL){
          $cfEl = array();
          $cfEl[$key] = $value;
          $cf[] = $cfEl;
        }

        if($key == "Manufacturer"){
          $the_query = new WP_Query( "name=".urlencode(trim($value))."&post_type=Manufacturer" );
          if ( $the_query->have_posts() ) {
              while ( $the_query->have_posts() ) {
                $the_query->the_post();
                $manufacturerId= get_the_ID();
                // echo  '<br>' . $manufacturerId . '<br>';

              }
            }
          else{
            echo  $postTitle." is missing manufacturer <br>";
            // echo '|'.$value.'|';
            // echo urlencode(trim($value));
          }
        }
        if($key == "Designer"){
          $the_query = new WP_Query( "name=".urlencode(trim($value))."&post_type=Designer" );
          if ( $the_query->have_posts() ) {
              while ( $the_query->have_posts() ) {
                $the_query->the_post();
                $designerId= get_the_ID();
                // echo  $designerId . '<br>';
              }
            }
          else{
            echo $postTitle." is missing designer<br>";
            // echo '|'.$value.'|';
            // echo urlencode(trim($value));
          }
        }


        if($key == "productType" || $key == 'Designer' || $key=="Manufacturer"){
          $postTags = $postTags. ", " . $value;
        }
      }

    }
      // if($counter < 2){
        echo $postContent;
        // echo $counter;
        $postId = createPost($postTitle, $postContent, $postType, $postTags);
        echo $postId;
        addImage($imgSrc, $postId, $imgName);
        // echo $imgSrc;
        // echo $imgName;

        foreach($cf as $cfEl){
          $cfElPair = each($cfEl);
          add_post_meta($postId, $cfElPair['key'], $cfElPair['value']);
          echo $cfElPair['key'] . "";
          echo $cfElPair['value'] . "";
        }
        add_post_meta($postId, 'designer_id', $designerId);
        add_post_meta($postId, 'manufacturer_id', $manufacturerId);
      // }
      $counter++; 
      echo "<br>";
      echo "<br>";
  }
}





function addImage($imgSrc, $postId, $name){

  // $filename should be the path to a file in the upload directory.
  // $filename = $imgSrc;

  // The ID of the post this attachment is for.
  $parent_post_id = $postId;

  $imgSrc =  '/Applications/MAMP/htdocs' . $imgSrc;
  $destination = '/Applications/MAMP/htdocs/mdl/wp-content/uploads/2014/06/' . basename( $imgSrc );


  $wp_upload_dir = wp_upload_dir();
  $filename = $wp_upload_dir['url'] . '/' . basename( $imgSrc );

  if (copy( $imgSrc, $destination )) {
    echo "Moved $imgSrc to ".$destination;

    // Check the type of tile. We'll use this as the 'post_mime_type'.
    $filetype = wp_check_filetype( basename( $filename ), null );

    // Get the path to the upload directory.
    $wp_upload_dir = wp_upload_dir();

    echo $wp_upload_dir['url'] . '/' . basename( $filename );
    // Prepare an array of post data for the attachment.
    $attachment = array(
      'guid'           => $wp_upload_dir['url'] . '/' . basename( $filename ), 
      'post_mime_type' => $filetype['type'],
      'post_title'     => preg_replace( '/\.[^.]+$/', '', basename( $filename ) ),
      'post_content'   => '',
      'post_status'    => 'inherit'
    );

    // Insert the attachment.
    $attach_id = wp_insert_attachment( $attachment, $destination, $parent_post_id );

    // Make sure that this file is included, as wp_generate_attachment_metadata() depends on it.
    require_once( ABSPATH . 'wp-admin/includes/image.php' );

    // Generate the metadata for the attachment, and update the database record.
    $attach_data = wp_generate_attachment_metadata( $attach_id, $destination );
    wp_update_attachment_metadata( $attach_id, $attach_data );
    set_post_thumbnail($postId ,$attach_id);
  }
}

function createPost($postTitle, $postContent, $postType,$postTags){
  $post = array(
    'post_content'   => $postContent,
    'post_title'     => $postTitle,
    'post_status'    => 'publish' ,
    'post_type'      => $postType,
    'tags_input'      => $postTags
  );
  $postId =  wp_insert_post( $post, true );
  return $postId;

}




// function grabAntiques(){
//   $result = mysql_query("SELECT * FROM atf");
//   //fetch tha data from the database
//   while ($row = mysql_fetch_assoc ($result)) {
//     // print_r($row);
//     foreach ($row as $key => $value){
//       if( $key != 'ATF_ID' && $key != "addedDT"){
//         echo $key. " ";
//         echo $value. " ";
//       }
//     }
//     echo "<br>";
//     echo "<br>";
//   }
// }

// grabDesigners();
// grabManufacturers();
// grabObjects();


mysql_close($link);

?>