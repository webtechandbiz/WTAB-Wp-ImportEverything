<?php
//# Panel form sections
function _getSectionsFields(){
    $get_users = get_users(array('role__in'     => array(),));
    foreach ($get_users as $_user){
        $users[$_user->ID] = $_user->user_login;
    }

    //# Su quale tipologia di post scrivi
    $args = array('public'   => true, '_builtin' => false,);
    $post_types = get_post_types($args);
    $post_types = array_merge($post_types);

    if(is_woocommerce_activated()){
        $_woocommerce_conf = array(
            'WooCommerce' => array(
                'field_slug' => 'wp_woocommerce_active__importer',
                'field_type' => 'checkbox'
            )
        );
    }else{
        $_woocommerce_conf = array();
    }

    $ary_ = array(
        'Configurazione' => 
            array(
                'section_slug' => 'section_config',
                'fields' => array(
                    'WS URL (with http/https)<br> or file name with date <br>(naming: filename-[YYYYMMDD])' => 
                        array(
                            'field_slug' => 'ws_url__importer',
                            'field_type' => 'text' //# It could be: text, textarea, select, checkbox
                        )
                    ,
                    'Format' => 
                        array(
                            'field_slug' => 'format__importer',
                            'field_type' => 'select',
                            'options' => array(0 => 'Select', 1 => 'XML', 2 => 'CSV', 3 => 'JSON', 4 => 'DB')
                        )
                    ,
                    'Max products in importer' => 
                        array(
                            'field_slug' => 'max_products__importer',
                            'field_type' => 'text'
                        )
                    ,
                    'Active' => 
                        array(
                            'field_slug' => 'active__importer',
                            'field_type' => 'checkbox'
                        )
                    ,
                    'WP Importer User' => 
                        array(
                            'field_slug' => 'wp_user_id__importer',
                            'field_type' => 'select',
                            'options' => $users,
                        )
                    ,
                    'Post Type' => 
                        array(
                            'field_slug' => 'wp_posttype__importer',
                            'field_type' => 'select',
                            'options' => $post_types
                        )
                    ,
                    $_woocommerce_conf
                    
                )
            ),
        
        'Apache basic authentication' => 
            array(
                'section_slug' => 'basic_authentication__importer',
                'fields' => array(
                    'Username' => 
                        array(
                            'field_slug' => 'username_basicauth__importer',
                            'field_type' => 'text'
                        )
                    ,
                    'Password' => 
                        array(
                            'field_slug' => 'password_basicauth__importer',
                            'field_type' => 'text'
                        )
                    ,
                )
            )
        
    );
    return $ary_;
}

//# Panel form register
function register_pnl_form_droswavosw_settings() {
    $ary = _getSectionsFields();
    foreach ($ary as $section_label => $section_conf){
        $section_slug = $section_conf['section_slug'];
        $fields = $section_conf['fields'];

        foreach ($fields as $field_label => $field_conf){
            if($field_label !== '-' && $field_label !== '' && isset($field_conf['field_slug'])){
                register_setting( 'droswavosw_pnl_form_settings_page', $field_conf['field_slug'] );
            }
        }
    }
}

//# Panel form page
function droswavosw_pnl_form_settings_page() {?>
    <div class="wrap">
        <h1>Import Panel form</h1>
    </div>
    <form class="admin_droswavosw_pnl_form_settings_page_table" method="post" action="options.php">
        <?php settings_fields( 'droswavosw_pnl_form_settings_page' ); ?>
        <?php do_settings_sections( 'droswavosw_pnl_form_settings_page' ); ?>
        <table><?php
            $ary = _getSectionsFields();
            foreach ($ary as $section_label => $section_conf){
                $section_slug = $section_conf['section_slug'];
                $fields = $section_conf['fields'];

                echo '<tr><td colspan="2"><h2>'.$section_label.'</h2></td></tr>';
                foreach ($fields as $field_label => $field_conf){
                    if(isset($field_conf['field_type']) && $field_label !== '-'){
                        switch ($field_conf['field_type']) {
                            case 'text':
                                echo '
                                    <tr>
                                        <td>'.$field_label.'</td><td><input type="text" name="'.$field_conf['field_slug'].'" value="'.get_option($field_conf['field_slug']).'"/></td>
                                    </tr>';
                                break;

                            case 'textarea':
                                echo '
                                    <tr>
                                        <td>'.$field_label.'</td><td><textarea name="'.$field_conf['field_slug'].'">'.get_option($field_conf['field_slug']).'</textarea></td>
                                    </tr>';
                                break;

                            case 'select':
                                if(isset($field_conf['options']) && is_array($field_conf['options'])){
                                    $_options = '';
                                    $_option_selected = false;
                                    foreach ($field_conf['options'] as $_option_value => $option_label){
                                        if(intval(get_option($field_conf['field_slug'])) === intval($_option_value)){
                                            $_options .= '<option selected="selected" value="'.$_option_value.'">'.$option_label.'</option>';
                                        }else{
                                            $_options .= '<option value="'.$_option_value.'">'.$option_label.'</option>';
                                        }
                                    }
                                    if(!$_option_selected){
                                        $_options = '<option value="">-</option>'.$_options;
                                    }
                                    echo '
                                        <tr>
                                            <td>'.$field_label.'</td><td><select id="'.$field_conf['field_slug'].'" name="'.$field_conf['field_slug'].'">'.$_options.'</select></td>
                                        </tr>';
                                }
                                break;

                            case 'checkbox':
                                $_options = '';
                                $_option_selected = false;

                                if(intval(get_option($field_conf['field_slug'])) == 1){
                                    $_option_selected = true;
                                }
                                echo '<input type="hidden" id="'.$field_conf['field_slug'].'" name="'.$field_conf['field_slug'].'" value="'.get_option($field_conf['field_slug']).'"/></td>';
                                if($_option_selected){
                                    echo '
                                        <tr>
                                            <td>'.$field_label.'</td><td><input class="wtab_chk" checked="checked" type="checkbox" id="chk_'.$field_conf['field_slug'].'" name="chk_'.$field_conf['field_slug'].'" value="1"/></td>
                                        </tr>';
                                }else{
                                    echo '
                                        <tr>
                                            <td>'.$field_label.'</td><td><input class="wtab_chk" type="checkbox" id="chk_'.$field_conf['field_slug'].'" name="chk_'.$field_conf['field_slug'].'" value="0"/></td>
                                        </tr>';
                                }
                                break;

                            default:
                                break;
                        }
                    }
                }
            }
            ?>
        </table>
        <?php submit_button(); ?>
    </form><?php
}
