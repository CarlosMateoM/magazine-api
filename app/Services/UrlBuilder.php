<?php

namespace App\Services;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UrlBuilder
{

    public function __construct()
    {

    }

    public function build(string $urlBase, array $params = [], bool $withSignature = false, bool $withExpires = false, $expirationTime = 60): string
    {

        $queryParams = [];

        foreach ($params as $key => $value) {
            if(str_contains($key , '&hash') && !str_contains($key, '&hash&')){

                [$nameParam,] = explode('&hash', $key); // obtengo solo el nombre del parametro
                $valueHashed = $this->applyHash('sha1', $value);
                $queryParams[$nameParam] = $valueHashed;

            }elseif (str_contains($key , '&hash') && str_contains($key, '&hash&')){

                [$nameParam, $hashType] = explode('&hash&', $key);
                $valueHashed = $this->applyHash($hashType, $value);

                $queryParams[$nameParam] = $valueHashed;
            }else{
                $queryParams[$key] = $value;
            }
        }

        if($withSignature){
            $queryParams['signature'] = hash_hmac('sha256', http_build_query($queryParams), config('app.key'));
        }

        if($withExpires){
            $queryParams['expires'] = now()->addMinutes($expirationTime)->getTimestamp();
        }

        if(!empty($queryParams)){
            return $urlBase.'?'.http_build_query($queryParams);
        }

        return $urlBase;
    }


    private function applyHash(string $hashType, string $hashValue): string
    {

        return match (strtolower($hashType)) {
            'md5' => md5($hashValue),
            'sha1' => sha1($hashValue),
            'sha256' => hash('sha256', $hashValue),
            'sha384' => hash('sha384', $hashValue),
            'sha512' => hash('sha512', $hashValue),
            'bcrypt' => Hash::make($hashValue),
            default => $hashValue,
        };

    }
}
