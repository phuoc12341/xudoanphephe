<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function test()
    {
        return view('admin');
    }

    public function alo(Request $request)
    {
        if (preg_match('~[0-9]+~', $request->message)) {
            $numberMessages = explode(" ", $request->message);

            $convert = array('A','B','C','D','E','F','G','H','I','J','K', 'L','M','N','O','P','Q','R','S','T','U','V','W','X ','Y','Z');

            $messages = [];
            foreach ($numberMessages as $key => $value) {
                if (is_numeric($value)) {
                    $value--;
                    $messages[] = $convert[$value];
                }
            }
            
            $messages = (implode('', $messages));
        } else {
            $messages = strtoupper($request->message);
        }
        
        $messages = str_split($messages);
        $alphas = range('A', 'Z');

        $changeTableArr = range('A', 'Z');

        $result = [];
        foreach ($alphas as $alpha) {
            array_push($changeTableArr, array_shift($changeTableArr));
            $newChangeTable = array_combine($changeTableArr, $alphas);

            $test = [];
            foreach ($messages as $key => $value) {
                if (isset($newChangeTable[$value])) {
                    $test[] = $newChangeTable[$value];
                } else {
                    $test[] = $value;
                }
            }

            $test = implode('', $test);
            $result[] = $test; 
        }

        return view('alo', ['messages' => $result]);
    }
}
