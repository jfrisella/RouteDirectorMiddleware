#Route Director Middleware

This class gives the Slim\Middleware class the ability to include or exclude certain routes. 

Just extend the `RouteDirectorMiddleware` and override the `routeCall()` method.

The routes that are included/excluded MUST BE named routes.

You can exclude or include routes, but not both. It will test if there are any excluded routes first, 
and stop if it finds some. Then it tests for included routes.  

Here is an example of excluding some routes.

```php

class SomeMiddlewareName extends \VJS\Middleware\RouteDirectorMiddleware
{
	
	//Add some routes to exclude from the Middleware 
	protected $excludedRoutes = [
		"MyNamedRoute",
		"Dashboard"
	];

	
	public function routeCall(){
		//Do stuff normal middleware stuff here
		$app = \Slim::getInstance();

		...

		//Remember 'MyNamedRoute' and 'Dashboard' WILL NOT execute the middleware
	
	}

}

```


Here is an example of including routes.

```php

class SomeMiddlewareName extends \VJS\Middleware\RouteDirectorMiddleware
{
	
	//Add some routes to include for Middleware 
	protected $includedRoutes = [
		"MyNamedRoute",
		"Dashboard"
	];

	
	public function routeCall(){
		//Do stuff normal middleware stuff here
		$app = \Slim::getInstance();

		...

		//Remember 'MyNamedRoute' and 'Dashboard' WILL execute the middleware
	
	}

}

```
