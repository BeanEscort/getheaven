<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class MailerController extends Controller
{
	$dados = ['nome','email','mensagem','message'];

	protected $rules = [
        'name' => 'required|min:6',
        'email' => 'required|email:filter',
        'mensagem' => 'required'
    ];

    protected $messages = [
        'name.required' => 'O campo Nome é obrigatório!!',
        'name.min' => 'O campo Nome deve ter no mínimo 6 caracteres!!',
        'email.required' => 'O E-mail é obrigatório!!',
        'email.email' => 'Digite um e-mail válido!!',
        'mensagem.required' => 'Digite sua mensagem.'
    ];

    public function email() {
        return view("contact-form");
    }

    // ========== [ Compose Email ] ================
    public function composeEmail(Request $request) {
	$this->validate();
dd($request);
        $nome = $request->nome;
        $email = $request->email;
        $mensagem = 'Olá Marcos. <p><strong>'.$nome. '</strong></p>'.' ('.$email
        .') '.'<p>Enviou a seguinte mensagem:</p><p></p>'

        .'<p><pre>'.$request->mensagem.'</pre></p>';

        require base_path("vendor/autoload.php");

        $mail = new PHPMailer(true);     // Passing `true` enables exceptions

        try {
            $mail->setLanguage('pt_br', '/optional/path/to/language/directory/');
            // Email server settings
            $mail->SMTPDebug = 0;
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';             //  smtp host
            $mail->SMTPAuth = true;
            $mail->Username = 'mr.beanescort@gmail.com';   //  sender username
            $mail->Password = '65564422';       // sender password
            $mail->SMTPSecure = 'tsl';                  // encryption - ssl/tls
            $mail->Port = 587;                          // port - 587/465

            $mail->CharSet = "utf-8";

            $mail->setFrom($email,'Administrador' );
            $mail->addAddress('marcos_prog@yahoo.com.br', 'Marcos');
            //$mail->addCC('mr.beanescort@gmail.com');

            $mail->isHTML(true);                // Set email content format to HTML

            $mail->Subject = 'Contato do Site';
            $mail->Body    = $mensagem;

            // $mail->AltBody = plain text version of email body;

            if( !$mail->send() ) {
                return back()->with("failed", "E-mail não enviado.")->withErrors($mail->ErrorInfo);
            }

            else {
                return back()->with("success", "E-mail enviado com sucesso.");
            }

        } catch (Exception $e) {
             return back()->with('error','Ocorreu um erro ao enviar sua mensagem.');
        }
    }
}
