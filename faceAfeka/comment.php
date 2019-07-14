<?php
class Comment
{
	var $comment_id;
	var $post_id;
	var $user_id;
	var $user_name;
	var $content;
	var $date;
	var $img;
	
	function __construct($comment_id, $post_id, $user_id, $user_name, $content,$date,$img)
	{
		$this->comment_id = $comment_id;
		$this->post_id = $post_id;
		$this->user_id = $user_id;
		$this->user_name = $user_name;
		$this->content = $content;
		$this->date = $date;
		$this->img = $img;
		
	}
	/**
	 * @return the $comment_id
	 */
	public function getComment_id() {
		return $this->comment_id;
	}
	
	public function getImg() {
		return $this->img;
	}
	
	/**
	 * @return the $post_id
	 */
	public function getPost_id() {
		return $this->post_id;
	}
	
	/**
	 * @return the $user_id
	 */
	public function getUser_id() {
		return $this->user_id;
	}
	
	/**
	 * @return the $content
	 */
	public function getContent() {
		return $this->content;
	}
	
	/**
	 * @return the $date
	 */
	public function getDate() {
		return $this->date;
	}
	
	
	/**
	 * @param field_type $comment_id
	 */
	public function setComment_id($comment_id) {
		$this->comment_id = $comment_id;
	}
	
	/**
	 * @param field_type $post_id
	 */
	public function setPost_id($post_id) {
		$this->post_id = $post_id;
	}
	
	/**
	 * @param field_type $user_id
	 */
	public function setUser_id($user_id) {
		$this->user_id = $user_id;
	}
	
	/**
	 * @param field_type $content
	 */
	public function setContent($content) {
		$this->content = $content;
	}
	
	/**
	 * @param field_type $date
	 */
	public function setDate($date) {
		$this->date = $date;
	}
	/**
	 * @return the $user_name
	 */
	public function getUser_name() {
		return $this->user_name;
	}

	/**
	 * @param field_type $user_name
	 */
	public function setUser_name($user_name) {
		$this->user_name = $user_name;
	}

	/**
	 * @param field_type $img
	 */
	public function setImg($img) {
		$this->img = $img;
	}
}