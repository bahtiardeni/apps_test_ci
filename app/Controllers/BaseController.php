<?php

namespace App\Controllers;

use App\Models\GeneralModel;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Session;
use Psr\Log\LoggerInterface;
use CodeIgniter\Model;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var list<string>
     */
    protected $helpers = ['session', 'url'];

    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */
    protected $session;
    protected $general;
    protected $route_controller;
    protected $route_method;

    /**
     * @return void
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.

        // E.g.: $this->session = \Config\Services::session();

    }

    public function __construct()
    {
        $this->general              = new GeneralModel();
        $this->session              = \Config\Services::session();
        $this->session->start();

        $router                     = service('router');
        $this->route_controller     = $router->controllerName();
        $this->route_controller     = explode("\\", $this->route_controller);
        $this->route_controller     = $this->route_controller[(count($this->route_controller) - 1)];
        $this->route_method         = $router->methodName();
    }
}
