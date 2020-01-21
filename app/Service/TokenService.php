<?php

namespace App\Service;

use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Signer\Key;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Parser;

class TokenService 
{
    public function generateToken(array $data) 
    {
        $time = time();
        $signer = new Sha256();
        $builder = new Builder();
        $builder//->issuedBy('http://127.0.0.1')
                //->permittedFor('http://127.0.0.1')
                //->identifiedBy('4f1g23a12aa')
                ->issuedAt($time) // Configures the time that the token was issue (iat claim)
                //->canOnlyBeUsedAfter($time + 2) // Configures the time that the token can be used (nbf claim)
                ->expiresAt($time + 3600); // Configures the expiration time of the token (exp claim)
                //->withHeader('foo', 'bar');

        foreach($data as $key => $value) {
            $builder->withClaim($key, $value);
        }
        
        $token = $builder->getToken($signer, new Key('testing'));

        return $token;
    }

    public function parseToken(string $token)
    {
        $parser = new Parser();

        $token = $parser->parse($token);

        $token->getHeaders();
        return $token->getClaims();
    }
} 