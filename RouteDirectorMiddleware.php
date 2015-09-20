<?php
/**
*   Route Director Middleware
*/
namespace VJS\Middleware;

class RouteDirectorMiddleware extends \Slim\Middleware
{

    protected $excludedRoutes;
    protected $includedRoutes;
    
    protected $afterCall = "callRoute";
    
    
    public function call(){
        if($this->skipMiddlewareForRoute()){
            $this->next->call();
        }else{
            if(is_callable([$this, $this->afterCall])){
                $this->callRoute();
            }else{
                throw new Exception("VJS\\Middleware\\RouteDirectorMiddleware\\call : " . $this->afterCall . " was not set");
            }
        }
    }
    
    /**
    *   callRoute
    *   You should override this method
    */
    public function callRoute(){
        
        //do the same stuff in here you would for call()
        //in the normal Slim\Middleware class
    
    }
    
    /**
    *   Skip Route
    *   @return Boolean - if middleware should be skipped for route
    */
    protected function skipMiddlewareForRoute(){
        
        //Test if excludedRoutes exists and is_array
        if(isset($this->excludedRoutes) && is_array($this->excludedRoutes)){
            return $this->isExcluded($this->excludedRoutes);
        }
        
        //Test if includedRoutes exists and is_array
        if(isset($this->includedRoutes) && is_array($this->includedRoutes)){
            return !$this->isExcluded($this->includedRoutes);
        }
        
        //if no routes are provided then we can assume
        //no routes should be skipped, so return false
        return false;
    }
    
    /**
    *   IsExcluded
    *   @param $pathsToTest - list of NAMED routes to test for exclusion
    *   @return Boolean - if path is excluded
    */
    protected function isExcluded($pathsToTest){
        $r = $this->app->router();
        $c = $this->app->request()->getPathInfo();
        
        foreach($pathsToTest as $name){
            try{
                //Get Path for the named url
                $path = $r->urlFor($name);
            }catch(\Exception $e){
                continue;
            }
            
            //Test if Current Path is excluded
            if(strtolower($c) === strtolower($path)){
                return true;
            }
        }
        
        return false;
    }
    

}
