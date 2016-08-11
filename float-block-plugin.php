<?php
/*
Plugin Name: float block Плавающий блок
Plugin URI: http://www.computy.ru
Description: Плавающий блок внизу страницы с полезной информацией
Version: 1.1
Author: Computy
Author URI: http://www.computy.ru
License: GPL2
*/
?>
<?
// Для того, чтобы этот файл не могли подключить вне WordPress
if (!defined("WPINC")) {
    die;
}

function computy_wp_plugin_admin_menu(){
    if ( function_exists('add_options_page') )
    {
        $admin_page = add_options_page('computy Template', 'Плавающий блок', 8, 'Computytemplate',  'computy_wp_plugin_admin_menu_form' );
        // Подгружаем стили и скрипты из папки плагина
        //add_action( "admin_print_scripts-$admin_page", 'computy_wp_plugin_admin_menu_form_head' );
    }
}

function computy_wp_plugin_admin_menu_form(){

    ?>
    <div class='wrap'>
        <div id="icon-options-general" class="icon32"><br /></div>
        <h2>Короткая инструкция</h2>
        <div class='content_body'>
          Приветствую уважаемые пользователи CMS wordpress. <br><br>
            Предлагаем вашему вниманию плагин нашей разработки float block(Плавающий виджет). <br><br>
            Всего несколько кликов и на вашем сайте полностью функциональный блок с информацией. <br><br>
            Вы можете вставить туда рекламу, информационный текст, фото и видео. <br><br>
            Настраивается в панели инструментов «Внешний вид» — «виджеты» — «Плавающий блок» <br><br>
            Основные настройки плагина:<br> 
            Заголовок <br>
            Позиционирование блока <br>
            Основной текст <br>
            Ширина блока <br>
            Прозрачность блока (до наведения) - после наведения на блок, прозрачность убирается <br>
            <br>
            Вводится заголовок и основной текст, возможность вставлять ссылки, изображения, iframe и формы.
            Так же есть возможность добавлять до 4 блоков.

            © computy.ru


        </div>
    </div>
    <?php
}

/* ******************************* */
add_action('admin_menu',  'computy_wp_plugin_admin_menu' );
add_action( 'widgets_init', 'my_widget' );
function my_widget() {
    register_widget( 'MY_Widget' );
}

class MY_Widget extends WP_Widget {
    public function __construct() {
        parent::__construct("example", "Плавающий блок",
            array("description" => "Вставляйте любую информцию и блок будет постоянно видимым на странице"));
    }
    function widget( $args, $instance ) {//Тут как виджет будет отображаться
        extract( $args );


        if($instance["options_position"] == 'left-bottom'){
            $position = 'left:0; bottom: 0;';
        }elseif($instance["options_position"] == 'right-bottom') {
            $position = 'right:0; bottom: 0;';
        }elseif($instance["options_position"] == 'left-top') {
            $position = 'left:0; top: 0;';
        }elseif($instance["options_position"] == 'right-top') {
            $position = 'right:0;top: 0;';
        }



        echo'
<style>

.float-block-'.$this->get_field_id( 'name' ).'{
    position: fixed;
       '.$position.'
   transition: box-shadow .25s;
    padding: 20px;
    margin: 1rem ;
    border-radius: 2px;
    background-color: #fff;
   box-shadow: 0 2px 5px 0 rgba(0,0,0,0.16),0 2px 10px 0 rgba(0,0,0,0.12);
    opacity: '.$instance["opacity"].';
    width: '.$instance["width"].'px;
    z-index: 9999;
 }
 .float-block-'.$this->get_field_id( 'name' ).':hover{
 opacity:1;
 }
 #fb-close-'.$this->get_field_id( 'name' ).'{
     position: absolute;
    right: 8px;
    top: 0;
    text-decoration: none;
    color: red;
    font-weight: bold;
 }
 .fb-title-'.$this->get_field_id( 'name' ).'{
 text-align: center;
 }
 a,button,input,textarea {
outline: none;
}
#fb-close-'.$this->get_field_id( 'name' ).':focus {outline:none !important;}

</style>
<script>
	window.onload= function() {
	document.getElementById("fb-close-'.$this->get_field_id( 'name' ).'").onclick = function() {
	openbox("fb-box-'.$this->get_field_id( 'name' ).'", this);
	return false;	};	};
	function openbox(id, toggler) {
	var div = document.getElementById(id);
	if(div.style.display == "block") {
	div.style.display = "none";	}	else {
	div.style.display = "none";	}
		}
	</script>
<div id="fb-box-'.$this->get_field_id( 'name' ).'" class=" float-block-'.$this->get_field_id( 'name' ).'">
<a href="#fb-close-'.$this->get_field_id( 'name' ).'" id="fb-close-'.$this->get_field_id( 'name' ).'" onclick="closeWindow()" title="Закрыть">x</a>
<div class="fb-title-'.$this->get_field_id( 'name' ).'">',$instance['title'],'</div>
<div class="fb-text-'.$this->get_field_id( 'name' ).'">
',$instance["name"]
        ,'</div></div> ';

    }

    //Update the widget

    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;

        //Strip tags from title and name to remove HTML
        $instance['title'] = strip_tags( $new_instance['title'] );
        $instance['name'] =  $new_instance['name'];
        $instance['options_position'] =  $new_instance['options_position'];
        $instance['width'] =  $new_instance['width'];
        $instance['opacity'] =  $new_instance['opacity'];

        return $instance;
    }
    function form( $instance ) {

        //Set up some default widget settings.
        $defaults = array(

            'title' => __('Заголовок', 'example'),
            'name' => __('Текст', 'example'),
            'options_position' => __('выравнивание', 'example'),
            'show_info' => true );
        $instance = wp_parse_args( (array) $instance, $defaults ); ?>

        <p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Заголовок:', 'example'); ?></label>
            <input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
        </p>

        <p><label for="<?php echo $this->get_field_id( 'options_position' ); ?>"><?php _e('Выравнивание:', 'example'); ?></label><br>
            <select id="<?php echo $this->get_field_id('options_position' ); ?>" name="<?php echo $this->get_field_name( 'options_position' ); ?>">
                <option disabled>Выберите выравнивание</option>
                <option value="left-bottom">По левому краю снизу</option>
                <option value="right-bottom">По правому краю снизу</option>
                <option value="right-top">По правому краю сверху</option>
                <option value="left-top">По левому краю сверху</option>
            </select></p>

        <p>
            <label for="<?php echo $this->get_field_id( 'name' ); ?>"><?php _e('Текст:', 'example'); ?></label>
            <textarea id="<?php echo $this->get_field_id( 'name' ); ?>" name="<?php echo $this->get_field_name( 'name' ); ?>" style="width:100%;min-height: 100px" ><?php echo $instance['name']; ?></textarea>
        </p>

        <p><label for="<?php echo $this->get_field_id( 'width' ); ?>"><?php _e('Ширина блока, px:', 'example'); ?></label>
            <input id="<?php echo $this->get_field_id( 'width' ); ?>" placeholder="250" name="<?php echo $this->get_field_name( 'width' ); ?>" value="<?php echo $instance['width']; ?>" />
        </p>

        <p>
            <label for="<?php echo $this->get_field_id( 'opacity' ); ?>"><?php _e('Прозрачность(до наведения) с 0.1-1:', 'example'); ?></label>
            <input id="<?php echo $this->get_field_id( 'opacity' ); ?>" placeholder="0.8" name="<?php echo $this->get_field_name( 'opacity' ); ?>" value="<?php echo $instance['opacity']; ?>" />

        </p>
     <?php
    }
}

?>