<head>
    <title>IMPORTER BY SMOKE</title>
</head>
<h1>XVideos Importer By Smoke</h1>
<h2>Busca y guarda en categoría</h2>
<br>
<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');
$path=$_SERVER["DOCUMENT_ROOT"];
#require('wp-blog-header.php');
require_once($path.'/wp-load.php');
require_once('simple_html_dom.php');
$con = "variable.txt";
$archivo = fopen($con, "r");

while(!feof($archivo)){ 
    $control = fgets($archivo);
}
$numero = (int)$control;
$categorias  = array('Aceite', 'Amateur', 'American', 'Amiga', 'Anal', 'Argentina', 'Asian', 'Asmr', 'Ass', 'Athletic', 'Babe', 'Babysister', 'Bath', 'Bathroom', 'BBC', 'BBW', 'Beatiful', 'Beauty', 'Big Ass', 'Big Tits', 'Bikini', 'Blonde', 'BlowJob', 'Blue Hair', 'Boobs', 'Brazzers', 'British', 'Brunette', 'Bukake', 'Cartoon', 'Casadas', 'Casero', 'Casting', 'Chaturbate', 'Cheating', 'Chica', 'Christmas', 'Class', 'Colegiala', 'College', 'Colombiana', 'Cosplay', 'Couch', 'Creampie', 'Culioneros', 'Culona', 'Cum', 'Cumlouder', 'Cumshot', 'Cute', 'Dildo', 'Doctor', 'Doll', 'DP', 'Ebony', 'Embarazada', 'Escuela', 'European', 'Extra Small', 'Fake tits', 'Famous', 'Feet', 'Fetish', 'First Time', 'Gangbang', 'Glasses', 'Gym', 'HandJob', 'Hentai', 'Honey', 'Hot', 'Hotel', 'Huge', 'Innie Pussy', 'Interracial', 'Japanese', 'Jeans', 'Jewelz Blu', 'Joven', 'Juguetes', 'Kitchen', 'Latina', 'Leggins', 'Lenceria', 'Lesbian', 'Madura', 'Maid', 'Masajes', 'Massage', 'Masturbation', 'Mature', 'Mexican', 'MILF', 'Morena', 'Natural', 'Natural Tits', 'Novia', 'Nurse', 'Office', 'Oral', 'Orgasmo', 'Orgy', 'Outdoor', 'Outdoors', 'Pareja', 'Party', 'Peliroja', 'Perfect', 'Petite', 'Piercing', 'Police', 'Pornstar', 'Pov', 'Pregnant', 'Prepago', 'Primera Vez', 'Professional', 'Public', 'Pussy', 'Reality', 'Red Hair', 'Rough', 'Rubias', 'SexMex', 'Sexo', 'Shaved', 'Shorts', 'Shy', 'Skinny', 'Skirt', 'Small', 'Sneaky', 'Solo', 'Spanish', 'Sports', 'Squirt', 'Tattoo', 'Teacher', 'Teen', 'Tetona', 'Tight', 'Tiny', 'Tiny Pussy', 'Tits', 'Toys', 'Trimmed', 'Trio', 'Uniform', 'Venezolana', 'Vintage', 'Voyeur', 'Vr', 'Webcam', 'Wet', 'White', 'Wife', 'Yoga', 'Young');

$tube = 'xvideos';
$tubeLink = 'https://www.xvideos.com';
$pagina = rand(1,148);
$fin =$pagina+2;
$indice=$numero;
echo $indice;
$key = $categorias[$indice];
$key=str_replace(" ", "+", $key);
$indice=$indice+2;

echo "Página de inicio: ".$pagina."<br>";
echo "Categoria: ".$key;

//Definimos la categoria
for($j=$pagina; $j<$fin; $j++){

    $u=rand(1,6);
    //Se elige la página teniendo ya la categoria
    switch ($u) {
        case '1':
        $url=$tubeLink."/?k=".$key."&sort=uploaddate&p=".$j;
        break;
        case '2':
        $url=$tubeLink."/?k=".$key."&sort=relevance&p=".$j;
        break;
        case '3':
         $url=$tubeLink."/tags/s:uploaddate/".$key."/".$j;
        break;
        case '4':
        $url=$tubeLink."/tags/".$key."/".$j;
        break;
        case '5':
        $url=$tubeLink."/tags/s:rating/".$key."/".$j;
        break;            
        case '6':
        $url=$tubeLink."/?k=".$key."&sort=rating&p=".$j;
        break;
    }  
    echo "<br><br>".$url."<br><br>";

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 6.1; rv:2.2) Gecko/20110201');
    $xvdr = curl_exec($curl);
    curl_close($curl);

    $temporal = explode('<div id="video_', $xvdr); 
    $cantidad_videos=sizeof($temporal);$cantidad_videos-=1;
    for ($k=1; $k <= $cantidad_videos; $k++) { 
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 6.1; rv:2.2) Gecko/20110201');
        $xvdr = curl_exec($curl);
        curl_close($curl);
        
        //Saco id,duracion,titulo,imagen, link y contenido
        $temporal = explode('<div id="video_', $xvdr);
        $video_actual = $temporal[$k];
        $dur = explode('class="duration">', $video_actual);$dur = $dur[1];$duracion = explode('<', $dur);$duracion = $duracion[0];
        $title = explode('title="', $video_actual);$title = $title[1];$titulo = explode('"', $title);$titulo = $titulo[0];
        $id = explode('data-id"', $video_actual);$id = $id[0];$id=explode('"', $id);$id=$id[0];
        $th = explode('data-src="', $video_actual);$th = $th[1];$th = explode('"', $th);$imagen = $th[0];$imagen = str_replace("THUMBNUM", "1", $imagen);  
        $link_video=explode('class="thumb"><a href="',$video_actual);$link_video=explode('"',$link_video[1]);$link_video=$tubeLink.$link_video[0];$link_video = str_replace("/THUMBNUM","",$link_video);
        $link_comentarios = $tubeLink."/threads/video-comments/get-posts/top/".$id."/0/1";
        $contenido = "<center><iframe src='https://www.xvideos.com/embedframe/".$id."' frameborder='0' width='510' height='400' scrolling='no' allowfullscreen='allowfullscreen'></iframe></center>";
        $palabras= array('rape', 'incest', 'bestiality','zoo', 'zoophilia', 'lolita', 'animal', 'bdsm', 'pedophilia', 'pedo', 'violence', 'abuse', 'torture', 'blood', 'scatophilia', 'urination', 'pee', 'forced', 'brutal', 'aggressive', 'prima', 'mama', 'mom', 'mother', 'sister', 'stepmom', 'stepmother', 'Stepdaughter', 'daughter', 'stepdad', 'stepsister', 'stepbro', 'dad', 'pissing','step', 'brother','aunt','uncle', ' tia','primo', 'cousin','hij', 'abuel','herman','bondage','hard', ' tio', 'drug', 'viola','hog', 'atad','tied','castig','slave','xtreme','esclav','piss','sleep','banged','child','dog', 'cat ','cats ','animal','scat','sobrina');
        
        //Defino los actores
        $act=file_get_html($link_video);
        $actores = array();
        $actores_names=array();
        $name=explode('name"><span class="name">',$act);$name=explode('<span',$name[2]);
        $actores_names[]=$name[0];

        //-Defino los tags
        $tg = file_get_html($link_video);
        $modal = array();
        $tag = array();
        foreach($tg->find('a[href^="/tags/"]') as $a) {
            $temp = explode('tags/', $a->href);
            $tag[]=ucwords(str_replace("-"," ",$temp[1]));
            for($i=0; $i<sizeof($palabras); $i++){
                $con = stripos($temp[1], $palabras[$i]);     
                if($con===false){
                }else{
                    $modal[] = ucwords(str_replace("-"," ",$temp[1]));
                }
            }
        }


        $tags=array_diff($tag,$modal);
        $rd_args = array(
        'meta_query' => array(
        array(
        'key' => $tube,
        'value' => $id ) )
        );
        $query = new WP_Query( $rd_args );

        //Revisamos si el título contiene alguna palabra baneada

        $c=0;
        for($i=0; $i<sizeof($palabras); $i++){
            $con = stripos($titulo, $palabras[$i]);
            if($con===false){
            }else{
                $c=$c+1;
            }
        }

        // Parte de comentarios //



        //Si la contiene, no se sube
        if($c==0){
            if (preg_match ("/^[a-zA-Z0-9. ()¡!\',\"\&\-\/\:\[\]\%\ñ]+$/", $titulo)) {
                if ( $query->posts ) {
              
                        echo "[".$k."] Subido -> Repetido ".$titulo."-".$key."<br>";
                        require($path.'/wp-load.php');
                        $c = array($indice);
                        $views = rand( 1, 100);
                        $likes = rand( 0, 50 );
                        remove_filter('content_save_pre', 'wp_filter_post_kses');
                        remove_filter('content_filtered_save_pre', 'wp_filter_post_kses');

                        $new_post = array(
                        'post_title' => $titulo,
                        'post_content' => html_entity_decode($contenido),
                        'post_status' => 'publish',
                        'post_date' => date('Y-m-j H:i:s'),
                        'post_author' => 1,
                        'post_type' => 'post',
                        'post_category' => $c,
                        'tags_input' => $tags
                        );
                        $post_id = wp_insert_post($new_post);
                        update_post_meta( $post_id, 'duration', $duracion );
                        update_post_meta( $post_id, 'post_views_count', $views );
                        update_post_meta( $post_id, 'votes_count', $likes );
                        update_post_meta( $post_id, 'xvideos', $id ); 
                        update_post_meta( $post_id, 'thumb', $imagen );

                        $html = file_get_html($link_comentarios);
                        $comentario = json_decode($html,true);
                        if($comentario!=null){
                            $cantidad_comentarios= count($comentario["posts"]["posts"]);
                            $comentarios=$comentario["posts"]["posts"];
                            for ($i=0; $i < $cantidad_comentarios; $i++){
                                $nombre = array_values(array_values($comentarios)[$i]);
                                $data = array(
                                    'comment_post_ID' => $post_id,
                                    'comment_author' => $nombre[5],
                                    'comment_content' => $nombre[7],
                                    'comment_date' => date('Y-m-d H:i:s'),
                                    'comment_date_gmt' => date('Y-m-d H:i:s'),
                                    'comment_approved' => 1,
                                    );
                                $comment_id = wp_insert_comment($data);
                            }
                        }
                   
                    }else{
                        echo "[".$k."] Subido -> ".$titulo."-".$key."<br>";
                        require($path.'/wp-load.php');
                        $c = array($indice);
                        $views = rand( 1, 100);
                        $likes = rand( 0, 50 );
                        remove_filter('content_save_pre', 'wp_filter_post_kses');
                        remove_filter('content_filtered_save_pre', 'wp_filter_post_kses');

                        $new_post = array(
                        'post_title' => $titulo,
                        'post_content' => html_entity_decode($contenido),
                        'post_status' => 'publish',
                        'post_date' => date('Y-m-j H:i:s'),
                        'post_author' => 1,
                        'post_type' => 'post',
                        'post_category' => $c,
                        'tags_input' => $tags
                        );


                        $post_id = wp_insert_post($new_post);
                        update_post_meta( $post_id, 'duration', $duracion );
                        update_post_meta( $post_id, 'post_views_count', $views );
                        update_post_meta( $post_id, 'votes_count', $likes );
                        update_post_meta( $post_id, 'xvideos', $id ); 
                        update_post_meta( $post_id, 'thumb', $imagen );
                        wp_set_object_terms($post_id, $actores_names, 'actors');

                        $html = file_get_html($link_comentarios);
                        $comentario = json_decode($html,true);
                        if($comentario!=null){
                            $cantidad_comentarios= count($comentario["posts"]["posts"]);
                            $comentarios=$comentario["posts"]["posts"];
                            for ($i=0; $i < $cantidad_comentarios; $i++){
                                $nombre = array_values(array_values($comentarios)[$i]);
                                $data = array(
                                    'comment_post_ID' => $post_id,
                                    'comment_author' => $nombre[5],
                                    'comment_content' => $nombre[7],
                                    'comment_date' => date('Y-m-d H:i:s'),
                                    'comment_date_gmt' => date('Y-m-d H:i:s'),
                                    'comment_approved' => 1,
                                    );
                                $comment_id = wp_insert_comment($data);
                            }
                        }
                    }
            }else{
                echo "[".$k."] * ".$titulo." -> No se sube, Palabras raras<br>";
            }
        }else{
            echo "[".$k."] * ".$titulo." -> No se sube, Ban<br>";
        }
    }  
}


//FIN DEL PROCESO

$numero++;
if($numero>157){
    $numero=0;
}
fclose($archivo);
$arch = fopen ("variable.txt", "w");
fwrite($arch, $numero);
fclose($arch);

?>