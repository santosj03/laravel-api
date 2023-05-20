<?php

namespace Modules\User\Exceptions;

use App\Base\BaseException;
use App\Services\ContentMapping;
use Modules\Configuration\Services\ConfigurationService;

/**
 * Class InvalidArgumentException
 * @package App\Exceptions
 */
class LoginException extends BaseException
{
    protected $code;
    protected $error;

    public function __construct($code)
    {
        $this->code = $code;
        $this->error = ConfigurationService::mapping($this->code);
    }

    public function message()
    {
        return $this->error['message'];
    }
    /**
     * @inheritDoc
     */
    public function statusCode()
    {
        return $this->error['status'];
    }

    /**
     * @inheritDoc
     */
    public function errorCode()
    {
        return $this->error['code'];
    }
}
