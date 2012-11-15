<?php

class LibraryHelper
{
	private $key;
	private $allowed_cover_sizes = array('small', 'medium', 'large');

	public function __construct($key)
	{
		$this->key = $key;
	}

	public function get_work($search)
	{
		$base_url = "http://www.librarything.com/services/rest/1.1/?method=librarything.ck.getwork&apikey=$this->key&";

		$url = $this->url_builder($base_url, $search);

		$data = $this->pull_data($url);
		$response = $this->parse_response($data);

		return $response;
	}

	public function get_cover_url($isbn, $size='medium')
	{
		if (!in_array($size, $this->allowed_cover_sizes))
		{
			return false;
		}

		$url = "http://covers.librarything.com/devkey/$this->key/medium/isbn/$isbn";

		return $url;
	}

	public function get_book_language($isbn, $display=false)
	{
		$url = "http://www.librarything.com/api/thingLang.php?isbn=$isbn";
		
		if ($display)
		{
			$url .= '&display=name'; 
		}

		$response = $this->pull_data($url);

		if (strpos($response, 'invalid'))
		{
			return false;
		}
		else
		{
			return $response;
		}
	}

	public function what_work($search)
	{
		$base_url = 'http://www.librarything.com/api/whatwork.php?';

		$url = $this->url_builder($base_url, $search, false, true);

		$data = $this->pull_data($url);
		$response = $this->parse_response($data);

		if (isset($response->error))
		{
			return $response->error;
		}
		else
		{
			return $response;
		}
	}

	public function search_title_isbn($title)
	{
		if (!$title)
		{
			$title = $this->title;
		}

		$url_title = urlencode($title);

		$url = "http://www.librarything.com/api/thingTitle/$url_title";

		$data = $this->pull_data($url);
		$response = $this->parse_response($data);

		if (isset($response->isbn))
		{
			return $response;
		}
		else
		{
			return false;
		}
	}

	public function isbn_check($isbn=false)
	{
		if (!$isbn)
		{
			$isbn = $this->isbn;
		}

		$url = "http://www.librarything.com/isbncheck.php?isbn=$isbn";

		$data = $this->pull_data($url);
		$response = $this->parse_response($data);

		if (isset($response->error))
		{
			return $response->error;
		}
		else
		{
			return $response;
		}
	}

	private function url_builder($base_url, $additons, $tail_url=false, $replace_spaces=false)
	{
		$url = $base_url;

		foreach ($additons as $k => $v)
		{
			if ($replace_spaces)
			{
				$v = str_replace(' ', '+', $v);
			}
			$url .= $k.'='.$v.'&';
		}

		if ($tail_url)
		{
			$url .= $tail_url;
		}

		return $url;

	}

	private function pull_data($url)
	{
		$context = stream_context_create(array('http' => array(
				'timeout' => '5' // Timeout in seconds
	            )));

		$contents = file_get_contents($url, 0, $context);

		return $contents;
	}

	private function parse_response($raw, $type='xml')
	{
		if ($type == 'xml')
		{
			$parsed = simplexml_load_string($raw);
		}
		elseif ($type == 'json')
		{
		   	$parsed = json_decode($raw);
		}

		return $parsed;
	}
}