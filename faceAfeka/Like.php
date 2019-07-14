<?php
class Like
{
	var $like_id;
	var $user_id;
	var $post_id;
	
	function __construct($like_id, $user_id, $post_id)
	{
		$this->like_id = $like_id;
		$this->user_id = $user_id;
		$this->post_id = $post_id;
	}
	/**
	 * @return the $like_id
	 */
	public function getLike_id() {
		return $this->like_id;
	}

	/**
	 * @return the $user_id
	 */
	public function getUser_id() {
		return $this->user_id;
	}

	/**
	 * @return the $post_id
	 */
	public function getPost_id() {
		return $this->post_id;
	}

	/**
	 * @param field_type $like_id
	 */
	public function setLike_id($like_id) {
		$this->like_id = $like_id;
	}

	/**
	 * @param field_type $user_id
	 */
	public function setUser_id($user_id) {
		$this->user_id = $user_id;
	}

	/**
	 * @param field_type $post_id
	 */
	public function setPost_id($post_id) {
		$this->post_id = $post_id;
	}	
}