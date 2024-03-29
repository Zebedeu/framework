<?php

namespace Ballybran\Exception;

/**
 * Class HttpException
 * Adapted from Laravel Framework in order to use HTTP Exceptions
 *
 * @package Knut7\Exception
 */
class HttpException extends \RuntimeException
{
    /**
     * @var int
     */
    private $statusCode;

    /**
     * @var array
     */
    private $headers;

    /**
     * @var array
     */
    protected $errorMessages = [
        400 => ['title' => 'Bad Request', 'message' => 'Sorry, your request is invalid.'],
        401 => ['title' => 'Unauthorized', 'message' => 'Sorry, you are not authorized to access this page.'],
        403 => ['title' => 'Forbidden', 'message' => 'Sorry, you are forbidden from accessing this page.'],
        404 => ['title' => 'Page Not Found', 'message' => 'Sorry, the page you are looking for could not be found.'],
        405 => ['title' => 'Method Not Allowed', 'message' => 'Sorry, your request method is not allowed.'],
        419 => ['title' => 'Page Expired', 'message' => 'Sorry, your session has expired. Please refresh and try again.'],
        429 => ['title' => 'Too Many Requests', 'message' => 'Sorry, you are making too many requests to our servers.'],
        500 => ['title' => 'Service Error', 'message' => 'Whoops, something went wrong on our servers.'],
        503 => ['title' => 'Service Unavailable', 'message' => 'Sorry, we are doing some maintenance. Please check back soon.'],
    ];

    /**
     * HttpException constructor.
     *
     * @param int $statusCode
     * @param string|array|null $messageText
     * @param \Exception|null $previous
     * @param array $headers
     * @param int|null $code
     */
    public function __construct(
        int $statusCode,
        $messageText = null,
        \Exception $previous = null,
        array $headers = [],
        ?int $code = 0
    ) {
        $this->statusCode = $statusCode;
        $this->headers = $headers;

        http_response_code($statusCode);

        if (!app()->isProduction()) {
            $message = is_array($messageText) ? implode(' - ', $messageText) : $messageText;
            return parent::__construct($message, $code, $previous);
        }

        $title = null;
        if (is_array($messageText)) {
            $title = $messageText['title'] ?? null;
            $messageText = $messageText['message'] ?? null;
        }

        $message = $messageText ?? null;
        if (in_array($statusCode, array_keys($this->errorMessages))) {
            $title = $title === null 
                    ? $this->errorMessages[$statusCode]['title']
                    : $title;
            $message = $message === null 
                    ? $this->errorMessages[$statusCode]['message']
                    : $message;
        }

        $title = $title ?? 'System Error';
        $message = $message ?? 'Whoops, something went wrong on the system.';

        if (request()->headers->get('content-type') === 'application/json') {
            echo response()->json([
                'success' => false,
                'error' => $message,
            ], $statusCode);
            return false;
        }

        return require __DIR__ . '/views/index.php';
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function setHeaders(array $headers): void
    {
        $this->headers = $headers;
    }
}