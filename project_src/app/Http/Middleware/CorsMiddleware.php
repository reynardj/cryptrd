<?php namespace App\Http\Middleware;
class CorsMiddleware {
    public function handle($request, \Closure $next)
    {
        //Intercepts OPTIONS requests
        if ($request->isMethod('OPTIONS')) {
            $response = response('', 200);
        } else {
            // Pass the request to the next middleware
            $response = $next($request);
        }

        $response->header('Access-Control-Allow-Methods', 'HEAD, GET, POST, PUT, OPTIONS, PATCH, DELETE');
        $response->header('Access-Control-Allow-Headers', $request->header('Access-Control-Request-Headers'));
        $response->header('Access-Control-Allow-Origin', '*');
        $response->header('Access-Control-Allow-Credentials', true);

        return $response;
    }
}
