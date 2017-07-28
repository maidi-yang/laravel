<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/7/17
 * Time: 11:37
 */

namespace App\Mailer;

use Mail;
use Naux\Mail\SendCloudTemplate;

class Mailer
{
    public function senTo($template, $email, array $data)
    {
        $centent = new SendCloudTemplate($template, $data);

        Mail::raw($centent, function ($message) use ($email){
            $message->from('254884797@qq.com', 'Laravel');
            $message->to($email);
        });
    }
}