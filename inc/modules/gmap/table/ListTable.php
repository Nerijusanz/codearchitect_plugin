<?php
/**
 * @package Codearchitect
 */
namespace CA_Inc\modules\gmap\table;

use CA_Inc\library\WP_List_Table\WP_List_Table;


class ListTable extends WP_List_Table
{

    public static $table;  //unique table name
    public static $page;    //module page
    public static $data;    //module data
    public static $items_per_page;  //for pagination
    public static $order_by_item;//order by column name
    public static $order_type;  //default asc
    public static $primary_column;  //column name

    public function __construct(){

        parent::__construct();

        self::$table = TableSetup::$table;
        self::$page = TableSetup::$page;
        self::$data = TableSetup::$data;
        self::$items_per_page = TableSetup::$items_per_page;

        self::$order_by_item = TableSetup::$order_by_item; //order by column name
        self::$order_type = TableSetup::$order_type;

        self::$primary_column = TableSetup::$primary_column;    //primary column name;

    }


    public function render_table(){


            $this->prepare_items();

            //$this->display_search_box();

            $this->display();   //WP_List_Table class

    }


    public function display_search_box(){

        echo '<form method="get">';
            echo '<input type="hidden" name="page" value="'.self::$page.'" />';
            echo '<input type="hidden" name="search_action" value="'.self::$table.'" />';

            $this->search_box('search','search');

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
        if( isset($_GET['search_action']) && $_GET['search_action']== self::$table && isset($_GET['s']) ){

            $search_key = sanitize_text_field($_GET['s']);

            if($search_key !='')
                self::$data = $this->make_search_filter_data( self::$data, $search_key );   //filter data by search key

        }


        $columns = $this->get_columns();
        $hidden = $this->get_hidden_columns();
        $sortable = $this->get_sortable_columns();
        $primary = self::$primary_column;    //primary column name;

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
            'id'    => sprintf(__('Location %s',PLUGIN_DOMAIN),'ID'),
            'title'       => __('Title',PLUGIN_DOMAIN),
            'lat' => __('Latitude',PLUGIN_DOMAIN),
            'long'   => __('Longitude',PLUGIN_DOMAIN),
            'action'    => __('Actions',PLUGIN_DOMAIN)
        );

        return $columns;

    }


    public function column_default( $item, $column_name )
    {
        //var_dump($item);exit;
        switch( $column_name ) {
            case 'id':
            case 'title':
            case 'lat':
            case 'long':
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
            'id'
        );
    }

    /*public function column_module($item){

            return $item['column_name'];
    }*/



    protected function column_cb( $item ) {
        return sprintf(
            '<label class="screen-reader-text" for="item_id_' . $item['id'] . '">' . sprintf( __( 'Select %s' ), $item['title'] ) . '</label>'
            . "<input type='checkbox' name='items[]' id='item_id_{$item['id']}' value='{$item['id']}' />"
        );
    }


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
            'title'=>'title'

        );

        /*return array(
            'module' => array('module',false)
        );*/
    }
    /*
    public function get_bulk_actions() {

        return array(
            'delete' => __( 'Delete', 'your-textdomain' ),
            //'save'   => __( 'Save', 'your-textdomain' ),
        );

    }

    public function process_bulk_action() {

        // make security nonce check here!


        $action = $this->current_action();

        switch ( $action ) {

            case 'delete':
                wp_die( 'Delete something' );
                break;

            case 'save':
                wp_die( 'Save something' );
                break;

            default:
                // do nothing or something else
                return;
                break;
        }

        return;
    }*/


    protected function column_action( $item ) {

        $admin_url =  admin_url('admin.php');
        $page = $_GET['page'];
        $item_id = $item['id'];    //column module_id

        $edit_link = sprintf('<a href="%s?page=%s&action=%s&item_id=%s">%s</a>',
            $admin_url,
            $page,
            'table_row_edit',
            $item_id,
            __('Edit',PLUGIN_DOMAIN)
        );

        $delete_link = sprintf('<a href="%s?page=%s&action=%s&item_id=%s&item_name=%s">%s</a>',
            $admin_url,
            $page,
            'table_row_delete',
            $item_id,
            $item['title'],
            __('Delete',PLUGIN_DOMAIN)
        );


        $actions['edit_item']=$edit_link;
        $actions['delete_item'] = $delete_link;

        return $this->row_actions( $actions );

    }


    function extra_tablenav( $which ) {

        if ( $which == "top" ){ //table top links;

            $admin_url =  admin_url('admin.php');
            $page = $_GET['page'];

            $link_all = sprintf('<a href="%s?page=%s&action=%s">%s</a>',
                $admin_url,
                $page,
                'table_all_items',
                __('All',PLUGIN_DOMAIN)
            );

            $link_add = sprintf('<a href="%s?page=%s&action=%s">%s</a>',
                $admin_url,
                $page,
                'table_add_new_item',
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
        $orderby = self::$order_by_item;

        $order = self::$order_type; //order type

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