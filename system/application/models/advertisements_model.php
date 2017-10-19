<?php

class Advertisements_Model extends Model{
	function advertisements_model(){
		parent::Model();
		$this->load->database();		
	}
	function get_footer_ads(){
		$this->db->cache_off();
		$this->db->order_by('order');
		$res = $this->db->get_where('admin_advertisements',array('page' => 'footer'));
		return $res->result_array();
	}
	function get_sidebar_ads(){
		$this->db->cache_off();
		$query = "SELECT DISTINCT(page),name FROM admin_advertisements WHERE page != 'footer'";
		$res = $this->db->query($query);
		return $res->result_array();
	}
	function get_sidebar_ads_by_page($page,$order){
		$this->db->cache_off();
		$res = $this->db->get_where('admin_advertisements',array('page' => $page,'order' => $order));
		return $res->row_array();
	}
	function get_footer_ad($edit){
		$this->db->cache_off();
		$res = $this->db->get_where('admin_advertisements',array('page' => 'footer','id' => $edit));
		return $res->row_array();
	}
	function save_footer_ad($edit){
		$data = array(
		   'links' => $this->input->post('links'),
		   'title' => $this->input->post('title'),
		   'text' => $this->input->post('text'),
		   'align' => $this->input->post('align'),
		   'image' => $this->input->post('image')
        );
		$this->db->update('admin_advertisements', $data, array('id' => $edit));
	}
	function save_sidebar_ad($page,$order,$data){
		$this->db->update('admin_advertisements', $data, array('page' => $page,'order' => $order));
	}
	function get_sidebar_ads_by_pagename($page){
		$this->db->cache_off();
		$this->db->order_by('order');
		$res = $this->db->get_where('admin_advertisements',array('page' => $page));
		return $res->result_array();
	}
	function get_page_sidebar_ads($page){
		$this->db->cache_off();
		$this->db->select('use_default');
		$res = $this->db->get_where('admin_advertisements',array('page' => $page,'order' => 1));
		$res = $res->row_array();
		
		if($res['use_default']){
			return $this->get_sidebar_ads_by_pagename('article');
		}else{
			return $this->get_sidebar_ads_by_pagename($page);
		}
	}
}