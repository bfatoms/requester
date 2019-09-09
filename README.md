# Installation
```
composer require bfatoms/requester
```

# Publish Config
```
php artisan vendor:publish bfatoms/requester
```

# Usage
This package is heavily patterned to the laravel http test methods..
```
use BfAtoms\Requester\Requester;

public function index(Requester $request)
{
    // returns json
    return $request->json('GET','http://url.test',[], [
        'Authorization' => 'Bearer asdasdas.dadsasdasd.asdasdasdasd'
    ]);

    return $request->json('POST','http://url.test',[], [
        'Authorization' => 'Bearer asdasdas.dadsasdasd.asdasdasdasd'
    ]);
    
    return $request->json('PUT','http://url.test',[], [
        'Authorization' => 'Bearer asdasdas.dadsasdasd.asdasdasdasd'
    ]);
    
    return $request->json('DELETE','http://url.test',[], [
        'Authorization' => 'Bearer asdasdas.dadsasdasd.asdasdasdasd'
    ]);
}

public function post(Requester $request)
{
    return $request->post('http://url.test',[], [
        'Authorization' => 'Bearer asdasdas.dadsasdasd.asdasdasdasd'
    ]);
}

public function put(Requester $request)
{
    return $request->put('http://url.test',[], [
        'Authorization' => 'Bearer asdasdas.dadsasdasd.asdasdasdasd'
    ]);
}

public function delete(Requester $request)
{
    return $request->delete('http://url.test',[], [
        'Authorization' => 'Bearer asdasdas.dadsasdasd.asdasdasdasd'
    ]);
}

public function get(Requester $request)
{
    return $request->get('http://url.test',[], [
        'Authorization' => 'Bearer asdasdas.dadsasdasd.asdasdasdasd'
    ]);
}
```