<?php
/**
 * sf_progesco
 *
 * @author: emile.camara
 * @date  :   10/02/2020
 * @time  :   17:09
 */

namespace App\Manager\EventListener;


use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class ExceptionListener
 *
 * @package App\Manager\EventListener
 *
 */
class ExceptionListener {
    private $logger;
    
    public function __construct(LoggerInterface $logger) {
        $this->logger = $logger;
    }
    
    /**
     * @param ExceptionEvent $event
     */
    public function onKernelException(ExceptionEvent $event) {
        $exception = $event->getThrowable();
        $message = sprintf(
            'Error says: %s with code: %s',
            $exception->getMessage(),
            $exception->getCode()
        );
        $response = new Response();
        $response->setContent($message);
    
        // HttpExceptionInterface is a special type of exception that
        // holds status code and header details
        if ($exception instanceof HttpExceptionInterface
            || $exception instanceof HttpException
            || $exception instanceof NotFoundHttpException
            || $exception instanceof FileException
        ) {
            $response->setStatusCode($exception->getStatusCode());
            $response->headers->replace($exception->getHeaders());
        } else {
            $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        $this->log($exception);
        // sends the modified response object to the event
        $event->setResponse($response);
    }
    
    /**
     * @param $exception
     */
    public function log( $exception) {
        if ($exception instanceof HttpExceptionInterface
            || $exception instanceof HttpException
            || $exception instanceof NotFoundHttpException
            || $exception instanceof FileException
        ) {
            $log = [
                'code' => $exception->getStatusCode(),
                'message' => $exception->getMessage(),
                'called' => [
                    'file' => $exception->getTrace()[0]['file'],
                    'line' => $exception->getTrace()[0]['line'],
                ],
                'occurred' => [
                    'file' => $exception->getFile(),
                    'line' => $exception->getLine(),
                ],
            ];
        } else {
            $log = [
                'code' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'called' => [],
                'occurred' => [],
            ];
        }
    
        if ($exception->getPrevious() instanceof Exception) {
            $log += [
                'previous' => [
                    'message' => $exception->getPrevious()->getMessage(),
                    'exception' => get_class($exception->getPrevious()),
                    'file' => $exception->getPrevious()->getFile(),
                    'line' => $exception->getPrevious()->getLine(),
                ],
            ];
        }
    
        $this->logger->error(json_encode($log));
        
    }
}