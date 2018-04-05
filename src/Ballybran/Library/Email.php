<?php
/**
 * Created by PhpStorm.
 * User: macbookpro
 * Date: 18/01/18
 * Time: 16:32
 */

namespace Ballybran\Library;


use Ballybran\Database\RegistryDatabase;
use PHPMailer\PHPMailer\PHPMailer;

class Email
{

    private $charset;
    private $lang;
    private $debug;
    private $host;
    private $auth;
    private $username;
    private $password;
    private $secure;
    private $port;
    private $from;
    private $fromName;
    private $html;
    private $message1;
    private $message2;
    private $message3;
    private $email;
    private $nome;
    private $assunto;
    private $message;
    private $to;
    private $addr;

    /**
     * @return mixed
     */
    public function getAddr()
    {
        return $this->addr;
    }

    /**
     * @param mixed $addr
     */
    public function setAddr($addr)
    {
        $this->addr = $addr;
    }

    /**
     * @return mixed
     */
    public function getTo()
    {
        return $this->to;
    }

    /**
     * @param mixed $to
     */
    public function setTo($to)
    {
        $this->to = $to;
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param mixed $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * @param mixed $nome
     */
    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    /**
     * @return mixed
     */
    public function getAssunto()
    {
        return $this->assunto;
    }

    /**
     * @param mixed $assunto
     */
    public function setAssunto($assunto)
    {
        $this->assunto = $assunto;
    }

    /**
     * @return mixed
     */
    public function getCharset()
    {
        return $this->charset;
    }

    /**
     * @param mixed $charset
     */
    public function setCharset($charset)
    {
        $this->charset = $charset;
    }

    /**
     * @return mixed
     */
    public function getLang()
    {
        return $this->lang;
    }

    /**
     * @param mixed $lang
     */
    public function setLang($lang)
    {
        $this->lang = $lang;
    }

    /**
     * @return mixed
     */
    public function getDebug()
    {
        return $this->debug;
    }

    /**
     * @param mixed $debug
     */
    public function setDebug($debug)
    {
        $this->debug = $debug;
    }

    /**
     * @return mixed
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * @param mixed $host
     */
    public function setHost($host)
    {
        $this->host = $host;
    }

    /**
     * @return mixed
     */
    public function getAuth()
    {
        return $this->auth;
    }

    /**
     * @param mixed $auth
     */
    public function setAuth($auth)
    {
        $this->auth = $auth;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getSecure()
    {
        return $this->secure;
    }

    /**
     * @param mixed $secure
     */
    public function setSecure($secure)
    {
        $this->secure = $secure;
    }

    /**
     * @return mixed
     */
    public function getPort()
    {
        return $this->port;
    }

    /**
     * @param mixed $port
     */
    public function setPort($port)
    {
        $this->port = $port;
    }

    /**
     * @return mixed
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * @param mixed $from
     */
    public function setFrom($from)
    {
        $this->from = $from;
    }

    /**
     * @return mixed
     */
    public function getFromName()
    {
        return $this->fromName;
    }

    /**
     * @param mixed $fromName
     */
    public function setFromName($fromName)
    {
        $this->fromName = $fromName;
    }

    /**
     * @return mixed
     */
    public function getHtml()
    {
        return $this->html;
    }

    /**
     * @param mixed $html
     */
    public function setHtml($html)
    {
        $this->html = $html;
    }

    /**
     * @return mixed
     */
    public function getMessage1()
    {
        return $this->message1;
    }

    /**
     * @param mixed $message1
     */
    public function setMessage1($message1)
    {
        $this->message1 = $message1;
    }

    /**
     * @return mixed
     */
    public function getMessage2()
    {
        return $this->message2;
    }

    /**
     * @param mixed $message2
     */
    public function setMessage2($message2)
    {
        $this->message2 = $message2;
    }

    /**
     * @return mixed
     */
    public function getMessage3()
    {
        return $this->message3;
    }

    /**
     * @param mixed $message3
     */
    public function setMessage3($message3)
    {
        $this->message3 = $message3;
    }


    public function __construct( $email , array $paramConfigMailer)
    {
        $this->mail = $email;

        $params =  $paramConfigMailer;

        $this->setLang($params['Lang']);
        $this->setPort($params['Port']);
        $this->setSecure($params['Secure']);
        $this->setPassword($params['Password']);
        $this->setUsername($params['Username']);
        $this->setAuth($params['Auth']);
        $this->setHost($params['Host']);
        $this->setDebug($params['Debug']);
        $this->setCharset($params['Charset']);
        $this->setMessage1($params['Message1']);
        $this->setMessage2($params['Message2']);
        $this->setMessage3($params['Message3']);
        $this->setHtml($params['Html']);
    }

    public function send()
    {

        $this->mail->CharSet = $this->getCharset();
        $this->mail->setLanguage($this->getLang());
        $this->mail->SMTPDebug = $this->getDebug();
        $this->mail->isSMTP();
        $this->mail->Host = $this->getHost();
        $this->mail->SMTPAuth = $this->getAuth();
        $this->mail->Username = $this->getUsername();
        $this->mail->Password = $this->getPassword();
        $this->mail->SMTPSecure = $this->getSecure();
        $this->mail->Port = $this->getPort();
        $this->mail->From = $this->getUsername();
        $this->mail->FromName = $this->getNome();

        $this->mail->addAddress($this->getAddr(), $this->getNome());
        $this->mail->isHTML($this->getHtml());


    }

    public function body()
    {

        if ($this->mail->addReplyTo($this->getTo(), $this->getNome())) {
            //Definir assunto do e-mail
            $this->mail->Subject = $this->getAssunto();
            //Definir versÃ£o HTML do e-mail
            $this->mail->Body = "<br><br>" . $this->getMessage() . " </p><p>Mensagem enviada atravavés do seu site -" . URL." </p>";
            //Definir versÃ£o alternativa do e-mail apenas em plain text
            $this->mail->AltBody = "
                 E-mail: {$this->getEmail()}
                Nome: {$this->getNome()}
                Mensagem: {$this->getMessage()}";


            //Enviar a mensagem e verificar se ocorreram erros
            if (!$this->mail->send()) {
                //O motivo pelo qual um envio falha Ã© mostrado em $this->mail->ErrorInfo
                //no entanto nÃ£o deverÃ¡ mostrar estes erros ao utilizador, pelo que deverÃ¡ apenas activar em situaÃ§Ãµes de debug
                $msg = $this->getMessage1();
            } else {
                $msg = $this->getMessage2();
            }
        } else {
            $msg = $this->getMessage3();
        }
    }
}