<?php
class filterValidatorLib{
	public function __construct(){}

	public static function filterRequest($request, $indice = null){
		foreach ($request as $indice => $value){
			if (is_array($value)){
				filterValidatorLib::filterRequest($value);
			}else{
				$request[$indice] = utf8_decode($value);
			}
		}
		return $request;
	}

	public static function formatDate($data, $type = 'en'){
		if ($type == 'en'){
			$arrData 	= explode("/", $data);
			$data 		= implode("-", array_reverse($arrData));
		}else if ($type == 'br'){
			$arrData 	= explode("-", $data);
			$data 		= implode("/", array_reverse($arrData));
		}
		return $data;
	}
}
?>