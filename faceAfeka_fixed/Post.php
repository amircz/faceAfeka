<?php
class Post
{
	var $post_username;
	var $post_id;
	var $post_user_id;
	var $date;
	var $private;
	var $content;
	var $imagesPath;
	var $likes_num;
	var $location;
	var $comments_num;
	var $likes = array();
	var $comments = array();
	function __construct($post_username, $post_id, $post_user_id, $date, $private, $content, $imagesPath,
			$likes_num, $location,$comments_num)
	{
		$this->post_username = $post_username;
		$this->post_id = $post_id;
		$this->post_user_id = $post_user_id;
		$this->date = $date;
		$this->private = $private;
		$this->content = $content;
		$this->imagesPath = $imagesPath;
		$this->likes_num = $likes_num;
		$this->location = $location;
		$this->comments_num =$comments_num ;
	}
	/**
	 * @return the $post_username
	 */
	public function getPost_username() {
		return $this->post_username;
	}
	
	/**
	 * @return the $post_id
	 */
	public function getPost_id() {
		return $this->post_id;
	}
	
	/**
	 * @return the $post_user_id
	 */
	public function getPost_user_id() {
		return $this->post_user_id;
	}
	
	/**
	 * @return the $date
	 */
	public function getDate() {
		return $this->date;
	}
	
	/**
	 * @return the $private
	 */
	public function getPrivate() {
		return $this->private;
	}
	
	/**
	 * @return the $content
	 */
	public function getContent() {
		return $this->content;
	}
	
	/**
	 * @return the $img1
	 */
	public function getImagesPath() {
		return $this->imagesPath;
	}
	/**
	 * @return the $likes_num
	 */
	public function getLikes_num() {
		return $this->likes_num;
	}
	
	/**
	 * @return the comments number
	 */
	public function getcomments_num() {
		return $this->comments_num;
	}
	
	
	/**
	 * @return the $location
	 */
	public function getLocation() {
		return $this->location;
	}
	
	/**
	 * @return the $likes
	 */
	public function getLikes() {
		return $this->likes;
	}
	
	/**
	 * @return the $comments
	 */
	public function getComments() {
		return $this->comments;
	}
	
	/**
	 * @param field_type $post_username
	 */
	public function setPost_username($post_username) {
		$this->post_username = $post_username;
	}
	
	/**
	 * @param field_type $post_id
	 */
	public function setPost_id($post_id) {
		$this->post_id = $post_id;
	}
	
	/**
	 * @param field_type $post_user_id
	 */
	public function setPost_user_id($post_user_id) {
		$this->post_user_id = $post_user_id;
	}
	
	/**
	 * @param field_type $date
	 */
	public function setDate($date) {
		$this->date = $date;
	}
	
	/**
	 * @param field_type $private
	 */
	public function setPrivate($private) {
		$this->private = $private;
	}
	
	/**
	 * @param field_type $content
	 */
	public function setContent($content) {
		$this->content = $content;
	}
	
	/**
	 * @param field_type $img1
	 */
	public function setImagesPath($imagesPath) {
		$this->imagesPath = $imagesPath;
	}
	
	/**
	 * @param field_type $likes_num
	 */
	public function setLikes_num($likes_num) {
		$this->likes_num = $likes_num;
	}
	
	/**
	 * @param field_type $location
	 */
	public function setLocation($location) {
		$this->location = $location;
	}
	
	/**
	 * @param multitype: $likes
	 */
	public function setLikes($likes) {
		$this->likes = $likes;
	}
	
	/**
	 * @param multitype: $comments
	 */
	public function setComments($comments) {
		$this->comments = $comments;
	}
	
	public function setCommentsNum($comment_num)
	{
		$this->comments_num = $comment_num;
	}
}