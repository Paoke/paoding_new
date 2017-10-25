<?php

namespace Mobile\Controller;
use Think\Controller;

header("Content-Type: text/html;charset=utf-8");

class RegisterController extends Controller
{

    public function register(){

        $this->display('Template/5u/mobile/Register/register.html');

    }

}