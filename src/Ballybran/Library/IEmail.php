<?php
/**
 * Created by PhpStorm.
 * User: macbookpro
 * Date: 18/01/18
 * Time: 17:01
 */

namespace Ballybran\Library;
/**
 * Interface MailerInterface
 * @package JetFire\Mailer
 */


interface IEmail
{
    /**
     * @param $config
     */
    public function __construct($obj , array $paramConfigMailer);

    /**
     * @param null $to
     * @param null $from
     * @param null $subject
     * @param null $content
     * @param null $file
     * @return mixed
     */
    public function send($to = null , $from = null , $subject = null , $content = null , $file = null);

    /**
     * @param $subject
     * @return mixed
     */
    public function subject($subject);

    /**
     * @return mixed
     */
    public function from();

    /**
     * @return mixed
     */
    public function to();

    /**
     * @return mixed
     */
    public function addTo();

    /**
     * @return mixed
     */
    public function cc();

    /**
     * @return mixed
     */
    public function addCc();

    /**
     * @return mixed
     */
    public function bcc();

    /**
     * @return mixed
     */
    public function addBcc();

    /**
     * @param $content
     * @return mixed
     */
    public function content($content);

    /**
     * @param $html
     * @return mixed
     */
    public function html($html);

    /**
     * @param $file
     * @param null $name
     * @return mixed
     */
    public function file($file , $name = null);

    /**
     * @return mixed
     */
    public function getMail();


    /**
     * @return mixed
     */
    public function getCharset();

    /**
     * @return mixed
     */
    public function getLang();

    /**
     * @return mixed
     */
    public function getDebug();

    /**
     * @return mixed
     */
    public function getHost();

    /**
     * @return mixed
     */
    public function getAuth();

    /**
     * @return mixed
     */
    public function getUsername();

    /**
     * @return mixed
     */
    public function getPassword();

    /**
     * @return mixed
     */
    public function getSecure();

    /**
     * @return mixed
     */
    public function getPort();

    /**
     * @return mixed
     */
    public function getFrom();

    /**
     * @return mixed
     */
    public function getFromName();

    /**
     * @return mixed
     */
    public function getHtml();

    /**
     * @return mixed
     */
    public function getEmail();

    /**
     * @return mixed
     */
    public function getAssunto();

    /**
     * @return mixed
     */
    public function getMessage();

    /**
     * @return mixed
     */
    public function getTo();

    /**
     * @return mixed
     */
    public function getAddr();


    /**
     * @return mixed
     */
}