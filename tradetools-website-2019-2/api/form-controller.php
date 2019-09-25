<?php

require __DIR__ . '/form-sender.php';
require __DIR__ . '/hubspot-api.php';

// Settings
$debug = false;
date_default_timezone_set('America/Sao_Paulo');

// Email SMTP
$from_email = "info@mintlab.com.br";
$from_name = "Website Tradetools";
$to_email = array('portinho@tradetools.co', 'customersupport@tradetools.co');
$to_name = "Contato Tradetools Website";

$smtp_host = "email-ssl.com.br";
$smtp_user = "info@mintlab.com.br";
$smtp_pass = "DzGoDe517";
$smpt_port = "587";
$smtp_secure = 'tls';

// Hubspot
$portalId = "3891312";
$formId = "834c2929-b462-4b7c-ad49-5b8f62ff7167";
$name = 'Nome do Lead';
$email = 'Email do Lead';
$message = 'Mensagem do Lead';
$origin = 'TradeTools';


if ($debug) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}

$status_return = array();
$status_return['status'] = false;
$status_return['error'] = false;

if(     !isset($_POST['name'])
    ||  !isset($_POST['email'])
    ||  !isset($_POST['message'])
    ||  !isset($_POST['action'])
    )
{
        $status_return['status'] = false;
        $status_return['error']  = true;
}

if( !$status_return['error'] ){

    $form_sender = new Form_Sender($debug);

    // var_dump(post_to_hubspot($portalId, $formId, $name, $email, $message, $origin));

    $user_name      = strip_tags( trim( $_POST['name'] ));
    $user_email     = strip_tags( trim( $_POST['email'] ));
    $user_message   = strip_tags( trim( $_POST['message'] ));
    $user_company   = (isset($_POST['company']) && trim($_POST['company']) != '') ? strip_tags( trim( $_POST['company'])) : 'Não informada';
    $user_field     = (isset($_POST['field']) && trim($_POST['field']) != '') ? strip_tags( trim( $_POST['field'])) : 'Não informada';
    $user_action    = strip_tags( trim( $_POST['action'] ));
    $user_origin    = isset($_POST['origin']) ? strip_tags( trim( $_POST['origin'])) : 'Desconhecida';

    $filepath = false;
    $filename = false;

    $email_subject = "Mensagem do Website TradeTools de $user_name";

    $email_body  = "<strong>Mensagem website TradeTools</strong><BR>";
    $email_body .= "<BR><strong>Nome</strong>: $user_name";
    $email_body .= "<BR><strong>E-mail</strong>: $user_email";
    $email_body .= "<BR><strong>Empresa</strong>: $user_company";
    $email_body .= "<BR><strong>Área de Atuação</strong>: $user_field";
    $email_body .= "<BR><strong>Message</strong>: $user_message";

    $email_body .= "<BR><BR><strong>Hora do servidor</strong>: " . date("Y-m-d H:i:s");

    $ip = isset($_SERVER['HTTP_CLIENT_IP'])?$_SERVER['HTTP_CLIENT_IP']:isset($_SERVER['HTTP_X_FORWARDED_FOR'])?$_SERVER['HTTP_X_FORWARDED_FOR']:$_SERVER['REMOTE_ADDR'];
    $email_body .= "<BR><strong>IP</strong>: " . $ip;
    $email_body .= "<BR><strong>UserAgent</strong>: " . $_SERVER['HTTP_USER_AGENT'];
    $email_body .= "<BR><strong>Origem:</strong>: " . $user_origin;
    $email_body .= "<BR><strong>Action:</strong>: " . $user_action;

    $status_return['status'] = $form_sender->send( $to_email, $to_name, $filepath, $filename, $email_subject, $email_body);

}
// $status_return['status'] = false;

echo json_encode($status_return);

exit(0);
