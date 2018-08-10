<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CryptoController extends Controller
{

    public function decrypt(Request $request){

        $decrypt_type = $request->type;
        $text  = $request->text;
        $preproessor = new Preprocessor();
        $bag = $preproessor->preprocess($text);

        $keys = array_keys($bag);

        $method = new DecryptMethod($decrypt_type);




        return $method->compute($keys, $bag);

    }


}


class Preprocessor {

    public function preprocess($text){

        $text = str_replace(".","",$text);
        $text = str_replace(",","",$text);
        $text = str_replace(";","",$text);
        $text = str_replace(":","",$text);
        $text = str_replace("'","",$text);
        $text = str_replace("*","",$text);
        $text = str_replace("ù","u",$text);
        $text = str_replace("à","a",$text);
        $text = str_replace("è","e",$text);
        $text = str_replace("é","e",$text);
        $text = str_replace("ì","i",$text);
        $text = str_replace("ò","o",$text);
        $text = str_replace("!","",$text);
        $text = str_replace("?","",$text);

        $text = strtolower($text);

        $exploded = explode(" ",$text);

        $bag = array();

        foreach ($exploded as $ex){
            if (array_key_exists($ex, $bag)){
                $bag[$ex] += 1;
            }else{
                $bag[$ex] = 1;
            }
        }

        unset($bag[""]);

        $keys = array_keys($bag);


        $character_bag = array();

        foreach ($keys as $k){

            $length = strlen($k);
            $i = 0;
            while ($i < $length){
                $c = $k[$i];
                if(array_key_exists($c, $character_bag)){
                    $character_bag[$c] += 1;
                }else{
                    $character_bag[$c] = 1;
                }

                $i++;
            }
        }

        return $character_bag;
    }


    public function decrypt(){}
}


class DecryptMethod{

    private $dictionary;

    function __construct($type){

        switch($type){
            case 1:
                $this->dictionary = array('a'=> 1, 'b'=> 2, 'c'=> 3, 'd'=> 4, 'e'=> 5, 'f'=> 6, 'g'=> 7, 'h'=> 8, 'i'=> 9, 'j'=> 10, 'k'=> 11, 'l'=> 12, 'm'=> 13, 'n'=> 14, 'o'=> 15, 'p'=> 16, 'q'=> 17, 'r'=> 18, 's'=> 19, 't'=> 20, 'u'=> 21, 'v'=> 22, 'w'=> 23, 'x'=> 24, 'y'=> 25, 'z'=> 26);
                break;
            case 2:
                $this->dictionary = array('a'=>5, 'b'=>3, 'c'=>3, 'd'=>4, 'e'=>23,'f'=>6,'g'=>6,'h'=>3,'i'=>14,'j'=>10,'k'=>11,'l'=>4,'m'=>20,'n'=>11,'o'=>14,'p'=>8,'q'=>4,'r'=>10,'s'=>7,'t'=>8,'u'=>13,'v'=>22,'w'=>23,'x'=>24,'y'=>5,'z'=>2);
                break;
            case 3:
                $this->dictionary = array('a'=>16, 'b'=>4, 'c'=>16, 'd'=>4, 'e'=>225,'f'=>9,'g'=>36,'h'=>9,'i'=>9,'j'=>10,'k'=>11,'l'=>49,'m'=>4,'n'=>4,'o'=>1,'p'=>4,'q'=>16,'r'=>25,'s'=>1,'t'=>9,'u'=>25,'v'=>1,'w'=>23,'x'=>24,'y'=>25,'z'=>4);
                break;
            case 4:
                $this->dictionary = array('a'=>25, 'b'=>9, 'c'=>9, 'd'=>4, 'e'=>529,'f'=>6,'g'=>36,'h'=>9,'i'=>196,'j'=>10,'k'=>11,'l'=>16,'m'=>400,'n'=>121,'o'=>196,'p'=>64,'q'=>16,'r'=>100,'s'=>49,'t'=>64,'u'=>169,'v'=>22,'w'=>23,'x'=>24,'y'=>25,'z'=>4);
                break;
        }

    }

    public function getDict(){
        return $this->dictionary;
    }

    public function compute($keys, $bag){
        $sum = 0;

        foreach ($keys as $k){
            $sum += $bag[$k] *$this->dictionary[$k];
        }

        return $sum;
    }

    public function getForm(){
        return view('crypto');
    }
}
