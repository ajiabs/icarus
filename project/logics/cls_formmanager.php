<?php 
// +----------------------------------------------------------------------+
// | File name : CMS	                                          		  |
// | 					 	  |
// | PHP version >= 5.2                                                   |
// +----------------------------------------------------------------------+
// +----------------------------------------------------------------------+
// | Copyrights Armia Systems  2010                                    |
// | All rights reserved                                                  |
// +----------------------------------------------------------------------+
// | This script may not be distributed, sold, given away for free to     |
// | third party, or used as a part of any internet services such as      |
// | webdesign etc.                                                       |
// +----------------------------------------------------------------------+

class FormManager {
	
	public $formElements 		= array();
	public $formProperties 		= array();
	public $validationJsCode 	= '';
	public $formId;
	
	public function  __construct($arrForm = array()) {
		$this->formProperties	= $arrForm;
		$this->formId = $arrForm['id'];
		
    }
	
	/*
	 * function to assign the form fields
	 */
	public function addFields($formelements){
		 $this->formElements 	= $formelements;
	}
	
	/*
	 * function to render the form
	 */
	public function renderForm($fields = array()){
		$formFields 	= $this->formElements;
		$formStarttag 	= $this->generateFormProperites($this->formProperties);
		$formElements 	= $formStarttag;
		foreach($formFields as $key=>$fields) {
			$type = $fields['type'];			
			$formElements.= $this->generateFormField($type,$fields);
		}
		$formEndTag 	= '</form>'.$this->validationJsCode;
		$formElements  .= $formEndTag;
	 	return $formElements;
	}
	
	/*
	 * function to genertate the form fields
	 */
	public function generateFormField($field,$params = array()){
		$formElements = ''; 
		if($field != ''){
		 	if($field == 'text') { 			// textbox field processing
		 		$formElements = $this->generateField($field,$params);
		 		$formField = '<div>'.$formElements.'</div>';
		 	}
		 	else if($field == 'password') { // password field processing
		 		$formElements = $this->generateField($field,$params);
		 		$formField = '<div>'.$formElements.'</div>';
		 	}
		 	else if($field == 'submit') { // submit button field processing
		 		$formElements = $this->generateField($field,$params);
		 			$formField =  $formElements ;
		 	}
		 	else if($field == 'button') { // normal button field processing
		 		$formElements = $this->generateField($field,$params);
		 		$formField =  $formElements ;
		 	}
		 	else if($field == 'textarea') { // text area field processing
		 		$formElements = $this->generateTextArea($field,$params);
		 		$formField = '<div>'.$formElements.'</div>';
		 	}
		 	else if($field == 'hidden') { // hidden field processing
		 		$formElements = $this->generateField($field,$params);
		 		$formField = '<div>'.$formElements.'</div>';
		 	}
		 	else if($field == 'select') { // hidden field processing
		 		$formElements = $this->generateSelectField($field,$params);
		 		$formField = '<div>'.$formElements.'</div>';
		 	}
		 	else if($field == 'checkbox') { // hidden field processing
		 		$formElements = $this->generateCheckBoxField($field,$params);
		 		$formField = '<div>'.$formElements.'</div>';
		 	}
		 	else if($field == 'file') { 			// file field processing
		 		$formElements = $this->generateField($field,$params);
		 		$formField = '<div>'.$formElements.'</div>';
		 	}
		 }
		 return $formField;
	}
	
    /*
     * function to create labels
     */
	public function createLabel($arrLabel){
		return '<label class="'.$arrLabel['class'].'">'.$arrLabel['message'].'</label>';	
	}
	
	/*
	 * function to generate the field.
	 * It also processes the validation code.
	 */
	public function generateField($type,$arrPwdParams){
		$fieldStart = '<input  ';
		if(sizeof($arrPwdParams) > 0) {
			foreach($arrPwdParams as $key=>$params){
				if($key == 'label')
					$label = $this->createLabel($params);
				else if($key == 'validations'){
					$arrValCode = $this->createValidationsCode($arrPwdParams['name'],$params);
					$paramValidations = $arrValCode[0];
				}
				else{
					if($key == 'class') 
						$paramClass = $params;
					else
						$parameters .= $key.'="'.$params.'" ';
				}
			}
		}
		$fieldClassed 	= 'class="'.$paramClass.' '.$paramValidations.'"';
		$fieldEnd		= $fieldClassed.'>'.$arrValCode[1];
  		return $label.$arrValCode[2].$fieldStart.$parameters.$fieldEnd;
		
	}
	
	/*
	 * function to generate the text areas
	 */
	public function generateTextArea($type,$arrPwdParams){
		$fieldStart = '<textarea ';
		if(sizeof($arrPwdParams) > 0) {
			foreach($arrPwdParams as $key=>$params){
				if($key == 'label')
					$label = $this->createLabel($params);
				else if($key == 'validations'){
					$arrValCode = $this->createValidationsCode($arrPwdParams['name'],$params);
					$paramValidations = $arrValCode[0];
				}
				else{
					if($key == 'class') 
						$paramClass = $params;
					else
						$parameters .= $key.'="'.$params.'" ';
				}
			}
		}
		$fieldClassed 	= 'class="'.$paramClass.' '.$paramValidations.'"';
		$fieldEnd		= $fieldClassed.'></textarea>'.$arrValCode[1];
  		return $label.$arrValCode[2].$fieldStart.$parameters.$fieldEnd;
	}
	
	
	/*
	 * function to generate the  select box
	 */
	public function generateSelectField($type,$arrParams){
		$fieldStart = '<select ';
		if(sizeof($arrParams) > 0) {
			foreach($arrParams as $key=>$params){
				if($key == 'label')
					$label = $this->createLabel($params);
				else if($key == 'validations'){
					$arrValCode = $this->createValidationsCode($arrParams['name'],$params);
					$paramValidations = $arrValCode[0];
				}
				else if($key =='options')  
					 $selectOptions = $this->createSelectOptions($params);
				else{
					if($key == 'class') 
						$paramClass = $params;
					else
						$parameters .= $key.'="'.$params.'" ';
				}
			}
		}
		$fieldClassed 	= 'class="'.$paramClass.' '.$paramValidations.'"';
		$fieldEnd		= $fieldClassed.'>'.$selectOptions.'</select>'.$arrValCode[1];
  		return $label.$arrValCode[2].$fieldStart.$parameters.$fieldEnd;
	}

	/*
	 * function to generate the select box options
	 */
	public function createSelectOptions($options){
		$optionText = '';
		if(sizeof($options) >0){	
			foreach($options as $key=>$option){
				$optionText .= '<option ';
 				foreach($option as $sleKey=>$selOption)  
 					$optionText .= $sleKey.'="'.$selOption.'" ';
 				$optionText .= '>'.$key.'</option>';		
			}
		}
		return $optionText;
	}
	
	
	/*
	 * function to generate the form with the form properties
	 */
	public function generateFormProperites(){
		$formProperties  = $this->formProperties;
		$formTags = '<form ';
		if(sizeof($formProperties) > 0) {
			foreach($formProperties as $key=>$params){
				$formTags .= $key.'="'.$params.'" ';
			}
		}
		$formTags		.= '>';
		return $formTags;
	}
	
	
	
	/*
	 * function to generate the check boxes
	 */
	public function generateCheckBoxField($type,$arrParams){ 
		$checkLabel 		= $arrParams['label'];
		$checkOptions 		=  $arrParams['options'];
		$label 				= $this->createLabel($checkLabel);
		$validationClass 	= $this->createValidationsCode($arrParams['name'],$arrParams['validations']);
		$validation 		= ' class="'.$validationClass[0].'"';
		$checkbox 			= '';
		foreach($checkOptions as $checkName=>$options) {
			$checkbox .= '<input type="checkbox" name="'.$arrParams['name'].'"  '.$validation;
			$validation = '';
			foreach($options as $key=>$option){
				$checkbox .= $key.'="'.$option.'" ';
			}
			$checkbox .= '> '.$checkName;		
		}
		$checkbox .= $validationClass[1];
		return $label.$checkbox;
	}

	
	
	/*
	 * function to generate the js validation codes
	 */
	public function createValidationsCode($fieldName,$validation){
		
 		$validations 	= $validation['options'];
 		$errorClass 	= $validation['class'];
		if(sizeof($validations) > 0){	
			if($this->validationJsCode == ''){
				$this->validationJsCode='<script type="text/javascript">
					$(document).ready(function() { $("#'.$this->formId.'").validate({meta: "validate"}); }); </script>';
			}
			foreach($validations as $key=>$items){
				if($key == 'required')
					$mandate = '<span class="mandatory">*</span>';
				$validateCode .= $key.':'.$items[0].',';
				$validateMsg  .= $key.":'".$items[1]."',";
			}
		}
		$arrValidation[0] 	= ' {validate:{'.$validateCode.' messages:{'.$validateMsg.'}}}';	
		$arrValidation[1]  	= '<div class="'.$errorClass.'"><label class="error" for="'.$fieldName.'" generated="true"></label></div>';
		$arrValidation[2]	= $mandate;
		return $arrValidation;
	}
 }



 /*
  * class to validate the form object
  */

class formValidator extends FormManager {
	public $formFields 		= array();
	public $validMessage 	= array();
	
	public function  __construct() {
    }
    
    /*
     * function to validate the form element
     */
    public function validate($formFields){
    	$this->formFields 	= $formFields;
    	if(sizeof($formFields) > 0) {
    		foreach($formFields as $fieldType=>$fields) {		// iterate the form fields
    			$fieldName 		= $fields['name'];
    			$validations 	= $fields['validations']['options'];
      			if(sizeof($validations) > 0 ){		// check whether the field has a validation or not
    				$fieldValue = $_POST[$fieldName];
    				foreach($validations as $key=>$messages) {
    					switch($key){				// validate the fields
    						case 'required':
    							if($fieldType == 'file')	// check the input field is file or not
    								$message = $this->checkFileRequired($fieldName,$messages[1]);
    							else
    								$message = $this->checkRequired($fieldValue,$messages[1]);
    							break;
    						case 'email':
    							$message = $this->validateEmail($fieldValue,$messages[1]);
    							break;
    						case 'accept':
    							$message = $this->validateFile($fieldName,$messages);	
    					}
    					if($message){
    						$validMessage['messages'][] = $message;
    						$validMessage['error']		= 1;
    					}
    				}
    			}
    		}
     	}
    	return $validMessage;
    }
    
    
    /*
     * function to validate the filed value is blank or not
     */
  	public function checkRequired($value,$messages) {
        if($value=="")
            return  $messages;
    }
    
    
    /*
     * function to validate the file field is entered or not
     */
   	public function checkFileRequired($fileName,$messages) {
		if($fileName != '') {
    		$file = $_FILES[$fileName]; 
    		if($file['name'] == '')
    			return $messages;
      	}
    }
    
    /*
     * function to validate the input value is an email or not
     */
    public function validateEmail($email,$messages) {
        if(!eregi('^[a-zA-Z0-9._-]+@[a-zA-Z0-9-]+\.[a-zA-Z]{2,4}(\.[a-zA-Z]{2,3})?(\.[a-zA-Z]{2,3})?$', $email))
            return  $messages;
    }
    
    
    /*
     * function to validate the file field
     */
    public function validateFile($fileName,$messages){
    	if($fileName != '') {
    		$file = $_FILES[$fileName];
	    	if($file['name'] != '') {
				$ext 			= pathinfo($file['name'], PATHINFO_EXTENSION);
    			$allowedExts 	= str_replace('\'','',$messages[0]);
    			$extensions 	= explode('|',$allowedExts);
    	 		if (!in_array($ext, $extensions)) {
    	 			return $messages[1];
    	 		}
    		}
    	}
    }
    
    
}

?>