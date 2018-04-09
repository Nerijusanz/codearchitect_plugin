<?php
/**
 * @package Codearchitect
 */
namespace CA_Inc\modules\cpt;

use CA_Inc\library\WP_List_Table\WP_List_Table;

class CptTable
{

    public static function generate_table() //usage: cpt/template/cpt.php
    {
        $table = new Table();
        $table->render_table();

    }

}


class Table extends WP_List_Table
{

    public static $table_name;  //unique table name
    public static $page;    //module page
    public static $data;    //module data
    public static $items_per_page;  //for pagination


    public function __construct(){

        parent::__construct();

        self::$table_name = Setup::$module.'_table'; //prefix_table
        self::$page = Setup::$module_slug;
        self::$data = Setup::cpt_table_module_data();
        self::$items_per_page = Setup::$cpt_table_per_page;
    }


    public function render_table(){

        $this->prepare_items();

        $this->display_search_box();

        $this->display();   //WP_List_Table class

    }

    public function display_search_box(){

        echo '<form method="get">';
            echo '<input type="hidden" name="page" value="'.self::$page.'" />';
            echo '<input type="hidden" name="search_action" value="'.self::$table_name.'" />';

            $this->search_box('search','cpt-search');

        echo '</form>';

    }

    /**
     * Prepare the items for the table to process
     *
     * @return Void
     */
    public function prepare_items()
    {

        // check if table search form was submitted
        if( isset($_GET['search_action']) && $_GET['search_action']== self::$table_name && isset($_GET['s']) ){

            $search_key = sanitize_text_field($_GET['s']);

            if($search_key !='')
                self::$data = $this->make_search_filter_data( self::$data, $search_key );   //filter data by search key

        }

        $columns = $this->get_columns();
        $hidden = $this->get_hidden_columns();
        $sortable = $this->get_sortable_columns();
        $primary = 'module';    //primary column name;

        $this->_column_headers = array($columns, $hidden, $sortable,$primary);


        $currentPage = $this->get_pagenum();
        $totalItems = count(self::$data);

        $this->set_pagination_args( array(
            'total_items' => $totalItems,
            'per_page'    => self::$items_per_page
        ) );

        usort( self::$data, array( &$this, 'sort_data' ) );

        self::$data = array_slice(self::$data,(($currentPage-1)*self::$items_per_page),self::$items_per_page);

        $this->items = self::$data;

    }

    /**
     * Override the parent columns method. Defines the columns to use in your listing table
     *
     * @return Array
     */
    public function get_columns()
    {
        $columns = array(
            //'cb'		=> '<input type="checkbox" />', // to display the checkbox.*/
            'module_id'    => sprintf(__('Module %s',PLUGIN_DOMAIN),'ID'),
            'module'       => __('Module'),
            'singular_name' => __('Singular name'),
            'plural_name'   => __('Plural name'),
            'public'    => __('Public'),
            'archive'      => __('Archive'),
            'action'    => __('Actions')
        );

        return $columns;

    }


    public function column_default( $item, $column_name )
    {
        //var_dump($item);exit;
        switch( $column_name ) {
            case 'module_id':
            case 'module':
            case 'singular_name':
            case 'plural_name':
            case 'public':
            case 'archive':
            case 'action':
                return $item[ $column_name ];

            default:
                return print_r( $item, true ) ;
                //return;
        }
    }

    /**
     * Define which columns are hidden
     *
     * @return Array
     */
    public function get_hidden_columns()
    {
        //make hidden fields
        return array(
            'module_id'
        );
    }

    public function column_module($item){

        return $post_link = sprintf('<a href="%s?post_type=%s">%s</a>',
            admin_url('edit.php'),
            $item['module'],
            $item['module']
        );
    }



    /*protected function column_cb( $item ) {
        return sprintf(
            '<label class="screen-reader-text" for="cpt_module_id_' . $item['module_id'] . '">' . sprintf( __( 'Select %s' ), $item['module'] ) . '</label>'
            . "<input type='checkbox' name='ctp_modules[]' id='cpt_module_id_{$item['module_id']}' value='{$item['module_id']}' />"
        );
    }*/


    function no_items() {
        _e( 'items not found' );
    }

    /**
     * Define the sortable columns
     *
     * @return Array
     */
    public function get_sortable_columns()
    {
        /*
        * specify which columns should have the sort icon.
         */

        return $sortable = array(
            'module'=>'module',
            'singular_name'=>'singular name',
            'plural_name'=>'plural_name'

        );

        /*return array(
            'module' => array('module',false)
        );*/
    }


    protected function column_action( $item ) {

        $admin_url =  admin_url('admin.php');
        $page = (isset($_GET['page']))? esc_attr($_GET['page']):'';
        $module_id = $item['module_id'];    //column module_id

        $edit_link = sprintf('<a href="%s?page=%s&action=%s&module_id=%s">%s</a>',
            $admin_url,
            $page,
            self::$table_name.'_row_edit',
            $module_id,
            __('Edit',PLUGIN_DOMAIN)
        );

        $delete_link = sprintf('<a href="%s?page=%s&action=%s&module_id=%s&module_name=%s">%s</a>',
            $admin_url,
            $page,
            self::$table_name.'_row_delete',
            $module_id,
            $item['module'],
            __('Delete',PLUGIN_DOMAIN)
        );


        $actions['edit_module']=$edit_link;
        $actions['delete_module'] = $delete_link;

        return $this->row_actions( $actions );

    }


    function extra_tablenav( $which ) {

        if ( $which == "top" ){ //table top links;

            $admin_url =  admin_url('admin.php');
            $page = (isset($_GET['page']))?esc_attr($_GET['page']):'';

            $link_all = sprintf('<a href="%s?page=%s&action=%s">%s</a>',
                $admin_url,
                $page,
                self::$table_name.'_all_items',
                __('All',PLUGIN_DOMAIN)
            );

            $link_add = sprintf('<a href="%s?page=%s&action=%s">%s</a>',
                $admin_url,
                $page,
                self::$table_name.'_add_new_item',
                __('Add new',PLUGIN_DOMAIN)
            );

            printf('<ul class="top-links"><li>%s</li><li>%s</li></ul>',$link_all,$link_add);


        }
        /*
        if ( $which == "bottom" ){
            //The code that goes after the table is there

        }*/

    }


    /**
     * Allows you to sort the data by the variables set in the $_GET
     *
     * @return Mixed
     */
    private function sort_data( $a, $b )
    {
        // Set defaults
        $orderby = 'module'; //by module field
        $order = 'asc'; //order type

        // If orderby is set, use this as the sort column
        if(!empty($_GET['orderby']))
        {
            $orderby = $_GET['orderby'];
        }

        // If order is set use this as the order
        if(!empty($_GET['order']))
        {
            $order = $_GET['order'];
        }


        $result = strcmp( $a[$orderby], $b[$orderby] );

        if($order === 'asc')
        {
            return $result;
        }

        return -$result;

    }



    // filter the table data based on the search key
    public function make_search_filter_data( $data, $search_key ) {

        $filtered_data = array_values( array_filter( $data, function( $row ) use( $search_key ) {

            foreach( $row as $row_val ):
                if( stripos( $row_val, $search_key ) !== false ):
                    return true;
                endif;
            endforeach;

        } ) );

        return $filtered_data;

    }


}
?>