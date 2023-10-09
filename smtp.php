<?php

use app\index\process\email\send\Send;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

class SmtpEmail
{

    /**
     * @var array
     */
    private $smtp_config;

    public function __construct(
        $email_smtp_host,
        $email_smtp_username,
        $email_smtp_password,
        $email_smtp_secure,
        $email_smtp_port,
        $debug = false
    ) {
        $this->smtp_config = [
            "email_smtp_host" => $email_smtp_host,
            "email_smtp_username" => $email_smtp_username,
            "email_smtp_password" => $email_smtp_password,
            "email_smtp_secure" => $email_smtp_secure,
            "email_smtp_port" => $email_smtp_port,
            "debug" => $debug,
        ];
    }

    public function send($email_send_sender_name, $email_send_sender, $email_send_recipient, $email_send_title, $email_send_content, $char_set = "UTF-8")
    {
        $mail = new PHPMailer(true);  // Passing `true` enables exceptions

        try {
            //服务器配置
            $mail->CharSet = $char_set;                     //设定邮件编码
            if ($this->smtp_config["debug"]) {
                $mail->SMTPDebug = true;                        // 调试模式输出

            }
            $mail->isSMTP();                             // 使用SMTP
            $mail->Host = $this->smtp_config["email_smtp_host"];                // SMTP服务器
            $mail->SMTPAuth = true;                      // 允许 SMTP 认证
            $mail->Username = $this->smtp_config["email_smtp_username"];                // SMTP 用户名  即邮箱的用户名
            $mail->Password = $this->smtp_config['email_smtp_password'];             // SMTP 密码  部分邮箱是授权码(例如163邮箱)
            $mail->SMTPSecure = $this->smtp_config['email_smtp_secure'];                    // 允许 TLS 或者ssl协议
            $mail->Port = $this->smtp_config['email_smtp_port'];                            // 服务器端口 25 或者465 具体要看邮箱服务器支持

            $mail->setFrom($this->smtp_config['email_smtp_username'], $email_send_sender_name);  //发件人
            $mail->addAddress($email_send_recipient);  // 收件人
            $mail->addReplyTo($email_send_sender, $email_send_sender_name); //回复的时候回复给哪个邮箱 建议和发件人一致

            $mail->isHTML(true);                                  // 是否以HTML文档格式发送  发送后客户端可直接显示对应HTML内容
            $mail->Subject = $email_send_title;
            $mail->Body = $email_send_content;
            $mail->AltBody = '';
            $mail->send();
            return ["error" => 0, "message" =>"success"];
        } catch (Exception $e) {
            return ["error" => 2, "message" => $e->getMessage()];;
        }
    }
}



$data = array(
    'email_smtp_host' => '', // SMTP服务器
    'email_smtp_username' => '', // SMTP 用户名  即邮箱的用户名
    'email_smtp_password' => '', // SMTP 密码  部分邮箱是授权码(例如163邮箱)
    'email_smtp_secure' => 'tls', // 允许 TLS 或者ssl协议
    'email_smtp_port' => '465', // 服务器端口 25 或者465 具体要看邮箱服务器支持
    'email_send_sender_name' => '', ///发件人名 (这里是域名)
    'email_send_recipient' => '', // 收件人邮箱地址
    'email_send_sender' => '', //回复的时候回复给哪个邮箱 建议和发件人一致
    'email_send_title' => '',
    'email_send_content' => ''
);
foreach ($data as $key => $val) {
    if (empty($_REQUEST[$key])) {
        echo json_encode(["error" => 1, "message" => "Invalid request $key"]);
        return false;
    }
    $data[$key] = $_REQUEST[$key];
}

$smtp_email = new SmtpEmail($data['email_smtp_host'], $data['email_smtp_username'], $data['email_smtp_password'], $data['email_smtp_secure'], $data['email_smtp_port']);
$res=$smtp_email->send($data['email_send_sender_name'],$data['email_send_sender'],$data['email_send_recipient'],$data['email_send_title'],$data['email_send_content']);
echo json_encode($res);
