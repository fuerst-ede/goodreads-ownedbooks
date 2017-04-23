<?php
/**
 * Created by PhpStorm.
 * User: jenswalter
 * Date: 06.02.17
 * Time: 15:33
 */

namespace framework;


class mailer {
  
  /**
   * @return \PHPMailer
   */
  static public function getMailer() {
    
    include_once (CLASS_DIR . 'phpmailer/PHPMailerAutoload.php');
    $mail = new \PHPMailer;
  
    if (USE_MAIL) {
      $mail->isSMTP();                                      // Set mailer to use SMTP
      $mail->Host = 'smtp.1und1.de';  // Specify main and backup SMTP servers
      $mail->SMTPAuth = true;                               // Enable SMTP authentication
      $mail->Username = 'mailer@anwendungsserver.info';                 // SMTP username
      $mail->Password = 'simplemail';                           // SMTP password
      $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
      $mail->Port = 587;                                    // TCP port to connect to
    }
    $mail->CharSet = 'UTF-8';
    $mail->XMailer = ' ';
  
    $mail->setFrom('booking@gocruise.com', 'GoCruise');
  
    $mail->isHTML(true);                                  // Set email format to HTML
    
    return $mail;
  
  }
  
}