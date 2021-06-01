<?php
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2014 - 2019, British Columbia Institute of Technology
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package	CodeIgniter
 * @author	EllisLab Dev Team
 * @copyright	Copyright (c) 2008 - 2014, EllisLab, Inc. (https://ellislab.com/)
 * @copyright	Copyright (c) 2014 - 2019, British Columbia Institute of Technology (https://bcit.ca/)
 * @license	https://opensource.org/licenses/MIT	MIT License
 * @link	https://codeigniter.com
 * @since	Version 1.0.0
 * @filesource
 */



defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Model Class
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Libraries
 * @author		EllisLab Dev Team
 * @link		https://codeigniter.com/user_guide/libraries/config.html
 */
class CI_Model {
    private $table_index;
    private $table;
    private $mongodb;


	/**
	 * Class constructor
	 *
	 * @link	https://github.com/bcit-ci/CodeIgniter/issues/5332
	 * @return	void
	 */
	public function __construct() {}


	/**
	 * __get magic
	 *
	 * Allows models to access CI's loaded classes using the same
	 * syntax as controllers.
	 *
	 * @param	string	$key
	 */

	public function __get($key)
	{
		// Debugging note:
		//	If you're here because you're getting an error message
		//	saying 'Undefined Property: system/core/Model.php', it's
		//	most likely a typo in your model code.
		return get_instance()->$key;
	}
	public function set_table_index($table_index){
	    $this->table_index = $table_index;
    }
    public function get_table_index(){
	    return $this->table_index;
    }
    public function set_table($table){
	    $this->table = $table;
    }
    public function get_table(){
	    return $this->table;
    }

    /** Responsável por validar os dados do formulário
     * @param $data
     * @param $model
     */
    public function form_validate($data){
        $this->load->library('form_validation');

        $this->form_validation->set_rules($this->validate);

        if($this->form_validation->run() == FALSE) {
            $this->output->set_output(json_encode(array('error'=>validation_errors())));
        }

    }


    /**
     * Responsável pela busca de dados através da condição Where
     * Se não informada a condição Where retornal todos os dados
     * @get_hwere
     * Where = []
    **/
    public function getWhere( $where = null, $result = "array", $orderby = NULL, $direction = NULL, $limit = NULL, $offset = NULL, $validUser = true ){

        $getWhere = $this->db->order_by( $orderby,$direction )->get_where( $this->get_table(), $where, $limit, $offset );

        switch ( $result ){
            case "object":
                $result =  $getWhere->result_object();
                break;
            case "array":
                $result = $getWhere->result_array();
                break;
            case "row":
                $result = $getWhere->row();
                break;
        }
        if( $validUser ){
            $this->validInstanceUser( $result, $where );
        }
        return $result;

    }

    private function validInstanceUser( $result,$where ){
        if( $this->get_table() === 'user' && !$result ){
            debug($where);

            //aqui salvar informações para auditoria
            header( 'Content-type: application/json' );
            echo json_encode('User not found!');
            set_status_header(404);
            exit();
        }
        return false;
    }
    /**
     * Função para retornar todos os registros de uma tabela
     * $param $select = se for vazio retornara todas as entidades
     **/
    public function all($select = "*"){

        $all = $this->db->select($select)->from($this->get_table());
        return $all->get()->result_array();
    }
    public function count_result_table($reset = TRUE){
        return $this->db->count_all_results($this->get_table(),$reset);
    }
    /**
     * Função delete com condição Where
    **/

    public function deletewhere($where = null,$limit = 1,$reset_data = TRUE){

        return $this->db->delete($this->get_table(),$where,$limit,$reset_data);

    }

    /**
     * Save para sql
     */
    public function save( $data = [],$return = false ){

            if( array_key_exists( $this->get_table_index(),$data ) && $data[$this->get_table_index()]):
                $table_index    = $this->get_table_index();
                $value_index    = $data[ $this->get_table_index() ];
                $save           = $this->db->update( $this->get_table(),$data,"$table_index = $value_index" );
            else:
                $save = $this->db->insert( $this->get_table(),$data );
            endif;

            if( !$save ):
                return $this->db->error();
            endif;

            if( $return ){
                is_array( $return ) && array_key_exists( $this->get_table_index(),$data )
                    ?
                $last_id = $data[ $this->get_table_index() ]

                    :
                $last_id = $this->db
                                ->insert_id();

                $data_return = $this->db
                                     ->select( $return )
                                     ->from( $this->get_table() )
                                     ->where(
                                         [ $this->get_table_index() => $last_id ]
                                     );

                $data_r = $data_return->get()->result_array();
                if( count( $data_r ) ){
                    $data_r = reset($data_r );
                    return $data_r;
                }
                return $data_r;
            }
            return true;

    }

}
