<?php

namespace App\Routing;

use App\Routing\Attribute\Route;
use App\Utils\Filesystem;
use Psr\Container\ContainerInterface;
use ReflectionClass;
use ReflectionMethod;

class Router
{
  private array $routes = [];
  private ContainerInterface $container;
  private const CONTROLLERS_DIRECTORY = __DIR__ . '/../Controller';
  private const CONTROLLERS_NAMESPACE = "App\\Controller\\";

  public function __construct(ContainerInterface $container)
  {
    $this->container = $container;
  }

  /**
   * Adds a route into the router internal array
   *
   * @param string $name
   * @param string $url
   * @param string $httpMethod
   * @param string $controller Controller's class FQCN
   * @param string $method
   * @return void
   */
  public function addRoute(
    string $name,
    string $url,
    string $httpMethod,
    string $controller,
    string $method
  ) {
    $this->routes[] = [
      'name' => $name,
      'url' => $url,
      'http_method' => $httpMethod,
      'controller' => $controller,
      'method' => $method
    ];
  }

  public function getRoute(string $uri, string $httpMethod): ?array
  {
    foreach ($this->routes as $route) {
      if ($route['url'] === $uri && $route['http_method'] === $httpMethod) {
        return $route;
      }
    }

    return null;
  }

  /**
   * Executes router on specified URI and HTTP Method
   *
   * @param string $requestUri
   * @param string $requestMethod
   * @return void
   * @throws RouteNotFoundException if route is not found
   */
  public function execute(string $requestUri, string $requestMethod)
  {
    $route = $this->getRoute($requestUri, $requestMethod);

    if ($route === null) {
      throw new RouteNotFoundException($requestUri);
    }

    $controller = $route['controller'];
    $constructorParams = $this->getMethodParams($controller, '__construct');
    $controllerInstance = new $controller(...$constructorParams);

    $method = $route['method'];
    $params = $this->getMethodParams($controller, $method);

    call_user_func_array(
      [$controllerInstance, $method],
      $params
    );
  }

  /**
   * Resolve & build method's parameters
   *
   * @param string $controller Controller's FQCN
   * @param string $method
   * @return array Empty if controller doesn't have any parameter
   */
  private function getMethodParams(string $controller, string $method): array
  {
    $methodInfos = new ReflectionMethod($controller . '::' . $method);
    $methodParameters = $methodInfos->getParameters();
    $params = [];

    foreach ($methodParameters as $param) {
      $paramName = $param->getName();
      $paramType = $param->getType()->getName();

      if ($this->container->has($paramType)) {
        $params[$paramName] = $this->container->get($paramType);
      }
    }

    return $params;
  }

  public function registerRoutes(): void
  {
    $controllerClassNames = Filesystem::getClassNames(self::CONTROLLERS_DIRECTORY);

    foreach ($controllerClassNames as $class) {
      $fqcn = self::CONTROLLERS_NAMESPACE . $class;
      $reflection = new ReflectionClass($fqcn);

      if ($reflection->isAbstract()) {
        continue;
      }

      $methods = $reflection->getMethods(ReflectionMethod::IS_PUBLIC);

      foreach ($methods as $method) {
        if ($method->isConstructor()) {
          continue;
        }

        $attributes = $method->getAttributes(Route::class);

        foreach ($attributes as $attribute) {
          /** @var Route */
          $route = $attribute->newInstance();

          $this->addRoute(
            $route->getName(),
            $route->getPath(),
            $route->getHttpMethod(),
            $fqcn,
            $method->getName()
          );
        }
      }
    }
  }
}
