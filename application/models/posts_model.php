<?php 

/**
* 
*/
class posts_model extends CI_Model
{

	public function getAllPosts()
	{
		//mysql_query("select * from blog_posts");
		$this->db->select("*");
		
		// select * from blog_posts where id = 1
		//$this->db->where("postID", 1);
		
		//select * from blog_posts where id = 1 || id = 3
		//$this->db->where("postID = 1 || postID = 3");

		$query = $this->db->get("blog_posts");

		//echo $this->db->last_query();
		
		return $query->result();
	}
	
	public function getPostsInCategory($categoryID)
	{
		//SELECT * FROM blog_posts JOIN categories on blog_posts.categoryID=categories.categoryID 
		//where blog_posts.categoryID=1
		$this->db->select("*");
		$this->db->from('blog_posts');
		$this->db->join("categories", "blog_posts.categoryID = categories.categoryID");
		$this->db->where('blog_posts.categoryID', $categoryID);
		$query = $this->db->get();
		return $query->result();
	}
/*
	public function getCategoryOfAllPosts()
	{
		$this->db->select("categoryName");
		$this->db->from('categories');
		$this->db->join("blog_posts", "categories.categoryID = blog_posts.categoryID");
		$query = $this->db->get();
		return $query->result();
	}
*/
	public function getCategoryOfAllPosts()
	{
		$this->db->select("*");
		$this->db->from('blog_posts');
		$this->db->join("categories", "categories.categoryID = blog_posts.categoryID");
		$query = $this->db->get();
		return $query->result();
	}

	public function getPost($post_id)
	{
		$this->db->select("*");
		$this->db->where("postID", $post_id);
		$query = $this->db->get("blog_posts");
		return $query->result();
	}

	public function getCategory($categoryID)
	{
		$this->db->select("categoryName");
		$this->db->where("categoryID", $categoryID);
		$query = $this->db->get("categories");
		return $query->result();
	}

	public function getCategories()
	{
		$this->db->select("*");
		$query = $this->db->get("categories");

		return $query->result();
	}

	public function getAbout()
	{
		$this->db->select("*");
		$query = $this->db->get("about_us");

		return $query->result();
	}

	public function addPost($values)
	{
		$this->load->helper('date');
		$time = now();
		$data = array(
			'title' => $values[0],
			'postContent' => $values[1],
			'categoryID' => $values[2],
			'date' => $time
		 );
		 
		 $add = $this->db->insert("blog_posts", $data);

		return $add;
	}

	public function updatePost($values)
	{
		$data = array(
			'title' => $values[0],
			'postContent' => $values[1],
			'categoryID' => $values[3] 
			);	
		
		$postID = $values[2];
		
		$this->db->where('postID',$postID);
		$update = $this->db->update('blog_posts', $data);
		return $update;
	}

	public function updateAbout($about)
	{
			$data = array(
			'about' => $about
			);		
		$update = $this->db->update('about_us', $data);
		return $update;	
	}

	public function deletePost($postID)
	{
		$this->db->where('postID', $postID);
		$delete = $this->db->delete('blog_posts');
		return $delete;
	}

	public function adminLoginControl($values)
	{
		$this->db->select("*");
		$query = $this->db->get("admins");
		$result = $query->result();

		foreach ($result as $admin) {
			if ($admin->username == $values[1] && $admin->password == $values[0]) {
				return true;
			}
		}
		return false;
	}

	public function addCategory($categoryName)
	{		
		$data = array(
			'categoryName' => $categoryName,
		 );
		 
		 $add = $this->db->insert("categories", $data);

		return $add;
	}

	public function deleteCategory($categoryID)
	{
		$this->db->where('categoryID', $categoryID);
		$delete = $this->db->delete('categories');	// category deleted

		$data = array(
			'categoryID' => 0 
			);
		
		$this->db->where('categoryID',$categoryID);
		$update = $this->db->update('blog_posts', $data);
		return $delete;
	}

	public function addComment($values)
	{			
		$this->load->helper('date');
		$time = now();
		$data = array(
			'writerName' => $values[0],
			'writerEmail' => $values[1],
			'comment' => $values[2],
			'postID' => $values[3],
			'date' => $time,
			'visibility' => 0
		);
		//echo "<pre>"; print_r($data);
		$add = $this->db->insert("comments", $data);
		return $add;
	}

	public function deleteComment($commentID)
	{	
		$this->db->where('commentID', $commentID);
		$delete = $this->db->delete('comments');
		return $delete;
	}

	public function getUnseenComments()
	{
		$this->db->select("*");
		$this->db->from('comments');		
		$this->db->join("blog_posts", "blog_posts.postID = comments.postID");
		$this->db->where('comments.visibility' , 0);
		$query = $this->db->get();

		return $query->result();
	}

	public function getCommentsInPost($postID)	//blog yazısındaki yorumları döndürür.
	{
		//SELECT * FROM comments JOIN blog_posts on blog_posts.postID=comments.postID 
		//where blog_posts.postID=1
		$this->db->select("*");
		$this->db->from('comments');
		$this->db->join("blog_posts", "blog_posts.postID = comments.postID");
		$this->db->where('blog_posts.postID', $postID);
		$query = $this->db->get();
		return $query->result();
	}

	public function commentSetVisible($commentID)	//yorumu görünür yapar
	{
		$data = array(
			'visibility' => 1
			);		
		$this->db->where('commentID', $commentID);
		$update = $this->db->update('comments', $data);
		return $update;	
	}

	public function commentSetInvisible($commentID)	//yorumu görünmez yapar
	{
		$data = array(
			'visibility' => 0
			);		
		$this->db->where('commentID', $commentID);
		$update = $this->db->update('comments', $data);
		return $update;	
	}

	public function updateAdminPassword($username ,$password)
	{
		$data = array(
			'password' => $password,
			'username' => $username 
			);
		$update = $this->db->update('admins', $data);
		return $update;
	}	

}


 ?>