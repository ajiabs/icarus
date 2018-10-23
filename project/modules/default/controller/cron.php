<?php
set_time_limit(0);
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class ControllerCron extends BaseController{
    public function init(){
        parent::init();
    }

    public function send_newsletter(){
        ini_set('memory_limit','512M');
        $dbh               = new Db();
    	  $currentDay        = date('Y-m-d');
        $newsletter_array  = array();
        $subscribers_array = array();

        $newsletter_array   = $dbh->selectResult('newsletters','*'," `vSendDate` = '".$currentDay."' AND `vStatus` = 'Y' AND `vSendStatus` = 'No' ORDER BY `vNewsletterId` ASC");
        $subscribers_array  = $dbh->selectResult('newsletter_subscribers','vEmail'," `vStatus` = 'Y' ORDER BY `vSubscriberId` ASC");
        //echopre1($subscribers_array);

        if(is_array($subscribers_array) && count($subscribers_array)>0){
            if(trim($newsletter_array[0]->vContent) <> ""){
                if(trim($newsletter_array[0]->vSubject) <> ""){
                    $subject = stripslashes($newsletter_array[0]->vSubject)." - ".SITE_NAME;
                }else{
                    $subject = "Newsletter dated on ".date("d-F-Y",strtotime($currentDay))." - ".SITE_NAME;
                }
                /************************ SEND EMAIL TO ADMINISTRATOR  **********************/
                $emailBody 		= '<table border="0" cellpadding="1" cellspacing="1" class="maintext2" style="width:100%">
                                  <tbody>
                                    <tr>
                                      <td colspan="2">
                                          <p>Hi User,</p>
                                      </td>
                                    </tr>
                                    <tr>
                                      <td colspan="2">
                                          <p>'.stripslashes($newsletter_array[0]->vContent).'</p>
                                      </td>
                                    </tr>
                                    <tr>
                                      <td colspan="2">&nbsp;</td>
                                    </tr>
                                    <tr>
                                      <td colspan="2"><strong>Regards,<br/>Team {SITE_NAME}</strong></td>
                                    </tr>
                                    <tr>
                                      <td colspan="2">&nbsp;</td>
                                    </tr>
                                    <tr>
                                      <td colspan="2" align="center"><a href="'.BASE_URL.'unsubscribe/{SUBSCRIBED_EMAIL}">Unsubscribe</a></td>
                                    </tr>
                                  </tbody>
                                </table>';

                $arrTSearch     = array("{SITE_NAME}");
                $arrTReplace    = array(SITE_NAME);
                $emailBody      = str_replace($arrTSearch, $arrTReplace, $emailBody);
                //echo $emailBody;

                $from_email  	    = Cmshelper::getSettingsValueByName("admin_email");
                $from_name        = SITE_NAME;
                PageContext::includePath('phpmailer');

                $is_mail_sent = 0;
                foreach($subscribers_array as $subscriber){
                    $arrTSearch       = array("{SUBSCRIBED_EMAIL}");
                    $arrTReplace      = array($subscriber->vEmail);
                    $emailBody        = str_replace($arrTSearch, $arrTReplace, $emailBody);
                    //echo $emailBody; die();

                    $mail             = new PHPMailer();
                    $mail->IsSMTP();
                    $mail->Host       = SMTPSERVER;
                    $mail->SMTPAuth   = true;
                    $mail->Port       = SMTPPORT;
                    $mail->Username   = SMTPUSERNAME;
                    $mail->Password   = SMTPPASSWORD;
                    $mail->SMTPSecure = 'ssl';
                    //$mail->AddReplyTo($from_email,$from_name);
                    $mail->SetFrom($from_email,$from_name);
                    $to_email           = $subscriber->vEmail;
                    $mail->Subject      = $subject;
                    $mail->AltBody      = '';
                    $mail->MsgHTML($emailBody);
                    if($mail->validateAddress($to_email)){
                        $mail->AddAddress($to_email, "");
                    }
                    $mail_sent = $mail->Send();
                    if($mail_sent && !$is_mail_sent){
                        $is_mail_sent = 1;
                    }
                }
                /************************ SEND EMAIL TO ADMINISTRATOR  **********************/
                if($is_mail_sent){
                    $vNewsletterId = trim($newsletter_array[0]->vNewsletterId);
                    $updateQuery   = "UPDATE `".$dbh->tablePrefix."newsletters` SET `vSendStatus` = 'Yes' WHERE `vNewsletterId` = '".$vNewsletterId."'";
                    $dbh->execute($updateQuery);
                }
            }
            echo "Cron executed successfully!";
        }else{
            echo "No active subscriber(s) found!";
        }
    }
}
?>
