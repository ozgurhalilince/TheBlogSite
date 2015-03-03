<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* 
*/
class Admin extends CI_Controller
{	
	public function index()
	{
		$this->load->view("admin/login.html");
	}

	public function homepage()	
	{		
		if(doesEntry()) // giris yapilmis mi
		{	
			$data["posts"] = $this->posts_model->getAllPosts();		
			$data["categories"] = $this->posts_model->getCategories();
			$data["about"] = $this->posts_model->getAbout();
			$data["categoryOfPosts"] = $this->posts_model->getCategoryOfAllPosts();	
		//echo "<pre>";
		//print_r($data);

			$header["title"] = "Anasayfa";
			$this->load->view("admin/adminHeader.html", $header);
			$this->load->view("admin/homepage.html", $data);	
			$this->load->view("admin/adminFooter.html");	
		}
		else
			noEntry();
		
	}

	public function changePasswordView()	//giris yapıldı mı?
	{
		if(doesEntry()) // giris yapilmis mi
		{
			$data["about"] = $this->posts_model->getAbout();
			$data["categories"] = $this->posts_model->getCategories();
			$header["title"] = "Şifre Değiştir";
			$this->load->view("admin/adminHeader.html", $header);
			$this->load->view('admin/changePassword.html');
			$this->load->view("admin/adminFooter.html", $data);	
		}
		else		
			noEntry();	
	}

	public function updateAdminUserNamePassword()
	{
		if ($_POST) 
		{
			$newUn = $this->input->post('username');
			$newPw = $this->input->post('password');
			if (loginInputControl($newUn, $newPw)) 
			{		
				$update = $this->posts_model->updateAdminPassword($newUn ,$newPw);
				if ($update) 
				{
					$data["title"] = "Error";
					$data["content"] = "Şifre değiştirme işleminiz gerçekleştirildi";
					$this->load->view("admin/information_view.html", $data);
				}
				else
				{
					$data["title"] = "Error";
					$data["content"] = "Şifre değiştirme işleminiz gerçekleştirilemedi";
					$this->load->view("admin/information_view.html", $data);
				}
			}
			else
			{
				$data["title"] = "Error";
				$data["content"] = "Şifre değiştirme işleminiz gerçekleştirilemedi";
				$this->load->view("admin/information_view.html", $data);
			}
		}
		else		
			noEntry();	
	}	

	public function about()
	{
		if(doesEntry()) // giris yapilmis mi
		{
			$data["about"] = $this->posts_model->getAbout();
			$data["categories"] = $this->posts_model->getCategories(); 

			$header["title"] = "About";
			$this->load->view("admin/adminHeader.html", $header);
			$this->load->view("admin/aboutAdmin_view.html", $data);
			$this->load->view("admin/adminFooter.html");
			
		}
		else
			noEntry();	
	}	
	public function login()	//şifrenin genel kontrolleri hariç tamamlandı.
	{
		if ($_POST) 
		{
			$username = $this->input->post("username");
			$password = $this->input->post("password");

			if (!$username || !$password) 
			{	// if username or password empty
				$data["title"] = "Error";
				$data["content"] = "Lütfen kullanıcı adınızı ve şifrenizi boş bırakmayınız.";
				$this->load->view("admin/yetkiyok_view.html", $data);
			}
			else
			{				
				if (!loginInputControl($username, $password)) 
				{
					$data["title"] = "Error";
					$data["content"] = "Lütfen kullanıcı adınızı ve şifrenizi kontrol ediniz.";
					$this->load->view("admin/yetkiyok_view.html", $data);
				}
				else
				{
					$values  = array($password, $username);
					$loginControl = $this->posts_model->adminLoginControl($values);

					if ($loginControl) 
					{
						$data["posts"] = $this->posts_model->getAllPosts();		
						$data["categories"] = $this->posts_model->getCategories();
						$data["about"] = $this->posts_model->getAbout();
						$data["categoryOfPosts"] = $this->posts_model->getCategoryOfAllPosts();	
						$newdata = array(  
					       'username'  => "hello", 
					       'logged_in' => TRUE  
					    );
					    $this->session->set_userdata($newdata);  

						$header["title"] = "Anasayfa";
						$this->load->view("admin/adminHeader.html", $header);
						$this->load->view("admin/homepage.html", $data);	
						$this->load->view("admin/adminFooter.html");
					}
					else
					{
						$data["title"] = "Error";
						$data["content"] = "Lütfen kullanıcı adınızı ve şifrenizi kontrol ediniz.";
						$this->load->view("admin/yetkiyok_view.html", $data);
					}
				}
			}
		}
		else
			noEntry();
	}

	public function addPostView()
	{		
		if(doesEntry()) // giris yapilmis mi
		{
			$data["categories"] = $this->posts_model->getCategories();
			$data["about"] = $this->posts_model->getAbout();

			$header['title'] = "Yazı Ekle";
			$this->load->view("admin/adminHeader.html" , $header);
			$this->load->view("admin/addpost_view.html", $data);
			$this->load->view("admin/adminFooter.html");	 		
		}
		else
			noEntry();	
	}

	public function addPost()	
	{
		if ($_POST) 
		{
			if(doesEntry()) // giris yapilmis mi
			{
				$title = $this->input->post("title");
				$content = $this->input->post("content");
				$categoryID = $this->input->post('categoryID');
				if (!$content || !$title) {	// if content or title empty
					$data["title"] = "Error";
					$data["content"] = "Lütfen tüm alanları doldurup öyle gönderin.";
					$this->load->view("admin/information_view.html", $data);
				}
				else
				{
					$values  = array($title, $content,$categoryID);
					$add = $this->posts_model->addPost($values);
					if ($add) {
						$data["title"] = "Successful";
						$data["content"] = "Ekleme işleminiz başarıyla gerçekleştirildi.";
						$this->load->view("admin/information_view.html", $data);
					}
					else{
						$data["title"] = "Error";
						$data["content"] = "Ekleme işlemi gerçekleştirilemedi.";
						$this->load->view("admin/information_view.html", $data);
					}
				}
			}
			else
				noEntry();
		}
		else
			noEntry();	
			
	}	
	public function updatePost()
	{
		if ($_POST) 
		{			
			$title = $this->input->post("title");
			$content = $this->input->post("content");
			$postID = $this->input->post("postID");
			$categoryID = $this->input->post("categoryID");
			if (!$content || !$title) 
			{	// if content or title empty
				$data["title"] = "Error";
				$data["content"] = "Lütfen tüm alanları doldurup öyle gönderin.";
				$this->load->view("admin/information_view.html", $data);
			}			
			else
			{
				$values  = array($title, $content, $postID, $categoryID);
				$update = $this->posts_model->updatePost($values);
				if ($update) {
					$data["title"] = "Successful";
					$data["content"] = "Güncelleme işleminiz başarıyla gerçekleştirildi.";
					$this->load->view("admin/information_view.html", $data);
				}
				else{
					$data["title"] = "Error";
					$data["content"] = "Güncelleme işlemi gerçekleştirilemedi.";
					$this->load->view("admin/information_view.html", $data);
				}
			}				
		}
		else
			noEntry();		
	}

	public function updateAbout()
	{
		if ($_POST) 
		{
			$aboutContent = $this->input->post("aboutContent");
			$update = $this->posts_model->updateAbout($aboutContent);
			if ($update) 
			{
				$data["title"] = "Successful";
				$data["content"] = "Güncelleme işleminiz başarıyla gerçekleştirildi.";
				$this->load->view("admin/information_view.html", $data);
			}
			else{
				$data["title"] = "Error";
				$data["content"] = "Güncelleme işlemi gerçekleştirilemedi.";
				$this->load->view("admin/information_view.html", $data);
			}
		}
		else
			noEntry();	
	}

	public function updatePostView($postID)
	{		
		if(doesEntry()) // giris yapilmis mi
		{
			$post = $this->posts_model->getPost($postID);
			$data = array(					
				'postID' => $postID,
				'title' => $post[0]->title,
				'content' => $post[0]->postContent, 
				'categoryID' => $post[0]->categoryID,
				'about' => $this->posts_model->getAbout(),
				'categories' => $this->posts_model->getCategories()
				);
				
			$header['title'] = "Yazı Ekle";
			$this->load->view("admin/adminHeader.html" , $header);
			$this->load->view("admin/updatepost_view.html", $data);
			$this->load->view("admin/adminFooter.html");
		}
		else
			noEntry();	
	}

	public function deletePost($postID)
	{	
		if(doesEntry()) // giris yapilmis mi
		{	
			$delete = $this->posts_model->deletePost($postID);
			if ($delete) 
			{
				$data["title"] = "Successful";
				$data["content"] = "Silme işleminiz başarıyla gerçekleştirildi.";
				$this->load->view("admin/information_view.html", $data);
			}
			else
			{
				$data["title"] = "Error";
				$data["content"] = "Silme işlemi gerçekleştirilemedi.";
				$this->load->view("admin/information_view.html", $data);
			}			
		}
		else
			noEntry();	
	}

	public function readPostForAdmin($categoryOfPost, $postID)
	{
		if(doesEntry()) // giris yapilmis mi
		{
			$result = $this->posts_model->getPost($postID);
			$post = $result[0];
			$data = array(
				'title' => $post->title,
				'postContent' =>  $post->postContent,
				'date' => $post->date,
				'categoryID' => $post->categoryID,
				'categoryOfPost' => $categoryOfPost,
				'postID' => $post->postID,
				'categories' => $this->posts_model->getCategories(),
				'about' => $this->posts_model->getAbout(),
				'comments' => $this->posts_model->getCommentsInPost($postID)
			);	
		
			$header["title"] = $data['title'];
			$this->load->view("admin/adminHeader.html", $header);
			$this->load->view("admin/readpost_view.html", $data);
			$this->load->view("admin/adminFooter.html");
		}
		else
			noEntry();	
	}

	public function seeCategories()
	{
		if(doesEntry()) // giris yapilmis mi
		{
			$data["categories"] = $this->posts_model->getCategories();
			$data["about"] = $this->posts_model->getAbout();
			$header["title"] = "Kategoriler";
			$this->load->view("admin/adminHeader.html", $header);
			$this->load->view("admin/seeCategories_view.html", $data);
			$this->load->view("admin/adminFooter.html");
		}						
		else
			noEntry();	
	}

	public function addCategory()
	{	
		if ($_POST) 
		{
			$categoryName = $this->input->post("categoryName");
			
			if (!$categoryName) {	// if content or title empty
				$data["title"] = "Error";
				$data["content"] = "Lütfen kategori ismini boş bırakmayınız.";
				$this->load->view("admin/information_view.html", $data);
			}
			else{				
				$this->load->model('posts_model');
				$add = $this->posts_model->addCategory($categoryName);
				if ($add) {
					$data["title"] = "Başarılı";
					$data["content"] = "Kategori başarıyla eklenmiştir.";
					$this->load->view("admin/information_view.html", $data);
				}
				else {
					$data["title"] = "Error";
					$data["content"] = "Ekleme işlemi gerçekleştirilemedi.";
					$this->load->view("admin/information_view.html", $data);
				}
			}
		}
		else
			noEntry();
	}
	public function deleteCategory($categoryID)
	{
		if(doesEntry()) // giris yapilmis mi
		{
			$delete = $this->posts_model->deleteCategory($categoryID);
			if ($delete) {
				$data["title"] = "Başarılı";
				$data["content"] = "Kategori başarıyla silinmiştir.";
				$this->load->view("admin/information_view.html", $data);
			}
			else {
				$data["title"] = "Error";
				$data["content"] = "Silme işlemi gerçekleştirilemedi.";
				$this->load->view("admin/information_view.html", $data);
			}
		}
		else
			noEntry();
	}

	public function postsInCategoryAdmin($categoryID)
	{
		if(doesEntry()) // giris yapilmis mi
		{			
			$data["postsInCategory"] = $this->posts_model->getPostsInCategory($categoryID);
			$data["categories"] = $this->posts_model->getCategories();
			$data["about"] = $this->posts_model->getAbout();
			$data["category"] = $this->posts_model->getCategory($categoryID);
			
			$header["title"] = $data["category"][0]->categoryName;
			$this->load->view("admin/adminHeader.html", $header);
			$this->load->view("admin/postsInCategoryAdmin.html", $data);	
			$this->load->view("admin/adminFooter.html");
		}
		else
			noEntry();
	}

	public function seeUnapprovedComments()
	{
		if(doesEntry()) // giris yapilmis mi
		{
			$data["unSeenComments"] = $this->posts_model->getUnseenComments();
			$data["categories"] = $this->posts_model->getCategories();
			$data["about"] = $this->posts_model->getAbout();
			//echo "<pre>"; print_r($data);
			$header["title"] = "Onay Bekleyen Yorumlar"; 
			$this->load->view('admin/adminHeader.html', $header);
			$this->load->view('admin/seeUnapprovedComments_view.html', $data);
			$this->load->view('admin/adminFooter.html');
		}
		else
			noEntry();
	}

	public function deleteComment($commentID)
	{
		if(doesEntry()) // giris yapilmis mi
		{
			$delete = $this->posts_model->deleteComment($commentID);
			if ($delete) {
				$data["title"] = "Başarılı";
				$data["content"] = "Yorum başarıyla silinmiştir.";
				$this->load->view("admin/information_view.html", $data);
			}
			else {
				$data["title"] = "Error";
				$data["content"] = "Silme işlemi gerçekleştirilemedi.";
				$this->load->view("admin/information_view.html", $data);
			}
		}
		else
			noEntry();
	}

	public function commentSetVisible($commentID)
	{
		if(doesEntry()) // giris yapilmis mi
		{
			$update = $this->posts_model->commentSetVisible($commentID);
			if ($update) {
				$data["title"] = "Başarılı";
				$data["content"] = "Yorumun görünümü onaylandı.";
				$this->load->view("admin/information_view.html", $data);
			}
			else {
				$data["title"] = "Error";
				$data["content"] = "Onay işlemi gerçekleştirilemedi.";
				$this->load->view("admin/information_view.html", $data);
			}
		}
		else
			noEntry();
	}

	public function commentSetInvisible($commentID)
	{
		if(doesEntry()) // giris yapilmis mi
		{
			$update = $this->posts_model->commentSetInvisible($commentID);
			if ($update) {
				$data["title"] = "Başarılı";
				$data["content"] = "Yorum gizlendi.";
				$this->load->view("admin/information_view.html", $data);
			}
			else {
				$data["title"] = "Error";
				$data["content"] = "Yorum gizleme işlemi gerçekleştirilemedi.";
				$this->load->view("admin/information_view.html", $data);
			}
		}
		else
			noEntry();
	}

	public function logOut()
	{
		if(doesEntry()) // giris yapilmis mi
		{
			$this->session->unset_userdata('username');
			$this->session->unset_userdata('logged_in'); //session silinir

			$data["posts"] = $this->posts_model->getAllPosts();		
			$data["categories"] = $this->posts_model->getCategories();
			$data["about"] = $this->posts_model->getAbout();
			$data["categoryOfPosts"] = $this->posts_model->getCategoryOfAllPosts();	

			$header["title"] = "Anasayfa"; 
			$this->load->view('template/header.html', $header);
			$this->load->view('/template/index.html', $data);
			$this->load->view('template/footer.html');				
		}
		else
			noEntry();
	}
}

 ?>