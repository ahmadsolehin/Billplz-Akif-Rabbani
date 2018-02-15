<?php

// billplz api
// akifrabbani, 2016.

class BillplzApiv3 {

	public $api_key = false;
	public $url = "https://www.billplz.com/api/v3/";
	public $callback_url = false;

	function __construct($api_key, $callback_url = false) {
		$this->api_key = $api_key;
		$this->callback_url = $callback_url;
	}

	function create_bill($collection_id, $amount, $description, $name, $email = false, $phone = false, $redirect_url = false, $callback_url = false) {
		$amount = $amount * 100;

		$command = ["collection_id" => $collection_id, "description" => $description, "name" => $name, "amount" => $amount];
		if ($phone) {
			$command['phone'] = $phone;
		}

		if ($email) {
			$command['email'] = $email;
		}

		if ($redirect_url) {
			$command['redirect_url'] = $redirect_url;
		}

		if ($this->callback_url) {
			$command['callback_url'] = $this->callback_url;
		}

		if ($callback_url) {
			$command['callback_url'] = $callback_url;
		}


		//print_r($command);
		return json_decode($this->execute('bills', $command));
	}

	function get_bill($bill_id) {
		return json_decode($this->execute('bills/'.$bill_id, [], "GET"));
	}	

	function execute($endpoint, $command = [], $type = "POST") {

		$ch = curl_init();
		$fields_string = '';

		if (count($command)) {
			foreach ($command as $key => $value) {
				$fields_string .= $key . '=' . $value . '&';
			}

			rtrim($fields_string, '&');
			curl_setopt($ch, CURLOPT_POST, count($command));
			curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
		}


		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_USERPWD, $this->api_key . ":");
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $type);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_URL, $this->url . $endpoint);


		//execute post
		if (!$result = curl_exec($ch)) {
			die(curl_error($ch));
		}

		//close connection
		curl_close($ch);

		return $result;
	}
}