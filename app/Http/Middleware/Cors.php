<?php

namespace App\Http\Middleware;

use Closure;

class Cors {
    public function handle($request, Closure $next)
    {
      // $headers = [
      //       'Access-Control-Allow-Origin'      => '*',
      //       // CORS doesn't accept Access-Control-Allow-Origin = * for security reasons
      //       //'Access-Control-Allow-Origin'    => '*',
      //       'Access-Control-Allow-Methods'     => 'GET, POST, PUT, DELETE, OPTIONS',
      //       //'Access-Control-Allow-Methods'   => 'POST, GET, OPTIONS, PUT, DELETE',
      //       'Access-Control-Allow-Credentials' => 'true',
      //       'Access-Control-Max-Age'           => '86400',
      //       'Access-Control-Allow-Headers'     => 'Content-Type, Authorization, X-Requested-With',
      //       //'Access-Control-Allow-Headers'   => 'X-Custom-Header, X-Requested-With, Content-Type, Origin, Authorization, Accept, Client-security-token',
      //   ];
      //   if($request->isMethod('OPTIONS'))
      //     return Response::json('{"method":"OPTIONS"}', 200, $headers);
      //   $response = $next($request);
      //   foreach($headers as $key => $value)
      //       $response->header($key, $value);
      //
      //   return $response;
        // return $next($request)
        //     ->header('Access-Control-Allow-Origin', '*')
        //     ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
        //     ->header('Access-Control-Allow-Headers', 'X-Requested-With,accept, Content-Type,Authorization')
        //     ->header('Access-Control-Allow-Credentials','true');
        return $next($request)
    }
}
