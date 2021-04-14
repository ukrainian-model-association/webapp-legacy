<?

class email
{
    private $options = [];

    public function __construct($receiver = null, $subject = null, $body = null)
    {
        $this->setReceiver($receiver);
        $this->setSubject($subject);
        $this->setBody($body);
    }

    public function setReceiver($email)
    {
        $this->setOption('receiver', $email);
    }

    public function setOption($name, $value)
    {
        $this->options[$name] = $value;
    }

    public function setSubject($subject)
    {
        $this->setOption('subject', $subject);
    }

    public function setBody($body)
    {
        $this->setOption('body', $body);
    }

    public function isHTML()#torwald
    {
        $this->setOption('isHTML', true);
    }

    public function setReplyTo($reply_email)#andimov
    {
        $this->setOption('replyto', $reply_email);
    }

    public function send($test = false, $path = 'mails')
    {
        if (!$this->options['sender']) {
            $this->setSender(conf::get('default_email'), conf::get('project_name'));
        }

        if (conf::get('debug_emails')) {
            $this->send_debug($test, $path);
        }

        if (!$test) {
            require_once dirname(__FILE__) . '/mailer/class.phpmailer.php';

            $mail = new PHPMailer();
            $mail->IsSendmail();
            $mail->CharSet  = 'utf-8';
            $mail->Sendmail = '/usr/sbin/ssmtp -t';
            $mail->From     = $this->options['sender'];
            // $mail->Sender     = $this->options['sender'];
            $mail->FromName = $this->options['sender_name'];
            $mail->Subject  = $this->options['subject'];
            $mail->Body     = $this->options['body'];
            $mail->AddReplyTo('info@models.org.ua');
            if ($this->options['replyto'])#andimov
            {
                $mail->AddReplyTo($this->options['replyto']);
            }
            if ($this->options['isHTML'])#torwald
            {
                $mail->isHTML(true);
            }#torwald
            $mail->AddAddress($this->options['receiver']);

            $mail->Send();
        }
        //}
    }

    public function setSender($email, $name = null)
    {
        $this->setOption('sender', $email);
        $this->setOption('sender_name', $name);
    }

    public function send_debug($testpath = false, $path = 'mails')
    {
        $mainpath = conf::get('project_root') . '/data/debug/' . $path . '/' . date('Y');
        if (!is_dir($mainpath)) {
            mkdir($mainpath);
        }
        $mainpath = $mainpath . '/' . date('m');
        if (!is_dir($mainpath)) {
            mkdir($mainpath);
        }
        $mainpath = $mainpath . '/' . date('d') . '/';
        if (!is_dir($mainpath)) {
            mkdir($mainpath);
        }

        if (!$testpath) {
            $path = $mainpath . date('H_i_s') . '_' . microtime() . '.mail';
        } else {
            $path = $mainpath . '/test/' . date('H_i_s') . '_' . microtime() . '.mail';
        }
        $data =
            "Subject: {$this->options['subject']}\n" .
            "Receiver: {$this->options['receiver']}\n" .
            "From: {$this->options['sender']}\n\n" .
            "{$this->options['body']}\n";

        file_put_contents($path, $data);
    }
}
