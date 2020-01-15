<?php
	function validateUsername(&$errors, $field_list, $field_name)
	{	
		$pattern = "/^[a-zA-Z'-]+$/"; // format nama (alfabet)
		if (!isset($field_list[$field_name]) || empty($field_list[$field_name]))
			$errors[$field_name] = 'kolom harus diisi';
		else if (!preg_match($pattern, $field_list[$field_name]))
			$errors[$field_name] = 'kolom harus hanya berisi alfabet';
	}
	function validateEmail(&$errors, $field_list, $field_name)
	{
		if (!isset($field_list[$field_name]) || empty($field_list[$field_name]))
			$errors[$field_name] = 'kolom harus diisi';
		else if (!filter_var($field_list[$field_name], FILTER_VALIDATE_EMAIL))
			$errors[$field_name] = "invalid email address";
	}
	function validatePass(&$errors, $field_list, $field_name)
	{
        $pattern = "/^[a-zA-Z0-9]+$/";
		if (!isset($field_list[$field_name]) || empty($field_list[$field_name]))
			$errors[$field_name] = 'kolom harus diisi';
        elseif (!preg_match($pattern, $field_list[$field_name]))
        	$errors[$field_name] = "password harus berupa huruf dan angka";
		else if (strlen($field_list[$field_name]) < 6) 
			$errors[$field_name] = "password entered was not 6 digits long";
	}
	function validateNomorInduk(&$errors, $field_list, $field_name) {
		$pattern = "/^[0-9]+$/"; // format NomorInduk(numerik)
		if (!isset($field_list[$field_name]) || empty($field_list[$field_name]))
			$errors[$field_name] = 'kolom harus diisi';
		elseif (!preg_match($pattern, $field_list[$field_name]))
			$errors[$field_name] = 'kolom hanya berisi numerik';
		elseif (strlen($field_list[$field_name]) < 6)
			$errors[$field_name] = "nomor induk yang dimasukkan minimal harus 6 digit";
	}
	function validateInputanAlfabetSpasi(&$errors, $field_list, $field_name) {
		$pattern = "/^[a-zA-Z ]*$/"; // format Inputan Umum(alfabet dengan spasi)
		if (!isset($field_list[$field_name]) || empty($field_list[$field_name]))
			$errors[$field_name] = 'kolom harus diisi';
		elseif (!preg_match($pattern, $field_list[$field_name]))
			$errors[$field_name] = 'kolom hanya berisi alfabet dengan spasi';
	}
	function validateInputanAlfabetNomorSpasi(&$errors, $field_list, $field_name) {
		$pattern = "/^[a-zA-Z0-9 ]*$/"; // format Inputan Umum(alfabet, numerik, spasi)
		if (!isset($field_list[$field_name]) || empty($field_list[$field_name]))
			$errors[$field_name] = 'kolom harus diisi';
		elseif (!preg_match($pattern, $field_list[$field_name]))
			$errors[$field_name] = 'kolom hanya berisi alfabet,nomor,spasi';
	}
?>