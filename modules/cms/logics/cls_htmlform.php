<?php
// +----------------------------------------------------------------------+
// | File name : CMS	                                          		  |
// |(AUTOMATED CUSTOM CMS LOGIC)					 	  |
// | PHP version >= 5.2                                                   |
// +----------------------------------------------------------------------+
// | Author: ARUN SADASIVAN<arun.s@armiasystems.com>              		  |
// +----------------------------------------------------------------------+
// | Copyrights Armia Systems Ã¯Â¿Â½ 2010                                    |
// | All rights reserved                                                  |
// +----------------------------------------------------------------------+
// | This script may not be distributed, sold, given away for free to     |
// | third party, or used as a part of any internet services such as      |
// | webdesign etc.                                                       |
// +----------------------------------------------------------------------+

class Htmlform {
    public $method;
    public $action;
    public $formName;
    public $handleFile=false;
    public $class;
    public $id;
    public $preaction;
    public $formElements = array();
    public $form_title;
    public $form_error_message;
    public $displayMethod;



    public function renderForm() {


        $displayMethod  =   $this->displayMethod;


        if($this->handleFile)
            $enctype="enctype=multipart/form-data";
        echo $formData   =   '<form name="'.$this->name.'" id="jqCmsForm" method="'.$this->method.'" action="'.$this->action.'" class="form-horizontal'.$this->class.'" '.$enctype.' >';
        if($this->form_title) {
            if($displayMethod=="popup") {
                echo $formData = '<div class="modal-header"><span class="legend formhd_popup">'.$this->form_title.'</span></div>';
            }
            else {
                echo $formData = '<span class="legend formhd_popup">'.$this->form_title.'</span>';
            }
        }
        if($displayMethod=="popup") {
            echo $formData = '<div class="modal-body">';
        }
        if($this->form_error_message) echo  '    <div class="container container-lg animated fadeInDown"><div class="panel"><div class="panel-body"><p class="lead text-center text-bold"> <h4>Error!</h4></p><p class="text-center">'.$this->form_error_message.' </p></div></div></div>';
        echo $formData   = "<input type='hidden' id='jqSectionName' name='sectionName'><input type='hidden' id='jqFormMethodType' name='jqFormMethodType'>" ;
        for($loop=0;$loop<count($this->formElements);$loop++) {

            //pre html
            if(!$primaryId)
            $primaryId  =   $this->formElements[$loop]->primaryKeyValue;
            echo $formData   =  $this->formElements[$loop]->prehtml;
            if($this->formElements[$loop]->type!="hidden")
                echo  '<div class="control-group">';

            //element
            if($this->formElements[$loop]->label) {

                echo   $this->addLabel($this->formElements[$loop]);
            }
            if($this->formElements[$loop]->type=="textbox") {
                if($this->formElements[$loop]->onEdit=="disable"){
            		echo   $this->addDisabledTextboxField($this->formElements[$loop]);
            	}
            	else{
                	echo   $this->addTextbox($this->formElements[$loop]);
            	}
            }else if($this->formElements[$loop]->type=="hidden")
                echo   $this->addHiddenField($this->formElements[$loop]);
            else if($this->formElements[$loop]->type=="textarea") {
                echo   $this->addTextarea($this->formElements[$loop]);
            }
            else if($this->formElements[$loop]->type=="htmlEditor") {
                echo '<div class="controls">'. $this->addHtmlEditor($this->formElements[$loop]).'</div>';
            }
            else if($this->formElements[$loop]->type=="select") {
                echo   $this->addSelectBox($this->formElements[$loop],$this->formElements[$loop]->primaryKeyValue);
            }
            else if($this->formElements[$loop]->type=="checkbox") {
                echo   $this->addCheckbox($this->formElements[$loop]);
            }
            else if($this->formElements[$loop]->type=="password") {
                echo   $this->addPasswordField($this->formElements[$loop]);
            }
            else if($this->formElements[$loop]->type=="file") {
                echo   $this->addFileField($this->formElements[$loop]);
            }
            else if($this->formElements[$loop]->type=="datepicker") {
                echo   $this->addDatepicker($this->formElements[$loop]);
            }
            else if($this->formElements[$loop]->type=="autocomplete") {

                echo   $this->addAutoCompleteField($this->formElements[$loop]);
            }
            else if($this->formElements[$loop]->type=="radio") {

                echo   $this->addRadio($this->formElements[$loop]);
            }

            else if($this->formElements[$loop]->type=="disabled") {

                echo   $this->addDisabledTextboxField($this->formElements[$loop]);
            }
            else if($this->formElements[$loop]->type=="tags") {
            	echo   $this->addTags($this->formElements[$loop]);
            }
            if($this->formElements[$loop]->type!="hidden")
                echo '</div>';
            //post html
            echo   $this->formElements[$loop]->posthtml;

        }
        if($displayMethod=="popup") {
            echo $formData = '</div>';
        }
        if($displayMethod=="popup") {
            echo $formData = ' <div class="modal-footer">';
        }
        echo    $this->addSubmitButton($this->formElements[$loop],$displayMethod);
        if($displayMethod=="popup") {
            echo $formData = ' </div >';
        }
         echo "<input type='hidden' id='jqPrimaryId' name='primary_key_value' value=".$primaryId.">";

        echo    '</form>';
//      /  echo $formData;

    }

    public function getElements($sectionConfig) {

        foreach($sectionConfig->columns as  $key => $val) {

            if($val->editoptions) {

                $objFormElement = new Formelement();
                $objForm->formElements[]        =   $objFormElement->addElement($key,$val);

            }
        }
        echopre($objForm->formElements);
    }

    public function addElement(Formelement $objFormElement) {
        array_push($this->formElements,$objFormElement);
    }

    public function addLabel($labelElement) {

        return '<label class="control-label" for="'.$labelElement->id.'">'.$labelElement->label.'</label>';

    }
    public function addTextbox($textboxElement) {

        if(in_array('required',$textboxElement->validations)) {
            $validationClass="required";
            $mandatory='<span class="mandatory">*</span>';
        }

        if($textboxElement->hint)
            $hint   =   '<a href="#" class="tooltiplink" data-original-title="'.$textboxElement->hint.'"><span class="help-icon"><img src="'.BASE_URL.'modules/cms/app/img/help_icon.png"><span></a>';

        if($textboxElement->width)
            $style .= "width:".$textboxElement->width.";";
        return '<div class="controls"><input style="'.$style.'" placeholder="'.$textboxElement->placeholder.'" type="text" id="'.$textboxElement->id.'" name="'.$textboxElement->name.'" value="'.$textboxElement->value.'" class="'.$validationClass.'">'.$mandatory.$hint.'</div>';

    }
    public function addPasswordField($textboxElement) {

        if(in_array('required',$textboxElement->validations)) {
            $validationClass="required";
            $mandatory='<span class="mandatory">*</span>';
        }

        return '<div class="controls"><input type="password" id="'.$textboxElement->id.'" name="'.$textboxElement->name.'" value="" class="'.$validationClass.'">'.$mandatory.$hint.'</div>';

    }
    public function addHiddenField($hiddenElement) {


        return '<input type="hidden" id="'.$hiddenElement->id.'" name="'.$hiddenElement->name.'" value="'.$hiddenElement->value.'">';

    }
    public function addTextarea($textareaElement) {
        if(in_array('required',$textareaElement->validations)) {
            $validationClass="required";
            $mandatory='<span class="mandatory">*</span>';
        }
        if($textareaElement->onEdit=="disable"){
        	$readonly = ' readonly=readonly ';
        }

        if($textareaElement->hint)
            $hint   =   '<a href="#" class="tooltiplink" data-original-title="'.$textareaElement->hint.'"><span class="help-icon"><img src="'.BASE_URL.'modules/cms/app/img/help_icon.png"><span></a>';
        // echo $mandatory;
		return '<div class="controls"><textarea id="'.$textareaElement->id.'" name="'.$textareaElement->name.'" class="'.$validationClass.'" rows="7" cols="20" '.$readonly. '>'.$textareaElement->value.'</textarea>'.$mandatory.$hint.'</div>';

    }
    public function addHtmlEditor($textareaElement) {
        //TODO
        //echopre($textareaElement);
        if(in_array('required',$textareaElement->validations))
            $validationClass="required";
        //$string  =   '<div class="controls"><textarea id="FCKeditor1" name="'.$textareaElement->name.'" class="htmleditor '.$validationClass.'">'.$textareaElement->value.'</textarea></div>';

        //'<script type="text/javascript" src="'.BASE_URL.'/lib/FCKeditor/fckeditor.js"></script>'
        //$string  =   '<div class="controls"><textarea id="mytext" name="mytext" class="htmleditor '.$validationClass.'">'.$textareaElement->value.'</textarea></div>';
        if($textareaElement->editorType == 'ckeditor'){
        	$string = '<script type="text/javascript" src="'.BASE_URL.'public/ckeditor/ckeditor.js">
        			jQuery(document).ready(function($){

           CKEDITOR.replace( "'.$textareaElement->name.'", {
           //filebrowserBrowseUrl : "'.BASE_URL.'public/ckeditor/ckfinder/ckfinder.html",
          // filebrowserImageBrowseUrl :"'.BASE_URL.'public/ckeditor/ckfinder/ckfinder.html?Type = Images",
          // filebrowserUploadUrl : "'.BASE_URL.'public/ckeditor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files",
          // filebrowserImageUploadUrl : "'.BASE_URL.'public/ckeditor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images"
           });

           CKEDITOR.config.width = 700;
           CKEDITOR.config.height = 300;
           CKEDITOR.config.fullPage = false;});
        			</script>';
        	$string  .= '<textarea id="'.$textareaElement->name.'" name="'.$textareaElement->name.'" class="htmleditor ckeditor '.$validationClass.'" rows="10" cols="10"  style="max-width:350px;">'.stripslashes(trim($textareaElement->value)).'</textarea>';

        	return $string;
        /* include_once "public/ckeditor/ckeditor.php" ;
        $sBasePath                              = "public/ckeditor/";
        $oFCKeditor 				= new CKEditor() ;
        $oFCKeditor->basePath			=  $sBasePath;
        $oFCKeditor->config['width']  	= '740' ;
        $oFCKeditor->config['height']	= '300' ;
        $oFCKeditor->config['allowedContent'] = true;
//         $config['toolbar'] = 'Full';
//         $config['skins'] = 'moono';
    	$config['resize_enabled '] = true;
//     	$config['resize_dir '] = 'vertical';
        $oFCKeditor->editor($textareaElement->name, stripslashes(trim($textareaElement->value)), $config);
        //return $string; */
        }
        else{
        	include_once "public/fckeditor/fckeditor.php" ;
        	$sBasePath                              = "public/fckeditor/";
        	$oFCKeditor 				= new FCKeditor($textareaElement->name) ;
        	$oFCKeditor->Id				= $textareaElement->name;
        	$oFCKeditor->BasePath			=  $sBasePath;
        	$oFCKeditor->Value			=  stripslashes(trim($textareaElement->value));
        	$oFCKeditor->Width  			= '740' ;
        	$oFCKeditor->Height			= '400' ;
        	$oFCKeditor->Create() ;
        	//return $string;
        }
    }
    public function addCheckbox($checkboxElement) {

        if($checkboxElement->hint)
            $hint   =   '<a href="#" class="tooltiplink" data-original-title="'.$checkboxElement->hint.'"><span class="help-icon"><img src="'.BASE_URL.'modules/cms/app/img/help_icon.png"><span></a>';
        if(in_array('required',$checkboxElement->validations)) {
            $validationClass="required";
            $mandatory='<span class="mandatory">*</span>';
        }
                if($checkboxElement->default=="yes" && $checkboxElement->value==""){
            $checkedFlag    =   "checked=checked";

        }
        else if($checkboxElement->value==1){
            $checkedFlag    =   "checked=checked";

        }
        else{
            $checkedFlag    =   "";
            if($checkboxElement->onEdit=="disable"){
            	$readonly = ' disabled ';
            }
        }
        return '<div class="controls"><input type="checkbox" id="'.$checkboxElement->id.'" name="'.$checkboxElement->name.'" value="1" '.$checkedFlag.$readonly.'>'.$mandatory.$hint.'</div>';

    }
    public function addSelectBox($selectBoxtElement,$primaryKeyValue) {
        if($selectBoxtElement->hint)
            $hint   =   '<a href="#" class="tooltiplink" data-original-title="'.$selectBoxtElement->hint.'"><span class="help-icon"><img src="'.BASE_URL.'modules/cms/app/img/help_icon.png"><span></a>';
        if(in_array('required',$selectBoxtElement->validations)) {
            $validationClass="required";
            $mandatory='<span class="mandatory">*</span>';
        }
        if($selectBoxtElement->sourceType=="function") {
            $functionName   =  $selectBoxtElement->source;
            $options        =  call_user_func_refined($functionName,$primaryKeyValue);

        }
        else {
            $sourceArray        =   $selectBoxtElement->source;
            $loop    =   0;
            foreach($sourceArray as $key    => $val) {
                $options[$loop]->value  =  $key;
                $options[$loop]->text   =  $val;
                $loop++;
            }

        }
        $defaultOptionLabel = $selectBoxtElement->defaultOptionLabel?$selectBoxtElement->defaultOptionLabel:'Select';
        Logger::info($options);

        if($selectBoxtElement->onEdit=="disable"){
        	$readonly = ' readonly=readonly ';

        	$html   =   '<select disabled>';
//         	$html   .=   '<option value="">Select</option>';
        	$html   .=   '<option value="">'.$defaultOptionLabel.'</option>';
        	foreach($options as $value) {

        		$html   .=    '<option value="'.$value->value.'" ';
        		$selected = false;
        		$selectedOption =   $this->getSelectedOption($options,$selectBoxtElement->value);
        		if($selectBoxtElement->value!="") {
        			if($value->value==$selectedOption)
        				$html   .=    ' selected="selected"';
        		}
        		else {
        			if($value->value==$selectBoxtElement->default)
        				$html   .=    ' selected="selected"';
        		}

        		$html   .=    '>'.$value->text;
        		$html   .=    '</option>';
        	}
        	$html   .=    '</select>
        			<input type="hidden" id="'.$selectBoxtElement->id.'" name="'.$selectBoxtElement->name.'" value="'.$selectedOption.'">';
        }
        else{

        $html   =   '<select class="'.$validationClass.'" id="'.$selectBoxtElement->id.'" name="'.$selectBoxtElement->name.'">';
        $html   .=   '<option value="">Select</option>';
        foreach($options as $value) {

            $html   .=    '<option value="'.$value->value.'" ';
            $selected = false;
            $selectedOption =   $this->getSelectedOption($options,$selectBoxtElement->value);
            if($selectBoxtElement->value!="") {
                if($value->value==$selectedOption)
                    $html   .=    ' selected="selected"';
            }
            else {
                if($value->value==$selectBoxtElement->default)
                    $html   .=    ' selected="selected"';
            }

            $html   .=    '>'.$value->text;
            $html   .=    '</option>';
        }
        $html   .=    '</select>';
        }
        return '<div class="controls">'.$html.$mandatory.$hint.'</div>';

    }
    public function getSelectedOption($options,$selecctedValue) {

        $selecctedValueArray=explode("{valSep}", $selecctedValue);
        if(count($selecctedValueArray)>1) {
            $selecctedValue=$selecctedValueArray[1];
            foreach($options as $value) {


                if($value->value==$selecctedValue)
                    return $selecctedValue;
            }
            return 0;
        }
        else
            return $selecctedValue;
    }
    public function addFileField($fileElement,$width='60',$height='60') {
        if($fileElement->hint)
            $hint   =   '<a href="#" class="tooltiplink" data-original-title="'.$fileElement->hint.'"><span class="help-icon"><img src="'.BASE_URL.'modules/cms/app/img/help_icon.png"><span></a>';
        if(in_array('required',$fileElement->validations)) {
            $mandatory='<span class="mandatory">*</span>';
            $validationClass="required";
        }
        $fileString =   '<div class="controls"><input type="file" id="'.$fileElement->id.'" name="'.$fileElement->name.'" class="'.$validationClass.'">'.$mandatory.$hint;
        if($fileElement->value!="") {
//             $fileName       =   Cms::getImageName($fileElement->value);
//             $filePath       =   BASE_URL. 'project/files/'.$fileName;
//             if(!file_exists('project/files/'.$fileName))
//                 $filePath  =    BASE_URL. 'modules/cms/app/img/'."noImagePlaceholder.JPG";
//             $fileString     .=  '<ul class="thumbnails">
//                                     <li class="span3">
//                                         <a href="#" class="thumbnail">
//                                             <img src="'.$filePath.'" width="'.$width.'px" height="'.$height.'px">
//                                         </a>
//                                     </li>
//                                 </ul>';
        	$fileDetails   =   Cms::getImageName($fileElement->value);
        	$fileName = $fileDetails[0];
        	$fileType = $fileDetails[1];
        	$filePath       =   BASE_URL. 'project/files/'.$fileName;
        	if(!file_exists('project/files/'.$fileName)){
        		$fileType = "image/jpg";
        		$filePath  =    BASE_URL. 'modules/cms/app/img/'."noImagePlaceholder.JPG";
        	}
        	if(strstr($fileType, 'image')!== false){
        		$fileString     .=  '<a href="'.$filePath.'" class="thumbnail" target="new">
                                            <img src="'.$filePath.'" width="'.$width.'px" height="'.$height.'px">
                                        </a>';
        	}else{
        		//Something other than image
        		$fileString     .= "<div class='clearfix'><a href=".$filePath." target='_tab'>View</a></div>";
        	}
        }
        $fileString        .=  '</div>';
        return $fileString;

    }
    public function addDatepicker($dateElement) {
        //TODO
        if($dateElement->hint)
            $hint   =   '<a href="#" class="tooltiplink" data-original-title="'.$dateElement->hint.'"><span class="help-icon"><img src="'.BASE_URL.'modules/cms/app/img/help_icon.png"><span></a>';
        if(in_array('required',$dateElement->validations)) {
            $mandatory='<span class="mandatory">*</span>';
            $validationClass="required";
        }
        if($dateElement->type=="datepicker") {
            $date  =   $dateElement->value;
            if( $dateElement->value=="")
                $date = "";
            else {
            	if($dateElement->dbFormat=="date") {
            		$dateElement1 = date('Y-m-d H:i:s',strtotime($dateElement->value));
            		list($date1,$time)=explode(" ",  $dateElement1);
            		//                     list($date1,$time)=explode(" ", $dateElement->value);
            		list($year,$month,$day)=explode("-",$date1);
            		list($hour,$minute,$second)=explode(":",$time);

            		$time=mktime($hour,$minute,$second,$month,$day,$year);
            		//                     $timeArray=explode("-",$dateElement->value);

            		//                     $time=mktime(0,0,0,$timeArray[1],$timeArray[2],$timeArray[0]);
            		$date= date($dateElement->displayFormat,$time);

            	}
            	if($dateElement->dbFormat=="time") {
            		$dateElement1 = date('Y-m-d H:i:s',strtotime($dateElement->value));
            		list($date1,$time)=explode(" ",  $dateElement1);
            		//                     list($date1,$time)=explode(" ", $dateElement->value);
            		list($year,$month,$day)=explode("-",$date1);
            		list($hour,$minute,$second)=explode(":",$time);

            		$time=mktime($hour,$minute,$second,$month,$day,$year);
            		$date= date($dateElement->displayFormat,$time);
            		//                     $date = date($dateElement->displayFormat,$dateElement->value);
            	}
            	if($dateElement->dbFormat=="timestamp") {
            		$dateElement1 = date('Y-m-d H:i:s',strtotime($dateElement->value));
            		list($date1,$time)=explode(" ",  $dateElement1);
            		//                     list($date1,$time)=explode(" ", $dateElement->value);
            		list($year,$month,$day)=explode("-",$date1);
            		list($hour,$minute,$second)=explode(":",$time);

            		$time=mktime($hour,$minute,$second,$month,$day,$year);
            		$date= date($dateElement->displayFormat,$time);

            	}
            	if($dateElement->dbFormat=="datetime") {
            		$dateElement1 = date('Y-m-d H:i:s',strtotime($dateElement->value));
            		list($date1,$time)=explode(" ",  $dateElement1);
            		//                     list($date1,$time)=explode(" ", $dateElement->value);
            		list($year,$month,$day)=explode("-",$date1);
            		list($hour,$minute,$second)=explode(":",$time);

            		$time=mktime($hour,$minute,$second,$month,$day,$year);
            		$date= date($dateElement->displayFormat,$time);

            	}
//                 if($dateElement->dbFormat=="date") {
//                     $timeArray=explode("-",$dateElement->value);

//                     $time=mktime(0,0,0,$timeArray[1],$timeArray[2],$timeArray[0]);
//                     $date= date($dateElement->displayFormat,$time);

//                 }
//                 if($dateElement->dbFormat=="time") {

//                     $date = date($dateElement->displayFormat,$dateElement->value);
//                 }
//                 if($dateElement->dbFormat=="timestamp") {
//                     list($date1,$time)=explode(" ", $dateElement->value);
//                     list($year,$month,$day)=explode("-",$date1);
//                     list($hour,$minute,$second)=explode(":",$time);

//                     $time=mktime($hour,$minute,$second,$month,$day,$year);
//                     $date= date($dateElement->displayFormat,$time);

//                 }
//                 if($dateElement->dbFormat=="datetime") {

//                     list($date1,$time)=explode(" ",  $dateElement->value);
//                     list($year,$month,$day)=explode("-",$date1);
//                     list($hour,$minute,$second)=explode(":",$time);

//                     $time=mktime($hour,$minute,$second,$month,$day,$year);
//                     $date= date($dateElement->displayFormat,$time);

//                 }
            }
        }
        else
            $date  =   $dateElement->value;
        if($dateElement->onEdit=="disable"){
        	$readonly = ' readonly=readonly ';

        	$dateString     =   '<div class="controls"><input name="'.$dateElement->name.'" id="'.$dateElement->id.'" type="text"  value="'.$date.'" placeholder="Date" '.$readonly.'>'.$mandatory.$hint;
        	$dateString    .=  '</div>';
        }
        else{
        $dateString     =   '<div class="controls"><input name="'.$dateElement->name.'" id="'.$dateElement->id.'" type="text"  value="'.$date.'" placeholder="Date" class="textfield_date" >'.$mandatory.$hint;
        $dateString    .=  '</div>';
        }
        return $dateString;

    }
    public function addAutoCompleteField($inputElement) {

        if(in_array('required',$inputElement->validations)) {
            $mandatory='<span class="mandatory">*</span>';
            $validationClass="required";
        }
        if($inputElement->hint)
            $hint   =   '<a href="#" class="tooltiplink" data-original-title="'.$inputElement->hint.'"><span class="help-icon"><img src="'.BASE_URL.'modules/cms/app/img/help_icon.png"><span></a>';
        $inputElement->value    =   explode("{valSep}",$inputElement->value);
        $textValue  =   $inputElement->value[0];
        $hiddenValue  =   $inputElement->value[1];

        $inputString     =   '<div class="controls"><input name="'.$inputElement->name.'" id="'.$inputElement->id.'" type="text"  value="'.$textValue.'"  class="textfield ui-autocomplete-input">'.$mandatory.$hint;
        // hidden field to hold selected value
        $inputString    .=  '<input type="hidden" id="selected_'.$inputElement->id.'" name="selected_'.$inputElement->name.'" value="'.$hiddenValue.":".$textValue.'" >';
        // for storing source url , used in cms.js file
        $inputString    .=  '<input type="hidden" id="source_'.$inputElement->id.'" name="source_'.$inputElement->name.'" value="'.$inputElement->source.'">';
        $inputString    .=  '</div>';
        return $inputString;

    }
    public function addRadio($radioElement) {

        if($radioElement->hint)
            $hint   =   '<a href="#" class="tooltiplink" data-original-title="'.$radioElement->hint.'"><span class="help-icon"><img src="'.BASE_URL.'modules/cms/app/img/help_icon.png"><span></a>';
        if(in_array('required',$radioElement->validations)) {
            $validationClass="required";
            $mandatory='<span class="mandatory">*</span>';
        }


        foreach ($radioElement->options as $key=>$value) {
            $checkedFlag    =   "";
            if($radioElement->onEdit=="disable"){
            	$readonly = ' disabled ';
            }
            if($radioElement->default==$key && $radioElement->value==""){
                $checkedFlag    =   "checked=checked";
                $readonly = ' ';
            }
            else if( $radioElement->value==$key){
                $checkedFlag    =   "checked=checked";
                $readonly = ' ';
            }
            $radioButtonString .= '<label class="radio-inline"><input type="radio" class="left" name="'.$radioElement->name.'" value='.$key.' '.$checkedFlag.$readonly.'><span >'.$value.'</span></label>';
        }
        return '<div class="controls">'.$radioButtonString.$mandatory.$hint.'</div>';

    }
    public function addDisabledTextboxField($textboxElement) {


        return '<div class="controls"><input type="text" id="'.$textboxElement->id.'" name="'.$textboxElement->name.'" value="'.$textboxElement->value.'" readonly=readonly ></div>';

    }
    public function addSubmitButton($submitElement,$displayMethod) {


        if($displayMethod=="popup") {
            $buttonText =    '<div class="controls"> <input  aria-hidden="true" data-dismiss="modal" class="cancelButton btn" type="button" value="Cancel" name="cancel">&nbsp;';
        }
        else
            $buttonText =    '<div class="controls"> <input class="cancelButton btn" type="button" value="Cancel" name="cancel">&nbsp;';
        $buttonText .=       '<input class="submitButton btn jqSubmitForm" type="submit" value="Save" name="submit" id="jqSubmitForm">
                   </div>';
        return    $buttonText;

    }

    public function addTags($tagElement) {
    	//TODO
//     	echopre($tagElement);
    	if(in_array('required',$tagElement->validations)){
    		$validationClass="required";
    		$mandatory='<span class="mandatory" style="float:left;">*</span>';
    	}

    	if($tagElement->hint)
    		$hint   =   '<a href="#" class="tooltiplink" data-original-title="'.$tagElement->hint.'" style="float:left;"><span class="help-icon"><img src="'.BASE_URL.'modules/cms/app/img/help_icon.png"><span></a>';

    	if($tagElement->width)
    		$style .= "width:".$tagElement->width.";";

    	if($tagElement->tagDetails->autocompleteMinChars)
    		$minChar = $tagElement->tagDetails->autocompleteMinChars;
    	else
    		$minChar =1;

    	if($tagElement->tagDetails->tagDetails->placeholder)
    		$placeholder = $tagElement->tagDetails->placeholder;

//     	if($tagElement->tagDetails->autocompleteSource)
    		$tokenInputUrl = call_user_func_refined($tagElement->tagDetails->autocompleteSource,$tagElement->primaryKeyValue);

    	if($tagElement->tagDetails->prePopulateSource)
    		$prePopulateData = call_user_func_refined($tagElement->tagDetails->prePopulateSource,$tagElement->primaryKeyValue);

    	$string = '<script type="text/javascript">
    			jQuery(document).ready(function($){
    			//For multiselect textbox
    			$("#'.$tagElement->name.'").tokenInput("'.$tokenInputUrl.'", {
    					theme: "facebook",
    					preventDuplicates:true,
    					autocompleteCaching: false,
    					minChars:'.$minChar.',
    					placeholder :"'.$placeholder.'",
    					prePopulate: '.$prePopulateData.'
			    });
    			$(".token-input-list-facebook").css("float","left");
    			//$(".token-input-list-facebook").height(70);
    			//$(".token-input-list-facebook").width(210);
			    });
    			</script>';

    	$string  .= '<div class="controls"><input type="text" name="'.$tagElement->name.'" style="'.$style.'" class="'.$tagElement->class.' '.$validationClass.'"  id="'.$tagElement->name.'" value="" placeholder="'.$placeholder.'">'.$mandatory.$hint.'</div>';

    	return $string;
    }

}



class Formelement {
    public $type;
    public $name;
    public $value;
    public $default;
    public $sourceType;
    public $source;
    public $id;
    public $label;
    public $class;
    public $prehtml;
    public $posthtml;
    public $validations=array();
    public $hint;
    public $enumvalues;
    public $displayFormat;

    public function  __construct() {

    }
    public function addElement($element,$attributes) {

        $this->type     =   $attributes->editoptions->type;
        $this->name     =   $element;
        $this->id       =   $element;
        $elementArray   =   array();
        if($attributes->editoptions->hidden)            $elementArray['type']   =   $this->type;
        $elementArray['name']   =   $this->name;
        $elementArray['id']=$this->id;

        return $elementArray;
    }

}
class Formvalidation {
    public $field;
    public $successMessage;
    public $errorMessage;

    public function  __construct() {

    }
    public function validateForm($value,$name,$attributes) {
//echopre1($attributes);

        for($loop=0;$loop<count($attributes->validations);$loop++) {

            if($attributes->validations[$loop]=="required")
                $this->checkRequired($value,$name);
            if($attributes->validations[$loop]=="email")
                $this->validateEmail($value);
            if($attributes->validations[$loop]=="url")
                $this->validateURL($value,$name);
            if($attributes->validations[$loop]=="numeric")
                $this->validateNumber($value,$name);

            if($attributes->type=="file")
                $this->checkFileType($value,$attributes->file_types);

        }

        return $this->errorMessage;
    }
    public function checkFileType($value,$allowed_extensions='') {
        $ext = pathinfo($value, PATHINFO_EXTENSION);
        $fileHandler = new Filehandler();
        if($allowed_extensions=="")
            $allowed_extensions = array("gif", "jpeg", "jpg", "png","bmp");
        else {
            $allowed_extensions =   explode(",", $allowed_extensions);
        }

        if($value!="") {
            if (!in_array($ext, $allowed_extensions)) {
                return $this->errorMessage=" Invalid file format";
            }
        }
        return true;

    }
    public function checkRequired($value,$name) {

        if($value=="")
            return $this->errorMessage=$name." Field is mandatory";
        return true;
    	// if(trim($value)=="")
    	// 	return $this->errorMessage=$name." Field is mandatory";
    	// return true;
    }
    /*public function validateEmail($email) {
        if(eregi('^[a-zA-Z0-9._-]+@[a-zA-Z0-9-]+\.[a-zA-Z]{2,4}(\.[a-zA-Z]{2,3})?(\.[a-zA-Z]{2,3})?$', $email))
            return true;
        else
            return $this->errorMessage="Invalid email";
    }*/

    public function validateEmail($email) {
        if(preg_match("^[a-zA-Z0-9._-]+@[a-zA-Z0-9-]+\.[a-zA-Z]{2,4}(\.[a-zA-Z]{2,3})?(\.[a-zA-Z]{2,3})?$^", $email))
            return true;
        else
            return $this->errorMessage="Invalid email";
    }

    public function validateURL($url,$name) {


        if (preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$url))
            return true;
        else
            return $this->errorMessage="Invalid ".strtolower($name);
    }

    public function validateNumber($value,$name) {


        if (is_numeric($value))
            return true;
        else
            return $this->errorMessage="Invalid ".strtolower($name);
    }


}
?>
