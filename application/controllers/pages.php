<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pages extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */

	public function index()
	{		
		$this->load->model("posts_model");
		$data["posts"] = $this->posts_model->getAllPosts();		
		$data["categories"] = $this->posts_model->getCategories();
		$data["categoryOfPosts"] = $this->posts_model->getCategoryOfAllPosts();	
		$data["about"] = $this->posts_model->getAbout();
		//echo "<pre>";
		//print_r($data);

		$header["title"] = "Anasayfa";
		$this->load->view("template/header.html" , $header);
		$this->load->view('template/index.html', $data);
		$this->load->view('template/footer.html');

	}

	public function about()
	{
		$this->load->model('posts_model');
		$data["posts"] = $this->posts_model->getAllPosts();		
		$data["categories"] = $this->posts_model->getCategories();
		$data["categoryOfPosts"] = $this->posts_model->getCategoryOfAllPosts();	
		$data["about"] = $this->posts_model->getAbout();
		$header["title"] = "Hakkında";
		$this->load->view("template/header.html" , $header);
		$this->load->view('template/about.html', $data);
		$this->load->view('template/footer.html');
	}

	public function readPostForUser($categoryOfPost, $postID)
	{	
		$this->load->model("posts_model");
		$result = $this->posts_model->getPost($postID);
		$post = $result[0];
		$categories = $this->posts_model->getCategories();
		$data = array(
			'title' => $post->title,
			'postContent' =>  $post->postContent,
			'date' => $post->date,
			'categoryID' => $post->categoryID,
			'categoryOfPost' => $categoryOfPost,
			'postID' => $post->postID,
			'categories' => $categories,
			'about' => $this->posts_model->getAbout(),
			'comments' => $this->posts_model->getCommentsInPost($postID)
			);
		$header["title"] = $post->title;
		$this->load->view("template/header.html" , $header);
		$this->load->view("template/readpostforuser_view.html", $data);
		$this->load->view('template/footer.html');		
	}

	public function postsInCategory($categoryID)
	{
		$this->load->model("posts_model");
		$data["postsInCategory"] = $this->posts_model->getPostsInCategory($categoryID);
		$data["categories"] = $this->posts_model->getCategories();
		$data["about"] = $this->posts_model->getAbout();
		$data["category"] = $this->posts_model->getCategory($categoryID);

		//echo "<pre>"; print_r($data);
		$header["title"] = $data["category"][0]->categoryName;
		$this->load->view("template/header.html" , $header);
		$this->load->view("template/postsInCategory_view.html", $data);	
		$this->load->view('template/footer.html');		
	}
	public function contact()
	{	
		$this->load->model("posts_model");
		$data["categories"] = $this->posts_model->getCategories();
		$data["about"] = $this->posts_model->getAbout();
		$header["title"] = "İletişim";
		$this->load->view("template/header.html" , $header);
		$this->load->view('template/contact.html',$data);
		$this->load->view('template/footer.html');	
	}

	public function addCommentForPost()
	{
		if ($_POST) 
		{
			$name = $this->input->post("name");
			$e_mail = $this->input->post("email");
			$comment = $this->input->post("comment");
			$postID = $this->input->post("postID");
			$categoryOfPost = $this->input->post("categoryOfPost");

			if (empty($name) || empty($e_mail) || empty($comment) ) {
					$header["title"] = "Comment Error";
					$this->load->view("template/header.html", $header);
					$information["content"] = "**Lütfen tüm alanları doldurunuz";
					$this->load->view("template/informationForUser_view.html", $information);
					$this->load->model("posts_model");
					$data["categories"] = $this->posts_model->getCategories();
					$data["about"] = $this->posts_model->getAbout();
					$this->load->view("template/footer.html", $data);
			}
			else{
				$data = array($name, $e_mail, $comment, $postID);
				$this->load->model("posts_model");
				$add = $this->posts_model->addComment($data);
				
				if ($add) 
				{	/*
					$header["title"] = "Başarılı";
					$this->load->view("template/header.html", $header);
					$information["content"] = "Yorumunuz başarıyla gönderildi. ";
					$this->load->view("template/informationForUser_view.html", $information);
					$data["categories"] = $this->posts_model->getCategories();
					$data["about"] = $this->posts_model->getAbout();
					$this->load->view("template/footer.html", $data);
*/
					//$this->load->view("template/readpostforuser_view.html");
				//controller'da readPostForUser'ın içeriği  
					$result = $this->posts_model->getPost($postID);
					$post = $result[0];
					$categories = $this->posts_model->getCategories();
					$data = array(
						'title' => $post->title,
						'postContent' =>  $post->postContent,
						'date' => $post->date,
						'categoryID' => $post->categoryID,
						'categoryOfPost' => $categoryOfPost,
						'postID' => $post->postID,
						'categories' => $categories,
						'about' => $this->posts_model->getAbout(),						
						'comments' => $this->posts_model->getCommentsInPost($postID)
						);
					$header["title"] = $post->title;
					$this->load->view("template/header.html" , $header);
					$this->load->view("template/readpostforuser_view.html", $data);
					$this->load->view('template/footer.html');	
				}
				else
				{
					$header["title"] = "Error";
					$this->load->view("template/header.html", $header);
					$information["content"] = "Yorumunuz gönderilemedi. ";
					$this->load->view("template/informationForUser_view.html", $information);
					$data["categories"] = $this->posts_model->getCategories();
					$data["about"] = $this->posts_model->getAbout();
					$this->load->view("template/footer.html", $data);
				}
			}
		}
		else
			echo "Giris yasak.";
	}

	public function page()
	{
		$this->load->view('page.html');
	}
}