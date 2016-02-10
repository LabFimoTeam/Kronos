<?php

App::uses('BaseAuthenticate', 'Controller/Component/Auth');


class RestAuthenticate  extends BaseAuthenticate{

    public function authenticate(CakeRequest $request, CakeResponse $response)
    {
        $token = $request->header("apiKey");
        if(!$token)
        {
            throw new HttpHeaderException("No se pudo obtener la informacion del token");
        }
        else{
            
        }
    }

}