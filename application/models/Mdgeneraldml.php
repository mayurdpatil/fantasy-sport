<?php
class Mdgeneraldml extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	/*
         * function to fetch details from database...
         * argument syntax : 
         * $where = array("column_name" => "value");
         * $num = limit[1] numeric
         * $offset = limit[1] numeric
         * $join[0] = array("tableName"=>"tbl_name", "columnNames" => "tbl_one.col=tbl_two.col", "joinType" => "INNER")...
         * $goup_by = column_name...
         */
        function select($select, $from, $where = NULL, $orderBy = NULL, $num = NULL, $offset = NULL, $join = NULL, $group_by = NULL)
	{
            try
            {
                $slavedb = $this->load->database('slavedb', TRUE);
                $slavedb->select($select);
                $slavedb->from($from);

                //if there is any joining with n($joinCnt) another tables .................
                if($join != NULL)
                {
                    for($i = 1; $i <= count($join); $i++)
                    {
                        $joinType = ($join[$i]['joinType'] == "") ? "INNER" : $join[$i]['joinType'];
                        $slavedb->join($join[$i]['tableName'], $join[$i]['columnNames'], $joinType);
                    }
                }

                //if there is no any where criteria..............
                if($where != NULL)
                        $slavedb->where($where);

                //if result want sorted 
                if($orderBy != NULL)
                        $slavedb->order_by($orderBy['colname'], $orderBy['type']);

                //chk for pagination pages......................
                if($num != NULL or $offset != NULL)
                        $slavedb->limit($num,$offset);

                //chk for groupt by ......................
                if($group_by != NULL)
                        $slavedb->group_by($group_by); 
                return  $slavedb->get()->result_array();
                } catch (\Exception $e) {
                log_message('error', 'Error in Model : ' . $this->router->fetch_class() . "->" . $this->router->fetch_method());
            }
	}

	function insert($tableName, $insertData)
	{
            try{
		$this->db->insert($tableName, $insertData); 
		$arr['last_insertId'] = $this->db->insert_id();
		$arr['affectedRow'] = $this->db->affected_rows();
		$arr['last_query'] = $this->db->last_query();
		return $arr;
                } catch (\Exception $e) {
                    log_message('error', 'Error in Model while Insert: ' . $this->router->fetch_class() . "->" . $this->router->fetch_method());
                }
	}

	function update($where, $tableName, $updateData)
	{
            try{
		$this->db->where($where);
		$this->db->update($tableName, $updateData);
		return $this->db->last_query();
            } catch (\Exception $e) {
                log_message('error', 'Error in Update data: ' . $this->router->fetch_class() . "->" . $this->router->fetch_method());
            }
	}
	
	function match_update($where, $tableName, $team)
	{
            try{
		$this->db->set('sc_attempt', 'sc_attempt+1', FALSE);
		$this->db->set('sc_team', $this->input->post("team"));
		$this->db->where($where);
		$this->db->update($tableName);
            } catch (\Exception $e) {
                log_message('error', 'Error in Update data: ' . $this->router->fetch_class() . "->" . $this->router->fetch_method());
            }
	}
	
	function delete($where, $tableName)
	{
            try{
                $this->db->delete($tableName,$where); 
            } catch (\Exception $e) {
                log_message('error', 'Error in Delete Data: ' . $this->router->fetch_class() . "->" . $this->router->fetch_method());
            }
	}
        
        function core_select($select, $from, $where = NULL, $orderBy = NULL, $num = NULL, $offset = NULL, $join = NULL, $groupBy = NULL)
        {
            try
            {
                $slavedb = $this->load->database('slavedb', TRUE);
                $str_query = "SELECT " . $select;
                $str_query .= " FROM " . $from;
                //if there is any joining with n($joinCnt) another tables .................
                if($join != NULL)
                {
                    for($i = 1; $i <= count($join); $i++)
                    {
                        $str_query .= (! isset($join[$i]['joinType'])) ? "  INNER " : " " . $join[$i]['joinType'];
                        $str_query .= " join " . $join[$i]['tableName'] . " on " . $join[$i]['columnNames'];
                    }
                }

                 //if there is no any where criteria..............
                if($where != NULL)
                {
                    $str_query .= " where (1=1 AND ";

                    for($i = 1; $i <= count($where); $i++)
                    {
                        if($where[$i]['value'] != "" || $where[$i]['value'] == "0")
                        {
                            $where[$i]['value'] = $this->db->escape_str($where[$i]['value']);
                            if($where[$i]['islike'])
                                $str_query .= " (" . $where[$i]['columnName'] . " LIKE '%" . $where[$i]['value'] . "%') AND ";
                            else
                                $str_query .= " (" . $where[$i]['columnName'] . " = '" . $where[$i]['value'] . "') AND ";
                        }
                    }
                    $str_query .= " 1=1)";
                }

                //group by data...
                if($groupBy != NULL)
                    $str_query .= " group by " . $groupBy;

                //if result want sorted 
                if($orderBy != NULL)
                    $str_query .= " order by " . $orderBy['colname'] . " " . $orderBy['type'];

                //chk for pagination pages......................
                if($num != NULL or $offset != NULL)
                        $str_query .= " Limit ". $num . ", " . $offset;

                $query = $slavedb->query($str_query);
                return $query->result_array();
            } catch (\Exception $e) {
                log_message('error', 'Error in fetch data core select : ' . $this->router->fetch_class() . "->" . $this->router->fetch_method());
            }
        }
        
	function core_update($sql)
        {
            try
            {
                return $this->db->query($sql);

            } catch (\Exception $e) {
                log_message('error', 'Error in fetch data core select : ' . $this->router->fetch_class() . "->" . $this->router->fetch_method());
            }
        }
	   
	   function get_leaderboard($sql)
	   {
		try
		{
			    $slavedb = $this->load->database('slavedb', TRUE);
			$query = $slavedb->query($sql);
			return $query->result_array();
		} catch (\Exception $e) {
		    log_message('error', 'Error in fetch data core select : ' . $this->router->fetch_class() . "->" . $this->router->fetch_method());
		}		
	   }

	   function getMatchSelection($matchId)
	   {
		try
		{
			$slavedb = $this->load->database('slavedb', TRUE);
			$sql = "SELECT u.usr_fname, u.usr_lname, u.usr_id, u.usr_rating, t.* FROM tbl_users as u 
				LEFT JOIN tbl_score as s on u.usr_id = s.sc_player_id and s.sc_match_id = " . $matchId . "
				LEFT JOIN tbl_teams as t on t.tm_id = s.sc_team WHERE usr_status = 'A' ORDER BY tm_name DESC";

			$query = $slavedb->query($sql);
			return $query->result_array();
		} catch (\Exception $e) {
		    log_message('error', 'Error in fetch data core select : ' . $this->router->fetch_class() . "->" . $this->router->fetch_method());
		}		
	   }
}
/* End of file mdgeneraldml.php */
/* Location: ./system/application/model/mdgeneraldml.php */
/* @Author : mAYUR...*/
/* Version : 3.0*/
?>
