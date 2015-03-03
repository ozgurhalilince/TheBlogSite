<?php 

	function loginInputControl($id, $pw)
	{
		if (empty($id) || empty($pw)) // id veya pw bos olamaz
			return false;
		elseif (strlen($id) > 10 || strlen($pw) > 10) //id veya pw'nin uzunlugu 8'den buyuk olamaz 
			return false;
		elseif (strlen($id) < 4 || strlen($pw) < 4) //id veya pw'nin uzunlugu 4'ten kucuk olamaz
			return false;
		elseif (!ctype_alnum($id) || !ctype_alnum($pw)) // id veya pw sadece harf ve rakam içerebilir.
			return false;
		return true;
	}

	function doesEntry()	//giris yapilmis mi?
	{
		$CI =& get_instance();
    	$username = $CI->session->userdata('username'); 
		$logged_in = $CI->session->userdata('logged_in');
		
		if(!empty($username))
			if ($logged_in) //giriş yapılmış
				return true;		
		return false;		
	}

	function noEntry()	//yetki yok
	{
		$CI = &get_instance();
		$data["title"] = "Error";
		$data["content"] = "Bu sayfaya girmeye yetkiniz bulunmamaktadır.";
		$CI->load->view("admin/yetkiyok_view.html", $data);
	}

	function permalink($string)	//link oluşturmak için yardımcı
	{
		$find = array('Ç', 'Ş', 'Ğ', 'Ü', 'İ', 'Ö', 'ç', 'ş', 'ğ', 'ü', 'ö', 'ı', '+', '#');
		$replace = array('c', 's', 'g', 'u', 'i', 'o', 'c', 's', 'g', 'u', 'o', 'i', 'plus', 'sharp');
		$string = strtolower(str_replace($find, $replace, $string));
		$string = preg_replace("@[^A-Za-z0-9\-_\.\+]@i", ' ', $string);
		$string = trim(preg_replace('/\s+/', ' ', $string));
		$string = str_replace(' ', '-', $string);
		return $string;
	}

 ?>