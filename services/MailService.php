<?php 
include_once('../pdquser/PHPMailer/class.phpmailer.php');
include_once('../pdquser/MPDF60/mpdf.php');
require_once('../pdquser/services/NcrbasicinfoService.php');
require_once('../pdquser/services/PdqinfoService.php');
require_once('../pdquser/services/PdqimmediateactionService.php');
require_once('../pdquser/services/ReportsService.php');
/**
 * @author Thongchai Lim  *  林生海
 *	Tel:0816477729  0866018771
 *	Email/MSN:limweb@hotmail.com,thongchai@servit.co.th
 *	GoogleTalk:lim.thongchai@gmail.com
 *	Social Network Name: “limweb” Skype/HI5/Twitter/Facebook
 *  @copyright 2013 TH/BKK
 **/
$method = $_SERVER['REQUEST_METHOD'];
$request = explode("/", substr(@$_SERVER['PATH_INFO'], 1));



if( $method == 'GET' && $request[0] == 'test') {
	$sv = new MailService();
    $sv->test();
}

class MailService {
	
	public $mail;
	public $email;
	public $pass;
	
	public function __construct()
	{
	   
		$this->mail = new PHPMailer();
		$this->email = 'report@vause.co.th';
		$this->pass = '11111111';
	}


public function sendMailPDQ($emailTo,$emailName,$ccTo,$ccName,$pdqID){
	   
       $Immediate = new PdqimmediateactionService();
       $pdqInfo = new PdqinfoService();
       
       $getImme = $Immediate->getPdq_immediateactionByPDQID($pdqID);
       $getInfo = $pdqInfo->getAllPdq_basicinfoAdvancedBypdqID($pdqID);
       
       if($getInfo->basic_2==='1'){
            $nearmiss = 'Yes';
       }else{
            $nearmiss = 'No';
       }

        if($getInfo->basic_6==='1'){
            $ncr = 'Yes';
       }else{
            $ncr = 'No';
       }
		
		$this->mail->CharSet = "utf-8";
		$this->mail->IsSMTP();
		$this->mail->SMTPDebug = 0;
		$this->mail->SMTPAuth = true;
		$this->mail->SMTPSecure = "tls";
		$this->mail->Host = "smtp.gmail.com"; // SMTP server
		$this->mail->Port = 587; 
		$this->mail->Username = $this->email; // account SMTP
		$this->mail->Password = $this->pass; //  account SMTP
		//From:
		$this->mail->SetFrom($this->email, "PDQ Report");
		//TO:
       $this->mail->AddAddress($emailTo, $emailName);
       $this->mail->AddCC("hseq.thailand@vause.co.th", "HSEQ");
       $this->mail->AddCC($ccTo, $ccName);
       /** Test by*/
		//$this->mail->AddAddress("patcharin@infomediacomm.com", "Patcharin");

		//ReplayTo:
		$this->mail->AddReplyTo($this->email, " ");
		//Subject:
		if(!empty($subject)){
		 	$sub = $subject;	
		}  else  {
			$sub = 'PDQ Reported by '.$ccName;
		}
		$this->mail->Subject = $sub;
		//Attachment:
		// $attach_file = "./".$strFileName;
		// $this->mail->AddAttachment($attach_file);
		//Display HTML Y/N
		$this->mail->IsHTML(true);
		
		if(!empty($msg)){
			$message = $msg;			
		} else {
		  
            $message1  = 'Dear '.$getInfo->super_name.'<br />';
            $message2  = '<br/><table width="100%" border="0" align="left" cellpadding="0" cellspacing="0" style="font-family:arial;table-layout:fixed;" >
    	                   <tr>
		                      <td width="100%" align="left" valign="top">
		                          <table width="100%">
                                    <tr><td width="165" align="left" valign="top"><B>REPORTED BY</B></td>            <td width="20" valign="top">:</td>    <td align="left" valign="top" >'.$getInfo->Ename.'</td></tr>
                                    <tr><td width="165" align="left" valign="top"><B>EDITTED BY</B></td>            <td width="20" valign="top">:</td>    <td align="left" valign="top" >'.$ccName.'</td></tr>
                                    <tr><td width="165" align="left" valign="top"><B>PDQ ID</B></td>            <td width="20" valign="top">:</td>    <td align="left" valign="top" >'.$pdqID.'</td></tr>
                                    <tr><td width="165" align="left" valign="top"><B>CATEGORY</B></td>            <td width="20" valign="top">:</td>    <td align="left" valign="top" >'.$getInfo->basic_category.'</td></tr>
                                    <tr><td width="165" align="left" valign="top"><B>EVENT DATE</B></td>            <td width="20" valign="top">:</td>    <td align="left" valign="top" >'.$getInfo->basic_eventDate.'</td></tr>
                                    <tr><td width="165" align="left" valign="top"><B>CUSTOMER</B></td>            <td width="20" valign="top">:</td>    <td align="left" valign="top" >'.$getInfo->client.'</td></tr>
                                    <tr><td width="165" align="left" valign="top"><B>LOCATION</B></td>            <td width="20" valign="top">:</td>    <td align="left" valign="top" >'.$getInfo->location.'</td></tr>
                                     <tr><td width="165" align="left" valign="top"><B>WHERE</B></td>            <td width="20" valign="top">:</td>    <td align="left" valign="top" >'.$getInfo->applied.'</td></tr>
		                      </table></td>           
                            </tr>
                        </table>';
            $message3  = '<br/><table width="100%" border="0" align="left" cellpadding="0" cellspacing="0" style="font-family:arial;table-layout:fixed;" >
    	                   <tr>
		                      <td width="100%" align="left" valign="top">
		                          <table width="100%">
                                    <tr><td width="165" align="left" valign="top"><B>NEAR MISS</B></td>            <td width="20" valign="top">:</td>    <td align="left" valign="top" >'.$nearmiss.'</td></tr>
                                    <tr><td width="165" align="left" valign="top"><B>NON CONFORMANCE</B></td>            <td width="20" valign="top">:</td>    <td align="left" valign="top" >'.$ncr.'</td></tr>
		                      </table></td>           
                            </tr>
                        </table>';
            $message4 = '<br/><table width="100%" border="0" align="left" cellpadding="0" cellspacing="0" style="font-family:arial;table-layout:fixed;" >
    	                   <tr>
		                      <td width="100%" align="left" valign="top">
		                          <table width="100%">
                                    <tr><td width="165" align="left" valign="top"><B>OBSERVATION</B></td>            <td width="20" valign="top">:</td>    <td align="left" valign="top" >'.$getInfo->basic_description.'</td></tr>
		                      </table></td>           
                            </tr>
                        </table>';
             $message5 = '<br/><table width="100%" border="0" align="left" cellpadding="0" cellspacing="0" style="font-family:arial;table-layout:fixed;" >
    	                   <tr>
		                      <td width="100%" align="left" valign="top">
		                          <table width="100%">
                                    <tr><td width="165" align="left" valign="top"><B>ACTION ITEM</B></td>            <td width="20" valign="top">:</td>  <td align="left" valign="top" ></td></tr>
		                      </table></td>           
                            </tr>
                        </table>';

            $message6 ='<br/><table width="98%" align="center" border="1" style="font-family:arial;border-collapse: collapse;">
                <tr>
                    <td align="center" valign="middle"><B>No.<B></td>
                    <td align="center" valign="middle"><B>Responsible<B></td>
                    <td align="center" valign="middle"><B>Details<B></td>
                    <td align="center" valign="middle"><B>Expected Closing<B></td>
                    <td align="center" valign="middle"><B>Status<B></td>
                </tr>';  
            foreach ($getImme as $value) {
            $message6 .='
            	<tr>
            		<td width="5%" align="center" valign="top">'.$value->imeItem.'</td>
            		<td width="20%" align="center" valign="top">'.$value->ime_responsible.'</td>
                    <td width="50%" align="left" valign="top" style="padding-left: 10px;">'.$value->ime_actionItem.'</td>
                    <td width="15%" align="center" valign="top">'.$value->ime_expected.'</td>
                    <td width="8%" align="center" valign="top" style="padding-right: 10px;">'.$value->ime_status.'</td>
            	</tr>';
            }
            $message6 .='</table>';
            
            $message7 = '<br/><table width="100%" border="0" align="left" cellpadding="0" cellspacing="0" style="font-family:arial;table-layout:fixed;" >
    	                   <tr>
		                      <td width="100%" align="left" valign="top">
		                          <table width="100%">
                                    <tr><td width="165" align="left" valign="top"><B>VISIT PDQ REPORT LINK</B></td>            <td width="20" valign="top">:</td>   <td><a href="http://vause.dyndns-server.com:8888/online_report/pdquser/index.html">Click Here</a></td></tr>
		                      </table></td>           
                            </tr>
                        </table><br />';
                        
             $message8 = '<br /><br />Best Regards,<br />'.$ccName.'<br />'.$getInfo->emp_jobfunction;
            //	$message = 'You Have A New PDQ Report From '.$ccName.'<br />PDQ ID : '.$pdqID.'<br />Observation : '.$getInfo->basic_description.'<br />Please Check -> http://vause.dyndns-server.com:8888/online_report/pdquser/index.html<br />';
		}
		//Body Message:
		$this->mail->Body = $message1.$message2.$message3.$message4.$message5.$message6.$message7.$message8;
		//Sent.....
		if(!$this->mail->Send())
		{
			return 'Error';
		}
		else
		{
			return 'Message has been sent';
		}
		
	}
    
public function sendMailPDQAttachment($emailTo,$emailName,$ccTo,$ccName,$pdqID){
       //mpdf//
        $ncrInfo = new NcrbasicinfoService();
        $pdqInfo = new PdqinfoService();
        $Immediate = new PdqimmediateactionService();
        $empAdress = new ReportsService();

        $getInfoNcr = $ncrInfo->getNcr_basicinfoByID($pdqID);
        $getInfo = $pdqInfo->getAllPdq_basicinfoAdvancedBypdqID($pdqID);
        $getImme = $Immediate->getPdq_immediateactionByPDQID($pdqID);
        $getAddress = $empAdress->getAddress($getInfo->empID);

        $check = '../pdquser/upload_images/checkbox_yes.png';
        $uncheck = '../pdquser/upload_images/checkbox_no.png';
        $logoVause = '../pdquser/upload_images/logo-pdf.jpg';
        $imgDefault = '../pdquser/upload_images/default.png';

        if($getInfo->basic_image1===NULL){
            $imgsrc1 = $imgDefault;
             $evident1 = ' ';
        }else{
            $imgsrc1 = '../pdquser/upload_images/'.$getInfo->basic_image1;
            $evident1 = 'Evident1';
        }
        if($getInfo->basic_image2===NULL){
            $imgsrc2 = $imgDefault;
             $evident2 = ' ';
        }else{
            $imgsrc2 = '../pdquser/upload_images/'.$getInfo->basic_image2;
            $evident2 = 'Evident2';
        }
        if($getInfo->basic_4===NULL){
            $imgsrc3 = $imgDefault;
            $evident3 = ' ';
        }else{
            $imgsrc3 = '../pdquser/upload_images/'.$getInfo->basic_4;
            $evident3 = 'Evident3';
        }
        if($getInfo->basic_5===NULL){
            $imgsrc4 = $imgDefault;
            $evident4 = ' ';
        }else{
            $imgsrc4 = '../pdquser/upload_images/'.$getInfo->basic_5;
            $evident4 = 'Evident4';
        }

 
        if($getInfo->basic_2==='1'){
            $nearmissYes = $check;
            $nearmissNo  = $uncheck;
        }else{
            $nearmissYes = $uncheck;
            $nearmissNo = $check;
        }
        
        if($getInfo->basic_6==='1'){
            $ncrYes = $check;
            $ncrNo  = $uncheck;
        }else{
            $ncrYes = $uncheck;
            $ncrNo  = $check;
        }
        
         if($getInfo->basic_2==='1'){
            $nearmiss = 'Yes';
       }else{
            $nearmiss = 'No';
       }

        if($getInfo->basic_6==='1'){
            $ncr = 'Yes';
       }else{
            $ncr = 'No';
       }

            $mpdf = new mPDF('c','A3','','',15,15,30,25,10,10);
            $mpdf->SetHTMLHeader('
            <div style="border-width: 2px; border-style: solid; border-color: #CC0C00; " height="25">
            				<table width="100%" >
                        <tr>
                            <td width="10%" align="left"><img src="'.$logoVause.'" width="100px" /></td>
                            <td width="90%" style="text-align:center;">
                                   <table width="100%" style="font-family:arial;font-size: 9pt; color: #005C95;">
                                       <tr><td style="font-family:arial;font-weight: bold;font-size:12pt;text-align:center;">'.$getAddress->companyname.'</td><tr>
                                       <tr><td style="font-family:arial;font-weight: bold;font-size:12pt;text-align:center;">PDQ / IMMEDIATE ACTION ITEM REPORT</td>
                                   </table></td>
            			</tr></table></div><br>
            		');
            
            /** VAUSE WIRELINE SERVICES LTD. */
            $aradd = preg_split("/[.]/", $getAddress->address,2,PREG_SPLIT_DELIM_CAPTURE);
            $mpdf->SetHTMLFooter('
            <table width="100%" style="font-family:arial;border-top:5px solid #CC0C00;" cellspacing="0" cellpadding="0">
            </table>
             <table  width="100%" style="font-family:arial; font-weight: normal;font-size:6pt;vertical-align:text-middle;">
                 <tr><td width="100%" align="right" valign="middle" ><B></B></td></tr> 
                 <tr><td width="100%" align="right" valign="middle" ><B></B></td><tr>
             </table>
            ');
            
            $htmlinfo ='<div style="border-width: 2px; border-style: solid; border-color: #CC0C00; ">
            		';
            $htmlinfo .= '
            	<table width="100%" border="" align="left" cellpadding="0" cellspacing="0" style="font-family:arial;table-layout:fixed;" >
                	<tr>
            		<td width="333" align="left" valign="top">
            		  <table width="333">
                            <tr><td width="110" align="left" valign="top"><B>Customer</B></td>            <td width="20" valign="top">:</td>    <td align="left" valign="top" >'.$getInfo->client.'</td></tr>
            		   </table></td> 
                    <td width="333" align="left" valign="top">
                        <table width="333">
                            <tr><td width="110" align="left" valign="top"><B>Where</B></td>                 <td width="20" valign="top">:</td>    <td align="left" valign="top" >'.$getInfo->applied.'</td></tr> 
            		  </table></td> 
                    <td width="333" align="left" valign="top">
                        <table width="333">
                            <tr><td width="110" align="left" valign="top"><B>PDQ No</B></td>               <td width="20" valign="top">:</td>    <td align="left" valign="top" >'.$getInfo->pdqID.'</td></tr>
            		    </table></td>           
                   </tr>
                </table>
                <table width="100%" border="" align="left" cellpadding="0" cellspacing="0" style="font-family:arial;table-layout:fixed;" >
                	<tr>
            		<td width="333" align="left" valign="top">
            		  <table width="333">
                            <tr><td width="110" align="left" valign="top"><B>Location</B></td>            <td width="20" valign="top">:</td>    <td align="left" valign="top" >'.$getInfo->location.'</td></tr>
            		   </table></td> 
                    <td width="333" align="left" valign="top">
                        <table width="333">
                           	<tr><td width="110" align="left" valign="top"><B>Business Unit</B></td>           <td width="20" valign="top">:</td>    <td align="left" valign="top" >'.$getInfo->business.'</td></tr>   
            		  </table></td> 
                    <td width="333" align="left" valign="top">
                        <table width="333">
                            <tr><td width="110" align="left" valign="top"><B>Category</B></td>             <td width="20" valign="top">:</td>   <td align="left" valign="top" >'.$getInfo->basic_category.'</td></tr>  
            		    </table></td>            
                   </tr>
                   
                </table>
               	<table width="100%" border="" align="left" cellpadding="0" cellspacing="0" style="font-family:arial;table-layout:fixed;" >
                   <tr>
                   <td width="333" align="left" valign="top">
                        <table width="333">
                            <tr><td width="110" align="left" valign="top"><B>Reported By<B/></td>   <td width="20" valign="top">:</td>    <td align="left" valign="top" >'.$getInfo->Ename.'</td></tr>    
            		    </table></td> 
                   <td width="333" align="left" valign="top">
                        <table width="333">
                             <tr><td width="110" align="left" valign="top"><B>Job Function<B/></td>  <td width="20" valign="top">:</td>    <td align="left" valign="top" >'.$getInfo->emp_jobfunction.'</td></tr> 
            		    </table></td> 
                   <td width="333" align="left" valign="top">
                        <table width="333">
                            	<tr><td width="110" align="left" valign="top"><B>NCR<B/></td> <td width="20" valign="top" align="left">:</td>
                                <td align="left" valign="top" class="imgleft"><img src="'.$ncrYes.'"/></td><td width="50" align="left" valign="top" >Yes</td>
                                <td align="left" valign="top" class="imgleft"><img src="'.$ncrNo.'"/></td><td width="50" align="left" valign="top" >No</td></tr> 
            		    </table></td>  
                   </tr>
            	</table>
                <table width="100%" border="" align="left" cellpadding="0" cellspacing="0" style="font-family:arial;table-layout:fixed;" >
                     <tr>
                     <td width="333" align="left" valign="middle">
                        <table width="333">
                            <tr><td width="110" align="left" valign="top" ><B>Status</B></td>   <td width="20" valign="top">:</td>    <td align="left" valign="top" >'.$getInfo->basic_status.' - (Progress '.$getInfo->basic_1.' %)</td></tr>
                        </table></td>
                     <td width="333" align="left" valign="middle">
                        <table width="333">
                            <tr><td width="110" align="left" valign="top" ><B>Supervisor</B></td>   <td width="20" valign="top">:</td>    <td align="left" valign="top" >'.$getInfo->super_name.'</td></tr>
                        </table></td>
                     <td width="333" align="left" valign="top">
                        <table width="333">
                             <tr><td width="110" align="left" valign="top"><B>Near Miss<B/></td>  <td width="20" valign="top">:</td>  
                             <td align="left" valign="top" class="imgleft"><img src="'.$nearmissYes.'"/></td><td width="50" align="left" valign="top" >Yes</td>
                             <td align="left" valign="top" class="imgleft"><img src="'.$nearmissNo.'"/></td><td width="50" align="left" valign="top" >No</td></tr> 
            		    </table></td> 
                    </tr>
            	</table></div>';
                
            $htmldesc ='<br><div style="font-family:arial;background-color:#cccccc;vertical-align:"middle";	padding:0pt; border: 0px solid #555555;left:5;" height="20">
                         	<span style="font-family:arial;vertical-align:text-middle;"><B>&nbsp;&nbsp;OBSERVATION</B></span>
            		  </div><div style="border-width: 2px; border-style: solid; border-color: #CC0C00;">';
            $htmldesc .='<table width="100%" border="0" align="left" cellpadding="0" cellspacing="0" style="font-family:arial;table-layout:fixed;" >
                     <tr>
                     <td width="1000" align="left" valign="top">
                        <table width="1000">
                            <tr><td align="left" valign="top" >&nbsp;&nbsp;'.$getInfo->basic_description.'</td></tr>
                            </table></td>         
                    </tr>
                 </table></div>';  
            
            if($getInfo->basic_image1 !== NULL){   
            $htmlevident ='<br><div style="font-family:arial;background-color:#cccccc;vertical-align:"middle";	padding:0pt; border: 0px solid #555555;left:5;" height="20">
                         	<span style="font-family:arial;vertical-align:text-middle;"><B>&nbsp;&nbsp;EVIDENT</B></span>
            		  </div><div style="border-width: 2px; border-style: solid; border-color: #CC0C00;">
            		<br><table width="100%" border="0" align="left"  valign="top" cellpadding="0" cellspacing="0" style="font-family:arial;table-layout: fixed; 
                 border-width: 1px;border-spacing: 1px;border-style: none;border-color: #cccccc;border-collapse: collapse;background-color: white;">
            <tr>
                <td width="240" align="center" valign="middle" rowspan="2" valign="bottom" border="1" class="imgleft"><img src="'.$imgsrc1.'" height="200" /></td>
                <td width="240" align="center" valign="middle" rowspan="2" valign="bottom" border="1" class="imgleft"><img src="'.$imgsrc2.'" height="200" /></td>
                <td width="240" align="center" valign="middle" rowspan="2" valign="bottom" border="1" class="imgleft"><img src="'.$imgsrc3.'" height="200" /></td>
                <td width="240" align="center" valign="middle" rowspan="2" valign="bottom" border="1" class="imgleft"><img src="'.$imgsrc4.'" height="200" /></td>
            </tr>
            </table>';
            }
            $htmlevident .='<table width="100%" border="0" align="left"  valign="top" cellpadding="0" cellspacing="0" style="font-family:arial;table-layout: fixed;
                 border-width: 1px;border-spacing: 1px;border-style: none;border-color: #cccccc;border-collapse: collapse;background-color: white;">
                    <tr>
                        <td width="240" align="center" valign="top"><B>'.$getInfo->basic_7.'</td>
                        <td width="240" align="center" valign="top"><B>'.$getInfo->basic_8.'</td>
                        <td width="240" align="center" valign="top"><B>'.$getInfo->basic_9.'</td>
                        <td width="240" align="center" valign="top"><B>'.$getInfo->basic_10.'</B></td>
                    </tr>';
            $htmlevident .='</table></div>';
             
            $htmlimme ='<br><div style="font-family:arial;background-color:#cccccc;vertical-align:"middle";	padding:0pt; border: 0px solid #555555;left:5;" height="20">
                         		<span style="font-family:arial;vertical-align:text-middle;">
                                 <table width="100%" width="100%" border="" align="left" cellpadding="0" cellspacing="0" style="font-family:arial;table-layout:fixed;" >
                                    <td width="1000" align="left" valign="top">
                                        <tr>
                                             <td width="500" align="left" valign="top"><B>&nbsp;&nbsp;IMMEDIATE ACTION ITEM</B></td>
                                             <td width="500" align="right" valign="top" >Status : '.$getInfo->basic_status.' (Progress '.$getInfo->basic_1.' %)</td>
                                        </tr></td>
                                 </table>
                            </span>
            		  </div><div style="border-width: 2px; border-style: solid; border-color: #CC0C00;">';
            
            $htmlimme .='<br><table width="98%" align="center" border="1" style="font-family:arial;border-collapse: collapse;">
                <tr>
                    <td align="center" valign="middle"><B>No.<B></td>
                    <td align="center" valign="middle"><B>Responsible<B></td>
                    <td align="center" valign="middle"><B>Details<B></td>
                    <td align="center" valign="middle"><B>Expected Closing<B></td>
                    <td align="center" valign="middle"><B>Status<B></td>
                </tr>';  
            foreach ($getImme as $value) {
            $htmlimme .='
            	<tr>
            		<td width="5%" align="center" valign="top">'.$value->imeItem.'</td>
            		<td width="20%" align="center" valign="top">'.$value->ime_responsible.'</td>
                    <td width="50%" align="left" valign="top" style="padding-left: 10px;">'.$value->ime_actionItem.'</td>
                    <td width="15%" align="center" valign="top">'.$value->ime_expected.'</td>
                    <td width="8%" align="center" valign="top" style="padding-right: 10px;">'.$value->ime_status.'</td>
            	</tr>';
            }
            $htmlimme .='</table>';
            
            $getInfo->sub_ina    =   $getInfo->sub_ina==='Y'? $check:$uncheck;
            $getInfo->sub_human  =   $getInfo->sub_human==='Y'? $check:$uncheck;
            $getInfo->sub_manual =   $getInfo->sub_manual==='Y'? $check:$uncheck;
            $getInfo->sub_safety =   $getInfo->sub_safety==='Y'? $check:$uncheck;
            $getInfo->sub_percep =   $getInfo->sub_percep==='Y'? $check:$uncheck;
            $getInfo->sub_driving=   $getInfo->sub_driving==='Y'? $check:$uncheck;
            $getInfo->sub_other1     =   $getInfo->sub_other1==='Y'? $check:$uncheck;
            $getInfo->sub_positive   =   $getInfo->sub_positive==='Y'? $check:$uncheck;
            
            $htmlimme  .='<table width="90%" border="" align="center" cellpadding="0" cellspacing="0" style="font-family:arial;table-layout:fixed;" >
                	<tr>
            		<td width="300" align="center" valign="middle">
            		  <table width="300">
                                <tr><td width="250" align="left" valign="middle"><B>SUBSTANDARD PRACTICES</B></td></tr>
                                <tr><td align="left" valign="middle" class="imgleft"><img valign="middle" src="'.$getInfo->sub_ina.'"/>&nbsp;&nbsp;Inadequate PPE</td></tr>
                                <tr><td align="left" valign="middle" class="imgleft"><img valign="middle" src="'.$getInfo->sub_human.'"/>&nbsp;&nbsp;Human Behaviour</td></tr>
                                <tr><td align="left" valign="middle" class="imgleft"><img valign="middle" src="'.$getInfo->sub_manual.'"/>&nbsp;&nbsp;Manual Handling</td></tr>
                                <tr><td align="left" valign="middle" class="imgleft"><img valign="middle" src="'.$getInfo->sub_safety.'"/>&nbsp;&nbsp;Ignorant of Safety Rules</td></tr>
                                <tr><td align="left" valign="middle" class="imgleft"><img valign="middle" src="'.$getInfo->sub_percep.'"/>&nbsp;&nbsp;Perception of Risk/Hazards</td></tr>
                                <tr><td align="left" valign="middle" class="imgleft"><img valign="middle" src="'.$getInfo->sub_driving.'"/>&nbsp;&nbsp;Driving Violations</td></tr>
                                <tr><td align="left" valign="middle" class="imgleft"><img valign="middle" src="'.$getInfo->sub_other1.'"/>&nbsp;&nbsp;Other '.$getInfo->sub_ment1.'</td></tr>
                                <tr><td align="left" valign="middle" class="imgleft"><img valign="middle" src="'.$getInfo->sub_positive.'"/>&nbsp;&nbsp;Positive Behavior</td></tr>
                     </table>';
                     
                     
            $getInfo->sub_tool=$getInfo->sub_tool==='Y'? $check:$uncheck;
            $getInfo->sub_vehicle=$getInfo->sub_vehicle==='Y'? $check:$uncheck;
            $getInfo->sub_work=$getInfo->sub_work==='Y'? $check:$uncheck;
            $getInfo->sub_house=$getInfo->sub_house==='Y'? $check:$uncheck;
            $getInfo->sub_mainten=$getInfo->sub_mainten==='Y'? $check:$uncheck;
            $getInfo->sub_storage=$getInfo->sub_storage==='Y'? $check:$uncheck;
            $getInfo->sub_other2=$getInfo->sub_other2==='Y'? $check:$uncheck;
            $getInfo->sub_excellent=$getInfo->sub_excellent==='Y'? $check:$uncheck;
            
            $htmlimme   .='	<td width="300" align="center" valign="middle">
            		  <table width="300">
                                <tr><td width="250" align="left" valign="middle"><B>SUBSTANDARD CONDITION</B></td></tr>
                                <tr><td align="left" valign="middle" class="imgleft"><img valign="middle" src="'.$getInfo->sub_tool.'"/>&nbsp;&nbsp;Tool/Equipment</td></tr>
                                <tr><td align="left" valign="middle" class="imgleft"><img valign="middle" src="'.$getInfo->sub_vehicle.'"/>&nbsp;&nbsp;Vehicle / Transportation</td></tr>
                                <tr><td align="left" valign="middle" class="imgleft"><img valign="middle" src="'.$getInfo->sub_work.'"/>&nbsp;&nbsp;Work Place Environment</td></tr>
                                <tr><td align="left" valign="middle" class="imgleft"><img valign="middle" src="'.$getInfo->sub_house.'"/>&nbsp;&nbsp;Housekeeping</td></tr>
                                <tr><td align="left" valign="middle" class="imgleft"><img valign="middle" src="'.$getInfo->sub_mainten.'"/>&nbsp;&nbsp;Maintenance</td></tr>
                                <tr><td align="left" valign="middle" class="imgleft"><img valign="middle" src="'.$getInfo->sub_storage.'"/>&nbsp;&nbsp;Storage</td></tr>
                                <tr><td align="left" valign="middle" class="imgleft"><img valign="middle" src="'.$getInfo->sub_other2.'"/>&nbsp;&nbsp;Other '.$getInfo->sub_ment2.'</td></tr>
                                <tr><td align="left" valign="middle" class="imgleft"><img valign="middle" src="'.$getInfo->sub_excellent.'"/>&nbsp;&nbsp;Excellent Working Condition</td></tr>
                     </table>';
                     
            $getInfo->sub_inapro=$getInfo->sub_inapro==='Y'? $check:$uncheck;
            $getInfo->sub_lack=$getInfo->sub_lack==='Y'? $check:$uncheck;
            $getInfo->sub_poor=$getInfo->sub_poor==='Y'? $check:$uncheck;
            $getInfo->sub_inasuper=$getInfo->sub_inasuper==='Y'? $check:$uncheck;
            $getInfo->sub_insuff=$getInfo->sub_insuff==='Y'? $check:$uncheck;
            $getInfo->sub_inajob=$getInfo->sub_inajob==='Y'? $check:$uncheck;
            $getInfo->sub_natu=$getInfo->sub_natu==='Y'? $check:$uncheck;
            $getInfo->sub_other3=$getInfo->sub_other3==='Y'? $check:$uncheck;
            
            $htmlimme   .='	<td width="300" align="center" valign="middle">
            		  <table width="300">
                                <tr><td width="250" align="left" valign="middle"><B>CAUSES</B></td></tr>
                                <tr><td align="left" valign="middle" class="imgleft"><img src="'.$getInfo->sub_inapro.'"/>&nbsp;&nbsp;Inadequate Procedures</td></tr>
                                <tr><td align="left" valign="middle" class="imgleft"><img src="'.$getInfo->sub_lack.'"/>&nbsp;&nbsp;Lack of Tranining</td></tr>
                                <tr><td align="left" valign="middle" class="imgleft"><img src="'.$getInfo->sub_poor.'"/>&nbsp;&nbsp;Poor Motivation</td></tr>
                                <tr><td align="left" valign="middle" class="imgleft"><img src="'.$getInfo->sub_inasuper.'"/>&nbsp;&nbsp;Inadequate Supervision</td></tr>
                                <tr><td align="left" valign="middle" class="imgleft"><img src="'.$getInfo->sub_insuff.'"/>&nbsp;&nbsp;Insufficient Resources</td></tr>
                                <tr><td align="left" valign="middle" class="imgleft"><img src="'.$getInfo->sub_inajob.'"/>&nbsp;&nbsp;Inadequate Job Knowledge</td></tr>
                                <tr><td align="left" valign="middle" class="imgleft"><img src="'.$getInfo->sub_natu.'"/>&nbsp;&nbsp;Natural / Weather</td></tr>
                                <tr><td align="left" valign="middle" class="imgleft"><img src="'.$getInfo->sub_other3.'"/>&nbsp;&nbsp;Other '.$getInfo->sub_ment3.'</td></tr>
                        </table></td>
                        </tr>  
                     </table></div>';
            
            $htmlrisk ='<br><div style="font-family:arial;background-color:#cccccc;vertical-align:"middle";	padding:0pt; border: 0px solid #555555;left:5;" height="20">
                         	<span style="font-family:arial;vertical-align:text-middle;">
                                 <table width="100%" width="100%" border="" align="left" cellpadding="0" cellspacing="0" style="font-family:arial;table-layout:fixed;" >
                                    <td width="1000" align="left" valign="top">
                                        <tr>
                                             <td width="500" align="left" valign="top"><B>&nbsp;&nbsp;RISK ASSESSMENT</B></td>
                                             <td width="500" align="right" valign="top" >Supervisor Name : '.$getInfo->super_name.'</td>
                                        </tr></td>
                                 </table>
                            </span>
            		  </div><div style="border-width: 2px; border-style: solid; border-color: #CC0C00;">';
            $htmlrisk .='<table width="100%" border="0" align="left" cellpadding="0" cellspacing="0" style="font-family:arial;table-layout:fixed;" >
                     <tr>
                     <td width="1000" align="left" valign="top">
                        <table width="1000">
                            <tr><td width="150" align="left" valign="top" ><B>Risk Level</B></td>  <td width="20" valign="top">:</td>  <td align="left" valign="top" >'.$getInfo->risk_level.'</td></tr>
                             <tr><td width="150" align="left" valign="top" ><B>Preventive Action</B></td>  <td width="20" valign="top">:</td>  <td align="left" valign="top" >'.$getInfo->super_comment.'</td></tr>
                        </table></td>
                    </tr>
                    </table>';    
                     
            $getInfo->riskass_personal    =   $getInfo->riskass_personal==='Y'? $check:$uncheck;
            $getInfo->riskass_fire  =   $getInfo->riskass_fire==='Y'? $check:$uncheck;
            $getInfo->riskass_fall =   $getInfo->riskass_fall==='Y'? $check:$uncheck;
            $getInfo->riskass_property =   $getInfo->riskass_property==='Y'? $check:$uncheck;
            $getInfo->riskass_radiation =   $getInfo->riskass_radiation==='Y'? $check:$uncheck;
            $getInfo->riskass_traffic =   $getInfo->riskass_traffic==='Y'? $check:$uncheck;
            $getInfo->riskass_gas     =   $getInfo->riskass_gas==='Y'? $check:$uncheck;
            $getInfo->riskass_chemical   =   $getInfo->riskass_chemical==='Y'? $check:$uncheck;
            $getInfo->riskass_collision   =   $getInfo->riskass_collision==='Y'? $check:$uncheck;
            $getInfo->riskass_oil   =   $getInfo->riskass_oil==='Y'? $check:$uncheck;
            $getInfo->riskass_explosion   =   $getInfo->riskass_explosion==='Y'? $check:$uncheck;
            $getInfo->riskass_env   =   $getInfo->riskass_env==='Y'? $check:$uncheck;
            $getInfo->riskass_kick   =   $getInfo->riskass_kick==='Y'? $check:$uncheck;
            $getInfo->riskass_fatality   =   $getInfo->riskass_fatality==='Y'? $check:$uncheck;
            $getInfo->riskass_otherrisk   =   $getInfo->riskass_otherrisk==='Y'? $check:$uncheck;
            
            $htmlrisk  .='<table width="90%" border="" align="center" cellpadding="0" cellspacing="0" style="font-family:arial;table-layout:fixed;" >
                	<tr>
            		<td width="180" align="center" valign="middle">
            		  <table width="180">
                                <tr><td align="left" valign="middle" class="imgleft"><img valign="middle" src="'.$getInfo->riskass_personal.'"/>&nbsp;&nbsp;Personal Injury</td></tr>
                                <tr><td align="left" valign="middle" class="imgleft"><img valign="middle" src="'.$getInfo->riskass_fire.'"/>&nbsp;&nbsp;Fire</td></tr>
                                <tr><td align="left" valign="middle" class="imgleft"><img valign="middle" src="'.$getInfo->riskass_fall.'"/>&nbsp;&nbsp;Fall Over Board</td></tr>
                      </table></td>
                      	<td width="180" align="center" valign="middle">
            		  <table width="180">
                              
                                <tr><td align="left" valign="middle" class="imgleft"><img valign="middle" src="'.$getInfo->riskass_property.'"/>&nbsp;&nbsp;Property Damage</td></tr>
                                <tr><td align="left" valign="middle" class="imgleft"><img valign="middle" src="'.$getInfo->riskass_radiation.'"/>&nbsp;&nbsp;Radiation Leak</td></tr>
                                <tr><td align="left" valign="middle" class="imgleft"><img valign="middle" src="'.$getInfo->riskass_traffic.'"/>&nbsp;&nbsp;Traffic Accident</td></tr>
                      </table></td>
                      	<td width="180" align="center" valign="middle">
            		  <table width="180">
                              
                                <tr><td align="left" valign="middle" class="imgleft"><img valign="middle" src="'.$getInfo->riskass_gas.'"/>&nbsp;&nbsp;Gas Leak</td></tr>
                                <tr><td align="left" valign="middle" class="imgleft"><img valign="middle" src="'.$getInfo->riskass_chemical.'"/>&nbsp;&nbsp;Chemical Spill</td></tr>
                                <tr><td align="left" valign="middle" class="imgleft"><img valign="middle" src="'.$getInfo->riskass_collision.'"/>&nbsp;&nbsp;Collision</td></tr>
                      </table></td>
                      	<td width="180" align="center" valign="middle">
            		  <table width="180">
                              
                                <tr><td align="left" valign="middle" class="imgleft"><img valign="middle" src="'.$getInfo->riskass_oil.'"/>&nbsp;&nbsp;Oil Leak</td></tr>
                                <tr><td align="left" valign="middle" class="imgleft"><img valign="middle" src="'.$getInfo->riskass_explosion.'"/>&nbsp;&nbsp;Explosion</td></tr>
                                <tr><td align="left" valign="middle" class="imgleft"><img valign="middle" src="'.$getInfo->riskass_env.'"/>&nbsp;&nbsp;ENV. Damage</td></tr>
                      </table></td>
                      	<td width="180" align="center" valign="middle">
            		  <table width="180">
                               
                                <tr><td align="left" valign="middle" class="imgleft"><img valign="middle" src="'.$getInfo->riskass_kick.'"/>&nbsp;&nbsp;Kick / Blow-Out</td></tr>
                                <tr><td align="left" valign="middle" class="imgleft"><img valign="middle" src="'.$getInfo->riskass_fatality.'"/>&nbsp;&nbsp;Fatality</td></tr>
                                <tr><td align="left" valign="middle" class="imgleft"><img valign="middle" src="'.$getInfo->riskass_otherrisk.'"/>&nbsp;&nbsp;Other '.$getInfo->riskass_mentsrisk.'</td></tr>
                    </table></td> 
                </table></div>';

        $html = $htmlinfo.$htmldesc.$htmlevident.$htmlimme.$htmlrisk;
        $mpdf->AddPage();
        $mpdf->WriteHTML($html);
        $name = $pdqID.'.pdf';
        $content = $mpdf->Output('', 'S');
		
		$this->mail->CharSet = "utf-8";
		$this->mail->IsSMTP();
		$this->mail->SMTPDebug = 0;
		$this->mail->SMTPAuth = true;
		$this->mail->SMTPSecure = "tls";
		$this->mail->Host = "smtp.gmail.com"; // SMTP server
		$this->mail->Port = 587; 
		$this->mail->Username = $this->email; // account SMTP
		$this->mail->Password = $this->pass; //  account SMTP
		//From:
		$this->mail->SetFrom($this->email, "PDQ Report");
		//TO:
        $this->mail->AddAddress($emailTo, $emailName);
        $this->mail->AddCC("hseq.thailand@vause.co.th", "HSEQ");
        $this->mail->AddCC($ccTo, $ccName);
       /** Test by */
		//$this->mail->AddAddress("patcharin@infomediacomm.com", "Patcharin");
        
		//ReplayTo:
		$this->mail->AddReplyTo($this->email, " ");
		//Subject:
		if(!empty($subject)){
		 	$sub = $subject;	
		}  else  {
			$sub = 'PDQ Reported by '.$ccName;
		}
		$this->mail->Subject = $sub;
		//Attachment:
		// $attach_file = "./".$strFileName;
		// $this->mail->AddAttachment($attach_file);
		//Display HTML Y/N
		$this->mail->IsHTML(true);
		
		if(!empty($msg)){
			$message = $msg;			
		} else {
		  
             $message1  = 'Dear '.$getInfo->super_name.'<br />';
            $message2  = '<br/><table width="100%" border="0" align="left" cellpadding="0" cellspacing="0" style="font-family:arial;table-layout:fixed;" >
    	                   <tr>
		                      <td width="100%" align="left" valign="top">
		                          <table width="100%">
                                    <tr><td width="165" align="left" valign="top"><B>REPORTED BY</B></td>            <td width="20" valign="top">:</td>    <td align="left" valign="top" >'.$getInfo->Ename.'</td></tr>
                                    <tr><td width="165" align="left" valign="top"><B>EDITTED BY</B></td>            <td width="20" valign="top">:</td>    <td align="left" valign="top" >'.$ccName.'</td></tr>
                                    <tr><td width="165" align="left" valign="top"><B>PDQ ID</B></td>            <td width="20" valign="top">:</td>    <td align="left" valign="top" >'.$pdqID.'</td></tr>
                                    <tr><td width="165" align="left" valign="top"><B>CATEGORY</B></td>            <td width="20" valign="top">:</td>    <td align="left" valign="top" >'.$getInfo->basic_category.'</td></tr>
                                    <tr><td width="165" align="left" valign="top"><B>EVENT DATE</B></td>            <td width="20" valign="top">:</td>    <td align="left" valign="top" >'.$getInfo->basic_eventDate.'</td></tr>
                                    <tr><td width="165" align="left" valign="top"><B>CUSTOMER</B></td>            <td width="20" valign="top">:</td>    <td align="left" valign="top" >'.$getInfo->client.'</td></tr>
                                    <tr><td width="165" align="left" valign="top"><B>LOCATION</B></td>            <td width="20" valign="top">:</td>    <td align="left" valign="top" >'.$getInfo->location.'</td></tr>
                                     <tr><td width="165" align="left" valign="top"><B>WHERE</B></td>            <td width="20" valign="top">:</td>    <td align="left" valign="top" >'.$getInfo->applied.'</td></tr>
		                      </table></td>           
                            </tr>
                        </table>';
            $message3  = '<br/><table width="100%" border="0" align="left" cellpadding="0" cellspacing="0" style="font-family:arial;table-layout:fixed;" >
    	                   <tr>
		                      <td width="100%" align="left" valign="top">
		                          <table width="100%">
                                    <tr><td width="165" align="left" valign="top"><B>NEAR MISS</B></td>            <td width="20" valign="top">:</td>    <td align="left" valign="top" >'.$nearmiss.'</td></tr>
                                    <tr><td width="165" align="left" valign="top"><B>NON CONFORMANCE</B></td>            <td width="20" valign="top">:</td>    <td align="left" valign="top" >'.$ncr.'</td></tr>
		                      </table></td>           
                            </tr>
                        </table>';
            $message4 = '<br/><table width="100%" border="0" align="left" cellpadding="0" cellspacing="0" style="font-family:arial;table-layout:fixed;" >
    	                   <tr>
		                      <td width="100%" align="left" valign="top">
		                          <table width="100%">
                                    <tr><td width="165" align="left" valign="top"><B>OBSERVATION</B></td>            <td width="20" valign="top">:</td>    <td align="left" valign="top" >'.$getInfo->basic_description.'</td></tr>
		                      </table></td>           
                            </tr>
                        </table>';
             $message5 = '<br/><table width="100%" border="0" align="left" cellpadding="0" cellspacing="0" style="font-family:arial;table-layout:fixed;" >
    	                   <tr>
		                      <td width="100%" align="left" valign="top">
		                          <table width="100%">
                                    <tr><td width="165" align="left" valign="top"><B>ACTION ITEM</B></td>            <td width="20" valign="top">:</td>  <td align="left" valign="top" ></td></tr>
		                      </table></td>           
                            </tr>
                        </table>';

            $message6 ='<br/><table width="98%" align="center" border="1" style="font-family:arial;border-collapse: collapse;">
                <tr>
                    <td align="center" valign="middle"><B>No.<B></td>
                    <td align="center" valign="middle"><B>Responsible<B></td>
                    <td align="center" valign="middle"><B>Details<B></td>
                    <td align="center" valign="middle"><B>Expected Closing<B></td>
                    <td align="center" valign="middle"><B>Status<B></td>
                </tr>';  
            foreach ($getImme as $value) {
            $message6 .='
            	<tr>
            		<td width="5%" align="center" valign="top">'.$value->imeItem.'</td>
            		<td width="20%" align="center" valign="top">'.$value->ime_responsible.'</td>
                    <td width="50%" align="left" valign="top" style="padding-left: 10px;">'.$value->ime_actionItem.'</td>
                    <td width="15%" align="center" valign="top">'.$value->ime_expected.'</td>
                    <td width="8%" align="center" valign="top" style="padding-right: 10px;">'.$value->ime_status.'</td>
            	</tr>';
            }
            $message6 .='</table>';
            
            $message7 = '<br/><table width="100%" border="0" align="left" cellpadding="0" cellspacing="0" style="font-family:arial;table-layout:fixed;" >
    	                   <tr>
		                      <td width="100%" align="left" valign="top">
		                          <table width="100%">
                                    <tr><td width="165" align="left" valign="top"><B>VISIT PDQ REPORT LINK</B></td>            <td width="20" valign="top">:</td>   <td><a href="http://vause.dyndns-server.com:8888/online_report/pdquser/index.html">Click Here</a></td></tr>
		                      </table></td>           
                            </tr>
                        </table><br />';
                        
             $message8 = '<br /><br />Best Regards,<br />'.$ccName.'<br />'.$getInfo->emp_jobfunction;
            //	$message = 'You Have A New PDQ Report From '.$ccName.'<br />PDQ ID : '.$pdqID.'<br />Observation : '.$getInfo->basic_description.'<br />Please Check -> http://vause.dyndns-server.com:8888/online_report/pdquser/index.html<br />';
		}
		//Body Message:
		$this->mail->Body = $message1.$message2.$message3.$message4.$message5.$message6.$message7.$message8;
        $encoding = "base64";
        $type = "application/octet-stream";
     
        $this->mail->AddStringAttachment($content,$name);
        //$mpdf->Output($name,'D');
		//Sent.....
		if(!$this->mail->Send())
		{
			return 'Error';
		}
		else
		{
			return 'Message has been sent';
		}
		
	}
    
    
    
public function sendMailNCR($emailTo,$emailName,$ccTo,$ccName,$pdqID){
	   
        $ncrInfo = new NcrbasicinfoService();
        $pdqInfo = new PdqinfoService();
        $Immediate = new PdqimmediateactionService();
        $empAdress = new ReportsService();

        $getInfoNcr = $ncrInfo->getNcr_basicinfoByID($pdqID);
        $getInfo = $pdqInfo->getAllPdq_basicinfoAdvancedBypdqID($pdqID);
        $getImme = $Immediate->getPdq_immediateactionByPDQID($pdqID);
        $getAddress = $empAdress->getAddress($getInfo->empID);
        
        // if($getInfoNcr->ncr_cusComplaint==='1'){
//            $complaint = 'Yes';
//        }else{
//            $complaint = 'No';
//        }
		
		$this->mail->CharSet = "utf-8";
		$this->mail->IsSMTP();
		$this->mail->SMTPDebug = 0;
		$this->mail->SMTPAuth = true;
		$this->mail->SMTPSecure = "tls";
		$this->mail->Host = "smtp.gmail.com"; // SMTP server
		$this->mail->Port = 587; 
		$this->mail->Username = $this->email; // account SMTP
		$this->mail->Password = $this->pass; //  account SMTP
		//From:
		$this->mail->SetFrom($this->email, "NCR Report");
		//TO:
        $this->mail->AddAddress($emailTo, $emailName);
        $this->mail->AddCC("hseq.thailand@vause.co.th", "HSEQ");
        $this->mail->AddCC($ccTo, $ccName);
        /** Test by*/
		//$this->mail->AddAddress("patcharin@infomediacomm.com", "Patcharin");
        
		//ReplayTo:
		$this->mail->AddReplyTo($this->email, " ");
		//Subject:
		if(!empty($subject)){
		 	$sub = $subject;	
		}  else  {
			$sub = 'by '.$ccName;
		}
		$this->mail->Subject = $sub;
		//Attachment:
		// $attach_file = "./".$strFileName;
		// $this->mail->AddAttachment($attach_file);
		//Display HTML Y/N
		$this->mail->IsHTML(true);
		
		if(!empty($msg)){
			$message = $msg;			
		} else {
		  
            $message1  = 'Dear '.$getInfo->super_name.'<br />';
            $message2  = '<br/><table width="100%" border="0" align="left" cellpadding="0" cellspacing="0" style="font-family:arial;table-layout:fixed;" >
    	                   <tr>
		                      <td width="100%" align="left" valign="top">
		                          <table width="100%">
                                    <tr><td width="165" align="left" valign="top"><B>REPORTED BY</B></td>            <td width="20" valign="top">:</td>    <td align="left" valign="top" >'.$getInfo->Ename.'</td></tr>
                                    <tr><td width="165" align="left" valign="top"><B>EDITTED BY</B></td>            <td width="20" valign="top">:</td>    <td align="left" valign="top" >'.$ccName.'</td></tr>
                                    <tr><td width="165" align="left" valign="top"><B>NCR ID</B></td>            <td width="20" valign="top">:</td>    <td align="left" valign="top" >'.$pdqID.'</td></tr>
		                      </table></td>           
                            </tr>
                        </table>';
            $message3 = '<br/><table width="100%" border="0" align="left" cellpadding="0" cellspacing="0" style="font-family:arial;table-layout:fixed;" >
    	                   <tr>
		                      <td width="100%" align="left" valign="top">
		                          <table width="100%">
                                    <tr><td width="165" align="left" valign="top"><B>OBSERVATION</B></td>            <td width="20" valign="top">:</td>    <td align="left" valign="top" >'.$getInfo->basic_description.'</td></tr>
		                      </table></td>           
                            </tr>
                        </table>';
             $message4 = '<br/><table width="100%" border="0" align="left" cellpadding="0" cellspacing="0" style="font-family:arial;table-layout:fixed;" >
    	                   <tr>
		                      <td width="100%" align="left" valign="top">
		                          <table width="100%">
                                    <tr><td width="165" align="left" valign="top"><B>ACTION ITEM</B></td>            <td width="20" valign="top">:</td>  <td align="left" valign="top" ></td></tr>
		                      </table></td>           
                            </tr>
                        </table>';

            $message5 ='<br/><table width="98%" align="center" border="1" style="font-family:arial;border-collapse: collapse;">
                <tr>
                    <td align="center" valign="middle"><B>No.<B></td>
                    <td align="center" valign="middle"><B>Responsible<B></td>
                    <td align="center" valign="middle"><B>Details<B></td>
                    <td align="center" valign="middle"><B>Expected Closing<B></td>
                    <td align="center" valign="middle"><B>Status<B></td>
                </tr>';  
            foreach ($getImme as $value) {
            $message5 .='
            	<tr>
            		<td width="5%" align="center" valign="top">'.$value->imeItem.'</td>
            		<td width="20%" align="center" valign="top">'.$value->ime_responsible.'</td>
                    <td width="50%" align="left" valign="top" style="padding-left: 10px;">'.$value->ime_actionItem.'</td>
                    <td width="15%" align="center" valign="top">'.$value->ime_expected.'</td>
                    <td width="8%" align="center" valign="top" style="padding-right: 10px;">'.$value->ime_status.'</td>
            	</tr>';
            }
            $message5 .='</table>';
            
            $message6 = '<br/><table width="100%" border="0" align="left" cellpadding="0" cellspacing="0" style="font-family:arial;table-layout:fixed;" >
    	                   <tr>
		                      <td width="100%" align="left" valign="top">
		                          <table width="100%">
                                    <tr><td width="165" align="left" valign="top"><B>VISIT NCR REPORT LINK</B></td>            <td width="20" valign="top">:</td>   <td><a href="http://vause.dyndns-server.com:8888/online_report/pdquser/index.html">Click Here</a></td></tr>
		                      </table></td>           
                            </tr>
                        </table>';
                        
             $message7 = '<br /><br />Best Regards,<br />'.$ccName.'<br />'.$getInfo->emp_jobfunction;
            //	$message = 'You Have A New PDQ Report From '.$ccName.'<br />PDQ ID : '.$pdqID.'<br />Observation : '.$getInfo->basic_description.'<br />Please Check -> http://vause.dyndns-server.com:8888/online_report/pdquser/index.html<br />';
		}
		//Body Message:
		$this->mail->Body = $message1.$message2.$message3.$message4.$message5.$message6.$message7;
		//Sent.....
		if(!$this->mail->Send())
		{
			return 'Error';
		}
		else
		{
			return 'Message has been sent';
		}
		
	}    
	
public function sendMailNCRAttachment($emailTo,$emailName,$ccTo,$ccName,$pdqID){
       //mpdf//
        $ncrInfo = new NcrbasicinfoService();
        $pdqInfo = new PdqinfoService();
        $Immediate = new PdqimmediateactionService();
        $empAdress = new ReportsService();

        $getInfoNcr = $ncrInfo->getNcr_basicinfoByID($pdqID);
        $getInfo = $pdqInfo->getAllPdq_basicinfoAdvancedBypdqID($pdqID);
        $getImme = $Immediate->getPdq_immediateactionByPDQID($pdqID);
        $getAddress = $empAdress->getAddress($getInfo->empID);

        $check = '../pdquser/upload_images/checkbox_yes.png';
        $uncheck = '../pdquser/upload_images/checkbox_no.png';
        $imgDefault = '../pdquser/upload_images/default.png';
        $logoVause = '../pdquser/upload_images/logo-pdf.jpg';

      if($getInfo->basic_image1===NULL){
            $imgsrc1 = $imgDefault;
            $evident1 = ' ';
        }else{
            $imgsrc1 = '../pdquser/upload_images/'.$getInfo->basic_image1;
            $evident1 = 'Evident1';
        }
        if($getInfo->basic_image2===NULL){
            $imgsrc2 = $imgDefault;
            $evident2 = ' ';
        }else{
            $imgsrc2 = '../pdquser/upload_images/'.$getInfo->basic_image2;
            $evident2 = 'Evident2';
        }
        if($getInfo->basic_4===NULL){
            $imgsrc3 = $imgDefault;
            $evident3 = ' ';
        }else{
            $imgsrc3 = '../pdquser/upload_images/'.$getInfo->basic_4;
            $evident3 = 'Evident3';
        }
        if($getInfo->basic_5===NULL){
            $imgsrc4 = $imgDefault;
            $evident4 = ' ';
        }else{
            $imgsrc4 = '../pdquser/upload_images/'.$getInfo->basic_5;
            $evident4 = 'Evident4';
        }
        
         if($getInfoNcr->ncr_type==='1'){
            $Major = $check;
            $Minor = $uncheck;
        }else{
            $Major = $uncheck;
            $Minor = $check;
        }

        if($getInfoNcr->ncr_cusComplaint==='1'){
            $Yes = $check;
            $No = $uncheck;
        }else{
            $Yes = $uncheck;
            $No = $check;
        }
        if($getInfoNcr->ncr_proposedAction === '1') {
            $Accepted = $check;
            $Rejected = $uncheck;
        }if($getInfoNcr->ncr_proposedAction === '0'){
            $Accepted = $uncheck;
            $Rejected = $check;
        }else{
            $Accepted = $uncheck;
            $Rejected = $uncheck;
        }


        
$mpdf = new mPDF('c','A3','','',15,15,30,25,10,10);
$mpdf->SetHTMLHeader('
<div style="border-width: 2px; border-style: solid; border-color: #CC0C00; " height="25">
				<table width="100%" >
            <tr>
                <td width="10%" align="left"><img src="'.$logoVause.'" width="100px" /></td>
                <td width="90%" style="text-align:center;">
                       <table width="100%" style="font-family:arial;font-size: 9pt; color: #005C95;">
                           <tr><td style="font-family:arial;font-weight: bold;font-size:12pt;text-align:center;">'.$getAddress->companyname.'</td><tr>
                           <tr><td style="font-family:arial;font-weight: bold;font-size:12pt;text-align:center;">Non Conformance Report</td>
                       </table></td>
			</tr></table></div><br>
		');
/** VAUSE WIRELINE SERVICES LTD. */
$aradd = preg_split("/[.]/", $getAddress->address,2,PREG_SPLIT_DELIM_CAPTURE);
$mpdf->SetHTMLFooter('
<table width="100%" style="font-family:arial;border-top:5px solid #CC0C00;" cellspacing="0" cellpadding="0">
</table>
 <table  width="100%" style="font-family:arial; font-weight: normal;font-size:6pt;vertical-align:text-middle;">
     <tr><td width="100%" align="right" valign="middle" ><B>F-HSEQ-20</B></td></tr> 
     <tr><td width="100%" align="right" valign="middle" ><B>REV.02</B></td><tr>
 </table>
');

$htmlinfo ='<div style="border-width: 2px; border-style: solid; border-color: #CC0C00; ">
		';
$htmlinfo .= '
	<table width="100%" border="" align="left" cellpadding="0" cellspacing="0" style="font-family:arial;table-layout:fixed;" >
    	<tr>
		<td width="333" align="left" valign="top">
		  <table width="333">
                <tr><td width="150" align="left" valign="top"><B>Customer</B></td>            <td width="20" valign="top">:</td>    <td align="left" valign="top" >'.$getInfo->client.'</td></tr>
		   </table></td> 
        <td width="333" align="left" valign="top">
            <table width="333">
                <tr><td width="150" align="left" valign="top"><B>Well</B></td>                 <td width="20" valign="top">:</td>    <td align="left" valign="top" >'.$getInfoNcr->ncr_well.'</td></tr> 
		  </table></td> 
        <td width="333" align="left" valign="top">
            <table width="333">
                <tr><td width="150" align="left" valign="top"><B>NCR No</B></td>               <td width="20" valign="top">:</td>    <td align="left" valign="top" >'.$getInfoNcr->ncrID.'</td></tr>
		    </table></td>           
       </tr>
    </table>
    <table width="100%" border="" align="left" cellpadding="0" cellspacing="0" style="font-family:arial;table-layout:fixed;" >
    	<tr>
		<td width="333" align="left" valign="top">
		  <table width="333">
                <tr><td width="150" align="left" valign="top"><B>Location</B></td>            <td width="20" valign="top">:</td>    <td align="left" valign="top" >'.$getInfo->location.'</td></tr>
		   </table></td> 
        <td width="333" align="left" valign="top">
            <table width="333">
               	<tr><td width="150" align="left" valign="top"><B>Department</B></td>           <td width="20" valign="top">:</td>    <td align="left" valign="top" >'.$getInfo->business.'</td></tr>   
		  </table></td> 
        <td width="333" align="left" valign="top">
            <table width="333">
                <tr><td width="150" align="left" valign="top"><B>NCR Case</B></td>             <td width="20" valign="top">:</td> 
                <td align="left" valign="middle" class="imgleft"><img src="'.$Minor.'"/></td><td width="50" align="left" valign="top" >Minor</td> 
                <td align="left" valign="middle" class="imgleft"><img src="'.$Major.'"/></td><td width="50" align="left" valign="top" >Major</td></tr>      
		    </table></td>            
       </tr>
       
    </table>
   	<table width="100%" border="" align="left" cellpadding="0" cellspacing="0" style="font-family:arial;table-layout:fixed;" >
       <tr>
       <td width="333" align="left" valign="top">
            <table width="333">
                <tr><td width="150" align="left" valign="top"><B>Purchase Order No</B></td>   <td width="20" valign="top">:</td>    <td align="left" valign="top" >'.$getInfoNcr->ncr_purchaseOrder.'</td></tr>    
		    </table></td> 
       <td width="333" align="left" valign="top">
            <table width="333">
                 <tr><td width="150" align="left" valign="top"><B>Vender / Supplier</B></td>  <td width="20" valign="top">:</td>    <td align="left" valign="top" >'.$getInfoNcr->ncr_vender.'</td></tr> 
		    </table></td> 
       <td width="333" align="left" valign="top">
            <table width="333">
                	<tr><td width="150" align="left" valign="top"><B>Customer Complaint<B/></td> <td width="20" valign="top" align="left">:</td>
                    <td align="left" valign="top" class="imgleft"><img src="'.$No.'"/></td><td width="50" align="left" valign="top" >No</td>
                    <td align="left" valign="top" class="imgleft"><img src="'.$Yes.'"/></td><td width="50" align="left" valign="top" >Yes</td></tr> 
		    </table></td>  
       </tr>
	</table>
    <table width="100%" border="" align="center" style="font-family:arial;border-collapse: collapse;" >
         <tr>
         <td width="333" align="left" valign="middle">
            <table width="333">
                <tr><td width="150" align="left" valign="top" ><B>Compliance</B></td>   <td width="20" valign="top">:</td>    <td align="left" valign="top" >'.$getInfoNcr->imsprocess.' '.$getInfoNcr->compliance.'</td></tr>
            </table></td>
            <td width="333" align="left" valign="top">
            <table width="333">
                 <tr><td width="150" align="left" valign="top"><B>Lost Time</B></td>  <td width="20" valign="top">:</td>    <td align="left" valign="top" >'.$getInfoNcr->ncr_losttime.'</td></tr> 
		    </table></td> 
            <td width="333" align="left" valign="top">
            <table width="333">
                 <tr><td width="150" align="left" valign="top"><B>Event Date</B></td>  <td width="20" valign="top">:</td>    <td align="left" valign="top" >'.$getInfo->basic_eventDate.'</td></tr> 
		    </table></td> 
        </tr>
	</table></div>';
$htmlinfo .='<br><div style="border-width: 2px; border-style: solid; border-color: #CC0C00;">
                <table width="100%" border="" align="left" cellpadding="0" cellspacing="0" style="font-family:arial;table-layout:fixed;" >
    	<tr>
		<td width="1000" align="left" valign="top">
		  <table width="1000">
                <tr><td width="150" align="left" valign="top"><B>Brief Descriptions</B></td>              <td width="20" valign="top">:</td>    <td align="left" valign="top" >'.$getInfoNcr->ncr_brief.'</td></tr>	
		   </table></td>          
       </tr>
    </table>
		  </div>';
          
$htmlinfo .='<br><div style="border-width: 2px; border-style: solid; border-color: #CC0C00;">
                <table width="100%" border="" align="left" cellpadding="0" cellspacing="0" style="font-family:arial;table-layout:fixed;" >
    	<tr>
		<td width="1000" align="left" valign="top">
		  <table width="1000">
                <tr><td width="150" align="left" valign="top"><B>Process</B></td>              <td width="20" valign="top">:</td>    <td align="left" valign="top" >'.$getInfoNcr->ncr_process.'</td></tr>	
		   </table></td>          
       </tr>
    </table>
		  </div>';
$htmldesc ='<br><div style="font-family:arial;background-color:#cccccc;vertical-align:"middle";	padding:0pt; border: 0px solid #555555;left:5;" height="20">
             	<span style="font-family:arial;vertical-align:text-middle;"><B>&nbsp;&nbsp;DESCRIPTIONS</B></span>
		  </div><div style="border-width: 2px; border-style: solid; border-color: #CC0C00;">';
$htmldesc .='<table width="100%" border="0" align="left" cellpadding="0" cellspacing="0" style="font-family:arial;table-layout:fixed;" >
         <tr>
         <td width="1000" align="left" valign="top">
            <table width="1000">
                <tr><td width="150" align="left" valign="top" ><B>Related Equipment</B></td>  <td width="20" valign="top">:</td>  <td align="left" valign="top" >'.$getInfoNcr->ncr_equipment.'</td></tr>
                <tr><td width="150" align="left" valign="top" ><B>Crews</B></td>             <td width="20" valign="top">:</td>  <td align="left" valign="top" >'.$getInfoNcr->ncr_crews.'</td></tr>
                <tr><td width="150" align="left" valign="top" ><B>Details</B></td>          <td width="20" valign="top">:</td>  <td align="left" valign="top" >'.$getInfo->basic_description.'</td></tr>
                <tr><td width="150" align="left" valign="top" ><B>Decision Making</B></td> <td width="20" valign="top">:</td> <td align="left" valign="top" >'.$getInfoNcr->deposition.'</td></tr>
            </table></td>         
        </tr>
     </table>';  
$htmldesc .='<table width="100%" border="" align="left" cellpadding="0" cellspacing="0" style="font-family:arial;table-layout:fixed;" >
    	<tr>
		<td width="333" align="left" valign="top">
		  <table width="333">
                <tr><td width="150" align="left" valign="top"><B>Decided by</B></td>   <td width="20" valign="top">:</td>    <td align="left" valign="top" >'.$getInfoNcr->ncr_approvedName.'</td></tr>
		   </table></td> 
    	<td width="333" align="left" valign="top">
		  <table width="333">
                <tr><td width="150" align="left" valign="top"><B>Approved by</B></td>   <td width="20" valign="top">:</td>    <td align="left" valign="top" >_________________</td></tr> 
		  </table></td> 
       <td width="333" align="left" valign="top">
        <table width="333">
             <tr><td width="100" align="right" valign="top"><B>Date</B> : '.$getInfoNcr->ncr_approvedDate.'</td>
	    </table></td>            
       </tr>
	</table></div>';
    
    
if($getInfo->basic_image1 !== NULL){   
$htmlevident ='<br><div style="font-family:arial;background-color:#cccccc;vertical-align:"middle";	padding:0pt; border: 0px solid #555555;left:5;" height="20">
             	<span style="font-family:arial;vertical-align:text-middle;"><B>&nbsp;&nbsp;EVIDENT</B></span>
		  </div><div style="border-width: 2px; border-style: solid; border-color: #CC0C00;">
		<br><table width="100%" border="0" align="left"  valign="top" cellpadding="0" cellspacing="0" style="font-family:arial;table-layout: fixed; 
     border-width: 1px;border-spacing: 1px;border-style: none;border-color: #cccccc;border-collapse: collapse;background-color: white;">
<tr>
    <td width="240" align="center" valign="middle" rowspan="2" valign="bottom" border="1" class="imgleft"><img src="'.$imgsrc1.'" height="200" /></td>
    <td width="240" align="center" valign="middle" rowspan="2" valign="bottom" border="1" class="imgleft"><img src="'.$imgsrc2.'" height="200" /></td>
    <td width="240" align="center" valign="middle" rowspan="2" valign="bottom" border="1" class="imgleft"><img src="'.$imgsrc3.'" height="200" /></td>
    <td width="240" align="center" valign="middle" rowspan="2" valign="bottom" border="1" class="imgleft"><img src="'.$imgsrc4.'" height="200" /></td>
</tr>
</table>';
}
$htmlevident .='<table width="100%" border="0" align="left"  valign="top" cellpadding="0" cellspacing="0" style="font-family:arial;table-layout: fixed;
     border-width: 1px;border-spacing: 1px;border-style: none;border-color: #cccccc;border-collapse: collapse;background-color: white;">
        <tr>
            <td width="240" align="center" valign="top"><B>'.$getInfo->basic_7.'</td>
            <td width="240" align="center" valign="top"><B>'.$getInfo->basic_8.'</td>
            <td width="240" align="center" valign="top"><B>'.$getInfo->basic_9.'</td>
            <td width="240" align="center" valign="top"><B>'.$getInfo->basic_10.'</B></td>
        </tr>';
$htmlevident .='</table>';
$htmlevident .='<table width="100%" border="0" align="left"  valign="top" cellpadding="0" cellspacing="0" style="font-family:arial;table-layout: fixed;
     border-width: 1px;border-spacing: 1px;border-style: none;border-color: #cccccc;border-collapse: collapse;background-color: white;">
        <tr>
            <td width="240" align="left" valign="top">'.$getInfoNcr->ncr_1.'</td>
            <td width="240" align="left" valign="top">'.$getInfoNcr->ncr_2.'</td>
            <td width="240" align="left" valign="top">'.$getInfoNcr->ncr_3.'</td>
            <td width="240" align="left" valign="top">'.$getInfoNcr->ncr_4.'</td>
        </tr></table></div>';
        
        
$htmlroot ='<br><div style="font-family:arial;background-color:#cccccc;vertical-align:"middle";	padding:0pt; border: 0px solid #555555;left:5;" height="20">
             	<span style="font-family:arial;vertical-align:text-middle;"><B>&nbsp;&nbsp;TROUBLESHOOTING ROOT CAUSE & CORRECTIVE ACTION</B></span>
		  </div><div style="border-width: 2px; border-style: solid; border-color: #CC0C00;">';
$htmlroot .='<table width="100%" border="0" align="left" cellpadding="0" cellspacing="0" style="font-family:arial;table-layout:fixed;" >
         <tr>
         <td width="1000" align="left" valign="top">
            <table width="1000">
                <tr><td align="left" valign="top" >(Action must include cause, analysis, corrective action taken and action to prevent reoccurrence)</td></tr>
                 <tr><td align="left" valign="top" ><B>Troubleshooting </B>:</td></tr>
                <tr><td align="left" valign="top" >'.$getInfoNcr->ncr_troubleshooting.'</td></tr>
                <tr><td align="left" valign="top" ><B>Root Cause </B>:</td></tr>
                <tr><td align="left" valign="top" >'.$getInfoNcr->ncr_rootCause.'</td></tr>
                <tr><td align="left" valign="top" ><B>Action Items </B>:</td></tr>
            </table></td>
        </tr>
</table>';

$htmlimme ='<table width="98%" align="center" border="1" style="font-family:arial;border-collapse: collapse;">
    <tr>
        <td align="center" valign="middle"><B>No.<B></td>
        <td align="center" valign="middle"><B>Responsible<B></td>
        <td align="center" valign="middle"><B>Details<B></td>
        <td align="center" valign="middle"><B>Expected Closing<B></td>
        <td align="center" valign="middle"><B>Status<B></td>
    </tr>';  
foreach ($getImme as $value) {
$htmlimme .='
	<tr>
		<td width="5%" align="center" valign="top">'.$value->imeItem.'</td>
		<td width="20%" align="center" valign="top">'.$value->ime_responsible.'</td>
        <td width="50%" align="left" valign="top" style="padding-left: 10px;">'.$value->ime_actionItem.'</td>
        <td width="15%" align="center" valign="top">'.$value->ime_expected.'</td>
        <td width="8%" align="center" valign="top" style="padding-right: 10px;">'.$value->ime_status.'</td>
	</tr>';
}
$htmlimme .='</table>';
$htmlimme .='<br><table width="100%" border="" align="left" cellpadding="0" cellspacing="0" style="font-family:arial;table-layout:fixed;" >
    	<tr>
		<td width="503" align="left" valign="top">
      		<table width="503">
              	 <tr><td width="150" align="left" valign="top"><B>Reported by</B></td>     <td width="20" valign="top">:</td> <td align="left" valign="top" >'.$getInfo->Ename.' - '.$getInfo->emp_jobfunction.'</td></tr>
            </table>
            <td width="163" align="left" valign="top">
            <table width="163">
                <tr><td width="163" align="left" valign="top">____________________</td>
            </table>
        <td width="333" align="right" valign="top">
            <table width="333">
                <tr><td width="333" align="right" valign="top"><B>Date</B> : '.$getInfo->basic_eventDate.'</td>
            </table></td>           
       </tr>
	</table></div>';


$htmlprop ='<br><div style="font-family:arial;background-color:#cccccc;vertical-align:"middle";	padding:0pt; border: 0px solid #555555;left:5;" height="20">
             	<span style="font-family:arial;vertical-align:text-middle;">
                     <table width="100%" width="100%" border="" align="left" cellpadding="0" cellspacing="0" style="font-family:arial;table-layout:fixed;" >
                        <td width="1000" align="left" valign="top">
                            <tr>
                                 <td width="800" align="left" valign="top"><B>  PROPOSED ACTION (If rejected give reason for rejection and alternate action required)</B></td>
                                 <td width="100"align="right" valign="middle" class="imgleft"><img src="'.$Accepted.'" /></td><td width="50" align="left" valign="top" >Accepted</td>
                                 <td width="100"align="right" valign="middle" class="imgleft"><img src="'.$Rejected.'" /></td><td width="50" align="left" valign="top" >Rejected</td>
                            </tr></td>
                     </table>
                </span>
		  </div><div style="border-width: 2px; border-style: solid; border-color: #CC0C00;">';
$htmlprop .='<table width="100%" border="0" align="left" cellpadding="0" cellspacing="0" style="font-family:arial;table-layout:fixed;" >
         <tr>
         <td width="1000" align="left" valign="top">
            <table width="1000">
                <tr><td width="150" align="left" valign="top" ><B>Details</B></td>  <td width="20" valign="top">:</td>  <td align="left" valign="top" >'.$getInfoNcr->ncr_proposedDesc.'</td></tr>
            </table></td>
        </tr>
        </table>';     
$htmlprop .='<br><table width="100%" border="" align="left" cellpadding="0" cellspacing="0" style="font-family:arial;table-layout:fixed;" >
    	<tr>
		<td width="666" align="left" valign="top">
            <table width="666">
                 <tr><td width="300" align="left" valign="top"><B>Signed by</B></td>  <td width="20" valign="top">:</td>  <td align="left" valign="top" >'.$getInfoNcr->ncr_proposedName.' - '.$getInfoNcr->ncr_proposedPosition.'</td></tr>
              	 <tr><td width="300" align="left" valign="top"><B>Closed by Division Manager</B></td>   <td width="20" valign="top">:</td>  <td align="left" valign="top" >'.$getInfoNcr->ncr_divisionName.'</td></tr>
                 <tr><td width="300" align="left" valign="top"><B>Closed by HSE & Q Manager</B></td>    <td width="20" valign="top">:</td>  <td align="left" valign="top" >'.$getInfoNcr->ncr_hseqName.'</td></tr>
            </table>
        <td width="333" align="left" valign="top">
            <table width="333">
                <tr><td width="333" align="right" valign="top"><B>Date</B> : '.$getInfoNcr->ncr_proposedDate.'</td>
                <tr><td width="333" align="right" valign="top"><B>Date</B> : _________</td> 
                <tr><td width="333" align="right" valign="top"><B>Date</B> : _________</td> 
		  </table></td>         
       </tr>
	</table></div>';
 
$html = $htmlinfo.$htmldesc.$htmlevident.$htmlroot.$htmlimme.$htmlprop;
        $mpdf->AddPage();
        $mpdf->WriteHTML($html);
        $name = $getInfoNcr->ncrID.'.pdf';
        $content = $mpdf->Output('', 'S');
		
		$this->mail->CharSet = "utf-8";
		$this->mail->IsSMTP();
		$this->mail->SMTPDebug = 0;
		$this->mail->SMTPAuth = true;
		$this->mail->SMTPSecure = "tls";
		$this->mail->Host = "smtp.gmail.com"; // SMTP server
		$this->mail->Port = 587; 
		$this->mail->Username = $this->email; // account SMTP
		$this->mail->Password = $this->pass; //  account SMTP
		//From:
		$this->mail->SetFrom($this->email, "NCR Report");
		//TO:
//        $this->mail->AddAddress($emailTo, $emailName);
//        $this->mail->AddCC("hseq.thailand@vause.co.th", "HSEQ");
//        $this->mail->AddCC($ccTo, $ccName);
        /** Test by*/
		$this->mail->AddAddress("patcharin@infomediacomm.com", "Patcharin");
        
		//ReplayTo:
		$this->mail->AddReplyTo($this->email, " ");
		//Subject:
		if(!empty($subject)){
		 	$sub = $subject;	
		}  else  {
			$sub = 'by '.$ccName;
		}
		$this->mail->Subject = $sub;
		//Attachment:
		// $attach_file = "./".$strFileName;
		// $this->mail->AddAttachment($attach_file);
		//Display HTML Y/N
		$this->mail->IsHTML(true);
		
		if(!empty($msg)){
			$message = $msg;			
		} else {
		  
           $message1  = 'Dear '.$getInfo->super_name.'<br />';
            $message2  = '<br/><table width="100%" border="0" align="left" cellpadding="0" cellspacing="0" style="font-family:arial;table-layout:fixed;" >
    	                   <tr>
		                      <td width="100%" align="left" valign="top">
		                          <table width="100%">
                                    <tr><td width="165" align="left" valign="top"><B>REPORTED BY</B></td>            <td width="20" valign="top">:</td>    <td align="left" valign="top" >'.$getInfo->Ename.'</td></tr>
                                    <tr><td width="165" align="left" valign="top"><B>EDITTED BY</B></td>            <td width="20" valign="top">:</td>    <td align="left" valign="top" >'.$ccName.'</td></tr>
                                    <tr><td width="165" align="left" valign="top"><B>NCR ID</B></td>            <td width="20" valign="top">:</td>    <td align="left" valign="top" >'.$getInfoNcr->ncrID.'</td></tr>
		                      </table></td>           
                            </tr>
                        </table>';
            $message3 = '<br/><table width="100%" border="0" align="left" cellpadding="0" cellspacing="0" style="font-family:arial;table-layout:fixed;" >
    	                   <tr>
		                      <td width="100%" align="left" valign="top">
		                          <table width="100%">
                                    <tr><td width="165" align="left" valign="top"><B>OBSERVATION</B></td>            <td width="20" valign="top">:</td>    <td align="left" valign="top" >'.$getInfo->basic_description.'</td></tr>
		                      </table></td>           
                            </tr>
                        </table>';
             $message4 = '<br/><table width="100%" border="0" align="left" cellpadding="0" cellspacing="0" style="font-family:arial;table-layout:fixed;" >
    	                   <tr>
		                      <td width="100%" align="left" valign="top">
		                          <table width="100%">
                                    <tr><td width="165" align="left" valign="top"><B>ACTION ITEM</B></td>            <td width="20" valign="top">:</td>  <td align="left" valign="top" ></td></tr>
		                      </table></td>           
                            </tr>
                        </table>';

            $message5 ='<br/><table width="98%" align="center" border="1" style="font-family:arial;border-collapse: collapse;">
                <tr>
                    <td align="center" valign="middle"><B>No.<B></td>
                    <td align="center" valign="middle"><B>Responsible<B></td>
                    <td align="center" valign="middle"><B>Details<B></td>
                    <td align="center" valign="middle"><B>Expected Closing<B></td>
                    <td align="center" valign="middle"><B>Status<B></td>
                </tr>';  
            foreach ($getImme as $value) {
            $message5 .='
            	<tr>
            		<td width="5%" align="center" valign="top">'.$value->imeItem.'</td>
            		<td width="20%" align="center" valign="top">'.$value->ime_responsible.'</td>
                    <td width="50%" align="left" valign="top" style="padding-left: 10px;">'.$value->ime_actionItem.'</td>
                    <td width="15%" align="center" valign="top">'.$value->ime_expected.'</td>
                    <td width="8%" align="center" valign="top" style="padding-right: 10px;">'.$value->ime_status.'</td>
            	</tr>';
            }
            $message5 .='</table>';
            
            $message6 = '<br/><table width="100%" border="0" align="left" cellpadding="0" cellspacing="0" style="font-family:arial;table-layout:fixed;" >
    	                   <tr>
		                      <td width="100%" align="left" valign="top">
		                          <table width="100%">
                                    <tr><td width="165" align="left" valign="top"><B>VISIT NCR REPORT LINK</B></td>            <td width="20" valign="top">:</td>   <td><a href="http://vause.dyndns-server.com:8888/online_report/pdquser/index.html">Click Here</a></td></tr>
		                      </table></td>           
                            </tr>
                        </table>';
                        
             $message7 = '<br /><br />Best Regards,<br />'.$ccName.'<br />'.$getInfo->emp_jobfunction;
            //	$message = 'You Have A New PDQ Report From '.$ccName.'<br />PDQ ID : '.$pdqID.'<br />Observation : '.$getInfo->basic_description.'<br />Please Check -> http://vause.dyndns-server.com:8888/online_report/pdquser/index.html<br />';
		}
		//Body Message:
		$this->mail->Body = $message1.$message2.$message3.$message4.$message5.$message6.$message7;
        $encoding = "base64";
        $type = "application/octet-stream";
     
        $this->mail->AddStringAttachment($content,$name);
        //$mpdf->Output($name,'D');
		//Sent.....
		if(!$this->mail->Send())
		{
			return 'Error';
		}
		else
		{
			return 'Message has been sent';
		}
		
	}
	
	public function  __destruct(){
		$this->mail = null;
	}
	
	
	
	
	public function test($format=null) {
			$rs = $this->SentMail('thongchai@servit.co.th','test','testagain');
			echo $rs;
	}
}